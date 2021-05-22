<template>
  <section class="ag-flex ag-align-center ag-flex-wrap filters-container" v-if="moduleName">
    <filter-menu
      v-for="filter in addedFilters"
      :key="filter.id"
      :filter="filter"
      @update:filter="updateFilter"
      @remove="removeFilter"
    ></filter-menu>
    <div class="ag-flex ag-align-center ag-flex-wrap" v-if="options && options.length">
      <fm-menu :disabled="isFilterMissingValue">
        <button
          slot="base"
          type="button"
          class="transparent-button text-semi-bold"
          :class="isFilterMissingValue ? 'text-mid-grey' : 'text-primary'"
          :disabled="isFilterMissingValue"
          :title="isFilterMissingValue ? 'One of the filter is missing value' : 'Add Filter'"
        >
          Add Filter
        </button>
        <template slot="item">
          <button
            type="button"
            class="transparent-button width-100p"
            v-for="option in options"
            :key="option.key"
            @click="addFilter(option)"
          >
            {{ option.label }}
          </button>
        </template>
      </fm-menu>
      <template v-if="addedFilters.length">
        <button
          type="button"
          class="transparent-button text-semi-bold text-danger"
          title="Clear All Filters"
          @click="clearFilters"
        >
          Clear
        </button>
      </template>
    </div>
  </section>
</template>

<script>
  import { groupBy, debounce, isEqual, first } from 'lodash/fp';
  import { uniqueKey } from '../../utitlities/helpers';
  import { refsMixin } from '../../mixins/index';
  import { OPERATOR_QUERY_ALIAS_MAP } from './const/operators';
  import FmMenu from '../FmMenu';
  import FilterMenu from './FilterMenu';
  import FmIcon from '../functional/FmIcon';

  const FILTER_SAVE_MODAL = 'FILTER_SAVE_MODAL';
  const DEBOUNCE_TIME = 350;

  export default {
    name: 'FmFilter',
    mixins: [refsMixin],
    components: {
      FmIcon,
      FilterMenu,
      FmMenu,
    },
    props: {
      options: {
        type: Array,
        required: true,
      },
      moduleName: {
        type: String,
        required: true,
      },
    },
    FILTER_SAVE_MODAL,
    data: () => ({
      addedFilters: [],
      savedFilters: [],
      lastFilterQuery: null,
      currentFilterId: null,
      isFilterSaveMounted: false,
    }),
    computed: {
      currentFilter() {
        return first(this.savedFilters.filter(({ id }) => id === this.currentFilterId)) || {};
      },
      isFilterMissingValue() {
        return this.addedFilters.some(({ value }) => !value);
      },
      mappedAddedFilters() {
        return this.addedFilters.map(({ key, operator, value }) => {
          const filter = { key, operator, value };
          filter.operator = OPERATOR_QUERY_ALIAS_MAP.get(operator) || operator;
          return filter;
        });
      },
    },
    watch: {
      mappedAddedFilters() {
        this.debounceFilterQuery(this);
      },
      currentFilter(newFilter, { id: oldId }) {
        const { id: newId } = newFilter;
        if (newId && newId !== oldId) {
          this.addedFilters = newFilter.value.map(filters => ({ ...filters, saved: true }));
        }
      },
    },
    created() {
    //   this.fetchFilters();
    },
    methods: {
    //   fetchFilters() {
    //     const { moduleName } = this;
    //     return getFilters({ moduleName })
    //       .then(({ data }) => {
    //         this.savedFilters = data.data;
    //       });
    //   },
    //   sendFilters({ name, id }) {
    //     const payload = {
    //       module_name: this.moduleName,
    //       name,
    //       value: this.isFilterMissingValue ? this.addedFilters.filter(({ value }) => !!value) : this.addedFilters,
    //     };
    //     this.refAction(FILTER_SAVE_MODAL, 'enableLoading');
    //     this.getFilterRequest(id, payload)
    //       .then(({ data }) => {
    //         this.fetchFilters()
    //           .then(this.setCurrentFilterId(data.data.id));
    //       })
    //       .then(() => this.refAction(FILTER_SAVE_MODAL, 'hide'))
    //       .catch(({ response }) => Agentcis.alert(response.data.message || 'Saving filter failed. Please try again.', 'danger'))
    //       .finally(() => this.refAction(FILTER_SAVE_MODAL, 'disableLoading'));
    //   },
    //   getFilterRequest(id, payload) {
    //     if (id) {
    //       return putFilter(id, payload);
    //     }
    //     return postFilters(payload);
    //   },
      debounceFilterQuery: debounce(DEBOUNCE_TIME)(context => context.emitFilterQuery()),
      emitFilterQuery() {
        const filters = this.getFilterQuery(this.mappedAddedFilters);
        if (!isEqual(filters)(this.lastFilterQuery)) {
          this.$emit('query', { filters });
          this.lastFilterQuery = filters;
        }
      },
      getFilterQuery(filters) {
        const filtersWithValue = filters.filter(({ value }) => !!value);
        if (!filtersWithValue.length) {
          return null;
        }
        const filterKeys = groupBy(filter => filter.key)(filtersWithValue);
        const request = {};
        Object.keys(filterKeys).forEach((key) => {
          request[key] = {};
          filterKeys[key].forEach(({ operator, value }) => {
            request[key][operator] = value;
          });
        });
        return request;
      },
      addFilter(filter = {}) {
        if (filter.key) {
          const filterToAdd = { ...filter, id: `filter-${uniqueKey()}` };
          this.addedFilters.push(filterToAdd);
        }
      },
      saveFilter() {
        if (!this.isFilterSaveMounted) {
          this.isFilterSaveMounted = true;
        } else {
          this.refAction(FILTER_SAVE_MODAL, 'show');
        }
      },
      clearFilters() {
        this.addedFilters = [];
        this.setCurrentFilterId();
      },
      removeFilter({ id }) {
        this.addedFilters = this.addedFilters.filter(filter => filter.id !== id);
      },
      updateFilter(updatedFilter) {
        this.addedFilters = this.addedFilters.map((filter) => {
          if (updatedFilter.id === filter.id) {
            return updatedFilter;
          }
          return filter;
        });
      },
      setCurrentFilterId(id) {
        this.currentFilterId = id || null;
      },
    },
  };
</script>

<style scoped>
  .filters-container {
    margin: 15px -5px;
  }

  .filters-container > * {
    margin: 5px;
  }

  .filter-quick {
    background-color: #fff;
    padding: 5px 10px;
    border-radius: 2px;
    height: 30px;
    max-width: 300px;
  }
</style>
