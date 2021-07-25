<template>
    <div>
        <div v-if="!editMode">
            <v-btn small class="mr-2" @click="onUpdate">Update</v-btn>
            <v-btn small @click="onDelete">Delete</v-btn>
        </div>
        <div v-if="editMode">
            <v-btn small class="mr-2" @click="onSave">Save</v-btn>
            <v-btn small @click="onCancel">Cancel</v-btn>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ButtonActions',
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

</style>
