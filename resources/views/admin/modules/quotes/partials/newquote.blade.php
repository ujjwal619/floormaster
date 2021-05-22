<modal title="Add new quote" :is-large="false" v-if="modals.newQuote.show"
       @close="modals.newQuote.show=false">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-lg-12">
        <div class="form-group">
          <label>Quote creation method</label>
          <select @change="handleQuoteCreation(modals.newQuote.method)" v-model="modals.newQuote.method">
            <option value="">Please select</option>
            <option value="copy_from_current">Copy job: </option>
            <option value="choose_from_client">Select from client list</option>
            <option value="manual">Manual Detail Entry</option>
          </select>
        </div>
        <div class="form-group mt-3" v-if="modals.newQuote.showClients">
          <label>Choose Client</label>
          <select v-model="modals.newQuote.client_id" @change="getQuoteIdFromClient(modals.newQuote.client_id)">
            <option value="">Please select</option>
            <option v-for="(customer, key) in customers" :value="key"
            >
              @{{ customer.name }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label>Select Templates</label>
          <drop-down
                  :options="templates"
                  v-model="values.selectedTemplates"
                  :multiple="true"
                  placeholder="Select templates"
                  :close-on-select="false"
          />
        </div>
        <div class="form-group mt-3">
          <input type="checkbox" v-model="modals.newQuote.isBatch"> Batch<br>
        </div>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="modals.newQuote.show=false">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="proceedQuoteCreatePage"
    >Proceed
    </button>
  </template>
</modal>
