<template>
  <div id="auth">

    <div class="row h-100">
      <div class="col-lg-5 col-12 shadow">
        <div id="auth-left" class="mt-5">
          <div class="auth-logo">
           
          </div>
          <h1 class="auth-title">Log in.</h1>
          <p class="auth-subtitle mb-5">Silahkan masukan username dan password.</p>

          <form action="#">
            <!-- <p v-show="loginError.username" class="text-danger">Username {{ loginError.username }}</p> -->
            <div class="form-group position-relative has-icon-left mb-4">
              <input type="text" class="form-control form-control-xl" placeholder="Username">
              <div class="form-control-icon">
                <i class="bi bi-person"></i>
              </div>
            </div>
            <!-- <p v-show="loginError.password" class="text-danger">Password {{ loginError.password }}</p> -->
            <div class="form-group position-relative has-icon-left mb-4">
              <input type="password" class="form-control form-control-xl" placeholder="Password">
              <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
              </div>
            </div>
            <button type="button" class="btn btn-primary btn-block btn-lg shadow-lg mt-5" @click="">Log in</button>
          </form>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="title-info text-center">
          <a href="#"><img src="../../../public/assets/images/logo/logosmkn2palu.png" alt="Logo"
              style="height: 110px;"></a>
          <p>Sistem Informasi Penjadwalan</p>
          <h4>SMK Negeri 2 Palu</h4>
        </div>
        <iframe id="myIframe" src="https://embed.lottiefiles.com/animation/124048"></iframe>
      </div>
    </div>

  </div>
</template>
<style scoped>
  @import url('../../../public/assets/css/pages/auth.css');
  #myIframe{
    all: unset;
    position: absolute;
    top: 15%;
    right: 10%;
    width: calc(85% - 50%);
    height: 85%;
    border: none;
    background-color: transparent;
    mix-blend-mode: multiply;
  }
  .title-info{
    margin-top: 5.5%;
    margin-left: 5%;
  }
  .title-info p{
    font-size: 21pt;
    margin-top: 15px;
  }
  .title-info h4{
    margin-top: -15px;
    font-size: 40pt;
    text-transform: uppercase;
    font-weight: 800;
  }
</style>
<script setup>
import { reactive, ref } from 'vue';
import * as Yup from 'yup'
</script>