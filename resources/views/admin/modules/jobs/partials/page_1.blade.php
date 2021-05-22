<div class="row">
  <div class="col-xsmall-12 col-small-6">
    <portlet-content header="Company" subheader="Details" isform="true" height="865">
      <template slot="action_button" v-if="method==='post'">
        <button class="btn btn-primary auto-code-btn">Autocode</button>
      </template>
      <template slot="body">
        <div class="m-portlet__body">
          <div class="form-group m-form__group row">
            <div class="col-xsmall-12">
              <div class="row">
                <div class="col-small-1">
                  <label class="required">Name</label>
                </div>
                <div class="col-small-11 row pl-2">
                  <div class="col-2">
                    <label>Title</label>
                    <input
                            type="text"
                            class="form-control"
                            v-model="values.customerDetails.title"
                    />
                  </div>
                  <div class="col-3">
                    <label class="ml-2">Given Name</label>
                    <input type="text"
                           class="form-control ml-2"
                           v-model="values.customerDetails.firstname"
                    />
                    <span class="form-error"
                          v-if="form.errors.has('customerDetails.given_name')"
                          v-text="form.errors.get('customerDetails.given_name')"
                    ></span>
                  </div>
                  <div class="col-3">
                    <label class="ml-2">Surname/Company</label>
                    <input type="text"
                           name="company_name"
                           class="ml-2"
                           :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                           v-model="values.customerDetails.trading_name"
                    >
                    <span class="form-error"
                          v-if="form.errors.has('customerDetails.trading_name')"
                          v-text="form.errors.get('customerDetails.trading_name')"
                    ></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group m-form__group row pt-3">
            <div class="col-xsmall-12">
              <div class="row">
                <div class="col-small-1">
                  <label class="required">Street</label>
                </div>

                <div class="col-small-11">
                  <input type="text"
                         name="street"
                         :class="{ 'input-error' : form.errors.has('customer.address.street'), 'form-control': loaded }"
                         v-model="values.customerDetails.address.street"
                  >
                  <span class="form-error"
                        v-if="form.errors.has('customer.address.street')"
                        v-text="form.errors.get('customer.address.street')"></span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group m-form__group row">
            <div class="col-small-6">
              <div class="row">
                <div class="col-small-2">
                  <label class="required">Town</label>
                </div>
                <div class="col-small-10">
                  <input type="text"
                         name="town"
                         :class="{ 'input-error' : form.errors.has('customer.address.town'), 'form-control': loaded }"
                         v-model="values.customerDetails.address.town"
                         @focus="updateModalStatus('StateModal', true)"
                  >
                  <span class="form-error"
                        v-if="form.errors.has('customer.address.town')"
                        v-text="form.errors.get('customer.address.town')"></span>
                </div>
              </div>
            </div>
            <div class="col-small-3">
              <div class="row">
                <div class="col-small-3">
                  <label class="required" for="gender">State </label>
                </div>
                <div class="col-small-9">
                  <input
                          type="text"
                          name="state"
                          :value="values.customerDetails.address.state"
                          class="text-uppercase"
                          :class="{ 'input-error' : form.errors.has('customer.address.state'), 'form-control': loaded }"
                          @focus="updateModalStatus('StateModal', true)"
                  >
                  <span class="form-error"
                        v-if="form.errors.has('customer.address.state')"
                        v-text="form.errors.get('customer.address.state')"></span>
                </div>
              </div>
            </div>
            <div class="col-small-3">
              <div class="row">
                <div class="col-small-3">
                  <label class="required" for="gender">Code</label>
                </div>
                <div class="col-small-9">
                  <input type="text"
                         name="code"
                         :class="{ 'input-error' : form.errors.has('customer.address.code'), 'form-control': loaded }"
                         v-model="values.customerDetails.address.code"
                  >
                  <span class="form-error"
                        v-if="form.errors.has('customer.address.code')"
                        v-text="form.errors.get('customer.address.code')"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <div class="col-small-12">
              <div class="row">
                <div class="col-small-1">
                  <label class="required" for="gender">Contact</label>
                </div>
                <div class="col-small-11">
                  <input type="text"
                         name="contact"
                         :class="{ 'input-error' : form.errors.has('customer.contact'), 'form-control': loaded }"
                         v-model="values.customerDetails.contact"
                  >
                  <span class="form-error"
                        v-if="form.errors.has('customer.contact')"
                        v-text="form.errors.get('customer.contact')"></span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group m-form__group row">
            <div class="col-xsmall-12">
              <div class="row">
                <div class="col-small-1">
                  <label class="required">Project</label>
                </div>
                <div class="col-small-11">
                  <input type="text"
                         name="project"
                         :class="{ 'form-control': loaded }"
                         v-model="values.job.project"
                  >
                  <span class="form-error"
                        v-if="form.errors.has('job.project')"
                        v-text="form.errors.get('job.project')"></span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group m-form__group row">
            <div class="col-xsmall-12">
              <div class="row">
                <div class="col-small-1">
                  <label class="required" for="gender">Remarks</label>
                </div>
                <div class="col-small-11">
									<textarea
                          rows="18"
                          v-model="values.job.remarks"
                          placeholder="Remarks">
									</textarea>
                  <span class="form-error"
                        v-if="form.errors.has('job.remarks')"
                        v-text="form.errors.get('job.remarks')"></span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group m-form__group row">
            <div class="col-xsmall-12 col-small-6">
              <div class="row">
                <div class="col-small-2">
                  <label>Terms</label>
                </div>
                <div class="col-small-1">
                  <input type="text"
                         name="terms"
                         v-model="values.job.term.id"
                         class="form-control"
                         @focus="openModal('TermsModal')"
                  >
                </div>
                <div class="col-small-7">
                  <input type="text"
                         name="terms"
                         v-model="values.job.term.name"
                         disabled
                         class="form-control"
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <div class="col-xsmall-12">
              <div class="row">
                <div class="col-small-1">
                  <label></label>
                </div>
                <div class="col-small-11">
                    <textarea 
                      name="" 
                      id="" 
                      cols="30" 
                      rows="6" 
                      disabled
                    >@{{ quoteTerm }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </portlet-content>
  </div>
  <div class="col-xsmall-12 col-small-6">
    <div class="row">
      <div class="col-xsmall-12 col-small-4">
        <portlet-content header="Job" subheader="Details" isform="true">
          <template slot="body">
            <div class="m-portlet__body">
              <div class="form-group m-form__group row" v-if="method==='patch'">
                <div class="col-xsmall-12">
                  <div class="row job-id">
                    <div class="col-small-4">
                      <label class="required">Job Id</label>
                    </div>
                    <div class="col-small-8">
                      <input type="text"
                             name="company_name"
                             :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                             disabled
                             :value="job.site.quote_prefix + '' + job.job_id"
                      >
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group m-form__group row">
                <div class="col-xsmall-12">
                  <div class="row">
                    <div class="col-small-3">
                      <label><span v-show="selectedShop.name">B.U.</span>(Store)</label>
                    </div>
                    <div class="col-small-9">
                      <input type="text"
                             name="company_name"
                             :class="{ 'form-control': loaded }"
                             disabled
                             :value="(selectedShop.name || '') + ' (' + selectedSite.name + ')'"
                             :title="(selectedShop.name || '') + ' (' + selectedSite.name + ')'"
                      >
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group m-form__group row">
                <div class="col-xsmall-12">
                  <div class="row">
                    <div class="col-small-3">
                      <label class="required">Source</label>
                    </div>
                    <div class="col-small-9">
                      {{--<select--}}
                      {{--:class="{ 'input-error' : form.errors.has('job.job_source_id'), 'form-control': loaded }"--}}
                      {{--v-model="values.job.job_source_id"--}}
                      {{-->--}}
                      {{--<option value="">Select Job source</option>--}}
                      {{--<option v-for="(source, key) in JSON.parse(jobsources)" :value="key"--}}
                      {{-->--}}
                      {{--@{{ source }}--}}
                      {{--</option>--}}
                      {{--</select>--}}

                      <drop-down
                              ref="sourceSelect"
                              :default-selected="selectedJobSource"
                              :options="jobSources"
                              label="title"
                              :value="values.job.job_source_id"
                              @input="setDefaultSelectedJobSource"
                      />

                      <span class="form-error"
                            v-if="form.errors.has('job.job_source_id')"
                            v-text="form.errors.get('job.job_source_id')">
												</span>

                      <span class="form-error"
                            v-if="form.errors.has('customer.address.street')"
                            v-text="form.errors.get('customer.address.street')"></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group m-form__group row">
                <div class="col-xsmall-12">
                  <div class="row">
                    <div class="col-small-3">
                      <label class="required">Type</label>
                    </div>
                    <div class="col-small-9">
                      <input type="text"
                             name="town"
                             disabled
                             :class="{ 'input-error' : form.errors.has('customer.address.town'), 'form-control': loaded }"
                             :value="values.job.type"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('customer.address.town')"
                            v-text="form.errors.get('customer.address.town')"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </template>
        </portlet-content>
      </div>
      <div class="col-xsmall-12 col-small-8">
        <portlet-content header="Sales Staff">
          <template slot="body">
            <div class="col-small-1">
              <button class="btn btn-primary m-btn--sm" title="Save" data-toggle="tooltip"
                      @click="openModal('StaffModal')"><i class="fa fa-plus"></i>
              </button>
            </div>
            <span class="form-error" v-if="form.errors.has('selectedSales')">
								Please select at least one sales staff.
							</span>
            <div class="row table-wrap" style="max-height: 55px;overflow-y: auto;">
              <div class="col-xsmall-12">
                <table class="table">
                  <tbody>
                  <tr v-for="(sale, index) in values.selectedSales" @click="editSalesStaff(sale, index)">
                    <td style="width: 45%;">@{{ getSalesName(sale.sales_id) }}</td>
                    <td style="width: 10%;">@{{ sale.priority }}</td>
                    <td style="width: 10%;">@{{ sale.commission }}</td>
                    <td style="width: 10%;" class="text-center">
                      <button class="btn btn-danger" @click="removeSalesStaff(sale.sales_id)">Delete</button>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </template>
        </portlet-content>
        <portlet-content :onlybody="true">
          <template slot="body">
            <div class="row">
              <label class="col-3">Sales Code: </label>
              <drop-down
                label="code"
                class="col-6 pb-1"
                :options="accounts"
                v-model="values.job.sales_code_id"
                :default-selected="salesCode"
                style="max-height: 40px;"
              />
            </div>
            <span 
              class="form-error"
              v-if="form.errors.has('job.sales_code_id')">Sales Code is Required.
            </span>
          </template>
        </portlet-content>
      </div>
    </div>
    <div class="row">
      <div class="col-xsmall-12">
        <portlet-content :onlybody="true">
          <template slot="body">
            <div class="form-group m-form__group row">
              <div class="col-xsmall-12 col-small-6">
                <div class="row">
                  <div class="col-small-3">
                    <label class="required">Home Ph</label>
                  </div>
                  <div class="col-small-9">
                    <input type="text"
                           name="company_name"
                           :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                           v-model="values.customerDetails.phone"
                    >
                    <span class="form-error"
                          v-if="form.errors.has('customer.trading_name')"
                          v-text="form.errors.get('customer.trading_name')"></span>
                  </div>
                </div>
              </div>

              <div class="col-xsmall-12 col-small-6">
                <div class="row">
                  <div class="col-small-3">
                    <label class="required">Work Ph</label>
                  </div>
                  <div class="col-small-9">
                    <input type="text"
                           name="company_name"
                           :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                           v-model="values.customerDetails.work_phone"
                    >
                    <span class="form-error"
                          v-if="form.errors.has('customer.trading_name')"
                          v-text="form.errors.get('customer.trading_name')"></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group m-form__group row">
              <div class="col-xsmall-12 col-small-6">
                <div class="row">
                  <div class="col-small-3">
                    <label class="required">Mobile</label>
                  </div>
                  <div class="col-small-9">
                    <input type="text"
                           name="company_name"
                           :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                           v-model="values.customerDetails.mobile"
                    >
                    <span class="form-error"
                          v-if="form.errors.has('customer.trading_name')"
                          v-text="form.errors.get('customer.trading_name')"></span>
                  </div>
                </div>
              </div>

              <div class="col-xsmall-12 col-small-6">
                <div class="row">
                  <div class="col-small-3">
                    <label class="required">Fax</label>
                  </div>
                  <div class="col-small-9">
                    <input type="text"
                           name="company_name"
                           :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                           v-model="values.customerDetails.fax"
                    >
                    <span class="form-error"
                          v-if="form.errors.has('customer.trading_name')"
                          v-text="form.errors.get('customer.trading_name')"></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group m-form__group row">
              <div class="col-xsmall-6">
                <div class="row">
                  <div class="col-small-3">
                    <label class="required">Email</label>
                  </div>
                  <div class="col-small-9">
                    <input type="email"
                           name="company_name"
                           :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                           v-model="values.customerDetails.email"
                    >
                  </div>
                </div>
              </div>
            </div>

          </template>
        </portlet-content>
      </div>
      <div class="col-xsmall-12 table-wrap">
        <portlet-content header="Materials @ sell Price (incl. GST)" height="310">
          <template slot="body">
            <div class="form-group m-form__group row">
              <div class="col-small-1">
                <button class="btn btn-primary m-btn--sm"
                        @click="openProductModal" :disabled="!selectedSite.id"><i class="fa fa-plus"></i></button>
              </div>
            </div>
            <span class="form-error" v-if="form.errors.has('materials')">* Please select at least one material.</span>
            <div class="form-group m-form__group row">
              <div class="col-small-4">
                <label class="required">Range</label>
              </div>
              <div class="col-small-2">
                <label class="required">Variant</label>
              </div>
              <div class="col-small-2">
                <label class="required">Qty</label>
              </div>
              <div class="col-small-2">
                <label class="required">Unit Sell</label>
              </div>
              <div class="col-small-1">
                <label class="required">Total</label>
              </div>
              <div class="col-small-1 pl-5">
                <label class="required">Action</label>
              </div>
            </div>
            <div class="form-group m-form__group">
              <div style="max-height: 230px;overflow-y: scroll;">
                <table class="table table-bordered">
                  <tbody>
                  <tr 
                    v-for="(material,index) in values.materials"
                    :key="index"
                  >
                    <td style="width: 30%" @click="openEditMaterialProductModal(material,index)">@{{ material.product_name }}</td>
                    <td style="width: 20%" class="pl-5" @click="openEditMaterialProductModal(material,index)">@{{ material.variant_name }}</td>
                    <td style="width: 10%" class="pl-5" @click="openEditMaterialProductModal(material,index)">@{{ Number(material.quantity).toFixed(2) }}</td>
                    <td style="width: 20%" class="pr-3 text-right" @click="openEditMaterialProductModal(material,index)">@{{ displayMoney(material.unit_sell) }}</td>
                    <td style="width: 10%" class="text-right" @click="openEditMaterialProductModal(material,index)">@{{ displayMoney(getMaterialTotalFirstPage(material)) }}</td>
                    <td style="width: 10%" class="text-center">
                      <button class="btn btn-danger" @click="removeMaterial(index)">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">@{{ displayMoney(materialGrandTotalFirstPage) }}</td>
                    <td>Total</td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </template>
        </portlet-content>
      </div>
      <div class="col-xsmall-12 table-wrap">
        <portlet-content header="Labour @ sell Price (incl. GST)">
          <template slot="body">
            <div class="form-group m-form__group row">
              <div class="col-small-3">
                <label class="required">Labour</label>
                <input type="text"
                       :class="{ 'input-error' : form.errors.has('labour.name'), 'form-control': loaded }"
                       v-model="values.labour.product"
                >
              </div>

              <div class="col-small-2">
                <label class="required">Qty</label>
                <input type="text"
                       :class="{ 'input-error' : form.errors.has('labour.quantity'), 'form-control': loaded }"
                       v-model="values.labour.quantity"
                >
              </div>
              <div class="col-small-3">
                <label class="required">Unit Charge</label>
                <input type="text"
                       :class="{ 'input-error' : form.errors.has('labour.unitCost'), 'form-control': loaded }"
                       v-model="values.labour.unitCost"
                >
              </div>
              <div class="col-small-2">
                <label class="required">Grand Total</label>
                <input type="text"
                       disabled
                       :class="{ 'form-control': loaded }"
                       :value="labourProductPrice"
                >
              </div>
              <div class="col-small-2">
                <label class="required">Action</label>
                <button 
                  class="btn btn-primary m-btn--sm"
                  @click="addNewLabour"
                ><i class="fa fa-plus"></i></button>
              </div>
            </div>
            <span class="form-error"
                  v-if="form.errors.has('labours')">* Please select at least one labour.</span>
            <div class="form-group m-form__group row">
              <div class="col-xsmall-12" style="max-height: 90px;overflow-y: scroll;">
                <table class="table table-bordered">
                  <tbody>
                  <tr 
                    v-for="(material,index) in values.labours"
                    :key="index"
                  >
                    <td @click="openEditLabourProductModal(material)" style="width: 25%">@{{ material.product }}</td>
                    <td @click="openEditLabourProductModal(material)" style="width: 15%">@{{ Number(material.quantity).toFixed(2) }}</td>
                    <td class="text-right" @click="openEditLabourProductModal(material)" style="width: 25%">@{{ displayMoney(material.unit) }}</td>
                    <td class="text-right" @click="openEditLabourProductModal(material)" style="width: 10%">@{{ displayMoney(material.total) }}</td>
                    <td style="width: 15%" class="text-center">
                      <button class="btn btn-danger" @click="removeLabour(index)">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">@{{ displayMoney(labourGrandTotal) }}</td>
                    <td>Grand Total</td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </template>
        </portlet-content>
      </div>
      <div class="col-12 mb-2">
        <portlet-content :onlybody="true">
          <div slot="body" class="py-1 px-1">
            <div class="row">
              <div class="col-3">
                <span class="background-black">
                  Sell Price Costing
                </span>
                <button class="btn action-buttons" @click="openModal('ForceJob')">Force Total</button>
              </div>
              <div class="col-9 row">
                <label class="col-7 text-right pr-2">Calculated Sell Total:</label>
                <input type="text" class="form-control col-5 text-primary" disabled
                       :value="displayMoney(materialLabourCostTotal)"/>
                <label class="col-7 text-right pr-2">GST Inclusive Quote:</label>
                <input v-if="values.job" type="text" class="form-control col-5 text-danger" disabled
                       :value="displayMoney(gstInclusiveQuote)"/>
                <input v-else type="text" class="form-control col-5 text-danger" disabled value="$0"/>
                <label class="col-7 text-right pr-2">GST at @{{ values.job.gst }}%:</label>
                <label class="col-5">@{{ displayMoney(values.job.gst_amount) }}</label>
                <label class="col-7 text-right pr-2">Net Quote Price:</label>
                <label class="col-5">@{{ displayMoney(values.job.quote_price) }}</label>
              </div>
            </div>
          </div>
        </portlet-content>
      </div>
    </div>
  </div>
</div>
