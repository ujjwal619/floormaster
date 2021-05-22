<template >
  <modal title="Allocation Alert" @close="handleOnClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="form-group">
        <div class="row pb-4">
          <label class="col-lg-3 text-right">Date Required:</label>
          <div class="col-lg-6">
            <input class="form-control" type="date" v-model="date" v-validate="'required'" name="date" />
            <label class="error">{{ errors.first('date') }}</label>
          </div>
        </div>
        <div class="row">
          <label >
            Please Confirm of Enter the Allocation Quantity for this item.
          </label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="finishAllocation"
      >Next ></button>
      <button type="button" class="btn action-buttons" @click="handleOnClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../common/components/Modal/Modal";
import { format } from 'date-fns';
import { LoadingMixin } from '../../../common/mixins';

export default {
  name: "FutureStockAllocation",
  mixins: [LoadingMixin],
  components: {
    Modal
  },
  props: {
    futureStock: {
      type: Object,
      required: true,
    },
    allocationData: {
      type: Object,
      required: true,
    },
    color: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    date: format(new Date(), 'yyyy-MM-dd'),
  }),
  methods: {
    handleOnClose() {
      this.$emit("close");
    },
    finishAllocation() {
      this.$validator.validateAll()
        .then((valid) => {
          if (valid) {
            this.saveAllocation();
          }
        });
    },
    saveAllocation() {
      this.enableLoading();
      axios.post(`/api/future-stocks/${this.futureStock.id}/allocate`, ({ ...this.allocationData, date_required: this.date }))
        .then(({ data }) => {
          this.$toastr("success", "Future Stock Allocated Successfully.", "Success!!");
          // window.location.href = `/color/${this.color.id}/stocks`
        })
        .catch(() => {
          this.$toastr("error", 'Could not allocate future stock.', "Error!!")
          // window.location.href = `/color/${this.color.id}/stocks`;
        })
        .finally(() => {
          this.disableLoading();
          this.$emit('allocated');
        });
    },
  }
};
</script>
