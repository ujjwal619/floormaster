<template>
  <div>
    <div class="row pl-3">
      <label>
        <input type="checkbox" v-model="quoteData.client_particulars" />
        <span class="pr-2">Copy Client Particulars</span>
      </label>
    </div>
    <div class="row mt-3 pl-3">
      <label>
        <input type="checkbox" v-model="quoteData.quote_text" />
        <span class="pr-2">Copy Quote Text</span>
      </label>
    </div>
    <div class="row mt-3 pl-3">
      <label>
        <input type="checkbox" v-model="quoteData.costing" />
        <span class="pr-2">Copy Costing</span>
      </label>
    </div>
  </div>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";

export default {
  name: "CopyQuote",
  components: {
    Modal
  },
  data: () => ({
    quoteData: {
      particulars: false,
      quote: false,
      costing: false
    }
  }),
  watch: {
    quoteData: {
      deep: true,
      handler(value) {
        this.$emit("copy", { ...value });
      }
    }
  }
};
</script>

