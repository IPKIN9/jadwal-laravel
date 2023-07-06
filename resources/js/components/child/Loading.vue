<template>
  <img class="img-loading" :src="loadingImg" alt="">
</template>
<style scoped>
.img-loading{
  height: 20px;
  widows: auto;
}
</style>
<script setup>
import loadingImg from '../../../../public/assets/images/Loading.gif'
</script>