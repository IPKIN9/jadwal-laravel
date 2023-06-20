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


</script>