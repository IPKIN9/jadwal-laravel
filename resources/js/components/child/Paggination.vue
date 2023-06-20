<template>
  <div class="dataTable-bottom" v-show="totalPage > 1">
    <div class="dataTable-info mt-3">Showing {{ page }} to {{ totalPage }} of {{ total }} entries</div>
    <ul class="pagination pagination-primary float-end dataTable-pagination" style="margin-top: -20px !important;">
      <li class="page-item pager" :class="page <= 1 ? 'disabled' : ''"><a href="#" class="page-link" @click="clickTriger({n_page: 1, type: 'first'})">‹‹</a></li>
      <li class="page-item pager" :class="page <= 1 ? 'disabled' : ''"><a href="#" class="page-link" @click="clickTriger({n_page: page-1, type: 'min-1'})">‹</a></li>
      <li v-for="paginate in numberedPage" class="page-item" :class="paginate == page ? 'active' : ''">
        <a v-if="paginate <= totalPage && paginate >= 1" href="#" class="page-link" :data-page="paginate"  @click="clickTriger({n_page: paginate, type: 'current'})">{{ paginate }}</a>
      </li>
      <li class="page-item pager" :class="page < totalPage ? '' : 'disabled'"><a href="#" class="page-link" @click="clickTriger({n_page: page+1, type: 'plus-1'})">›</a></li>
      <li class="page-item pager" :class="page < totalPage ? '' : 'disabled'"><a href="#" class="page-link" @click="clickTriger({n_page: totalPage, type: 'latest'})">››</a></li>
    </ul>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';

  const props = defineProps({
    page : {
      type   : Number,
      default: 0
    },
    total: {
      type   : Number,
      default: 0
    },
    limit: {
      type   : Number,
      default: 0
    }
  })

  const totalPage = computed(() => {
    return Math.ceil(props.total / props.limit)
  })

  const numberPage = ref(props.page)
  const numberedPage = computed(() => {    
    return [numberPage.value, numberPage.value + 1, numberPage.value + 2]
  })

  const emits = defineEmits(['eventClick'])

  const clickTriger = (data) => {
    if (data.type == 'plus-1' && data.n_page == numberPage.value + 3) {
      numberPage.value = numberPage.value + 3
    } else if (data.type == 'min-1' && data.n_page == numberPage.value - 1) {
      numberPage.value = numberPage.value - 3
    } else if (data.type == 'latest') {
      numberPage.value = totalPage.value - 2
    } else if (data.type == 'first') {
      numberPage.value = 1
    }
    emits('eventClick', data)
    
  }
</script>