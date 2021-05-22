<template>
  <div>
    <div class="row">
      <div class="col-2">&nbsp;</div>
      <label>
        Please confirm or change your Cheque Date <br/>
        The default Cheque number is one more than the last cheque drawn<br/>
        The Cheque counter on your setup screen will be updated with the number you use here
      </label>
    </div>
    <div class="row pt-3">
      <label class="col-4 text-right">Cheque Date</label>
      <div class="col-7">
        <input 
          type="date" 
          v-model="model.cheque_date" 
          name="cheque date" 
          v-validate="{ required: true, date_between: dateRangeForValidation }"
        >
        <label
              class="error"
              v-if="errors.firstByRule('cheque date', 'required')"
          >The cheque date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('cheque date', 'date_format')"
          >The cheque date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('cheque date', 'date_between')"
          >The cheque date field must be between {{ startDate }} and {{ endDate }}.</label>
      </div>
    </div>
    <div class="row pt-3">
      <label class="col-4 text-right">Cheque Number</label>
      <div class="col-7">
        <input type="text" v-model="model.cheque_number" name="cheque number" v-validate="'required'">
        <label class="error">{{ errors.first('cheque number') }}</label>
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
  name: 'ChequeDrawing',
  mixins: [CurrentUserMixin],
  data: () => ({
    model: {
      cheque_date: formatDate(new Date()),
      cheque_number: 'C',
    },
  }),
  watch: {
    model: {
      deep: true,
      handler(value) {
        return this.$emit('updated', value);
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
