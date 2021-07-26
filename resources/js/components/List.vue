<template>
    <div>
        <v-btn class="mb-5" @click="addStockSymbol">+ Create Symbol</v-btn>
        <div class="card shadow py-3 px-5 d-flex flex-column mb-3" v-for="(stockSymbol, stockSymbolIndex) in stockSymbols">
            <StockSymbol @onCancel="onCancel" @onDelete="onDelete" v-model="stockSymbols[stockSymbolIndex]"/>
        </div>
    </div>
</template>

<script>
import StockSymbol from "./StockSymbols/StockSymbol";
import ButtonActions from "./Base/ButtonActions";
export default {
    name: 'List',
    components: {ButtonActions, StockSymbol },
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
        },
        addStockSymbol() {
            const lastItem = this.stockSymbols[this.stockSymbols.length -1];
            if (lastItem.id === 0) {
                return;
            }

            this.stockSymbols.push({
                id: 0,
                name: '',
                daily_prices: [],
            });
        },
        onCancel() {
            this.stockSymbols.pop();
        },
        onDelete() {
            this.getStockSymbols();
        }
    },
}
</script>

<style scoped>

</style>
