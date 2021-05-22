<template>
  <modal title="Search Template" @close="handleClose">
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
        <label>Template: </label>
        <drop-down
          placeholder="Search Template"
          v-model="templateId"
          :options="templates"
          v-validate="'required'"
          name="templates"
        />
        <label class="error">{{ errors.first('templates') }}</label>
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
    templateId: "",
    templates: [],
    selectedSite: '',
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.fetchTemplatesBySite(value);
      }
    },
  },
  methods: {
    fetchTemplatesBySite(siteId) {
      this.enableLoading();
      axios
        .get(`/api/sites/${siteId}/templates`)
        .then(({ data }) => (this.templates = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        )
        .finally(() => this.disableLoading());
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', this.templateId);
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
