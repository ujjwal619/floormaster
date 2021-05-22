<template>
  <modal title="Shop Search" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>Select Store: </label>
        <drop-down
          placeholder="Select Store"
          :options="alteredSites"
          v-model="site"
          :return-object="true"
          v-validate="'required'"
          name="site"
        />
        <label class="error mt-3">{{ errors.first('site') }}</label>
      </div>
      <div class="row pt-3">
        <label>Select Business Unit: </label>
        <drop-down
          placeholder="Select Business Unit"
          :options="shops"
          v-model="shop"
          :return-object="true"
          v-validate="'required'"
          name="shop"
        />
        <label class="error mt-3">{{ errors.first('shop') }}</label>
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
  name: "SearchWip",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
  },
  data: () => ({
    sites: [],
    site: {},
    shop: {},
    alteredSites: [
      {
        id: 0,
        name: 'All Stores',
      }
    ],
  }),
  computed:  {
    shops() {
      return this.site.shops || [];
    },
  },
  created() {
    this.fetchSites();
  },
  methods: {
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', {site: this.site, shop: this.shop});
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
          this.alteredSites = [...this.alteredSites, ...data.data];
        })
        .catch(() => {
          this.$toastr('error', 'Could not fetch Stores', 'Error!!')
        })
        .finally(this.disableLoading);
    },
  }
};
</script>
