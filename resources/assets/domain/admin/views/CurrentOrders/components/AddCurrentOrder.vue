<template>
  <modal title="Place General Purchase Order" :is-large="true" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <div class="col-8">
          <div class="row">
            <label class="col-4 text-right">Store:</label>
            <drop-down
              :options="sites"
              :default-selected="sites[0]"
              placeholder="Select Store"
              v-model="selectedSite"
              name="store"
              class="col-7"
              v-validate="'required'"
            />
            <label class="error">{{ errors.first('store') }}</label>
          </div>
          <div class="row pt-2">
            <label class="col-4 text-right">Supplier:</label>
            <input 
              type="text" 
              name="supplier" 
              list="supplierName" 
              v-model="model.supplier_name"
              style="height: 28px;"
              class="col-7"
              v-validate="'required'"
            >
            <datalist id="supplierName">
              <option 
                v-for="supplier in suppliers" 
                :key="supplier.id" 
                :value="supplier.trading_name"/>
            </datalist>
            <label class="error">{{ errors.first('supplier') }}</label>
          </div>
          <div class="row pt-2">
            <label class="col-4 text-right">Your Name:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="text"
                v-model="model.sales_rep"
                name="your name"
                v-validate="'required'"
              />
              <label class="error">{{ errors.first('your name') }}</label>
            </div>
          </div>
          <div class="row pt-1">
            <label class="col-4 text-right">Sales Contact:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="text"
                v-model="model.sales_contact"
              />
            </div>
          </div>
          <div class="row pt-2">
            <label class="col-4 text-right">Quoted Delivery Date:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="date"
                v-model="model.due_date"
                name="quoted delivery date"
                v-validate="'required'"
              />
              <label class="error">{{ errors.first('quoted delivery date') }}</label>
            </div>
          </div>
          <div class="row pt-1">
            <label class="col-4 text-right">Expected Price Total $:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="number"
                v-model="model.costed_price"
                name="expected price total"
                v-validate="'required|decimal:2'"
              />
              <label class="error">{{ errors.first('expected price total') }}</label>
            </div>
          </div>
          <div class="row pt-1">
            <label class="col-4 text-right">Client Name:</label>
            <div class="col-7">
              <input
                class="form-control"
                type="text"
                v-model="model.client_name"
              />
            </div>
          </div>
          <div class="row pt-2">
            <label class="col-4 text-right">Job Number:</label>
            <drop-down
              class="col-7"
              :options="jobs"
              placeholder="Select Job"
              label="job_id"
              v-model="model.job_id"
            />
          </div>
          <div class="row pt-2">
            <fieldset class="deliver-fieldset col-11">
              <legend class="deliver-legend">Deliver to...
              </legend>
              <div class="deliver-fields">
                <div class="row">
                  <label class="col-4 text-right">Street:</label>
                  <div class="col-8">
                    <input
                      class="form-control"
                      type="text"
                      v-model="model.delivery_address.street"
                    />
                  </div>
                </div>
                <div class="row">
                  <label class="col-4 text-right">Town:</label>
                  <div class="col-8">
                    <input
                      class="form-control"
                      type="text"
                      v-model="model.delivery_address.town"
                    />
                  </div>
                </div>
                <div class="row">
                  <label class="col-4 text-right">State:</label>
                  <div class="col-8">
                    <input
                      class="form-control"
                      type="text"
                      v-model="model.delivery_address.state"
                    />
                  </div>
                </div>
                <div class="row">
                  <label class="col-4 text-right">Phone:</label>
                  <div class="col-8">
                    <input
                      class="form-control"
                      type="text"
                      v-model="model.delivery_address.phone"
                    />
                  </div>
                </div>
                <div class="row">
                  <label class="col-4 text-right">Fax:</label>
                  <div class="col-8">
                    <input
                      class="form-control"
                      type="text"
                      v-model="model.delivery_address.fax"
                    />
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
        </div>
        <div class="col-4">
            This function is only for creating orders that are not
            processed through stock system.
          <br/>
          <br/>
            Customer Orders are created by clicking on the Act button
            next to the Job costing item on screen 2.
          <br/>
          <br/>
            Order stock from the Add button. Stock Screen, Future Stock.
        </div>
      </div>
      <div class="row pt-2">
        <fieldset class="deliver-fieldset col-12">
          <legend class="deliver-legend">Order Items
          </legend>
          <div class="col-12">
            <ul style="list-style-type:none;">
              <li 
                v-for="(futureStock, key) in model.future_stocks"
                :key="key"
              >{{ `
                  ${futureStock.quantity} ${futureStock.product_name} @ 
                  ${displayMoney(futureStock.list_price)} minus ${futureStock.discount || 0}% 
                  discount plus ${displayMoney(futureStock.delivery)} 
                  handling charge plus ${futureStock.tax || 0}% GST` 
                }}</li>
            </ul>  
          </div>
        </fieldset>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="addOrderClickedHandler">Add Order Item</button>
      <button 
        type="button" 
        :disabled="loading" 
        class="btn action-buttons" 
        @click="saveCurrentOrder"
      >Save Only</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from "../../../../common/mixins";
import { getSites, getSuppliersBySite, getJobsBySite, postCurrentOrder } from '../../../api/calls';
import { displayMoney } from '../../../../common/utitlities/helpers'

export default {
  name: "AddCurrentOrder",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    // accounts: {
    //   type: Array,
    //   required: true,
    // },
    currentOrderData: {
      type: Object,
      default: ({})
    },
    newOrder: {
      type: Object,
      default: () => ({})
    },
  },
  data: () => ({
    sites: [],
    jobs: [],
    suppliers: [],
    selectedSite: '',
    model: {
      delivery_address: {},
      future_stocks: [],
    },
  }),
  watch: {
    selectedSite(value) {
      this.model.site_id = value
      this.fetchSuppliersBySite(value);
      this.fetchJobsBySite(value);
      const site = this.sites.find(site => site.id === value) || {};
      this.model.delivery_address = site.delivery_address
        ? JSON.parse(site.delivery_address)
        : {};
    },
    // newOrder(value) {
    //   if (value.quantity) {
    //     console.log(value);
    //     this.model.future_stocks.push({...value});
    //   }
    // },
  },
  created() {
    this.model = this.currentOrderData;
    this.model.delivery_address = this.currentOrderData.delivery_address || {};
    this.model.future_stocks = this.currentOrderData.future_stocks || [];
    this.model.is_general = true;
    if (this.newOrder.quantity) {
      this.model.future_stocks.push({...this.newOrder});
      const futureStocks = [...this.model.future_stocks];
      const totalPrice = futureStocks.reduce((acc, futureStock) => {
        // console.log
        let cost = Number(futureStock.list_price) * Number(futureStock.quantity);
        if (futureStock.discount) {
          cost = cost - ((cost * futureStock.discount) / 100);
        }
        if (futureStock.delivery) {
          cost = cost + ((cost * futureStock.delivery) / 100);
        }
        if (futureStock.tax) {
          cost = cost + ((cost * futureStock.tax) / 100);
        }
        return cost + acc;
      }, 0);

      this.model.costed_price = totalPrice.toFixed(2);
    }
    this.fetchSites(); 
  },
  methods: {
    displayMoney,
    saveCurrentOrder() {
      this.validate().then(valid => {
        if (valid) {
          this.enableLoading();
          const selectedSupplier = this.suppliers.find(supplier => supplier.trading_name == this.model.supplier_name) || {};
          if (selectedSupplier.id) {
            this.model.supplier_id = selectedSupplier.id;
            this.model.supplier_details = {...selectedSupplier};
            return postCurrentOrder(this.model)
              .then(({data}) => {
                this.$emit('updated', data.data.id);
                this.$toastr("success", "Successfully created order.", "Success!!")
                this.handleClose();
              })
              .catch(() => {
                console.log('could not create current order');
              })
              .finally(this.disableLoading);
          }

          this.$emit('openaddsuppliermodal', this.model);
          this.handleClose();
        }
      });
    },
    addOrderClickedHandler() {
      this.$emit('addorderclicked', this.model);
      this.handleClose();
    },
    fetchSuppliersBySite() {
      this.enableLoading();
      getSuppliersBySite(this.selectedSite)
        .then(({ data }) => (this.suppliers = data.data))
        .catch(error => this.$toastr("error", error.message, "Error!!"))
        .finally(this.disableLoading);
    },
    fetchJobsBySite() {
      this.enableLoading();
      getJobsBySite(this.selectedSite)
        .then(({ data }) => (this.jobs = data.data))
        .catch(error => this.$toastr("error", error.message, "Error!!"))
        .finally(this.disableLoading);
    },
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => (this.sites = data.data))
        .catch(error => this.$toastr("error", error.message, "Error!!"))
        .finally(this.disableLoading);
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

<style scoped>
  .deliver-fieldset {
    padding: 0px 0px 6px 50px;
    margin: 4px 0px 0px 1px;
    border: 1px solid antiquewhite;

  }

  .deliver-legend {
    color: black;
    font-size: small;
    margin-left: -44px;
    width: 78px;
  }

  .legend2 {
    position: absolute; 
    bottom: 10.6ex; 
    left: 613px; 
    background: white;
  }

  .deliver-fields {
    padding-right: 10px;
    margin-left: -26px;
  }
</style>

