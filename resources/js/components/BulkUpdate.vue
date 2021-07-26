<template>
    <div>
        BulkUpdate
    </div>
</template>

<script>
export default {
    name: 'BulkUpdate',
    data() {
        return {
            stockSymbols: [],
        };
    },
    methods: {
        getStockSymbols() {
            this.axios.get('/api/stock-symbols').then(({data}) => {
                this.stockSymbols = data;
            }).then(() => {
                this.loading = false;
            })
        },
    }
}
</script>

<style scoped>

</style>
