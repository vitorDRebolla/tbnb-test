<template>
    <div>
        <v-snackbar
            v-model="snackbar"
            :timeout="timeout"
        >
            {{ text }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    color="blue"
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                >
                    X
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>

<script>
export default {
    name: 'Errorhandler',
    props: {
        value: {
            type: Boolean,
            default: false,
            required: true,
        },
        timeout: {
            type: Number,
            default: 5000,
            required: false,
        },
        text: {
            type: String,
            default: '',
            required: true,
        },
    },
    computed: {
        snackbar: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit('input', value);
            }
        }
    },
}
</script>

<style scoped>

</style>
