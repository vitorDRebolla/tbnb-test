<template>
  <div>
    Charts
  </div>
</template>

<script>
export default {
  name: 'Charts',
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
