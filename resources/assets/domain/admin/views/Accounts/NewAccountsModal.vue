<template>
  <modal :title="title" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group row">
        <div class="col-lg-12">
          <div class="row pb-2">
            <label class="col-lg-3 text-right">Store:</label>
            <label class="col-lg-8">{{ selectedSite.name }}</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-3 text-right">Period:</label>
            <label class="col-lg-8">{{ getViewFiscalYear() }}</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-3 text-right">Account Family:</label>
            <label class="col-lg-8" >{{ tabData.name }}</label>
          </div>
          <div class="row pb-3">
            <label class="col-lg-3 text-right">Account Name:</label>
            <input 
              class="col-lg-8 form-control" 
              type="text" 
              v-model="model.name"
              name="name"
              v-validate="'required'"
            />
          </div>
          <div class="row pb-3">
            <label class="col-lg-3 text-right">Account Type:</label>
            <input type="radio" class="mt-1" v-model="model.type" id="header" :value="1"> <label for="header" class="mr-2">Header</label>
            <input type="radio" class="mt-1" v-model="model.type" id="detail" :value="2"> <label for="detail" >Detail</label>
          </div>
          <div class="row pb-3">
            <label class="col-lg-3 text-right">Account Code:</label>
            <input 
              class="col-lg-8 form-control" 
              type="text" 
              v-model="model.code"
              name="code"
              v-validate="'required'"
            />
          </div>
          <div class="row pb-3">
            <label class="col-lg-3">&nbsp;</label>
            <input 
              type="radio" 
              class="mt-1" 
              v-model="model.gst_applicable" 
              id="gst" 
              :value="true"
            > <label for="gst" class="mr-2">Standard GST</label>
            <input 
              type="radio" 
              class="mt-1" 
              v-model="model.gst_applicable" 
              id="no_gst" 
              :value="false"
            > <label for="no_gst" >GST Not Applicable</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-3 text-right">Reports to:</label>
            <select class="col-lg-8 form-control" v-model="model.reports_to">
              <option v-for="(headerAccount, index) in headerAccounts" :value="headerAccount.id" :key="index">{{ headerAccount.name }}</option>
            </select>
          </div>
          <template v-if="isDetail">
            <div class="row pb-2">
              <label class="col-lg-3 text-right">Opening Balance:</label>
              <input class="col-lg-8 form-control" type="number" v-model="model.opening_balance">
            </div>
            <div class="row pb-2">
              <label class="col-lg-3 text-right">Account Balance:</label>
              <label class="col-lg-3 text-right">{{ displayMoney(model.account_balance) }}</label>
            </div>
            <div class="row pb-2">
              <label class="col-lg-3 text-right">Current Balance:</label>
              <label class="col-lg-3 text-right">{{ displayMoney(model.total_balance) }}</label>
            </div>
          </template>
        </div>
      </div>
      <label class="row pt-3" v-if="isDetail">
          Each Detail and Header Account reports to a Parent Header. <br>
          For example, 6-2510: Staff Amenities, 6-2520: Supperannuation all report to the Parent Header 
          6-2500: Employment Expenses.<br>
          Employment Expenses reports directly to Master Account 6-0000 Expenses. <br>
          You must nominate which Header Account this new Account reports to.
      </label>
      <label class="row pt-3" v-else>
          Enter the Account Code for this Account. Make sure that you follow accepted conventions. <br>
          If, for example, this is your super annuation detail Account, Payroll is Header Account 8000. <br>
          Your super annuation Account code may be 8001. This way Floor manager knows to add accounts 8001, 8002, etc.<br>
          to generate the subtotal for the Payroll Header Account 8000.<br>
          Standard GST appliest to most items. GST Not Applicable are for account type like
          Wages where GST is never applicable.
      </label>
    </template>
    <template slot="modal-footer">
      <button
        v-if="isEdit"
        type="button"
        class="btn action-buttons"
        @click="removeAccount"
      >
        Remove
      </button>
      <button 
        type="button"
        class="btn action-buttons"
        @click="handleSave"
      >
        Save
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

  import Modal from '../../../common/components/Modal/Modal';
  import { 
    getViewFiscalYear, 
    displayMoney
  } from '../../../common/utitlities/helpers';
  import { LoadingMixin } from '../../../common/mixins';

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
    name: 'NewAccountsModal',
    mixins: [LoadingMixin],
    components: {
      Modal,
    },
    props: {
      tabData: {
        type: Object,
        required: true,
      },
      headerAccounts: {
        type: Array,
        default: []
      },
      account: {
        type: Object,
        default: {}
      },
      selectedSite: {
        type: Object,
        required: true,
      },
    },
    TYPE,
    data: () => ({
      model: { ...BASE_STATE },
    }),
    computed: {
      isDetail() {
        return this.model.type === TYPE.DETAIL;
      },
      tabId() {
        return this.tabData.id;
      },
      isEdit() {
        return !!this.account.id;
      },
      title() {
        return this.isEdit ? 'Edit Account' : 'New Account';
      },
    },
    watch: {
      isDetail(val) {
        if (!val) {
          this.model.opening_balance = null;
        }
      },
      account: {
        immediate: true,
        handler(value) {
          if (this.account.id) {
            this.model = ({ ...value })
          }
        },
      },
    },
    methods: {
      getViewFiscalYear,
      displayMoney,
      handleClose() {
        this.model = ({ ...BASE_STATE });
        this.$emit('close');
      },
      handleSave() {
        this.validate().then(valid => {
          if (valid) {
            this.enableLoading();
            const payLoad = {family: this.tabData.id, site_id: this.selectedSite.id, ...this.model};
            const method = !this.isEdit ? 'post' : 'put';
            const url = !this.isEdit ? `/accounts` : `/accounts/${this.account.id}`;
            axios[method](url, payLoad)
              .then(() => {
                this.$toastr('success', 'Successfully saved account', 'Success!!');
                this.handleClose();
                this.$emit('saved');
              })
              .catch(() => {
                this.$toastr('error', 'Could not save new account', 'Error!!')
              })
              .finally(this.disableLoading);
          }
        });
      },
      removeAccount() {
        let confirmation = confirm('Are you sure you want to delete?');
        if (confirmation) {
          axios.delete(`/api/accounts/${this.account.id}`)
            .then(() => {
              this.$toastr('success', 'Successfully deleted account.', 'Success!!');
              this.$emit('saved');
            })
            .catch(() => {
              this.$toastr('error', 'Could not delete account', 'Error!!')
            })
            .finally(this.handleClose);
        }
      },
      validate() {
        return this.$validator.validate();
      },
    },
  }
</script>
