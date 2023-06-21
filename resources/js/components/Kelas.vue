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
                <h3>TABEL KELAS</h3>
                <BaseButton class="btn-primary" @event-click="showHideModal({ type: 'new-data' })">Tambah Data</BaseButton>
              </div>
            </div>
            <div class="card-body">
              <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-top d-flex justify-content-between">
                  <div class="dataTable-dropdown">
                    <select class="dataTable-selector form-select" v-model.number="meta.limit" @change="getPayloadList()">
                      <option value="10">10</option>
                      <option value="15">15</option>
                      <option value="20">20</option>
                      <option value="25">25</option>
                    </select><label>entries per page</label>
                  </div>
                  <div class="dataTable-search">
                    <div class="input-group">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                      <input class="dataTable-input" placeholder="Search..." type="text" v-model="meta.search"
                        @keyup="getPayloadList()">
                    </div>
                  </div>
                </div>
                <div class="dataTable-container mt-3">
                  <table class="table" id="table1">
                    <thead>
                      <tr>
                        <th style="width: 5%;"><a href="#">No.</a></th>
                        <th style="width: 25.862%;"><a @click="sortingData(meta.sort, '_kelas')" href="#"
                            class="dataTable-sorter"><i class="fa-solid me-1" :class="meta.sortIcon._kelas"></i> Nama</a></th>
                        <th style="width: 25.862%;"><a @click="sortingData(meta.sort, '_jurusan')" href="#"
                            class="dataTable-sorter"><i class="fa-solid me-1" :class="meta.sortIcon._jurusan"></i> Jurusan</a></th>
                        <th style="width: 18.8881%;"><a @click="sortingData(meta.sort, 'created_at')" href="#"
                            class="dataTable-sorter"><i class="fa-solid me-1" :class="meta.sortIcon.created_at"></i> Dibuat</a>
                        </th>
                        <th style="width: 16.3429%;"><a href="#" class="dataTable-sorter">Diupdate</a></th>
                        <th style="width: 11.1186%;"><a href="#" class="dataTable-sorter">Aksi</a></th>
                      </tr>
                    </thead>
                    <TransitionGroup name="table" tag="tbody">
                      <tr v-for="(kelas, index) in payloadList" :key="index">
                        <td>{{ index + 1 }}.</td>
                        <td class="text-capitalize">{{ kelas._kelas }}</td>
                        <td class="text-capitalize">{{ kelas._jurusan }}</td>
                        <td>{{ moment(kelas.created_at).format('DD, MMMM YYYY') }}</td>
                        <td>{{ moment(kelas.updated_at).format('DD, MMMM YYYY') }}</td>
                        <td>
                          <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <BaseButton :data-id="kelas.id" :row-data="payloadList[index]" @event-click="editPayload"
                              class="btn"><i class="text-primary fas fa-pencil mx-2"></i></BaseButton>
                            <BaseButton :data-id="kelas.id" class="btn" @event-click="deletePayload"><i
                                class="text-danger fas fa-trash mx-2"></i></BaseButton>
                          </div>
                        </td>
                      </tr>
                    </TransitionGroup>
                  </table>
                  <TransitionGroup name="defend" tag="div" class="d-flex justify-content-center" >
                    <h5 class="text-muted py-3" v-if="meta.total === 0 && meta.search.length === 0">Belum ada data dalam tabel ini!</h5>
                    <h5 class="text-muted py-3" v-if="meta.total_in_page === 0 && meta.search.length >= 1">Data tidak ditemukan!</h5>
                  </TransitionGroup>
                </div>
                <Transition>
                  <Paggination v-show="meta.search.length <= 0 && meta.total > meta.limit" :page="meta.page" :total="meta.total" :limit="meta.limit"
                    @event-click="paggination" />
                </Transition>
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
      <h4><i class="fa-solid fa-file-invoice me-2"></i> Formulir Data</h4>
    </template>
    <template v-slot:body>
      <div class="mx-2">
        <p class="text-muted mt-2 mb-3">Harap periksa formulir anda sebelum dikirim dan disimpan.</p>
        <div class="form-group mb-4">
          <BaseInput label="Nama kelas" :required="true" v-model="payload._kelas" placeholder="Masukan disini..." />
          <small class="text-danger">
            {{ kelasError._kelas }}
          </small>
        </div>
        <div class="form-group mb-3">
          <SelectSearchFixed size="5" @search-event="getJurusanPayload" :required="true" @clear-data="clearJurusan" label="Jurusan" :list="jurusanList" :show-up="jurusanShow" v-model.number="payload.jurusan_id" />
          <small class="text-danger">
            {{ kelasError.jurusan_id }}
          </small>
        </div>
      </div>
    </template>
    <template v-slot:footer>
      <BaseButton :disabled="loading ? true : false" class="btn-primary" @event-click="upsertPayload()">Proses <Loading v-if="loading" /></BaseButton>
      <BaseButton :disabled="loading ? true : false" class="btn-default" @event-click="showHideModal">Tutup</BaseButton>
    </template>
  </ModalComponent>
</template>
<style>
.v-enter-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}

.table-enter-active {
  transition: all 0.3s ease;
}

.table-enter-from,
.table-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

.table {
  overflow: hidden;
}

.defend-enter-active {
  transition: all 0.1s ease;
}

.defend-enter-active{
  transition-delay: 0.1s;
}

.defend-enter-from,
.defend-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

.defend {
  overflow: hidden;
}
</style>
<script setup>
import { onMounted, reactive, ref } from 'vue'
import moment from 'moment'
import * as Yup from 'yup'
import Kelas from '../utils/api/kelas';
import Izitoast from '../utils/other/izitoast';
import Sidebar from './child/Sidebar.vue';
import Header from './child/Header.vue';
import Footer from './child/Footer.vue';
import ModalComponent from './child/ModalComponent.vue';
import BaseButton from './input/BaseButton.vue';
import BaseInput from './input/BaseInput.vue';
import Loading from './child/Loading.vue';
import Paggination from './child/Paggination.vue';
import SelectSearchFixed from './input/SelectSearchFixed.vue'
import jurusan from '../utils/api/jurusan';
import sweetalert from '../utils/other/sweetalert';

const loading = ref(false)

/* Fungsi untuk mengambil data kelas */
const payloadList = ref()

const meta = reactive({
  sortIcon: {
    _kelas     : 'fa-sort',
    _jurusan   : 'fa-sort',
    created_at : 'fa-sort-up'
  },
  jurusan_id   : 0,
  search       : "",
  limit        : 10,
  page         : 1,
  total        : 10,
  orderBy      : "created_at",
  sort         : "desc",
  total_in_page: 10
})

const getPayloadList = () => {
  Kelas.getAll(meta)
    .then((res) => {
      let item           = res.data
      payloadList.value  = item.data
      meta.total         = item.meta.total
      meta.page          = item.meta.page
      meta.total_in_page = item.meta.total_in_page      
    })
    .catch((err) => {
      if (err.response) {
        Izitoast.errorNotif(err.response.status)
      } else {
        Izitoast.errorNotif(900)
      }
    })
}

/* Fungsi untuk menambahkan data */
const payload = reactive({
  _kelas: '',
  jurusan_id: 0
})

const kelasError = ref('');

const upsertPayload = async () => {
  try {
    const payloadSchema = Yup.object().shape({
      _kelas: Yup.string()
      .required('Field harus diisi')
      .min(2, 'Field minimal terdiri dari 2 karakter')
      .max(150, 'Field maksimal terdiri dari 150 karakter'),
      jurusan_id: Yup.number()
      .required('Field harus diisi'),
    });
    
    await payloadSchema.validate(payload, { abortEarly: false });
    
    loading.value = true
    axios.post(`/api/v1/kelas`, payload)
      .then((res) => {
        loading.value = false
        showHideModal({ type: '' })
        Izitoast.successNotif({
          title: 'Tersimpan',
          message: 'Berhasil menyimpan data ke database'
        })
      })
      .catch((err) => {
        if (err.response) {
          Izitoast.errorNotif(err.response.status)
        } else {
          Izitoast.errorNotif(900)
        }
      })

  } catch (err) {
    const errorMessages = err.inner.reduce((errors, error) => {
      errors[error.path] = error.message;
      return errors;
    }, {});
    loading.value = false
    kelasError.value = errorMessages;
  }
}

/* Fungsi untuk mengedit data */
const editPayload = (params) => {
  let rowData = params.rowData
  for (const key in rowData) {
    if (key === 'created_at' || key === 'updated_at') {
      continue
    }
    if (key === '_jurusan') {
      getJurusanPayload(rowData[key])
    }
    payload[key] = rowData[key]
  }

  showHideModal({ type: 'editedData' })
}

/* Fungsi untuk menghapus data */
const deletePayload = (params) => {
  sweetalert.confirmNotif(() => {
    Kelas.delete(params.dataId)
      .then((res) => {
        Izitoast.successNotif({
          title: 'Terhapus',
          message: 'Berhasil menyimpan dihapus'
        })
        if (payloadList.value.length <= 1) {
          meta.page = 1
        }
        getPayloadList()
      })
      .catch((err) => {
        if (err.response) {
          Izitoast.errorNotif(err.response.status)
        } else {
          Izitoast.errorNotif(900)
        }
      })
  })
}

/* Fungsi untuk mencari data jurusan */
const jurusanList = ref()

const jurusanShow = {
  key: 'id',
  name: '_jurusan'
}

const getJurusanPayload = (jurusanPayload) => {
  jurusan.getAll({
    search: jurusanPayload,
    page: 1,
    limit: 100,
    orderBy: '_jurusan',
    sort: 'desc'
  })
  .then((res) => {
    jurusanList.value = res.data.data
  })
  .catch((err) => {
    if (err.response) {
      Izitoast.errorNotif(err.response.status)
    } else {
      Izitoast.errorNotif(900)
    }
  })
}

const clearJurusan = () => {
  jurusanList.value = []
}

/* Fungsi menampilkan modal */
const modalStatus = ref(false)
const showHideModal = (properties) => {
  if (properties.type === 'new-data') {
    clearPayload()
  }

  modalStatus.value = modalStatus.value ? false : true
  if (modalStatus.value === false) {
    getPayloadList()
  }
}

/* Fungsi untuk mengambil page baru berdasarkan paggination */
const paggination = (data) => {
  meta.page = data.n_page
  getPayloadList()
}

/* Fungsi untuk mengurutkan data dalam tabel */
const sortingData = (sort, by) => {
  for (const key in meta.sortIcon) {
    if (by === (meta.sortIcon)[key]) {
      continue
    }
    (meta.sortIcon)[key] = 'fa-sort'
  }

  if (sort == 'asc') {
    meta.orderBy = by
    meta.sort = 'desc'
    meta.sortIcon[by] = 'fa-sort-up'
  } else if (sort == 'desc') {
    meta.orderBy = by
    meta.sort = 'asc'
    meta.sortIcon[by] = 'fa-sort-down'
  }

  getPayloadList()
}

/* Fungsi untuk membersihkan daftar payload */
const clearPayload = () => {
  payload._kelas = ''
  kelasError.value = ''
  jurusanList.value = []
  if ('id' in payload) {
    delete payload.id
  }
}

onMounted(() => {
  getPayloadList()
})
</script>