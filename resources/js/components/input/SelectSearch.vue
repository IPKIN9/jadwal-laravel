<template>
  <label class="from-label">{{ label }} <small v-if="required" class="text-danger">*</small></label>
  <div class="form-group mb-2 position-relative has-icon-right">
    <input v-bind="$attrs" @focusin="getWidth()" :id="idElement.search" type="text" class="form-control"
      placeholder="---Cari disini---" v-model="searchPayload" @keyup="searchData()" @focus="searchData()"
      autocomplete="off">
    <div v-show="list.length >= 1 || searchPayload.length >= 1" class="form-control-icon">
      <a role="button" @click="clearInput()" class="fa-solid fa-xmark text-danger"></a>
    </div>
  </div>
  <TransitionGroup :id="idElement.select" name="selectsearch" tag="select" v-show="list.length >= 1 && showList"
    class="form-select select-search" v-bind="$attrs" :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)">
    <option v-for="(ls, index) in list" :key="index" :value="ls[showUp.key]" class="text-capitalize"
      @click="setNameValue(ls[showUp.name])">{{ ls[showUp.name] }}</option>
  </TransitionGroup>
</template>
<style>
.selectsearch-enter-active {
  transition: all 0.1s ease;
}

.selectsearch-enter-active {
  transition-delay: 0.1s;
}

.selectsearch-enter-from,
.selectsearch-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

.selectsearch {
  overflow: hidden;
}

.select-search {
  position: absolute;
}
</style>
<script setup>
import { ref } from 'vue';

const props = defineProps({
  label: {
    type: String,
    default: 'Text input'
  },
  list: {
    type: [Object, Array],
    default: []
  },
  showUp: {
    type: Object,
    default: {
      key: 'id',
      name: 'nama'
    }
  },
  modelValue: [String, Number],
  required: {
    type: Boolean,
    default: false
  },
  idElement: {
    type: Object,
    default: {}
  }
})

const emits = defineEmits(['searchEvent', 'update:modelValue', 'clearData', 'setName'])

const getWidth = async () => {
  let width = document.getElementById(props.idElement.search)?.offsetWidth
  let selectSearch = document.getElementById(props.idElement.select)
  selectSearch.style.width = `${width}px`

  showList.value = true
};

const searchPayload = ref('')

const searchData = () => {
  emits('searchEvent', searchPayload.value)
}

const setNameValue = (name) => {
  searchPayload.value = name
  emits('setName', name)
}

const clearInput = () => {
  emits('clearData')
  showList.value = false
  searchPayload.value = ''
}

const showList = ref(false)

</script>