import './assets/index.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import { autoAnimatePlugin } from '@formkit/auto-animate/vue'

const app = createApp(App)


app.use(autoAnimatePlugin)

app.use(router)

app.mount('#app')
