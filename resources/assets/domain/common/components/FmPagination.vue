<template>
  <div class="ag-flex ag-align-center ag-pagination">
    <label class="col-hr-2">
      <strong class="col-hr-1"> Rows per page </strong>
      <select class="ag-pagination__select" v-model="pageSize">
        <option
          v-for="size of pageSizes"
          :key="size"
          :value="size"
        >
          {{ size }}
        </option>
      </select>
    </label>
    <span class="ag-pagination__info col-hr-2"> <strong> {{ from }} </strong> - <strong> {{ to }} </strong> of <strong> {{ totalPages }} </strong> </span>
    <span class="ag-flex ag-pagination__buttons">
      <button
        type="button"
        class="ag-flex ag-justify-center ag-align-center ag-pagination__button"
        :disabled="!canPrev"
        @click="handlePrev"
      >
        <i class="fa fa-chevron-left"></i>
      </button>
      <button
        type="button"
        class="ag-flex ag-justify-center ag-align-center ag-pagination__button"
        :disabled="!canNext"
        @click="handleNext"
      >
        <i class="fa fa-chevron-right"></i>
      </button>
    </span>
  </div>
</template>

<script>
  import head from 'lodash/fp/head';

  const FIRST_PAGE = 1;

  export default {
    name: 'FmPagination',
    components: {
    },
    props: {
      pagination: {
        type: Object,
        required: true,
      },
      pageSizes: {
        type: Array,
        default: () => [10, 25, 50],
      },
    },
    computed: {
      pageSize: {
        get() {
          return this.pagination.per_page || head(this.pageSizes);
        },
        set(value) {
          this.handlePerPage(value);
        },
      },
      from() {
        return this.pagination.from || FIRST_PAGE;
      },
      to() {
        return this.pagination.to || FIRST_PAGE;
      },
      totalPages() {
        return this.pagination.total || FIRST_PAGE;
      },
      currentPage() {
        return this.pagination.current_page || FIRST_PAGE;
      },
      canPrev() {
        return this.currentPage > FIRST_PAGE;
      },
      canNext() {
        return this.currentPage < this.pagination.last_page;
      },
    },
    methods: {
      update({ page, perPage }) {
        this.$emit('updated', {
          page: page || this.currentPage,
          per_page: perPage || this.pageSize,
        });
      },
      handleNext() {
        this.update({
          page: this.currentPage + 1,
        });
      },
      handlePrev() {
        this.update({
          page: this.currentPage - 1,
        });
      },
      handlePerPage(value) {
        this.update({
          page: 1,
          perPage: value,
        });
      },
    },
  };
</script>

<style scoped>
  .ag-pagination {
    font-size: .9rem;
  }

  .ag-pagination__select {
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 10px 8px;
  }

  .ag-pagination__select:focus,
  .ag-pagination__select:hover {
    background-color: #fff;
  }

  .ag-pagination__info {
    font-size: 1rem;
  }

  .ag-pagination__button {
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    cursor: pointer;
    padding: 10px 12px;
    transition: 150ms background;
  }

  .ag-pagination__button:first-child {
    border-radius: 5px 0 0 5px;
  }

  .ag-pagination__button:last-child {
    border-radius: 0 5px 5px 0;
    margin-left: 5px;
  }

  .ag-pagination__button:focus,
  .ag-pagination__button:hover {
    background-color: #fff;
  }

  .ag-pagination__button:disabled {
    cursor: not-allowed;
    opacity: .8;
  }

</style>
