<template>
    <div class="form-container">
        <loading :loading="loading" />
        <div class="content-wrapper">
            <div class="container-fluid col-v-5" style="background: white;">
                <h2 class="pageHeading"> Billing </h2>
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
                    <template slot="invoice_no" slot-scope="{ invoice_no }"> {{ invoice_no }}</template>
                    <span
                    slot="site_name"
                    slot-scope="{ site_name }"
                    >
                    {{ site_name }}
                    </span>
                    <span
                    slot="invoice_date"
                    slot-scope="{ invoice_date }"
                    >
                    {{ formatViewDate(invoice_date) }}
                    </span>
                    <span
                    slot="invoice_type"
                    slot-scope="{ invoice_type }"
                    >
                    {{ invoice_type }}
                    </span>
                    <span
                    slot="client"
                    slot-scope="{ client }"
                    >
                    {{ client }}
                    </span>
                    <span
                    slot="project"
                    slot-scope="{ project }"
                    >
                    {{ project }}
                    </span>
                    <span
                    slot="net_invoice"
                    slot-scope="{ net_invoice }"
                    >
                    {{ net_invoice }}
                    </span>
                    <span
                    slot="gst_amount"
                    slot-scope="{ gst_amount }"
                    >
                    {{ gst_amount }}
                    </span>
                    <span
                    slot="gross_amount"
                    slot-scope="{ gross_amount }"
                    >
                    {{ gross_amount }}
                    </span>
                    <span
                    slot="balance_due"
                    slot-scope="{ balance_due }"
                    >
                    {{ balance_due }}
                    </span>
                    <span
                    slot="sales_staff"
                    slot-scope="{ sales_staff }"
                    >
                    {{ sales_staff }}
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
import { getSites, getBillingReport } from '../../../../../api/calls';
import FmFilter from "../../../../../../common/components/fmFilter/Index"
import FmTableSortable from '../../../../../../common/components/fmTable/Sortable'
import FmPagination from '../../../../../../common/components/FmPagination'
import { formatViewDate } from '../../../../../../common/utitlities/helpers'

const FILTERS = [
    // {
    //   key: 'invoice_date',
    //   label: 'Inv Date',
    //   type: 'Date',
    // },
];

const TABLE_COLUMNS = [
    {
      id: 'invoice_no',
      label: 'Inv No.',
    },
    {
      id: 'site_name',
      label: 'Store',
    },
    {
      id: 'invoice_date',
      label: 'Inv Date',
    },
    {
      id: 'invoice_type',
      label: 'Inv Type',
    },
    {
      id: 'client',
      label: 'Client',
    },
    {
      id: 'project',
      label: 'Project',
    },
    {
      id: 'net_invoice',
      label: 'Net',
    },
    {
      id: 'gst_amount',
      label: 'Gst',
    },
    {
      id: 'gross_amount',
      label: 'Gross',
    },
    {
      id: 'balance_due',
      label: 'Bal Due',
    },
    {
      id: 'sales_staff',
      label: 'Sales Rep',
    },
];

const DEFAULT_PARAMS = {
    page: 1,
    per_page: 10,
    sort: 'invoice_no',
    filters: {},
};
  
export default {
    name: 'BillingReport',
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
        openModal(type) {
            this[`mount${type}`] = true;
        },
        closeModal(type) {
            this[`mount${type}`] = false;
        },
        exportReport() {
            window.location.href = `/api/reports/job/billing/export?${$.param({...this.query, ...this.filterData})}`;
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
            console.log('setquery', params);
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
            getBillingReport({...DEFAULT_PARAMS, ...params, ...this.filterData})
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

