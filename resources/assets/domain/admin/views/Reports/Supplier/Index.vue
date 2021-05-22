<template>
    <div class="form-container">
        <loading :loading="loading" />
        <div class="content-wrapper">
            <div class="container-fluid col-v-5" style="background: white;">
                <h2 class="pageHeading"> Suppliers </h2>
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
                    <template slot="id" slot-scope="{ id }"> {{ id }}</template>
                    <span
                    slot="trading_name"
                    slot-scope="{ trading_name }"
                    >
                    {{ trading_name }}
                    </span>
                    <span
                    slot="address"
                    slot-scope="{ address }"
                    >
                    {{ address }}
                    </span>
                    <span
                    slot="contact"
                    slot-scope="{ contact }"
                    >
                    {{ contact }}
                    </span>
                    <span
                    slot="site_name"
                    slot-scope="{ site_name }"
                    >
                    {{ site_name }}
                    </span>
                </fm-table-sortable>
                </div>
                <img :src="require('../../../../../../../public/images/fm-logo.png')"/>
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

import { LoadingMixin } from '../../../../common/mixins';
import { getSites, getSuppliersReport } from '../../../api/calls';
import FmFilter from "../../../../common/components/fmFilter/Index"
import FmTableSortable from '../../../../common/components/fmTable/Sortable'
import FmPagination from '../../../../common/components/FmPagination'

const FILTERS = [
    {
      key: 'id',
      label: 'Id',
      type: 'Number',
    },
    {
      key: 'trading_name',
      label: 'Name',
      type: 'String',
    },
];

const TABLE_COLUMNS = [
    {
      id: 'id',
      label: 'Id',
    },
    {
      id: 'trading_name',
      label: 'Name',
    },
    {
      id: 'address',
      label: 'Address',
    },
    {
      id: 'contact',
      label: 'Contact',
    },
    {
      id: 'site_name',
      label: 'Store',
    },
];

const DEFAULT_PARAMS = {
    page: 1,
    per_page: 10,
    sort: 'id',
    filters: {},
};
  
export default {
    name: 'SupplierReport',
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
            id: 'dsc',
            trading_name: 'default',
            site_name: 'default',
        },
        pagination: {},
        sites: [],
        query: DEFAULT_PARAMS,
    }),
    watch: {
      query: {
        deep: true,
        handler(value) {
          console.log(value);
          this.fetchSuppliers(value);
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
                    key: 'site_name',
                    label: 'Store',
                    type: 'Select',
                    options: sites,
                })
                this.fetchSuppliers();
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
    },
    methods: {
        openModal(type) {
            this[`mount${type}`] = true;
        },
        closeModal(type) {
            this[`mount${type}`] = false;
        },
        exportSupplierReport() {
            window.location.href = `/api/suppliers/report/export?${$.param(this.query)}`;
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
        fetchSuppliers(params) {
            this.enableLoading();
            getSuppliersReport({...DEFAULT_PARAMS, ...params})
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
