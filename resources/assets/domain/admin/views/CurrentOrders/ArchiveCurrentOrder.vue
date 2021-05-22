<template>
  <modal title="Updating Order Item - Marry Invoice to Received Stock" :is-large="true" @close="handleKeepIt">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div>
        
        <div class="form-group row pt-3">
            <div class="col-lg-12">
                <div class="row pb-2">
                    <label class="col-lg-3">Order No:</label>
                    <label class="col-lg-4">{{ currentOrder.id }}</label>
                </div>
                <div class="row pb-2">
                    <label class="col-lg-3">Supplier:</label>
                    <label class="col-lg-4">{{ supplierName }}</label>
                </div>
                <br />
                <div class="row pb-2">
                    <label class="col-lg-3">Total Quantity Ordered:</label>
                    <label class="col-lg-4">{{ totalQuantityordered }}</label>
                </div>
                <br />
                <div class="row pb-2">
                    <label class="col-lg-3">Total Quantity Delivered:</label>
                    <label class="col-lg-4">{{ totalQuantityDelivered }}</label>
                </div>
                <br />
                <div class="row pb-2">
                    <label class="col-lg-3">Total Cost Value:</label>
                    <label class="col-lg-4">${{ currentOrder.costed_price }}</label>
                </div>
                <div class="row">
                    <label class="col-lg-3">Received Invoice Total:</label>
                    <label class="col-lg-4">${{ currentOrder.invoice_received_amount || 0 }}</label>
                </div>
                <label class="row pt-5">
                    When order items are received and their invoices married to them, 
                    Floor Manager needs to archive the Order. This menas that any stock 
                    received against this Order will be costed,  and you Inventory figure adjusted.<br/>
                    This order and it's items will be moved to the Delivered Ordersr file.
                </label>
                <label class="row pt-5">
                    DO NOT ARCHIVE THIS ORDER UNLESS ALL GOODS RECEIVED HAVE HAD 
                    INVOICES MARRIED AGAINST THEM. IF YOUR ARCHIVE TOO EARLY
                    UNCOSTED STOCK WILL STAY THAT WAY!
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
          @click="handleArchive"
          :disabled="loading"
        >Archive
        </button>
        <button
          type="button"
          class="btn action-buttons"
          @click="handleKeepIt"
        >Keep it
        </button>
      </template>
    </template>
  </modal>
</template>

<script>
import Modal from '../../../common/components/Modal/Modal'
import { LoadingMixin } from '../../../common/mixins'

export default {
    name: 'ArchiveCurrentOrder',
    mixins: [LoadingMixin],
    props: {
        currentOrder: {
            type: Object,
            required: true,
        },
        futureStock: {
            type: Object,
            required: true,
        },
    },
    components: {
      Modal,
    },
    computed: {
        supplierName() {
            return this.currentOrder.supplier_details ? this.currentOrder.supplier_details.trading_name : this.currentOrder.supplier_name;
        },
        isLeftToReceive() {
            let totalLeftToReceive = this.currentOrder.future_stocks.reduce((sum, futureStock) => {
                return sum + Number(futureStock.quantity) - Number(futureStock.received);
            }, 0);

            return totalLeftToReceive > 0;
        },
        totalQuantityordered() {
            return this.currentOrder.future_stocks.reduce((sum, futureStock) => {
                return sum + Number(futureStock.quantity);
            }, 0);
        },
        totalQuantityDelivered() {
            return this.currentOrder.future_stocks.reduce((sum, futureStock) => {
                return sum + Number(futureStock.received);
            }, 0);
        },
    },
    methods: {
        handleArchive() {
            if (this.isLeftToReceive) {
                let confirmation = confirm('Are you sure you want to archive stock amount is still pending?');
                if (confirmation) {
                    this.archiveCurrentOrder();
                }
                return;
            }

            this.archiveCurrentOrder();
        },
        archiveCurrentOrder() {
            this.enableLoading();
            axios.post(`/api/current-orders/${this.currentOrder.id}/archive`)
            .then(response => {
                this.$toastr('success', 'Successfully archived current order', 'Success!!');
                window.location.href = '/current-orders';
            })
            .catch(response => {
                this.$toastr('error', 'Could not archive current order', 'Error!!')
            })
            .finally(this.disableLoading);
        },
        handleKeepIt() {
            this.$emit('created');
            this.$emit('close');
        },
    },
}
</script>
