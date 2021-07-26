import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './components/App'
import Home from './components/Home'
import vuetify from './plugins/vuetify'
import axios from 'axios'
import VueAxios from 'vue-axios'
import '@fortawesome/fontawesome-free/css/all.css'
import Vuetify from 'vuetify/lib'

Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(Vuetify)

export default new Vuetify({
    icons: {
        iconfont: 'fa',
    },
})

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
    ],
});
const app = new Vue({
    el: '#app',
    components: { App },
    router,
    vuetify,
});
