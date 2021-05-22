<template>
  <div key="payment-type">
    <div class="row">
      <label>If you want all remittance items defaulting to "Hold", select option then payment type</label>
    </div>
    <div class="row pt-4">
      <label class="col-4 text-right pr-2">Default Item Status</label>
      <label>
        <input type="radio" v-model="model.default_item_status" :value="1" name="default status" v-validate="'required'">
        Pay
      </label>
      <label class="pl-2">
        <input type="radio" v-model="model.default_item_status" :value="2" name="default status">
        Hold
      </label>
      <label class="error">{{ errors.first('default status') }}</label>
    </div>
  </div>
</template>

<script>

import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: 'PaymentType',
  components: {
    DropDown,
  },
  data: () => ({
    model: {
      default_item_status: 1,
    },
  }),
  watch: {
    model: {
      deep: true,
      immediate: true,
      handler(value) {
        return this.$emit('updated', value);
      }
    },
  },
}
</script>

