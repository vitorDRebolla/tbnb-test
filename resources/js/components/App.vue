<template>
    <v-app>
        <v-main class="background">
            <div class="container">
                <router-view/>
            </div>
        </v-main>
    </v-app>
</template>
<script>
    export default {}
</script>
<style>
.background {
    background: rgb(130,171,161);
    background: linear-gradient(90deg, rgba(130,171,161,1) 0%, rgba(159,209,197,1) 50%, rgba(194,255,241,1) 100%);
}
</style>
