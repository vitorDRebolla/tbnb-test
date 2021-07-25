<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 v-if="!editMode" class="font-weight-bold mb-0">{{ stockSymbol.name }}</h4>
            <input class="form-control col-1" v-if="editMode" v-model="stockSymbol.name"/>
            <ButtonActions @onUpdate="setEditMode" @onCancel="setEditMode"/>
        </div>
        <div v-for="(dailyPrice, dailyPriceIndex) in stockSymbol.daily_prices" class="card p-3 mb-2">
            <DailyPrice v-model="stockSymbol.daily_prices[dailyPriceIndex]"/>
        </div>
    </div>
</template>

<script>
import DailyPrice from "./Dailyprice";
import ButtonActions from "../Base/ButtonActions";

export default {
    name: 'StockSymbol',
    components: { ButtonActions, DailyPrice },
    props: {
        value: Object,
    },
    computed: {
        stockSymbol: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit('input', value);
            }
        }
    },
    data() {
        return {
            editMode: false,
        }
    },
    methods: {
        setEditMode(mode) {
            this.editMode = mode;
        }
    },
}
</script>

<style scoped>

</style>
