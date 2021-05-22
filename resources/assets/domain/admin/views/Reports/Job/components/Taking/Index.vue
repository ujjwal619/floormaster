<template>
    <div class="form-container">
        <loading :loading="loading" />
        <div class="content-wrapper">
            <div class="container-fluid col-v-5" style="background: white;">
                <h2 class="pageHeading"> Taking </h2>
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
                    <span
                    slot="receipt_date"
                    slot-scope="{ receipt_date }"
                    >
                    {{ formatViewDate(receipt_date) }}
                    </span>
                    <template slot="invoice_no" slot-scope="{ invoice_no }"> {{ invoice_no }}</template>
                    <span
                    slot="store_name"
                    slot-scope="{ store_name }"
                    >
                    {{ store_name }}
                    </span>
                    <span
                    slot="client"
                    slot-scope="{ client }"
                    >
                    {{ client }}
                    </span>
                    <span
                    slot="reference"
                    slot-scope="{ reference }"
                    >
                    {{ reference }}
                    </span>
                    <span
                    slot="amount"
                    slot-scope="{ amount }"
                    >
                    {{ displayMoney(amount) }}
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
import { getSites, getBillingReport, getTakingReport } from '../../../../../api/calls';
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
      id: 'receipt_date',
      label: 'Receipt Date',
    },
    {
      id: 'invoice_no',
      label: 'Inv No.',
    },
    {
      id: 'store_name',
      label: 'Store',
    },
    {
      id: 'client',
      label: 'Client',
    },
    {
      id: 'reference',
      label: 'Reference',
    },
    {
      id: 'amount',
      label: 'Amount',
    },
];

const DEFAULT_PARAMS = {
    page: 1,
    per_page: 10,
    sort: 'invoice_no',
    filters: {},
};
  
export default {
    name: 'TakingReport',
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
            invoice_no: 'dsc',
        },
        pagination: {},
        sites: [],
        query: DEFAULT_PARAMS,
    }),
    watch: {
      query: {
        deep: true,
        handler(value) {
          this.fetchBillingReport(value);
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

                this.fetchBillingReport();
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
        exportReport() {
            window.location.href = `/api/reports/job/taking/export?${$.param({...this.query, ...this.filterData})}`;
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
        fetchBillingReport(params) {
            this.enableLoading();
            getTakingReport({...DEFAULT_PARAMS, ...params, ...this.filterData})
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
