<template>
    <div>
        <v-row align="center" justify="center" class="mt-3" v-if="loading">
            <v-icon>fas fa-circle-notch fa-spin fa-lg</v-icon>
            <h5 class="ml-3 mb-0">Loading...</h5>
        </v-row>
        <div v-else>
            <v-btn class="mb-5" @click="addStockSymbol">
                <v-icon style="font-size: 11px">fas fa-plus fa-pull-left</v-icon>
                <span>Add Symbol</span>
            </v-btn>
            <div
                class="card shadow py-3 px-5 d-flex flex-column mb-3"
                style="background-color:#FCC3B1;"
                v-for="(stockSymbol, stockSymbolIndex) in stockSymbols"
                :key="`stock-symbol-${stockSymbol.id}`"
            >
                <StockSymbol @onCancel="onCancel" @onDelete="onDelete" v-model="stockSymbols[stockSymbolIndex]"/>
            </div>
        </div>
        <Errorhandler v-model="snackbar" :text="errorText"/>
    </div>
</template>

<script>
import StockSymbol from "../StockSymbols/StockSymbol";
import ButtonActions from "../Utility/ButtonActions";
import Errorhandler from "../Utility/ErrorHandler";

export default {
    name: 'List',
    components: {ButtonActions, StockSymbol, Errorhandler },
    data() {
        return {
            stockSymbols: [],
            loading: true,
            snackbar: false,
            errorText: '',
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
                    this.snackbar = true;
                    this.errorText = 'You need to save the last stock symbol to add another one';
                    return;
                }
            }

            this.stockSymbols.push({
                id: 0,
                name: '',
                daily_prices: [],
            });

            setTimeout(() => {
                window.scrollTo(0,document.body.scrollHeight);
            }, 0);
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
