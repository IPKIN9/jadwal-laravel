<template>
  <div id="sidebar" class="active">
  <Sidebar />
</div>
<div id="main">
  <Header/>

  <div class="page-content">
    <section class="row">
      <section class="section">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <h3>Export Data</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <SelectSearch label="Pilih Jurusan" size="5"
                  :id-element="{ search: 'input-search-jurusan', select: 'input-select-jurusan' }" :required="true"
                  @search-event="getJurusanPayload" @set-name="clearJurusan" @clear-data="clearJurusan" :list="jurusanList"
                  :show-up="jurusanShow" v-model="meta.jurusan_id" />
              </div>
              <div class="col-lg">
                <DateTimePicker placeholder="Pilih tanggal mulai" type="start" :end-date="meta.end" v-model="meta.start" class="mt-4" />
              </div>
              <div class="col-lg">
                <DateTimePicker placeholder="Pilih tanggal akhir" type="end" :start-date="meta.start" v-model="meta.end" class="mt-4" />
              </div>
              <div class="col-lg">
                <BaseButton @event-click="getReportPayload" class="btn-primary mt-4 float-end">Download Data</BaseButton>
              </div>
            </div>
          </div>
        </div>
      </section>
    </section>
  </div>
  
  <Footer/>
</div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue'
import moment from 'moment'
import Sidebar from './child/Sidebar.vue';
import Header from './child/Header.vue';
import BaseButton from './input/BaseButton.vue';
import SelectSearch from './input/SelectSearch.vue';
import DateTimePicker from './input/DateTimePicker.vue';
import Footer from './child/Footer.vue';
import Loading from './child/Loading.vue';
import IziToast from '../utils/other/izitoast';
import jurusan from '../utils/api/jurusan'
import report from '../utils/api/report'
import Report from '../utils/other/report';

/* Fungsi untuk mengambil data jadwal */
const reportPayload = ref([])

const meta = reactive({
  start: '',
  end: '',
  jurusan_id: 0,
  limit     : 10,
  page      : 1,
  orderBy   : '_Jurusan',
  sort      : 'asc'
})


const getReportPayload = () => {
meta.start = moment(meta.start).format('YYYY-MM-DD')
meta.end = moment(meta.end).format('YYYY-MM-DD')

report.getAll(meta)
.then((res) => {
  let item = res.data
  reportPayload.value = item
  
  exportFile(item.kelas)
})
.catch((err) => {
  console.log(err);
  
  if (err.response) {
    IziToast.errorNotif(err.response.status)
  } else {
    IziToast.errorNotif(900)
  }
})
}

/* Fungsi untuk mendownload data jadwal */

const exportFile = (payload) => {
Report.orderLogs(jurusanName.value, payload, {start: meta.start, end: meta.end})
.then((res) => {
  IziToast.successNotif({
    title: 'Berhasil',
    message: 'Berhasil mendownload jadwal'
  })
})
.catch((err) => {
  console.log(err);
  if (err.response) {
    IziToast.errorNotif(err.response.status)
  } else {
    IziToast.errorNotif(900)
  }
})
}

/* Fungsi untuk mengambil data Jurusan */
const jurusanMeta = reactive({
search    : '',
limit     : 10,
page      : 1,
orderBy   : '_Jurusan',
sort      : 'asc'
})

const jurusanList = ref()

const jurusanShow = {
key : 'id',
name: '_jurusan'
}

const jurusanName = ref('')

const getJurusanPayload = (jurusanPayload) => {
jurusanMeta.search = jurusanPayload
jurusan.getAll(jurusanMeta)
.then((res) => {
  let item = res.data.data
  jurusanList.value = item
})
.catch((err) => {
  if (err.response) {
    IziToast.errorNotif(err.response.status)
  } else {
    IziToast.errorNotif(900)
  }
})
}

const clearJurusan = (name) => {
jurusanName.value = name
jurusanList.value = []
}

</script>