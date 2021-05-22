<template>
  <modal title="GST Inclusive Sell Price" @close="handleClose">
    <template slot="modal-body">
      <div class="row">
        <label class="col-7 text-right">Calculated GST Inclusive Job Price</label>
        <div class="col-5">
          <label>{{ currentPrice }}</label>
        </div>
      </div>
      <div class="row pt-3">
        <label class="col-7 text-right">Actual GST Inclusive Job Price</label>
        <div class="col-5">
          <input type="number" class="form-control" v-model="actualPrice" v-validate="'required'" name="price" />
          <label class="error">{{ errors.first('price') }}</label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="nextButtonHandler">Done</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>

import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: 'ForceJob',
  components: {
    DropDown,
    Modal,
  },
  props: {
    currentPrice: {
      type: Number,
      required: true,
    },
    inclusivePrice: {
      type: Number,
      default: 0,
    },
  },
  data: () => ({
    actualPrice: 0,
  }),
  created() {
    this.actualPrice = this.inclusivePrice;
  },
  methods: {
    handleClose() {
      this.$emit('close');
    },
    nextButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('forced', this.actualPrice);
          this.handleClose();
        }        
      });
    },
    validate() {
      return this.$validator.validate();
    },
  }
};
</script>
