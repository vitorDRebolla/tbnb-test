<template>
    <div>
        <div class="card py-3 px-5 d-flex flex-column" v-for="(stockSymbol, stockSymbolIndex) in stockSymbols">
            <StockSymbol v-model="stockSymbols[stockSymbolIndex]"/>
        </div>
    </div>
</template>

<script>
import StockSymbol from "./StockSymbols/StockSymbol";
export default {
    name: 'List',
    components: { StockSymbol },
    data() {
        return {
            stockSymbols: [
                {
                    id: 1,
                    name: 'ABC',
                    daily_prices: [
                        {
                            id: 1,
                            stock_symbol_id: 1,
                            day: '2021-07-25',
                            price: 56.97
                        },
                        {
                            id: 2,
                            stock_symbol_id: 1,
                            day: '2021-07-26',
                            price: 23.97
                        },
                        {
                            id: 3,
                            stock_symbol_id: 1,
                            day: '2021-07-27',
                            price: 65.63
                        },
                        {
                            id: 4,
                            stock_symbol_id: 1,
                            day: '2021-07-28',
                            price: 12.89
                        },
                    ]
                }
            ],
        };
    },
    mounted() {
        this.getStockSymbols();
    },
    methods: {
        getStockSymbols() {
            // axios.get('/stock-symbols').then(({data}) => {
            //     this.stockSymbols = data;
            // })
        }
    },
}
</script>

<style scoped>

</style>
