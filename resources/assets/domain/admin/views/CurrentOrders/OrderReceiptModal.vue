<template>
  <modal 
    :title="getTitle" 
    :is-large="isLarge" 
    @close="handleClose"
  >
    <template slot="modal-body">
      <template v-if="page === 1">
        <div class="row pb-2">
          <label class="col-lg-4 text-right">Enter Delivery Date:</label>
          <input 
            class="col-lg-4 form-control" 
            type="date" 
            v-model="model.delivery_date"
            name="receipt date"
            v-validate="{ required: true, date_between: dateRangeForValidation }"
          >
          <label
            class="error"
            v-if="errors.firstByRule('receipt date', 'required')"
          >The date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('receipt date', 'date_format')"
          >The date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('receipt date', 'date_between')"
          >The date field must be between {{ startDate }} and {{ endDate }}.</label>
        </div>
      </template>
      <template v-else>
        <div class="form-group row">
          <span class="col-12">
              {{ stockData.quantity }} &nbsp; 
              {{ stockData.unit }} &nbsp; 
              {{ stockData.color.product.name }},&nbsp; 
              {{ stockData.color.name }}
              <template v-if="stockData.list_price">@ ${{ stockData.list_price }} </template>
              <template v-if="stockData.discount"> minus {{ stockData.discount }}% discount </template>
              <template v-if="stockData.delivery"> plus ${{ stockData.delivery }} handling</template>.
              <template v-if="stockData.levy"> plus {{ stockData.levy }}% levy</template>.
              <template v-if="stockData.tax"> plus {{ stockData.tax }}% GST</template>.
          </span>
          <span class="col-12">
                      ( {{ stockData.quantity - stockData.received }} of Order Remaining. )
          </span>
        </div>
        <div class="form-group row pt-3">
          <div class="col-lg-6">
            <div class="row pb-2">
              <label class="col-lg-4 text-right">Dye Batch:</label>
              <input class="col-lg-8 form-control" type="text" v-model="model.batch">
            </div>
            <div class="row pb-2">
              <label class="col-lg-4 text-right">Roll No / Item:</label>
              <input class="col-lg-8 form-control" type="text" v-model="model.roll_no">
            </div>
            <div class="row pb-2">
              <label class="col-lg-4 text-right">Quantity / Size:</label>
              <input class="col-lg-8 form-control" type="number" v-model="model.size">
            </div>
            <div class="row pb-2">
              <label class="col-lg-4 text-right">Location:</label>
              <input class="col-lg-8 form-control" type="text" v-model="model.location">
            </div>
            <div class="row pb-2">
              <label class="col-lg-4 text-right">Notation:</label>
              <input class="col-lg-8 form-control" type="text" v-model="model.nb">
            </div>
          </div>
          <div class="col-lg-6 pl-3 mx-auto my-auto">
            <label>
              Enter the product's dye batch or rotation. <br>
              If not applicable then type in N/A. <br>
              Enter the ROll, Item Number or Id. <br>
              Enter size/quantity that you will pay for. If a roll product
              is delivered larger than ordered then enter only the order
              quantity, then type a plus sign, '+' in the Notation field. <br>
              Location can contain up to three characters. <br>
              Use a single character notation for damaged, second or
              remnant (reporting requires 'R'). <br>
              FLOOR manager will assign costs when the invoice is <br>
            </label>
          </div>
        </div>
      </template>
    </template>
    <template slot="modal-footer">
      <template v-if="page === 1">
        <button
          type="button"
          class="btn action-buttons"
          @click="goToPage2"
        >Next
        </button>
        <button
          type="button"
          class="btn action-buttons"
          @click="handleClose"
        >Cancel
        </button>
      </template>
      <template v-else>
        <button
          type="button"
          class="btn action-buttons"
          :class="{ 'disabled' : stopOrderRoll }"
          @click="handleSubmit"
          :disabled="stopOrderRoll"
        >Store Roll/Item
        </button>
        <button
          type="button"
          class="btn action-buttons"
          @click="doneOrderReceipt"
        >Done
        </button>
      </template>
    </template>
    <loading :loading="loading" />
  </modal>
</template>

<script>

  import Modal from '../../../common/components/Modal/Modal';
  import { 
    formatDate,
    formatViewDate,
    getFiscalYear,
    getFiscalYearDateRangeForValidation,
    getCurrentMonth,
    getMonthRangeForValidation,
  } from '../../../common/utitlities/helpers';
  import { getFutureStockById } from '../../api/calls';
  import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins';

  const RULES = [
    'delivery_date',
    'batch',
    'roll_no',
    'size',
  ];

  export default {
    name: 'OrderReceiptModal',
    mixins: [LoadingMixin, CurrentUserMixin],
    components: {
      Modal,
    },
    props: {
      stockData: {
        type: Object,
        required: true,
      },
    },
    data: () => ({
      model: {
        delivery_date: formatDate(new Date()),
      },
      page: 1,
    }),
    mounted() {
        this.model.size = (this.stockData.quantity - this.stockData.received).toFixed(2);
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
      stopOrderRoll() {
        return RULES.some((key) => !this.model[key]);
      },
      getTitle() {
        return this.page === 1 ? 
          'Updating Current Order - Delivery Date' : 
          'Purchase Order Receipt - Stock Entry';
      },
      isLarge() {
        return this.page !== 1;
      },
    },
    methods: {
      goToPage2() {
        this.validate().then(valid => {
          if (valid) {
            this.page = 2;
          }
        });
      },
      validate() {
        return this.$validator.validate();
      },
      handleClose() {
        this.$emit('close');
      },
      handleSubmit() {
        const payLoad = {...this.model};
        axios.post(`/future-stocks/${this.stockData.id}/order-receipt`, payLoad)
          .then(({ data }) => {
            this.model.roll_no = '';
            this.model.size = '';
            const currentStock = data.data;
            this.model.future_stock_receive_group_id = currentStock.future_stock_receive_group_id;
            getFutureStockById(this.stockData.id)
              .then(({data}) => {
                const futureStock = data.data;
                this.model.size = (data.data.quantity - data.data.received).toFixed(2);
                if (this.model.size <= 0) {
                  this.doneOrderReceipt();
                } 
              })
            this.$toastr('success', data.data.message || 'Successfully created order receipt.', 'Success!!');
          })
          .catch(() => {
            this.$toastr('error', 'Could not create order receipt', 'Error!!')
          })
      },
      doneOrderReceipt() {
            window.location.href = `/current-orders/${this.stockData.order_number}`;
      },
    },
  };
</script>
