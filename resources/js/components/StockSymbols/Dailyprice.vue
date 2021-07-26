<template>
    <div>
        <div class="d-flex justify-content-between align-items-center">
            <h5 v-if="!editMode" class="mb-0">{{ dailyPrice.day | formatDate }} - ${{ dailyPrice.price.toString().replace('.', ',') }}</h5>
            <div v-if="editMode" class="d-flex align-items-center">
                <h5 v-if="dailyPrice.id !== 0" class="mb-0">{{ dailyPrice.day | formatDate }}</h5>
                <input
                    v-if="dailyPrice.id === 0"
                    v-model="dailyPrice.day"
                    class="form-control col-6 edit-input"
                    type="DATE"
                />
                <h5 class="mb-0">&nbsp;- $</h5>
                <input
                    v-model="dailyPrice.price"
                    class="form-control col-5 edit-input"
                    type="number"
                />
            </div>
            <ButtonActions
                :hasMode="dailyPrice.id === 0"
                @onCancel="onCancel"
                @onDelete="onDelete"
                @onSave="onSave"
                @onUpdate="setEditMode"
            />
        </div>
    </div>
</template>

<script>
import ButtonActions from "../Base/ButtonActions";

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

            if (this.dailyPrice.id === 0) {
                this.saveNewDailyPrice();
            }

            this.updateDailyPrice();
        },
        onDelete() {
            this.axios.delete(
                `/api/stock-symbols/${this.dailyPrice.stock_symbol_id}/daily/${this.dailyPrice.day}/prices`
            ).then(() => {
                this.dailyPrice.deleted = true;
            });
        },
        validateDailyPrice() {
            let isValid = true;
            if (+this.dailyPrice.price === 0) {
                isValid = false;
            }

            return isValid;
        },
        saveNewDailyPrice() {
            this.axios.post(`/api/stock-symbols/${this.dailyPrice.stock_symbol_id}/daily-prices`, this.dailyPrice)
                .then(({data}) => {
                    this.dailyPrice.id = data.id;
                    this.setEditMode(false);
                })
        },
        updateDailyPrice() {
            this.axios.put(
                `/api/stock-symbols/${this.dailyPrice.stock_symbol_id}/daily-prices/${this.dailyPrice.id}`,
                this.dailyPrice
            ).then(({data}) => {
                this.originalPrice = data.price;
                this.setEditMode(false)
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
