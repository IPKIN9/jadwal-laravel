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
                <div class="input-group">
                  <h3>TABEL JADWAL</h3>
                </div>
                <div class="input-group">
                </div>
                <div class="input-group row ms-1">
                  <p class="col-lg text-end"><i class="fa-solid fa-user me-1"></i> User: ADMIN</p>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row mt-3">
                <div class="col-lg-4">
                  <SelectSearch @change="getCalendar" :id-element="{search: 'input-search-params', select: 'input-select-params'}" @setName="clearKelas" size="5" @search-event="getKelasPayload" @clear-data="clearKelas" :required="true" :list="kelasList" :show-up="kelasShow" v-model.number="scheduleMeta.kelas_id" label="Pilih Kelas" class="rounded-3" />
                </div>
                <div class="col-lg-4">
                  <BaseSelect @change="getCalendar()" label="Bulan" :list="bulan" v-model.number="datePayload.bulan" />
                </div>
                <div class="col-lg-4">
                  <BaseSelect label="Tahun" :list="tahun" v-model="datePayload.tahun" @change="getCalendar()" />
                </div>
              </div>
              <div class="mt-5" v-show="scheduleMeta.kelas_id !== 0">
                <table class="table table-bordered mb-0">
                  <thead>
                    <tr>
                      <th class="cs-th">SENIN</th>
                      <th class="cs-th">SELASA</th>
                      <th class="cs-th">RABU</th>
                      <th class="cs-th">KAMIS</th>
                      <th class="cs-th">JUMAT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(week, index) in newDates" :key="index">
                      <td class="cs-td" v-for="(day, index2) in week" :key="index2" >
                        <a href="#" role="button" @click="getDetail({show:`${day.tgl} ${getMonthName(day.bulan)} ${day.tahun}`, val:`${day.tahun}-${day.bulan}-${day.tgl}`, type: 'new', kelasId: scheduleMeta.kelas_id}, {data: day.data})" :class="
                          (day.bulan === (datePayload.bulan - 1) && day.bulan !== 12) || 
                          (day.bulan === (datePayload.bulan + 1) && day.bulan !== 12) ||
                          ((datePayload.bulan === 12 && (day.bulan === 1 || day.bulan === 11)) || 
                          (datePayload.bulan === 1 && (day.bulan === 12) || day.bulan === 2) && day.bulan != 2)? 'disabled' : ''">
                          <div class="px-2 pt-2 row">
                            <div class="col-lg-3">
                              <h3>{{ day.tgl }}</h3>
                            </div>
                            <div v-if="day.data.length >= 2" class="col-lg d-flex justify-content-end">
                              <div class=""><span class="badge bg-success">Full</span></div>
                            </div>
                            <div v-if="day.data.length === 1" class="col-lg d-flex justify-content-end">
                              <div class=""><span class="badge bg-primary">1 Sesi</span></div>
                            </div>
                            <div v-if="day.data.length === 0" class="col-lg d-flex justify-content-end">
                              <div class=""><span class="badge bg-light-secondary">Kosong</span></div>
                            </div>
                          </div>
                          <div class="row px-2 my-3" v-for="(d, index3) in day.data" :key="index3">
                            <div class="col-lg-12">
                              <div class="d-flex">
                                <small><span class="text-capitalize">{{ d.mapel }}</span> :<span> {{ d.guru }}</span></small>
                              </div>
                              <div class="d-flex"><small class="px-2 rounded-3"  style="background: #DDE6ED;">{{ d.jam_masuk }} - {{ d.jam_keluar }} WITA</small></div>
                            </div>
                          </div>
                          <div v-if="day.data.length <= 0" class="row px-2" style="margin: 43px 0;">
                            <div class="col-lg-12">
                              <div class="d-flex"><small class="px-2 py-2 rounded-3 text-muted">set sekarang</small></div>
                            </div>
                          </div>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
      </section>
    </div>
    
    <Footer/>
  </div>
  <ModalComponent size="modal-lg" :is-modal-open="modalStatus" @close="showHideModal" ref="modal">
    <template v-slot:header>
      <h4 class="tex-center"><i class="fa-solid fa-file-invoice me-2 text-capitalize"></i> Jadwal Hari Ini - {{ dateNow.show }}</h4>
    </template>
    <template v-slot:body>
      <div class="row px-2">
        <div class="col-lg-6">
          <div class="mb-3"><p>Pastikan semua data terisi sebelum melakukan proses</p></div>
        </div>
        <div class="col-lg-6">
          <span class="d-flex justify-content-end"><small>RPL 1</small><small class="text-muted ms-2">:KELAS</small></span>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group mt-2 mb-3 mx-2">
            <SelectSearch size="5" :id-element="{search: 'input-search-mapel', select: 'input-select-mapel'}" @search-event="getMapelList" @set-name="clearMapel" @clear-data="clearMapel" :list="mapelList" :show-up="mapelShow" label="Mata Pelajaran" :required="true" v-model.number="schedulePayload.mapel" />
            <small class="text-danger">
              {{ scheduleError.mapel }}
            </small>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group mt-2 mb-3 mx-2">
            <BaseSelectSchedule size="5" :id-element="{search: 'input-search-guru', select: 'select-search-guru'}" @visible-button="setButtonVisible" :tgl="dateNow.val" :list-schedule="allScheduleList" @search-event="getGuruList" @clear-data="clearGuru" :list="guruList" :show-up="guruShow" label="Guru" :required="true" v-model.number="schedulePayload.guru_id" />
            <small class="text-danger">
              {{ scheduleError.guru_id }}
            </small>
          </div>
        </div>
      </div>
      <div class="row my-3">
        <div v-if="!checkJamMasuk(session[0].masuk)" class="col-lg-6 mb-5 text-center"><BaseButton :class="visibleButton[0] ? '' : 'disabled'" class="btn-info px-5" @event-click="insertSchedule(session[0].masuk, session[0].keluar, null)">TAMBAHKAN KE SESI 1</BaseButton></div>
        <div v-if="!checkJamMasuk(session[1].masuk)" class="col-lg-6 mb-5 text-center"><BaseButton :class="visibleButton[1] ? '' : 'disabled'" class="btn-primary px-5" @event-click="insertSchedule(session[1].masuk, session[1].keluar, null)">TAMBAHKAN KE SESI 2</BaseButton></div>
      </div>
      <div class="row mt-3">
        <span class="col-lg-6 text-start"><p class="ms-4">GURU / MATA PELAJARAN</p></span>
        <span class="col-lg-6 text-end"><p class="me-4">AKSI</p></span>
        <div v-if="detailPayload.length <= 0" class="d-flex justify-content-center">
          <p class="text-muted my-5 text-uppercase">Data Belum Diset</p>
        </div>
        <div v-for="(detail, index) in detailPayload" :key="index">
          <div class="divider col-lg-12">
            <div class="divider-text">{{ detail.jam_masuk }} - {{ detail.jam_keluar }}</div>
          </div>
          <div class="row">
            <div class="col-lg-6 text-start">
            <div class="ms-4">
              <p class="mb-1"><i class="fa-solid fa-user me-2 text-muted"></i> {{ detail.guru }} </p>
              <span class="fs-5 fw-bold text-uppercase"> {{ detail.mapel }}</span>
            </div>
            </div>
            <div class="col-lg-6 text-end">
              <div class="btn-group" role="group" aria-label="Basic example">
                  <BaseButton v-show="visibleButton[index]" @event-click="insertSchedule(session[index].masuk, session[index].keluar, detail.id)" class="btn-default">Edit</BaseButton>
                  <BaseButton class="btn-default" @event-click="deleteSchedule" :data-id="detail.id">Hapus</BaseButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-slot:footer>
      <!-- <BaseButton @event-click="insertSchedule" :disabled="loading ? true : false" class="btn-primary">Proses <Loading v-if="loading" /></BaseButton> -->
      <BaseButton :disabled="loading ? true : false" class="btn-default" @event-click="showHideModal">Tutup</BaseButton>
    </template>
  </ModalComponent>
</template>
<style>
  .cs-th {
    text-align: center;
    width: 20%;
  }

  .cs-td {
    text-decoration: none;
    transition: box-shadow 0.3s;
  }

  .cs-td:hover {
    box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.1);
  }
  
  .disabled {
    opacity: 0.5; /* Mengatur transparansi elemen */
    pointer-events: none; /* Menonaktifkan interaksi dengan elemen */
    cursor: not-allowed; /* Mengubah kursor menjadi 'not-allowed' */
  }

  .calendar-enter-active {
    transition: all 0.3s ease;
  }

  .v-enter-active {
    transition: opacity 0.5s ease;
  }

  .v-enter-from,
  .v-leave-to {
    opacity: 0;
  }

  .calendar-enter-from,
  .calendar-leave-to {
    opacity: 0;
    transform: translateX(30px);
  }

  .calendar {
    overflow: hidden;
  }

  .day-enter-active {
    transition: all 0.3s ease;
  }

  .day-enter-from,
  .day-leave-to {
    opacity: 0;
    transform: translateX(30px);
  }

  .day {
    overflow: hidden;
  }
</style>
<script setup>
import { onMounted, reactive, ref } from 'vue';
import * as Yup from 'yup'
import Sidebar from './child/Sidebar.vue';
import Header from './child/Header.vue';
import ModalComponent from './child/ModalComponent.vue';
import BaseSelect from './input/BaseSelect.vue'
import SelectSearch from './input/SelectSearch.vue'
import Footer from './child/Footer.vue';
import BaseSelectSchedule from './input/BaseSelectSchedule.vue'
import BaseButton from './input/BaseButton.vue';
import Calendar from '../utils/other/calendar'
import detailJadwal from '../utils/api/detail-jadwal'
import IziToast from '../utils/other/izitoast'
import kelas from '../utils/api/kelas'
import mapel from '../utils/api/mapel'
import guru from '../utils/api/guru'

const loading = ref(false)

/* Fungsi untuk mengambil data dari detail jadwal */
const scheduleMeta = reactive({
  kelas_id : 0,
  start_date: '',
  end_date  : ''
})

const scheduleMeta2 = reactive({
  kelas_id : null,
  start_date: '',
  end_date  : ''
})

const scheduleList = ref()
const allScheduleList = ref()

const getSchedule = async () => {
  await detailJadwal.getAll(scheduleMeta)
  .then((res) => {
    let data = res.data.data
    scheduleList.value = data
    for (const key in data) {
      pushScheduleToCalendar(data[key])
    }
  })
  .catch((err) => {
    if (err.response) {
      IziToast.errorNotif(err.response.status)
    } else {
      IziToast.errorNotif(900)
    }
  })
}

const getAllSchedule = async () => {
  await detailJadwal.getAll(scheduleMeta2)
  .then((res) => {
    let data = res.data.data
    allScheduleList.value = data
  })
  .catch((err) => {
    if (err.response) {
      IziToast.errorNotif(err.response.status)
    } else {
      IziToast.errorNotif(900)
    }
  })
}

/* Fungsi tambah edit data */
const visibleButton= ref([
  true, true
]);

const setButtonVisible = (params) => {
  visibleButton.value[0] = params.sesi1
  visibleButton.value[1] = params.sesi2
};

const schedulePayload = reactive({
  kelas_id: 0,
  guru_id: 0,
  mapel: '',
  jumlah_jam: 5,
  tgl: '',
  jam_masuk: '',
  jam_keluar: ''
})

const scheduleError = ref('');

const insertSchedule = async (jam_masuk, jam_keluar, idSchedule) => {
  schedulePayload.jam_masuk = jam_masuk
  schedulePayload.jam_keluar = jam_keluar
  schedulePayload.tgl = dateNow.val

  schedulePayload.id  = idSchedule
  
  try {
    const payloadSchema = Yup.object().shape({
      kelas_id: Yup.number()
        .required('Inputan harus diisi')
        .notOneOf([0], 'Inputan tidak kosong'),
      guru_id: Yup.number()
        .required('Inputan harus diisi')
        .notOneOf([0], 'Inputan tidak kosong'),
      mapel: Yup.string()
        .required('Inputan harus diisi')
        .min(2, 'Inputan minimal terdiri dari 2 karakter')
        .max(50, 'Inputan maksimal terdiri dari 150 karakter'),
    });

    await payloadSchema.validate(schedulePayload, { abortEarly: false });

    axios.post(`/api/v1/detail/jadwal`, schedulePayload)
    .then((res) => {
      console.log(res.data);
      showHideModal({ type: '' })
      IziToast.successNotif({
        title: 'Tersimpan',
        message: 'Jadwal Berhasil Disimpan'
      })
      getCalendar()
      clearSchdule()

      scheduleError.value = []
    })
    .catch((err) => {
      if (err.response) {
        IziToast.errorNotif(err.response.status)
      } else {
        IziToast.errorNotif(900)
      }
    })

  } catch (error) {
     const errorMessages = error.inner.reduce((errors, error) => {
      errors[error.path] = error.message;
      return errors;
    }, {});
    scheduleError.value = errorMessages;
  }
}

const deleteSchedule = (params) => {
  detailJadwal.delete(params.dataId)
  .then((res) => {
    console.log(res.data);
    showHideModal({ type: '' })
    IziToast.successNotif({
      title: 'Terhapus',
      message: 'Jadwal Berhasil Dihapus'
    })
    getCalendar()
  })
  .catch((err) => {
    if (err.response) {
      IziToast.errorNotif(err.response.status)
    } else {
      IziToast.errorNotif(900)
    }
  })
}

const clearSchdule = () => {
  delete schedulePayload.id
  schedulePayload.kelas_id = 0
  schedulePayload.guru_id = 0
  schedulePayload.mapel = ''

  visibleButton.value[0] = true
  visibleButton.value[1] = true

  clearGuru()
  clearMapel()
}

/* Fungsi untuk mengambil data kelas */
const kelasList = ref()
const kelasShow= {
  key: 'id',
  name: '_kelas'
}

const getKelasPayload = (kelasPayload) => {
  kelas.getAll({
    jurusan_id: 0,
    search: kelasPayload,
    limit: 50,
    page: 1,
    orderBy: '_kelas',
    sort: 'asc'
  })
  .then((res) => {
    kelasList.value = res.data.data
  })
  .catch((err) => {
    if (err.response) {
      IziToast.errorNotif(err.response.status)
    } else {
      IziToast.errorNotif(900)
    }
  })
}

const clearKelas = () => {
  kelasList.value = []
}

/* Fungsi mengambil data guru */
const guruList = ref()

const guruShow= {
  key: 'id',
  name: 'nama'
}
const getGuruList = (guruPayload) => {
  guru.getAll({
    search : guruPayload,
    page   : 1,
    limit  : 100,
    orderBy: 'nama',
    sort   : 'asc',
  })
  .then((res) => {
    guruList.value = res.data.data
  })
  .catch((err) => {
    console.log(err);
    
  })
}

const clearGuru = () => {
  guruList.value = []
}

/* Fungsi mengambil data matapelajaran */
const mapelList = ref()

const mapelShow = {
  key: 'nama_mapel',
  name: 'nama_mapel'
}
const getMapelList = (mapelPayload) => {
  mapel.getAll({
    search : mapelPayload,
    page   : 1,
    limit  : 100,
    orderBy: 'nama_mapel',
    sort   : 'asc',
  })
  .then((res) => {
    mapelList.value = res.data.data
  })
  .catch((err) => {
    if (err.response) {
      IziToast.errorNotif(err.response.status)
    } else {
      IziToast.errorNotif(900)
    }
  })
}

const clearMapel = () => {
  mapelList.value = []
}

/* Detail schedule */
const detailPayload = ref()

const checkJamMasuk = (timeNow) => {
  return detailPayload.value.some((item) => item.jam_masuk === timeNow);
}

const getDetail = (params, data) => {
  showHideModal(params)
  detailPayload.value = data.data
  
  schedulePayload.kelas_id = params.kelasId
}

const session = [
  {masuk: '07:15:00', keluar: '11:15:00'},
  {masuk: '11:16:00', keluar: '16:00:00'},
]

/* Fungsi lainnya */
const datePayload = reactive({
  bulan: 6,
  tahun: 2023
})

const getCalendar = () => {
  newDates.value = Calendar.getDate(datePayload.tahun, datePayload.bulan);
  
  let lengthWeek = newDates.value.length - 1
  let lengthDay  = newDates.value[lengthWeek].length - 1
  
  let start_date = `${newDates.value[0][0].tahun }-${newDates.value[0][0].bulan}-${newDates.value[0][0].tgl}`
  let end_date   = `${newDates.value[lengthWeek][lengthDay].tahun }-${newDates.value[lengthWeek][lengthDay].bulan}-${newDates.value[lengthWeek][lengthDay].tgl}`

  scheduleMeta.start_date = start_date
  scheduleMeta.end_date   = end_date

  scheduleMeta2.start_date = start_date
  scheduleMeta2.end_date   = end_date

  getSchedule()
  getAllSchedule()
}

const pushScheduleToCalendar = (params) => {
  const datas = params
  const dateStr = datas.tgl;
  const dateParts = dateStr.split("-");

  const year = parseInt(dateParts[0]);
  const month = parseInt(dateParts[1]);
  const day = parseInt(dateParts[2]);

  const result = newDates.value.find((arr) => {
    return arr.some((obj) => obj.tgl === day && obj.bulan === month);
  });

  if (result) {
    const resRow = result.findIndex((row) => row.tgl === day && row.bulan === month && row.tahun === year);
    result[resRow].data.push(params)
    result[resRow].data.sort((a, b) => {
      const jamMasukA = a.jam_masuk;
      const jamMasukB = b.jam_masuk;

      if (jamMasukA < jamMasukB) {
        return -1;
      }
      if (jamMasukA > jamMasukB) {
        return 1;
      }
      return 0;
    });
  } 
}

const newDates = ref([]);

const bulan = [
  {lable: 'januari'  , val: 1 },
  {lable: 'februari' , val: 2 },
  {lable: 'maret'    , val: 3 },
  {lable: 'april'    , val: 4 },
  {lable: 'mei'      , val: 5 },
  {lable: 'juni'     , val: 6 },
  {lable: 'juli'     , val: 7 },
  {lable: 'agustus'  , val: 8 },
  {lable: 'september', val: 9 },
  {lable: 'oktober'  , val: 10},
  {lable: 'november' , val: 11},
  {lable: 'desember' , val: 12}
]

const tahun = ref([])

const getTahun = () => {
  const tahunSekarang = new Date().getFullYear();
  for (let i = 1; i >= 0; i--) {
      tahun.value.push({lable: (tahunSekarang - i).toString(), val: (tahunSekarang - i)});
    }

    // Mengisi array dengan rentang dua tahun ke depan
    for (let i = 1; i <= 2; i++) {
      tahun.value.push({lable: (tahunSekarang + i).toString(), val: (tahunSekarang - i)});
    }

    // Mengurutkan array tahun dari terkecil hingga terbesar
    tahun.value.sort();
}

const getMonthName = (monthVal) => {
  const month = bulan.find(item => item.val === monthVal);

  if (month) {
    return month.lable;
  } else {
    return 'bulan tidak ditemukan'
  }
}

const dateNow = reactive({
  show: '',
  val : ''
})

const modalStatus = ref(false)
const showHideModal = (properties) => {
  modalStatus.value = modalStatus.value ? false : true
  if (properties.type === 'new') {
    dateNow.show = properties.show
    dateNow.val  = properties.val
  }
}

onMounted(() => {
  getCalendar()
  getTahun()
})
</script>