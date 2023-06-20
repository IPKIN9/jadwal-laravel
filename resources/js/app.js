require('./bootstrap');

import { createApp } from 'vue'
import Jurusan from './components/Jurusan'

const app = createApp({})

app.component('jurusan', Jurusan)

app.mount('#app')