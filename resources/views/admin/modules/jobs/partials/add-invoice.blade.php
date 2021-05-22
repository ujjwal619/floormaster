<modal title="Add invoice" :is-large="false" v-if="modals.invoice.show"
       @close="modals.invoice.show=false">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-md-12">
        <label class="control-label">Receipt Date</label>
        <input type="date" class="form-control" v-model="modals.invoice.values.date"/>
        <span class="form-error"
              v-if="form.errors.has('date')"
              v-text="form.errors.get('date')"></span>
      </div>

      <div class="col-md-12 mt-3">
        <label class="control-label">Type</label>
        <input type="text" class="form-control" v-model="modals.invoice.values.type"/>
        <span class="form-error"
              v-if="form.errors.has('type')"
              v-text="form.errors.get('type')"></span>
      </div>

      <div class="col-md-12 mt-3">
        <label class="control-label">Amount</label>
        <input type="number" min="1" class="form-control" v-model="modals.invoice.values.invoice_amount"/>
        <span class="form-error"
              v-if="form.errors.has('invoice_amount')"
              v-text="form.errors.get('invoice_amount')"></span>
      </div>

      <div class="col-md-12 mt-3">
        <label class="control-label">Notation</label>
        <input type="text" class="form-control" v-model="modals.invoice.values.notation"/>
        <span class="form-error"
              v-if="form.errors.has('notation')"
              v-text="form.errors.get('notation')"></span>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="modals.invoice.show=false">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="addNewInvoice"
    >Save
    </button>
  </template>
</modal>
