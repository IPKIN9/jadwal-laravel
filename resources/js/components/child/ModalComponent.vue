<template>
  <div>
    <transition name="modal">
      <div v-if="isModalOpen" class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container" :class="size">
            <div class="modal-header">
              <slot name="header">
              </slot>
            </div>
            <div class="modal-body">
              <slot name="body">
              </slot>
            </div>
            <div class="modal-footer">
              <slot name="footer"></slot>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  size: {
    type: String,
    default: 'modal-md',
  },
  isModalOpen: {
    type: Boolean,
    default: false
  }
})
</script>

<style scoped>
.modal-mask {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  transition: opacity 0.3s;
}

.modal-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: opacity 0.3s;
}

.modal-container {
  background-color: #fff;
  border-radius: 4px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  max-width: 90%;
  box-sizing: border-box;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  max-height: 95%;
  overflow-y: auto;
}

.modal-enter-active,
.modal-leave-active {
  opacity: 1;
}

.modal-enter,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .modal-wrapper,
.modal-leave-active .modal-wrapper {
  transition: opacity 0.3s, transform 0.3s;
}

.modal-enter .modal-wrapper,
.modal-leave-to .modal-wrapper {
  opacity: 1;
}

.modal-sm {
  width: 300px;
}

.modal-md {
  width: 500px;
}

.modal-lg {
  width: 900px;
}

.modal-xl {
  width: 1500px;
}

.modal-header {
  padding: 16px;
  border-bottom: 1px solid #ddd;
}

.modal-title {
  margin: 0;
}

.modal-body {
  padding: 16px;
}

.modal-footer {
  padding: 16px;
  text-align: right;
  border-top: 1px solid #ddd;
}

</style>