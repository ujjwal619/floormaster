<div class="col-xsmall-12 col-small-12">
  <div class="table-wrap">
    <portlet-content :onlybody="true" :height="210">
      <template slot="body">
        <div class="row">
					<div style="width: 5%; text-align: center;">
            <label>UPC</label>
					</div>
					<div style="width: 6%; padding-left: 16px;">
						<label>Quantity</label>
					</div>
					<div style="width: 15%">
						<label>Supplier</label>
					</div>
					<div style="width: 15%">
						<label>Range</label>
					</div>
					<div style="width: 15%">
						<label>Color</label>
					</div>
					<div style="width: 6%">
						<label>List Price</label>
					</div>
					<div style="width: 4%">
						<label>Disc %</label>
					</div>
					<div style="width: 4%">
						<label>GST %</label>
					</div>
					<div style="width: 4%">
						<label>Levy</label>
					</div>
					<div style="width: 6%">
						<label>Extension</label>
					</div>
					<div style="width: 2%">
						<label>&nbsp;</label>
					</div>
					<div style="width: 4%" class="pr-2">
						<label>On Order</label>
					</div>
					<div style="width: 4%">
						<label>Alloctd</label>
					</div>
					<div style="width: 4%">
						<label>Act On</label>
					</div>
					<div style="width: 4%">
						<label>Disptchd</label>
					</div>
					<div style="width: 2%">
						<label>&nbsp;</label>
					</div>
				</div>
        <div class="row" style="max-height: 170px;overflow-y: scroll;"> 
          <table class="table table-bordered">
            <tbody>
            <tr 
              v-for="(material,index) in values.materials" 
              :key="material.id"
            >
              <td style="width: 5%" @click="openEditMaterialProductModal(material, index)">@{{ material.upc ? (material.supplier_id + ' - ' + material.upc) : '&nbsp;' }}</td>
              <td style="width: 4%" @click="openEditMaterialProductModal(material, index)">@{{ Number(material.quantity).toFixed(2) }}</td>                                                                                 
              <td style="width: 15%" @click="openEditMaterialProductModal(material, index)">@{{ material.supplier_name }}</td>
              <td style="width: 15%" @click="openEditMaterialProductModal(material, index)">@{{ material.product_name }}</td>
              <td style="width: 15%" @click="openEditMaterialProductModal(material, index)">@{{ material.variant_name }}</td>
              <td style="width: 6%" class="text-right" @click="openEditMaterialProductModal(material, index)">@{{ displayMoney(material.unit) }}</td>
              <td style="width: 4%" @click="openEditMaterialProductModal(material, index)">@{{ material.discount || 0 }}%</td>
              <td style="width: 4%" @click="openEditMaterialProductModal(material, index)">@{{ material.gst || 0 }}%</td>
              <td style="width: 4%" @click="openEditMaterialProductModal(material, index)">@{{ material.levy || 0 }}%</td>
              <td style="width: 6%" class="text-right" @click="openEditMaterialProductModal(material, index)">@{{ displayMoney(material.total) }}</td>
              <td style="width: 2%" @click="openEditMaterialProductModal(material, index)">@{{ material.material_from ? material.material_from : 'P' }}</td>
              <td style="width: 4%" @click="openEditMaterialProductModal(material, index)">@{{ material.on_order }}</td>
              <td style="width: 4%" @click="openEditMaterialProductModal(material, index)">@{{ material.allocated }}</td>
              <td style="width: 4%" @click="openEditMaterialProductModal(material, index)" class="text-danger">@{{ material.product_id ? calculateActOn(material) : '' }}</td>
              <td style="width: 4%" @click="openEditMaterialProductModal(material, index)">@{{ material.dispatched }}</td>
              <td style="width: 3%">
                <button 
                  style="padding: 4px !important;"
                  :disabled="!canAct(material)" 
                  class="action-buttons  btn" 
                  @click="openActModal(material)"
                >Act</button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </template>
    </portlet-content>
  </div>

  <div class="row">
    <div class="col-xsmall-6 col-small-6 table-wrap">
      <portlet-content :onlybody="true" :height="100">
        <template slot="body">
          <div class="row">
            <div class="col-2 text-right"><small>Deliveries Pending</small></div>
            <div class="col-10" style="max-height: 80px;overflow-y: scroll;">
              <table class="table table-bordered">
                <tbody>
                <template v-if="job">
                  <tr v-for="(futureStock,index) in values.job.future_stocks" :key="index">
                    <template @click="redirectToCurrentOrders(futureStock.order_number)">
                      <td style="width: 10%" @click="redirectToCurrentOrders(futureStock.order_number)">@{{ (futureStock.quantity - futureStock.received).toFixed(2) }}</td>
                      <td style="width: 10%">@{{ formatViewDate(futureStock.delivery_date) }}</td>
                      <td style="width: 10%">@{{ futureStock.order_number }}</td>
                      <td style="width: 10%">@{{ futureStock.color.product.name }}</td>
                      <td style="width: 10%">@{{ futureStock.color.name }}</td>
                    </template>
                  </tr>
                </template>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </portlet-content>
      <portlet-content :onlybody="true" :height="100">
        <template slot="body">
          <div class="row">
            <div class="col-2 text-right"><small>Back Orders & Allocations</small></div>
            <div class="col-10" style="max-height: 80px;overflow-y: scroll;">
              <table class="table table-bordered">
                <tbody>
                <template v-if="job">
                  <tr v-for="(allocationOrBackOrder,index) in values.job.allocations_and_back_orders" :key="index">
                    <template @click="allocationOrBackOrderTOStock(allocationOrBackOrder.variant_id)">
                      <td style="width: 10%" @click="allocationOrBackOrderTOStock(allocationOrBackOrder.variant_id)">@{{ allocationOrBackOrder.amount }}</td>
                      <td style="width: 10%">@{{ allocationOrBackOrder.current_stock ? allocationOrBackOrder.current_stock.batch : '' }}</td>
                      <td style="width: 10%">@{{ allocationOrBackOrder.current_stock ? allocationOrBackOrder.current_stock.roll_no : '' }}</td>
                      <td style="width: 10%">@{{ allocationOrBackOrder.color.product.name + ' ' + allocationOrBackOrder.color.name }}</td>
                    </template>
                  </tr>
                </template>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </portlet-content>
      <portlet-content :onlybody="true" :height="100">
        <template slot="body">
          <div class="row">
            <div class="col-2 text-right">
              
              <small>Stock Dispatched</small><br> <br>
              <label>$@{{ totalStockDispatches.toFixed(2) || 0 }}</label>
            </div>
            <div class="col-10" style="max-height: 80px;overflow-y: scroll;">
              <table class="table table-bordered">
                <tbody>
                <template v-if="job">
                  <tr v-for="(dispatch,index) in values.job.dispatches" :key="index">
                    <td style="width: 10%" @click="dispatchToStockHistory(dispatch)">@{{ dispatch.amount }}</td>
                    <td style="width: 10%" @click="dispatchToStockHistory(dispatch)">@{{ formatViewDate(dispatch.date) }}</td>
                    <td style="width: 30%" @click="dispatchToStockHistory(dispatch)">@{{ dispatch.supplier_product_color }}</td>
                    <td class="text-right" style="width: 10%" @click="dispatchToStockHistory(dispatch)">@{{ displayMoney(dispatch.total)}}</td>
                  </tr>
                </template>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </portlet-content>
      <portlet-content :onlybody="true" :height="100">
        <template slot="body">
          <div class="row">
            <div class="col-2 text-right">
              <small>Creditors Payable</small><br> <br>
              <label>$@{{ totalCreditorsPayables.toFixed(2) || 0 }}</label> 
              
            </div>
            <div class="col-10" style="max-height: 80px;overflow-y: scroll;">
              <table class="table table-bordered">
                <tbody>
                <template v-if="job">
                  <tr v-for="(payable,index) in values.job.creditors_payables" :key="index">
                    <template @click="creditorsPayableToPayable(payable)">
                      <td style="width: 10%" @click="creditorsPayableToPayable(payable)">@{{ formatViewDate(payable.invoice_date) }}</td>
                      <td style="width: 10%">@{{ payable.supplier_reference }}</td>
                      <td style="width: 30%">@{{ payable.supplier.trading_name }}</td>
                      <td class="text-right" style="width: 10%">@{{ displayMoney(payable.expected_amount) }}</td>
                    </template>
                  </tr>
                </template>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </portlet-content>
      <portlet-content :onlybody="true" :height="100">
        <template slot="body">
          <div class="row">
            <div class="col-2 text-right">
              <small>Contractors Payable</small><br> <br>
              <label>$@{{ totalContractorsPayables.toFixed(2) || 0 }}</label>
            </div>
            <div class="col-10" style="max-height: 80px;overflow-y: scroll;">
              <table class="table table-bordered">
                <tbody>
                <template v-if="job">
                  <tr v-for="(payable,index) in values.job.contractors_payables" :key="index">
                    <template @click="contractorsPayableToContractor(payable)">
                      <td style="width: 10%" @click="contractorsPayableToContractor(payable)">@{{ formatViewDate(payable.date) }}</td>
                      <td style="width: 30%">@{{ payable.contractor.name }}</td>
                      <td class="text-right" style="width: 10%">@{{ displayMoney(payable.amount) }}</td>
                    </template>
                  </tr>
                </template>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </portlet-content>
      <portlet-content :onlybody="true" :height="100">
        <template slot="body">
          <div class="row">
            <div class="col-2 text-right">
              <small>Paid</small><br> <br>
              <label>$@{{ totalPaidPayables.toFixed(2) || 0 }}</label>
            </div>
            <div class="col-10" style="max-height: 80px;overflow-y: scroll;">
              <table class="table table-bordered">
                <tbody>
                <template v-if="job">
                  <tr v-for="(remitItem,index) in values.job.paid_payables" :key="index">
                    <template @click="creditorsPayableToChequeButt(remitItem)">
                      <td style="width: 10%" @click="creditorsPayableToChequeButt(remitItem)">@{{ formatViewDate(remitItem.remittance.transaction_date) || formatViewDate(remitItem.remittance.cheque_date) }}</td>
                      <td style="width: 10%">@{{ remitItem.order_no }}</td>
                      <td style="width: 30%">@{{ remitItem.payable ? remitItem.payable.supplier.trading_name : remitItem.payment_due.contractor.name }}</td>
                      <td class="text-right" style="width: 10%">@{{ displayMoney(remitItem.net_payment) }}</td>
                    </template>
                  </tr>
                </template>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </portlet-content>
      <portlet-content :onlybody="true" :height="60">
        <template slot="body">
          <span class="text-white pull-right">Re: @{{ values.job.project }}</span>
          <span class="text-white">@{{ site.quote_prefix + '' + values.job.job_id }}</span><br>
          <span class="text-white">@{{ values.customerDetails.trading_name }}</span>
        </template>
      </portlet-content>
    </div>

    <div class="col-xsmall-6 col-small-6 table-wrap">
      <portlet-content :onlybody="true">
        <template slot="body">
          <div class="col-xsmall-12" style="max-height: 120px;overflow-y: scroll;">
            <table class="table table-bordered">
              <tbody>
              <tr>
                <td>Quantity</td>
                <td>Labour Item</td>
                <td>Rate</td>
                <td>Extension</td>
              </tr>
              <tr 
                v-for="(material,index) in values.labours"
                :key="index"
                @click="openEditLabourProductModal(material)"
                >
                <td style="width: 10%">@{{ Number(material.quantity).toFixed(2) }}</td>
                <td style="width: 10%">@{{ material.product }}</td>
                <td class="text-right" style="width: 10%">@{{ displayMoney(material.unit) }}</td>
                <td class="text-right" style="width: 10%">@{{ displayMoney(material.total) }}</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td>Labour:</td>
                <td class="text-right">@{{ displayMoney(labourGrandTotal) }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </template>
      </portlet-content>
      <portlet-content :onlybody="true" :height="350">
        <template slot="body">
          <div class="row">
            <div class="col-md-5">
              <label>Commission Guide</label>
              <div class="row">
                <div class="col-small-3"><label>Com %</label></div>
                <div class="col-small-4">
                  <input type="text" class="commissionInput" v-model="values.commission_percentage"/>
                </div>
                <div class="col-small-1">
                  <label>=</label>
                </div>
                <div class="col-small-4">
                  <input type="text" class="commissionInput" :value="commissionAmount" disabled/>
                </div>
              </div>
              <label>Quote Guide</label>
              <div class="row">
                <div class="col-small-3"><label>+%</label></div>
                <div class="col-small-4">
                  <input type="text" class="commissionInput" v-model="values.guided_percentage"/>
                </div>
                <div class="col-small-1">
                  <label>=</label>
                </div>
                <div class="col-small-4">
                  <input type="text" disabled class="commissionInput" :value="guidedAmount"/>
                </div>
              </div>
              <div class="row float-right" style="padding-top: 35%;">
                <div class="col-12">
                  <div class="row">
                    <div class="pr-2 pb-3">
                      <button 
                        @click="calculate" 
                        class="btn action-buttons center" 
                        style="color: #6e1a07"
                        >Calculate >></button>
                    </div>
                    <label class="required pt-2" style="color: #6e1a07">
                      Mark-up% 
                    </label>
                  </div>
                  <div class="row pt-1">
                    <div class="col-12">
                      <label class="text-right" style="color: blue;" ><strong><u>Actuals to Date</u></strong></label>  
                      <label class="text-right" style="color: blue;">Other Costs include misc.<br> Cash Book entries &<br> Invoice Expenses</label>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
            <div class="col-md-7">
              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right">Materials</label>
                </div>
                <div class="col-small-1">
                  <label class="dollarLabelBeforTextBox">$</label>
                </div>
                <div class="col-small-4">
                  <input type="text" name="company_name"
                         disabled="disabled"
                         :value="displayNumber(materialGrandTotal)"
                         class="form-control inputWithDollar jobCalculationInputField text-right">
                </div>
                <div class="col-small-3"></div>
              </div>

              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right">Net Cost</label>
                </div>
                <div class="col-small-1">
                  <label class="dollarLabelBeforTextBox">$</label>
                </div>
                <div class="col-small-4">
                  <input type="text" name="company_name"
                         disabled="disabled"
                         :value="displayNumber(netCost)"
                         class="form-control inputWithDollar jobCalculationInputField text-right">
                </div>
                <div class="col-small-3"></div>
              </div>

              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right">Costed Commission</label>
                </div>
                <div class="col-small-1">
                  <label class="dollarLabelBeforTextBox">$</label>
                </div>
                <div class="col-small-4">
                  <input 
                    type="text" 
                    name="company_name"
                    v-model="values.job.costed_commission"
                    class="form-control inputWithDollar jobCalculationInputField text-right"
                  >
                </div>
                <div class="col-small-3"></div>
              </div>

              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right">Total Cost</label>
                </div>
                <div class="col-small-1">
                  <label class="dollarLabelBeforTextBox">$</label>
                </div>
                <div class="col-small-4">
                  <input type="text" name="company_name"
                         disabled="disabled"
                         :value="displayNumber(totalCost || 0)"
                         class="form-control inputWithDollar jobCalculationInputField text-right">
                </div>
                <div class="col-small-3"></div>
              </div>


              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right" style="color: blue"><strong>Quote Price</strong></label>
                </div>
                <div class="col-small-1">
                  <label class="dollarLabelBeforTextBox">$</label>
                </div>
                <div class="col-small-4">
                  <input 
                   
                    type="text" 
                    name="company_name"
                    v-model="values.job.quote_price"
                    class="form-control inputWithDollar jobCalculationInputField text-right">
                </div>
                <div class="col-small-3">
                  <label class="required" style="color: blue"><strong>Net</strong></label>
                </div>
              </div>

              <div class="row">
                <div class="col-small-4">
                  <div class="row">
                    <label class="required col-5 text-right">GST</label>
                    <input type="text" class="commissionInput col-5" v-model="values.job.gst"/>
                    <label class="required col-2">%</label>
                  </div>
                </div>
                <div class="col-small-1">
                  <label class="dollarLabelBeforTextBox">$</label>
                </div>
                <div class="col-small-4">
                  <input type="text" name="company_name"
                         v-model="values.job.gst_amount"
                         class="form-control inputWithDollar jobCalculationInputField text-right">
                </div>
                <div class="col-small-3"></div>
              </div>


              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right" style="color: red"><strong>Total Charge</strong></label>
                </div>
                <div class="col-small-1">
                  <label class="dollarLabelBeforTextBox">$</label>
                </div>
                <div class="col-small-4">
                  <input type="text" name="company_name"
                         disabled="disabled"
                         :value="displayNumber(values.job.gst_inclusive_quote)"
                         class="form-control inputWithDollar jobCalculationInputField text-right">
                </div>
                <div class="col-small-3">
                  <label class="required" style="color: red"><strong>with GST</strong></label>
                </div>
              </div>


              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right" style="color: #6e1a07"><strong class="pr-1">@{{ quoteMarkUp + '%' }}</strong>Margin:</label>
                </div>
                <div class="col-small-1">
                  <label class="dollarLabelBeforTextBox">$</label>
                </div>
                <div class="col-small-4">
                  <input type="text" name="company_name"
                         disabled="disabled"
                         :value="displayNumber(quoteMargin)"
                         class="form-control inputWithDollar jobCalculationInputField text-right">
                </div>
                <div class="col-small-3">
                  <label class="required" style="color: #6e1a07"><strong>@{{ quoteGrossProfit + '%' }} GP%</strong></label>
                </div>
              </div>

              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right" style="color: blue;">Net Invoiced:</label>
                </div>
                <div class="col-small-3 ml-11">
                  <label class="text-right" style="color: blue;">@{{ displayMoney(netInvoiced) }}</label>
                </div>
                <div class="col-small-3"></div>
              </div>

              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right" style="color: blue;">Actioned Cost:</label>
                </div>
                <div class="col-small-3 ml-11">
                  <label class="text-right" style="color: blue;">@{{ displayMoney(netLabourAllocated) }}</label>
                </div>
                <div class="col-small-3"></div>
              </div>

              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right" style="color: blue;">Other Costs:</label>
                </div>
                <div class="col-small-3 ml-11">
                  <label class="text-right" style="color: blue;"></label>
                </div>
                <div class="col-small-3"></div>
              </div>

              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right" style="color: blue;">Deemed Costs:</label>
                </div>
                <div class="col-small-3 ml-11">
                  <label class="text-right" style="color: blue;"></label>
                </div>
                <div class="col-small-3"></div>
              </div>

              <div class="row">
                <div class="col-small-4">
                  <label class="required text-right" style="color: blue;"><strong>Margin to Date:</strong></label>
                </div>
                <div class="col-small-3 ml-11">
                  <label class="text-right" style="color: blue;">$@{{ marginToDate }}</label>
                </div>
                <div class="col-small-3"></div>
              </div>
            </div>
        </template>
      </portlet-content>
    </div>

  </div>

  <template v-if="mountActOnMaterial">
    <act-on-material
      :material="selectedMaterialForActing"
      @orderfuturestock="orderFutureStockForJob"
      @close="closeActModal"
    />
  </template>

  <div class="row">
    <div class="col-xsmall-12 col-small-6 table-wrap">

    </div>
  </div>
</div>
