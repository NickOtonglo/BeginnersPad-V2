import './bootstrap';
import '../css/default-theme.css'
import '../css/photoswipe.css'
import '../css/app.css'
import '../css/utilities.css'
import '../css/queries.css'

import { createApp } from 'vue';
import router from './routes/index'
import App from './components/App.vue'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

const app = createApp(App)
app.use(router)
app.use(VueSweetalert2)
app.mount('#app')