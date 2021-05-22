<div class="row">
  <div class="col-6">
      <div class="row">
          <portlet-content :height="200" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="form-group p-2">
                  <div class="row pb-2">
                  <label class="col-lg-1 text-right" v-if="isOldEntry">Store:</label>
                  <label class="col-lg-8 font-weight-bold">@{{ siteName }}</label>
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-1 text-right">Name:</label>
                      <input :disabled="!isEditMode" class="col-lg-8 form-control text-primary" type="text" v-model="model.name">
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-1 text-right">Street:</label>
                      <input :disabled="!isEditMode" class="col-lg-8 form-control" type="text" v-model="model.street">
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-1 text-right">Suburb:</label>
                      <input :disabled="!isEditMode" class="col-lg-6 form-control" type="text" v-model="model.suburb">
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-1 text-right">State:</label>
                      <input :disabled="!isEditMode" :value="model.state" class="col-lg-2 form-control" type="text" @focus="openModal('StateModal')">
                      <label class="col-lg-1 text-right">Postcode:</label>
                      <input :disabled="!isEditMode" class="col-lg-2 form-control" type="number" v-model="model.postcode">
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-1 text-right">Phone:</label>
                      <input :disabled="!isEditMode" class="col-lg-8 form-control" type="number" v-model="model.phone">
                      <div class="col-lg-3 d-flex align-items-center pl-4">
                          <input type="checkbox" :disabled="!isEditMode" v-model="model.is_active">
                          <span class="text-danger ml-2">Active</span>
                      </div>
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-1 text-right">Key No:</label>
                      <input :disabled="!isEditMode" class="col-lg-6 form-control" type="number" v-model="model.key_no">
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="70" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="pb-2 p-2">
                  <div class="row pb-2">
                      <label class="col-lg-1 text-right">Vehicle:</label>
                      <input :disabled="!isEditMode" class="col-lg-8 form-control" type="text" v-model="model.vehicle">
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-1 text-right">Rego:</label>
                      <input :disabled="!isEditMode" class="col-lg-2 form-control" type="text" v-model="model.rego">
                      <label class="col-lg-1 text-right">Expires:</label>
                      <input :disabled="!isEditMode" class="col-lg-3 form-control" type="text" v-model="model.expires">
                      <label class="col-lg-1 text-right">License:</label>
                      <input :disabled="!isEditMode" class="col-lg-3 form-control" type="text" v-model="model.license">
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="50" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="p-2">
                  <div class="row pb-2">
                      <label class="col-lg-1 text-right">TFN:</label>
                      <input :disabled="!isEditMode" class="col-lg-2 form-control text-primary" type="text" v-model="model.tfn">
                      <label class="col-lg-1 text-right">ABN:</label>
                      <input :disabled="!isEditMode" class="col-lg-2 form-control text-primary" type="text" v-model="model.abn">
                      <label class="col-lg-1 text-right">VN:</label>
                      <input :disabled="!isEditMode" class="col-lg-2 form-control" type="text" v-model="model.vn">
                      <label class="col-lg-1 text-right">Tax%:</label>
                      <input :disabled="!isEditMode" class="col-lg-2 form-control" type="number" v-model="model.tax">
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="110" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="p-2">
                  <div class="row pb-2">
                      <div class="col-lg-2">
                          <span class="background-black text-truncate">Bank</span>
                      </div>
                      <label class="col-lg-2 text-right">A/C Name:</label>
                      <input :disabled="!isEditMode" class="col-lg-6 form-control" type="text" v-model="bank.account_name">
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-2 text-right">Bank:</label>
                      <input :disabled="!isEditMode" class="col-lg-4 form-control" type="text" v-model="bank.bank">
                      <label class="col-lg-1 text-right">A/C No:</label>
                      <input :disabled="!isEditMode" class="col-lg-4 form-control " type="text" v-model="bank.account_number">
                  </div>
                  <div class="row pb-2">
                      <input :disabled="!isEditMode" type="checkbox" v-model="bank.eft">
                      <span class="text-danger">EFT</span>
                      <label class="col-lg-1 text-right">Branch:</label>
                      <input :disabled="!isEditMode" class="col-lg-4 form-control" type="text" v-model="bank.branch">
                      <label class="col-lg-1 text-right">BSB:</label>
                      <input :disabled="!isEditMode" class="col-lg-3 form-control" type="text" v-model="bank.bsb">
                      <span class="h6 ml-2">000-0000 format</span>
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="85" :onlybody="true" class="col-6 px-2">
              <div slot="body" class="p-2">
                  <div class="row pb-2">
                      <span class="background-black text-truncate">Contractor Liability Account</span>
                  </div>
                  <div class="row">
                      <div class="col-lg-3">&nbsp;</div>
                      <input disabled class="col-lg-5 form-control text-right" type="text" v-model="model.contractor_liability_account_code">
                      <button :disabled="!isEditMode" type="button" class="btn action-buttons ml-2" @click="pickAccount('contractor_liability_account')">
                          &lt;&lt;Pick
                      </button>
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="85" :onlybody="true" class="col-6 px-2">
              <div slot="body" class="p-2">
                  <div class="row pb-2">
                      <span class="background-black text-truncate">Cost of Sales Account</span>
                  </div>
                  <div class="row">
                      <div class="col-lg-3">&nbsp;</div>
                      <input disabled class="col-lg-5 form-control text-right" type="text" v-model="model.cost_of_sales_account_code">
                      <button :disabled="!isEditMode" type="button" class="btn action-buttons ml-2" @click="pickAccount('cost_of_sales_account')">
                          &lt;&lt;Pick
                      </button>
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="85" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="p-2">
                  <div class="row pb-2">
                      <span class="background-black text-truncate">Tax Liability Account</span>
                  </div>
                  <div class="row pb-2">
                      <div class="col-lg-2">&nbsp;</div>
                      <input disabled class="col-lg-5 form-control text-right" type="text" v-model="tax_liability_account.supplier_name">
                      <input disabled class="col-lg-3 form-control text-right" type="text" v-model="tax_liability_account.account_code">
                      <button :disabled="!isEditMode" type="button" class="btn action-buttons ml-2" @click="pickSupplierAccount('tax_liability_account')">
                          &lt;&lt;Pick
                      </button>
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="90" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="p-2">
                  <div class="row pb-3 d-flex justify-content-between">
                      <div class="col-lg-2">
                          <span class="background-black text-truncate">Deductions</span>
                      </div>
                      <div class="col-lg-4 d-flex align-items-center justify-content-between">
                          <div>
                              <input type="radio" v-model="deductions.type" value="super"><span>Super</span>
                          </div>
                          <span>or</span>
                          <div>
                              <input type="radio" v-model="deductions.type" value="workers_comp"><span>Workers Comp.</span>
                          </div>
                      </div>
                      <div class="col-lg-4 d-flex align-items-center">
                          %:
                          <input :disabled="!isEditMode" class="form-control text-right" type="text" v-model="deductions.tax">
                          <input class="ml-2" type="checkbox" v-model="deductions.is_checked">
                          <span class="col-lg-6">B4 Tax</span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-1">&nbsp;</div>
                      <input disabled class="col-lg-5 form-control text-right" type="text" v-model="deductions.supplier_name">
                      <input disabled class="col-lg-3 form-control text-right" type="text" v-model="deductions.account_code">
                      <button :disabled="!isEditMode" type="button" class="btn action-buttons ml-2" @click="pickSupplierAccount('deductions')">
                          &lt;&lt;Pick
                      </button>
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="120" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="p-2">
                  <span class="text-bold">Notes:</span>
                  <textarea class="col-12" cols="5" rows="1" v-model="model.note"></textarea>
              </div>
          </portlet-content>
          
      </div>
  </div>
  <div class="col-6">
      <div class="row">
          <portlet-content :height="386" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="p-2">
                  <div class="row">
                      <div class="col-lg-4">
                          <span class="background-black">Payments Due</span>
                      </div>
                  </div>
                  <div class="row table-wrap portlet-table" style="max-height: 270px;overflow-y: auto;">
                      <table class="table">
                          <tbody>
                              <template v-if="payments.length && hasPermission('contractors.due.reports')">
                                  <tr 
                                    class="row col-12 text-bold" 
                                    v-for="payment in payments" 
                                    :key="payment.id"
                                    >
                                      <td class="col-1">
                                          <button class="btn action-buttons" @click="editPayableData(payment)">Edit >> </button>
                                      </td>
                                      <td @click="redirectToJob(payment.job)" class="col-2">
                                          @{{ payment.job.job_id }}
                                      </td>
                                      <td class="col-3">@{{ payment.client }}</td>
                                      <td class="col-2">@{{ formatViewDate(payment.date) }}</td>
                                      <td class="col-2 text-danger">@{{ displayMoney(payment.amount) }}</td>
                                      <td class="col-2 text-danger">@{{ displayMoney(payment.gst_amount) }}</td>
                                  </tr>
                              </template>
                              <template v-else>
                                  <tr class="row col-12 text-bold">
                                      <td class="col-12">
                                          No Records Found
                                      </td>
                                  </tr>
                              </template>
                          </tbody>
                      </table>
                  </div>
                  <div class="row">
                      <table class="table">
                          <tbody>
                              <tr class="row col-12">
                                  <td class="col-8">&nbsp;</td>
                                  <td class="col-2 text-danger">@{{ displayMoney(getPaymentTotal) }}</td>
                                  <td class="col-2 text-danger">@{{ displayMoney(getGstTotal) }}</td>
                              </tr>
                              <tr class="row col-12">
                                  <td class="col-10">
                                  <input type="checkbox">
                                  <span class="text-danger">Does not collect GST</span>
                                  </td>
                                  <td class="col-2 text-danger">@{{ displayMoney(getFinalTotal) }} </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="200" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="p-2">
                  <div class="row">
                      <div class="col-lg-4">
                          <span class="background-black">Deductions Payable</span>
                      </div>
                  </div>
                  <div class="row table-wrap pl-2 portlet-table" style="max-height: 150px;overflow-y: auto;">
                      <table class="table">
                          <tbody>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                              <tr class="row col-12 text-bold">
                                  <td class="col-3">
                                      &nbsp;
                                  </td>
                                  <td class="col-6">&nbsp;</td>
                                  <td class="col-3">&nbsp;</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="100" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="p-2">
                  <div class="row pb-2">
                      <div class="col-lg-4">
                          <span class="background-black text-truncate">Public Liability Insurance</span>
                      </div>
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-2 text-right">Policy:</label>
                      <input :disabled="!isEditMode" class="col-lg-4 form-control" type="text" v-model="public_liability_insurance.policy">
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-2 text-right">Insurer:</label>
                      <input :disabled="!isEditMode" class="col-lg-4 form-control" type="text" v-model="public_liability_insurance.insurer">
                      <label class="col-lg-1 text-right">Expires:</label>
                      <input :disabled="!isEditMode" class="col-lg-4 form-control" type="text" v-model="public_liability_insurance.expires">
                  </div>
              </div>
          </portlet-content>
          <portlet-content :height="100" :onlybody="true" class="col-12 px-2">
              <div slot="body" class="p-2">
                  <div class="row pb-2">
                      <div class="col-lg-4">
                          <span class="background-black text-truncate">Workers Comp Insurance</span>
                      </div>
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-2 text-right">Policy:</label>
                      <input :disabled="!isEditMode" class="col-lg-4 form-control" type="text" v-model="workers_comp_insurance.policy">
                  </div>
                  <div class="row pb-2">
                      <label class="col-lg-2 text-right">Insurer:</label>
                      <input :disabled="!isEditMode" class="col-lg-4 form-control" type="text" v-model="workers_comp_insurance.insurer">
                      <label class="col-lg-1 text-right">Expires:</label>
                      <input :disabled="!isEditMode" class="col-lg-4 form-control" type="text" v-model="workers_comp_insurance.expires">
                  </div>
              </div>
          </portlet-content>
      </div>
  </div>
  <template v-if="mountStateModal">
    <state-modal
      @state="selectNewState"
      @close="closeModal('StateModal')"
    />
  </template>
</div>
