<template>
  <div>
    <div class="form-group row">
      <span class="col-12">
          {{ futureStock.quantity }} &nbsp;
          {{ futureStock.unit }} &nbsp;
          {{ futureStock.color.product.name }},&nbsp;
          {{ futureStock.color.name }} &nbsp;@
          <template v-if="futureStock.list_price">${{ futureStock.list_price }}</template>&nbsp;
          <template v-if="futureStock.discount">minus {{ futureStock.discount }}% discount</template>
          <template v-if="futureStock.delivery">plus ${{ futureStock.delivery }} handling</template>
          <template v-if="futureStock.tax">plus {{ futureStock.tax }}% GST</template>.
      </span>
      <span class="col-12" v-if="futureStock.received">
        {{ futureStock.received }} &nbsp;
        {{ futureStock.unit }} of this Order Item received
      </span>
      <span class="col-12" v-else>
        Zero of this Order Item receivedof this Order Item received
      </span>
      
      <span class="col-12" v-if="futureStock.invoiced">
        {{ futureStock.invoiced }} &nbsp;
        {{ futureStock.unit }} invoice amount already entered
      </span>
      <span class="col-12" v-else>
        Zero invoice amount already entered
      </span>
      <span class="col-12" v-if="futureStock.received - futureStock.invoiced">
        {{ futureStock.received - futureStock.invoiced }} &nbsp;
        {{ futureStock.unit }} waiting for invoice
      </span>
      <span class="col-12" v-else>
        No Goods waiting for invoice
      </span>
    </div>
    <div class="form-group row pt-3">
      <div class="col-lg-8">
        <div class="row pb-2">
          <label class="col-lg-3 text-right">Invoice Number:</label>
          <input class="col-lg-9 form-control" type="number" v-model="model.invoice_number">
        </div>
        <div class="row pb-2">
          <label class="col-lg-3 text-right">Invoice Date:</label>
          <input class="col-lg-9 form-control" type="date" v-model="model.invoice_date">
        </div>

        <div class="row pb-2">
          <label class="col-lg-3 text-right">Select Order:</label>
          <drop-down
            class="col-lg-8 pb-1"
            placeholder="Search Order"
            v-model="selectedOrder"
            :options="futureStock.current_stocks"
            v-validate="'required'"
            name="orders"
            :return-object="true"
            label="roll_no"
          >
            <template slot="singleLabel" slot-scope="{ data }">{{ data.received_date + ', Qty:' + data.size + ', Item: '+  data.roll_no + ', Batch: ' + data.batch }}</template>
            <template slot="option" slot-scope="{ data }"><span>{{ data.received_date + ', Qty:' + data.size + ', Item: '+  data.roll_no + ', Batch: ' + data.batch }}</span></template>
          </drop-down>
        </div>

        <div class="row pb-2">
          <label class="col-lg-3 text-right">Invoice Total $:</label>
          <input class="col-lg-9 form-control" type="number" v-model="model.invoice_total" disabled>
        </div>
        <br/>
        <!-- <div class="row pb-2">
          <label class="col-lg-3 text-right">Goods Quantity:</label>
          <input class="col-lg-9 form-control" type="number" v-model="model.quantity" disabled>
        </div> -->
        <div class="row pb-2">
          <label class="col-lg-3 text-right">Discounted Unit Price: $</label>
          <input class="col-lg-9 form-control" type="number" v-model="model.discounted_unit_price" disabled>
        </div>
        <br/>
        <div class="row pb-2">
          <label class="col-lg-3 text-right">Baling/Deliver $:</label>
          <input class="col-lg-9 form-control" type="number" v-model="model.delivery" disabled>
        </div>
        <div class="row pb-2">
          <label class="col-lg-3 text-right">Levy $:</label>
          <input class="col-lg-9 form-control" type="number" v-model="model.levy_amount" disabled>
        </div>
        <div class="row pb-2">
          <label class="col-lg-3 text-right">GST Credit $:</label>
          <input class="col-lg-9 form-control" type="number" v-model="model.gst_credit" disabled>
        </div>
      </div>
      <div class="col-lg-4 pl-3 mx-auto my-auto">
        <label>
          This process costs received stock, if applicable
          and creates Payable records.<br>
          Enter the invoice amount and the values that you
          intend to pay. Any difference will automatically
          create and Adjustment. <br>
          The default values are as costed at placing time. <br>
          <br>
          Only enter GST Credit if claimable. Otherwise
          include it in the relevant costs. <br>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
  import DropDown from '../../../common/components/DropDown/DropDown';

  export default {
    name: 'Page1',
    components: {
      DropDown,
    },
    props: {
      futureStock: {
        type: Object,
        required: true,
      },
    },
    data: () => ({
      model: {},
      selectedOrder: '',
    }),
    watch: {
      model: {
        deep: true,
        handler(value) {
          this.$emit('update', value);
        }
      },
      selectedOrder(value) {
        const quantity = value.size;
        this.model.discounted_unit_price = this.futureStock.list_price - ((this.futureStock.list_price * this.futureStock.discount) / 100);
        this.model.delivery = (this.futureStock.delivery / this.futureStock.quantity) * quantity;
        const price = this.futureStock.list_price * quantity;
        const discountedPrice = price - ((price * this.futureStock.discount) / 100);
        const levyAmount = (discountedPrice * this.futureStock.levy) / 100;
        const afterLevy = discountedPrice + levyAmount;
        const afterDelivery = afterLevy + this.model.delivery;
        const taxAmount = (afterDelivery * this.futureStock.tax) / 100;
        const afterTax = afterDelivery + taxAmount;

        this.model.gst_credit = taxAmount;
        this.model.levy_amount = levyAmount;
        this.model.invoice_total = afterTax;
        this.model.quantity = quantity;
        this.model.current_stock_id = value.id;
        this.model.future_stock_id = this.futureStock.id;
        this.model.current_order_id = this.futureStock.order_number;
        this.model.site_id = this.futureStock.site_id;
        this.$emit('update', this.model);
      }
    },
  }
</script>
