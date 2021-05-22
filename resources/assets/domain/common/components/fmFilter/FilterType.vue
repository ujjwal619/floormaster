<template>
  <span>
    <filter-item
      v-for="operatorObj in operators"
      :key="`${operatorObj.id}-${getComponentKey()}`"
      :operator="operatorObj"
      :is-checked="operatorObj.id === operator"
      @input="$emit('update:operator', $event)"
    >
      <slot :operator="operatorObj"></slot>
    </filter-item>
  </span>
</template>

<script>
  import { uniqueKey } from '../../utitlities/helpers';
  import FilterItem from './FilterItem.vue';

  export default {
    name: 'FilterType',
    components: {
      FilterItem,
    },
    props: {
      operators: {
        type: Array,
        required: true,
      },
      operator: {
        type: String,
        required: true,
      },
    },
    methods: {
      getComponentKey() {
        return `filter-type-${uniqueKey()}`;
      },
    },
  };
</script>

<style scoped>

</style>
