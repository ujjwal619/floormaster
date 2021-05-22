<template>
  <modal title="Search Cash Books" @close="handleClose">
    <template slot="modal-body">
      <div class="row">
        <label>Store:</label>
        <drop-down
          :options="sites"
          placeholder="Select Store"
          v-model="selectedSite"
          name="store"
          v-validate="'required'"
        />
      </div>
      <div class="row pt-3">
        <label>Search CashBook</label>
        <drop-down
          placeholder="Search CashBook"
          v-model="selectedCashBook"
          :options="cashBooks"
          :return-object="true"
          v-validate="'required'"
          name="cash book"
        >
          <template slot="singleLabel" slot-scope="{ data }">{{ data.month_name + ' ' + data.year }}</template>
          <template slot="option" slot-scope="{ data }"><span>{{ data.month_name + ' ' + data.year }}</span></template>
        </drop-down>
        <label class="error">{{ errors.first('cash book') }}</label>
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
import { getSites, getAvailableCashBooksBySite } from '../../../api/calls'

export default {
  name: "SearchCashBook",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  data: () => ({
    selectedCashBook: "",
    cashBooks: [],
    sites: [],
    selectedSite: ""
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.fetchAvailableCashBooksBySite(value);
      }
    },
  },
  created() {
    this.fetchSites();
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
    fetchAvailableCashBooksBySite(siteId) {
      this.enableLoading();
      getAvailableCashBooksBySite(siteId)
        .then(({ data }) => {
          this.cashBooks = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.handleClose();
          this.$emit('selected', this.selectedSite, ({ ...this.selectedCashBook}))
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
