<modal title="Search Installation Complaint" :is-large="false" v-if="modals.searchComplaint.show"
       @close="hideSearchModal">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="form-group col-lg-12">
        <div class="row">
          <span class="col-3 text-right">Store:</span>
          <drop-down
            class="col-8"
            :options="alteredSites"
            v-model="selectedSite"
            style="max-height: 40px;"
            :default-selected="alteredSites[0]"
          />
        </div>

        <div class="row" style="margin-top: 7px !important;">
          <span class="col-3 text-right">Complaint:</span>
          <drop-down
                  class="col-8"
                  ref="complaintSelect"
                  :options="complaints"
                  v-model="modals.searchComplaint.values.complaint"
                  placeholder="Select Installation Complaint"
                  label="id"
          >
            <template slot="singleLabel" slot-scope="{ data }">@{{ data.job_id }}  :@{{ data.job_trading_name }}, Re: @{{ data.project }} @{{ data.date_received }}</template>
            <template slot="option" slot-scope="{ data }"><span>@{{ data.job_id }} :@{{ data.job_trading_name }}, Re: @{{ data.project }} @{{ data.date_received }}</span></template>
          </drop-down>
        </div>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="hideSearchModal">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="searchComplaint"
    >Proceed
    </button>
  </template>
</modal>
