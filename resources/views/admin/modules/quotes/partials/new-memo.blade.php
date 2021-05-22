<modal title="Add memo" :is-large="false" v-if="modals.memo.show"
       @close="modals.memo.show=false">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-md-6">
        <label class="control-label">Date</label>
        <input type="date" class="form-control" v-model="modals.memo.values.date"/>
        <span class="form-error"
              v-if="form.errors.has('date')"
              v-text="form.errors.get('date')"></span>
      </div>
      <div class="col-md-6">
        <label class="control-label">Time</label>
        <input type="time" class="form-control" v-model="modals.memo.values.time"/>
        <span class="form-error"
              v-if="form.errors.has('time')"
              v-text="form.errors.get('time')"></span>
      </div>
      <div class="col-md-12 mt-3">
        <label class="control-label">Staff</label>

        <drop-down
                :class="{ 'input-error' : form.errors.has('selectedSales') }"
                :options="staffs"
                placeholder="Select Staff"
                v-model="modals.memo.values.user_id"
        />
        <span class="form-error"
              v-if="form.errors.has('user_id')"
             >Please select the staff.</span>
      </div>

      <div class="col-md-12 mt-3">
        <label class="control-label">Subject</label>
        <input type="text" class="form-control" v-model="modals.memo.values.subject"/>
        <span class="form-error"
              v-if="form.errors.has('subject')"
              v-text="form.errors.get('subject')"></span>
      </div>

      <div class="col-md-12 mt-3">
        <label class="control-label">Text</label>
        <textarea name="" id="" class="form-control h-80" v-model="modals.memo.values.details"></textarea>
        <span class="form-error"
              v-if="form.errors.has('details')"
              v-text="form.errors.get('details')"></span>
      </div>

      <div class="col-md-12 mt-3">
        <input type="checkbox" v-model="modals.memo.values.further_action"> Further Action Required<br>
      </div>

    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="modals.memo.show=false">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="createMemo"
    >Save
    </button>
  </template>
</modal>
