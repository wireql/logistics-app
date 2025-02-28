import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import Notifications from '@kyvg/vue3-notification'
import VueTheMask from 'vue-the-mask'

const pinia = createPinia();

const app = createApp(App)

app.use(pinia)
app.use(router)
app.use(Notifications)
app.use(VueTheMask)

app.mount('#app')