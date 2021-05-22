<template>
  <modal title="Add General Order Item" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label class="col-2 text-right">Product:</label>
        <div class="col-7">
          <input
            class="form-control"
            type="text"
            v-model="model.product_name"
            name="product"
            v-validate="'required'"
          />
          <label class="error">{{ errors.first('product') }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-2 text-right">Quantity:</label>
        <div class="col-7">
          <input
            class="form-control"
            type="number"
            v-model="model.quantity"
            name="quantity"
            v-validate="'required|decimal:2'"
          />
          <label class="error">{{ errors.first('quantity') }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-2 text-right">List Price $:</label>
        <div class="col-7">
          <input
            class="form-control"
            type="number"
            v-model="model.list_price"
            name="list price"
            v-validate="'required|decimal:2'"
          />
          <label class="error">{{ errors.first('list price') }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-2 text-right">Discount %:</label>
        <div class="col-7">
          <input
            class="form-control"
            type="number"
            v-model="model.discount"
            name="discount"
          />
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-2 text-right">Delivery $:</label>
        <div class="col-7">
          <input
            class="form-control"
            type="number"
            v-model="model.delivery"
            name="delivery"
          />
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-2 text-right">GST %:</label>
        <div class="col-7">
          <input
            class="form-control"
            type="number"
            v-model="model.tax"
            name="gst"
          />
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-2 text-right">&nbsp;</label>
        <div class="col-7">
          Enter Product, Quantity, List Price, Discount, Delivery and GST.
          <br/>
          <br/>
          Your Order Text is build from your inputs.
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" :disabled="loading" class="btn action-buttons" @click="goButtonHandler">Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from "../../../../common/mixins";
// import { getSites, getSuppliersBySite } from '../../../api/calls';

export default {
  name: "AddOrder",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    returnToAddCurrentOrderModal: {
      type: Boolean,
      default: false,
    },
    // defaultAccount: {
    //   type: Object,
    //   default: ({})
    // },
  },
  data: () => ({
    model: {
      
    },
  }),
  watch: {
  },
  created() {
  },
  methods: {
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          if (this.returnToAddCurrentOrderModal) {
            this.$emit('updated', this.model);
            this.$emit("close");
          }
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      if (this.returnToAddCurrentOrderModal) {
        this.$emit('updated');
      }
      this.$emit("close");
    }
  }
};
</script>
