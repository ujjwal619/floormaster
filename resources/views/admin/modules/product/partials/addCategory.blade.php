<modal :title="productCategoryTitle" :is-large="false" v-if="modals.category.show"
       @close="hideCategoryModal">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-lg-12">
        <div class="form-group">
          <label class="control-label">Store: </label>
          <label class="text-bold" v-if="modals.category.values.site_name">@{{ modals.category.values.site_name }}</label>
          <template v-else>
            <drop-down
              class="pb-2"
              :options="sites"
              v-model="categorySiteId"
              style="max-height: 40px;"
              v-validate="'required'"
              name="store"
            />
          </template>
        </div>
        <label class="error">@{{ errors.first('store') }}</label>
        <div class="form-group pt-2">
          <label class="control-label">Category Name: </label>
          <input 
            type="text" 
            class="form-control" 
            v-model="modals.category.values.title"
            v-validate="'required'"
            name="category name"
          />
          <!-- <span class="form-error"
                v-if="form.errors.has('title')"
                v-text="form.errors.get('title')"></span> -->
          <label class="error">@{{ errors.first('category name') }}</label>
        </div>
        <div class="form-group">
          <label class="control-label">Inventory Account: </label>
          <drop-down
                  class="pb-2"
                  :options="accounts"
                  :default-selected="defaultCategoryInventoryAccount"
                  v-model="categoryInventoryAccountId"
                  style="max-height: 40px;"
                  v-validate="'required'"
                  name="inventory account"
          />
        </div>
        <label class="error">@{{ errors.first('inventory account') }}</label>
        <div class="form-group">
          <label class="control-label">C.O.S Account: </label>
          <drop-down
                  class="pb-2"
                  :options="accounts"
                  :default-selected="defaultCategoryCosAccount"
                  v-model="categoryCOSAccountId"
                  style="max-height: 40px;"
                  v-validate="'required'"
                  name="c.o.s. account"
          />
        </div>
        <label class="error">@{{ errors.first('c.o.s. account') }}</label>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            v-if="modals.category.isEdit"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="removeCategory()"
    >Remove
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="hideCategoryModal">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="saveCategory"
    >Proceed
    </button>
  </template>
</modal>
