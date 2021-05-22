<template>
  <filter-type
    :operators="$options.OPERATORS"
    :operator.sync="operator"
  >
    <input
      type="number"
      v-model="value"
      slot-scope="{ operator: operatorObj }"
      v-show="operatorObj.id === operator"
    />
  </filter-type>
</template>

<script>
  import FilterTypeMixin from '../FilterTypeMixin';
  import {
    IS,
    IS_NOT,
    GREATER_THAN,
    LESS_THAN,
  } from '../const/humanizedOperator';
  import { EQUALS } from '../const/operators';

  const OPERATORS = [
    IS,
    IS_NOT,
    GREATER_THAN,
    LESS_THAN,
  ];

  export default {
    name: 'FilterNumber',
    mixins: [FilterTypeMixin],
    OPERATORS,
    created() {
      this.operator = this.filter.operator || EQUALS;
    },
  };
</script>

<style scoped>

</style>
