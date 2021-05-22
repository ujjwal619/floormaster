<template>
  <div>
    <div class="row pl-3">
      <label>
        <input type="checkbox" v-model="jobData.client_particulars" />
        <span class="pr-2">Copy Client Particulars</span>
      </label>
    </div>
    <div class="row mt-3 pl-3">
      <label>
        <input type="checkbox" v-model="jobData.job_text" />
        <span class="pr-2">Copy Job Text</span>
      </label>
    </div>
    <div class="row mt-3 pl-3">
      <label>
        <input type="checkbox" v-model="jobData.costing" />
        <span class="pr-2">Copy Costing</span>
      </label>
    </div>
  </div>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";

export default {
  name: "CopyJob",
  components: {
    Modal
  },
  data: () => ({
    jobData: {
      particulars: false,
      job: false,
      costing: false
    }
  }),
  watch: {
    jobData: {
      deep: true,
      handler(value) {
        this.$emit("copy", { ...value });
      }
    }
  }
};
</script>

