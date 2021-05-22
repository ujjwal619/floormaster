<template>
  <modal title="Contractor Payment Allocation" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div>
        <label>${{netLabourCost}} Net Labour Costing.</label>
        <label>${{netLabourAllocated}} Net Labour Allocated.</label>
        <label>${{netPayable}} Net is Payable, Pro-Rata</label>
      </div>
      <div class="row">
        <label class="col-3">Net Amount:</label> 
        <input class="col-6 form-control" type="number" name="net amount" v-model="model.amount" v-validate="'required'">
        <label class="col-3">before gst</label> 
        <label class="error">{{ errors.first('net amount') }}</label>
      </div>
      <div class="row pt-2">
        <label class="col-3">Install Date:</label> 
        <input 
          class="col-6 form-control" 
          type="date" 
          v-model="model.date"
          name="date"
          v-validate="{ required: true, date_between: dateRangeForValidation }"
        >
        <label class="col-3">(blank=yesterday)</label>
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
      </div>
      <div class="row pt-2">
        <label class="col-3">Details(optional):</label> 
        <textarea class="col-9" v-model="model.details"></textarea>
      </div>
      <div class="row pt-2">
        <label class="col-3">Contractor Inv No:</label> 
        <input class="col-6 form-control" type="text" v-model="model.invoice_no">
      </div>
      <div class="row pt-2">
        <label>Select Contractor:</label>
        <drop-down
          :options="contractors"
          placeholder="Select Contractor"
          v-model="selectedContractor"
          v-validate="'required'"
          name="contractor"
        >
        </drop-down>
        <label class="error">{{ errors.first('contractor') }}</label>
        <label class="error" v-if="noLiabilityAC">Has no Liability Account Code and can't be used</label>
        <label class="error" v-if="noCOSAC">Has no COS Account Code and can't be used</label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Next</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin, CurrentUserMixin } from '../../../../common/mixins'
import { getContractorsBySite } from '../../../api/calls'
import Axios from 'axios';
import { 
  formatDate,
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
  formatViewDate
} from '../../../../common/utitlities/helpers';

export default {
  name: "AllocateLabour",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    job: {
      type: Object,
      required: true
    },
    netLabourAllocated: {
      required: true,
    },
    netLabourCost: {
      type: Number,
      required: true
    },
  },
  computed: {
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
    netPayable() {
      return Number(this.netLabourCost) - Number(this.totalLabourAllocated);
    },
    contractor() {
      return this.contractors.find(contractor => contractor.id === this.selectedContractor) || {};
    },
  },
  data: () => ({
    selectedContractor: "",
    contractors: [],
    model: {
      date: formatDate(new Date().setDate(new Date().getDate() -1)),
    },
    noLiabilityAC: false,
    noCOSAC: false,
  }),
  created() {
    this.fetchContracotrsBySite(this.job.site_id);
  },
  methods: {
    fetchContracotrsBySite(siteId) {
      this.enableLoading();
      getContractorsBySite(siteId)
        .then(({ data }) => {
          this.contractors = data.data;
        })
        .catch(() => {
          console.log('could not fetch contractors');
        })
        .finally(this.disableLoading);
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          if (!this.contractor.contractor_liability_account) {
            return this.noLiabilityAC = true;
          }
          if (!this.contractor.cost_of_sales_account) {
            return this.noCOSAC = true;
          }

          this.model.job_id = this.job.id;
          this.model.gst = this.job.site.gst;
          // if(!this.model.date) {
          //   let date = new Date();
          //   new Date().setDate(date.getDate() -1);
          //   this.model.date = formatDate(new Date().setDate(date.getDate() -1));
          // }
          axios
           .post(`/contractors/${this.selectedContractor}/payments`, this.model)
           .then(() => {
             this.$emit('updated');
           })
           .catch(() => {
             this.$toastr('error', 'Could not allocate labour.', 'Error!!');
           })
           .finally(() => {
             this.disableLoading();
             this.handleClose();
           })
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>
<style scoped>
  textarea {
    width: 100;
    height: 50px;
  }
</style>
