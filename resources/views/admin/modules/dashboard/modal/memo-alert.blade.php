<modal title="Add new product category" :is-large="false" v-if="showModal" :has-header="false"
       @close="showModal=false">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      You have @{{ count  }} memos. Would you like to see it now ?
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="showModal=false">No
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="goToMemos"
            >Yes
    </button>
  </template>
</modal>
