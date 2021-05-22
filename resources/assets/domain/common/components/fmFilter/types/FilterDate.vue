<template>
  <filter-type
    :operators="$options.OPERATORS"
    :operator.sync="operator"
  >
    <div
      class="relativePosition"
      slot-scope="{ operator: operatorObj }"
      v-if="showFlatpicker(operatorObj.id)"
    >
      <flatpicker
        :config="$options.CONFIG"
        placeholder="Select a date range"
        class="relativePosition"
      >
        <input
          type="text"
          class="flatpickr-input input"
          :name="$options.FLATPICKER_ID"
          slot-scope="{ fp }"
          v-model="value"
          data-input
        />
      </flatpicker>
    </div>
  </filter-type>
</template>

<script>
  import {
    subDays,
    getDate,
    subMonths,
    format,
  } from 'date-fns';
  import { uniqueKey } from '../../../utitlities/helpers';
  import FilterTypeMixin from '../FilterTypeMixin';
  import {
    TODAY,
    YESTERDAY,
    LAST_7_DAYS,
    LAST_30_DAYS,
    CURRENT_MONTH,
    LAST_MONTH,
    CUSTOM,
  } from '../const/humanizedOperator';
  import * as BASE_OPERATOR from '../const/operators';
  import Flatpicker from '../../FlatPicker';

  const OPERATORS = [
    TODAY,
    YESTERDAY,
    LAST_7_DAYS,
    LAST_30_DAYS,
    CURRENT_MONTH,
    LAST_MONTH,
    CUSTOM,
  ];

  const CONFIG = {
    inline: true,
    mode: 'range',
  };

  const FLATPICKER_ID = `filter-datepicker-${uniqueKey()}`;

  export default {
    name: 'FilterDate',
    components: {
      Flatpicker,
    },
    mixins: [FilterTypeMixin],
    OPERATORS,
    CONFIG,
    FLATPICKER_ID,
    watch: {
      operator(value) {
        if (value !== BASE_OPERATOR.CUSTOM) {
          this.value = this.formattedDate(this.relativeToDate(value));
        }
      },
    },
    created() {
      this.operator = this.filter.operator || '';
    },
    methods: {
      showFlatpicker(operator) {
        console.log('show flaat', operator === BASE_OPERATOR.CUSTOM && this.operator === BASE_OPERATOR.CUSTOM)
        return operator === BASE_OPERATOR.CUSTOM && this.operator === BASE_OPERATOR.CUSTOM;
      },
      formattedDate(value) {
        return format(value || new Date(), 'yyyy-MM-dd');
      },
      relativeToDate(relativeDate) {
        switch (relativeDate) {
          case BASE_OPERATOR.YESTERDAY:
            return subDays(new Date(), 1);
          case BASE_OPERATOR.LAST_7_DAYS:
            return subDays(new Date(), 7);
          case BASE_OPERATOR.LAST_30_DAYS:
            return subDays(new Date(), 30);
          case BASE_OPERATOR.CURRENT_MONTH:
            return subDays(new Date(), getDate(new Date()) - 1);
          case BASE_OPERATOR.LAST_MONTH:
            return subMonths(this.relativeToDate(BASE_OPERATOR.CURRENT_MONTH), 1);
          default:
          case BASE_OPERATOR.TODAY:
            return new Date();
        }
      },
    },
  };
</script>

<style>
  .flatpickr-calendar.inline {
    position: absolute !important;
    top: 35px !important;
  }

  .flatpickr-current-month input {
    border-color: transparent !important;
    padding: 0 0 0 .5ch !important;
  }
</style>
