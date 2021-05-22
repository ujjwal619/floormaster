<template>
  <modal title="Create New Job" @close="handleClose" :is-large="isFirstPage">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div v-show="isFirstPage">
        <div class="row">
          <div class="col-6 row align-items-center">
            <label class="col-4 text-right">(1) Select Store</label>
            <div class="col-7">
              <drop-down
                placeholder="Search Store"
                v-model="model.store_id"
                :options="sites"
                v-validate="'required'"
                name="store"
              />
              <label class="error">{{ errors.first('store') }}</label>
            </div>
          </div>
          <div class="col-6 row align-items-center">
            <label class="col-4 text-right">(3) Select Terms</label>
            <div class="col-7">
              <drop-down placeholder="Search Terms" v-model="model.term" :options="terms" :return-object="true" />
              <label class="error">{{ errors.first('terms') }}</label>
            </div>
          </div>
        </div>
        <div class="row pt-3">
          <div class="col-6 row align-items-center">
            <label class="col-4 text-right">(2) Select B.U.</label>
            <drop-down
              ref="shopSelect"
              class="col-7"
              placeholder="Search B.U."
              v-model="model.shop_id"
              :options="shops"
              name="shops"
            />
          </div>
          <div class="col-6 row align-items-center">
            <label class="col-4 text-right">(4) Select Source</label>
            <div class="col-7">
              <drop-down
                ref="sourceSelect"
                placeholder="Search Source"
                v-model="model.source_id"
                :options="jobSources"
                v-validate="'required'"
                name="sources"
                label="title"
              />
              <label class="error">{{ errors.first('sources') }}</label>
            </div>
          </div>
        </div>
        <div class="row pt-3">
          <div class="col-6 row align-items-center">
            <label class="col-4 text-right">(5) Select one or more Template/s</label>
            <drop-down
              ref="templatesSelect"
              class="col-7"
              placeholder="Search template"
              :multiple="true"
              :allow-empty="true"
              v-model="model.templates"
              :options="templates"
              :show-multiple-label="false"
              name="templates"
            >
              <template slot="selection" slot-scope="{ data }">
                <span class="multiselect__single" v-if="data.values.length &amp;&amp; !data.isOpen">{{ data.values.length }} template selected</span>
              </template>
              <template slot="option" slot-scope="{ data }"><span>{{ data.name }}</span></template>
            </drop-down>
            <label class="error">{{ errors.first('templates') }}</label>
          </div>
          <div class="col-6 row align-items-center">
            <label class="col-4 text-right">(6) Select Sales Person/s</label>
            <div class="col-7">
              <drop-down
                ref="salesPersonSelect"
                placeholder="Search Sales Person"
                :multiple="true"
                v-model="model.sales_person"
                :allow-empty="true"
                :options="salesStaffs"
                :show-multiple-label="false"
                v-validate="'required'"
                name="sales person"
              >
                <template slot="selection" slot-scope="{ data }">
                  <span class="multiselect__single" v-if="data.values.length &amp;&amp; !data.isOpen">{{ data.values.length }} sales staff selected</span>
                </template>
                <template slot="option" slot-scope="{ data }"><span>{{ data.name }}</span></template>
              </drop-down>
              <label class="error">{{ errors.first('sales person') }}</label>
            </div>
          </div>
        </div>
        <div class="row pt-3">
          <label class="col-2 text-right">(7) Enter Job Date</label>
          <input
            class="col-4 form-control"
            type="date"
            v-model="model.quote_date"
            name="job date"
            v-validate="'required'"
          />
          <label class="error">{{ errors.first('job date') }}</label>
        </div>
        <div class="row pt-3">
          <div class="col-6 row">
            <fieldset>
              <legend>Creation Method</legend>
              <label class="w-50">
                <input type="radio" v-model="creation_method" :value="0" name="creation method" v-validate="'required'" />
                <span class="pl-1">Copy Job: Name</span>
              </label>
              <label class="w-50">
                <input type="radio" v-model="creation_method" :value="1" name="creation method" />
                <span class="pl-1">Select From Client List</span>
              </label>
              <label class="w-50">
                <input type="radio" v-model="creation_method" :value="2" name="creation method" />
                <span class="pl-1">Manual Detail Entry</span>
              </label>
            <label class="error">{{ errors.first('creation method') }}</label>
            </fieldset>
          </div>
          <div class="col-6 row justify-content-center align-items-center">
            <label>
              <input type="checkbox" v-model="model.completed" />
              100% completed
            </label>
            <label>
              <input type="checkbox" v-model="model.batch_mode" />
              Batch Mode
            </label>
          </div>
        </div>
      </div>
      <component
        :is="getSecondComponent"
        v-show="!isFirstPage && getSecondComponent"
        :customers="customers"
        :sales="selectedSalesStaffs"
        @client="selectClientHandler"
        @primaryrep="selectPrimaryRepHandler"
        @copy="copyJobHandler"
      />
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="nextButtonHandler">Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import CopyJob from "./CopyJob.vue";
import ChoosePrimaryRep from "../../Quotes/components/ChoosePrimaryRep.vue";
import SelectClient from "./SelectClient.vue";
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins'
import { formatDate } from '../../../../common/utitlities/helpers';

const PAGE_LIST = ["CopyJob", "SelectClient", "ChoosePrimaryRep"];

export default {
  name: "JobModal",
  mixins: [LoadingMixin],
  components: {
    CopyJob,
    DropDown,
    Modal,
    SelectClient,
    ChoosePrimaryRep
  },
  data: () => ({
    model: {
      store_id: "",
      term: {},
      sales_person: "",
      source_id: "",
      quote_date: formatDate(new Date()),
      client_id: "",
      primary_rep: "",
      particulars: "",
      text: "",
      costing: "",
      batch_mode: false,
      completed: false
    },
    creation_method: null,
    page: 1,
    secondPageComponent: 0,
    sites: [],
    shops: [],
    jobSources: [],
    salesStaffs: [],
    terms: [],
    templates: [],
    customers: []
  }),
  computed: {
    isFirstPage() {
      return this.page === 1;
    },
    getSecondComponent() {
      return PAGE_LIST[this.secondPageComponent];
    },
    selectedSalesStaffs() {
      return this.salesStaffs.filter(sale =>
        this.model.sales_person.includes(sale.id)
      );
    }
  },
  watch: {
    "model.store_id": {
      handler(id) {
        this.fetchJobSourcesAndSalesStaff(id);
      }
    }
  },
  created() {
    this.fetchSites();
  },
  methods: {
    fetchClients(id) {
      axios
        .get(`/api/sites/${id}/clients`)
        .then(({ data }) => {
          this.customers = data.data;
        })
        .catch(error => console.log("could not fetch clients"));
    },
    selectPrimaryRepHandler(saleId) {
      this.model.primary_rep = saleId;
    },
    fetchJobSourcesAndSalesStaff(id) {
      this.model.templates = [];
      this.model.sales_person = [];
      this.model.source_id = "";
      if (this.$refs.salesPersonSelect) {
        this.$refs.salesPersonSelect.reset();
      }
      if (this.$refs.templatesSelect) {
        this.$refs.templatesSelect.reset();
      }
      if (this.$refs.sourceSelect) {
        this.$refs.sourceSelect.reset();
      }
      if (id) {
        this.enableLoading();
        Promise.all
          ([this.fetchJobSources(id),
          this.fetchSalesStaff(id),
          this.fetchTerms(id),
          this.fetchTemplates(id),
          this.fetchShops(id),
          this.fetchClients(id)])
          .then(this.disableLoading);
      }
    },
    fetchShops(id) {
      return axios
        .get(`/api/sites/${id}/shops`)
        .then(({ data }) => {
          this.shops = data.data;
        })
        .catch(err => console.log(err));
    },
    fetchTemplates(id) {
      return axios
        .get(`/api/sites/${id}/templates`)
        .then(({ data }) => {
          this.templates = data.data;
        })
        .catch(err => console.log(err));
    },
    fetchSites() {
      this.enableLoading();
      axios
        .get("/api/sites")
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(err => console.log(err))
        .finally(this.disableLoading);
    },
    fetchJobSources(id) {
      return axios
        .get(`/api/sites/${id}/sources`)
        .then(({ data }) => {
          this.jobSources = data.data;
        })
        .catch(err => console.log(err));
    },
    fetchSalesStaff(id) {
      return axios
        .get(`/api/sites/${id}/sales_staff`)
        .then(({ data }) => {
          this.salesStaffs = data.data;
        })
        .catch(err => console.log(err));
    },
    fetchTerms(id) {
      return axios
        .get(`/api/sites/${id}/terms`)
        .then(({ data }) => {
          this.terms = data.data;
        })
        .catch(err => console.log(err));
    },
    nextButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          if (!this.model.primary_rep && this.model.sales_person.length > 1) {
            this.page = 2;
            this.secondPageComponent = 2;
          } else if (this.creation_method !== 2 && this.page !== 3) {
            this.secondPageComponent = this.creation_method;
            this.page = 3;
          } else {
            this.saveJob();
          }
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    saveJob() {
      this.$emit("jobdata", { ...this.model });
      this.handleClose();
    },
    selectClientHandler(clientId) {
      this.model.client_id = clientId.client_id;
    },
    copyJobHandler(copyParams) {
      this.model = Object.assign({}, this.model, copyParams);
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>

<style scoped>
fieldset {
  min-width: auto;
  padding: 5px 15px;
  margin: auto;
  width: 100%;
  border: 2px solid rgb(192, 192, 192);
}

legend {
  width: auto;
  padding: unset;
  margin: unset;
  font-size: unset;
}
</style>
