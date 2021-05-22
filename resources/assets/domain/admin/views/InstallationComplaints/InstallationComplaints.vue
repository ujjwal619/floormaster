<template>
    
</template>

<script>
  import {isEmpty} from "../../../common/utitlities/helpers";
  import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
  import Form from '../../../common/utitlities/Form'
  import Modal from '../../../common/components/Modal/Modal'
  import DropDown from '../../../common/components/DropDown/DropDown'
  import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins/index'
  import { 
    getSites, 
    getInstallationComplaints,
    getJobsBySite
  } from '../../api/calls';

  export default {
    name: "InstallationComplaints",
    mixins: [LoadingMixin, CurrentUserMixin],
    components: {
      PortletContent,
      Modal,
      DropDown
    },
    props: {
      complaint: {
        type: Object,
        default: () => ({})
      },
      // jobs: {
      //   type: Array,
      //   default: () => ([])
      // },
      job: {
        type: Object,
        default: () => ({})
      },
    },
    data() {
      return {
        complaints: [],
        jobs: [],
        form: new Form(),
        selectedJob: '',
        selectedSiteAddComplaint: '',
        modals: {
          addComplaint: {
            show: false,
            values: {},
          },
          searchComplaint: {
            show: false,
            values: {}
          },
        },
        values: {},
        sites: [],
        alteredSites: [
          {
            id: 0,
            name: 'All Stores',
          }
        ],
        selectedSite: '', 
      };
    },
    watch: {
      complaint: {
        handler: function (complaint) {
          if (isEmpty(complaint)) {
            return
          }
          return this.mapEditComplaintToValue(complaint)
        },
        immediate: true
      }, 
      selectedSiteAddComplaint: {
        immediate: true,
        handler(site) {
          console.log('watcher', site);
          if (site) {
            this.fetchJobsBySite(site);
          }
        }
      },
      selectedSite: {
        immediate: true,
        handler(site) {
          this.fetchInstallationComplaints({site_id: site});
        }
      },
    },
    computed: {
      isEdit() {
        return !isEmpty(this.complaint);
      },
      customer() {
        return this.job.customer || {};
      },
      address() {
        return this.job.address || {};
      },
      fullAddress() {
        return `${ this.address.street || '' }, ${ this.address.town || ''}, ${ this.address.state || ''}, ${ this.address.code || ''}`;
      },
      primarySalesPerson() {
        return this.job.primary_sales_person || [];
      },
      jobSalesPerson() {
        if (this.primarySalesPerson.length) {
          return this.primarySalesPerson[0].name;
        }
        return this.job.sales ? this.job.sales[0].name : '';
      },
      getSalesPersonName() {
        return this.isEdit ? this.values.sales_person : `${this.jobSalesPerson}`;
      }
    },
    created() {
      this.fetchSites();
    },
    methods: {
      fetchInstallationComplaints(params) {
        this.enableLoading();
        getInstallationComplaints(params).then(({ data }) => {
          this.complaints = data.data;
        })
          .catch(err => this.$toastr("error", "Could not get complaints.", "Error!!"))
          .finally(this.disableLoading);
      },
      fetchSites() {
        this.enableLoading();
        getSites().then(({ data }) => {
          this.sites = data.data;
          this.alteredSites = [...this.alteredSites, ...data.data];
          this.fetchJobsBySite(this.sites[0].id);
        })
          .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
          .finally(this.disableLoading);
      },
      fetchJobsBySite(siteId) {
        this.enableLoading();
        getJobsBySite(siteId).then(({ data }) => {
          this.jobs = data.data;
        })
          .catch(err => this.$toastr("error", "Could not get jobs data.", "Error!!"))
          .finally(this.disableLoading);
      },
      show() {
        this.modals.addComplaint.show = true;
      },
      hide() {
        if (this.$refs.jobSelect) {
          this.$refs.jobSelect.reset();
        }
        this.modals.addComplaint.show = false;
      },
      validate() {
        return this.$validator.validate();
      },
      addComplaint() {
        this.validate().then(valid => {
          if (valid) {
            location.href = `/installation-complaints/create?job=${this.selectedJob}`;
          }
        });
      },
      submit() {
        const values = ({ ...this.values, job_id: this.job.id, project: this.job.project, sales_person: this.getSalesPersonName });
        this.form = new Form(values);
        const method = this.isEdit ? 'put' : 'post';
        const url = this.isEdit ? `/installation-complaints/${this.complaint.id}` : '/installation-complaints';
        this.form.onSubmit(method, url)
          .then(response => {
            this.$toastr('success', this.form.alertMessage, 'Success!!');
            window.location.href = '/installation-complaints';
          })
          .catch(errors => {
            this.$toastr('error', this.form.alertMessage, 'Error!!')
          })
      },
      mapEditComplaintToValue(installationComplaint) {
        this.values = ({ ...installationComplaint });
      },
      deleteComplaint() {
        const isConfirmed = window.confirm('Are you sure?')
        if (isConfirmed) {
          axios.delete(`/installation-complaints/${this.complaint.id}`)
            .then(() => {
              this.$toastr('success', 'Successfully Deleted Installation Complaints', 'Success!!');
              window.location.href = '/installation-complaints'
            })
            .catch(() => {
              this.$toastr('error', 'Could not delete Complaint.', 'Error!!')
            })
        }
      },
      showSearchModal() {
        this.modals.searchComplaint.show = true;
      },
      hideSearchModal() {
        this.modals.searchComplaint.show = false;
      },
      searchComplaint() {
        const complaint = this.modals.searchComplaint.values.complaint;
        if (complaint) {
          window.location.href = `/installation-complaints/${complaint}/edit`;
        }
      },
    }
  }
</script>

<style scoped>

</style>
