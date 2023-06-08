import { createApp } from 'vue';
import axios from 'axios'
import VueAxios from 'vue-axios'
import 'flowbite';

import App from './components/pages/WeatherApp.vue';

const app = createApp(App)
.use(VueAxios, axios)
app.mount('#app')
