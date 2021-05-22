<template>
  <div class="form-container">
    <template v-if="currentPage === 1">
      <div class="row">
        <div class="col-5">
          <portlet-content :height="120" :onlybody="true" class="px-2" >
            <div slot="body">
              <div class="row">
                <label class="col-2 text-right">
                  Payee:
                </label>
                <input type="text" class="form-control text-primary col-8" :disabled="!isEditMode" v-model="model.payee_name">
              </div>
              <div class="row pt-2">
                <label class="col-2 text-right">
                  Street:
                </label>
                <input type="text" class="form-control col-8" :disabled="!isEditMode" v-model="model.payee_street">
              </div>
              <div class="row pt-2">
                <label class="col-2 text-right">
                  Suburb:
                </label>
                <input type="text" class="form-control col-8" :disabled="!isEditMode" v-model="model.payee_town">
              </div>
              <div class="row pt-2">
                <label class="col-2 text-right">
                  State:
                </label>
                <input type="text" class="form-control col-2" :disabled="!isEditMode" v-model="model.payee_state">
                <label class="col-2 text-right">
                  Code:
                </label>
                <input type="text" class="form-control col-2" :disabled="!isEditMode" v-model="model.payee_code">
              </div>
            </div>
          </portlet-content>
        </div>
        <div class="col-5">
          <portlet-content :height="180" :onlybody="true" class="px-2 col-12">
            <div slot="body" class="p-2">
              <div class="row">
                <input type="text" disabled v-model="model.notes[0]"/>
              </div>
              <div class="row">
                <input type="text" disabled v-model="model.notes[1]"/>
              </div>
              <div class="row">
                <input type="text" disabled v-model="model.notes[2]"/>
              </div>
              <div class="row">
                <input type="text" disabled v-model="model.notes[3]"/>
              </div>
            </div>
          </portlet-content>
        </div>
        <div class="col-2">
          <portlet-content :height="120" :onlybody="true">
            <div slot="body"  class="p-2">
              <div class="row">
                <label class="text-primary text-right col-4">Number: </label>
                <input type="text" class="form-control col-7 text-primary" disabled :value="model.payment_type === 1 ? 'E' + model.id : model.cheque_number"/>
              </div>
              <div class="row pt-3">
                <label class="text-primary col-4 text-right">Date Drawn: </label>
                <label class="text-primary col-7">{{ formatViewDate(model.transaction_date) || formatViewDate(model.cheque_date) }}</label>
              </div>
              <div class="row pt-3">
                <label class="text-primary font-weight-bolder">
                  {{ model.payment_type === 1 ? 'EFT' : 'Cheque' }}
                </label>
              </div>
            </div>
          </portlet-content>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-12">
          <portlet-content :height="555" :onlybody="true">
            <div slot="body" class="row cheque-table">
              <div class="col-12">
                <div class="row table-wrap">
                  <table class="table">
                    <tbody>
                      <tr class="row col-12">
                        <td class="table-head col-1">Order No</td>
                        <td class="table-head col-1">Your Reference</td>
                        <td class="table-head col-1">Invoice Amount</td>
                        <td class="table-head col-1">Adjustment</td>
                        <td class="table-head col-1">Discount</td>
                        <td class="table-head col-1">GST</td>
                        <td class="table-head col-5">Comments</td>
                        <td class="table-head col-1">Payment</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="row table-wrap" style="max-height: 480px;overflow-y: auto;">
                  <table class="table">
                    <tbody>
                      <tr class="row col-12" :key="item.id" v-for="item in model.items">
                        <td class="form-control col-1">{{ item.order_no}}</td>
                        <td class="form-control col-1">{{ item.supplier_reference }}</td>
                        <td class="form-control col-1">${{ item.invoice_amount || 0 }}</td>
                        <td class="form-control col-1">${{ item.adjustment || 0 }}</td>
                        <td class="form-control col-1">${{ item.discount || 0 }}</td>
                        <td class="form-control col-1">${{ item.gst }}</td>
                        <td class="form-control col-5">{{ item.comments }}</td>
                        <td class="form-control col-1">${{ item.invoice_amount || 0}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="row table-wrap">
                  <table class="table">
                    <tbody>
                      <tr class="row col-12">
                        <td class="table-head col-2">&nbsp;</td>
                        <td class="table-head col-1 text-primary">
                          ${{ totalPayment }}
                        </td>
                        <td class="table-head col-2">&nbsp;</td>
                        <td class="table-head col-1 text-primary">
                          ${{ totalGST }}
                        </td>
                        <td class="table-head col-5">&nbsp;</td>
                        <td class="text-primary table-head col-1">
                          ${{ totalPayment }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </portlet-content>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-12 mt-4">
            <portlet-content isform="true" :onlybody="true">
                <div slot="body" class="menu-bar d-flex justify-content-between">
                    <div class="mt-1">
                      <button type="button" class="btn action-buttons" @click="showModal('SearchCheque')">Search</button>
                      <button 
                        type="button" 
                        class="btn action-buttons" 
                        v-if="!isEditMode && hasPermission('cheque.butt.edit')" 
                        @click="enableEditMode"
                      >Edit</button>
                      <button 
                        type="button" 
                        class="btn action-buttons" 
                        v-if="isEditMode" 
                        @click="saveChequeButt"
                      >Save</button>
                      <button type="button" class="btn action-buttons" v-if="isEditMode" @click="cancelEditMode">Cancel</button>
                      <button 
                        v-if="hasPermission('cheque.butt.draw.cheque')"
                        type="button" 
                        class="btn action-buttons" 
                        @click="addButtonHandler"
                      >Add</button>
                      <button 
                        v-if="hasPermission('cheque.butt.void.cheque')"
                        type="button" 
                        class="btn action-buttons"
                      >Void</button>
                    </div>
                    <span class="background-black text-truncate mr-3 my-1">
                      ChequeButt
                    </span>
                </div>
            </portlet-content>
        </div>
      </div>
    </template>
    <remit
      v-else-if="currentPage === 2"
      :data="remit"
      :site-id="model.site_id"
      @update="loadRemitData"
      @print="currentPage = 3"
    />
    <remit-print
      v-else
      :remit="remit"
    />
    <search-cheque
      v-if="mountSearchCheque"
      @selected="handleSelectedChequeButt"
      @close="hideModal('SearchCheque')"
    />
    <template>
      <loading :loading="loading" />
    </template>
    <select-payment
      v-if="mountSelectPayment"
      @remit="handleRemitPaid"
      @close="hideModal('SelectPayment')"
    />
  </div>
</template>


<script>

import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import Remit from './components/Remit';
import SelectPayment from '../../../common/components/Payment/SelectPayment'
import SearchCheque from './components/SearchCheque';
import RemitPrint from './components/RemitPrint';
import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins'
import { formatViewDate } from '../../../common/utitlities/helpers';

export default {
  name: 'ChequeButt',
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    PortletContent,
    SearchCheque,
    SelectPayment,
    Remit,
    RemitPrint,
  },
  props: {
    remittanceId: {
      type: Number,
      default: 0
    }
  },
  data: () =>({
    model: {
      payee_name: '',
      payee_street: '',
      payee_suburb: '',
      payee_state: '',
      payee_code: '',
      number: '',
      date_drawn: '',
      notes: {}
    },
    isEditMode: false,
    mountSearchCheque: false,
    mountSelectPayment: false,
    remit: {},
    currentPage: 1,
  }),
  computed: {
    totalPayment() {
      if (this.model.items) {
        return this.model.items.reduce((sum, item) => {
          return sum + Number(item.invoice_amount);
        }, 0)
      }
      return 0;
    },
    totalGST() {
      if (this.model.items) {
        return this.model.items.reduce((sum, item) => {
          return sum + Number(item.gst);
        }, 0)
      }
      return 0;
    }
  },
  created() {
    if (!this.remittanceId) {
      this.fetchIndexRemittance();
    } else {
      this.fetchRemittanceById(this.remittanceId);
    }
  },
  methods: {
    formatViewDate,
    handleSelectedChequeButt(chequeButt) {
      this.fetchRemittanceById(chequeButt);
    },
    fetchRemittanceById(id) {
      this.enableLoading();
      axios.get(`/api/remittances/${id}`)
        .then(({data}) => {
          this.fillModel(data.data);
        })
        .catch(() => console.log('error fetching remittance data'))
        .finally(() => {
          this.disableLoading();
          this.hideModal('SearchCheque');
        })
    },
    fillModel(remittance) {
      if (remittance) {
        this.model = remittance;
        this.model.notes = this.model.notes || {};
        if (this.model.contractor_id) {
          this.model.payee_name = this.model.contractor.name;
          this.model.payee_street = this.model.contractor.street;
          this.model.payee_town = this.model.contractor.suburb;
          this.model.payee_state = this.model.contractor.state;
          this.model.payee_code = this.model.contractor.postcode;
        }
        if (this.model.supplier_id) {
          this.model.payee_name = this.model.supplier.trading_name;
          this.model.payee_street = this.model.supplier.street;
          this.model.payee_town = this.model.supplier.suburb;
          this.model.payee_state = this.model.supplier.state;
          this.model.payee_code = this.model.supplier.code;
          this.model.notes = this.model.notes || {};
        }
      }
    },
    fetchIndexRemittance() {
      this.enableLoading();
      axios.get('/api/remittances')
        .then(({ data }) => {
          this.fillModel(data.data);
        })
        .catch(() => {
          this.$toastr('error', 'Could not fetch Cheque Butt.', 'Error!!')
        })
        .finally(this.disableLoading);
    },
    showModal(type) {
      if (type) {
        this[`mount${type}`] = true;
      }
    },
    hideModal(type) {
      if (type) {
        this[`mount${type}`] = false;
      }
    },
    enableEditMode() {},
    saveChequeButt() {},
    cancelEditMode() {},
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
          if (this.remit.supplier_id) {
            this.remit.payee_name = this.remit.supplier.trading_name;
            this.remit.payee_street = this.remit.supplier.street;
            this.remit.payee_town = this.remit.supplier.suburb;
            this.remit.payee_state = this.remit.supplier.state;
            this.remit.payee_code = this.remit.supplier.code;
            this.remit.notes = this.remit.notes || [];
          }
        this.currentPage = 2;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
  }
};
</script>

<style scoped>
.cheque-table {
  padding: 5px 30px;
}

.form-control {
  line-height: 24px !important;
}
</style>
