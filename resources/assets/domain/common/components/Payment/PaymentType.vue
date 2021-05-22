<template>
  <div key="payment-type">
    <div class="row">
      <label class="col-4 text-right pr-2">Auto/Manual</label>
      <div class="col-7">
        <drop-down
          v-model="model.remittance_type"
          :options="$options.option"
          v-validate="'required'"
          name="auto/manual"
        />
        <label class="error">{{ errors.first('auto/manual') }}</label>
      </div>
    </div>
    <div 
      v-if="!siteId"
      class="row pt-3"
    >
      <span class="col-4 text-right h4">Store:</span>
      <div class="col-7">
        <drop-down
            :options="sites"
            v-model="selectedSite"
            style="max-height: 40px;"
            name="Store"
            v-validate="'required'"
        />
        <label class="error">{{ errors.first('Store') }}</label>
      </div>
    </div>
    <div class="row pt-3">
      <label>If you want all remittance items defaulting to "Hold", select option then payment type</label>
    </div>
    <div class="row pt-2">
      <label class="col-4 text-right pr-2">Default Item Status</label>
      <label>
        <input type="radio" v-model="model.default_item_status" :value="$options.PAY" name="default status" v-validate="'required'">
        Pay
      </label>
      <label class="pl-2">
        <input type="radio" v-model="model.default_item_status" :value="$options.HOLD" name="default status">
        Hold
      </label>
      <label class="error">{{ errors.first('default status') }}</label>
    </div>
  </div>
</template>

<script>

import DropDown from "../DropDown/DropDown";
import { getSites } from '../../../admin/api/calls';

const PAY = 1;
const HOLD = 2;

export default {
  name: 'PaymentType',
  components: {
    DropDown,
  },
  props: {
    siteId: {
      type: Number,
    },
  },
  option: [
    { id: 1, name: 'Auto Pay' },
    { id: 2, name: 'Manual Pay' },
  ],
  PAY,
  HOLD,
  data: () => ({
    sites: [],
    selectedSite: '',
    model: {
      default_item_status: PAY,
      remittance_type: '',
    },
  }),
  watch: {
    selectedSite(value) {
      this.$emit('site', value);
    },
    model: {
      deep: true,
      handler(value) {
        return this.$emit('updated', value);
      }
    },
  },
  created() {
    if (!this.siteId) {
      this.fetchSites();
    } else {
      this.selectedSite = this.siteId
    }
  },
  methods: {
    fetchSites() {
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"));
    },
  }
}
</script>

