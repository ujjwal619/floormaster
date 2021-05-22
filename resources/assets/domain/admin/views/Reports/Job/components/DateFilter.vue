<template>
  <modal :title="title" @close="handleClose">
    <template slot="modal-body">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <label class="col-4 text-right">Start Date:</label>
            <div class="col-6 pl-1">
              <input type="date" v-model="model.start_date" name="start date" v-validate="'required'" class="form-control" >
              <label class="error">{{ errors.first('start date') }}</label>
            </div>
          </div>
          <div class="row pt-2">
            <label class="col-4 text-right">End Date:</label>
            <div class="col-6 pl-1">
              <input type="date" v-model="model.end_date" name="end date" v-validate="'required'" class="form-control" >
              <label class="error">{{ errors.first('end date') }}</label>
            </div>
          </div>
          <div class="row">
            <p><b>
              The Billing report differs from Sales report. Sales are reported at the
              Job level and do not necessarily reflect invoicing. This report draws from
              Billing, showing Invoices and Credits over the period you nominited.
            </b></p>
          </div>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="nextButtonHandler">Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../../common/components/Modal/Modal";

export default {
  name: "DateFilter",
  components: {
    Modal,
  },
  props: {
    currentReportType: {
      type: String,
      required: true,
    }
  },
  data: () => ({
    model: {},
  }),
  computed: {
    title() {
      const title = this.currentReportType.toLowerCase();
      return title[0].toUpperCase() + title.slice(1) + ' Report';
    },
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    nextButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('dateFiltered', {data: this.model, type: this.currentReportType});
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
