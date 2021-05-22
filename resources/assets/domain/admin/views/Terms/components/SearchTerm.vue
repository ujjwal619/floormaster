<template>
  <modal title="Search Term" @close="handleClose">
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
        <label>Term: </label>
        <drop-down
          placeholder="Search Term"
          v-model="termId"
          :options="terms"
          v-validate="'required'"
          name="terms"
        />
        <label class="error">{{ errors.first('terms') }}</label>
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
  name: "SearchTerm",
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
    termId: "",
    terms: [],
    selectedSite: '',
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.fetchTermsBySite(value);
      }
    },
  },
  methods: {
    fetchTermsBySite(siteId) {
      this.enableLoading();
      axios
        .get(`/api/sites/${siteId}/terms`)
        .then(({ data }) => (this.terms = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        )
        .finally(() => this.disableLoading());
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', this.termId);
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
