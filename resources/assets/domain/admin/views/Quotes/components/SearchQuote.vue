<template>
  <modal title="Search Quote" @close="handleClose">
    <template slot="modal-body">
      <div class="row">
        <label>Store:</label>
        <drop-down
          :options="sites"
          placeholder="Select Store"
          v-model="selectedSite"
        />
      </div>
      <div class="row pt-2">
        <label>Search Quote</label>
        <drop-down
          placeholder="Search Quote"
          v-model="quote_id"
          :options="quotes"
          v-validate="'required'"
          name="quotes"
          label="quote_id"
        />
        <label class="error">{{ errors.first('quotes') }}</label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Go</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins'
import { getSites } from '../../../api/calls'

export default {
  name: "SearchQuote",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  data: () => ({
    quote_id: "",
    quotes: [],
    sites: [],
    selectedSite: ""
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.fetchQuotesBySite(value);
      }
    },
  },
  created() {
    this.fetchSites();
    this.fetchQuotes();
  },
  methods: {
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchQuotesBySite(siteId) {
      this.enableLoading();
      axios
        .get(`/api/sites/${siteId}/quotes`)
        .then(({ data }) => (this.quotes = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        )
        .finally(() => this.disableLoading());
    },
    fetchQuotes() {
      axios
        .get("/api/quotes")
        .then(({ data }) => (this.quotes = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        );
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          window.location.href = `/quotes/${this.quote_id}/edit`;
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>
