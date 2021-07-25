<template>
    <div>
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ dailyPrice.day | formatDate }} - ${{ dailyPrice.price }}</h5>
            <ButtonActions/>
        </div>
    </div>
</template>

<script>
import ButtonActions from "../Base/ButtonActions";

export default {
    name: 'DailyPrice',
    components: { ButtonActions },
    props: {
        value: Object,
    },
    computed: {
        dailyPrice: {
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
    filters: {
        formatDate(value) {
            let date = new Date(value);
            return date.toLocaleDateString();
        }
    }
}
</script>

<style scoped>

</style>
