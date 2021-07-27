<template>
    <div>
        <v-btn class="mb-5" @click="addStockSymbol">
            <v-icon style="font-size: 11px">fas fa-plus fa-pull-left</v-icon>
            <span>Add Symbol</span>
        </v-btn>
        <v-row align="center" justify="center" class="mt-3" v-if="loading">
            <v-icon>fas fa-circle-notch fa-spin fa-lg</v-icon>
            <h5 class="ml-3 mb-0">Loading...</h5>
        </v-row>
        <div
            v-else
            class="card shadow py-3 px-5 d-flex flex-column mb-3"
            style="background-color:#FCC3B1;"
            v-for="(stockSymbol, stockSymbolIndex) in stockSymbols"
        >
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
            stockSymbols: [],
            loading: true,
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
        addStockSymbol() {
            if (this.stockSymbols.length > 0 ) {
                const lastItem = this.stockSymbols[this.stockSymbols.length -1];
                if (lastItem.id === 0) {
                    return;
                }
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
