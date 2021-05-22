<template>
  <div class="filter-item ag-flex ag-flex-column">
    <div class="ag-flex ag-align-center filter-item__label">
      <label class="ag-flex">
        <input
          type="radio"
          class="col-hr-1"
          :value="operator.id"
          :checked="isChecked"
          @input="$emit('input', $event.target.value)"
        />
        {{ operator.value }}
      </label>
    </div>
    <slot></slot>
  </div>
</template>

<script>
  import get from 'lodash/fp/get';

  export default {
    name: 'FilterItem',
    props: {
      operator: {
        type: Object,
        required: true,
      },
      isChecked: {
        type: Boolean,
      },
    },
    watch: {
      isChecked: {
        immediate: true,
        handler(val, oldVal) {
          if (val && (val !== oldVal)) {
            this.$nextTick(() => {
              // @TODO: need to refactor in case of Vue js update to 2.6 or above
              const elm = get('default[0].elm')(this.$slots);
              if (elm && elm.focus) {
                elm.focus();
              }
            });
          }
        },
      },
    },
  };
</script>

<style scoped>
  .filter-item {
    margin: 1rem;
  }

  .filter-item__label + * {
    margin-top: 5px !important;
  }
</style>
