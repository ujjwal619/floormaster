<template>
  <modal title="Set Transaction Journal Viewing Range" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group row">
        <div class="col-lg-12">
          <div class="row pb-2">
            <label class="col-lg-3 text-right">Maximum Range:</label>
            <label class="col-lg-8">{{ getViewFiscalYear() }}</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-3 text-right">Viewing Range</label>
          </div>
          <div class="row pb-3">
            <label class="col-lg-3 text-right">From:</label>
            <input
              class="col-lg-8 form-control"
              type="date"
              v-model="model.from"
              v-validate="{ required: true, date_between: fiscalYearDateRangeForValidation }"
              name="from"
            />
            <label
              class="error"
              v-if="errors.firstByRule('from', 'required')"
            >The from field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('from', 'date_format')"
            >The from field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('from', 'date_between')"
            >The from field must be between {{ startOfFiscalYear }} and {{ endOfFiscalYear }}.</label>
          </div>
          <div class="row pb-3">
            <label class="col-lg-3 text-right">To:</label>
            <input
              class="col-lg-8 form-control"
              type="date"
              v-model="model.to"
              v-validate="{ required: true, date_between: fiscalYearDateRangeForValidation }"
              name="to"
            />
            <label
              class="error"
              v-if="errors.firstByRule('to', 'required')"
            >The to field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('to', 'date_format')"
            >The to field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('to', 'date_between')"
            >The to field must be between {{ startOfFiscalYear }} and {{ endOfFiscalYear }}.</label>
          </div>
        </div>
      </div>
      <label class="row pt-3">
        Each Detail and Header Account reports to a Parent Header.
        <br />For example, 6-2510: Staff Amenities, 6-2520: Supperannuation all report to the Parent Header
        6-2500: Employment Expenses.
        <br />Employment Expenses reports directly to Master Account 6-0000 Expenses.
        <br />You must nominate which Header Account this new Account reports to.
      </label>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="clearDateRange">Clear</button>
      <button type="button" class="btn action-buttons" @click="handleApply">Apply</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import {
  getViewFiscalYear,
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  formatViewDate
} from "../../../../common/utitlities/helpers";

const BASE_STATE = {
  from: "",
  to: ""
};

const TYPE = {
  HEADER: 1,
  DETAIL: 2
};

export default {
  name: "SetDateRangeModal",
  components: {
    Modal
  },
  props: {
    metaData: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    model: { ...BASE_STATE }
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
  watch: {},
  created() {
    this.model = { ...this.metaData };
  },
  methods: {
    getViewFiscalYear,
    handleClose() {
      this.model = { ...BASE_STATE };
      this.$emit("close");
    },
    handleApply() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit("selected", this.model);
          this.handleClose();
        }
      });
    },
    clearDateRange() {
      this.errors.clear();
      this.model = { ...BASE_STATE };
    },
    validate() {
      return this.$validator.validateAll();
    }
  }
};
</script>
