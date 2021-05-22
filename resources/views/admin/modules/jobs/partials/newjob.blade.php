<modal title="Add new job" :is-large="false" v-if="modals.newJob.show"
       @close="modals.newJob.show=false">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-lg-12">
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
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="modals.newJob.show=false">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="proceedJobCreatePage"
    >Proceed
    </button>
  </template>
</modal>
