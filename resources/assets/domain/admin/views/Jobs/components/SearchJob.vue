<template>
  <modal title="Search Job" @close="handleClose">
    <loading :loading="loading" />
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
        <label>Search Job</label>
        <drop-down
          placeholder="Search Job"
          v-model="job_id"
          :options="jobs"
          v-validate="'required'"
          name="jobs"
          label="job_id"
        />
        <label class="error">{{ errors.first('jobs') }}</label>
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
  name: "SearchJob",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  data: () => ({
    job_id: "",
    jobs: [],
    sites: [],
    selectedSite: ""
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.fetchJobsBySite(value);
      }
    },
  },
  created() {
    this.fetchSites();
    this.fetchJobs();
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
    fetchJobs() {
      this.enableLoading();
      axios
        .get("/api/jobs")
        .then(({ data }) => (this.jobs = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        )
        .finally(() => this.disableLoading());
    },
    fetchJobsBySite(siteId) {
      this.enableLoading();
      axios
        .get(`/api/sites/${siteId}/jobs`)
        .then(({ data }) => (this.jobs = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        )
        .finally(() => this.disableLoading());
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          window.location.href = `/jobs/${this.job_id}/edit`;
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
