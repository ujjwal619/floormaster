<template >
    <modal title="Allocation Alert" @close="hideModal">
        <loading :loading="loading" />
        <template slot="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="row">
                            <span class="col-12 py-2 h6">
                                {{ supplier.trading_name }}: {{ supplier.product_name }} {{ product.name }} {{ color.name }} <br/>
                                <br/>
                                Floor Manager can't find any refernce to this product in your Job Costing. <br/>
                                If you have selected the wrong product then cancel this operation now. <br/>
                                To proceed with this action or click on 'Continue'. <br/>
                                <br />

                                Note: You should use the 'ACT' button on the job costing item, or 'ACT' from the action Required screen.
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-8 pt-3">
                        <div class="row pb-2">
                            <label class="col-lg-4 text-right">Amount For Sale:</label>
                            <input class="col-lg-8 form-control" type="text" :value="forSell" disabled>
                        </div>
                        <div class="row pb-4">
                            <label class="col-lg-4 text-right">Allocation Quantity:</label>
                            <div class="col-lg-8">
                              <input class="form-control" type="number" key="quantity" v-model="size" name="quantity" v-validate="`required|max_value:${currentStock.size}`" >
                              <label class="error">{{ errors.first('quantity') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-12 text-right">Please Confirm of Enter the Allocation Quantity for this item.</label>
                        </div>
                    </div>
                </div>
        </template>
        <template slot="modal-footer">
            <button
                type="button"
                class="btn action-buttons"
                @click="finishHandler"
            >Next >
            </button>
            <button
                type="button"
                class="btn action-buttons"
                @click="hideModal"
            >Cancel
            </button>
        </template>
    </modal>
</template>

<script>
import Modal from '../../../common/components/Modal/Modal'
import { LoadingMixin } from '../../../common/mixins'

export default {
    name: 'CurrentStockAllocation',
    mixins: [LoadingMixin],
    components: {
        Modal,
    },
    props: {
        supplier: {
            type: Object,
            required: true,
        },
        product: {
            type: Object,
            required: true,
        },
        color: {
            type: Object,
            required: true,
        },
        allocationData: {
            type: Object,
            required: true,
        },
        currentStock: {
            type: Object,
            required: true,
        },
    },
    data: () => ({
        size: null
    }),
  computed: {
      forSell() {
        return Number(this.currentStock.size) - Number(this.currentStock.sold)
      },
  },
    created() {
        this.size = this.forSell < this.allocationData.amount ? this.forSell : this.allocationData.amount;
    },
    methods: {
        hideModal() {
            this.$emit('hide');
        },
        finishHandler() {
          this.$validator.validateAll()
            .then((valid) => {
              if (valid) {
                this.finishCurrentStockAllocation();
              }
            });
        },
        finishCurrentStockAllocation() {
          this.enableLoading();
          axios.post(`/api/current-stocks/${this.currentStock.id}/allocate`, ({ ...this.allocationData, amount: this.size }))
            .then(({ data }) => {
              this.$toastr("success", data.message, "Success!!");
              this.$emit('allocated', { size: this.size });
              this.hideModal();
            })
            .catch(() => {
              this.$toastr("error", 'Could not allocate current stock.', "Error!!")
            })
            .finally(this.disableLoading);
        },
    }

}
</script>
