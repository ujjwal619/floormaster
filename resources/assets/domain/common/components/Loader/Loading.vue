<template>
  <div class="backdrop" v-if="loading" >
    <div class="loader"></div>
  </div>
</template>

<script>
export default {
  name: "Loading",
  props: {
    loading: {
      type: Boolean,
    },
  },
};
</script>

<style scoped>
.backdrop {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  z-index: 99;
  background-color: #dbdbdb;
  opacity: 0.9;
  display: flex;
  align-items: center;
  justify-content: center;
}
.loader {
  width: 50px;
  height: 50px;
  border: 6px solid #f3f3f3;
  border-top: 6px solid #3498db;
  border-radius: 50%;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
