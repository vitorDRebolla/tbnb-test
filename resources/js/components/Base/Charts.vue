<template>
    <div>
        <v-row v-if="loading" align="center" class="mt-3" justify="center">
            <v-icon>fas fa-circle-notch fa-spin fa-lg</v-icon>
            <h5 class="ml-3 mb-0">Loading...</h5>
        </v-row>
        <div v-else>
            <div class="mb-5" v-if="selectedStockSymbol.id === undefined">
                <h5 class="mb-0 font-weight-bold">
                    Please, select one stock symbol to proceed
                </h5>
            </div>
            <div v-if="selectedStockSymbol.id === undefined" class="d-flex flex-wrap">
                <StockSymbolCard
                    v-for="stockSymbol in stockSymbols"
                    :key="`stock-symbol-card-${stockSymbol.id}`"
                    :stock-symbol="stockSymbol"
                    @setSelectedStockSymbol="setSelectedStockSymbol"
                />
            </div>
            <StockSymbolDailyPricesSelection
                v-if="selectedStockSymbol.id !== undefined"
                v-model="selectedStockSymbol"
                @back-to-list="setSelectedStockSymbol"
            />
        </div>
    </div>
</template>

<script>
import StockSymbolCard from "../Chart/StockSymbolCard";
import StockSymbolDailyPricesSelection from "../Chart/StockSymbolDailyPricesSelection";
export default {
    name: 'Charts',
    components: {StockSymbolDailyPricesSelection, StockSymbolCard},
    data() {
        return {
            stockSymbols: [],
            loading: true,
            selectedStockSymbol: {},
        };
    },
    mounted() {
        this.getStockSymbols();
    },
    methods: {
        getStockSymbols() {
            this.axios.get('/api/stock-symbols').then(({data}) => {
                this.stockSymbols = data;
            }).then(() => {
                this.loading = false;
            })
        },
        setSelectedStockSymbol(stockSymbol) {
            this.selectedStockSymbol = stockSymbol;
        }
    }
}
</script>

<style scoped>

</style>
