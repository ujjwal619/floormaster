<template>
    <div class="form-container">
        <loading :loading="loading" />
        <div class="content-wrapper">
            <div class="container-fluid col-v-5" style="background: white;">
                <h2 class="pageHeading"> Money Held in Trust </h2>
                <template>
                    <button  type="button" @click="exportReport('pdf')">
                      Export PDF
                    </button>
                </template>
                <template>
                  <button class="pull-right" type="button" @click="exportReport('excel')">
                    Export Excel
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
                    <span
                    slot="job"
                    slot-scope="{ job }"
                    >
                    {{ job }}
                    </span>
                    <template 
                    slot="client" 
                    slot-scope="{ client }"
                    >
                    {{ client }}
                    </template>
                    <span
                    slot="store_name"
                    slot-scope="{ store_name }"
                    >
                    {{ store_name }}
                    </span>
                    <span
                    slot="receipt_date"
                    slot-scope="{ receipt_date }"
                    >
                    {{ receipt_date }}
                    </span>
                    <span
                    slot="reference"
                    slot-scope="{ reference }"
                    >
                    {{ reference }}
                    </span>
                    <span
                    slot="allocated"
                    slot-scope="{ allocated }"
                    >
                    {{ displayMoney(allocated) }}
                    </span>
                    <span
                    slot="non_allocated"
                    slot-scope="{ non_allocated }"
                    >
                    {{ displayMoney(non_allocated) }}
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
import { getSites, getMITReport } from '../../../../../api/calls';
import FmFilter from "../../../../../../common/components/fmFilter/Index"
import FmTableSortable from '../../../../../../common/components/fmTable/Sortable'
import FmPagination from '../../../../../../common/components/FmPagination'
import { formatViewDate } from '../../../../../../common/utitlities/helpers'
import { displayMoney } from '../../../../../../common/utitlities/helpers'

const FILTERS = [
    // {
    //   key: 'invoice_date',
    //   label: 'Inv Date',
    //   type: 'Date',
    // },
];

const TABLE_COLUMNS = [
    {
      id: 'job',
      label: 'Job',
    },
    {
      id: 'client',
      label: 'Client',
    },
    {
      id: 'store_name',
      label: 'Store Name',
    },
    {
      id: 'receipt_date',
      label: 'Receipt Date',
    },
    {
      id: 'reference',
      label: 'Reference',
    },
    {
      id: 'allocated',
      label: 'Allocated',
    },
    {
      id: 'non_allocated',
      label: 'Non Allocated',
    },
];

const DEFAULT_PARAMS = {
    page: 1,
    per_page: 10,
    sort: 'job',
    filters: {},
};
  
export default {
    name: 'MITReport',
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
            job: 'dsc',
        },
        pagination: {},
        sites: [],
        query: DEFAULT_PARAMS,
    }),
    watch: {
      query: {
        deep: true,
        handler(value) {
          this.fetchMITReport(value);
        },
      },
    },
    created() {
        this.enableLoading();
            getSites()
            .then(({ data }) => {
                this.sites = data.data;
                const sites = data.data.map(site => {
                    return {id: site.name, value: site.name};
                })
                this.alteredFilters.push({
                    key: 'store_name',
                    label: 'Store',
                    type: 'Select',
                    options: sites,
                })

                this.fetchMITReport();
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
    },
    methods: {
        formatViewDate,
        displayMoney,
        openModal(type) {
            this[`mount${type}`] = true;
        },
        closeModal(type) {
            this[`mount${type}`] = false;
        },
        exportReport(type) {
            window.location.href = `/api/reports/job/mit/export?${$.param({...this.query, ...this.filterData, 'type': type})}`;
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
        fetchMITReport(params) {
            this.enableLoading();
            getMITReport({...DEFAULT_PARAMS, ...params, ...this.filterData})
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
