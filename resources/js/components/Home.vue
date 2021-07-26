<template>
    <div>
        <div class="d-flex mt-13">
            <v-btn
                class="mr-4"
                :outlined="selectedComponent === 1"
                elevation="2"
                @click="changeSelectedComponent(1)"
            >
                Home
            </v-btn>
            <v-btn
                class="mr-4"
                :outlined="selectedComponent === 2"
                elevation="2"
                @click="changeSelectedComponent(2)"
            >
                Charts
            </v-btn>
            <v-btn
                class="mr-4"
                :outlined="selectedComponent === 3"
                elevation="2"
                @click="changeSelectedComponent(3)"
            >
                Bulk Update
            </v-btn>
        </div>
        <div class="mt-13">
            <List v-if="selectedComponent === 1"/>
            <Charts v-if="selectedComponent === 2"/>
            <BulkUpdate v-if="selectedComponent === 3"/>
        </div>
    </div>
</template>

<script>
import List from './List';
import Charts from './Charts';
import BulkUpdate from './BulkUpdate';

export default {
    name: 'Home',
    components: {BulkUpdate, Charts, List},
    data() {
        return {
            selectedComponent: 1,
        };
    },
    methods: {
        changeSelectedComponent(component) {
            this.selectedComponent = component;
        }
    }
}
</script>
<style>
.v-btn--outlined {
    border-color: white !important;
    color: white !important;
}

.edit-input {
    max-height: 28px;
}

</style>
