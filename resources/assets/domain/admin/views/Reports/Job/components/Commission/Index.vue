<template>
    <div class="form-container">
        <loading :loading="loading" />
        <div class="content-wrapper">
            <div class="container-fluid col-v-5" style="background: white;">
                <h2 class="pageHeading"> Sales Commission </h2>
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
                    <template slot="completed_on" slot-scope="{ completed_on }"> {{ completed_on }}</template>
                    <template slot="sales_staff" slot-scope="{ sales_staff }"> {{ sales_staff }}</template>
                    <template slot="job_id" slot-scope="{ job_id }"> {{ job_id }}</template>
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
                    class="float-right"
                    slot="split"
                    slot-scope="{ split }"
                    >
                    {{ split }}
                    </span>
                    <span
                    class="float-right"
                    slot="quoted"
                    slot-scope="{ quoted }"
                    >
                    {{ quoted }}
                    </span>
                    <span
                    class="float-right"
                    slot="invoiced"
                    slot-scope="{ invoiced }"
                    >
                    {{ invoiced }}
                    </span>
                    <span
                    class="float-right"
                    slot="est_margin"
                    slot-scope="{ est_margin }"
                    >
                    {{ est_margin }}
                    </span>
                    <span
                    class="float-right"
                    slot="est_gp"
                    slot-scope="{ est_gp }"
                    >
                    {{ est_gp }}
                    </span>
                    <span
                    class="float-right"
                    slot="split_est"
                    slot-scope="{ split_est }"
                    >
                    {{ split_est }}
                    </span>
                    <span
                    class="float-right"
                    slot="act_margin"
                    slot-scope="{ act_margin }"
                    >
                    {{ act_margin }}
                    </span>
                    <span
                    class="float-right"
                    slot="act_gp"
                    slot-scope="{ act_gp }"
                    >
                    {{ act_gp }}
                    </span>
                    <span
                    class="float-right"
                    slot="split_actual"
                    slot-scope="{ split_actual }"
                    >
                    {{ split_actual }}
                    </span>
                    <span
                    class="float-right"
                    slot="costed_c"
                    slot-scope="{ costed_c }"
                    >
                    {{ costed_c }}
                    </span>
                    <span
                    class="float-right"
                    slot="split_c_c"
                    slot-scope="{ split_c_c }"
                    >
                    {{ split_c_c }}
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
import { getSites, getCommissionReport } from '../../../../../api/calls';
import FmFilter from "../../../../../../common/components/fmFilter/Index"
import FmTableSortable from '../../../../../../common/components/fmTable/Sortable'
import FmPagination from '../../../../../../common/components/FmPagination'
import { formatViewDate } from '../../../../../../common/utitlities/helpers'

const FILTERS = [
    
];

const TABLE_COLUMNS = [
    {
      id: 'completed_on',
      label: 'Completed',
    },
    {
      id: 'sales_staff',
      label: 'Sales Rep',
    },
    {
      id: 'job_id',
      label: 'Job',
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
      id: 'split',
      label: 'Split',
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
      id: 'est_margin',
      label: 'Est Margin',
    },
    {
      id: 'est_gp',
      label: 'Est GP',
    },
    {
      id: 'split_est',
      label: 'Split Est',
    },
    {
      id: 'act_margin',
      label: 'Act Margin',
    },
    {
      id: 'act_gp',
      label: 'Act Gp',
    },
    {
      id: 'split_actual',
      label: 'Split Actual',
    },
    {
      id: 'costed_c',
      label: 'Costed C',
    },
    {
      id: 'split_c_c',
      label: 'Split C C',
    },
];

const DEFAULT_PARAMS = {
    page: 1,
    per_page: 10,
    sort: 'job_id',
    filters: {},
};
  
export default {
    name: 'CommissionReport',
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
        },
        pagination: {},
        sites: [],
        query: DEFAULT_PARAMS,
    }),
    watch: {
      query: {
        deep: true,
        handler(value) {
          // if(value.filters.sales_staff.equals || value.filters.sales_staff.not_equals == false) {
          //   return;
          // }
          this.fetchCommissions(value);

          if (value.filters && !value.filters.sales_staff) {
            const site = this.findSiteByName(value.filters.store_name.equals);
            const salesStaffs = site.sales_staffs.map(staff => {
                return {id: staff.name, value: staff.name};
            })
            this.alteredFilters.push({
                key: 'sales_staff',
                label: 'Sales Staff',
                type: 'Select',
                options: salesStaffs,
            })
          }
          
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

                this.fetchCommissions();
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
    },
    methods: {
        formatViewDate,
        findSiteByName(siteName) {
          return this.sites.find(site => site.name === siteName) || {};
        },
        openModal(type) {
            this[`mount${type}`] = true;
        },
        closeModal(type) {
            this[`mount${type}`] = false;
        },
        exportReport(type) {
            window.location.href = `/api/reports/job/commission/export?${$.param({...this.query, 'type': type})}`;
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
        fetchCommissions(params) {
            this.enableLoading();
            getCommissionReport({...DEFAULT_PARAMS, ...params})
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
