<div class="form-container">
  <div>
    <div class="col-12 row">
        <span class="col-lg-1 text-right h4">Store:</span>
        <input class="col-3 form-control" style="max-height: 40px;" v-if="isOldEntry" type="text" disabled :value="getSelectedSiteName">
        <drop-down
          v-else
          class="col-3"
          :options="sites"
          v-model="selectedSite"
          style="max-height: 40px;"
          :default-selected="sites[0]"
          @input="handleStoreChange"
        />
    </div>
    <div class="row px-2 pt-2">
      <portlet-content :height="400" :onlybody="true" class="col-12">
        <div slot="body" class="row p-2">
          <div class="col-5">
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">Title/Firstname </label>
              <input type="text" class="col-2 form-control" v-model="model.title" :disabled="!isEditMode">
              <input type="text" class="col-8 form-control" v-model="model.firstname" :disabled="!isEditMode">
            </div>
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">Surname/Co </label>
              <input type="text" class="col-10 text-danger form-control" v-model="model.trading_name" :disabled="!isEditMode">
            </div>
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">Street </label>
              <input type="text" class="col-10 form-control" v-model="model.address.street" :disabled="!isEditMode">
            </div>
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">Town </label>
              <input type="text" class="col-10 form-control" v-model="model.address.town" :disabled="!isEditMode">
            </div>
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">State/Code </label>
              <input type="text" class="col-3 form-control text-uppercase" :value="model.address.state" :disabled="!isEditMode" @focus="openModal('StateModal')">
              <input type="text" class="col-3 form-control" v-model="model.address.code" :disabled="!isEditMode">
            </div>
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">Attention </label>
              <input type="text" class="col-10 form-control" v-model="model.attention" :disabled="!isEditMode">
            </div>
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">Home Ph </label>
              <input type="text" class="col-4 form-control" v-model="model.phone" :disabled="!isEditMode">
              <label class="col-2 text-right pr-2">Mobile</label>
              <input type="text" class="col-4 form-control" v-model="model.mobile" :disabled="!isEditMode">
            </div>
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">Work Ph </label>
              <input type="text" class="col-4 form-control" v-model="model.work_phone" :disabled="!isEditMode">
              <label class="col-2 text-right pr-2">Fax</label>
              <input type="text" class="col-4 form-control" v-model="model.fax" :disabled="!isEditMode">
            </div>
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">Email </label>
              <input type="text" class="col-10 form-control" v-model="model.email" :disabled="!isEditMode">
            </div>
            <div class="row pt-2">
              <label class="col-2 text-right pr-2">Terms </label>
              <input type="text" class="col-1 form-control" v-model="term.id" @focus="openModal('TermsModal')" :disabled="!isEditMode">
              <input type="text" class="col-4 form-control" :value="term.name" disabled>
              <label class="col-2 text-right pr-2">Key No </label>
              <input type="text" class="col-3 form-control" v-model="model.key_no" :disabled="!isEditMode">
            </div>
          </div>
          <div class="col-7 px-4">
            <div class="row">
              <div class="col-2">
                <span class="background-black">Samples on Loan</span>
                <button type="Button" class="btn action-buttons" @click="openAddSampleLoan">Add >> </button>
              </div>
              <div class="col-10">
                <div class="row table-wrap px-2">
                  <table class="table">
                    <tbody>
                      <tr class="row col-12">
                        <td class="table-head col-6">&nbsp;</td>
                        <td class="table-head col-2">&nbsp;</td>
                        <td class="table-head col-2">Loan Date</td>
                        <td class="table-head col-2">Due Date</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="row table-wrap px-2" style="max-height: 161px;overflow-y: auto;">
                  <table class="table">
                    <tbody>
                      <tr class="row col-12">
                        <td class="col-6">
                          &nbsp;
                        </td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-6">
                          &nbsp;
                        </td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-6">
                          &nbsp;
                        </td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-6">
                          &nbsp;
                        </td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-6">
                          &nbsp;
                        </td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-6">
                          &nbsp;
                        </td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-6">
                          &nbsp;
                        </td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row pt-3">
              <div class="col-2">
                <span class="background-black">Sample Loan Deposits</span>
              </div>
              <div class="col-10">
                <div class="row table-wrap px-2">
                  <table class="table">
                    <tbody>
                      <tr class="row col-12">
                        <td class="table-head col-4">&nbsp;</td>
                        <td class="table-head col-2">&nbsp;</td>
                        <td class="table-head col-2">&nbsp;</td>
                        <td class="table-head col-2">&nbsp;</td>
                        <td class="table-head col-2">Due Date</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="row table-wrap px-2" style="max-height: 56px;overflow-y: auto;">
                  <table class="table">
                    <tbody>
                      <tr class="row col-12">
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                      <tr class="row col-12">
                        <td class="col-4">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                        <td class="col-2">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 row pt-3">
            <label class="col-1 text-right pr-1">Notes </label>
            <textarea class="col-11" cols="20" rows="2" v-model="model.notes" :disabled="!isEditMode"></textarea>
          </div>
        </div>
      </portlet-content>
    </div>
    <div class="row pt-2 px-2">
      <portlet-content :height="330" class="col-12" :onlybody="true">
        <div slot="body" class="p-2">
          <div class="row table-wrap px-2">
            <table class="table">
              <tbody>
                <tr class="row col-12">
                  <td class="table-head col-1">Job No</td>
                  <td class="table-head col-2">D I B C M P X</td>
                  <td class="table-head col-3">Project</td>
                  <td class="table-head col-1">Initiated</td>
                  <td class="table-head col-1">Quoted</td>
                  <td class="table-head col-1">Comp</td>
                  <td class="table-head col-1">Invoiced</td>
                  <td class="table-head col-1">Retention</td>
                  <td class="table-head col-1">Due</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row table-wrap px-2" style="max-height: 250px;overflow-y: auto; scrollbar-width: none;">
            <table class="table">
              <tbody>
                <tr class="row col-12" v-for="(job, key) in relatedJobs">
                  <td class="table-head col-1" @click="redirectToJob(job)">@{{ job.job_id }}</td>
                  <td class="table-head col-2">&nbsp;</td>
                  <td class="table-head col-3">@{{ job.project }}</td>
                  <td class="table-head col-1">@{{ formatViewDate(job.initiation_date) }}</td>
                  <td class="table-head col-1">@{{ displayMoney(job.gst_inclusive_quote) }}</td>
                  <td class="table-head col-1">@{{ formatViewDate(job.completed_on) }}</td>
                  <td class="table-head col-1 text-primary">@{{ displayMoney(job.invoiced) }}</td>
                  <td class="table-head col-1">@{{ displayMoney(job.unbilled_retention_amount) }}</td>
                  <td class="table-head col-1">@{{ displayMoney(job.balance) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row table-wrap px-2">
            <table class="table">
              <tbody>
                <tr class="row col-12">
                  <td class="table-head col-1">&nbsp;</td>
                  <td class="table-head col-2">
                    <button class="btn action-buttons" type="button">Status Key></button>
                  </td>
                  <td class="table-head col-3 text-primary">Click on a listing to go that Job</td>
                  <td class="table-head col-1 text-uppercase">Totals: </td>
                  <td class="table-head col-1">@{{ displayMoney(totalQuoted) }}</td>
                  <td class="table-head col-1">&nbsp;</td>
                  <td class="table-head col-1">@{{ displayMoney(totalInvoiced) }}</td>
                  <td class="table-head col-1">&nbsp;</td>
                  <td class="table-head col-1">@{{ displayMoney(totalBalance) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </portlet-content>
    </div>
  </div>
  <div class="col-21 mt-2">
    <portlet-content isform="true" :onlybody="true">
      <div slot="body" class="menu-bar d-flex justify-content-between">
        <div class="mt-1">
          <button 
            type="button" 
            class="btn action-buttons" 
            v-if="!isEditMode && hasPermission('client.access.edit.client')"
            @click="enableEdit"
          >Edit</button>
          <button 
            type="button" 
            class="btn action-buttons" 
            v-if="isEditMode" 
            @click="cancelEditMode"
          >Cancel</button>
          <button 
            type="button" 
            class="btn action-buttons" 
            v-if="isEditMode && hasPermission('client.access.edit.client')" 
            @click="saveHandler"
          >Save</button>
          <button 
            type="button" 
            class="btn action-buttons" 
            @click="openModal('SearchClient')"
          >Search</button>
          <button
            v-if="hasPermission('client.access.add.client')"
            type="button" 
            class="btn action-buttons" 
            @click="handleAddClient"
          >Add</button>
          <!-- <button type="button" class="btn action-buttons">Delete</button> -->
        </div>
        <span class="background-black text-truncate mr-3 my-1">
          Clients
        </span>
      </div>
    </portlet-content>
  </div>

  <template v-if="mountSampleLoan">
    <sample-loan 
      @close="closeAddSampleLoan"
    />
  </template>

  <template v-if="mountSearchClient">
    <search-client
      :sites="sites"
      @selected="handleSelectedClient"
      @close="closeModal('SearchClient')"
    />
  </template>
  <template v-if="mountStateModal">
    <state-modal
      @state="selectNewState"
      @close="closeModal('StateModal')"
    />
  </template>

  <template v-if="mountTermsModal && selectedSite">
    <terms-modal
            :site-id="selectedSite"
            :term-id="Number(model.term_id)"
            @term="handleTermUpdate"
            @close="closeModal('TermsModal')"
    />
  </template>
</div>
