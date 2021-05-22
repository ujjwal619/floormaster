<template>
  <div>
    <div class="row">
      <label> Please Select the date for this Electronic Fund Transfer Remittance</label> 
    </div>
    <div class="row pt-2">
      <label class="col-4 text-right pr-3">Transaction Date</label>
      <div class="col-7">
        <input 
          type="date" 
          v-model="transactionDate" 
          name="transaction date" 
          v-validate="{ required: true, date_between: dateRangeForValidation }"
        >
        <label
              class="error"
              v-if="errors.firstByRule('transaction date', 'required')"
          >The transaction date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('transaction date', 'date_format')"
          >The transaction date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('transaction date', 'date_between')"
          >The transaction date field must be between {{ startDate }} and {{ endDate }}.</label>
      </div>
    </div>
  </div>  
</template>

<script>
import { 
  formatDate,
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
  formatViewDate,
} from '../../../../common/utitlities/helpers';
import { CurrentUserMixin } from '../../../../common/mixins';

export default {
  name: 'ElectronicFundTransfer',
  mixins: [CurrentUserMixin],
  data: () => ({
    transactionDate: formatDate(new Date()),
  }),
  watch: {
    transactionDate: {
      immediate: true,
      handler(value) {
        return this.$emit('updated', { transaction_date: value });
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
};
</script>
