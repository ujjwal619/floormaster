
<div class="row">
  <div class="col-12 pt-1">
    <div class="row">
      <portlet-content :height="35" :onlybody="true" class="col-lg-12 px-2">
        <div slot="body">
          <div class="row">
            <div class="col-6">
              <div class="row">
                <label class="col-lg-2 ml-2">Name:</label>
                <input class="col-lg-8 form-control" disabled type="text" :value="model.name">
              </div>
            </div>
            <div class="col-6">
              <div class="row">
                <label class="col-lg-2 pull-right">TFN:</label>
                <input class="col-lg-8 form-control" disabled type="text" :value="model.tfn">
              </div>
            </div>
          </div>
        </div>
      </portlet-content>
    </div>
    <div class="row">
      <portlet-content :height="500" :onlybody="true" class="col-12 px-2">
        <div slot="body">
          <div class="col-12">
            <div class="row table-wrap px-2">
              <table class="table">
                <tbody>
                  <tr class="row col-12">
                    <td class="table-head col-1">Date</td>
                    <td class="table-head col-1">Job</td>
                    <td class="table-head col-3">Client Name</td>
                    <td class="table-head col-4">&nbsp;</td>
                    <td class="table-head col-1">Remittance #</td>
                    <td class="table-head col-1">GST</td>
                    <td class="table-head col-1">Gross</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div 
                class="row table-wrap px-2 fms-data-table" 
                style="max-height: 440px; overflow-y: scroll; scrollbar-width: none;"
              >
                <table class="table">
                  <tbody>
                    <tr v-for="item in model.remittance_items" class="row col-12">
                      <td class="col-1">@{{ formatViewDate(item.remittance.transaction_date) || formatViewDate(item.remittance.cheque_date) }}</td>
                      <td class="col-1">@{{ item.supplier_reference }}</td>
                      <td class="col-3">@{{ item.comments }}</td>
                      <td class="col-4">&nbsp;</td>
                      <td class="col-1">@{{ item.remittance.payment_type === 1 ? 'E' + item.remittance.id : item.remittance.cheque_number }}</td>
                      <td class="col-1 text-right">@{{ displayMoney(item.gst) }}</td>
                      <td class="col-1 text-right">@{{ displayMoney(item.invoice_amount) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            <div class="row table-wrap px-2">
              <table class="table">
                <tbody>
                  <tr class="row col-12">
                    <td class="table-head col-11">&nbsp;</td>
                    <td class="table-head col-1 text-primary">@{{ displayMoney(getRemittanceItemsTotal('invoice_amount')) }}</td>
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
