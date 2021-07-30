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
                    class="form-control col-6 edit-input"
                    type="date"
                    :max="today"
                />
                <h5 class="mb-0">&nbsp;- $</h5>
                <input
                    v-model="dailyPrice.price"
                    class="form-control col-5 edit-input"
                    type="number"
                />
            </div>
            <ButtonActions
                :hasMode="editMode"
                :saving="saving"
                :deleting="deleting"
                @onCancel="onCancel"
                @onDelete="onDelete"
                @onSave="onSave"
                @onUpdate="setEditMode"
            />
        </div>
    </div>
</template>

<script>
import ButtonActions from "../Utility/ButtonActions";

export default {
    name: 'DailyPrice',
    components: {ButtonActions},
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
            const month = today.getMonth()+1;
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
            deleting: false
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
            }).then(() => {
                this.deleting = false;
            });
        },
        validateDailyPrice() {
            if (+this.dailyPrice.price === 0) {
                return  false;
            }
        },
        saveNewDailyPrice() {
            this.axios.post(`/api/stock-symbols/${this.dailyPrice.stock_symbol_id}/daily-prices`, this.dailyPrice)
                .then(({data}) => {
                    this.dailyPrice.id = data.id;
                }).then(() => {
                this.setEditMode(false);
                this.saving = false;
            })
        },
        updateDailyPrice() {
            this.axios.put(
                `/api/stock-symbols/${this.dailyPrice.stock_symbol_id}/daily-prices/${this.dailyPrice.id}`,
                this.dailyPrice
            ).then(({data}) => {
                this.originalPrice = data.price;
            }).then(() => {
                this.saving = false;
                this.setEditMode(false);
            })
        }
    },
    filters: {
        formatDate(value) {
            let date = new Date(value);
            return date.toLocaleDateString();
        }
    }
}
</script>

<style scoped>

</style>
