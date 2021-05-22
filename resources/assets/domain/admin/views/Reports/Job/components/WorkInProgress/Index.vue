<template>
    <div class="form-container">
        <loading :loading="loading" />
        <div class="content-wrapper">
            <div class="container-fluid col-v-5" style="background: white;">
                <h2 class="pageHeading"> Work In Progress </h2>
                <template>
                    <button type="button" @click="exportReport">
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
                    <template slot="job_id" slot-scope="{ job_id, id }"> <div @click="redirectToJob(id)">{{ job_id }}</div></template>
                    <span
                    slot="store_name"
                    slot-scope="{ store_name }"
                    >
                    {{ store_name }}
                    </span>
                    <span
                    slot="shop_name"
                    slot-scope="{ shop_name }"
                    >
                    {{ shop_name }}
                    </span>
                    <span
                    slot="initiation_date"
                    slot-scope="{ initiation_date }"
                    >
                    {{ formatViewDate(initiation_date) }}
                    </span>
                    <span
                    slot="completion_date"
                    slot-scope="{ completion_date }"
                    >
                    {{ formatViewDate(completion_date) }}
                    </span>
                    <span
                    slot="primary_sales_rep"
                    slot-scope="{ primary_sales_rep }"
                    >
                    {{ primary_sales_rep }}
                    </span>
                    <span
                    slot="trading_name"
                    slot-scope="{ trading_name }"
                    >
                    {{ trading_name }}
                    </span>
                    <span
                    slot="project"
                    slot-scope="{ project }"
                    >
                    {{ project }}
                    </span>
                    <span
                    slot="home_phone"
                    slot-scope="{ home_phone }"
                    >
                    {{ home_phone }}
                    </span>
                    <span
                    slot="work_phone"
                    slot-scope="{ work_phone }"
                    >
                    {{ work_phone }}
                    </span>
                    <span
                    slot="quoted"
                    slot-scope="{ quoted }"
                    >
                    {{ quoted }}
                    </span>
                    <span
                    slot="invoiced"
                    slot-scope="{ invoiced }"
                    >
                    {{ invoiced }}
                    </span>
                    <span
                    slot="balance"
                    slot-scope="{ balance }"
                    >
                    {{ balance }}
                    </span>
                </fm-table-sortable>
                </div>
                <img :src="require('../../../../../../../../../public/images/fm-logo.png')"/>
                <div class="ag-flex ag-justify-end col-v-4">
                <fm-pagination
                    :pagination="pagination"
                    @updated="setQuery"
                />
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { LoadingMixin } from '../../../../../../common/mixins';
import { getSites, getWipReport } from '../../../../../api/calls';
import FmFilter from "../../../../../../common/components/fmFilter/Index"
import FmTableSortable from '../../../../../../common/components/fmTable/Sortable'
import FmPagination from '../../../../../../common/components/FmPagination'
import { formatViewDate, isEmpty } from '../../../../../../common/utitlities/helpers'

const FILTERS = [
    
];

const TABLE_COLUMNS = [
    {
      id: 'job_id',
      label: 'Job',
    },
    {
      id: 'store_name',
      label: 'Store',
    },
    {
      id: 'shop_name',
      label: 'B.U.',
    },
    {
      id: 'order_status',
      label: 'Order Status',
    },
    {
      id: 'initiation_date',
      label: 'Initiated',
    },
    {
      id: 'completion_date',
      label: 'Completion',
    },
    {
      id: 'measured_date',
      label: 'Measured',
    },
    {
      id: 'primary_sales_rep',
      label: 'Primary Rep',
    },
    {
      id: 'trading_name',
      label: 'Client',
    },
    {
      id: 'project',
      label: 'Project',
    },
    {
      id: 'home_phone',
      label: 'Home Ph',
    },
    {
      id: 'work_phone',
      label: 'Work Ph',
    },
    {
      id: 'quoted',
      label: 'Quoted',
    },
    {
      id: 'invoiced',
      label: 'Invoiced',
    },
    {
      id: 'balance',
      label: 'Balance',
    },
    {
      id: 'notes',
      label: 'Notes',
    },
];

const DEFAULT_PARAMS = {
    page: 1,
    per_page: 10,
    sort: 'job_id',
    filters: {},
};
  
export default {
    name: 'WorkInProgressReport',
    mixins: [LoadingMixin],
    components: {
        FmFilter,
        FmTableSortable,
        FmPagination
    },
    FILTERS,
    TABLE_COLUMNS,
    data: () => ({
        alteredFilters: FILTERS,
        logs: [],
        sortableColumns: {
            job_id: 'dsc',
            trading_name: 'default',
            store_name: 'default',
            primary_sales_rep: 'default',
        },
        pagination: {},
        sites: [],
        query: DEFAULT_PARAMS,
    }),
    computed: {
      alteredSites() {
        return this.sites.map(site => {
            return {id: site.name, value: site.name};
        })
      },
    },
    watch: {
      query: {
        deep: true,
        handler(value) {
          this.fetchWorkInProgress(value);
          if (!value.filters) {
            this.alteredFilters = [];
            this.alteredFilters.push({
                key: 'store_name',
                label: 'Store',
                type: 'Select',
                options: this.alteredSites,
            })   
          }

          // if (!isEmpty(value.filters) && isEmpty(value.filters.shop_name)) {
          //   const site = this.findSiteByName(value.filters.store_name.equals);
          //   const shops = site.shops.map(shop => {
          //       return {id: shop.name, value: shop.name};
          //   });

          //   this.alteredFilters.push({
          //       key: 'shop_name',
          //       label: 'Business Unit',
          //       type: 'Select',
          //       options: shops,
          //   })
          // }
        },
      },
    },
    created() {
        this.enableLoading();
            getSites()
            .then(({ data }) => {
                this.sites = data.data;
                this.alteredFilters.push({
                    key: 'store_name',
                    label: 'Store',
                    type: 'Select',
                    options: this.alteredSites,
                })

                this.fetchWorkInProgress();
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
    },
    methods: {
        formatViewDate,
        findSiteByName(siteName) {
          return this.sites.find(site => site.name === siteName) || {};
        },
        redirectToJob(jobId) {
          window.location.href = `/jobs/${jobId}/edit`
        },
        openModal(type) {
            this[`mount${type}`] = true;
        },
        closeModal(type) {
            this[`mount${type}`] = false;
        },
        exportReport() {
            window.location.href = `/api/reports/job/wip/export?${$.param(this.query)}`;
        },
        setFilters(filters = {}) {
            const page = 1;
            this.setQuery({ page, ...filters });
        },
        setSort({ sort, sortable }) {
            this.sortableColumns = { ...sortable };
            const page = 1;
            this.setQuery({ sort, page });
        },
        setQuery(params = {}) {
            const { query } = this;
            this.$nextTick(() => {
            this.query = {
                ...query,
                ...params,
            };
            });
        },
        fetchWorkInProgress(params) {
            this.enableLoading();
            getWipReport({...DEFAULT_PARAMS, ...params})
            .then(({ data }) => {
                this.logs = data.data;
                this.pagination = data.meta;
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
        },
        fetchSites() {
            this.enableLoading();
            getSites()
            .then(({ data }) => {
                this.sites = data.data;
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
        },
    },
}
</script>

