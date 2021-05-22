<template>
  <filter-type
    :operators="operators"
    :operator.sync="operator"
  >
    <select
      slot-scope="{ operator: operatorObj }"
      v-show="operatorObj.id === operator"
      v-model="value"
    >
      <option
        v-for="option in filter.options"
        :key="option.id"
        :value="option.id">
        {{ option.value }}
      </option>
    </select>
  </filter-type>
</template>

<script>
  import FilterTypeMixin from '../FilterTypeMixin';
  import {
    IS,
    IS_NOT,
  } from '../const/humanizedOperator';

  const OPERATORS = [
    IS,
    IS_NOT,
  ];

  export default {
    name: 'FilterSelect',
    mixins: [FilterTypeMixin],
    props: {
      onlyIs: {
        type: Boolean,
        default: false,
    },
    },
    data: () => ({
      operators: [
        IS,
        IS_NOT
      ]
    }),
    created() {
      if (this.onlyIs) {
        this.operators.pop();
      }
      this.operator = this.filter.operator || 'equals';
    },
  };
</script>

<style scoped>

</style>
