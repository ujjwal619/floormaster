<template>
  <modal title="Edit Back Order" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label class="col-3 text-right">Client: </label>
        <input type="text" class="col-6 pl-2" v-model="model.client">
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Project: </label>
        <input type="text" class="col-6 pl-2" v-model="model.project">
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Quantity: </label>
        <input type="number" class="col-3 pl-2" v-model="model.amount">
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Placed: </label>
        <input type="date" class="col-4 pl-2" v-model="model.placed">
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Job:</label>
        <drop-down
          disabled
          v-model="model.job_id"
          :options="jobs"
          :default-selected="defaultSelectedJob"
          class="col-4 pl-2"
          label="job_id"
        />
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Required: </label>
        <input type="date" class="col-4 pl-2" v-model="model.date_required">
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Drop off: </label>
        <input type="text" class="col-3 pl-2" v-model="model.drop_off">
      </div>
    </template>
    <template slot="modal-footer">
      <button 
        v-if="backOrder.is_linked" 
        type="button" 
        class="btn action-buttons" 
        @click="unlinkHandler"
      >
        Unlink
      </button>
      <button 
        v-else
        type="button" 
        class="btn action-buttons" 
        @click="handleMakeAllocation"
      >
        Make into Allocation
      </button>
      <button type="button" class="btn action-buttons" @click="finishHandler">Finish</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../common/components/Modal/Modal";
import { LoadingMixin } from '../../../common/mixins';
import DropDown from '../../../common/components/DropDown/DropDown';
import { formatDate } from '../../../common/utitlities/helpers';

export default {
  name: "EditBackOrder",
  mixins: [LoadingMixin],
  components: {
    Modal,
    DropDown
  },
  props: {
    backOrder: {
      type: Object,
      required: true,
    },
    color: {
      type: Object,
      required: true,
    },
    jobs: {
      type: Array,
      required: true,
    },
  },
  data: () => ({
    model: {
      client: '',
      project: '',
      amount: '',
      placed: '',
      job_id: '',
      date_required: '',
      drop_off: '',
    },
  }),
  computed: {
    defaultSelectedJob() {
      return this.jobs.find(job => job.id === this.backOrder.job_id) || {};
    },
  },
  mounted() {
    this.model.client = this.backOrder.client;
    this.model.amount = this.backOrder.amount;
    this.model.project = this.backOrder.project;
    this.model.placed = this.backOrder.placed || formatDate(this.backOrder.created_at);
    this.model.date_required = this.backOrder.date_required;
    this.model.job_id = this.backOrder.job_id;
    this.model.drop_off = this.backOrder.drop_off;
  },
  methods: {
    finishHandler() {
      this.enableLoading();
      this.validate().then(valid => {
        if (valid) {
          axios.put(`/api/back-orders/${this.backOrder.id}`, this.model)
            .then(() => {
              this.$toastr('success', 'Back order updated successfully.', 'Success!!')
              window.location.href = `/color/${this.color.id}/stocks`;
            })
            .catch(() => {
              this.$toastr('error', 'Could not update back order.', 'Error!!')
            })
            .finally(() => {
              this.handleClose();
              this.disableLoading();
            })
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    },
    unlinkHandler() {
      this.$emit('unlink');
      this.handleClose();
    },
    handleMakeAllocation() {},
  }
};
</script>
