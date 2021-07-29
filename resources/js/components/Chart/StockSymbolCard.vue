<template>
    <v-card class="col-md-2 col-sm-6 mr-2 mb-2 p-0" hover @click="setSelectedStockSymbol">
        <v-card-text class="text-center">
            <h4 class="text-dark mb-0">{{ stockSymbol.name }}</h4>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: 'StockSymbolCard',
    props: {
        stockSymbol: Object
    },
    data() {
        return {
            showDailyPrices: false,
        };
    },
    methods: {
        setSelectedStockSymbol() {
            this.$emit('setSelectedStockSymbol', this.stockSymbol);
        }
    }
}
</script>
