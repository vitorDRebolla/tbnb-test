<template>
    <div class="d-flex">
        <div v-if="!editMode">
            <v-btn :disabled="deleting" class="mr-2" small @click="onUpdate">
                <v-icon>far fa-edit</v-icon>
            </v-btn>
            <v-btn :disabled="deleting" :loading="deleting" class="mr-2" small @click="onDelete">
                <v-icon>far fa-trash-alt</v-icon>
            </v-btn>
        </div>
        <div v-if="editMode">
            <v-btn :disabled="saving" :loading="saving" class="mr-2" small @click="onSave">
                <v-icon>far fa-save</v-icon>
            </v-btn>
            <v-btn :disabled="saving" class="mr-2" small @click="onCancel">
                <v-icon>fas fa-times</v-icon>
            </v-btn>
        </div>
        <v-btn class="ml-1" v-if="arrowUp || arrowDown" :disabled="deleting || saving" small @click="changeDropdown">
            <v-icon v-if="arrowUp">fas fa-angle-up</v-icon>
            <v-icon v-if="arrowDown">fas fa-angle-down</v-icon>
        </v-btn>
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
        },
        saving: {
            type: Boolean,
            default: false,
            required: false,
        },
        deleting: {
            type: Boolean,
            default: false,
            required: false,
        },
        arrowUp: {
            type: Boolean,
            default: false,
            required: false,
        },
        arrowDown: {
            type: Boolean,
            default: false,
            required: false,
        }
    },
    mounted() {
        this.setEditMode(this.hasMode);
    },
    watch: {
        hasMode() {
            this.setEditMode(this.hasMode);
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
        changeDropdown() {
            this.$emit('changeDropdown');
        }
    },
}
</script>

<style lang="scss" scoped>
@media (max-width: 768px) {
    i {
        font-size: 13px !important;
    }

    button {
        min-width: 36px !important;
    }
}

@media (min-width: 769px) {
    i {
        font-size: 15px !important;
    }

    button {
        min-width: 41px !important;
    }
}
</style>
