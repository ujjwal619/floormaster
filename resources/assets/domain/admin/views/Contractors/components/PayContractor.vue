<template>
  <div key="select-contractor">
    <div class="row">
      <label class="col-4 text-right pr-2">Select Site</label>
      <div class="col-7">
        <drop-down
          v-model="selectedSite"
          :options="sites"
          name="site"
          :default-selected="selectedSiteObject"
          v-validate="'required'"
        />
        <label class="error">{{ errors.first('contractor') }}</label>
      </div>
    </div>
    <div class="row pt-4">
      <label class="col-4 text-right pr-2">Select Contractor</label>
      <div class="col-7">
        <drop-down
          v-model="model.contractor_id"
          :options="contractors"
          name="contractor"
          :default-selected="selectedContractorObject"
          v-validate="'required'"
        />
        <label class="error">{{ errors.first('contractor') }}</label>
      </div>
    </div>
    <div class="row pt-4">
      <label class="col-4 text-right pr-2">Pay up to: </label>
      <div class="col-7">
        <input type="date" class="form-control" name="pay up to" v-validate="'required'" v-model="model.pay_up_to"/>
        <label>(inclusive date)</label>
        <label class="error">{{ errors.first('pay up to') }}</label>
      </div>
    </div>
  </div>
</template>

<script>

import DropDown from "../../../../common/components/DropDown/DropDown";
import { getSites } from "../../../api/calls"
import { formatDate } from '../../../../common/utitlities/helpers';

export default {
  name: 'PayContractor',
  components: {
    DropDown,
  },
  props: {
    siteId: {
      type: Number,
      required: true,
    },
    contractorId: {
      type: Number,
      required: true,
    },
  },
  data: () => ({
    model: {
      contractor_id: '',
      pay_up_to: formatDate(new Date()),
    },
    contractors: [],
    sites: [],
    selectedSite: '',
    selectedSiteObject: {},
    selectedContractorObject: {},
  }),
  watch: {
    model: {
      deep: true,
      immediate: true,
      handler(value) {
        return this.$emit('updated', value);
      }
    },
    selectedSite(value) {
      if (value) {
        if (value !== this.siteId) {
          this.selectedContractorObject = {};
        }
        this.fetchContractors(value);
      }
    },
    siteId: {
      immediate: true,
      handler(value) {
        this.fetchSites()
          .then(() => {
            this.selectedSiteObject = this.sites.find(site => site.id === value)
          });
      }
    },
    contractorId: {
      immediate: true,
      handler(value) {
        this.fetchContractors(this.siteId)
          .then(() => {
            this.selectedContractorObject = this.contractors.find(contractor => contractor.id === value);
          })
      }
    },
  },
  created() {
  },
  methods: {
    fetchContractors(siteId) {
      return axios
        .get(`/api/sites/${siteId}/contractors`)
        .then(({ data }) => (this.contractors = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        );
    },
    fetchSites() {
      return getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(error => console.log(error));
    },
  },
}
</script>
