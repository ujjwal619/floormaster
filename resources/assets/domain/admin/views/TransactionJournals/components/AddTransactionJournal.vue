<template>
  <modal title="Create Journal Entries" @close="handleClose" :isLarge="true">
    <template slot="modal-body">
      <div class="form-group row">
        <div class="col-lg-12">
          <div class="row pb-3">
            <label class="col-lg-2 text-right">Transaction Date:</label>
            <input
              class="col-lg-2 form-control"
              type="date"
              v-model="model.transaction_date"
              v-validate="{ required: true }"
              name="transaction date"
            />
            <label class="error">{{ errors.first('transaction date') }}</label>
          </div>
          <div class="row">
            <div class="col-6">
              <h6>Debits</h6>
            </div>
            <div class="col-6">
              <h6 class="float-right">Credits</h6>
            </div>
          </div>
        </div>
      </div>
      <label class="row pt-3">
          Activate either Add button (above) to create an entry.<br>
          In most instances Total Credits should equal Total Debits.<br>
          Only create single sided, (out of balance) entries as instructed by your accountant.<br>
          To remove an entry select it then activate the 'Delete Selected...' button.
      </label>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="deleteSelectedDebitOrCredit"
      >
        Delete Selected Debit or Credit
      </button>
      <button 
        type="button"
        class="btn action-buttons"
        @click="handleSave"
      >
        Finished
      </button>
      <button
        type="button"
        class="btn action-buttons"
        @click="handleClose"
      >
        Cancel
      </button>
    </template>
  </modal>
</template>

<script>

  import Modal from '../../../../common/components/Modal/Modal';

  const BASE_STATE = {
    name: '',
    type: 1,
    gst_applicable: true,
    reports_to: null,
    opening_balance: null,
  };

  const TYPE = {
    HEADER: 1,
    DETAIL: 2
  };

  const RULES = [
    'name',
    'type',
    'code',
    'gst_applicable',
  ];

  const DETAIL_RULES = ['opening_balance'];

  export default {
    name: 'AddTransactionJournal',
    components: {
      Modal,
    },
    props: {
      
    },
    TYPE,
    data: () => ({
      model: { ...BASE_STATE },
    }),
    computed: {
      
    },
    watch: {
      
    },
    methods: {
      deleteSelectedDebitOrCredit() {},
      handleClose() {
        this.model = ({ ...BASE_STATE });
        this.$emit('close');
      },
      handleSave() {
        // const payLoad = {};
        // const url = !this.isEdit ? `/accounts` : `/accounts/${this.account.id}`;
        // axios.post(url, payLoad)
        //   .then(() => {
        //     this.$toastr('success', 'Successfully saved transaction journal', 'Success!!');
        //     this.handleClose();
        //     this.$emit('saved');
        //   })
        //   .catch(() => {
        //     this.$toastr('error', 'Could not save new transaction journal', 'Error!!')
        //   });
      },
    },
  }
</script>
