<template>
  <modal title="Search Contractor" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>Store:</label>
        <drop-down
          :options="sites"
          v-model="selectedSite"
        />
      </div>
      <div class="row pt-2">
        <label>Contractor: </label>
        <drop-down
          placeholder="Search Contractor"
          v-model="contractorId"
          :options="contractors"
          v-validate="'required'"
          name="contractors"
          label="tfn"
        >
          <template slot="singleLabel" slot-scope="{ data }">{{ data.tfn + ' Name: ' + (data.name || '') }}</template>
          <template slot="option" slot-scope="{ data }"><span>{{ data.tfn + ' Name: ' + (data.name || '') }}</span></template>
        </drop-down>
        <label class="error">{{ errors.first('contractors') }}</label>
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

export default {
  name: "SearchContractor",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    sites: {
      type: Array,
      required: true,
    },
  },
  data: () => ({
    contractorId: "",
    contractors: [],
    selectedSite: '',
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.fetchContractorsBySite(value);
      }
    },
  },
  methods: {
    fetchContractorsBySite(siteId) {
      this.enableLoading();
      axios
        .get(`/api/sites/${siteId}/contractors`)
        .then(({ data }) => (this.contractors = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        )
        .finally(() => this.disableLoading());
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', this.contractorId);
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
