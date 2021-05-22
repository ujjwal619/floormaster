<div class="row">
  <div class="col-6">
    <portlet-content :height="737" :onlybody="true" class="col-12">
      <div slot="body" class="row">
        <div class="d-flex align-items-center ml-1 mr-1" style="border: 1px solid white; height: 56px;">
          <span class="col-2 background-black h6 ml-1">Payment Schedule</span>
          <div class="col-6 row pl-1">
            <span class="col-12 text-center"><small class="job-small-text">(leave fields blank, unless schedule agreed)</small></span>
            <span class="col-3 h6 text-right pl-2"><small class="job-small-text">Next Payment:</small></span>
            <input type="text" class="col-3 form-control">
            <span class="col-2 h6 text-right"><small class="job-small-text">Due on:</small></span>
            <input type="date" class="col-4 form-control">
          </div>
          <span class="col-4 pl-4"> 
            <small class="job-small-text">Use the Payment Schedule to record promised payment dates and Lay-Buys.</small> 
          </span>
        </div>
        <div class="col-12 mt-3">
          <span class="background-black ml-2">
            Non-Allocated Money Held in Trust
          </span>
          <span><small>(Receipts Not Allocated to an Invoice)</small></span>
        </div>
        <div class="col-12 mt-1">
          <div class="row table-wrap pl-5 pr-2" style="max-height: 60px; overflow-y: auto;">
            <table class="table mx-2">
              <tbody>
                <template v-if="nonAllocatedReceipts.length">
                  <tr 
                    class="row col-12" 
                    v-for="receipt in nonAllocatedReceipts"
                    @click="openDeleteReceiptModal(receipt)"
                  >
                    <td class="col-3 text-primary text-center">
                      @{{ formatViewDate(receipt.receipt_date) }}
                    </td>
                    <td class="col-3 text-primary text-center">
                      @{{ receipt.payment_method }}
                    </td>
                    <td class="col-3 text-primary text-center">
                      @{{ receipt.notation }}
                    </td>
                    <td class="col-3 text-danger text-right">
                      @{{ displayMoney(receipt.amount) }}
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr class="row col-12">
                    <td class="col-3 text-primary text-center">
                      &nbsp;
                    </td>
                    <td class="col-3 text-primary text-center">
                      &nbsp;
                    </td>
                    <td class="col-3 text-primary text-center">
                      &nbsp;
                    </td>
                    <td class="col-3 text-danger text-right">
                      &nbsp;
                    </td>
                  </tr>
                  <tr class="row col-12">
                    <td class="col-3 text-primary text-center">
                      &nbsp;
                    </td>
                    <td class="col-3 text-primary text-center">
                      &nbsp;
                    </td>
                    <td class="col-3 text-primary text-center">
                      &nbsp;
                    </td>
                    <td class="col-3 text-danger text-right">
                      &nbsp;
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-12 pt-3">
          <div class="row">
            <div class="col-9">
              &nbsp;
            </div>
            <div class="table-wrap col-3 pl-1 pr-2 text-right" style="margin-left: -11px;">
              <table class="table">
                <tbody>
                <tr class="col-12">
                  <td class="text-right text-danger" style="padding-right: 5px !important;">
                    @{{ displayMoney(nonAllocatedReceiptsSum) }}
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="invoice-receipts__block col-12" style="overflow-x: hidden;">
          <template v-if="invoices.length">
            <template v-for="invoice in invoices">
              <div @click="redirectToBilling(invoice)">
                <div class="row">
                  <span class="col-2"></span>
                  <div class="col-10">
                    <div class="row">
                      <span class="col-3"><small><center>Date</center></small></span>
                      <span class="col-3"><small><center>Invoice No</center></small></span>
                      <span class="col-3"><small><center>Type</center></small></span>
                      <span class="col-3"><small><center>Inv. Amount</center></small></span>
                    </div>
                  </div>
                </div>
                <div class="row pt-2">
                  <div class="col-2 d-inline-flex align-items-center justify-content-center">
                    <span class="background-black">
                      Invoice
                    </span>
                  </div>
                  <div class="col-10 table-wrap" style="padding-right: 10px !important; padding-left: 0px !important;">
                    <table class="table">
                      <tbody>
                      <tr class="row col-12">
                          <td class="col-3 px-0">
                            <input 
                              type="text" 
                              class="form-control text-center" 
                              :value="formatViewDate(invoice.date)"
                              readonly
                            >
                          </td>
                          <td class="col-3 px-0">
                            <input 
                              type="text" 
                              class="form-control text-center"
                              :value="`${job.site.quote_prefix}${job.job_id}/${invoice.id}`" 
                              readonly
                            >
                          </td>
                          <td class="col-3 px-0">
                            <input 
                              type="text" 
                              class="form-control text-center" 
                              :value="invoice.amount > 0 ? 'Tax Invoice' : 'Tax Credit' "
                              readonly
                            >
                          </td>
                          <td class="col-3 px-0">
                            <input 
                              type="text" 
                              class="form-control text-right" 
                              :value="displayMoney(invoice.amount)"
                              readonly
                            >
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12 row pt-2" style="margin-top: -31px !important;">
                  <div class="col-2 d-inline-flex align-items-center justify-content-center">
                    <span class="background-black">
                      Receipts
                    </span>
                  </div>
                  <div class="col-10 table-wrap portlet-table mt-3" style="max-height: 150px;overflow-y: auto; scrollbar-width: none; overflow-x: hidden;">
                    <table class="row table mx-2">
                      <tbody class="col-12">
                      <tr class="row px-3" style="margin: -17px !important;">
                        <th class="col-3 text-primary text-center">
                          <small>Date</small>
                        </th>
                        <th class="col-3 text-primary text-center">
                          <small>Reference</small>
                        </th>
                        <th class="col-3 text-primary text-center">
                          <small>Type</small>
                        </th>
                        <th class="col-3 text-primary text-right">
                          <small>Payment</small>
                        </th>
                      </tr>
                      <tr class="row" v-for="receipt in invoice.receipts">
                        <td class="col-3 px-0">
                          <input 
                            type="text" 
                            class="form-control text-primary text-center" 
                            :value="formatViewDate(receipt.receipt_date)"
                            readonly
                          >
                        </td>
                        <td class="col-3 px-0">
                          <input 
                            type="text" 
                            class="form-control text-primary text-center" 
                            :value="receipt.notation"
                            readonly
                          >
                        </td>
                        <td class="col-3 px-0">
                          <input 
                            type="text" 
                            class="form-control text-primary text-center" 
                            :value="receipt.payment_method"
                            readonly
                          >
                        </td>
                        <td class="col-3 px-0">
                          <input 
                            type="text" 
                            class="form-control text-primary text-right"
                            :value="displayMoney(receipt.amount)"
                            readonly>
                        </td>
                      </tr>
                      <tr class="row" v-if="invoice.receipts.length < 3">
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-center" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-center" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-center" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-right" class="text-right"
                            readonly>
                        </td>
                      </tr>
                      <tr class="row" v-if="invoice.receipts.length < 2">
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-center" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-center" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-center" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-right" class="text-right"
                            readonly>
                        </td>
                      </tr>
                      <tr class="row" v-if="invoice.receipts.length < 1">
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-center" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-center" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-center" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-primary text-right" class="text-right"
                            readonly>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  <span class="col-2"></span>
                  <div class="col-10 px-4">
                    <table class="table">
                      <tbody>
                      <tr class="row col-12" style="margin: -15px !important;">
                        <td class="col-9 text-right text-danger"><small>Invoice Balance Due:</small></td>
                        <td class="col-3 text-right"><small>@{{ displayMoney(invoiceBalanceDue(invoice)) }}</small></td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- <div class="col-12 row" @click="redirectToBilling(invoice)">
                <span class="col-2"></span>
                <div class="col-10">
                  <table class="table mx-6">
                    <tbody>
                    <tr class="row col-12">
                      <td class="col-3 text-center"><small><center>Date</center></small></td>
                      <td class="col-3 text-center"><small><center>Invoice No</center></small></td>
                      <td class="col-3 text-center"><small><center>Type</center></small></td>
                      <td class="col-3 text-right"><small><center>Inv. Amount</center></small></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-2 d-inline-flex align-items-center justify-content-center">
                <span class="background-black">
                  Invoice
                </span>
                </div>
                <div class="col-10 table-wrap" @click="redirectToBilling(invoice)">
                  <table class="row table mx-2">
                    <tbody @click="redirectToBilling(invoice)">
                    <template>
                      <tr class="row col-12">
                        <td class="col-3 px-0">
                          <input 
                            @click="redirectToBilling(invoice)" 
                            type="text" 
                            class="form-control text-center" 
                            :value="formatViewDate(invoice.date)"
                            readonly
                          >
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-center" :value="`${job.site.quote_prefix}${job.job_id}/${invoice.id}`" readonly>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-center" :value="invoice.amount > 0 ? 'Tax Invoice' : 'Tax Credit' "
                                disabled>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-right" :value="'$' + invoice.amount.toFixed(2)" disabled>
                        </td>
                      </tr>
                    </template>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-12 row pt-2" style="margin-top: -31px !important;" @click="redirectToBilling(invoice)">
                <div class="col-2 d-inline-flex align-items-center">
                <span class="background-black">
                  Receipts
                </span>
                </div>
                <div class="col-10 table-wrap portlet-table mt-3" style="max-height: 150px;overflow-y: auto;">
                  <table class="row table mx-2">
                    <tbody class="col-12">
                    <tr class="row px-3" style="margin: -17px !important;">
                      <th class="col-3 text-primary text-center">
                        <small>Date</small>
                      </th>
                      <th class="col-3 text-primary text-center">
                        <small>Reference</small>
                      </th>
                      <th class="col-3 text-primary text-center">
                        <small>Type</small>
                      </th>
                      <th class="col-3 text-primary text-right">
                        <small>Payment</small>
                      </th>
                    </tr>
                    <tr class="row" v-for="receipt in invoice.receipts">
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" :value="formatViewDate(receipt.receipt_date)"
                              disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" :value="receipt.notation"
                              disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" :value="receipt.payment_method" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-right" class="text-right"
                              :value="'$' + receipt.amount.toFixed(2)" disabled>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <span class="col-2"></span>
                <div class="col-10 px-4">
                  <table class="table">
                    <tbody>
                    <tr class="row col-12" style="margin: -15px !important;">
                      <td class="col-9 text-right text-danger"><small>Invoice Balance Due:</small></td>
                      <td class="col-3 text-right"><small>$@{{ invoiceBalanceDue(invoice) }}</small></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div> -->
            </template>
          </template>
          <template v-else>
            <div>
              <div class="row">
                <span class="col-2"></span>
                <div class="col-10">
                  <div class="row">
                    <span class="col-3"><small><center>Date</center></small></span>
                    <span class="col-3"><small><center>Invoice No</center></small></span>
                    <span class="col-3"><small><center>Type</center></small></span>
                    <span class="col-3"><small><center>Inv. Amount</center></small></span>
                  </div>
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-2 d-inline-flex align-items-center justify-content-center">
                  <span class="background-black">
                    Invoice
                  </span>
                </div>
                <div class="col-10 table-wrap" style="padding-right: 10px !important; padding-left: 0px !important;">
                  <table class="table">
                    <tbody>
                    <tr class="row col-12">
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-center" disabled>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-center" disabled>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-center" disabled>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-right" disabled>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-12 row pt-2" style="margin-top: -31px !important;">
                <div class="col-2 d-inline-flex align-items-center justify-content-center">
                  <span class="background-black">
                    Receipts
                  </span>
                </div>
                <div class="col-10 table-wrap portlet-table mt-3" style="max-height: 150px;overflow-y: auto; scrollbar-width: none; overflow-x: hidden;">
                  <table class="row table mx-2">
                    <tbody class="col-12">
                    <tr class="row px-3" style="margin: -17px !important;">
                      <th class="col-3 text-primary text-center">
                        <small>Date</small>
                      </th>
                      <th class="col-3 text-primary text-center">
                        <small>Reference</small>
                      </th>
                      <th class="col-3 text-primary text-center">
                        <small>Type</small>
                      </th>
                      <th class="col-3 text-primary text-right">
                        <small>Payment</small>
                      </th>
                    </tr>
                    <tr class="row">
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-right" class="text-right"
                          disabled>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-right" class="text-right"
                          disabled>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-right" class="text-right"
                          disabled>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <span class="col-2"></span>
                <div class="col-10 px-4">
                  <table class="table">
                    <tbody>
                    <tr class="row col-12" style="margin: -15px !important;">
                      <td class="col-9 text-right text-danger"><small>Invoice Balance Due:</small></td>
                      <td class="col-3 text-right"><small>&nbsp;</small></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="row">
                <span class="col-2"></span>
                <div class="col-10">
                  <div class="row">
                    <span class="col-3"><small><center>Date</center></small></span>
                    <span class="col-3"><small><center>Invoice No</center></small></span>
                    <span class="col-3"><small><center>Type</center></small></span>
                    <span class="col-3"><small><center>Inv. Amount</center></small></span>
                  </div>
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-2 d-inline-flex align-items-center justify-content-center">
                  <span class="background-black">
                    Invoice
                  </span>
                </div>
                <div class="col-10 table-wrap" style='padding-right: 10px !important; padding-left: 0px !important;'>
                  <table class="table">
                    <tbody>
                    <tr class="row col-12">
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-center" disabled>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-center" disabled>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-center" disabled>
                        </td>
                        <td class="col-3 px-0">
                          <input type="text" class="form-control text-right" disabled>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-12 row pt-2" style="margin-top: -31px !important;">
                <div class="col-2 d-inline-flex align-items-center justify-content-center">
                  <span class="background-black">
                    Receipts
                  </span>
                </div>
                <div class="col-10 table-wrap portlet-table mt-3" style="max-height: 150px;overflow-y: auto; scrollbar-width: none; overflow-x: hidden;">
                  <table class="row table mx-2">
                    <tbody class="col-12">
                    <tr class="row px-3" style="margin: -17px !important;">
                      <th class="col-3 text-primary text-center">
                        <small>Date</small>
                      </th>
                      <th class="col-3 text-primary text-center">
                        <small>Reference</small>
                      </th>
                      <th class="col-3 text-primary text-center">
                        <small>Type</small>
                      </th>
                      <th class="col-3 text-primary text-right">
                        <small>Payment</small>
                      </th>
                    </tr>
                    <tr class="row">
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-right" class="text-right"
                          disabled>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-right" class="text-right"
                          disabled>
                      </td>
                    </tr>
                    <tr class="row">
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-center" disabled>
                      </td>
                      <td class="col-3 px-0">
                        <input type="text" class="form-control text-primary text-right" class="text-right"
                          disabled>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <span class="col-2"></span>
                <div class="col-10 px-4">
                  <table class="table">
                    <tbody>
                    <tr class="row col-12" style="margin: -15px !important;">
                      <td class="col-9 text-right text-danger"><small>Invoice Balance Due:</small></td>
                      <td class="col-3 text-right"><small>&nbsp;</small></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </template>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-10">
              <div class="table-wrap portlet-table mx-auto">
                <table class="table mx-2">
                  <tbody>
                  <tr class="row px-3">
                    <th style="width: 20%;">
                      Quoted
                    </th>
                    <th style="width: 20%;">
                      Billed
                    </th>
                    <th style="width: 20%;">
                      Retention
                    </th>
                    <th style="width: 20%;">
                      Receipts
                    </th>
                    <th style="width: 20%;">
                      Balance Due
                    </th>
                  </tr>
                  <tr class="row" style="margin-right: 30px !important; margin-left: -13px !important;">
                    <td class="px-0" style="width: 20%;">
                      <input 
                        type="text" 
                        class="form-control text-primary text-right" 
                        :value="displayMoney(gstInclusiveQuote)"
                        disabled>
                    </td>
                    <td class="px-0" style="width: 20%;">
                      <input type="text" class="form-control text-right" :value="displayMoney(totalBilledInvoice)" disabled>
                    </td>
                    <td class="px-0" style="width: 20%;">
                      <input type="text" class="form-control text-right" :value="displayMoney(retentionTotal)" disabled>
                    </td>
                    <td class="px-0" style="width: 20%;">
                      <input type="text" class="form-control text-primary text-right" :value="displayMoney(receiptsTotal)" disabled>
                    </td>
                    <td class="px-0" style="width: 20%;">
                      <input type="text" class="form-control text-danger text-right" :value="displayMoney(balanceDueTotal)" disabled>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </portlet-content>
  </div>
  <div class="col-6 table-wrap">
    <portlet-content :height="120" header="Bookings" subheader="">
      <template slot="action_button">
        <button class="btn btn-primary" @click="showAddBookingModal">Add New</button>
      </template>
      <template slot="body">
        <div class="col-xsmall-12" style="max-height: 80px;overflow-y: scroll;">
          <table class="table table-bordered">
            <tbody>
            <tr>
              <td>Date</td>
              <td>Type</td>
              <td>For</td>
            </tr>
              <tr v-for="booking in bookings" :key="booking.id">
                <td @click="redirectToBooking(booking)">@{{ formatViewDate(booking.booking_date) }}</td>
                <td>@{{ booking.booking_type }}</td>
                <td width="20%">@{{ booking.booking_for }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>
    </portlet-content>

    <portlet-content :height="120" header="Installation Complaints" subheader="">
      <template slot="action_button">
        <button class="btn btn-primary" @click="addComplaint">Add New</button>
      </template>
      <template slot="body">
        <div class="col-xsmall-12" style="max-height: 80px;overflow-y: scroll;">
          <table class="table table-bordered">
            <tbody>
            <tr>
              <td>Date Received</td>
              <td>Date Rectified</td>
              <td>Complaint</td>
            </tr>
            <tr v-for="complaint in complaints">
              <td @click="redirectToInstallationComplaint(complaint)">@{{ formatViewDate(complaint.date_received) }}</a></td>
              <td>@{{ formatViewDate(complaint.date_rectified) }}</td>
              <td width="20%">@{{ complaint.complaint }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </template>
    </portlet-content>

    <portlet-content :onlybody="true" :height="85">
      <template slot="body">
        <div class="col-xsmall-12">
          <div class="row pb-3">
            <div class="col-4">
              <div class="row">
                <label class="col-3">Paid</label>
                <input 
                  type="number" 
                  class="form-control col-8" 
                  v-model="values.job.costed_commission_paid"
                >
              </div>
            </div>
            <div class="col-5">
              <div class="row">
              <label class="col-3">Date Paid</label>
              <input 
                type="date" 
                class="form-control col-8" 
                v-model="values.job.costed_commission_date_paid"
              >
              </div>
              <div class="row">
                <label class="col-3">Balance</label>
                <input 
                  type="text" 
                  class="form-control col-8" 
                  :value="displayMoney(values.job.costed_commission_balance)"
                >
              </div>
            </div>
            <div class="col-3">
              <label style="background: black; color: white;" class="text-center">Costed Commission</label>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input 
                type="text" 
                class="form-control" 
                v-model="values.job.costed_commission_text"
              >
            </div>
          </div>
        </div>
      </template>
    </portlet-content>

    <portlet-content header="Memos" subheader="">
      <template slot="action_button">
        <button class="btn btn-primary" @click="mountAddMemo=true">Add New</button>
      </template>
      <template slot="body">
        <div class="col-xsmall-12" style="max-height: 120px;overflow-y: scroll;">
          <table class="table table-bordered">
            <tbody>
            <tr>
              <td>Subject</td>
              <td>Date</td>
              <td>Staff</td>
              <td>Description</td>
            </tr>
            <tr v-for="memo in memos" @click="editMemoModal(memo)">
              <td>@{{ memo.subject }}</a></td>
              <td>@{{ formatViewDate(memo.date) }}</td>
              <td>@{{ memo.user.username }}</td>
              <td>@{{ memo.details }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </template>
    </portlet-content>

    <div class="row pb-3 pr-1">
      <div class="col-8">
        <portlet-content :onlybody="true" :height="130">
          <template slot="body">
            <div class="row">
              <div class="col-4">
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                <div class="row">
                  <span class="col-9"></span>
                  <input type="text" class="col-3 form-control float-right" v-model="values.job.completed_percent">
                </div>
              </div>
              <div class="col-7">
                <div class="row">
                  <label class="col-5 text-right">Quote Date</label>
                  <input type="date" class="col-7 form-control" v-model="values.job.quote_date">
                </div>
                <div class="row">
                  <label class="col-5 text-right">Date Job Initiated</label>
                  <input type="date" class="col-7 form-control" v-model="values.job.initiation_date">
                </div>
                <div class="row">
                  <label class="col-5 text-right">% Completed on</label>
                  <input type="date" class="col-7 form-control" v-model="values.job.completed_on">
                </div>
              </div>
              <div class="col-1">
              </div>
            </div>
            <div class="row pt-3">
              <div class="col-5">
                <div class="row">
                  <span class="col-5"></span>
                  <input type="checkbox" class="col-1 form-control" style="margin-top: -1px;" v-model="values.job.financed">
                  <h6 class="col-4" style="font-weight: bolder">Financed</h6>
                </div>
                <div class="row pt-1">
                  <label class="col-12 text-right">Approval Code:</label>
                </div>
              </div>
              <div class="col-6">
                <div class="row">
                  <label class="col-4 text-right">Approved</label>
                  <input type="date" class="col-8 form-control" v-model="values.job.approved_date">
                </div>
                <div class="row pt-1">
                  <span class="col-1"></span>
                  <input type="text" class="col-11 form-control" v-model="values.job.approval_code">
                </div>
              </div>
              <div class="col-1">
              </div>
            </div>
          </template>
        </portlet-content>

        <portlet-content :onlybody="true" :height="80">
          <template slot="body">
            <div class="col-xsmall-12">
              <div class="row pb-3">
                <div class="col-3">
                  <label style="background: black; color: white;" class="text-center">Unbilled Retention</label>
                </div>
                <div class="col-6">
                  <input type="text" class="form-control" disabled :value="displayMoney(values.job.unbilled_retention_amount)">
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <label>Release Date: </label>
                </div>
                <div class="col-6">
                  <input type="text" class="form-control" disabled :value="formatViewDate(values.job.unbilled_retention_release_date)">
                </div>
              </div>
            </div>
          </template>
        </portlet-content>
      </div>
      <div class="col-4">
        <portlet-content :onlybody="true" :height="212">
            <template slot="body">
              <div class="background-grey" style="padding-bottom: 80px">
                <h2 class="text-center">
                  <span>@{{ site.quote_prefix + '' + values.job.job_id }}</span><br>
                </h2>
                <h4 class="text-center">
                  <span>@{{ values.customerDetails.trading_name }}</span>
                </h4>
                <br/>
                <h6 class="text-center">
                  <span>Re: @{{ values.job.project }}</span>
                </h6>
              </div>
            </template>
        </portlet-content>
      </div>
    </div>
  </div>
</div>
