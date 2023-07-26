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
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import Pagination from './components/Misc/Pagination.vue'

const globalOptions = {
    placeholder: 'Your article starts here...',
    theme: 'snow',
    content: {},
    contentType: 'delta',
}

const app = createApp(App)
app.use(router)
app.use(VueSweetalert2)
QuillEditor.props.globalOptions.default = () => globalOptions
app.component('QuillEditor', QuillEditor)
    .component('Pagination', Pagination)
app.mount('#app')