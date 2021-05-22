<template>
  <div>
    <div class="row">
      <div class="col-8 row">
        <portlet-content :height="180" :onlybody="true" class="px-2 col-12">
          <div slot="body" class="p-2">
            <div class="row">
              <label class="col-1 text-right pr-2">
                Payee:  
              </label>
              <input type="text" class="form-control col-7 text-primary" disabled v-model="remit.payee_name"/>
            </div>
            <div class="row pt-2">
              <label class="col-1 text-right pr-2">
                Street:  
              </label>
              <input type="text" class="form-control col-7" disabled v-model="remit.payee_street"/>
            </div>
            <div class="row pt-2">
              <label class="col-1 text-right pr-2">
                Suburb:  
              </label>
              <input type="text" class="form-control col-7" disabled v-model="remit.payee_town"/>
            </div>
            <div class="row pt-2">
              <label class="col-1 text-right pr-2">
                State:  
              </label>
              <input type="text" class="form-control col-3" disabled v-model="remit.payee_state"/>
              <label class="col-1 text-right pr-2">
                Code:  
              </label>
              <input type="text" class="form-control col-3" disabled v-model="remit.payee_code"/>
            </div>
          </div>
        </portlet-content>
      </div>
      <div class="col-2 row">
        <portlet-content :height="180" :onlybody="true" class="px-2 col-12">
          <div slot="body" class="p-2" v-if="remit.notes">
            <div class="row">
              <input type="text" disabled v-model="remit.notes[0]"/>
            </div>
            <div class="row">
              <input type="text" disabled v-model="remit.notes[1]"/>
            </div>
            <div class="row">
              <input type="text" disabled v-model="remit.notes[2]"/>
            </div>
            <div class="row">
              <input type="text" disabled v-model="remit.notes[3]"/>
            </div>
          </div>
        </portlet-content>
      </div>
      <div class="col-2 row">
        <portlet-content :height="180" :onlybody="true" class="px-2 col-12">
          <div slot="body" class="p-2">
            <div class="row">
              <label class="col-3 text-right text-primary pr-2">
                Number:  
              </label>
              <input type="text" class="form-control col-7 text-primary" disabled :value="remit.payment_type === 1 ? 'E' + remit.id : remit.cheque_number"/>
            </div>
            <div class="row pt-3">
              <label class="col-6 text-right text-primary pr-2">
                Date Drawn:  
              </label>
              <label class="col-5 text-primary">
                {{ remit.transaction_date || remit.cheque_date }}
              </label>
            </div>
            <div class="row pt-3">
              <label class="text-primary">
                {{ remit.payment_type === 1 ? 'EFT' : 'Cheque' }}
              </label>
            </div>
          </div>
        </portlet-content>
      </div>
      <div class="col-12 row pt-3">
        <portlet-content :height="600" :onlybody="true" class="col-12 px-2">
          <div slot="body" class="p-2">
            <div class="col-12">
              <div class="row table-wrap px-2">
                <table class="table">
                  <tbody>
                    <tr class="row col-12">
                      <td class="table-head col-1">&nbsp;</td>
                      <td class="table-head col-1">Order No</td>
                      <td class="table-head col-1">Reference</td>
                      <td class="table-head col-1">Invoice Amount</td>
                      <td class="table-head col-1">Adjustment</td>
                      <td class="table-head col-1">Discount</td>
                      <td class="table-head col-1">GST</td>
                      <td class="table-head col-4">Comments</td>
                      <td class="table-head col-1">Payment</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row table-wrap px-2" style="max-height: 480px;overflow-y: auto;">
                <table class="table">
                  <tbody>
                    <tr class="row col-12" v-for="item in remit.items" :key="item.id">
                      <td class="col-1">
                        <button class="btn action-buttons w-100 text-danger" @click="changeItemStatus(item.id)">
                          {{ item.default_item_status === $options.PAY ? 'PAY' : 'HOLD' }}
                        </button>
                      </td>
                      <td class="col-1">{{ item.order_no }}</td>
                      <td class="col-1">{{ item.supplier_reference }}</td>
                      <td class="col-1">$ {{ item.invoice_amount }}</td>
                      <td class="col-1">$ {{ item.adjustment }}</td>
                      <td class="col-1">{{ item.discount }}</td>
                      <td class="col-1">{{ item.gst }}</td>
                      <td class="col-4">{{ item.comments }}</td>
                      <td class="col-1">{{ item.gross_payment.toFixed(2) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row table-wrap px-2">
                <table class="table">
                  <tbody>
                    <tr class="row col-12">
                      <td class="table-head col-3">&nbsp;</td>
                      <td class="table-head col-1">${{ getTotal('invoice_amount') }}</td>
                      <td class="table-head col-1">${{ getTotal('adjustment') }}</td>
                      <td class="table-head col-1">${{ getTotal('discount') }}</td>
                      <td class="table-head col-1">${{ getTotal('gst') }}</td>
                      <td class="table-head col-4 text-right">{{ remit.remittance_type === 1 ? 'EFT' : 'CHEQUE' }}</td>
                      <td class="table-head col-1">${{ getTotal('net_payment') }}</td>
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
                    <button type="button" class="btn action-buttons" v-if="remit.remittance_type === $options.MANUAL_PAY_ID && !isEditMode" @click="enableEditMode">Edit</button>
                    <button type="button" class="btn action-buttons" @click="saveRemit" v-if="isEditMode">Save</button>
                    <button type="button" class="btn action-buttons" v-if="isEditMode" @click="cancelRemitEditMode">Cancel</button>
                    <button type="button" class="btn action-buttons" v-if="remit.remittance_type === $options.MANUAL_PAY_ID" @click="openModal('AddRemittance')">Add Item</button>
                    <button type="button" class="btn action-buttons" @click="openModal('TrashOrKeep')">Abort</button>
                    <button type="button" class="btn action-buttons" @click="remitSupplier">Remit</button>
                  </div>
                  <span class="background-black text-truncate mr-3 my-1">
                    ChequeButt
                  </span>
              </div>
          </portlet-content>
      </div>
    </div>
    <template v-if="mountAddRemittance">
      <add-remittance
        :site-id="siteId"
        :remittance-id="remit.id"
        :remit="remit"
        @updated="updateRemit"
        @close="closeModal('AddRemittance')"
      />
    </template>
    <template v-if="mountTrashOrKeep">
      <trash-or-keep
        @trash-it="currentPage = 1"
        @close="closeModal('TrashOrKeep')"
      />
    </template>
  </div>
</template>

<script>

import PortletContent from '../../../../common/components/Portlets/Content/PortletContent';
import TrashOrKeep from '../../../../common/components/TrashOrKeep'
import AddRemittance from './AddRemittance'
import { LoadingMixin } from "../../../../common/mixins";

export default {
  name: 'Remit',
  mixins: [LoadingMixin],
  components: {
    PortletContent,
    TrashOrKeep,
    AddRemittance,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
    siteId: {
      type: Number,
      required: true,
    },
  },
  AUTO_PAY_ID: 1,
  MANUAL_PAY_ID: 2,
  data: () => ({
    remit: {},
    remitCache: {},
    mountTrashOrKeep: false,
    mountAddRemittance: false,
    isEditMode: false,
  }),
  created() {
    this.remit = { ...this.data };
    this.remitCache = { ...this.data };
  },
  methods: {
    remitSupplier() {
      // delete supplier payables item
      this.enableLoading();
      axios.put(`/api/remittances/${this.remit.id}/remit`)
        .then(() => {
          if (this.remit.supplier_id) {
            axios.delete(`/api/suppliers/${this.remit.supplier_id}/removePayables`)
              .then(() => this.$emit('print'))
              .catch(error => console.log('error deleting supplier payables.'))
          }

          if (this.remit.contractor_id) {
            axios.delete(`/api/contractors/${this.remit.contractor_id}/removePayments`)
              .then(() => this.$emit('print'))
              .catch(error => console.log('error deleting payments.'))
          }
        })
        .catch(error => console.log('error remitting remittance.'))
        .finally(() => this.disableLoading());
    },
    changeItemStatus(id) {
      const item = this.remit.items.find(item => item.id === id);
      const payLoad = { ...item, status: item.status === PAY ? HOLD : PAY };
      // update item status by sending an axios request;
      console.log(payLoad);
    },
    getTotal(key) {
      if (!this.remit.items || !this.remit.items.length) {
        return 0;
      }
      return this.remit.items.reduce((acc, item) => acc + item[key], 0);
    },
    openModal(type) {
      this[`mount${type}`] = true;
    },
    closeModal(type) {
      this[`mount${type}`] = false;
    },
    cancelRemitEditMode() {
      this.remit = this.remitCache;
      this.changeEditMode(false);
    },
    enableEditMode() {
      this.modelCache = { ...this.model };
      this.changeEditMode(true);
    },
    changeEditMode(type) {
      this.isEditMode = !!type;
    },
    updateRemit() {
      this.$emit('update', this.remit.id);
    },
  },
};
</script>
