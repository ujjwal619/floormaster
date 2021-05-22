<template>
  <div class="form-container">
    <loading :loading="loading" />
    <template v-if="currentPage === 1">
      <div class="row">
        <div class="col-12">
          <portlet-content :onlybody="true">
            <template slot="body">
              <div class="row">
                <label class="text-right pr-2 col-1">
                  Order No: 
                </label>
                <input type="number" class="form-control text-center col-1" v-model="model.order_no" :disabled="!isEditMode" />
                <button type="button" class="btn action-buttons" @click="redirectToOrder">Get Order</button>
                <label class="text-right pr-2 col-1">
                  Job: 
                </label>
                <input v-if="!isEditMode" type="text" class="form-control col-1" :value="job.job_id" disabled/>
                <drop-down
                  v-else
                  class="col-1 ml-2"
                  :options="jobs"
                  placeholder="Select job"
                  label="job_id"
                  :default-selected="job"
                  v-model="model.job_id"
                />
                <button type="button" class="btn action-buttons" @click="redirectToJob">Get Job</button>
                <label class="text-right pr-2 col-1">
                  Client: 
                </label>
                <input 
                  type="text" 
                  class="form-control col-3" 
                  v-model="model.client" 
                  :disabled="!isEditMode"
                />
              </div>
            </template>
          </portlet-content>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6">
          <portlet-content :onlybody="true">
            <div slot="body" class="px-2 pb-2">
              <div class="row">
                <div class="col-12 row d-flex justify-content-between">
                  <div class="background-black">Pay To..</div>
                  <span class="col-3 text-light">{{ formatViewDate(payable.created_at) }}</span>
                </div>
              </div>
              <div class="row pt-1">
                <div class="d-flex justify-content-end align-items-center col-8">
                  <label class="pr-2">Supplier SN: </label>
                  <span class="text-primary">{{ supplier.id }}</span>
                </div>
              </div>
              <div class="row pt-2">
                <label class="text-right pr-2 col-1">
                  Payee: 
                </label>
                <input type="text" class="form-control col-9" :value="supplier.trading_name" disabled />
              </div>
              <div class="row pt-2">
                <label class="text-right pr-2 col-1">
                  Address: 
                </label>
                <input type="text" class="form-control col-9" :value="supplier.street" disabled />
              </div>
              <div class="row pt-2">
                <label class="text-right pr-2 col-1">
                  &nbsp; 
                </label>
                <input type="text" class="form-control col-6" :value="supplier.suburb" disabled />
                <input type="text" class="form-control col-1" :value="supplier.state" disabled />
                <input type="text" class="form-control col-1" :value="supplier.code" disabled />
              </div>
            </div>
          </portlet-content>
        </div>
        <div class="col-6">
          <portlet-content :onlybody="true">
            <div slot="body" class="px-2 pb-2">
              <div class="row">
                <div class="background-black">Trading Terms</div>
              </div>
              <div class="row pt-1">
                <div class="col-6">
                  <div class="row">
                    <label class="font-weight-bold text-right col-9 pr-1">Early Discount:</label>
                    <input type="number" class="form-control col-2" v-model="model.trading_terms.early_discount" :disabled="!isEditMode">
                  </div>
                  <div class="row pt-2">
                    <label class="col-9 text-right pr-1">End of Month:</label>
                    <input type="number" class="form-control col-1" v-model="model.trading_terms.early_end_of_month" :disabled="!isEditMode">
                    Days
                  </div>
                  <div class="row pt-2">
                    <label class="col-9 text-right pr-1">OR Invoice Date:</label>
                    <input type="number" class="form-control col-1" v-model="model.trading_terms.early_invoice_date" :disabled="!isEditMode">
                    Days
                  </div>
                  <div class="row pt-2">
                    <label class="col-9 text-right pr-1">OR Bi-Monthly:</label>
                    <input type="number" class="form-control col-1" v-model="model.trading_terms.early_bi_monthly" :disabled="!isEditMode">
                  </div>
                </div>
                <div class="col-6">
                  <div class="row">
                    <label class="font-weight-bold text-right col-4 pr-1">Normal Discount:</label>
                    <input type="number" class="form-control col-2" v-model="model.trading_terms.normal_discount" :disabled="!isEditMode">
                  </div>
                  <div class="row pt-2">
                    <label class="col-4 text-right pr-1">End of Month:</label>
                    <input type="number" class="form-control col-1" v-model="model.trading_terms.normal_end_of_month" :disabled="!isEditMode">
                    Days
                  </div>
                  <div class="row pt-2">
                    <label class="col-4 text-right pr-1">OR Invoice Date:</label>
                    <input type="number" class="form-control col-1" v-model="model.trading_terms.normal_invoice_date" :disabled="!isEditMode">
                    Days
                  </div>
                  <div class="row pt-2">
                    <label class="col-9 text-right pr-1">Late Factor:</label>
                    <input type="number" class="form-control col-1" v-model="model.trading_terms.late_factor" :disabled="!isEditMode">
                    Days
                  </div>
                </div>
              </div>
            </div>
          </portlet-content>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-12">
          <portlet-content :onlybody="true">
            <div slot="body" class="px-2 pt-1 pb-2">
              <div class="row">
                <div class="col-2">
                  <div class="row">
                    <label class="text-right pr-2 col-6">
                      Date Delivered: 
                    </label>
                    <input 
                      v-if="isEditMode"
                      type="date" 
                      class="form-control col-6" 
                      v-model="model.date_delivered" 
                    />
                    <input 
                      v-else
                      type="text" 
                      class="form-control col-6" 
                      :value="formatViewDate(model.date_delivered)" 
                      disabled
                    />
                  </div>
                </div>
                <div class="col-2">
                  <div class="row">
                    <label class="text-right pr-2 col-6">
                      Invoice Date: 
                    </label>
                    <input 
                      v-if="isEditMode" 
                      type="date" 
                      class="form-control col-6" 
                      v-model="model.invoice_date" 
                    />
                    <input 
                      v-else
                      type="text" 
                      class="form-control col-6" 
                      :value="formatViewDate(model.invoice_date)"
                      disabled 
                    />
                  </div>
                </div>
                <div class="col-2">
                  <div class="row">
                    <label class="text-right pr-2 col-6">
                      Invoice No: 
                    </label>
                    <input 
                      type="text" 
                      class="form-control col-6" 
                      v-model="model.supplier_reference" 
                      :disabled="!isEditMode" 
                    />
                  </div>
                </div>
                <div class="col-3">
                  <div class="row">
                    <label class="text-right col-6">
                      Expected Amount: 
                    </label>
                    <label class="col-6">
                      <b>${{ expectedAmount }}</b>
                    </label>
                  </div>
                  <div class="row">
                    <label class="text-right col-6">
                      Invoice Amount: 
                    </label>
                    <label class="col-6">
                      <b>${{ this.model.invoice_amount }}</b>
                    </label>
                  </div>
                  <div class="row">
                    <label class="text-right col-6">
                      Difference: 
                    </label>
                    <label class="col-6">
                      <b>${{ difference }}</b>
                    </label>
                  </div>
                </div>
              </div>
              <div class="row pt-3">
                <span class="col-3 text-right">Goods</span>
                <span class="col-1 text-right">Levy</span>
                <span class="col-1 text-right">Baling/Delivery</span>
                <span class="col-1 text-right">GST Credit</span>
              </div>
              <div class="row pt-2">
                <span class="col-2 text-right">Payable</span>
                <input type="text" class="form-control col-1 text-right" :disabled="!isEditMode" v-model="model.goods">
                <input type="text" class="form-control col-1 text-right" :disabled="!isEditMode" v-model="model.levy">
                <input type="text" class="form-control col-1 text-right" :disabled="!isEditMode" v-model="model.freight">
                <input type="text" class="form-control col-1 text-right" :disabled="!isEditMode" v-model="model.gst">
                <label class="col-2 text-right">${{ expectedAmount }}</label>
              </div>
              <div class="row pt-2">
                <span class="col-2 text-right">Paid</span>
                <input type="text" class="form-control col-1 text-right" disabled >
                <input type="text" class="form-control col-1 text-right" disabled >
                <input type="text" class="form-control col-1 text-right" disabled >
                <input type="text" class="form-control col-1 text-right" disabled >
                <label class="col-2 text-right"></label>
                <input type="text" class="form-control col-1 ml-2 text-right" disabled :value="'-$' + difference">
                <label class="col-1 text-right">Adjustment</label>
              </div>
              <div class="row pt-2">
                <span class="col-2 text-right">Balance</span>
                <input type="text" class="form-control text-danger col-1 text-right" disabled :value="'$' + (model.goods || '')">
                <input type="text" class="form-control text-danger col-1 text-right" disabled :value="'$' + (model.levy || '')">
                <input type="text" class="form-control text-danger col-1 text-right" disabled :value="'$' + (model.freight || '')">
                <input type="text" class="form-control text-danger col-1 text-right" disabled :value="'$' + (model.gst || '')">
                <label class="col-2 text-right">${{ expectedAmount }}</label>
              </div>
              <div class="row pt-2">
                <span class="col-7">&nbsp;</span>
                <label class="col-1">Adjustment Reason</label>
              </div>
              <div class="row pt-1">
                <span class="col-7">&nbsp;</span>
                <textarea class="col-4" :disabled="!isEditMode" cols="10" rows="2" v-model="model.comments"></textarea>
              </div>
            </div>
          </portlet-content>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6">
          <portlet-content :onlybody="true" :height="206">
            <div slot="body" class="px-2 pb-2">
            <div class="row">
                <div class="background-black">Credit Request</div>
              </div>
              <div class="row pt-1">
                <label class="text-right col-8 pr-1">
                  Date Required:
                </label>
                <input 
                  v-if="isEditMode" 
                  type="date" 
                  class="col-2 form-control" 
                  v-model="model.credit_request.date_required" 
                >
                <input 
                  v-else
                  type="text" 
                  class="col-2 form-control" 
                  :value="formatViewDate(model.credit_request.date_required)" 
                >
              </div>
              <div class="row pt-1">
                <label class="text-right col-8 pr-1">
                  Amount:
                </label>
                <input type="number" class="col-2 form-control" v-model="model.credit_request.amount" :disabled="!isEditMode">
              </div>
              <div class="row pt-1">
                <label class="text-right col-8 pr-1">
                  Amount Granted:
                </label>
                <input type="number" class="col-2 form-control" v-model="model.credit_request.amount_granted" :disabled="!isEditMode">
              </div>
              <div class="row pt-2">
                <label class="col-12">Reason: </label>
                <textarea class="col-12" cols="10" rows="2" v-model="model.credit_request.reason" :disabled="!isEditMode"></textarea>
              </div>
            </div>
          </portlet-content>
        </div>
        <div class="col-6">
          <portlet-content :onlybody="true" :height="206">
            <div slot="body" class="px-2 pb-2">
              <div class="row d-flex align-items-center">
                <span class="background-black col-1 pr-2">Liability</span>
                <input type="text" class="ml-2 col-6 text-right form-control" :value="liabilityAccount.name" disabled>
                <input type="text" class="mr-2 col-2 form-control text-right" :value="liabilityAccount.code" disabled>
                <button type="button" class="btn action-buttons" @click="pickLiabilityAccount">&gt;&gt; Pick</button>
              </div>
              <div class="row d-flex align-items-center pt-2">
                <span class="background-black col-1 pr-2">Goods</span>
                <input type="text" class="ml-2 col-6 text-right form-control" :value="costAccount.name" disabled>
                <input type="text" class="mr-2 col-2 form-control text-right" :value="costAccount.code" disabled>
                <button type="button" class="btn action-buttons" @click="pickCostAccount">&gt;&gt; Pick</button>
              </div>
              <div class="row d-flex align-items-center pt-2">
                <span class="background-black col-1 pr-2">Levy</span>
                <input type="text" class="ml-2 col-6 text-right form-control" :value="levyAccount.name" disabled>
                <input type="text" class="mr-2 col-2 form-control text-right" :value="levyAccount.code" disabled>
                <button type="button" class="btn action-buttons" @click="pickLevyAccount">&gt;&gt; Pick</button>
              </div>
            </div>
          </portlet-content>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-12 mt-2">
          <portlet-content :onlybody="true" isform="true">
            <div slot="body" class="menu-bar d-flex justify-content-between">
              <div class="mt-1">
                <button type="button" class="btn action-buttons" @click="openModal('SearchPayables')">Search</button>
                <button
                  type="button"
                  class="btn action-buttons"
                  v-if="!isEditMode && hasPermission('payables.edit')"
                  @click="enableEditMode"
                >Edit</button>
                <button
                  type="button"
                  class="btn action-buttons"
                  v-if="isEditMode"
                  @click="updatePayable"
                >Save</button>
                <button
                  type="button"
                  class="btn action-buttons"
                  v-if="isEditMode"
                  @click="cancelEditMode"
                >Cancel</button>
                <button v-if="hasPermission('payables.add')" type="button" class="btn action-buttons" @click="openModal('AddPayables')">Add</button>
                <button type="button" class="btn action-buttons" @click="openModal('SelectPayment')">Pay</button>
                <button type="button" class="btn action-buttons">Copy</button>
                <button 
                  v-if="!isEditMode && 
                    hasPermission('payables.delete') && 
                    payable.id" 
                  type="button" 
                  class="btn action-buttons" 
                  @click="openModal('DeletePayable')"
                >Delete</button>
              </div>
              <span class="background-black text-truncate mr-3 my-1">Payables</span>
            </div>
          </portlet-content>
        </div>
      </div>
    </template>
    <remit
      v-else-if="currentPage === 2"
      :data="remit"
      :site-id="payable.site_id"
      @update="loadRemitData"
      @print="goToPrintRemit"
      @trash="currentPage=1"
    />
    <remit-print
      v-else
      :remit="remit"
    />
    <search-payables
      v-if="mountSearchPayables"
      @selected="fetchPayableDetail"
      @close="closeModal('SearchPayables')"
    />
    <account-pick
      v-if="mountAccountPick"
      :accounts="choosenAccounts"
      :default-account="defaultAccount"
      @selected="accountPicked"
      @close="closeModal('AccountPick')"
    />
    <add-payables
      v-if="mountAddPayables"
      @updated="fetchPayableDetail"
      @close="closeModal('AddPayables')"
    />
    <delete-payable
      v-if="mountDeletePayable"
      :payable-id="payable.id"
      @deleted="loadPayable"
      @close="closeModal('DeletePayable')"
    />
    <select-payment
      v-if="mountSelectPayment"
      :site-id="payable.site_id"
      :current-supplier="payable.supplier_id"
      :payable="payable.id"
      @remit="handleRemitPaid"
      @close="closeModal('SelectPayment')"  
    />
  </div>
</template>

<script>

import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import Remit from './components/Remit';
import AddPayables from './components/AddPayables';
import SelectPayment from '../Suppliers/components/SelectPayment'
import SearchPayables from './components/SearchPayables';
import { LoadingMixin, CurrentUserMixin } from "../../../common/mixins";
import DropDown from "../../../common/components/DropDown/DropDown";
import RemitPrint from './components/RemitPrint';
import DeletePayable from './components/DeletePayable';
import {
  getJobsBySite,
  getAccountsBySite,
  indexPayable,
  getPayableById,
} from "../../api/calls";
import AccountPick from "../../../common/components/AccountPick";
import { formatViewDate } from '../../../common/utitlities/helpers';

export default {
  name: 'Payables',
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    PortletContent,
    AddPayables,
    SearchPayables,
    DropDown,
    AccountPick,
    SelectPayment,
    Remit,
    RemitPrint,
    DeletePayable
  },
  props: {
    payableId: {
      type: Number,
      default: 0
    }
  },
  data: () => ({
    activeAccountPick: '',
    isEditMode: false,
    mountSearchPayables: false,
    mountAddPayables: false,
    mountDeletePayable: false,
    mountAccountPick: false,
    mountSelectPayment: false,
    model: {
      credit_request: {},
      trading_terms: {},
    },
    payable: {},
    jobs: [],
    liabilityAccounts: [],
    accounts: [],
    choosenAccounts: [],
    defaultAccount: {},
    currentPage: 1,
  }),
  computed: {
    job() {
      return this.payable.job || {};
    },
    supplier() {
      return this.payable.supplier || {};
    },
    expectedAmount() {
      return (Number(this.payable.goods) + Number(this.payable.freight) + Number(this.payable.levy) + Number(this.payable.gst)).toFixed(2);
    },
    difference() {
      return this.payable.invoice_amount - Number(this.expectedAmount);
    },
    adjustment() {
      return -this.difference;
    },
    liabilityAccount() {
      return this.payable.liability_account || {};
    },
    levyAccount() {
      return this.payable.levy_account || {};
    },
    costAccount() {
      return this.payable.cost_account || {};
    },
  },
  created() {
    this.loadPayable();
    // this.loadRemitData(53);
  },
  methods: {
    formatViewDate,
    goToPrintRemit(remitId) {
      this.loadRemitData(remitId);
      this.currentPage = 3;
    },
    loadPayable() {
      if (!this.payableId) {
        this.enableLoading();
        indexPayable()
          .then(({ data }) => {
            if (!data.data.id) {
              this.$toastr('error', 'No Record Found.', 'Error!!')
            } else {
              this.fetchPayableDetail(data.data.id);
            }
          })
          .catch(() => {
            this.$toastr('error', 'Could not fetch payable information.', 'Error!!')
          })
          .finally(this.disableLoading)
      } else {
        this.enableLoading();
        this.fetchPayableDetail(this.payableId)
          .catch(() => {
            console.log('could not fetch payable')
          })
          .finally(this.disableLoading);
      }
    },
    accountPicked(accountId) {
      if (this.activeAccountPick === 'Liability') {
        this.model.liability_account = accountId;
      } else if (this.activeAccountPick === 'Cost') {
        this.model.cost_account = accountId;
      } else {
        this.model.levy_account = accountId;
      }

      this.closeModal('AccountPick');
      this.updatePayable();
    },
    pickLiabilityAccount() {
      this.activeAccountPick = 'Liability';
      this.choosenAccounts = this.liabilityAccounts;
      this.defaultAccount = this.payable.liability_account;
      this.openModal('AccountPick');
    },
    pickCostAccount() {
      this.activeAccountPick = 'Cost';
      this.choosenAccounts = this.accounts;
      this.defaultAccount = this.payable.cost_account;
      this.openModal('AccountPick');
    },
    pickLevyAccount() {
      this.activeAccountPick = 'Levy';
      this.choosenAccounts = this.accounts;
      this.defaultAccount = this.payable.levy_account;
      this.openModal('AccountPick');
    },
    redirectToJob() {
      if (!this.model.job_id) {
        return;
      }
      window.location.href = `/jobs/${this.model.job_id}/edit`;
    },
    redirectToOrder() {
      if (!this.model.order_no) {
        return;
      }
      window.location.href = `/current-orders/${this.model.order_no}`;
    },
    fetchPayableDetail(id) {
      return getPayableById(id)
        .then(({ data }) => {
          const payable = data.data;
          this.payable = payable;
          this.model.order_no = payable.order_no;
          this.model.client = payable.client || payable.job ? payable.job.trading_name : '';
          this.model.date_delivered = payable.date_delivered;
          this.model.invoice_date = payable.invoice_date;
          this.model.invoice_amount = payable.invoice_amount;
          this.model.supplier_reference = payable.supplier_reference;
          this.model.goods = payable.goods || 0;
          this.model.freight = payable.freight || 0;
          this.model.levy = payable.levy || 0;
          this.model.gst = payable.gst || 0;
          this.model.comments = payable.comments;
          this.model.liability_account = payable.liability_account ? payable.liability_account.id : null;
          this.model.cost_account = payable.cost_account ? payable.cost_account.id : null;
          this.model.levy_account = payable.levy_account ? payable.levy_account.id : null;
          this.model.job_id = payable.job_id;
          this.model.credit_request = this.payable.credit_request || {};
          this.model.trading_terms = this.payable.trading_terms || {};


          this.fetchLiabilityAccountBySite(payable.site_id);
          this.fetchAccountsBySite(payable.site_id);
        })
    },
    fetchLiabilityAccountBySite(siteId) {
      axios.get(`/accounts/2/sites/${siteId}`)
        .then(({ data }) => {
          this.liabilityAccounts = data.data;
        })
        .catch(() => {
          console.log('could not fetch liability account.');
        })
    },
    fetchAccountsBySite(siteId) {
      getAccountsBySite(siteId)
        .then(({ data }) => {
          this.accounts = data.data;
        })
        .catch(() => {
          console.log('could not fetch accounts.');
        })
    },
    updatePayable() {
      this.enableLoading();
      axios.put(`/api/payables/${this.payable.id}`, ({ ...this.model, trading_terms: this.model.trading_terms }))
        .then(() => {
          this.$toastr('success', 'Payable Updated Successfully.', 'Success!!')
          this.fetchPayableDetail(this.payable.id);
        })
        .catch(() => {
          this.$toastr('error', 'Could not update Payable.', 'Error!!')
        })
        .finally(() => {
          this.disableLoading();
          this.cancelEditMode();
        });
    },
    enableEditMode() {
      if (!this.jobs.length) {
        this.enableLoading();
        getJobsBySite(this.payable.site_id)
          .then(({ data }) => {
            this.jobs = data.data;
          })
          .catch(() => {
            console.log('could not fetch jobs');
          })
          .finally(this.disableLoading);
      }
      this.changeEditMode(true);
    },
    changeEditMode(type) {
      this.isEditMode = !!type;
    },
    cancelEditMode() {
      this.changeEditMode(false);
    },
    openModal(name) {
      if (name) {
        this[`mount${name}`] = true;
      }
    },
    closeModal(name) {
      if (name) {
        this[`mount${name}`] = false;
      }
    },
    addButtonHandler() {
      this.showModal('SelectPayment');
    },
    handleRemitPaid(data) {
      this.loadRemitData(data.id);
    },
    loadRemitData(id) {
      this.enableLoading();
      axios.get(`/api/remittances/${id}`)
        .then(({ data }) => {
          this.remit = Object.assign({}, { ...this.remit }, { ...data.data } );
          this.remit.notes = this.remit.notes || [];
        this.currentPage = 2;
        // this.currentPage = 3;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
  },
};
</script>
