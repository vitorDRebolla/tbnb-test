<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4
                v-if="!editMode"
                class="font-weight-bold mb-0"
                style="color: #54413b"
            >{{ stockSymbol.name }}</h4>
            <input
                v-if="editMode"
                v-model="stockSymbol.name"
                class="form-control col-2 text-uppercase edit-input"
                maxlength="6"
            />
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
        <div
            v-for="(dailyPrice, dailyPriceIndex) in stockSymbol.daily_prices"
            :key="`daily-price-${dailyPrice.id}`"
            class="card p-3 mb-2 daily-price-background"
        >
            <DailyPrice v-model="stockSymbol.daily_prices[dailyPriceIndex]" @onCancel="cancelDailyPrice" @onDelete="getDailyPrices"/>
        </div>
        <v-btn v-if="stockSymbol.id !== 0" class="mt-4" @click="addDailyPrice">
            <v-icon style="font-size: 11px">fas fa-plus fa-pull-left</v-icon>
            <span>Add Daily Price</span>
        </v-btn>
    </div>
</template>

<script>
import DailyPrice from "./Dailyprice";
import ButtonActions from "../Utility/ButtonActions";

export default {
    name: 'StockSymbol',
    components: {ButtonActions, DailyPrice},
    props: {
        value: Object,
    },
    computed: {
        stockSymbol: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit('input', value);
            }
        },
    },
    mounted() {
        this.originalName = this.stockSymbol.name;
        this.setEditMode(this.stockSymbol.id === 0);
    },
    data() {
        return {
            editMode: false,
            originalName: '',
            saving: false,
            deleting: false
        }
    },
    methods: {
        setEditMode(mode) {
            this.editMode = mode;
        },
        validateStockSymbolName() {
            const name = this.stockSymbol.name;
            return name.length <= 2 || name.length > 6;
        },
        saveNewStockSymbol() {
            this.axios.post('/api/stock-symbols', this.stockSymbol).then(({data}) => {
                this.stockSymbol.id = data.id;
            }).then(() => {
                this.setEditMode(false);
                this.saving = false;
            })
        },
        updateStockSymbol() {
            this.axios.put(`/api/stock-symbols/${this.stockSymbol.id}`, this.stockSymbol).then(({data}) => {
                this.originalName = data.name;
            }).then(() => {
                this.saving = false;
                this.setEditMode(false);
            });
        },
        onSave() {
            if (this.validateStockSymbolName()) {
                return;
            }

            this.saving = true;
            this.stockSymbol.name = this.stockSymbol.name.toUpperCase();

            if (this.stockSymbol.id === 0) {
                this.saveNewStockSymbol();
                return;
            }

            this.updateStockSymbol();
        },
        onCancel(value) {
            if (this.stockSymbol.id === 0) {
                this.$emit('onCancel');
            }
            this.stockSymbol.name = this.originalName;
            this.setEditMode(value);
        },
        onDelete() {
            this.deleting = true;
            this.axios.delete(`/api/stock-symbols/${this.stockSymbol.id}`).then(() => {
                this.$emit('onDelete');
            }).then(() => {
                this.deleting = false;
            })
        },
        addDailyPrice() {
            if (this.stockSymbol.daily_prices.length > 0) {
                const lastItem = this.stockSymbol.daily_prices[this.stockSymbol.daily_prices.length - 1];
                if (lastItem.id === 0) {
                    return;
                }
            }

            this.stockSymbol.daily_prices.push({
                id: 0,
                stock_symbol_id: this.stockSymbol.id,
                day: '',
                price: 0.00
            })
        },
        cancelDailyPrice() {
            this.stockSymbol.daily_prices.pop();
        },
        getDailyPrices() {
            this.axios.get(`/api/stock-symbols/${this.stockSymbol.id}/daily-prices`).then(({ data }) => {
                this.stockSymbol.daily_prices = data;
            })
        }
    },
}
</script>

<style scoped>
.daily-price-background {
    background-color: #ffece6
}
</style>
