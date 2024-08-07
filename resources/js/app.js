import './bootstrap';
import '../css/default-theme.css'
// import '../css/photoswipe.css'
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
import VueViewer from 'v-viewer'
import 'viewerjs/dist/viewer.css'
import VueGoogleMaps from '@fawmi/vue-google-maps'

const globalOptions = {
    placeholder: 'Your article starts here...',
    theme: 'snow',
    content: {},
    contentType: 'delta',
}

localStorage.setItem('title', 'BeginnersPad')

const app = createApp(App)
app.use(router)
app.use(VueSweetalert2)
app.use(VueViewer)
QuillEditor.props.globalOptions.default = () => globalOptions
app.component('QuillEditor', QuillEditor)
    .component('Pagination', Pagination)
app.use(VueGoogleMaps, {
    load: {
        key: import.meta.env.VITE_GOOGLE_MAPS_API_KEY,
        libraries: "places",
    },
})
app.mount('#app')