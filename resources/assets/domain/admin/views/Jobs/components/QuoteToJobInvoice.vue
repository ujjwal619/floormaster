<template>
  <modal title="Auto-Updates" @close="handleClose">
    <template slot="modal-body">
      <div class="row">
        <label class="col-3 text-right">Net Invoice $:</label>
        <div class="col-7">
          <input
            type="text"
            name="invoice amount"
            v-validate="'required'"
            v-model="model.invoice_amount"
          />
          <label class="error">{{ errors.first('invoice amount') }}</label>
        </div>
      </div>
      <div class="row">
        <label class="col-3 text-right">Invoice Date:</label>
        <div class="col-7">
          <input
            type="date"
            name="invoice date"
            v-validate="'required'"
            v-model="model.invoice_date"
          />
          <label class="error">{{ errors.first('invoice date') }}</label>
        </div>
      </div>
      <div class="row pt-3">
        <label class="col-7 m-auto">
          <input type="checkbox" v-model="model.invoice_job" />
          <span class="pr-1">Invoice Job</span>
        </label>
      </div>
      <div class="row pt-2">
        <label class="col-7 m-auto">
          <input type="checkbox" />
          <span class="pr-1">Print Costed JobSheet</span>
        </label>
      </div>
      <div class="row pt-2">
        <label class="col-7 m-auto">
          <input type="checkbox" />
          <span class="pr-1">Print Uncosted JobSheet</span>
        </label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="saveButtonClickHandler">Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Skip</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";

export default {
  name: "QuoteToJobInv",
  components: {
    Modal
  },
  props: {
    job: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    model: {
      invoice_amount: "",
      invoice_date: "",
      invoice_job: false
    }
  }),
  created() {
    this.model.invoice_amount = this.job.quote_price;
  },
  methods: {
    handleClose() {
      this.updateRecentlyConverted();
      this.$emit("close");
    },
    validate() {
      return this.$validator.validate();
    },
    saveButtonClickHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.handleSave();
        }
      });
    },
    handleSave() {
      if (this.model.invoice_job) {
        axios
          .post(`/jobs/${this.job.id}/invoice`, {
            amount: this.model.invoice_amount,
            date: this.model.invoice_date
          })
          .then(({ data }) => {
            this.$emit("modal:receipts", data.data.id);
            this.handleClose();
          })
          .catch(() => {
            console.log("could not save invoice");
          });
      } else {
        this.$emit("modal:receipts", 0);
        this.handleClose();
      }
    },
    updateRecentlyConverted() {
      axios
        .patch(`/api/jobs/${this.job.id}/recently-converted`)
        .then(() => {
          console.log("success");
        })
        .catch(() => {
          console.log("error");
        });
    }
  }
};
</script>

<style scoped>
</style>

