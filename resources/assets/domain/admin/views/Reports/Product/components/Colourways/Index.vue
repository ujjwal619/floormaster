<template>
    <div class="form-container">
        <loading :loading="loading" />
        <div class="content-wrapper">
            <div class="container-fluid col-v-5" style="background: white;">
                <h2 class="pageHeading"> GST Inclusive Price List </h2>
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
                    <template slot="code" slot-scope="{ code }"> {{ code }}</template>
                    <span
                    slot="supplier_name"
                    slot-scope="{ supplier_name }"
                    >
                    {{ supplier_name }}
                    </span>
                    <span
                    slot="range"
                    slot-scope="{ range }"
                    >
                    {{ range }}
                    </span>
                    <span
                    slot="colour_name"
                    slot-scope="{ colour_name }"
                    >
                    {{ colour_name }}
                    </span>
                    <span
                    slot="site_name"
                    slot-scope="{ site_name }"
                    >
                    {{ site_name }}
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
import { 
    getSites, 
    getProductReport, 
    getSuppliers,
    getProductCategories,
    getColourwaysReport
} from '../../../../../api/calls';
import FmFilter from "../../../../../../common/components/fmFilter/Index"
import FmTableSortable from '../../../../../../common/components/fmTable/Sortable'
import FmPagination from '../../../../../../common/components/FmPagination'
import { 
    displayMoney, 
    displayNumber, 
    formatViewDate
} from '../../../../../../common/utitlities/helpers' 

const FILTERS = [
    // {
    //   key: 'id',
    //   label: 'Id',
    //   type: 'Number',
    // },
];

const TABLE_COLUMNS = [
    {
      id: 'code',
      label: 'Code',
    },
    {
      id: 'supplier_name',
      label: 'Supplier',
    },
    {
      id: 'range',
      label: 'Range',
    },
    {
      id: 'colour_name',
      label: 'Colour',
    },
    {
      id: 'site_name',
      label: 'Store',
    },
];

const DEFAULT_PARAMS = {
    page: 1,
    per_page: 10,
    sort: 'code',
    filters: {},
};
  
export default {
    name: 'Colourways',
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
        suppliers: [],
        categories: [],
        sortableColumns: {
            code: 'dsc',
        },
        pagination: {},
        sites: [],
        query: DEFAULT_PARAMS,
    }),
    watch: {
      query: {
        deep: true,
        handler(value) {
          this.fetchColourwaysReport(value);
          this.fetchSuppliers(value);
          this.fetchCategories(value);
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
                this.fetchColourwaysReport();
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
    },
    methods: {
        displayMoney,
        displayNumber,
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
            window.location.href = `/api/reports/product/colourways/export?${$.param({...this.query, 'type': type})}`;
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
        fetchColourwaysReport(params) {
            this.enableLoading();
            getColourwaysReport({...DEFAULT_PARAMS, ...params})
            .then(({ data }) => {
                this.logs = data.data;
                this.pagination = data.meta;
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
        },
        fetchSuppliers(params) {
            if (params.filters.site_name && params.filters.site_name.equals) {
                this.enableLoading();
                const site = this.findSiteByName(params.filters.site_name.equals);
                getSuppliers({site_id: site.id})
                    .then(({ data }) => {
                        this.suppliers = data.data;
                        if (params.filters && !params.filters.supplier_name) {
                            const suppliers = data.data.map(supplier => {
                                return {id: supplier.name, value: supplier.name};
                            })
                            console.log('sup', suppliers);
                            this.alteredFilters.push({
                                key: 'supplier_name',
                                label: 'Supplier',
                                type: 'Select',
                                options: suppliers,
                            })
                        }
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.disableLoading());
            }
        },
        fetchCategories(params) {
            if (params.filters.site_name && params.filters.site_name.equals) {
                this.enableLoading();
                const site = this.findSiteByName(params.filters.site_name.equals);
                getProductCategories({site_id: site.id})
                    .then(({ data }) => {
                        this.categories = data.data;
                        if (params.filters && !params.filters.category_name) {
                            const categories = data.data.map(category => {
                                return {id: category.name, value: category.name};
                            })
                            console.log('cat', categories);
                            this.alteredFilters.push({
                                key: 'category_name',
                                label: 'Category',
                                type: 'Select',
                                options: categories,
                            })
                        }
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.disableLoading());
            }
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
