<template>
    <div>
        <div v-if="!editMode">
            <v-btn small class="mr-2" @click="onUpdate">
                <v-icon>far fa-edit</v-icon>
            </v-btn>
            <v-btn small @click="onDelete">
                <v-icon>far fa-trash-alt</v-icon>
            </v-btn>
        </div>
        <div v-if="editMode">
            <v-btn small class="mr-2" @click="onSave">
                <v-icon>far fa-save</v-icon>
            </v-btn>
            <v-btn small @click="onCancel">
                <v-icon>fas fa-times</v-icon>
            </v-btn>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ButtonActions',
    props: {
        hasMode: {
            type: Boolean,
            default: false,
            required: false,
        }
    },
    mounted() {
        this.setEditMode(this.hasMode);
    },
    data() {
        return {
            editMode: false,
        }
    },
    methods: {
        setEditMode(mode) {
            this.editMode = mode;
        },
        onSave() {
            this.$emit('onSave');
        },
        onUpdate() {
            this.setEditMode(true);
            this.$emit('onUpdate', this.editMode);
        },
        onCancel() {
            this.setEditMode(false);
            this.$emit('onCancel', this.editMode);
        },
        onDelete() {
            this.$emit('onDelete');
        },
    },
}
</script>

<style scoped>
* {
    font-size: 15px !important;
}
</style>
