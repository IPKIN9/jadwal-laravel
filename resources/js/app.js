require('./bootstrap');

import { createApp } from 'vue'
import Jurusan from './components/Jurusan'
import Kelas from './components/Kelas'
import Mapel from './components/Mapel'
import Pangkat from './components/Pangkat'
import Jadwal from './components/Jadwal'
import 'izitoast/dist/css/iziToast.css'
import 'izitoast/dist/js/iziToast.js'

const app = createApp({})

app.component('jurusan', Jurusan)
app.component('kelas', Kelas)
app.component('mapel', Mapel)
app.component('pangkat', Pangkat)
app.component('jadwal', Jadwal)

app.mount('#app')