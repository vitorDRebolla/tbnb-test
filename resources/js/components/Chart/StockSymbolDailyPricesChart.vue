<template>
    <div>
        <v-card
            class="mx-auto text-center"
            color="rgb(140 184 173)"
            dark
        >
            <v-card-text>
                <v-sheet color="rgb(68 156 134)">
                    <v-sparkline
                        :value="values"
                        color="rgba(194,255,241,1);"
                        height="100"
                        padding="20"
                        smooth
                    >
                        <template v-slot:label="item">
                            ${{ item.value }}
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
