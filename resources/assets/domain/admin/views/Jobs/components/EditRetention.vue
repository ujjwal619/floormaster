<template>
  <modal title="Unbilled Retention" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <label>{{ job.job_id }}</label>
      <label>{{ fullName }}</label>
      <div class="row">
        <label class="col-7 text-right">Retention Amount: </label>
        <div class="col-5">
          <input type="number" v-model="model.unbilled_retention_amount">
        </div>
      </div>
      <div class="row pt-3">
        <label class="col-7 text-right">Release Date: </label>
        <div class="col-5">
          <input type="date" class="form-control" v-model="model.unbilled_retention_release_date" v-validate="'required'" />
        </div>
      </div>
      <p>
        Record andy unbilled retention held against this Job here.
        If you have issued an invoice and retention has been held against it
        then go to that invoice and record the retention there.
      </p>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="nextButtonHandler">Done</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>

import Modal from "../../../../common/components/Modal/Modal";
import { LoadingMixin } from "../../../../common/mixins/index";

export default {
  name: 'EditRetention',
  mixins: [LoadingMixin],
  components: {
    Modal,
  },
  props: {
    job: {
      type: Object,
      required: true
    },
  },
  data: () => ({
    model: {},
  }),
  computed: {
    fullName() {
      return this.job.title + ' ' + this.job.firstname + ' ' + this.job.trading_name;
    },
  },
  created() {
    this.model.unbilled_retention_amount = this.job.unbilled_retention_amount;
    this.model.unbilled_retention_release_date = this.job.unbilled_retention_release_date;
  },
  methods: {
    handleClose() {
      this.$emit('close');
    },
    nextButtonHandler() {
      this.enableLoading();
      axios.put(`/api/jobs/${this.job.id}/update-retention`, this.model)
      .then(() => {
        this.$emit('updated');
      })
      .catch(() => {
        this.$toastr('error', 'Could not update retention.');
      })
      .finally(() => {
        this.handleClose();
        this.disableLoading();
      });
    },
    validate() {
      return this.$validator.validate();
    },
  }
};
</script>
