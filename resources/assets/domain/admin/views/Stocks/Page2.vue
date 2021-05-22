<template>
  <div class="form-group row">
    <div class="col-lg-8 pb-2">
      <div class="row">
        <label class="col-lg-4" style="text-align: right">Delivery Date:</label>
        <div class="col-lg-8">
          <input 
            class="form-control" 
            type="date" 
            v-model="model.delivery_date" 
            name="delivery date" 
            v-validate="{ required: true, date_between: fiscalYearDateRangeForValidation }"
          />
          <label
              class="error"
              v-if="errors.firstByRule('delivery date', 'required')"
            >The delivery date field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('delivery date', 'date_format')"
            >The delivery date field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('delivery date', 'date_between')"
            >The delivery date field must be between {{ startOfFiscalYear }} and {{ endOfFiscalYear }}.</label>
        </div>
        <span class="col-7 text-right">OR</span>
      </div>
    </div>
    <div class="col-12">
      <div class="row d-flex align-items-center justify-content-center pt-3">
        <input type="radio" v-model="model.delivery_date" id="sevenDays" :value="getDaysAddedWithToday(7)"> 
        <label class="col-5" for="sevenDays">Today + 7 Days</label>
        <input type="radio" v-model="model.delivery_date" id="tenDays" :value="getDaysAddedWithToday(10)"> 
        <label class="col-5" for="tenDays" >Today + 10 Days</label>
      </div>
      <div class="row d-flex align-items-center justify-content-center pt-1">
        <input type="radio" v-model="model.delivery_date" id="2weeks" :value="getWeeksAddedWithToday(2)"> 
        <label class="col-5" for="2weeks">Today + 2 Weeks</label>
        <input type="radio" v-model="model.delivery_date" id="3weeks" :value="getWeeksAddedWithToday(3)"> 
        <label class="col-5" for="3weeks" >Today + 3 Weeks</label>
      </div>
      <div class="row d-flex align-items-center justify-content-center pt-1">
        <input type="radio" v-model="model.delivery_date" id="4weeks" :value="getWeeksAddedWithToday(4)"> 
        <label class="col-5" for="4weeks">Today + 4 Weeks</label>
        <input type="radio" v-model="model.delivery_date" id="5weeks" :value="getWeeksAddedWithToday(5)"> 
        <label class="col-5" for="5weeks" >Today + 5 Weeks</label>
      </div>
      <div class="row d-flex align-items-center pt-1 pl-4">
        <input type="radio" v-model="model.delivery_date" id="6weeks" :value="getWeeksAddedWithToday(6)"> 
        <label class="col-5" for="6weeks">Today + 6 Weeks</label>
      </div>
      <div class="row pt-3">
        <label>
          Enter the expected Delivery Date
          of this item, or select one of the
          date options.
          Delivery Date is Compulsory.
        </label>
      </div>
    </div>
  </div>
</template>

<script>

import { addDays, addWeeks, format } from 'date-fns';
import {
  getViewFiscalYear,
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  formatViewDate
} from "../../../common/utitlities/helpers";

const TODAY = new Date();
const FORMAT = 'yyyy-MM-dd';

export default {
  name: "Page2",
  components: {},
  props: {
    stockData: {
      type: Object,
      required: true
    },
    data: {
      type: Object,
      default: () => ({}),
    },
  },
  data: () => ({
    model: {}
  }),
  computed: {
    startOfFiscalYear() {
      return formatViewDate(getFiscalYear());
    },
    endOfFiscalYear() {
      return formatViewDate(getFiscalYear("end"));
    },
    fiscalYearDateRangeForValidation() {
      return getFiscalYearDateRangeForValidation();
    }
  },
  watch: {
    // data: {
    //   immediate: true,
    //   deep: true,
    //   handler(value) {
    //     if (value) {
    //       this.model = value;
    //     }
    //   },
    // },
    model: {
      deep: true,
      immediate: true,
      handler(value) {
        const updatedData = Object.assign({}, this.stockData.values, value);
        this.$emit("updated:stock-data", updatedData);
      }
    }
  },
  methods: {
    getDaysAddedWithToday(days) {
      if  (days) {
        return format(addDays(TODAY, Number(days)), FORMAT);
      }
    },
    getWeeksAddedWithToday(weeks) {
      if  (weeks) {
        return format(addWeeks(TODAY, Number(weeks)), FORMAT);
      }
    },
  },
};
</script>
