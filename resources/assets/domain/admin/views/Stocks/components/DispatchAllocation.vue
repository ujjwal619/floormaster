<template>
  <modal title="Dispatch Confirmation" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">

      <div class="row">
        Confirm the Dispatch Quantity.
        Confirm that this is the correct Allocation.
        Enter Dispatch Date or select a default option.
      </div>
      <div class="row pt-4">
        <label class="col-3 text-right"><b>Roll No: </b></label>
        <label class="col-4 pl-2"><b>{{ allocation.current_stock.roll_no }}</b></label>
        <label></label>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right"><b>Job: </b></label>
        <label class="col-4 pl-2"><b>{{ allocation.job ? allocation.job.job_id : '' }}</b></label>
        <label></label>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right"><b>Job Name: </b></label>
        <label class="col-4 pl-2"><b>{{ allocation.client }}</b></label>
        <label></label>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right"><b>Quantity: </b></label>
        <input 
          type="number" 
          class="col-3 pl-2" 
          v-model="model.amount"
          v-validate="'required'"
        >
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right"><b>Dispatch Date: </b></label>
        <input 
          type="date" 
          class="col-4 pl-2" 
          v-model="model.date"
          v-validate="{ required: true, date_between: dateRangeForValidation }"
          name="dispatch date"
        >
        <label
                class="error"
                v-if="errors.firstByRule('dispatch date', 'required')"
              >The date field is required.</label>
              <label
                class="error"
                v-if="errors.firstByRule('dispatch date', 'date_format')"
              >The date field is required.</label>
              <label
                class="error"
                v-if="errors.firstByRule('dispatch date', 'date_between')"
              >The date field must be between {{ startDate }} and {{ endDate }}.</label>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right"><b>Return Location: </b></label>
        <input type="text" class="col-2 pl-2" v-model="model.return_location">
      </div>
      <div class="row pt-3">
        FLOORmanager will walk you through each roll/item
         of this product Allocated to this Job.
        Activate 'Dispatch this Quantity' after confirming
         the details, activate 'Skip this Allocation' 
        to move to the next Allocation, or Cancel to end.
      </div>
    </template>
    <template slot="modal-footer">
      <button 
        type="button" 
        class="btn action-buttons" 
        @click="skipThisAllocation"
      >
        Skip this Allocation
      </button>
      <button 
        type="button" 
        class="btn action-buttons" 
        @click="dispatchThisQuantity"
      >
        Dispatch this Quantity
      </button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin, CurrentUserMixin } from '../../../../common/mixins'
import { dispatchAllocation } from '../../../api/calls'
import { 
  formatDate,
  formatViewDate,
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
} from '../../../../common/utitlities/helpers';

export default {
  name: "DispatchAllocation",
  mixins: [LoadingMixin, CurrentUserMixin],
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
  },
  data: () => ({
    model: {
      amount: '',
      date: formatDate(new Date()),
      return_location: '',
    },
  }),
  watch: {
    allocation: {
      immediate: true,
      deep: true,
      handler(allocation) {
        this.model.amount = allocation.amount;
      }
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
  },
  // created() {
    
  // },
  // mounted() {
    
  // },
  methods: {
    dispatchThisQuantity() {
      this.validate().then(valid => {
        if (valid) {
          this.enableLoading();
          return dispatchAllocation(this.allocation.id, this.model)
            .then(() => {
              // this.$toastr("success",`Successfully dispatchd Allocation data`,"Success!!");
              this.$emit('next-dispatch');
            })
            .catch(err => this.$toastr("error", "Could not get dispatch allocation data.", "Error!!"))
            .finally(this.disableLoading);
        }
      });
    },
    skipThisAllocation() {
      this.$emit('next-dispatch');
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
  }
};
</script>
