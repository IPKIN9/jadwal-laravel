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
              <input v-model="payload.email" type="text" class="form-control form-control-xl" placeholder="Username">
              <div class="form-control-icon">
                <i class="bi bi-person"></i>
              </div>
              <small class="text-danger">
                {{ authError.email }}
              </small>
            </div>
            <!-- <p v-show="loginError.password" class="text-danger">Password {{ loginError.password }}</p> -->
            <div class="form-group position-relative has-icon-left mb-4">
              <input v-model="payload.password" type="password" class="form-control form-control-xl" placeholder="Password">
              <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
              </div>
              <small class="text-danger">
                {{ authError.email }}
              </small>
            </div>
            <button type="button" class="btn btn-primary btn-block btn-lg shadow-lg mt-5" :disabled="loading ? true : false" @click="getToken">Log in <Loading v-if="loading" /></button>
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
  @import url('../../../public/assets/css/pages/auth.scoped.css');

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
import axios from 'axios'
import IziToast from '../utils/other/izitoast'
import Loading from './child/Loading.vue'
import AuthCheck from '../utils/other/authcheck'

const loading = ref(false)

const payload = reactive({
  email   : '',
  password: ''
})

const authError = ref('');

const getToken = async (csrf) => {
  try {
    const payloadSchema = Yup.object().shape({
      email: Yup.string()
        .required(     'Inputan harus diisi'                       )
        .min     (2,   'Inputan minimal terdiri dari 2 karakter'   )
        .max     (150, 'Inputan maksimal terdiri dari 150 karakter'),
      password: Yup.string()
        .required(    'Inputan harus diisi'                       )
        .min     (4,  'Inputan minimal terdiri dari 2 karakter'   )
        .max     (20, 'Inputan maksimal terdiri dari 150 karakter'),
    });

    await payloadSchema.validate(payload, { abortEarly: false });

    loading.value = true

    axios.post('/api/v1/oauth/token', payload)
    .then((res) => {
      loading.value = false
      let token = res.data.token
      let scope = AuthCheck.createJwtToken(res.data.scope)

      // setToken(token, scope)
    })
    .catch((err) => {
      console.log(err);
      loading  .value = false
      if (err.response) {
        IziToast.errorNotif(err.response.status)
      } else {
        IziToast.errorNotif(900)
      }
    })
  } catch (e) {
    console.log(e);
    loading  .value = false
    const errorMessages = e.inner.reduce((errors, error) => {
      errors[error.path] = error.message;
      return errors;
    }, {});
    authError.value = errorMessages;
  }
}
</script>