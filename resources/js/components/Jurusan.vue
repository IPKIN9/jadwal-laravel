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
                <h3>TABEL JURUSAN</h3>
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
                        <th style="width: 41.862%;"><a @click="sortingData(meta.sort, '_jurusan')" href="#"
                            class="dataTable-sorter"><i class="fa-solid me-1" :class="meta.sortIcon._jurusan"></i> Nama</a></th>
                        <th style="width: 18.8881%;"><a @click="sortingData(meta.sort, 'created_at')" href="#"
                            class="dataTable-sorter"><i class="fa-solid me-1" :class="meta.sortIcon.created_at"></i> Dibuat</a>
                        </th>
                        <th style="width: 16.3429%;"><a href="#" class="dataTable-sorter">Diupdate</a></th>
                        <th style="width: 11.1186%;"><a href="#" class="dataTable-sorter">Aksi</a></th>
                      </tr>
                    </thead>
                    <TransitionGroup name="table" tag="tbody">
                      <tr v-for="(jurusan, index) in payloadList" :key="index">
                        <td>{{ index + 1 }}.</td>
                        <td class="text-capitalize">{{ jurusan._jurusan }}</td>
                        <td>{{ moment(jurusan.created_at).format('DD, MMMM YYYY') }}</td>
                        <td>{{ moment(jurusan.updated_at).format('DD, MMMM YYYY') }}</td>
                        <td>
                          <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <BaseButton :data-id="jurusan.id" :row-data="payloadList[index]" @event-click="editPayload"
                              class="btn"><i class="text-primary fas fa-pencil mx-2"></i></BaseButton>
                            <BaseButton :data-id="jurusan.id" class="btn" @event-click="deletePayload"><i
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
        <div class="form-group mb-3">
          <BaseInput label="Nama Jurusan" :required="true" v-model="payload._jurusan" placeholder="Masukan disini..." />
          <small class="text-danger">
            {{ jurusanError }}
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
<script setup>
import Sidebar from './child/Sidebar.vue';
import Footer from './child/Footer.vue'
import Header from './child/Header.vue'

import { onMounted, reactive, ref } from 'vue'
import Jurusan from '../utils/api/jurusan'
import moment from 'moment'
import Paggination from './child/Paggination.vue'
import BaseButton from './input/BaseButton.vue'
import ModalComponent from './child/ModalComponent.vue'
import IziToast from '../utils/other/izitoast.js'
import BaseInput from './input/BaseInput.vue'
import * as Yup from 'yup'
import Loading from './child/Loading.vue'
import SweetAlert from '../utils/other/sweetalert'

const loading = ref(false)
/* Fungsi untuk mengambil data jurusan */
const payloadList = ref()

const meta = reactive({
  sortIcon: {
    _jurusan  : 'fa-sort'   ,
    created_at: 'fa-sort-up'
  },
  search       : "",
  limit        : 10,
  page         : 1,
  total        : 10,
  orderBy      : "created_at",
  sort         : "desc",
  total_in_page: 10
})

const getPayloadList = () => {
  Jurusan.getAll(meta)
    .then((res) => {
      let item           = res.data
      payloadList.value  = item.data
      meta.total         = item.meta.total
      meta.page          = item.meta.page
      meta.total_in_page = item.meta.total_in_page      
    })
    .catch((err) => {
      if (err.response) {
        IziToast.errorNotif(err.response.status)
      } else {
        IziToast.errorNotif(900)
      }
    })
}

/* Tambah data function */

const payload = reactive({
  _jurusan: ''
})

const jurusanError = ref('');

const upsertPayload = async () => {
  loading.value = true
  try {
    const payloadSchema = Yup.object().shape({
      _jurusan: Yup.string()
        .required('Inputan harus diisi')
        .min(2, 'Inputan minimal terdiri dari 2 karakter')
        .max(150, 'Inputan maksimal terdiri dari 150 karakter'),
    });

    await payloadSchema.validate(payload, { abortEarly: false });

    Jurusan.upsert(payload)
      .then((res) => {
        loading.value = false
        showHideModal({ type: '' })
        IziToast.successNotif({
          title: 'Tersimpan',
          message: 'Berhasil menyimpan data ke database'
        })
      })
      .catch((err) => {
        if (err.response) {
          IziToast.errorNotif(err.response.status)
        } else {
          IziToast.errorNotif(900)
        }
        console.log(err);
      })

  } catch (err) {
    const errorMessages = err.inner.map((error) => error.message);

    jurusanError.value = errorMessages.join(' | ');
  }
}

/* Fungsi untuk mengedit data */
const editPayload = (params) => {
  let rowData = params.rowData
  for (const key in rowData) {
    if (key === 'created_at' || key === 'updated_at') {
      continue
    }
    payload[key] = rowData[key]
  }

  showHideModal({ type: 'editedData' })
}

/* Fungsi untuk menghapus data */
const deletePayload = (params) => {
  SweetAlert.confirmNotif(() => {
    Jurusan.delete(params.dataId)
      .then((res) => {
        IziToast.successNotif({
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
          IziToast.errorNotif(err.response.status)
        } else {
          IziToast.errorNotif(900)
        }
      })
  })
}

const paggination = (data) => {
  meta.page = data.n_page
  getPayloadList()
}

/* Menampilkan modal */
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

/* Sorting data */
const sortingData = (sort, by) => {

if (sort == 'asc') {
  meta.orderBy = by
  meta.sort = 'desc'
  meta.sortIcon[by] = 'fa-sort-up'
} else if (sort == 'desc') {
  meta.orderBy = by
  meta.sort = 'asc'
  meta.sortIcon[by] = 'fa-sort-down'
}

if (by === '_jurusan') {
  meta.sortIcon.created_at = 'fa-sort'
} else if (by === 'created_at') {
  meta.sortIcon._jurusan = 'fa-sort'
}

getPayloadList()
}

/* Fungsi untuk membersihkan daftar payload */
const clearPayload = () => {
payload._jurusan = ''
jurusanError.value = ''
if ('id' in payload) {
  delete payload.id
}
}

onMounted(() => {
  getPayloadList()
})
</script>