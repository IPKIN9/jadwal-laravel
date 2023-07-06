<template>
  <label class="from-label">{{ label }} <small v-if="required" class="text-danger">*</small></label>
  <div class="form-group mb-2 position-relative has-icon-right">
    <input :id="idElement.search" @click="getWidth" type="text" class="form-control" placeholder="---Cari disini---"
      v-model="searchPayload" @keyup="searchData()" @focus="searchData()" autocomplete="off">
    <div v-show="list.length >= 1 || searchPayload.length >= 1" class="form-control-icon">
      <a role="button" @click="clearInput()" class="fa-solid fa-xmark text-danger"></a>
    </div>
  </div>
  <TransitionGroup :id="idElement.select" name="selectsearch" tag="select" v-show="list.length >= 1 && showList"
    class="form-select select-search" v-bind="$attrs" :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)">
    <option v-for="(ls, index) in list" :key="index" :value="ls[showUp.key]"
      :class="checkDataExists(ls[showUp.key], formatDate(tgl)) ? 'text-muted' : ''" class="text-capitalize"
      @click="() => { setNameValue(ls[showUp.name]); checkVisibilityButton(ls[showUp.key], formatDate(tgl)) }">{{
        ls[showUp.name] }}</option>
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

.hidden {
  display: none;
}

.select-search {
  position: absolute;
}
</style>
<script setup>
import { reactive, ref } from 'vue';

const props = defineProps({
  label: {
    type: String,
    default: 'Text input'
  },
  list: {
    type: [Object, Array],
    default: []
  },
  listSchedule: {
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
  tgl: {
    type: String,
    default: ''
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

const emits = defineEmits(['searchEvent', 'update:modelValue', 'clearData', 'setName', 'visibleButton'])

const searchPayload = ref('')

const getWidth = async () => {
  let width = document.getElementById(props.idElement.search)?.offsetWidth
  let selectSearch = document.getElementById(props.idElement.select)
  selectSearch.style.width = `${width}px`

  showList.value = true
};

const searchData = () => {
  emits('searchEvent', searchPayload.value)
}

const checkDataExists = (id, tgl) => {
  // return props.listSchedule.some((item: { guru_id }) => item.guru_id === id);
  const filteredData = props.listSchedule.filter((item) => item.guru_id === id && item.tgl === tgl);

  return filteredData.length;
}

const formatDate = (date) => {
  const [year, month, day] = date.split("-");
  const formattedMonth = month.padStart(2, "0");
  const formattedDay = day.padStart(2, "0");
  return `${year}-${formattedMonth}-${formattedDay}`;
}

const showList = ref(false)

const setNameValue = (name) => {
  searchPayload.value = name
  emits('setName')

  showList.value = false
}

const checkVisibilityButton = (id, tgl) => {
  const filteredData = props.listSchedule.filter((item) => item.guru_id === id && item.tgl === tgl);
  for (const item of filteredData) {
    if (item.jam_masuk === "07:15:00") {
      visibleButton.sesi1 = false
    }
    if (item.jam_masuk === "11:16:00") {
      visibleButton.sesi2 = false
    }
  }

  emits('visibleButton', visibleButton)
}

const clearInput = () => {
  emits('clearData')
  showList.value = false
  searchPayload.value = ''
  visibleButton.sesi1 = true
  visibleButton.sesi2 = true
}

const visibleButton = reactive({
  sesi1: true,
  sesi2: true
})
</script>