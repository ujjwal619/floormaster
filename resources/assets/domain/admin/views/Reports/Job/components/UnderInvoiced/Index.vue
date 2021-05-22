<template>
    <div class="form-container">
        <loading :loading="loading" />
        <div class="content-wrapper">
            <div class="container-fluid col-v-5" style="background: white;">
                <h2 class="pageHeading"> Under-Invoiced Report </h2>
                <template>
                    <button type="button" @click="exportReport">
                        Export
                    </button>
                </template>
                <fm-filter
                    :options="alteredFilters"
                    module-name="job"
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
                    slot="trading_name"
                    slot-scope="{ trading_name }"
                    >
                    {{ trading_name }}
                    </span>
                    <span
                    slot="suburb"
                    slot-scope="{ suburb }"
                    >
                    {{ suburb }}
                    </span>
                    <span
                    slot="completion_date"
                    slot-scope="{ completion_date }"
                    >
                    {{ completion_date }}
                    </span>
                    <span
                    slot="quoted"
                    slot-scope="{ quoted }"
                    >
                    {{ displayMoney(quoted) }}
                    </span>
                    <span
                    slot="invoiced"
                    slot-scope="{ invoiced }"
                    >
                    {{ displayMoney(invoiced) }}
                    </span>
                    <span
                    slot="difference"
                    slot-scope="{ difference }"
                    >
                    {{ displayMoney(difference) }}
                    </span>
                </fm-table-sortable>
                </div>
                <b class="float-right"><i>Date range from {{formatViewDate(filterData.start_date)}} to {{formatViewDate(filterData.end_date)}}</i></b>
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
import { getSites, getUnderInvoicedReport } from '../../../../../api/calls';
import FmFilter from "../../../../../../common/components/fmFilter/Index"
import FmTableSortable from '../../../../../../common/components/fmTable/Sortable'
import FmPagination from '../../../../../../common/components/FmPagination'
import { 
  formatViewDate, 
  isEmpty, 
  displayMoney
} from '../../../../../../common/utitlities/helpers'

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
      id: 'trading_name',
      label: 'Client',
    },
    {
      id: 'suburb',
      label: 'Suburb',
    },
    {
      id: 'completion_date',
      label: 'Comp Date',
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
      id: 'difference',
      label: 'Difference',
    },
];

const DEFAULT_PARAMS = {
    page: 1,
    per_page: 10,
    sort: 'job_id',
    filters: {},
};
  
export default {
    name: 'UnderInvoicedReport',
    mixins: [LoadingMixin],
    components: {
        FmFilter,
        FmTableSortable,
        FmPagination
    },
    FILTERS,
    TABLE_COLUMNS,
    props: {
        filterData: {
            type: Object,
            required: true,
        },
    },
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
          this.fetchUnderInvoiced(value);
          if (!value.filters) {
            this.alteredFilters = [];
            this.alteredFilters.push({
                key: 'store_name',
                label: 'Store',
                type: 'Select',
                options: this.alteredSites,
            })   
          }

          if (!isEmpty(value.filters) && isEmpty(value.filters.shop_name)) {
            const site = this.findSiteByName(value.filters.store_name.equals);
            const shops = site.shops.map(shop => {
                return {id: shop.name, value: shop.name};
            });

            this.alteredFilters.push({
                key: 'shop_name',
                label: 'Business Unit',
                type: 'Select',
                options: shops,
            })
          }

          // if (!isEmpty(value.filters) && isEmpty(value.filters.primary_sales_rep)) {
          //   const site = this.findSiteByName(value.filters.store_name.equals);
          //   const salesStaffs = site.sales_staffs.map(staff => {
          //       return {id: staff.name, value: staff.name};
          //   });

          //   this.alteredFilters.push({
          //       key: 'primary_sales_rep',
          //       label: 'Primary Rep',
          //       type: 'Select',
          //       options: salesStaffs,
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

                this.fetchUnderInvoiced();
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
    },
    methods: {
        formatViewDate,
        displayMoney,
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
            window.location.href = `/api/reports/job/under-invoiced/export?${$.param({...this.query, ...this.filterData})}`;
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
        fetchUnderInvoiced(params) {
            this.enableLoading();
            getUnderInvoicedReport({...DEFAULT_PARAMS, ...params, ...this.filterData})
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

