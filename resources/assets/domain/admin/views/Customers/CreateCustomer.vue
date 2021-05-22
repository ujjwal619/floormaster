<template>

</template>

<script>
    import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
    import Form from '../../../common/utitlities/Form'
    import Vue from "vue";

    export default {
        name: "CreateCustomer",
        props: {
            url: {
                required: true
            },
            method: {
                type: String,
                default: "post"
            },
            customer: {
                required: false
            },
            jobsources: {
                required: true
            },
            sales: {
                required: true
            },
            selectedjobs: {
                required: false
            },
            selectedsales: {
                required: false
            },
            selectedsites: {
                required: false
            },
            settings: {
                required: false
            }
        },
        data() {
            return {
                form: new Form(),
                loaded: true,
                formSubmitting: true,
                shop_name: null,
                gl_suffix: null,
                selectedJob: '',
                selectedSale: '',
                values: {
                    customer: {
                        address: {},
                        postal_address: {},
                        delivery_address: {},
                    },
                    selectedJobs: [],
                    selectedSales: [],
                    sites: [],
                    deletedSites: [],
                    settings: {
                        gl_recording: 'on',
                        remittance_printing: 'letter_head',
                        automated_stock_control: [],
                        prompts: []
                    }
                },
            }
        },
        components: {
            PortletContent
        },
        mounted() {
            if (this.method === 'patch') {
                this.loadCustomer();
            }
        },
        methods: {
            /**
             * Proceed towards the form submission.
             *  */
            submit() {
                this.form = new Form(this.values);
                $("html, body").animate({scrollTop: 0}, "slow");
                this.form.onSubmit(this.method, this.url)
                        .then(response => {
                            this.$toastr('success', this.form.alertMessage, 'Success!!');
                            window.location.href = this.url;
                        })
                        .catch(() => {
                            this.$toastr('error', this.form.alertMessage, 'Error!!');
                        });
            },
            /**
             * Load the customer to form.
             */
            loadCustomer() {
                this.values.customer = JSON.parse(this.customer);
                this.values.selectedJobs = JSON.parse(this.selectedjobs);
                this.values.selectedSales = JSON.parse(this.selectedsales);
                this.values.sites = JSON.parse(this.selectedsites);
                this.values.settings = JSON.parse(this.settings).general;
            },
            /**
             * Handle site edit click.
             * @param index
             */
            handleSiteEditClick(index) {
                let sites = [...this.values.sites];
                let site = sites[index];
                site.is_edit = !site.is_edit;

                Vue.set(this.values.sites, index, site);
            },
            /**
             * Add job sources.
             */
            addJobSources() {
                if (this.selectedJob && !this.values.selectedJobs.includes(this.selectedJob)) {
                    this.values.selectedJobs.push(this.selectedJob);
                    this.selectedJob = '';
                }
            },
            /**
             * Remove the job sources from the selected list.
             * @param index
             */
            removeJobSource(index) {
                this.values.selectedJobs.splice(index, 1);
            },
            /**
             * Add job sources.
             */
            addSalesStaff() {
                if (this.selectedSale && !this.values.selectedSales.includes(this.selectedSale)) {
                    this.values.selectedSales.push(this.selectedSale);
                    this.selectedSale = '';
                }
            },
            /**
             * Remove the job sources from the selected list.
             * @param index
             */
            removeSalesStaff(index) {
                this.values.selectedSales.splice(index, 1);
            },
            getJobName(id) {
                let jobs = JSON.parse(this.jobsources);

                return jobs[id];
            },
            /**
             * Get the sales full name when id is provided.
             * @param id
             * @returns {*}
             */
            getSalesName(id) {
                let sales = JSON.parse(this.sales);
                return sales[id].first_name + ' ' + sales[id].last_name;
            },
            /**
             * Add new site to data object.
             */
            addNewSite() {
                if (this.shop_name !== null) {
                    let site = {
                        shop_name: this.shop_name,
                        gl_suffix: this.gl_suffix
                    };
                    this.values.sites.push(site);
                    this.shop_name = null;
                    this.gl_suffix = null;
                }
            },
            /**
             * Remove the site when index is provided.
             * @param {int} index
             * @param {Object} site
             */
            removeSite(index, site) {
                if (site.hasOwnProperty('id')) {
                    this.values.deletedSites.push(site.id);
                }
                this.values.sites.splice(index, 1);
            },
        }
    }
</script>

<style lang="scss">
    .m-portlet {
        .m-portlet__head {
            padding: 0 1.0rem;
        }
        .m-portlet__body {
            padding: 1.0rem 1.0rem;
        }
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .mt-28 {
        margin-top: 28px;
    }
</style>
