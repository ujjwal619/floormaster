<template>
  <modal title="Shop Search" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row pt-2">
        <label>Select Shop: </label>
        <drop-down
          placeholder="Select Shop"
          :options="sites"
          v-model="site"
          :return-object="true"
          v-validate="'required'"
          name="allocation"
        />
        <label class="error mt-3">{{ errors.first('allocation') }}</label>
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
import { getSites } from "../../../api/calls";

export default {
  name: "SearchAllocation",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
  },
  data: () => ({
    sites: [],
    site: {}
  }),
  created() {
    this.fetchSites();
  },
  methods: {
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', this.site);
          this.handleClose();
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    },
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(() => {
          this.$toastr('error', 'Could not fetch Stores', 'Error!!')
        })
        .finally(this.disableLoading);
    },
  }
};
</script>
