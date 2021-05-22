<template>
  <div key="payment-type">
    <div class="row">
      <label class="col-4 text-right pr-2">Auto/Manual</label>
      <div class="col-7">
        <drop-down
          v-model="model.remittance_type"
          :options="options"
          v-validate="'required'"
          name="auto/manual"
        />
        <label class="error">{{ errors.first('auto/manual') }}</label>
      </div>
    </div>
    <div class="row pt-2">
      <label>If you want all remittance items defaulting to "Hold", select option then payment type</label>
    </div>
    <div class="row pt-2">
      <label class="col-4 text-right pr-2">Default Item Status</label>
      <label>
        <input type="radio" v-model="model.default_item_status" :value="$options.PAY" name="default status" v-validate="'required'">
        Pay
      </label>
      <label class="pl-2">
        <input type="radio" v-model="model.default_item_status" :value="$options.HOLD" name="default status">
        Hold
      </label>
      <label class="error">{{ errors.first('default status') }}</label>
    </div>
  </div>
</template>

<script>

import DropDown from "../../../../common/components/DropDown/DropDown";

const PAY = 1;
const HOLD = 2;

export default {
  name: 'PaymentType',
  components: {
    DropDown,
  },
  PAY,
  HOLD,
  props: {
    payable: {
      type: Number,
      required: true,
    },
  },
  data: () => ({
    model: {
      default_item_status: PAY,
      remittance_type: '',
    },
    options: [
      { id: 1, name: 'Auto Pay' },
      { id: 2, name: 'Manual Pay' },
    ]
  }),
  watch: {
    model: {
      deep: true,
      handler(value) {
        return this.$emit('updated', value);
      }
    },
    payable: {
      immediate: true,
      handler(value) {
        if(value > 0) {
          this.options.push({id: 3, name: 'Pay This Record'});
        }
      }
    },
  },
}
</script>

