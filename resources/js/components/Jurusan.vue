<template>
  <div id="sidebar" class="active">
    <Sidebar />
  </div>
  <div id="main">
    <Header/>

    <div class="page-content">
      <section class="row">
        <section class="section">
          
        </section>
      </section>
    </div>
    
    <Footer/>
  </div>
</template>
<script setup>
import Sidebar from './child/Sidebar.vue';
import Footer from './child/Footer.vue'
import Header from './child/Header.vue'
import { reactive, onMounted } from 'vue'
import Jurusan from '../utils/api/jurusan'

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
      console.log(res);   
    })
    .catch((err) => {
      console.log(err);
    })
}

onMounted(() => {
  getPayloadList()
})
</script>