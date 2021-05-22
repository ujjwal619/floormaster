<modal title="Update Category" :is-large="false" v-if="modals.searchCategory.show"
       @close="modals.searchCategory.show=false">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="form-group col-lg-12">
        <div class="row">
          <div class="col-lg-9">
          <label>Store:</label>
            <drop-down
                    :options="sites"
                    v-model="modals.searchCategory.values.site_id"
                    placeholder="Select Site"
            />
          </div>
        </div>
        <div class="row pt-3">
          <div class="col-lg-9">
            <label>Category:</label>
            <drop-down
                    :options="categories"
                    v-model="modals.searchCategory.values.category_id"
                    placeholder="Select Category"
                    label="title"
            />
          </div>
        </div>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="modals.searchCategory.show=false">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="searchCategory"
    >Proceed
    </button>
  </template>
</modal>
