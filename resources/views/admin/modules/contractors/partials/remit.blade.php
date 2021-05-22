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
      <div slot="body" class="p-2">
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
            @{{ remit.transaction_date || remit.cheque_date }}
          </label>
        </div>
        <div class="row pt-3">
          <label class="text-primary">
            @{{ remit.payment_type === 1 ? 'EFT' : 'Cheque' }}
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
                <tr class="row col-12" v-for="item in remit.items">
                  <td class="col-1">
                    <button class="btn action-buttons w-100 text-danger" @click="changeItemStatus(item.id)">
                      @{{ remit.default_item_status === $options.PAY ? 'PAY' : 'HOLD' }}
                    </button>
                  </td>
                  <td class="col-1">@{{ item.order_no }}</td>
                  <td class="col-1">@{{ item.supplier_reference }}</td>
                  <td class="col-1">$@{{ item.invoice_amount }}</td>
                  <td class="col-1">$@{{ item.adjustment }}</td>
                  <td class="col-1">@{{ item.discount }}</td>
                  <td class="col-1">$@{{ item.gst }}</td>
                  <td class="col-4">@{{ item.comments }}</td>
                  <td class="col-1">$@{{ item.gross_payment }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row table-wrap px-2">
            <table class="table">
              <tbody>
                <tr class="row col-12">
                  <td class="table-head col-3">&nbsp;</td>
                  <td class="table-head col-1">$@{{ getTotal('invoice_amount') }}</td>
                  <td class="table-head col-1">$@{{ getTotal('adjustment') }}</td>
                  <td class="table-head col-1">$@{{ getTotal('discount') }}</td>
                  <td class="table-head col-1">$@{{ getTotal('gst') }}</td>
                  <td class="table-head col-4 text-right">@{{ remit.remittance_type === 1 ? 'EFT' : 'CHEQUE' }}</td>
                  <td class="table-head col-1">$@{{ getTotal('gross_payment') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </portlet-content>
  </div>
</div>
