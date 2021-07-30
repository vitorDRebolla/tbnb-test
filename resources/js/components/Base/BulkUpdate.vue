<template>
    <div>
        <v-row v-if="loading" align="center" class="mt-3" justify="center">
            <v-icon>fas fa-circle-notch fa-spin fa-lg</v-icon>
            <h5 class="ml-3 mb-0">Loading...</h5>
        </v-row>
        <div v-else>
            <div v-if="dailyPrices.length > 0">
                <div class="mb-5" >
                    <v-btn :disabled="saving" @click="saveChanges">
                        <span v-if="!saving">Save</span>
                        <v-icon v-if="saving">fas fa-circle-notch fa-spin fa-lg</v-icon>
                    </v-btn>
                </div>
                <div class="d-flex flex-wrap">
                    <DailyPriceCard
                        v-for="(dailyPrice, dailyPriceIndex) in dailyPrices"
                        v-model="dailyPrices[dailyPriceIndex]"
                        :saved="saved"
                        @changed="saved = false"
                    />
                </div>
            </div>
            <div v-else>
                <h5 class="font-weight-bold">
                    Please, register at least one daily price to bulk update.
                </h5>
            </div>
        </div>
    </div>
</template>

<script>
import DailyPriceCard from "../BulkUpdate/DailyPriceCard";

export default {
    name: 'BulkUpdate',
    components: {DailyPriceCard},
    data() {
        return {
            stockSymbols: [],
            loading: true,
            saving: false,
            saved: false,
        };
    },
    computed: {
        dailyPrices() {
            return this.stockSymbols.flatMap(
                (stockSymbol) =>
                    stockSymbol.daily_prices.map((dailyPrice) =>
                        ({
                            ...dailyPrice,
                            stock_symbol_name: stockSymbol.name,
                            changed: false,
                        })
                    )
            )
        },
        changedDailyPrices() {
            return this.dailyPrices.filter(dailyPrice => dailyPrice.changed);
        }
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
        saveChanges() {
            this.saving = true;
            this.axios.post('/api/stock-symbols-daily-price', this.changedDailyPrices).then(() => {
                this.saving = false;
            }).then(() => {
                this.saved = true;
            });
        },
    }
}
</script>
