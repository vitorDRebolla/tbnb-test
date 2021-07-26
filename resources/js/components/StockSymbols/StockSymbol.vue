<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 v-if="!editMode" class="font-weight-bold mb-0">{{ stockSymbol.name }}</h4>
            <input class="form-control col-1 text-uppercase" maxlength="4" v-if="editMode" v-model="stockSymbol.name"/>
            <ButtonActions :hasMode="stockSymbol.id === 0" @onUpdate="setEditMode" @onCancel="onCancel" @onSave="onSave" @onDelete="onDelete"/>
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
    mounted() {
      this.originalName = this.stockSymbol.name;
      this.hasMode = this.stockSymbol.id === 0;
      this.setEditMode(this.hasMode);
    },
    data() {
        return {
            editMode: false,
            originalName: '',
            hasMode: false,
        }
    },
    methods: {
        setEditMode(mode) {
            this.editMode = mode;
        },
        saveNewStockSymbol() {
            axios.post('/stock-symbols', this.stockSymbol).then(({ data }) => {
                this.stockSymbol.id = data.id
            })
        },
        onSave() {
            if (this.stockSymbol.id === 0) {
                this.saveNewStockSymbol();
                return;
            }

            const name = this.stockSymbol.name;
            if (name.length <= 2 || name.length > 4) {
                return;
            }
            this.stockSymbol.name = this.stockSymbol.name.toUpperCase();
            axios.put(`/stock-symbols/${this.stockSymbol.id}`, this.stockSymbol).then(({ data }) => {
                this.originalName = data.name;
                this.setEditMode(false);
            });
        },
        onCancel(value) {
            if (this.stockSymbol.id === 0) {
                this.$emit('onCancel');
            }
            this.stockSymbol.name = this.originalName;
            this.setEditMode(value);
        },
        onDelete() {
            axios.delete(`/stock-symbols/${this.stockSymbol.id}`).then(() => {
                this.$emit('onDelete');
            })
        }
    },
}
</script>

<style scoped>

</style>
