<template>
  <modal title="Cheque Search" @close="handleClose">
    <template slot="modal-body">
      <div class="row">
        <label class="required">Store:</label>
        <drop-down
          :options="sites"
          placeholder="Select Store"
          v-model="storeId"
        />
      </div>
      <div class="row pt-4">
        <label class="required">Select Cheque Butt:</label>
        <drop-down
          class="col-12"
          v-model="chequeButt"
          :options="payeeChequeButts"
          name="cheque butt"
          label="payee_name"
          v-validate="'required'"
        />
        <span class="error">{{  errors.first('cheque butt') }}</span>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="handleSelect"
      >Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
    <template>
      <loading :loading="loading" />
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { getSites } from '../../../api/calls'
import { LoadingMixin } from '../../../../common/mixins'

export default {
  name: "SearchCheque",
  mixins: [LoadingMixin],
  components: {
    Modal,
    DropDown
  },
  data: () => ({
    payee: '',
    chequeButt: '',
    page: 1,
    payeeChequeButts: [],
    sites: [],
    storeId: '',
  }),
  watch: {
    storeId(value) {
      if (value) {
        this.fetchRemittanceBySite(value);
      }
    }
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
        .finally(this.disableLoading);
    },
    fetchRemittanceBySite(siteId) {
      console.log(siteId);
      this.enableLoading();
      axios
        .get(`/api/sites/${siteId}/remittances`)
        .then(({ data }) => {
          console.log(data, data.data);
          if (data.data) {
            this.payeeChequeButts = data.data.map((remittance) => {
              if (remittance.contractor_id) {
                remittance.payee_name = remittance.contractor.name;
              }
              if (remittance.supplier_id) {
                remittance.payee_name = remittance.supplier.trading_name;
              }
              return {
                ...remittance,
              }
            });
          }
        })
        .catch(error => {
          this.$toastr("error", "Could not fetch Remittance Data", "Error!!");
        })
        .finally(this.disableLoading);
    },
    handleClose() {
      this.$emit("close");
    },
    handleSelect() {
      this.$validator.validateAll()
        .then(valid => {
          if (valid) {
            this.$emit('selected', this.chequeButt);
          }
        })
    },
    nextStep() {
      if (this.page === 1) {
        this.getChequeButts();
      } else {
        this.$emit("search-and-close", { id: this.userId });
        this.handleClose();
      }
    },
    getChequeButts() {
      // api request to fetch cheque butts matching the payee name
    },
  },
};
</script>
