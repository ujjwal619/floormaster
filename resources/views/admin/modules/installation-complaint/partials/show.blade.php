<div class="form-container">
  <div class="row">
    <div class="col-xsmall-12">
      <portlet-content onlybody isform="true">
        <template slot="body">
          <div class="m-portlet__body">
            <div class="form-group m-form__group">
              <div class="row">
                <div class="col-xsmall-4">
                  <p>
                    <span class="font-weight-bold">Name: </span>
                    <span style="color: blue">@{{ job.trading_name }}</span>
                  </p>
                  <p>
                    <span class="font-weight-bold">Street: </span>@{{ fullAddress }}
                  </p>
                  <p><span class="font-weight-bold">Project: </span>Re: @{{ job.project }}</p>
                  <h5>
                    <span class="font-weight-bold">Sales Rep: </span>
                    <u><b><i><span style="color: red;">@{{ getSalesPersonName }}</span></i></b></u>
                  </h5>
                </div>
                <div class="col-xsmall-8">
                  <div class="row">
                    <div class="col-small-6">
                      <div class="row">
                        <div class="col-small-3">
                          <label class="required">Date Reveived: </label>
                        </div>
                        <div class="col-small-9">
                          <input type="date"
                                 name="date_received"
                                 :class="{ 'input-error' : form.errors.has('date_received') }"
                                 class="form-control"
                                 v-model="values.date_received"
                          >
                          <span class="form-error"
                                v-if="form.errors.has('date_received')"
                                v-text="form.errors.get('date_received')"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-small-6">
                      <div class="row">
                        <div class="col-small-1">
                          <label class="required">Job: </label>
                        </div>
                        <div class="col-small-11">
                          <input type="text"
                                 name="job"
                                 class="form-control"
                                 disabled
                                 :value="job.job_id"
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-6">
                      <div class="row">
                        <div class="col-small-3">
                          <label class="required">Received by: </label>
                        </div>
                        <div class="col-small-9">
                          <input type="text"
                                 name="received_by"
                                 :class="{ 'input-error' : form.errors.has('received_by') }"
                                 class="form-control"
                                 v-model="values.received_by"
                          >
                          <span class="form-error"
                                v-if="form.errors.has('received_by')"
                                v-text="form.errors.get('received_by')"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-small-6">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group m-form__group row">
              <div class="col-xsmall-12">
                <label class="required">
                  <h5 style="color: darkblue;"><u><b><i>Complaint</i></b></u></h5>
                </label>
                <textarea
                        :class="{ 'input-error' : form.errors.has('complaint') }"
                        rows="3"
                        cols="30"
                        v-model="values.complaint"
                        placeholder="Complaint"
                >
                    </textarea>
              </div>
              <span class="form-error"
                    v-if="form.errors.has('complaint')"
                    v-text="form.errors.get('complaint')"></span>
            </div>
            <div class="form-group m-form__group row">
              <div class="col-xsmall-5 float-right">
                <div class="row">
                  <div class="col-small-2">
                    <label class="required">Referred To: </label>
                  </div>
                  <div class="col-small-6">
                    <input type="text"
                           name="referred_to"
                           :class="{ 'input-error' : form.errors.has('referred_to') }"
                           class="form-control"
                           v-model="values.referred_to"
                    >
                    <span class="form-error"
                          v-if="form.errors.has('referred_to')"
                          v-text="form.errors.get('referred_to')"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group m-form__group row">
              <div class="col-xsmall-12">
                <label class="required">
                  <h5 style="color: darkblue;"><u><b><i>Action</i></b></u></h5>
                </label>
                <textarea
                        :class="{ 'input-error' : form.errors.has('action') }"
                        rows="3"
                        cols="30"
                        v-model="values.action"
                        placeholder="Action">
									</textarea>
                <span class="form-error"
                      v-if="form.errors.has('action')"
                      v-text="form.errors.get('action')"></span>
              </div>
            </div>
            <div class="form-group m-form__group row">
              <div class="col-small-6">
                <div class="row">
                  <div class="col-small-2">
                    <label class="required">Date Rectified: </label>
                  </div>
                  <div class="col-small-6">
                    <input type="date"
                           name="date_rectified"
                           :class="{ 'input-error' : form.errors.has('date_rectified') }"
                           class="form-control"
                           v-model="values.date_rectified"
                    >
                    <span class="form-error"
                          v-if="form.errors.has('date_rectified')"
                          v-text="form.errors.get('date_rectified')"></span>
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
        <button type="button" @click="showSearchModal" class="btn action-buttons">Search</button>
        <button 
          v-if="hasPermission('customer.complaints.add.complaint')" 
          type="button" 
          @click="show" 
          class="btn action-buttons"
        >Add</button>
        <button
          v-if="isEdit && hasPermission('customer.complaints.delete.complaint')"
          type="button"
          @click="deleteComplaint"
          class="btn action-buttons"
        >
          Delete
        </button>
        <button 
          v-if="hasPermission('customer.complaints.edit.complaint')"
          class="btn action-buttons" 
          type="button" 
          @click="submit"
        >Save</button>
      </template>
    </portlet-content>
  </div>
  </form>

  @include('admin.modules.installation-complaint.partials.add')
  @include('admin.modules.installation-complaint.partials.search')
</div>

