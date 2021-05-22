<modal title="Add Installation Complaint" :is-large="false" v-if="modals.addComplaint.show"
       @close="hide">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="form-group col-lg-12">
        <div class="row">
          <span class="col-3 text-right">Store:</span>
          <drop-down
            class="col-8"
            :options="sites"
            v-model="selectedSiteAddComplaint"
            style="max-height: 40px;"
            :default-selected="sites[0]"
          />
        </div>
        <div class="row pt-3">
          <span class="col-3 text-right">Jobs:</span>
          <div class="col-lg-9">
            <drop-down
              ref="jobSelect"
              :options="jobs"
              v-model="selectedJob"
              placeholder="Select Job"
              label="job_id"
              name="job"
              v-validate="'required|numeric'"
            />
          </div>
          <label class="error pt-1">@{{ errors.first('job') }}</label>
        </div>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="hide">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="addComplaint"
    >Proceed
    </button>
  </template>
</modal>
