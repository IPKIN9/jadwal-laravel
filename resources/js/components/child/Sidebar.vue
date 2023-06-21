<template>
  <div class="sidebar-wrapper active">
    <div class="sidebar-header">
      <div class="d-flex justify-content-center">
        <div class="logo text-center">
          <a href="#"><img src="../../../../public/assets/images/logo/logosmkn2palu.png" alt="Logo" style="height: 70px;" /> <p style="margin-top: 12px; font-size: 21pt; font-weight: 800;">SMKN 2 PALU</p></a>
        </div>
        <div class="toggler">
          <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
        </div>
      </div>
    </div>
    <div class="sidebar-menu">
      <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item" :class="getCurrentLocation('/') ? 'active' : ''">
          <a href="/" class="sidebar-link">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Jadwal</span>
          </a>
        </li>
        <li class="sidebar-item" :class="getCurrentLocation('/pangkat') ? 'active' : ''">
          <a href="/pangkat" class="sidebar-link">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Pangkat</span>
          </a>
        </li>
        <li class="sidebar-item" :class="getCurrentLocation('/jurusan') ? 'active' : ''">
          <a href="/jurusan" class="sidebar-link">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Jurusan</span>
          </a>
        </li>
        <li class="sidebar-item" :class="getCurrentLocation('/mapel') ? 'active' : ''">
          <a href="/mapel" class="sidebar-link">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Mata Pelajaran</span>
          </a>
        </li>
        <li class="sidebar-item" :class="getCurrentLocation('/kelas') ? 'active' : ''">
          <a href="/kelas" class="sidebar-link">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Kelas</span>
          </a>
        </li>
        <li class="sidebar-item" :class="getCurrentLocation('/guru') ? 'active' : ''">
          <a href="/guru" class="sidebar-link">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Guru</span>
          </a>
        </li>
        <li class="sidebar-item" :class="getCurrentLocation('/report') ? 'active' : ''">
          <a href="/report" class="sidebar-link">
            <i class="fa-solid fa-download"></i>
            <span>Export</span>
          </a>
        </li>
      </ul>
    </div>
    <div style="margin-top: 230px;" class="text-center">
      <BaseButton class="btn-danger rounded">Logout <i class="fas fa-power-off"></i></BaseButton>
    </div>
  </div>
</template>

<script setup>
import BaseButton from '../input/BaseButton.vue';

const getCurrentLocation = (route) => {
  return window.location.pathname == route
}
</script>