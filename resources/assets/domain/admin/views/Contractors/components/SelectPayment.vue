<template>
  <modal title="Make Payment" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <component
        ref="dynamicComponent"
        :site-id="siteId"
        :contractor-id="currentContractor"
        :is="currentComponent"
        @updated="updateModel"
      />
    </template>
    <template slot="modal-footer">
      <template v-if="page === 2">
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
import ElectronicFundTransfer from './ElectronicFundTransfer';
import PayContractor from './PayContractor';
import PaymentType from './PaymentType';
import { LoadingMixin } from '../../../../common/mixins'

const EFT = 1;
const CHEQUE = 2;
const AUTO_PAY_ID = 1;

const PAGE_3 = [
  { id: EFT, component: 'ElectronicFundTransfer' },
  { id: CHEQUE, component: 'ChequeDrawing' },
]; 


export default {
  name: 'SelectPayment',
  mixins: [LoadingMixin],
  components: {
    Modal,
    ChequeDrawing,
    ElectronicFundTransfer,
    PayContractor,
    PaymentType,
  },
  props: {
    siteId: {
      type: Number,
      required: true,
    },
    currentContractor: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      page: 1,
      model: {
        remittance_type: AUTO_PAY_ID,
      },
    };
  },
  computed: {
    currentComponent() {
      if (this.page === 1) {
        return 'PayContractor';
      } else if(this.page === 2) {
        return 'PaymentType';
      }
      const page3Detail = PAGE_3.find(page => page.id === this.model.payment_type);
      return page3Detail.component;

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
          if (this.page === 3) {
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
      this.enableLoading()
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
