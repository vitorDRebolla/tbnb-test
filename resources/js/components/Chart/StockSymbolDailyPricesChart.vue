<template>
    <div>
        <v-card
            class="mx-auto text-center"
            color="rgb(140 184 173)"
            dark
        >
            <v-card-text>
                <v-sheet
                    class="v-sheet--offset mx-auto"
                    color="rgb(68 156 134)">
                    <v-sparkline
                        :value="values"
                        color="rgba(194,255,241,1);"
                        padding="16"
                        line-width="0.5"
                    >
                        <template v-slot:label="item">
                            {{ item.value.replace('.', ',') }}
                        </template>
                    </v-sparkline>
                </v-sheet>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    name: 'StockSymbolDailyPricesChart',
    props: {
        values: Array,
    }
}
</script>

<style>
g text {
    font-size: 4px;
}
</style>
