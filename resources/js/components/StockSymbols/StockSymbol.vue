<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4
                v-if="!editMode"
                style="color: #54413b"
                class="font-weight-bold mb-0"
            >{{ stockSymbol.name }}</h4>
            <input
                v-if="editMode"
                v-model="stockSymbol.name"
                class="form-control col-2 text-uppercase edit-input"
                maxlength="6"
            />
            <ButtonActions
                :hasMode="stockSymbol.id === 0"
                @onCancel="onCancel"
                @onDelete="onDelete"
                @onSave="onSave"
                @onUpdate="setEditMode"
            />
        </div>
        <div
            v-for="(dailyPrice, dailyPriceIndex) in activeDailyPrices"
            class="card p-3 mb-2 daily-price-background"
        >
            <DailyPrice v-model="stockSymbol.daily_prices[dailyPriceIndex]" @onCancel="cancelDailyPrice"/>
        </div>
        <v-btn v-if="stockSymbol.id !== 0" class="mt-4" @click="addDailyPrice">
            <v-icon style="font-size: 11px">fas fa-plus fa-pull-left</v-icon>
            <span>Add Daily Price</span>
        </v-btn>
    </div>
</template>

<script>
import DailyPrice from "./Dailyprice";
import ButtonActions from "../Base/ButtonActions";

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
        activeDailyPrices() {
            return this.stockSymbol.daily_prices.filter((dailyPrice) => !dailyPrice.deleted);
        }
    },
    mounted() {
        this.originalName = this.stockSymbol.name;
        this.setEditMode(this.stockSymbol.id === 0);
    },
    data() {
        return {
            editMode: false,
            originalName: '',
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
                this.setEditMode(false);
            })
        },
        updateStockSymbol() {
            this.axios.put(`/api/stock-symbols/${this.stockSymbol.id}`, this.stockSymbol).then(({data}) => {
                this.originalName = data.name;
                this.setEditMode(false);
            });
        },
        onSave() {
            if(!this.validateStockSymbolName()) {
                return;
            }

            if (this.stockSymbol.id === 0) {
                this.saveNewStockSymbol();
                return;
            }
            this.stockSymbol.name = this.stockSymbol.name.toUpperCase();

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
            this.axios.delete(`/api/stock-symbols/${this.stockSymbol.id}`).then(() => {
                this.$emit('onDelete');
            })
        },
        addDailyPrice() {
            const lastItem = this.stockSymbol.daily_prices[this.stockSymbol.daily_prices.length - 1];
            if (lastItem.id === 0) {
                return;
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
    },
}
</script>

<style scoped>
.daily-price-background {
    background-color: #ffece6
}
</style>
