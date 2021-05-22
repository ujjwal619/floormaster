<modal title="Update to job" :is-large="true" v-if="modals.updateQuote.show"
       @close="modals.updateQuote.show=false">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="date" class="control-label">Enter Initiation Date</label>
          <input type="date" class="form-control" v-model="modals.updateQuote.values.initiation_date"/>
          <span class="form-error"
                v-if="form.errors.has('initiation_date')">* Please select initiation date.</span>
        </div>

      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="date" class="control-label">Existing Quote Number</label>
          <input type="text" value="{{ $quote->quote_id }}" class="form-control" disabled/>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="date" class="control-label">New Job No <input type="checkbox"
                                                                    @change="modals.updateQuote.values.job_id=quote.quote_id"/>
            Use
            Existing</label>
          <input type="text" class="form-control" v-model="modals.updateQuote.values.job_id"/>
          <span class="form-error"
                v-if="form.errors.has('job_id')">* Please provide job id.</span>
        </div>
      </div>
    </div>
    <br/>
    <div class="form-group m-form__group row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="date" class="control-label">Net Invoice $:</label>
          <input type="text" class="form-control" v-model="modals.updateQuote.values.invoice.net_value"/>
          <span class="form-error"
                v-if="form.errors.has('invoice.net_value')">* Please provide net value for invoice.</span>
        </div>

      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="date" class="control-label">Invoice Date:</label>
          <input type="date" class="form-control" v-model="modals.updateQuote.values.invoice.date"/>
          <span class="form-error"
                v-if="form.errors.has('invoice.date')">* Please provide date for invoice.</span>
        </div>
      </div>
    </div>
    <hr/>
    Auto Invoice Payment Receive <br/>
    <div class="form-group m-form__group row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="amount" class="control-label">Amount</label>
          <input type="text" class="form-control" v-model="modals.updateQuote.values.invoice.invoice_amount" required/>
        </div>

      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="receipt_date" class="control-label">Receipt Date:</label>
          <input type="date" class="form-control" v-model="modals.updateQuote.values.invoice.receipt_date"/>
        </div>
      </div>
    </div>
    <br/>
    <div class="form-group m-form__group row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="amount" class="control-label">Notation</label>
          <input type="text" class="form-control" v-model="modals.updateQuote.values.invoice.notation" required/>
        </div>
      </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="modals.updateQuote.show=false">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click.prevent="updateQuoteToJob"
    >Proceed
    </button>
  </template>
</modal>
