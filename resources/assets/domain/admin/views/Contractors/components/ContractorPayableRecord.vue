<template>
  <modal :title="`${this.isEditMode ? 'Edit' : 'Add'} Contractor Payable Record`" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="form-group row">
        <div class="col-lg-12">
          <div class="row pb-2">
            <label class="col-lg-3" style="text-align: right">Job:</label>
            <div class="col-lg-5" v-if="!isEditMode">
              <drop-down :options="jobs" v-model="id" label="job_id" name="job" v-validate="'required'"/>
              <label class="error">{{ errors.first('job') }}</label>
            </div>
            <div class="col-lg-5" v-else>
              <label class="error">{{ payableData.job.job_id }}</label>
            </div>
          </div>
          <div class="row pb-2">
            <label class="col-lg-3" style="text-align: right">Client:</label>
            <input class="col-lg-7 form-control" type="text" v-model="model.client">
          </div>
          <div class="row pb-2">
            <label class="col-lg-3" style="text-align: right">Project:</label>
            <input class="col-lg-9 form-control" type="text" v-model="model.project">
          </div>
          <div class="row pb-2">
            <label class="col-lg-3" style="text-align: right">Details:</label>
            <input class="col-lg-7 form-control" type="text" v-model="model.details">
          </div>
          <div class="row pb-2">
            <label class="col-lg-3" style="text-align: right">Amount:</label>
            <input 
              v-if="!isEditMode" 
              class="col-lg-4 form-control" 
              type="number" 
              v-model="model.amount" 
              name="amount" 
              v-validate="'required|decimal:2'"
            >
            <label v-else>${{ payableData.amount }}</label>
            <label class="error">{{ errors.first('amount') }}</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-3" style="text-align: right">GST %:</label>
            <input v-if="!isEditMode" class="col-lg-3 form-control" type="number" v-model="model.gst">
            <label v-else>{{ payableData.gst }}</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-3" style="text-align: right">Date:</label>
            <input 
              v-if="!isEditMode" 
              class="col-lg-4 form-control" 
              type="date" 
              v-model="model.date"
              name="date"
              v-validate="{ required: true, date_between: dateRangeForValidation }"
            />
            <label v-else>{{ payableData.date }}</label>
            <label
              class="error"
              v-if="errors.firstByRule('date', 'required')"
            >The date field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('date', 'date_format')"
            >The date field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('date', 'date_between')"
            >The date field must be between {{ startDate }} and {{ endDate }}.</label>
            <label v-else>{{ payableData.date }}</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-3" style="text-align: right">Con InvNo:</label>
            <input class="col-lg-4 form-control" type="text" v-model="model.invoice_no">
          </div>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="handleSave"
      >{{ isEditMode ? 'Update' : 'Add' }}</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import axios from "axios";
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin, CurrentUserMixin } from '../../../../common/mixins'
import { format } from 'date-fns';
import {
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
  formatViewDate
} from "../../../../common/utitlities/helpers";
import { getJobs } from '../../../api/calls';

export default {
  name: "ContractorPayableRecord",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    contractor: {
      type: Object,
      required: true,
    },
    payableData: {
      type: Object,
      default: () => ({})
    }
  },
  data: () => ({
    id: null,
    model: {
      job_id: "",
      client: "",
      project: "",
      details: "",
      amount: "",
      gst: "",
      date: format(new Date(), 'yyyy-MM-dd'),
      invoice_no: ""
    },
    jobs: [],
  }),
  computed: {
    isEditMode() {
      return !!this.payableData.id;
    },
    startDate() {
      const startDate = this.isSuperAdmin ? getFiscalYear() : getCurrentMonth();
      return formatViewDate(startDate);
    },
    endDate() {
      const endDate = this.isSuperAdmin ? getFiscalYear('end') : getCurrentMonth('end');
      return formatViewDate(endDate);
    },
    dateRangeForValidation() {
      return this.isSuperAdmin ? getFiscalYearDateRangeForValidation() : getMonthRangeForValidation();
    },
  },
  watch: {
    id: {
      handler(value) {
        const selectedJob = this.jobs.find(job => job.id === value);
        if (selectedJob) {
          this.model.job_id = selectedJob.id;
          this.model.client = selectedJob.trading_name;
          this.model.project = selectedJob.project;
        }
      }
    },
    payableData: {
      handler(value) {
        if (payableData) {
          this.model.details = value.details;
          this.model.client = value.client;
          this.model.project = value.project;
          this.model.invoice_no = value.invoice_no;
          this.model.job_id = value.job.id;
          this.model.amount = value.amount;
        }
      }
    }
  },
  created() {
    this.fetchJobs();
    if (this.isEditMode) {
      this.model = { ...this.payableData };
    }
    this.model.gst = this.contractor.site.gst;
  },
  methods: {
    fetchJobs() {
      this.enableLoading();
      getJobs({site_id: this.contractor.site_id})
        .then(({data}) => {
          this.jobs = data.data;
        })
        .catch(() => {
          console.log('could not fetch jobs.')
        })
        .finally(this.disableLoading);
    },
    handleClose() {
      this.$emit("close");
    },
    handleSave() {
      this.validate().then(valid => {
        if (valid) {
          this.savePayable();
        }
      });
    },
    validate() {
      return this.$validator.validateAll();
    },
    savePayable() {
      const payload = this.model;
      const method = this.isEditMode ? 'put' : 'post';
      const text = this.isEditMode ? 'update' : 'save';
      const url = this.isEditMode ? `/api/contractors/${this.contractor.id}/payments/${this.payableData.id}` : `/contractors/${this.contractor.id}/payments`;

      this.enableLoading();
      axios[method](url, { ...payload })
        .then(() => {
          this.$toastr(
            "success",
            `Successfully ${text}d the payable due record.`,
            "Success!!"
          );
          window.location.href = `/contractors/${this.contractor.id}/edit`;
        })
        .catch(() => {
          this.$toastr(
            "error",
            `Could not ${text}d the payable due record.`,
            "Error!!"
          );
        })
        .finally(() => this.disableLoading());
    }
  }
};
</script>
