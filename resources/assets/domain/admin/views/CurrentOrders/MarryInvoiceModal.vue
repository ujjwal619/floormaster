<template>
  <modal title="Updating Order Item - Marry Invoice to Received Stock" :is-large="true" @close="handleClose">
    <template slot="modal-body">
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
              <label class="col-lg-4 text-right">Invoice Number:</label>
              <input class="col-lg-7 form-control" type="number" v-validate="'required'"
                name="invoice number" v-model="model.invoice_number"/>
              <label class="error">{{ errors.first('invoice number') }}</label>
            </div>
            <div class="row pb-2">
              <label class="col-lg-4 text-right">Invoice Date:</label>
              <input 
                class="col-lg-7 form-control" 
                type="date" 
                v-validate="{ required: true, date_between: dateRangeForValidation }"
                name="invoice date" 
                v-model="model.invoice_date"
              >
              <label
                class="error"
                v-if="errors.firstByRule('invoice date', 'required')"
              >The invoice date field is required.</label>
              <label
                class="error"
                v-if="errors.firstByRule('invoice date', 'date_format')"
              >The invoice date field is required.</label>
              <label
                class="error"
                v-if="errors.firstByRule('invoice date', 'date_between')"
              >The invoice date field must be between {{ startDate }} and {{ endDate }}.</label>
            </div>

            <div class="row pb-2">
              <label class="col-lg-4 text-right">Select Order:</label>
              <drop-down
                class="col-lg-7 pb-1"
                placeholder="Search Order"
                v-model="selectedOrder"
                :options="futureStock.current_stocks"
                v-validate="'required'"
                name="current order"
                :return-object="true"
                :multiple="true"
                :show-multiple-label="false"
                :close-on-select="false" 
              >
                <template slot="selection" slot-scope="{ data }">
                  <span class="multiselect__single" v-if="data.values.length &amp;&amp; !data.isOpen">{{ data.values.length }} receipts selected</span>
                </template>
                <template slot="option" slot-scope="{ data }"><span>{{ data.received_date + ', Qty:' + data.quantity + ', Item: '+  data.roll_no + ', Batch: ' + data.batch }}</span></template>
              </drop-down>
              <label class="error">{{ errors.first('current order') }}</label>
            </div>

            <div class="row pb-2">
              <label class="col-lg-4 text-right">Invoice Total $:</label>
              <input class="col-lg-7 form-control" type="number" v-model="model.invoice_total" disabled>
            </div>
            <br/>
            <div class="row pb-2">
              <label class="col-lg-4 text-right">Goods Quantity:</label>
              <input class="col-lg-7 form-control" type="number" v-model="model.quantity" disabled>
            </div>
            <div class="row pb-2">
              <label class="col-lg-4 text-right">Discounted Unit Price: $</label>
              <input class="col-lg-7 form-control" type="number" v-model="model.discounted_unit_price" disabled>
            </div>
            <br/>
            <div class="row pb-2">
              <label class="col-lg-4 text-right">Baling/Deliver $:</label>
              <input class="col-lg-7 form-control" type="number" v-model="model.delivery" disabled>
            </div>
            <div v-if="futureStock.color.product.supplier.levy_account" class="row pb-2">
              <label class="col-lg-4 text-right">Levy $:</label>
              <input class="col-lg-7 form-control" type="number" v-model="model.levy_amount" disabled>
            </div>
            <div class="row pb-2">
              <label class="col-lg-4 text-right">GST Credit $:</label>
              <input class="col-lg-7 form-control" type="number" v-model="model.gst_credit" disabled>
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
    <template slot="modal-footer">
      <template>
        <button
          type="button"
          class="btn action-buttons"
          @click="saveMarryInvoice"
        >Next >
        </button>
        <button
          type="button"
          class="btn action-buttons"
          @click="handleClose"
        >Cancel
        </button>
      </template>
    </template>
    <loading :loading="loading" />
  </modal>
</template>

<script>

  import axios from 'axios';
  import ArchiveCurrentOrder from './ArchiveCurrentOrder.vue';
  import Modal from '../../../common/components/Modal/Modal'
  import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins'
  import DropDown from '../../../common/components/DropDown/DropDown';
  import { 
    formatViewDate,
    getFiscalYear,
    getFiscalYearDateRangeForValidation,
    getCurrentMonth,
    getMonthRangeForValidation,
    formatDate
  } from "../../../common/utitlities/helpers";

  const MARRY_INVOICE_RULES = [
    'invoice_number',
    'invoice_date',
    'invoice_total',
    'quantity',
  ];

  export default {
    name: 'MarryInvoiceModal',
    mixins: [LoadingMixin, CurrentUserMixin],
    components: {
      ArchiveCurrentOrder,
      Modal,
      DropDown,
    },
    props: {
      futureStock: {
        type: Object,
        required: true,
      },
      currentOrder: {
        type: Object,
        required: true,
      },
    },
    data: () => ({
      currentPageIndex: 0,
      model: {},
      selectedOrder: '',
      
    }),
    watch: {
      selectedOrder(currentOrders) {
        this.model.discounted_unit_price = this.futureStock.list_price - ((this.futureStock.list_price * this.futureStock.discount) / 100);
        const delivery = this.futureStock.delivery;
        const quantity = currentOrders.reduce((acc, item) => Number(item.quantity) + acc, 0);
        const price = this.futureStock.list_price * quantity;
        const discountedPrice = price - ((price * this.futureStock.discount) / 100);
        const levyAmount = (discountedPrice * this.futureStock.levy) / 100;
        const afterLevy = discountedPrice + levyAmount;
        const afterDelivery = afterLevy + delivery;
        const taxAmount = (afterDelivery * this.futureStock.tax) / 100;
        const afterTax = afterDelivery + taxAmount;

        this.model.delivery = delivery;
        this.model.gst_credit = taxAmount.toFixed(2);
        this.model.levy_amount = levyAmount.toFixed(2);
        this.model.invoice_total = afterTax.toFixed(2);
        if (!this.futureStock.color.product.supplier.levy_account) {
          this.model.invoice_total = (afterTax - levyAmount).toFixed(2);
        }
        this.model.quantity = quantity;
        this.model.current_stock_id = currentOrders.map(currentOrder => currentOrder.id);
        this.model.future_stock_id = this.futureStock.id;
        this.model.current_order_id = this.futureStock.order_number;
        this.model.site_id = this.futureStock.site_id;
      }
    },
    computed: {
      startDate() {
        const startDate = this.isSuperAdmin ? getFiscalYear() : getCurrentMonth();
        return formatViewDate(startDate);
      },
      endDate() {
        const endDate = this.isSuperAdmin ? getFiscalYear('end') : getCurrentMonth('end');
        return formatViewDate(endDate);
      },
      dateRangeForValidation() {
        return this.isSuperAdmin ? getFiscalYearDateRangeForValidation() : getMonthRangeForValidation();
      },
      getPageTitle() {
        return PAGE_TITLE[this.currentPageIndex];
      },
      getPage() {
        return PAGE_LIST[this.currentPageIndex];
      },
      isFirstPage() {
        return this.currentPageIndex === 0;
      },
      stopNext() {
        return MARRY_INVOICE_RULES.some((key) => {
          console.log(this.model[key], key, !this.model[key]);
          return !this.model[key];
        });
      },
    },
    methods: {
      validate() {
        return this.$validator.validate();
      },
      saveMarryInvoice() {
        this.enableLoading();
        this.validate().then(valid => {
          if (valid) {
            return axios.post(`/api/future-stocks/${this.futureStock.id}/marry-invoices`, this.model)
              .then(({ data }) => {
                axios.get(`/api/future-stocks/${this.futureStock.id}`)
                .then(({ data }) => {
                  const futureStock = data.data;
                  if(futureStock.quantity <= futureStock.invoiced) {
                    return this.openArchiveModal();
                  }
                  this.$emit('created');
                })
                this.$toastr('success', data.message, 'Success!!');
              })
              .catch((data) => {
                this.$toastr('error', data.message, 'Error!!')
              })
              .finally(() => {
                this.disableLoading();
              });
          }
        });
        this.disableLoading();        
      },
      handleClose() {
        this.$emit('close');
      },
      setCurrentPage(index) {
        this.currentPageIndex = index;
      },
      openArchiveModal() {
        this.$emit('modal:archive')
        this.handleClose();
      },
    },
  };
</script>
