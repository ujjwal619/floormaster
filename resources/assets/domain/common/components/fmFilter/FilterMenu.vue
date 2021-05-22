<template>
  <div
    class="filter-menu ag-flex-wrap relativePosition"
    :class="{ 'filter-menu--error': showError }"
    ref="filterMenu"
  >
    <div class="filter-menu__base ag-flex ag-align-center" @click="toggle">
      <button
        type="button"
        class="truncate transparent-button filter-menu__label"
        :title="filterText"
        
      >
        <strong> {{ filter.label }} </strong>
        <template v-if="showError">is missing value</template>
        <template v-else>{{ humanizedOperatorValue }}</template>
      </button>
      <button
        type="button"
        class="transparent-button ag-flex ag-align-center ag-flex-shrink-0 col-hr-1 filter-menu__button"
        :class="showError ? 'text-primary-red' : 'text-mid-grey'"
        title="Remove this filter"
        @click="$emit('remove', filter)"
      >
        <span class="fa fa-times"></span>
      </button>
    </div>
    <transition name="list-down">
      <form
        class="filter-menu__list ui form"
        v-show="visible"
      >
        <keep-alive>
          <component
            :is="currentFilterType"
            :filter="filter"
            @update="handleFilterUpdate"
          ></component>
        </keep-alive>
      </form>
    </transition>
  </div>
</template>

<script>
  import FmIcon from '../functional/FmIcon';
  import FilterNumber from './types/FilterNumber';
  import FilterSelect from './types/FilterSelect';
  import FilterDate from './types/FilterDate';
  import FilterString from './types/FilterString';
  import OPERATOR_VALUE_ID_MAP, { DEFAULT_FILTER_TEXT } from './const/humanizedOperator';

  const HUMANIZED_OPERATOR_MAP = new Map();
  OPERATOR_VALUE_ID_MAP.forEach(operator => HUMANIZED_OPERATOR_MAP.set(operator.id, operator.value, operator.message));

  const OPERATOR_MESSAGE_MAP = new Map();
  OPERATOR_VALUE_ID_MAP.forEach(operator => OPERATOR_MESSAGE_MAP.set(operator.id, operator.message));

  export default {
    name: 'FilterMenu',
    components: {
      FmIcon,
      FilterNumber,
      FilterSelect,
      FilterDate,
      FilterString,
    },
    props: {
      filter: {
        type: Object,
        required: true,
      },
    },
    data: () => ({
      visible: true,
    }),
    computed: {
      currentFilterType() {
        return `Filter${this.filter.type}`;
      },
      showError() {
        return !this.filter.value && !this.visible;
      },
      humanizedOperatorValue() {
        const value = this.filter.value || '';
        const operator = HUMANIZED_OPERATOR_MAP.get(this.filter.operator) || '';
        const operatorMessage = OPERATOR_MESSAGE_MAP.get(this.filter.operator);
        if (typeof operatorMessage === 'function') {
          return operatorMessage({ operator, value }) || '';
        }
        return DEFAULT_FILTER_TEXT({ operator, value }) || '';
      },
      filterText() {
        const { label, value } = this.filter;
        const message = value ? this.humanizedOperatorValue : 'is missing value';
        return `${label} ${message}`;
      },
    },
    watch: {
      visible: {
        immediate: true,
        handler(value, oldValue) {
          console.log(value, oldValue);
          if (oldValue && value !== oldValue) {
            this.$nextTick(() => {
              if (value) {
                // document.addEventListener('click', this.handleClick);
              } else {
                // document.removeEventListener('click', this.handleClick);
              }
            });
          }
        },
      },
    },
    created() {
      if (this.filter.saved) {
        this.hide();
      }
    },
    beforeDestroy() {
      // document.removeEventListener('click', this.handleClick);
    },
    methods: {
      handleClick(event) {
        if (this.visible) {
          const { target } = event;
          const { filterMenu } = this.$refs;
          if (target !== filterMenu && !filterMenu.contains(target)) {
            // this.hide();
          }
        }
      },
      toggle() {
        console.log('toggle clicked');
        if (this.visible) {
          this.hide();
        } else {
          this.show();
        }
      },
      show() {
        this.visible = true;
      },
      hide() {
        this.visible = false;
      },
      handleFilterUpdate({ operator, value }) {
        if (value) {
          this.$nextTick(() => {
            this.hide();
          })
        }
        const updatedFilter = { ...this.filter, operator, value };
        this.$emit('update:filter', updatedFilter);
      },
    },
  };
</script>


<style scoped>
  .filter-menu__base {
    background-color: #dbdbdb;
    border-radius: 2px;
    height: 30px;
    max-width: 300px;
  }

  .filter-menu__base:after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(0, 0, 0, .03);
    opacity: 0;
    transition: 250ms ease opacity;
  }

  .filter-menu:focus > .filter-menu__base:after,
  .filter-menu:focus-within > .filter-menu__base:after,
  .filter-menu:hover > .filter-menu__base:after {
    opacity: 1;
  }

  .filter-menu--error .filter-menu__base {
    background-color: #f2c6c6;
    color: #ed595a;
  }

  .filter-menu__label {
    color: inherit;
    /* z-index: 1; */
    padding: 5px 5px 5px 10px;
  }

  .filter-menu__button {
    opacity: 0;
    padding: 5px;
    transition: all 300ms ease-in-out;
    z-index: 1;
  }

  .filter-menu__base:focus-within .filter-menu__button,
  .filter-menu__base:hover .filter-menu__button {
    opacity: 1;
  }

  .filter-menu__list {
    background-color: #fff;
    border-radius: 3px;
    border: 1px solid #f2f2f2;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
    left: 0;
    min-width: 200px;
    position: absolute;
    top: 30px;
    /* z-index: 2; */
  }
</style>
