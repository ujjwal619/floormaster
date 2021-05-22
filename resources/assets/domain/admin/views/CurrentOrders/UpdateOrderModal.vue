<template>
    <modal title="Update Order" @close="handleClose">
        <template slot="modal-body">
            <div class="form-group row">
                <button
                    type="button"
                    :title="orderReceiveTitle"
                    class="btn action-buttons"
                    :disabled="!canReceiveOrder"
                    @click="emit('modal:order-received')"
                >Order Received
                </button>
            </div>
            <div class="form-group row pt-3">
                <button
                    type="button"
                    class="btn action-buttons"
                    @click="emit('modal:enter-invoice')"
                >Enter Invoice
                </button>
            </div>
        </template>
        <template slot="modal-footer">
            <button
                type="button"
                class="btn action-buttons"
                @click="handleClose"
            >Cancel
            </button>
        </template>
    </modal>
</template>

<script>

import Modal from '../../../common/components/Modal/Modal';

export default {
    name: 'UpdateOrderModal',
    components: {
        Modal,
    },
    props: {
        orderData: {
            type: Object,
            required: true,
        },
    },
    computed: {
        canReceiveOrder() {
            return this.orderData.quantity - this.orderData.received > 0;
        },
        orderReceiveTitle() {
            return !this.canReceiveOrder ? 'All Order already received.' : ''
        },
    },
    methods: {
        handleClose() {
            this.$emit('close', true);
        },
        emit(event) {
            this.$emit(event);
            this.$emit('close');
        },
    },
}
</script>
