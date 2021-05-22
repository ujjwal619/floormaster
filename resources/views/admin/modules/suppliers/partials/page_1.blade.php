<div class="row">
  <div class="col-6 row" v-if="!isOldEntry">
    <span class="col-lg-2 text-right h4">Store:</span>
    <drop-down
        v-show="!isOldEntry"
        class="col-6"
        :options="sites"
        v-model="model.site_id"
        style="max-height: 40px;"
    />
  </div>
  <div class="d-flex justify-content-end" :class="[ isOldEntry ? 'col-12' : 'col-6' ]" v-if="isOldEntry">
    <span class="text-warning h3" style="margin-bottom: -2px; margin-top: -9px; margin-right: 15px;" >Supplier No: @{{ model.id }}</span>
  </div>
  <div class="col-7 row">
    <div class="col-12">
      <div class="row">
        <portlet-content :height="250" header="Account Details" class="col-12 px-2">
          <div slot="body" class="form-group p-2">
            <div class="row pb-2" v-if="isOldEntry">
              <label class="col-lg-2 text-right">Store:</label>
              <label class="col-lg-8 font-weight-bold">@{{ model.site.name }}</label>
            </div>
            <div class="row pb-2">
              <label class="col-lg-2 text-right">Name:</label>
              <input 
                :disabled="!isEditMode" 
                v-model="model.trading_name" 
                class="col-lg-8 form-control" 
                type="text"
              >
            </div>
            <div class="row pb-2">
                <label class="col-lg-2 text-right">Street:</label>
                <input :disabled="!isEditMode" v-model="model.street" class="col-lg-8 form-control" type="text">
            </div>
            <div class="row pb-2">
                <label class="col-lg-2 text-right">Suburb:</label>
                <input :disabled="!isEditMode" v-model="model.suburb" class="col-lg-6 form-control" type="text" @focus="openModal('StateModal')">
            </div>
            <div class="row pb-2">
                <label class="col-lg-2 text-right">State/Code:</label>
                <input :disabled="!isEditMode" :value="model.state" class="col-lg-2 form-control text-uppercase" type="text" @focus="openModal('StateModal')">
                <input :disabled="!isEditMode" v-model="model.code" class="col-lg-2 form-control" type="number">
            </div>
            <div class="row pb-2">
                <label class="col-lg-2 text-right">Fax:</label>
                <input :disabled="!isEditMode" v-model="model.fax" class="col-lg-3 form-control" type="number">
                <label class="col-lg-1 text-right">ABN:</label>
                <input :disabled="!isEditMode" v-model="model.abn" class="col-lg-2 form-control" type="text">
            </div>
            <div class="row pb-2">
              <label class="col-lg-2 text-right">Contact:</label>
              <input 
                :disabled="!isEditMode" 
                v-model="model.contact" 
                class="col-lg-3 form-control" 
                type="text"
                step=0
              >
              <label class="col-lg-1 text-right">Phone No:</label>
              <input :disabled="!isEditMode" v-model="model.key_no" class="col-lg-2 form-control" type="number">
            </div>
            <div class="row pb-2">
              <label class="col-lg-2 text-right">Email:</label>
              <input :disabled="!isEditMode" v-model="model.email" class="col-lg-6 form-control" type="email">
            </div>
          </div>
        </portlet-content>
        <portlet-content :height="120"  header="Sales Details" class="col-12 px-2">
          <div slot="body" class="form-group p-2">
            <div class="row pb-2">
              <label class="col-lg-2 text-right">Phone:</label>
              <input :disabled="!isEditMode" v-model="model.sales_detail.phone" class="col-lg-4 form-control" type="text">
              <label class="col-lg-2 text-right">QuickDial:</label>
              <input :disabled="!isEditMode" v-model="model.sales_detail.quick_dial" class="col-lg-2 form-control" type="number">
            </div>
            <div class="row pb-2">
                <label class="col-lg-2 text-right">Fax:</label>
                <input :disabled="!isEditMode" v-model="model.sales_detail.fax" class="col-lg-6 form-control" type="text">
            </div>
            <div class="row pb-2">
                <label class="col-lg-2 text-right">Contact:</label>
                <input :disabled="!isEditMode" v-model="model.sales_detail.contact" class="col-lg-6 form-control" type="text">
            </div>
          </div>
        </portlet-content>
        <portlet-content :height="150"  header="Trading Details" class="col-12 px-2">
          <div slot="body" class="form-group p-2">
            <div class="row pb-2">
              <label class="col-lg-2 text-right font-weight-bold">Early Discount:</label>
              <input :disabled="!isEditMode" v-model="model.early_discount.discount" class="col-lg-2 form-control text-danger" type="number">
              <label class="col-lg-3 text-right font-weight-bold">Normal Discount:</label>
              <input :disabled="!isEditMode" v-model="model.normal_discount.discount" class="col-lg-2 form-control text-danger" type="number">
            </div>
            <div class="row pb-2">
              <label class="col-lg-2 text-right">End of Month:</label>
              <input :disabled="!isEditMode" v-model="model.early_discount.end_of_month" class="col-lg-2 form-control" type="number">
              <label>Days</label>
              <label class="col-lg-3 text-right">End of Month:</label>
              <input :disabled="!isEditMode" v-model="model.normal_discount.end_of_month" class="col-lg-2 form-control" type="number">
              <label>Days</label>
            </div>
            <div class="row pb-2">
              <label class="col-lg-2 text-right">OR &nbsp;&nbsp;&nbsp;Invoice Date:</label>
              <input :disabled="!isEditMode" v-model="model.early_discount.invoice_date" class="col-lg-2 form-control" type="number">
              <label>Days</label>
              <label class="col-lg-3 text-right">OR &nbsp;&nbsp;&nbsp;Invoice Date:</label>
              <input :disabled="!isEditMode" v-model="model.normal_discount.invoice_date" class="col-lg-2 form-control" type="number">
              <label>Days</label>
            </div>
            <div class="row pb-2">
              <label class="col-lg-2 text-right">Bi-monthly:</label>
              <input :disabled="!isEditMode" v-model="model.early_discount.bi_monthly" class="col-lg-2 form-control" type="text">
              <label class="col-lg-3 text-right">Late Factor:</label>
              <input :disabled="!isEditMode" v-model="model.normal_discount.late_factor" class="col-lg-2 form-control" type="number">
              <label>Days</label>
            </div>
          </div>
        </portlet-content>
        <portlet-content :height="100"  header="Bank" class="col-12 px-2">
          <div slot="body" class="form-group p-2">
            <div class="row pb-2">
              <label class="col-lg-2 text-right">A/C Name:</label>
              <input :disabled="!isEditMode" v-model="model.bank.ac_name" class="col-lg-6 form-control" type="text">
              <label><input type="radio" v-model="model.bank.eft">EFT</label>
            </div>
            <div class="row pb-2">
              <label class="col-lg-1 text-right font-weight-bold">Bank:</label>
              <input :disabled="!isEditMode" v-model="model.bank.bank" class="col-lg-2 form-control text-danger" type="text">
              <label class="col-lg-1 text-right font-weight-bold">A/C No:</label>
              <input :disabled="!isEditMode" v-model="model.bank.ac_no" class="col-lg-2 form-control text-danger" type="number">
              <label class="col-lg-1 text-right font-weight-bold">Branch: </label>
              <input :disabled="!isEditMode" v-model="model.bank.branch" class="col-lg-2 form-control text-danger" type="text">
              <label class="col-lg-1 text-right font-weight-bold">BSB: </label>
              <input :disabled="!isEditMode" v-model="model.bank.bsb" class="col-lg-2 form-control text-danger" type="text">
            </div>
          </div>
        </portlet-content>
        <portlet-content :height="75"  header="Default Cost Account" class="col-12 px-2">
          <div slot="body" class="form-group p-2">
            <div class="row">
                <div class="col-lg-1">&nbsp;</div>
                <input disabled class="col-lg-4 form-control text-right text-bold" type="text" v-model="model.default_cost_account.name">
                <input disabled class="col-lg-2 form-control text-right text-bold" type="text" v-model="model.default_cost_account.code">
                <button 
                  :disabled="!isEditMode" 
                  type="button" 
                  class="btn action-buttons ml-2 col-lg-1"
                  @click="pickAccount('default_cost_account', 'Cost of Sales or Expense')">
                    &lt;&lt;Pick
                </button>
                <label class="error col-lg-3" v-if="isDefaultCostAccountRequired && isEditMode">The Default Cost Account is required.</label>
            </div>
          </div>
        </portlet-content>
        <portlet-content :height="75"  header="Levy Account" class="col-12 px-2">
            <div slot="body" class="form-group p-2">
              <div class="row">
                <label class="col-1 text-right">Levy%</label>
                <input 
                  :disabled="!isEditMode" 
                  type="number" 
                  class="form-control col-1" 
                  v-model="model.levy_percent"
                >
                <div class="col-lg-1">&nbsp;</div>
                <input 
                    disabled 
                    class="col-lg-5 form-control text-right text-bold" 
                    type="text" 
                    v-model="model.levy_account.name"
                  >
                  <input 
                    disabled 
                    class="col-lg-3 form-control text-right text-bold" 
                    type="text" 
                    v-model="model.levy_account.code"
                  >
                  <button :disabled="!isEditMode" type="button" class="btn action-buttons ml-2" @click="pickAccount('levy_account', 'Levy Cost of Sales or Expense')">
                      &lt;&lt;Pick
                  </button>
              </div>
              
            </div>
        </portlet-content>
        <portlet-content :height="67"  header="Baling/Delivery" class="col-12 px-2">
          <div slot="body" class="form-group p-2">
            <div class="row">
              <label class="col-2 text-right">Normal Baling/Delivery</label>
              <input :disabled="!isEditMode" type="text" class="form-control col-3" v-model="model.delivery">
            </div>
          </div>
        </portlet-content>
      </div>
    </div>
  </div>
  <div class="col-5">
    <div class="col-12">
      <div class="row">
        <portlet-content :height="595" header="Payable Summary" class="col-12 px-2">
          <div slot="body">
            <div class="col-12">
              <div class="row table-wrap px-2">
                <table class="table">
                  <tbody>
                    <tr class="row col-12">
                      <td class="table-head col-2">Invoice No</td>
                      <td class="table-head col-2">Inv. Date</td>
                      <td class="table-head col-2">Job</td>
                      <td class="table-head col-4">Customer</td>
                      <td class="table-head col-2">Amount</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div 
                class="row table-wrap px-2" 
                style="max-height: 505px;overflow-y: auto; scrollbar-width: none;"
              >
                <table class="table">
                  <tbody>
                    <template v-if="payables.length" >
                      <tr class="row col-12" v-for="payable in payables" :key="payable.id">
                        <td class="col-2" @click="goToPayable(payable)">@{{ payable.supplier_reference }}</td>
                        <td class="col-2">@{{ formatViewDate(payable.invoice_date) }}</td>
                        <td class="col-2">@{{ payable.job ? payable.job.job_id : '' }}</td>
                        <td class="col-4">@{{ payable.client }}</td>
                        <td class="col-2 text-right">@{{ displayMoney(payable.expected_amount) }}</td>
                      </tr>
                    </template>
                    <template v-else>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                    </template>
                  </tbody>
                </table>
              </div>
              <div class="row table-wrap px-2">
                <table class="table">
                  <tbody>
                    <tr class="row col-12">
                      <td class="table-head col-6">&nbsp;</td>
                      <td class="table-head col-4">All Payable:</td>
                      <td class="table-head col-2 text-right">@{{ displayMoney(totalPayables) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </portlet-content>
        <portlet-content :height="90"  header="Central Billing" class="col-12 px-2">
          <div slot="body" class="form-group p-2">
            <div class="row">
              <label>
                If you select another Supplier here, all payables will be directed to that Supplier.
                Orders are placed in the name of this Supplier.
              </label>
            </div>
            <div class="row">
                <input disabled class="col-lg-6 form-control text-right text-bold" type="text" v-model="model.central_billing.trading_name">
                <input disabled class="col-lg-3 form-control text-right text-bold" type="text" v-model="model.central_billing.id">
                <button :disabled="!isEditMode" type="button" class="btn action-buttons ml-2" @click="openSelectCentralBilling">
                    &lt;&lt;Pick
                </button>
            </div>
          </div>
        </portlet-content>
        <portlet-content :height="165" header="Products" class="col-12 px-2">
          <div slot="body" class="p-2">
            <div class="row">
              <label class="col-lg-1 text-right">Notes </label>
              <textarea class="col-lg-10" id="" cols="8" rows="2" v-model="model.products.notes"></textarea>
            </div>
            <div class="row pt-3 d-flex align-items-center">
              <input type="number" class="form-control col-2" v-model="model.products.product_counter"/>
              <label class="col-lg-2">Product Counter</label>
              <input type="checkbox" class="ml-2" v-model="model.products.uses_order_ref"/>
              <label class="col-lg-2 text-bold">Uses Order Ref.</label>
            </div>
          </div>
        </portlet-content>
      </div>
    </div>
  </div>
</div>
