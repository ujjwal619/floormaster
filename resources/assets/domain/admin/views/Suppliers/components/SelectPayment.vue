<template>
  <modal title="Make Payment" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <component
        ref="dynamicComponent"
        :site-id="siteId"
        :current-supplier="currentSupplier"
        :is="currentComponent"
        :remit="model"
        :payable="payable"
        @updated="updateModel"
      />
    </template>
    <template slot="modal-footer">
      <template v-if="page === 1">
        <button type="button" class="btn action-buttons" @click="handleEftSelect">EFT</button>
        <button type="button" class="btn action-buttons" @click="handleChequeSelect">Cheque</button>
      </template>
      <template v-else>
        <button type="button" class="btn action-buttons" @click="handleNext">Next ></button>
      </template>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>

import Modal from "../../../../common/components/Modal/Modal";
import ChequeDrawing from './ChequeDrawing';
import CreateManual from './CreateManual';
import CreditorsAutoPay from './CreditorsAutoPay';
import ElectronicFundTransfer from './ElectronicFundTransfer';
import PaymentType from './PaymentType';
import SelectSupplier from './SelectSupplier';
import { LoadingMixin } from '../../../../common/mixins'

const EFT = 1;
const CHEQUE = 2;
const AUTO_PAY_ID = 1;
const MANUAL_PAY_ID = 2;
const PAY_THIS_RECORD_ID = 3;

const AUTO_PAY_PAGES = [
  { pageNo: 3, component: 'SelectSupplier' },
  { pageNo: 4, component: 'CreditorsAutoPay' },
];
const MANUAL_PAY_PAGES = [
  { pageNo: 3, component: 'CreateManual' },
];

const AUTO_PAY = [
  {
    type: EFT,
    pages: [
      { pageNo: 2, component: 'ElectronicFundTransfer' },
      ...AUTO_PAY_PAGES,
    ],
  },
  {
    type: CHEQUE,
    pages: [
      { pageNo: 2, component: 'ChequeDrawing' },
      ...AUTO_PAY_PAGES,
    ],
  }
];

const MANUAL_PAY = [
  {
    type: EFT,
    pages: [
      { pageNo: 2, component: 'ElectronicFundTransfer' },
      ...MANUAL_PAY_PAGES,
    ]
  },
  {
    type: CHEQUE,
    pages: [
      { pageNo: 2, component: 'ChequeDrawing' },
      ...MANUAL_PAY_PAGES,
    ],
  }
];

export default {
  name: 'SelectPayment',
  mixins: [LoadingMixin],
  components: {
    Modal,
    ChequeDrawing,
    CreateManual,
    CreditorsAutoPay,
    ElectronicFundTransfer,
    PaymentType,
    SelectSupplier,
  },
  props: {
    siteId: {
      type: Number,
      required: true,
    },
    currentSupplier: {
      type: Number,
      required: true,
    },
    payable: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      page: 1,
      model: {},
    };
  },
  computed: {
    currentComponent() {
      if (this.page === 1) {
        return 'PaymentType';
      }
      let pages = [];
      if (this.model.remittance_type === AUTO_PAY_ID || this.model.remittance_type === PAY_THIS_RECORD_ID) {
        pages = AUTO_PAY.find(autoPay => autoPay.type === this.model.payment_type).pages || [];
      } else {
        pages = MANUAL_PAY.find(manualPay => manualPay.type === this.model.payment_type).pages || [];
      }

      const currentPage = pages.find(page => page.pageNo === this.page) || {};
      return currentPage.component;
    },
  },
  methods: {
    emit(type) {
      this.$emit(type);
      this.handleClose();
    },
    handleClose() {
      this.$emit('close');
    },
    validate() {
      return this.$validator.validate();
    },
    handleNext() {
      if (!this.$refs.dynamicComponent) {
        return;
      }
      this.$refs.dynamicComponent.$validator.validate().then(valid => {
        if (valid) {
          if (
            (this.model.remittance_type === AUTO_PAY_ID && this.page === 4) || 
            (this.model.remittance_type === MANUAL_PAY_ID && this.page === 3) ||
            (this.model.remittance_type === PAY_THIS_RECORD_ID && this.page === 2)
          ) {
            this.executePayment();
          } else {
            this.page += 1;
          }
        }
      });
    },
    handleEftSelect() {
      if (!this.$refs.dynamicComponent) {
        return;
      }
      this.$refs.dynamicComponent.$validator.validate().then(valid => {
        if (valid) {
          this.model.payment_type = EFT;
          this.page += 1;
        }
      });
    },
    handleChequeSelect() {
      if (!this.$refs.dynamicComponent) {
        return;
      }
      this.$refs.dynamicComponent.$validator.validate().then(valid => {
        if (valid) {
          this.model.payment_type = CHEQUE;
          this.page += 1;
        }
      });
    },
    updateModel(updatedModel) {
      this.model = { ...this.model, ...updatedModel };
    },
    executePayment() {
      this.enableLoading();
      if (!this.model.supplier_id) {
        this.model.supplier_id = this.currentSupplier;
      }
      if (this.model.remittance_type === PAY_THIS_RECORD_ID) {
        this.model.payable_id = this.payable;
      }
      axios.post(`/api/sites/${this.siteId}/remittances`, { ...this.model })
        .then(({ data }) => {
          this.$emit('remit', data.data);
          this.$emit("close");
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    }
  }

};
</script>

<style scoped>

</style>
