<template>
  <modal title="Convert Quote to Job" @close="handleClose">
    <template slot="modal-body">
      <div class="row">
        <label>
          Below is the existing Quote Number. If you wish to use a new <br>
          Job Number then enter the required number in the box below.
        </label>
      </div>
      <div class="row pt-3">
        <label class="col-4 text-right">Enter Initiation Date: </label>
        <div class="col-4">
          <input
            type="date"
            class="form-control"
            name="initiation date"
            v-validate="'required'"
            v-model="model.initiation_date"
          />
          <label class="error">{{ errors.first('initiation date') }}</label>
        </div>
      </div>
      <div class="row pt-3">
        <label class="col-4 text-right">Existing Quote Number: </label>
        <span class="col-8 pl-2 h5">{{ quote.site.quote_prefix + '' + quote.quote_id }}</span>
      </div>
      <div class="row pt-3">
        <label class="col-4 text-right">New Job Number: </label>
        <span class="col-1 pl-4">{{ quote.site.quote_prefix }}</span>
        <input
          class="col-3 form-control"
          type="text"
          v-model="model.new_job_no"
          v-validate="`required|numeric|between:${quote.site.quote_number_from},${quote.site.quote_number_to}`"
          name="new job no"
        />
        <label class="error">{{ errors.first('new job no') }}</label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleSaveWithNewJob">Use New No.</button>
      <button type="button" class="btn action-buttons" @click="handleSave">Use Existing</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import { formatDate } from "../../../../common/utitlities/helpers";

export default {
  name: "UpdateQuoteModal",
  components: {
    Modal
  },
  props: {
    quote: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    model: {
      job_id: "",
      initiation_date: formatDate(),
    }
  }),
  created() {},
  methods: {
    handleClose() {
      this.$emit("close");
    },
    validate() {
      return this.$validator.validate();
    },
    handleSaveWithNewJob() {
      this.validate().then(valid => {
        if (valid) {
          this.sendUpdateRequest();
        }
      });
    },
    handleSave() {
      this.model.new_job_no = null;
      this.sendUpdateRequest();
    },
    sendUpdateRequest() {
      axios
        .post(`/api/quotes/${this.quote.id}/convert-to-job`, { ...this.model })
        .then(({ data }) => {
          this.$toastr("success", "Converted to Job Successfully", "Success!!");
          location.href = "/jobs";
        })
        .catch(({ response }) => {
          if (response.data.errors.hasOwnProperty('new_job_no')) {
            this.errors.add({
              field: 'new job no',
              msg: 'The entered job no already exists.'
            })
          }
          this.$toastr("error", "Error in Converting to Job", "Error!!");
        });
    }
  }
};
</script>
