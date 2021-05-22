<div class="row">
  <span class="text-warning h3">@{{ model.trading_name }}</span>
  <div class="col-12 pt-3">
    <div class="row">
      <portlet-content :height="800" :onlybody="true" class="col-12 px-2">
        <div slot="body">
          <div class="col-12">
            <div class="row table-wrap px-2">
              <table class="table">
                <tbody>
                  <tr class="row col-12">
                    <td class="table-head col-1">Date Paid</td>
                    <td class="table-head col-1">Job</td>
                    <td class="table-head col-1">O/No</td>
                    <td class="table-head col-1">Invoice No</td>
                    <td class="table-head col-1">Invoice Date</td>
                    <td class="table-head col-1">Invoice Amt</td>
                    <td class="table-head col-1">Adjustment</td>
                    <td class="table-head col-1">Discount</td>
                    <td class="table-head col-1">GST Paid</td>
                    <td class="table-head col-1">Payment</td>
                    <td class="table-head col-1">Remittance #</td>
                    <td class="table-head col-1">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div 
              class="row table-wrap px-2" 
              style="max-height: 700px;overflow-y: scroll; scrollbar-width: none;"
            >
              <table class="table">
                <tbody>
                  <tr v-for="item in model.remittance_items" class="row col-12">
                    <td class="col-1">@{{ formatViewDate(item.remittance.transaction_date) || formatViewDate(item.remittance.cheque_date) }}</td>
                    <td class="col-1">@{{ item.job }}</td>
                    <td class="col-1">@{{ item.order_no }}</td>
                    <td class="col-1">@{{ item.supplier_reference }}</td>
                    <td class="col-1">@{{ item.invoice_date }}</td>
                    <td class="col-1 text-right">@{{ displayMoney(item.invoice_amount) }}</td>
                    <td class="col-1 text-right">@{{ displayMoney(item.adjustment) }}</td>
                    <td class="col-1 text-right">@{{ displayMoney(item.discount) }}</td>
                    <td class="col-1 text-right">@{{ displayMoney(item.gst) }}</td>
                    <td class="col-1 text-right">@{{ displayMoney(item.invoice_amount + item.adjustment) }}</td>
                    <td class="col-1">@{{ item.remittance.payment_type === 1 ? 'E' + item.remittance.id : item.remittance.cheque_number }}</td>
                    <td class="col-1">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row table-wrap px-2">
              <table class="table">
                <tbody>
                  <tr class="row col-12">
                    <td class="table-head col-5">&nbsp;</td>
                    <td class="table-head col-1 text-primary text-right">@{{ displayMoney(getRemittanceItemsTotal('invoice_amount')) }}</td>
                    <td class="table-head col-2">&nbsp;</td>
                    <td class="table-head col-1 text-primary text-right">@{{ displayMoney(getRemittanceItemsTotal('gst')) }}</td>
                    <td class="table-head col-1 text-primary text-right">@{{ displayMoney(getTotalPayment()) }}</td>
                    <td class="table-head col-2">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </portlet-content>
    </div>
  </div>
</div>
