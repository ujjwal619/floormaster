<template>
  <modal title="Add Remittance Item" @close="handleClose" :is-large="true" class="form-container">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label class="col-3 text-right pr-2">Number:</label>
        <label class="col-7">{{ remit.payment_type === 1 ? 'E' + remittanceId : remit.cheque_number }}</label>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right pr-2">Date:</label>
        <label class="col-7">{{ remit.transaction_date || remit.cheque_date }}</label>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right pr-2">Our Order No:</label>
        <input type="text" class="col-7 form-control" v-model="model.order_no" name="Order No" v-validate="'required'"/>
        <span class="col-10 text-right error">{{ errors.first('Order No') }}</span>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right pr-2">Supplier's Reference:</label>
        <input type="text" class="col-7 form-control" v-model="model.supplier_reference"/>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right pr-2">Invoice Amount $:</label>
        <input type="number" 
          class="col-7 form-control" 
          v-model="model.invoice_amount" 
          name="invoice amount" 
          v-validate="'required|decimal:2'"
        />
        <span class="col-5 error">{{ errors.first('invoice amount') }}</span>
      </div>
      <div class="row pt-3">
        <label class="col-5">Goods $</label>
        <label class="col-5">Goods Cost A/C</label>
      </div>
      <div class="row">
        <input class="col-5 form-control" type="number" name="goods" v-model="model.goods" v-validate="'required|decimal:2'"/>
        <drop-down 
          class="col-5"
          :options="accounts" 
          placeholder="Search goods cost a/c"  
          v-model="model.goods_cost_ac" 
          name="goods cost a/c" 
          v-validate="'required'" 
        />
        <span class="col-5 error">{{ errors.first('goods') }}</span>
        <span class="col-5 error">{{ errors.first('goods cost a/c') }}</span>
      </div>
      <div class="row pt-3">
        <label class="col-5">Freight $</label>
        <label class="col-5">Freight/Baling Cost A/C</label>
      </div>
      <div class="row">
        <input class="col-5 form-control" type="number" name="freight" v-validate="'decimal:2'" v-model="model.freight"/>
        <drop-down 
          class="col-5"
          :options="accounts" 
          placeholder="Search freight/baling a/c"  
           v-model="model.freight_baling_cost_ac"
        />
        <span class="col-5 error">{{ errors.first('freight') }}</span>
      </div>
      <div class="row pt-3">
        <label class="col-5">Levy $</label>
        <label class="col-5">Levy Cost A/C</label>
      </div>
      <div class="row">
        <input class="col-5 form-control" type="number" name="levy" v-validate="'decimal:2'" v-model="model.levy"/>
        <drop-down 
          class="col-5"
          :options="accounts" 
          placeholder="Search levy a/c"  
           v-model="model.levy_cost_a_c"
        />
        <span class="col-5 error">{{ errors.first('levy') }}</span>
      </div>
       <div class="row pt-3">
        <label class="col-5">GST $</label>
      </div>
      <div class="row">
        <input class="col-5 form-control" type="number" name="gst" v-validate="'decimal:2'" v-model="model.gst"/>
        <span class="col-5 error">{{ errors.first('gst') }}</span>
      </div>
      <div class="row pt-3">
        <label class="col-5 text-right pr-2">Gross Payment</label>
        <label class="col-5">{{ calcGrossPayment }}</label>
      </div>
      <div class="row pt-3">
        <label class="col-5 text-right pr-2">Adjustment</label>
        <label class="col-5">{{ calcAdjustment }}</label>
      </div>
      <div class="row pt-3">
        <label class="col-5 text-right pr-2">Discount %</label>
        <input type="number" class="col-2 form-control" v-model="model.discount" name="discount" v-validate="'decimal:2'">
        <span class="col-5 error">{{ errors.first('discount') }}</span>
      </div>
      <div class="row pt-3">
        <label class="col-5 text-right pr-2">Net Payment:</label>
        <label class="col-5">{{ netPayment }}</label>
      </div>
      <div class="row pt-3">
        <label class="col-5 text-right pr-2">Comments:</label>
        <input type="text" class="col-7 form-control" v-model="model.comments">
      </div>
      <div class="row pt-3">
        <label class="col-5 text-right pr-2">Job:</label>
        <input type="text" class="col-4 form-control" v-model="model.job">
      </div>
      <div class="row pt-3">
        <label>
          Adjustment is calced by deducting payument amounts from the 'Invoice Amount'. <br/>
          Only enter GST if claimable, otherwise add to Goods, Freight or Levy. <br/>
          Use the 'Calc' button to check totals and calc Goods from Invoice/GST.
        </label>
      </div>

    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
      <button type="button" class="btn action-buttons" @click="handleAddItem">Done ></button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins'

export default {
  name: "AddRemittance",
  mixins: [LoadingMixin],
  components: {
    Modal,
    DropDown
  },
  props: {
    remittanceId: {
      type: Number,
      required: true,
    },
    siteId: {
      type: Number,
      required: true,
    },
    remit: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    userId: "",
    users: [],
    goods: [],
    freight: [],
    levy: [],
    accounts: [],
    model: {
      order_no: '',
      supplier_reference: '',
      invoice_amount: '',
      goods: 0,
      goods_cost_ac: '',
      freight: 0,
      freight_baling_cost_ac: '',
      levy: 0,
      levy_cost_a_c: '',
      gst: 0,
      discount: '',
      comments: '',
      job: '',
    },
  }),
  computed: {
    calcGrossPayment() {
      return Number(this.model.goods) + Number(this.model.freight) + Number(this.model.levy) + Number(this.model.gst);
    },
    calcAdjustment() {
      return this.calcGrossPayment - Number(this.model.invoice_amount);
    },
    netPayment() {
      const value = this.calcGrossPayment - ((this.calcGrossPayment * Number(this.model.discount)) / 100);
      return value.toFixed(2);
    }
  },
  created() {
    this.enableLoading();
    // Promise.all([this.fetchGoodsAc, this.fetchFreightAc, this.fetchLevyAc])
    //   .then((data) => {
    //     this.goods = data.data[0];
    //     this.freight = data.data[0];
    //     this.levy = data.data[0];
    //   })
    //   .catch(error => console.log(error));
    axios.get(`/api/sites/${this.siteId}/suppliers/accounts`)
      .then(({ data }) => this.accounts = data.data)
      .catch(error => console.log(error))
      .finally(() => this.disableLoading());
  },
  methods: {
    // fetchGoodsAc() {
    //   return axios.get(``);
    // },
    // fetchFreightAc() {
    //   return axios.get(``);
    // },
    // fetchLevyAc() {
    //   return axios.get(``);
    // },
    handleClose() {
      this.$emit("close");
    },
    handleAddItem() {
      this.$validator.validate().then(valid => {
        if (valid) {
          this.enableLoading();
          const model = { ...this.model, adjustment: this.calcAdjustment, gross_payment: this.calcGrossPayment, net_payment: this.netPayment };
          axios.post(`/api/remittances/${this.remittanceId}/items`, model)
          .then(({ data }) => {
            this.$emit('updated');
            this.handleClose();
          })
          .catch(error => console.log(error))
          .finally(() => this.disableLoading());
        }
      })
    },
    validate() {
      return this.$validator.validate();
    },

  }
};
</script>
