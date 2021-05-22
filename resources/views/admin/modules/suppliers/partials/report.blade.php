
<div class="content-wrapper">
  <div class="container-fluid col-v-5" style="background: white;">
    <h3 class="pageHeading"> Suppliers </h3>
    <template>
    <button type="button" @click="exportSupplierReport">
      Export
    </button>
    </template>
    <fm-filter
        :options="alteredFilters"
        module-name="supplier"
        @query="setFilters"
    >
    </fm-filter>
    <div class="tableWrapper table-responsive">
      <fm-table-sortable
        :columns="$options.TABLE_COLUMNS"
        :records="logs"
        :sortable="sortableColumns"
        @sort="setSort"
      >
        <template slot="id" slot-scope="{ id }"> @{{ id }}</template>
        <span
          slot="trading_name"
          slot-scope="{ trading_name }"
          >
          @{{ trading_name }}
        </span>
        <span
          slot="site_name"
          slot-scope="{ site }"
          >
          @{{ site.name }}
        </span>
      </fm-table-sortable>
    </div>
    <div class="ag-flex ag-justify-end col-v-4">
      <fm-pagination
        :pagination="pagination"
        @updated="setQuery"
      />
    </div>
  </div>
</div>