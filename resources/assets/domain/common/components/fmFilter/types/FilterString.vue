<template>
  <filter-type
    :operators="$options.OPERATORS"
    :operator.sync="operator"
  >
    <input
      type="text"
      :value="value"
      @input="value = $event.target.value.toLowerCase()"
      slot-scope="{ operator: operatorObj }"
      v-show="showInput(operatorObj)"
    >
  </filter-type>
</template>

<script>
  import FilterTypeMixin from '../FilterTypeMixin';
  import {
    IS,
    IS_NOT,
    STARTS_WITH,
    ENDS_WITH,
    CONTAINS,
    NOT_CONTAINS,
    UNKNOWN,
  } from '../const/humanizedOperator';

  const OPERATORS = [IS, IS_NOT, STARTS_WITH, ENDS_WITH, CONTAINS, NOT_CONTAINS, UNKNOWN];

  export default {
    name: 'FilterString',
    mixins: [FilterTypeMixin],
    props: {
      filter: {
        type: Object,
        required: true,
      },
    },
    OPERATORS,
    UNKNOWN,
    watch: {
      operator(value) {
        if (value === UNKNOWN.id) {
          this.value = ' ';
        }
      },
    },
    methods: {
      showInput({ id }) {
        return id !== UNKNOWN.id && id === this.operator;
      },
    },
  };
</script>

<style scoped>

</style>
