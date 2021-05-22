<template>
  <modal title="Edit Allocation" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label class="col-3 text-right">Created: </label>
        <label class="col-4 pl-2">{{ allocation.created_at }}</label>
        <label></label>
      </div>
      <div class="row pt-2">
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
        <label class="col-3 text-right">Job:</label>
        <drop-down
          disabled
          v-model="model.job_id"
          :options="jobs"
          :default-selected="defaultSelectedJob"
          class="col-6 pl-1"
          label="job_id"
        />
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Required: </label>
        <input type="date" class="col-4 pl-2" v-model="model.date_required">
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Shop: </label>
        <drop-down
          disabled
          class="col-5 pl-2"
          :options="sites"
          :default-selected="defaultSelectedSite"
          v-model="model.site_id"
          style="max-height: 40px;"
        />
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Notes: </label>
        <textarea v-model="model.notes" cols="10" rows="2" class="col-8 pl-2" ></textarea>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Drop off: </label>
        <input type="text" class="col-3 pl-2" v-model="model.drop_off">
      </div>
    </template>
    <template slot="modal-footer">
      <button 
        v-if="allocation.is_linked" 
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
        @click="handleMakeBackOrder"
      >
        Make Back Order
      </button>
      <button type="button" class="btn action-buttons" @click="finishHandler">Finish</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../common/components/Modal/Modal";
import DropDown from "../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../common/mixins'
import { getSites, putAllocation } from '../../api/calls'

export default {
  name: "EditAllocation",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    allocation: {
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
      job_no: '',
      required: '',
      site_id: '',
      notes: '',
      drop_off: '',
    },
    sites: [],
  }),
  computed: {
    defaultSelectedJob() {
      return this.jobs.find(job => job.id === this.allocation.job_id) || {};
    },
    defaultSelectedSite() {
      return this.sites.find(site => site.id === this.allocation.site_id) || {};
    },
  },
  created() {
    this.fetchSites();
  },
  mounted() {
    this.model.client = this.allocation.client;
    this.model.amount = this.allocation.amount;
    this.model.project = this.allocation.project;
    this.model.job_id = this.allocation.job_id;
    this.model.notes = this.allocation.notes;
    this.model.date_required = this.allocation.date_required;
    this.model.drop_off = this.allocation.drop_off;
  },
  methods: {
    fetchSites() {
      this.enableLoading();
      getSites().then(({ data }) => {
        data.data.find(site => site.id === this.allocation.site_id) || {};
        this.sites = data.data;
      })
      .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
      .finally(this.disableLoading);
    },
    finishHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.enableLoading();
          return putAllocation(this.allocation.id, this.model)
            .then(() => {
              this.$toastr("success",`Successfully updated Allocation data`,"Success!!");
              window.location.reload();
              this.handleClose();
            })
            .catch(err => this.$toastr("error", "Could not get update allocation data.", "Error!!"))
            .finally(this.disableLoading);
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
    handleMakeBackOrder() {},
  }
};
</script>
