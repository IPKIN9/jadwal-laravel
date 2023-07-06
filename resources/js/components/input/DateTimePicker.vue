<template>
  <DateTimePicker :min-date="minDate" :max-date="maxDate" :clearable="false" utc format="dd/MM/yyyy" />
</template>

<script setup>
import DateTimePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { onMounted, ref, watch } from 'vue';
import moment from 'moment';

const props = defineProps({
  type: String,
  startDate: {
    type: String,
  },
  endDate: {
    type: String,
  },
  prevFormat: {
    type: String,
  },
});

const minDate = ref('');
const maxDate = ref('');

const count = () => {
  if (props.type == 'start') {
    if (props.endDate && props.endDate.length >= 1) {
      maxDate.value = moment(props.endDate).subtract(1, 'hours').format();
    } else {
      maxDate.value = null;
    }
  } else if (props.type == 'end') {
    if (props.startDate && props.startDate.length >= 1) {
      minDate.value = moment(props.startDate).add(6, 'hours').format();
    } else {
      minDate.value = null;
    }
  }
};

watch(props, (newProps) => {
  try {
    count();
  } catch (error) {
    console.log(error);
  }
});

onMounted(() => {
  count();
});
</script>