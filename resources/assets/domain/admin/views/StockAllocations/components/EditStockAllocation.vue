<template>
  <modal :is-large="true" :title="dispatch ? 'Dispatch Stock Allocation' : 'Edit Stock Allocation'" @close="handleClose">
    <loading :loading="loading" />
    <div slot="modal-body" class="row">
      <div class="col-8">
        <div class="row">
          <label class="col-4 text-right">
            Created on: 
          </label>
          <label class="pl-2">{{ allocation.created_at }} by: {{ allocation.created_by }}</label>
        </div>
        <div class="row pt-1">
          <label class="col-4 text-right">
            Name: 
          </label>
          <label class="pl-2">{{ allocation.client }}</label>
        </div>
        <div class="row pt-1">
          <label class="col-4 text-right">
            Job: 
          </label>
          <label class="pl-2">{{ allocation.job_no }}</label>
        </div>
        <div class="row pt-1">
          <label class="col-4 text-right">
            Product: 
          </label>
          <label class="pl-2">{{ allocation.supplier_name }}: {{ allocation.product_name}} {{ allocation.color_name }}</label>
        </div>
        <div class="row pt-1">
          <label class="col-4 text-right">
            Against: 
          </label>
          <label class="pl-2">{{ allocation.current_stock_roll }}</label>
        </div>
        <template v-if="!dispatch">
          <div class="row pt-1">
            <label class="col-4 text-right">
              Date Required: 
            </label>
            <div class="pl-2 col-6">
              <input type="date" v-model="model.date_required"/>
            </div>
          </div>
          <div class="row pt-1">
            <label class="col-4 text-right">
              Quantity: 
            </label>
            <div class="pl-2 col-6">
              <input type="number" name="quantity" v-model="model.amount" v-validate="'decimal:2'" />
              <label class="errors">{{ errors.first('quantity') }}</label>
            </div>
          </div>
          <div class="row pt-2">
            <label class="col-4 text-right">
              Notes: 
            </label>
            <textarea class="col-8" cols="6" rows="2" v-model="model.notes"></textarea>
          </div>
        </template>
        <template v-else>
          <div class="row pt-1">
            <label class="col-4 text-right">
              Quantity: 
            </label>
            <div class="pl-2 col-6">
              <input 
                type="number" 
                v-validate="'required|decimal:2'" 
                v-model="model.amount" 
                name="quantity" 
              />
              <label class="error">{{ errors.first('quantity') }}</label>
            </div>
          </div>
          <div class="row pt-1">
            <label class="col-4 text-right">
              Dispatch Date: 
            </label>
            <div class="pl-2 col-6">
              <input 
                type="date" 
                v-model="model.date" 
                name="dispatch date" 
                v-validate="{ required: true, date_between: dateRangeForValidation }"
              />
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
          </div>
        </template>
      </div>
      <div class="col-4 px-2">
        <label v-if="!dispatch">
          You may change only the Date Required, Quantity and Notes. <br/>
          Quantity increases will only be accepted if the target stock
          item can accomodate.<br/>
          Other changes should be made at source. <br/>
          You may need to remove and recreate the Allocation. <br/>
          The Dispatch button will only appear on the dialog
          when the Allocation is against a Stock Item. <br/>
        </label>
        <label v-else>
          Please Confirm your DIspatch quantity.<br/>
          You may Dispatch more thant he Allocation amount
          only if the Stock Item will accomodate.<br/>
          If you Dispatch less than your Allocation amount
          the balance of this Allocation will remain.
        </label>
      </div>
    </div>
    <div slot="modal-footer" class="d-flex justify-content-end">
      <template v-if="!dispatch">
        <button type="button" class="btn action-buttons" @click="showDispatch">Dispatch</button>
        <button type="button" class="btn action-buttons" @click="deleteAllocation">Delete</button>
        <button type="button" class="btn action-buttons" @click="redirectToJob">Go to Job</button>
      </template>
      <button type="button" class="btn action-buttons" @click="doneAllocation">{{ !dispatch ? 'Done' : 'Next >'}}</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </div>
  </modal>
  
</template>

<script>

import Modal from '../../../../common/components/Modal/Modal';
import DropDown from '../../../../common/components/DropDown/DropDown';
import { LoadingMixin, CurrentUserMixin } from '../../../../common/mixins/index';
import { 
  formatViewDate,
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
  formatDate
} from "../../../../common/utitlities/helpers";

export default {
  name: 'EditStockAllocation',
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    Modal,
    DropDown,
  },
  props: {
    allocation: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    dispatch: false,
    model: {
      date: formatDate(new Date())
    }
  }),
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
  created() {
    this.fillModel();
  },
  methods: {
    fillModel() {
      this.model.required_date = this.allocation.required_date;
      this.model.amount = this.allocation.amount;
      this.model.notes = this.allocation.notes;
    },
    handleClose() {
      this.$emit('close');
    },
    showDispatch() {
      this.dispatch = true;
    },
    redirectToJob() {
      window.location.href = `/jobs/${this.allocation.job_id}/edit?page=2`
    },
    doneAllocation() {
      this.validate().then(valid => {
        if (valid) {
          this.enableLoading();
          const url = !this.dispatch ? `/api/allocations/${this.allocation.id}` : `/api/allocations/${this.allocation.id}/dispatch`;
          const method = !this.dispatch ? 'put' : 'patch';
          axios[method](url, this.model)
            .then(({ data }) => {
              this.$toastr('success', data.message, 'Success!!');
              this.$emit('updated');
            })
            .catch(() => {
              this.$toastr('error', !this.dispatch ? 'Error Updating allocation.' : 'Error dispatching allocation', 'Error!!')
            })
            .finally(() => {
              this.handleClose();
              this.disableLoading();
            });
        }
      })
    },
    validate() {
      return this.$validator.validate();
    },
    deleteAllocation() {
      this.enableLoading();
      axios.delete(`/api/allocations/${this.allocation.id}`)
        .then(({ data }) => {
          this.$emit('updated');
          this.$toastr('success', data.message, 'Success!!');
        })
        .catch(() => {
          this.$toastr('error', 'Could not delete allocation', 'Error!!')
        })
        .finally(() => {
          this.disableLoading();
          this.handleClose();
        })
    },
  },
};
</script>
