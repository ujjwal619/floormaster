<div class="form-container">
  <div class="col-12 row">
    <span class="col-lg-1 text-right h4">Store:</span>
    <input class="col-3 form-control" style="max-height: 40px;" v-if="isOldEntry" type="text" disabled :value="getSelectedSiteName">
    <drop-down
            v-else
            class="col-3"
            :options="sites"
            v-model="values.site_id"
            style="max-height: 40px;"
            :default-selected="sites[0]"
            @input="handleStoreChange"
    />
  </div>
  <div class="row">
    <div class="col-xsmall-12 col-small-12">
      <portlet-content isform="true" :onlybody="true">
        <template slot="body">
          <div class="m-portlet__body">
            <div class="form-group m-form__group row">
              <div class="col-xsmall-6">
                <div class="row">
                  <div class="col-small-1">
                    <label class="required">Terms Name</label>
                  </div>
                  <div class="col-small-11">
                    <input type="text"
                           :class="{ 'input-error' : form.errors.has('values.name'), 'form-control': loaded }"
                           v-model="values.name"
                    >
                    <span class="form-error"
                          v-if="form.errors.has('name')"
                          v-text="form.errors.get('name')"></span>
                  </div>
                </div>
              </div>
              <div class="col-xsmall-3">
                <div class="row">
                  <div class="col-small-3" style="background: black">
                    <label class="required" style="color: white">Due date calculated from</label>
                  </div>
                  <div class="col-small-9">
                    <input type="radio" name="calculated_from" value="completion" v-model="values.due.calculated_from">
                    100% completion <br> or <br/>
                    <input type="radio" name="calculated_from" value="date" v-model="values.due.calculated_from">
                    Invoice Date<br>
                  </div>
                </div>
              </div>
              <div class="col-xsmall-3">
                <div class="row">
                  <div class="col-small-12">
                    Due by
                    <input type="number"
                           min="0"
                           :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                           v-model="values.due.days"
                    > days after <br/>
                    <span class="form-error"
                          v-if="form.errors.has('due.days_after')"
                          >Please provide valid date. <br/></span>

                    <input type="radio" name="days_after" value="invoice_completion" v-model="values.due.days_after">
                    Invoice completion <br> or <br/>
                    <input type="radio" name="days_after" value="month_of_invocie" v-model="values.due.days_after">
                    Month of Invoice / Completion<br>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </portlet-content>
    </div>
  </div>

  <div class="row">
    {{--Left side: Quote terms and invocie terms --}}
    <div class="col-xsmall-12 col-small-8">
      <portlet-content isform="true" header="Quote Terms">
        <template slot="body">
          <div class="m-portlet__body">
            <div class="form-group m-form__group row">
              <div class="col-xsmall-12">
                <div class="row">
                  <div class="col-small-12">
                    <textarea type="text"
                              rows="10"
                              v-model="values.terms.quote"
                    >
                    </textarea>
                    <span class="form-error"
                          v-if="form.errors.has('terms.quote')"
                          v-text="form.errors.get('terms.quote')"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </portlet-content>

      <portlet-content isform="true" header="Invoice Terms">
        <template slot="body">
          <div class="m-portlet__body">
            <div class="form-group m-form__group row">
              <div class="col-xsmall-12">
                <div class="row">
                  <div class="col-small-12">
                    <textarea type="text"
                              rows="10"
                              name="company_name"
                              v-model="values.terms.invoice"
                    >
                    </textarea>
                    <span class="form-error"
                          v-if="form.errors.has('terms.invoice')"
                          v-text="form.errors.get('terms.invoice')"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </portlet-content>
    </div>

    {{--Right side: Minor things--}}
    <div class="col-xsmall-12 col-small-4">
      <portlet-content isform="true" :onlybody="true">
        <template slot="body">
          <div class="m-portlet__body">
            <div class="m-portlet__body">
              <div class="form-group m-form__group row">
                <div class="col-xsmall-12">
                  <div class="row">
                    <div class="col-small-3">
                      <label class="required">Deposit % required</label>
                    </div>
                    <div class="col-small-2">
                      <input type="text"
                             :class="{ 'input-error' : form.errors.has('metadata.deposit_required'), 'form-control': loaded }"
                             v-model="values.metadata.deposit_required"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('metadata.deposit_required')"
                            v-text="form.errors.get('metadata.deposit_required')"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </portlet-content>

      <portlet-content isform="true" :onlybody="true">
        <template slot="body">
          <div class="m-portlet__body">
            <div class="m-portlet__body">
              <div class="form-group m-form__group row">
                <div class="col-xsmall-12">
                  <div class="row">
                    <div class="m-checkbox-inline"><label><input type="checkbox"
                                                                 v-model="values.metadata.bills_direct_to_customer">
                        Installer bills direct to customer
                        <span></span></label></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </portlet-content>

      <portlet-content isform="true" :onlybody="true">
        <template slot="body">
          <div class="m-portlet__body">
            <div class="m-portlet__body">
              <div class="form-group m-form__group row">
                <div class="col-xsmall-12">
                  <div class="row">
                    <div class="m-checkbox-inline"><label><input type="checkbox" v-model="values.metadata.financed">
                        Financed
                        <span></span></label></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </portlet-content>


      <portlet-content isform="true" :onlybody="true" :height="450">
        <template slot="body">
          <div class="m-portlet__body">
            <div class="m-portlet__body">
              <div class="form-group m-form__group row">
                <div class="col-xsmall-12">
                  <div class="row">
                    <p>
                      Enter as many sets of terms as required these will be available from the add quote
                      or add job function. Type in your terms continuiously, the system will wrap 
                      world to the next line. The enter key to forces a paragraph break. Your terms
                      will print in a different font and will not format exactly as displayed on this screen.
              
                    </p>
                    <p>
                      Select how you want your due date calculated, enter the number of days 
                      that will add from either completion date or invoice date. This effect work
                      in progress of setting. Select weather you want the days added to the invoice or completion date
                      or the end of that month.
                    </p>
                    <p>
                      There are two printing options. Test by printing a quote and invoice.
                    </p>
                    <p>
                      Enter the deposite % required for this terms. This field effect your low deposit reports.
                    </p>
                    <p>
                      Tag the finance option if these jobs will be financed.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </portlet-content>
      
    </div>
  </div>

  <div class="col-xsmall-12 col-small-12">
    <portlet-content isform="true" :onlybody="true">
      <template slot="body">
        <button type="button" class="btn action-buttons" @click="openModal('SearchTerm')">Search</button>

        @if(request()->segment(3) === 'edit')
          <button 
            v-if="hasPermission('terms.access.add.terms')"
            type="button" 
            class="btn action-buttons" 
            href="/terms/create"
          >Add New Term</a>
        @endif
        <button 
          v-if="hasPermission('terms.access.edit.terms')"
          class="btn action-buttons" 
          @click.prevent="submit"
        >Save</button>
      </template>

    </portlet-content>
  </div>

  <template v-if="mountSearchTerm">
    <search-term
            :sites="sites"
            @selected="handleSelectedTerm"
            @close="closeModal('SearchTerm')"
    />
  </template>

</div>
