<template>
  <modal title="Un-Listed Supplier" :is-large="true" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <div class="col-7">
          <div class="row">
            <label class="col-2 text-right">Name:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="text"
                v-model="model.trading_name"
                name="name"
                v-validate="'required'"
              />
              <label class="error">{{ errors.first('name') }}</label>
            </div>
          </div>
          <div class="row pt-2">
            <label class="col-2 text-right">Street:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="text"
                v-model="model.street"
              />
            </div>
          </div>
          <div class="row pt-2">
            <label class="col-2 text-right">Town:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="text"
                v-model="model.town"
              />
            </div>
          </div>
          <div class="row pt-2">
            <label class="col-2 text-right">State:</label>
            <div class="col-3">
              <input
                class="form-control"
                type="text"
                v-model="model.state"
              />
            </div>
            <label class="col-2 text-right">Code:</label>
            <div class="col-1">
              <input
                class="form-control"
                type="text"
                v-model="model.code"
              />
            </div>
          </div>
          <div class="row pt-2">
            <label class="col-2 text-right">Sales Phone:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="text"
                v-model="model.phone"
              />
            </div>
          </div>
          <div class="row pt-2">
            <label class="col-2 text-right">Fax:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="text"
                v-model="model.fax"
              />
            </div>
          </div>
          <div class="row pt-2">
            <fieldset class="deliver-fieldset col-12">
              <legend class="deliver-legend">Normal Settlement Discount
              </legend>
              <div class="row">
                <div class="col-5">
                  <div class="row"><label><input type="radio" v-model="normalDaysFor" value="inovice_date">Invoice Date +</label></div>
                  <div class="row pt-1"><label><input type="radio" v-model="normalDaysFor" value="end_of_month">End of Month +</label></div>
                  <div class="row pt-1"><label><input type="radio" v-model="normalDaysFor" value="bi_monthly">Bimonthly</label> </div>
                </div>
                <div class="col-6">
                  <div class="row">
                    <input  type="number" v-model="normalDays" class="col-4 form-control"><span class="col-8"> <label>Days</label></span>
                  </div>
                  <div class="row">&nbsp;</div>
                  <div class="row">
                    <span class="col-8 text-right"><label>Discount %:</label></span><input v-model="model.normal_discount.discount" type="number" class="form-control col-4">
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="row pt-2">
            <fieldset class="deliver-fieldset col-12">
              <legend class="deliver-legend">Early Settlement Discount
              </legend>
              <div class="row">
                <div class="col-5">
                  <div class="row"><label><input type="radio" v-model="earlyDaysFor" value="inovice_date">Invoice Date +</label></div>
                  <div class="row pt-1"><label><input type="radio" v-model="earlyDaysFor" value="end_of_month">End of Month +</label></div>
                  <div class="row pt-1"><label><input type="radio" v-model="earlyDaysFor" value="bi_monthly">Bimonthly</label></div>
                </div>
                <div class="col-6">
                  <div class="row">
                    <input type="number" v-model="earlyDays" class="col-4 form-control"><span class="col-8"> <label>Days</label></span>
                  </div>
                  <div class="row">&nbsp;</div>
                  <div class="row">
                    <span class="col-8 text-right"><label>Discount %:</label></span><input v-model="model.early_discount.discount" type="number" class="form-control col-4">
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="row pt-2">
            <h6 class="text-bold">Select Normal Ledger Entry:</h6>
            <drop-down
              :options="accounts"
              placeholder="Select Account"
              v-model="defaultCostAccount"
              name="account"
              class="col-12"
              v-validate="'required'"
            />
            <label class="error">{{ errors.first('account') }}</label>
          </div>
        </div>
        <div class="col-5">
          The Supplier that you entered is not recorded in the Supplier
          file. Input the details that you require for this order then
          activate Order Only.
          <br><br>
          If you wish to also add this Supplier to your database then
          activate Order and Add Supplier.
          <br><br>
          If settlement discounts apply then select one option button in 
          each and enter both early and normal discounts, even if they are
          the same. In both cases enter the number of days from either
          End of Month + or Invoice Date +.
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" :disabled="loading" class="btn action-buttons" @click="addSupplierAndOrder">Order and Add Supplier</button>
      <button type="button" :disabled="loading" class="btn action-buttons" @click="order">Order Only</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from "../../../../common/mixins";
import { getAccountsBySite, postCurrentOrder } from '../../../api/calls';
// import { getSites, getSuppliersBySite } from '../../../api/calls';

export default {
  name: "AddSupplier",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    currentOrderData: {
      type: Object,
      required: true
    },
  },
  data: () => ({
    model: {
      early_discount: {},
      normal_discount: {}
    },
    defaultCostAccount: '',
    accounts: [],
    normalDaysFor: '',
    normalDays: '',
    earlyDaysFor: '',
    earlyDays: '',
  }),
  watch: {
  },
  created() {
    this.model.trading_name = this.currentOrderData.supplier_name;
    this.fetchAccountsBySite();
  },
  methods: {
    fetchAccountsBySite() {
      this.enableLoading();
      getAccountsBySite(this.currentOrderData.site_id)
        .then(({ data }) => (this.accounts = data.data))
        .catch(error => this.$toastr("error", error.message, "Error!!"))
        .finally(this.disableLoading);
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    },
    addSupplierAndOrder() {
      this.validate().then(valid => {
        if (valid) {
          this.enableLoading();
          this.model.default_cost_account = this.defaultCostAccount;
          this.model.site_id = this.currentOrderData.site_id;
          if (this.earlyDays && this.earlyDaysFor) {
            this.model.early_discount[this.earlyDaysFor] = this.earlyDays;
          }
          if (this.normalDays && this.normalDaysFor) {
            this.model.normal_discount[this.normalDaysFor] = this.normalDays;
          }
          axios.post('/suppliers', this.model)
            .then(({data}) => {
              const currentOrder = {
                ...this.currentOrderData, 
                supplier_id: data.data.id,
                supplier_details: {...data.data}
              };
            postCurrentOrder(currentOrder)
              .then(({data}) => {
                this.$emit('updated', data.data.id);
                this.$toastr("success", "Successfully created order.", "Success!!")
                this.handleClose();
              })
          })
          .catch(error => {
            this.$toastr("error", "Could not create order.", "Error!!")
          })
          .finally(this.disableLoading);
        }
      });
    },
    order() {
      postCurrentOrder(this.currentOrderData)
        .then(({data}) => {
          this.$emit('updated', data.data.id);
          this.$toastr("success", "Successfully created order.", "Success!!")
          this.handleClose();
        })
        .catch(error => {
          this.$toastr("error", "Could not create order.", "Error!!")
        })
    },
  }
};
</script>


<style scoped>
  .deliver-fieldset {
    padding: 0px 0px 6px 13px;
    margin: 4px 0px 0px -11px;
    border: 1px solid antiquewhite;
  }

  .deliver-legend {
    color: black;
    font-size: small;
    margin-left: -10px;
    width: 188px;
  }
</style>

