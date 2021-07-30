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
                class="form-check card shadow p-1 mb-2 mr-2 col-md-2 col-sm-5"
            >
                <input
                    :id="`checkbox-${dailyPrice.id}`"
                    v-model="stockSymbol.daily_prices[dailyPriceIndex].selected"
                    style="position:absolute; bottom: 9px; cursor:pointer;"
                    type="checkbox">
                <label
                    :for="`checkbox-${dailyPrice.id}`"
                    class="form-check-label"
                    style="margin-left: 20px;">
                    {{ dailyPrice.day | formatDate }} - ${{ dailyPrice.price.replace('.', ',') }}
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
        },
    },
    mounted() {
        this.setLast30DaysDailyPrices();
    },
    methods: {
        backToStockSymbolList() {
            this.$emit('back-to-list', {});
        },
        setLast30DaysDailyPrices() {
            let date = new Date();
            date.setDate(date.getDate() - 30);
            date = this.createDateAsUTC(date);
            this.stockSymbol.daily_prices = this.stockSymbol.daily_prices.filter((dailyPrice) => {
                const dailyPriceDate = this.createDateAsUTC(new Date(dailyPrice.day))
                return new Date(dailyPrice.day) >= date;
            })
        },
        createDateAsUTC(date) {
            return new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0));
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

<style lang="scss" scoped>
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
    color: #30403C;
}
</style>
