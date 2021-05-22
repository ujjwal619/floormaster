<template>
</template>

<script>
  import Modal from '../../../common/components/Modal/Modal'

  export default {
    name: "MemoAlert",
    props: {
      count: {type: Number, default: 0}
    },
    data() {
      return {
        showModal: false
      }
    },
    created() {
      if (this.count > 0) {
        this.showModal = true;
      }
    },
    components: {
      Modal
    },
    methods: {
      goToMemos(){
        location.href = '/memos';
      }
    }
  }
</script>
