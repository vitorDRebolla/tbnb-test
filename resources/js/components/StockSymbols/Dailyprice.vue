<template>
    <div>
        <div class="d-flex justify-content-between align-items-center">
            <h5 v-if="!editMode" class="mb-0">{{ dailyPrice.day | formatDate }} -
                ${{ dailyPrice.price.toString().replace('.', ',') }}</h5>
            <div v-if="editMode" class="d-flex align-items-center">
                <h5 v-if="dailyPrice.id !== 0" class="mb-0">{{ dailyPrice.day | formatDate }}</h5>
                <input
                    v-if="dailyPrice.id === 0"
                    v-model="dailyPrice.day"
                    :max="today"
                    class="form-control col-6 edit-input"
                    type="date"
                />
                <h5 class="mb-0">&nbsp;- $</h5>
                <input
                    v-model="dailyPrice.price"
                    class="form-control col-5 edit-input"
                    type="number"
                />
            </div>
            <ButtonActions
                :deleting="deleting"
                :hasMode="editMode"
                :saving="saving"
                @onCancel="onCancel"
                @onDelete="onDelete"
                @onSave="onSave"
                @onUpdate="setEditMode"
            />
        </div>
        <Errorhandler v-model="snackbar" :text="errorText"/>
    </div>
</template>

<script>
import ButtonActions from "../Utility/ButtonActions";
import Errorhandler from "../Utility/ErrorHandler";

export default {
    name: 'DailyPrice',
    components: {Errorhandler, ButtonActions},
    props: {
        value: Object,
    },
    computed: {
        dailyPrice: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit('input', value);
            }
        },
        today() {
            const today = new Date();
            const month = today.getMonth() + 1;
            const formattedMonth = month.toString().length === 1 ? `0${month}` : month;

            return `${today.getFullYear()}-${formattedMonth}-${today.getDate()}`
        }
    },
    mounted() {
        this.originalPrice = this.dailyPrice.price;
        this.setEditMode(this.dailyPrice.id === 0);
    },
    data() {
        return {
            editMode: false,
            originalPrice: 0,
            saving: false,
            deleting: false,
            errorText: '',
            snackbar: false,
        }
    },
    methods: {
        setEditMode(mode) {
            this.editMode = mode;
        },
        onCancel(value) {
            if (this.dailyPrice.id === 0) {
                this.$emit('onCancel');
            }

            this.dailyPrice.price = this.originalPrice;
            this.setEditMode(value);
        },
        onSave() {
            if (!this.validateDailyPrice) {
                this.snackbar = true;
                this.errorText = 'Invalid price.';
                return;
            }
            this.saving = true;

            if (this.dailyPrice.id === 0) {
                this.saveNewDailyPrice();
                return;
            }

            this.updateDailyPrice();
        },
        onDelete() {
            this.deleting = true;
            this.axios.delete(
                `/api/stock-symbols/${this.dailyPrice.stock_symbol_id}/daily/${this.dailyPrice.day}/prices`
            ).then(() => {
                this.$emit('onDelete');
                this.snackbar = true;
                this.errorText = 'Daily price deleted successfully!';
            }).then(() => {
                this.deleting = false;
            });
        },
        validateDailyPrice() {
            if (+this.dailyPrice.price === 0) {
                return false;
            }
        },
        saveNewDailyPrice() {
            this.axios.post(`/api/stock-symbols/${this.dailyPrice.stock_symbol_id}/daily-prices`, this.dailyPrice).then(({data}) => {
                this.dailyPrice.id = data.id;
                this.setEditMode(false);
                this.snackbar = true;
                this.errorText = 'Daily price saved successfully!';
            }).catch((error) => {
                this.snackbar = true;
                this.errorText = this.retrieveFirstError(error.response.data.errors)
            }).finally(() => {
                this.saving = false;
            })
        },
        updateDailyPrice() {
            this.axios.put(
                `/api/stock-symbols/${this.dailyPrice.stock_symbol_id}/daily-prices/${this.dailyPrice.id}`,
                this.dailyPrice
            ).then(({data}) => {
                this.originalPrice = data.price;
                this.setEditMode(false);
                this.snackbar = true;
                this.errorText = 'Daily price updated successfully!';
            }).catch((error) => {
                this.snackbar = true;
                this.errorText = this.retrieveFirstError(error.response.data.errors)
            }).finally(() => {
                this.saving = false;
            })
        },
        retrieveFirstError(errors) {
            return Object.values(errors)[0][0];
        }
    },
    filters: {
        formatDate(value) {
            const values = value.split('-');
            return `${values[1]}/${values[2]}/${values[0]}`;
        }
    }
}
</script>
