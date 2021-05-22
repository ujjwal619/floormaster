<div class="form-container">
  <template>
    <template>
      <loading :loading="loading" />
    </template>
    <div class="d-flex justify-content-between">
      <span class="text-warning h3 text-bold">Tax Invoice @{{ jobInvoiceId }}</span>
      <span class="text-warning h3 text-bold">@{{ salesPerson.name || '' }}</span>
      <span class="text-warning h3 text-bold">@{{ formatViewDate(invoice.date) }}</span>
    </div>
    <div class="col-xsmall-12 col-small-12">
      <div class="row">
          <div class="col-7">
            <portlet-content :height="210" :onlybody="true" class="col-12 px-1">
              <div slot="body" class="form-group p-2">
                <div class="row">
                  <div class="col-4 d-flex flex-column">
                    <span class="h6 text-danger">@{{ clientName }}</span>
                    <input class="form-control text-primary mt-1" type="text" :value="address.street" disabled>
                    <input class="form-control text-primary mt-1" type="text" :value="address.town" disabled>
                    <div class="mt-1 d-flex">
                      <input class="form-control text-primary col-6" type="text" :value="address.state" disabled>
                      <input class="form-control text-primary col-6" type="text" :value="address.code" disabled>
                    </div>
                    <input class="form-control text-primary mt-1" type="text" :value="job.contact" disabled>
                    <input class="form-control text-primary mt-1" type="text" :value="job.project" disabled>
                  </div>
                  <div class="col-3 d-flex justify-content-center align-items-center">
                    <span class="h5">Client Code:</span>
                  </div>
                  <div class="col-5">
                    <span class="text-primary h6">
                      You can receipt payment using this Invoice from this screen
                      or the Job screen, using the Update button.
                      Activate the Update button to create expenses against this 
                      Invoice. These may be credit charges, returned cheques, bank
                      fees or write-offs. Invoice related Debits will affect your
                      Invoice balance Due.
                      Editing amounts from the General Ledger Transaction Journal.
                    </span>
                  </div>
                </div>
                <div class="d-flex justify-content-end p-2">
                  <div class="d-flex">
                    <span class="text-nowrap pr-2">Sales Code:</span>
                    <input type="text" disabled class="form-control" :value="salesCode.code">
                  </div>
                </div>
              </div>
            </portlet-content>
            <portlet-content :height="350" :onlybody="true" class="col-12 px-1">
              <div slot="body" class="p-2">
                <textarea cols="10" rows="11" v-model="model.remarks" :disabled="!isEditMode"></textarea>
              </div>
            </portlet-content>
            <portlet-content :height="50" :onlybody="true" class="col-12 px-1">
              <div slot="body" class="p-2 row">
                <span class="col-1">Terms: </span>
                <input type="text" class="form-control col-1" :value="term.id" disabled>
                <input type="text" class="form-control col-3" :value="term.name" disabled>
              </div>
            </portlet-content>
            <portlet-content :height="195" :onlybody="true" class="col-12 px-1">
              <div slot="body" class="p-2">
                <textarea cols="10" rows="5" disabled>@{{ quoteTerm }}</textarea>
              </div>
            </portlet-content>
            <portlet-content isform="true" :onlybody="true">
              <div slot="body" class="menu-bar d-flex justify-content-between">
                <div class="py-1">
                    <button type="button" class="btn action-buttons" @click="openModal('SearchBilling')">Search</button>
                    <button type="button" class="btn action-buttons">Report</button>
                    <button type="button" class="btn action-buttons" @click="enableEditMode()" v-if="!isEditMode" >Edit</button>
                    <button type="button" class="btn action-buttons" @click="cancelEditMode()" v-else>Cancel</button>
                    <button type="button" class="btn action-buttons" @click="updateInvoice">Save</button>
                    <button type="button" class="btn action-buttons" @click="openModal('UpdateBill')">Update</button>
                    <button type="button" class="btn action-buttons">Help</button>
                    <button type="button" class="btn action-buttons" @click="redirectToJob">Go to Job</button>
                    <button type="button" class="btn action-buttons text-primary">Index=inv.no</button>
                    <span class="h6"> Use the 'Index=' button to change lookup '?' browsing order
                </div>
                <span class="background-black text-truncate mr-3 my-1 d-inline-flex align-items-center">
                    Blilling Text Editor
                </span>
              </div>
          </portlet-content>
          </div>
          <div class="col-5">
            <portlet-content :height="866" :onlybody="true" class="col-12 px-1">
              <div slot="body" class="row p-2">
                <div class="col-5 d-flex align-items-center">
                  <input type="checkbox" v-model="model.financed">
                  <span class="text-bold h5 ml-1">Financed</span>
                </div>
                <div class="col-7 row d-flex align-items-center">
                  <span class="col-6 h5 text-right pr-2">Net Invoice:</span>
                  <input v-if="isEditMode" type="text" class="col-6 text-right" v-model="model.net_invoice">
                  <input v-else type="text" class="col-6 text-right" :value="displayMoney(model.net_invoice)" disabled>
                </div>
                <div class="col-5 d-flex align-items-center">&nbsp;</div>
                <div class="col-7 row d-flex align-items-center pt-2">
                  <span class="col-3 h5 text-right pr-2">GST%:</span>
                  <input v-if="isEditMode" type="number" class="col-2 text-right" v-model="model.gst">
                  <input v-else type="text" class="col-2 text-right" :value="model.gst + '%'" disabled>
                  <span class="col-2 h5 text-right pr-2">GST$:</span>
                  <input v-if="isEditMode" type="text" class="col-5 text-right" v-model="gstAmount">
                  <input v-else type="text" class="col-5 text-right" :value="displayMoney(gstAmount)" disabled>
                  
                </div>
                <div class="col-5 d-flex align-items-center">
                  &nbsp
                </div>
                <div class="col-7 row d-flex align-items-center pt-3">
                  <span class="col-6 h5 text-right text-danger pr-2">Total Charge:</span>
                  <input v-if="isEditMode" type="text" class="col-6 text-right" v-model="model.amount">
                  <input v-else type="text" class="col-6 text-right" :value="displayMoney(model.amount)" disabled>
                </div>
                <div class="col-12 pt-3">
                  <span class="background-black">
                    Recepits
                  </span>
                </div>
                <div class="col-12 pt-2">
                  <div class="row">
                    <table class="table mx-2">
                      <tbody>
                        <tr class="row col-12">
                          <td class="col-5">Date</td>
                          <td class="col-4">Type</td>
                          <td class="col-3 text-right">Amount</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row table-wrap" style="max-height: 112px;overflow-y: auto;">
                    <table class="table mx-2">
                      <tbody>
                        <template v-if="receipts.length">
                          <tr 
                            class="row" 
                            v-for="receipt in receipts" 
                            :key="receipt.id"
                            @click="openReceiptDeleteModal(receipt)"
                          >
                            <td class="col-5 background-white" @click="openReceiptDeleteModal(receipt)">
                              @{{ formatViewDate(receipt.receipt_date) }}
                            </td>
                            <td class="col-4 background-white">
                              @{{ receipt.payment_method }}
                            </td>
                            <td class="col-3 background-white">
                              @{{ displayMoney(receipt.amount) }}
                            </td>
                          </tr>
                        </template>
                        <template v-else>
                          <tr class="row col-12">
                            <td class="col-5 background-white">
                              &nbsp;
                            </td>
                            <td class="col-4 background-white">
                              &nbsp;
                            </td>
                            <td class="col-3 background-white">
                              &nbsp;
                            </td>
                          </tr>
                          <tr class="row col-12">
                            <td class="col-5 background-white">
                              &nbsp;
                            </td>
                            <td class="col-4 background-white">
                              &nbsp;
                            </td>
                            <td class="col-3 background-white">
                              &nbsp;
                            </td>
                          </tr>
                          <tr class="row col-12">
                            <td class="col-5 background-white">
                              &nbsp;
                            </td>
                            <td class="col-4 background-white">
                              &nbsp;
                            </td>
                            <td class="col-3 background-white">
                              &nbsp;
                            </td>
                          </tr>
                        </template>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12 pt-1">
                  <div class="row">
                    <table class="table mx-4">
                      <tbody>
                        <tr class="row col-12">
                          <td class="col-5">&nbsp;</td>
                          <td class="col-4">Total Received</td>
                          <td class="col-2 text-right">@{{ displayMoney(totalReceipts) }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12 pt-3">
                  <span class="background-black">
                    Expenses
                  </span>
                </div>
                <div class="col-12 pt-2">
                  <div class="row">
                    <table class="table mx-2">
                      <tbody>
                        <tr class="row col-12">
                          <td class="col-5">Date</td>
                          <td class="col-4">Name</td>
                          <td class="col-3 text-right">Amount</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row table-wrap" style="max-height: 112px;overflow-y: auto;">
                    <table class="table mx-2">
                      <tbody>
                      <template v-if="expenses.length">
                        <tr class="row" v-for="expense in expenses">
                          <td class="col-5 background-white">
                            @{{ formatViewDate(expense.debit_date) }}
                          </td>
                          <td class="col-4 background-white">
                            @{{ expense.payee }}
                          </td>
                          <td class="col-3 background-white">
                            @{{ displayMoney(expense.net_amount) }}
                          </td>
                        </tr>
                      </template>
                      <template v-else>
                        <tr class="row col-12">
                          <td class="col-5 background-white">
                            &nbsp;
                          </td>
                          <td class="col-4 background-white">
                            &nbsp;
                          </td>
                          <td class="col-3 background-white">
                            &nbsp;
                          </td>
                        </tr>
                        <tr class="row col-12">
                          <td class="col-5 background-white">
                            &nbsp;
                          </td>
                          <td class="col-4 background-white">
                            &nbsp;
                          </td>
                          <td class="col-3 background-white">
                            &nbsp;
                          </td>
                        </tr>
                        <tr class="row col-12">
                          <td class="col-5 background-white">
                            &nbsp;
                          </td>
                          <td class="col-4 background-white">
                            &nbsp;
                          </td>
                          <td class="col-3 background-white">
                            &nbsp;
                          </td>
                        </tr>
                      </template>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12 pt-1">
                  <div class="row">
                    <table class="table mx-4">
                      <tbody>
                        <tr class="row col-12">
                          <td class="col-5">&nbsp;</td>
                          <td class="col-4">Total Debts:</td>
                          <td class="col-2 text-right">@{{ displayMoney(totalExpenses) }}</td>
                        </tr>
                        <tr class="row col-12">
                          <td class="col-5">&nbsp;</td>
                          <td class="col-4">Credit Taken up:</td>
                          <td class="col-2 text-right">$00.0</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12 row pt-3 d-flex align-items-center justify-content-between">
                  <span class="background-black">
                      Billed Retention
                    </span>
                  <input v-if="isEditMode" type="text" class="col-4 text-right" v-model="model.retention_amount">
                  <input v-else type="text" class="col-4 text-right" :value="displayMoney(model.retention_amount)" disabled>
                </div>
                <div class="col-12 row pt-2 d-flex align-items-center justify-content-end">
                  <span class="col-3 h5 text-right">Release Date: </span>
                  <input 
                    v-if="isEditMode"
                    type="date" 
                    class="col-4" 
                    v-model="model.retention_release_date"
                  >
                  <input 
                    v-else
                    type="text" 
                    class="col-4" 
                    :value="formatViewDate(model.retention_release_date)" 
                    disabled
                  >
                </div>
                <div class="col-12 row pt-3 d-flex align-items-center">
                  <span class="h6 col-3">Notes:</span>
                  <span class="h6 col-5 text-right">Invoice Balance Due:</span>
                  <input type="text" class="col-4 text-right text-danger" :value="displayMoney(model.balance_due)" disabled>
                </div>
                <textarea class="col-12 mt-3" cols="10" rows="1" v-model="model.notes"></textarea>
              </div>
            </portlet-content>
          </div>
        </div>
      </div>
    </div>

    <update-bill
            v-if="mountUpdateBill"
            @invoice-expense="openModal('InvoiceExpense')"
            @retention="openModal('Retention')"
            @close="closeModal('UpdateBill')"
    ></update-bill>
    <retention
            v-if="mountRetention"
            @close="closeModal('Retention')"
            :job-invoice-number="jobInvoiceId"
            :invoice="invoice"
            :client-name="clientName"
            @updated="fetchCurrentInvoice"
    ></retention>
    <invoice-expense
            v-if="mountInvoiceExpense"
            :job-invoice-number="jobInvoiceId"
            :invoice-id="invoice.id"
            :client-name="clientName"
            :site-id="job.site_id"
            @close="closeModal('InvoiceExpense')"
            @updated="fetchCurrentInvoice"
    ></invoice-expense>
    <search-billing
            v-if="mountSearchBilling"
            :invoice-id="invoice.id"
            :site-id="job.site_id"
            @close="closeModal('SearchBilling')"
            @updated="fetchInvoiceDetail"
    ></search-billing>
    <template v-if="mountDeleteReceipt">
      <delete-receipt
        :receipt="selectedReceiptForDelete"
        :invoice-no="jobInvoiceId"
        :client-name="clientName"
        @deleted="receiptDeleted"
        @close="closeModal('DeleteReceipt')"
      />
    </template>
  </template>
</div>
