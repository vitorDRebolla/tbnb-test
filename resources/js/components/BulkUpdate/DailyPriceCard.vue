<template>
    <div>
        <div :class="['card border shadow p-3 position-relative mr-2 mb-2', {'edited': changed}]">
            <v-icon
                class="position-absolute edit-item"
                @click="editMode = !editMode"
            >
                far fa-edit
            </v-icon>
            <h5>{{ dailyPrice.stock_symbol_name }}</h5>
            <div v-if="!editMode">
                <p>{{ dailyPrice.day | formatDate }}</p>
                <p>{{ dailyPrice.price.replace('.', ',') }}</p>
            </div>
            <div v-if="editMode">
                <input
                    v-model="dailyPrice.day"
                    class="form-control edit-input"
                    type="date"
                    @input="onInput">
                <input
                    v-model="dailyPrice.price"
                    class="form-control edit-input"
                    type="number"
                    @input="onInput">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DailyPriceCard',
    props: {
        value: Object,
        saved: Boolean
    },
    computed: {
        dailyPrice: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit('input', value);
            }
        },
    },
    watch: {
      saved() {
          if(this.saved) {
              this.editMode = false;
              this.setChanged(false);
          }
      }
    },
    data() {
        return {
            editMode: false,
            changed: false,
        };
    },
    methods: {
        setChanged(value) {
            this.changed = value;
            this.$set(this.dailyPrice, 'changed', value);
        },
        onInput() {
            this.setChanged(true);
            this.$emit('changed');
        }
    },
    filters: {
        formatDate(value) {
            let date = new Date(value);
            return date.toLocaleDateString();
        }
    }
}
</script>
<style lang="scss" scoped>
.edit-item {
    right: 5px;
    top: 5px;
    font-size: 18px !important;
    cursor: pointer;
}

.card {
    width: 185px;
    height: 120px;
}

p, input {
    margin-bottom: 7px !important;
}

.edited {
    background-color: #fffdc1;
}
</style>
