require('./bootstrap');

import { createApp } from 'vue'
import Jurusan from './components/Jurusan'
import Kelas from './components/Kelas'
import 'izitoast/dist/css/iziToast.css'
import 'izitoast/dist/js/iziToast.js'

const app = createApp({})

app.component('jurusan', Jurusan)
app.component('kelas', Kelas)

app.mount('#app')