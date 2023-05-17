import './bootstrap';
import '../css/default-theme.css'
import '../css/photoswipe.css'
import '../css/queries.css'
import '../css/utilities.css'
import '../css/app.css'

import { createApp } from 'vue';
import router from './routes/index'
import App from './components/App.vue'

const app = createApp(App)
app.use(router)
app.mount('#app')