<template>
    <div>
        <div class="d-flex align-items-center">
            <v-btn @click="backToStockSymbolList">
                <v-icon style="font-size: 15px">fas fa-angle-left fa-pull-left</v-icon>
                <span>Back</span>
            </v-btn>
            <h2 class="mb-0 ml-2">{{ stockSymbol.name }}</h2>
        </div>
        <div class="my-10">
            <h5 v-if="stockSymbol.daily_prices.length > 1" class="mb-0 font-weight-bold">
                Please, select two or more values to build the chart:
            </h5>
            <h5 v-else class="mb-0 font-weight-bold">
                You need to have at least to daily prices to build the chart.
            </h5>
        </div>
        <div class="d-flex align-items-center flex-wrap mb-5">
            <div
                v-for="(dailyPrice, dailyPriceIndex) in stockSymbol.daily_prices"
                class="form-check card shadow p-1 mb-2 mr-2 col-2"
            >
                <input
                    v-model="stockSymbol.daily_prices[dailyPriceIndex].selected"
                    type="checkbox"
                    style="position:absolute; bottom: 9px; cursor:pointer;"
                    :id="`checkbox-${dailyPrice.id}`">
                <label
                    style="margin-left: 20px;"
                    class="form-check-label"
                    :for="`checkbox-${dailyPrice.id}`">
                    {{ dailyPrice.day | formatDate }} - ${{ dailyPrice.price }}
                </label>
            </div>
        </div>
        <StockSymbolDailyPricesChart v-if="values.length > 1" :values="values"/>
    </div>
</template>

<script>
import StockSymbolDailyPricesChart from "./StockSymbolDailyPricesChart";
export default {
    name: 'StockSymbolDailyPricesSelection',
    components: {StockSymbolDailyPricesChart},
    props: {
        value: Object
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
        selectedDailyPrices() {
            return this.stockSymbol.daily_prices.filter((dailyPrice) => dailyPrice.selected);
        },
        values() {
            return this.selectedDailyPrices.map((dailyPrice) => +dailyPrice.price);
        }
    },
    methods: {
        backToStockSymbolList() {
          this.$emit('back-to-list', {});
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

<style scoped lang="scss">
.form-check.card {
    &:hover {
        transform: scale(1.05);
        cursor: pointer;
    }

    & > label {
        cursor: pointer;
    }
}
h2, h5 {
    color: rgb(84, 65, 59);
}
</style>
