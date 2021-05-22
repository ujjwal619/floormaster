<script>
import axios from "axios";
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import Modal from "../../../common/components/Modal/Modal";
import DropDown from "../../../common/components/DropDown/DropDown";
import TermsModal from "../../../common/components/TermsModal";
import SampleLoan from "./components/SampleLoan";
import SearchClient from "./components/SearchClients";
import StateModal from '../../../common/components/StateModal';
import { formatViewDate, displayMoney } from '../../../common/utitlities/helpers';
import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins/index'

const BASE_MODEL = {
  title: "",
  first_name: "",
  surname_co: "",
  street: "",
  town: "",
  state: "",
  code: "",
  attention: "",
  home_ph: "",
  mobile: "",
  work_ph: "",
  fax: "",
  email: "",
  terms: {},
  key_no: "",
  notes: "",
  address: {},
};

export default {
  name: "Clients",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    DropDown,
    Modal,
    PortletContent,
    SampleLoan,
    SearchClient,
    StateModal,
    TermsModal,
  },
  data: () => ({
    isEditMode: false,
    modelCache: { ...BASE_MODEL },
    model: { ...BASE_MODEL },
    mountSampleLoan: false,
    mountSearchClient: false,
    mountStateModal: false,
    mountTermsModal: false,
    sites: [],
    selectedSite: null,
    relatedJobs: [],
    relatedJobsCache: [],
    values: {},
    term: {},
  }),
  computed: {
    totalQuoted() {
      return this.relatedJobs.reduce((sum, job) => {
        return sum + Number(job.gst_inclusive_quote);
      }, 0);
    },
    totalInvoiced() {
      return this.relatedJobs.reduce((sum, job) => {
        return sum + Number(job.invoiced);
      }, 0);
    },
    totalBalance() {
      return this.relatedJobs.reduce((sum, job) => {
        return sum + Number(job.balance);
      }, 0);
    },
    getSelectedSiteName() {
      if (this.selectedSite && this.sites.length) {
        return this.sites.find(site => site.id === this.selectedSite).name;
      }
      return "";
    },
    isOldEntry() {
      return !!this.model.id;
    }
  },
  created() {
    this.fetchSites();
    this.indexPage();
  },
  methods: {
    formatViewDate,
    displayMoney,
    redirectToJob(job) {
      window.location.href = `/jobs/${job.id}/edit`
    },
    handleTermUpdate(term) {
      this.term = term;
      this.model.term_id = term.id;
    },
    handleStoreChange(id) {
      if (id) {
        this.values.site_id = id;
      }
    },
    handleAddClient() {
      this.modelCache = this.model;
      this.relatedJobsCache = this.relatedJobs;
      this.model = { ...BASE_MODEL };
      this.relatedJobs = [];
      this.changeEditMode(true);
    },
    indexPage() {
      axios
        .get('/api/clients/index')
        .then(({ data }) => {
          if (data.data.id) {
            this.fetchClient(data.data.id);
            // const address = data.data.address ? JSON.parse(data.data.address) : {};
            // this.model = { ...data.data, address:(Array.isArray(address)) ? {} : address };
            // this.selectedSite = this.model.site_id;
            // this.model.terms = this.model.terms ? JSON.parse(this.model.terms) : {};
            // axios.get(`/api/clients/${this.model.id}/jobs`)
            //   .then(({ data }) => {
            //     this.relatedJobs = data.data;
            //   })
          }
        })
        .catch(error => {

        })
    },
    fetchSites() {
      axios.get("/api/sites").then(({ data }) => {
        this.sites = data.data;
      })
        .catch(error => {

        });
    },
    openAddSampleLoan() {
      this.mountSampleLoan = true;
    },
    closeAddSampleLoan() {
      this.mountSampleLoan = false;
    },
    changeEditMode(val) {
      this.isEditMode = !!val;
    },
    enableEdit() {
      this.modelCache = this.model;
      this.relatedJobsCache = this.relatedJobs;
      this.changeEditMode(true);
    },
    cancelEditMode() {
      this.model = { ...this.modelCache };
      this.relatedJobs = [ ...this.relatedJobsCache ];
      this.changeEditMode(false);
    },
    saveHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.saveClient();
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    saveClient() {
      const method = this.isOldEntry ? "put" : "post";
      const url = this.isOldEntry ? `api/clients/${this.model.id}` : `/api/sites/${this.selectedSite}/clients`;
      const msg = this.isOldEntry ? "update" : "create";
      axios[method](url, this.model)
        .then(({ data }) => {
          this.changeEditMode(false);
          this.$toastr(
            "success",
            `Successfully ${msg}d Client`,
            "Success!!"
          );
        })
        .catch(error => {
          this.$toastr("error", `Could not ${msg} Client`, "Error!!");
        });
    },
    openModal(type) {
      if (type) {
        this[`mount${type}`] = true;
      }
    },
    closeModal(type) {
      if (type) {
        this[`mount${type}`] = false;
      }
    },
    selectNewState({ state, suburb, code }) {
      this.model.address.state = state;
      this.model.address.town = suburb;
      this.model.address.code = code;
    },
    handleSelectedClient(client) {
      this.closeModal('SearchClient');
      this.fetchClient(client);
    },
    fetchClient(id) {
      axios.get(`/api/clients/${id}`).then(({ data }) => {
        this.model = data.data;
        this.selectedSite = this.model.site_id;
        this.model.address = this.model.address || {};
        this.model.terms = this.model.terms || {};
        this.term = this.model.term || {};
        axios.get(`/api/clients/${this.model.id}/jobs`)
          .then(({ data }) => {
            this.relatedJobs = data.data;
          })
      })
        .catch(error => console.log(error))
    },
  }
};
</script>

<style scoped>
.background-black {
  background-color: black;
  color: #fff;
  width: fit-content;
  height: fit-content;
  padding: 4px;
}
</style>
