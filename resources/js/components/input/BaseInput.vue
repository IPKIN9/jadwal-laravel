<template>
  <label for="first-name-vertical">{{ label }} <small v-if="required" class="text-danger">*</small></label>
  <input type="text" class="form-control"
  v-bind="$attrs"
  :value="modelValue"
  @input="$emit('update:modelValue', $event.target.value)">
</template>
<script setup>

const props = defineProps({
label: {
  type: String,
  default: 'label input'
},
required: {
  type: Boolean,
  default: false
},
modelValue: [String, Number],
})
</script>