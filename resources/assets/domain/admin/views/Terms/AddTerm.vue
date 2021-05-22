<template>

</template>

<script type="text/ecmascript-6">
  import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
  import DropDown from "../../../common/components/DropDown/DropDown";
  import Form from '../../../common/utitlities/Form'
  import { getSites } from '../../api/calls.js'
  import SearchTerm from './components/SearchTerm'
  import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins/index'

  export default {
    name: "AddTerm",
    mixins: [LoadingMixin, CurrentUserMixin],
    components: {
      PortletContent,
      DropDown,
      SearchTerm
    },
    props: {
      method: {type: String, required: true},
      url: {type: String, required: true},
      redirecturl: {type: String, required: true},
      term: {required: false, type: Object}
    },
    data() {
      return {
        form: new Form(),
        loaded: true,
        values: {
          name: '',
          due: {
            calculated_from: 'completion',
            days: 1,
            days_after: 'invoice_completion'
          },
          metadata: {
            financed: false,
            bills_direct_to_customer: false
          },
          terms: {},
        },
        sites: [],
        mountSearchTerm: false,
      }
    },
    watch: {
      term: {
        handler: function(term){
          if(!term) {
            return
          }
          this.values = term;
          this.values.due = term.due || {};
          this.values.terms = term.terms || {};
          this.values.metadata = term.metadata || {};
        },
        immediate: true
      }
    },
    computed: {
      getSelectedSiteName() {
        if (this.values.site_id && this.sites.length) {
          return this.sites.find(site => site.id === this.values.site_id).name;
        }
        return "";
      },
      isOldEntry() {
        return !!this.values.id;
      }
    },
    created() {
      this.fetchSites();
    },
    methods: {
      openModal(type) {
        this[`mount${type}`] = true;
      },
      closeModal(type) {
        this[`mount${type}`] = false;
      },
      handleSelectedTerm(term) {
        this.closeModal('SearchTerm');
        window.location.href = `/terms/${term}/edit`
      },
      fetchSites() {
        getSites().then(({ data }) => {
          this.sites = data.data;
        });
      },
      handleStoreChange(id) {
        if (id) {
          this.values.site_id = id;
        }
      },
      submit() {
        this.form = new Form(this.values);
        $("html, body").animate({scrollTop: 0}, "slow");
        this.form.onSubmit(this.method, this.url)
          .then(response => {
            this.$toastr('success', this.form.alertMessage, 'Success!!');
            window.location.href = this.redirecturl;
          })
          .catch(errors => {
            this.$toastr('error', this.form.alertMessage, 'Error!!');
          });
      }
    }
  }
</script>

<style scoped>

</style>
