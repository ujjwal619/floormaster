<modal title="Search Stock" :is-large="false" v-if="modals.search.show"
       @close="hideSearchModal">
  <template>
    <loading :loading="loading" />
  </template>
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="form-group col-lg-12">
        <div class="row">
          <div class="col-lg-9">
            <drop-down
                    ref="site"
                    :options="sites"
                    v-model="selectedSite"
                    placeholder="Select Site"
                    label="name"
            >
            </drop-down>
          </div>
        </div>
      </div>
    </div><br>
    <div class="form-group m-form__group row">
      <div class="form-group col-lg-12">
        <div class="row">
          <div class="col-lg-9">
            <drop-down
                    ref="supplier"
                    :options="suppliersList"
                    v-model="selectedSupplier"
                    placeholder="Select Supplier"
                    label="trading_name"
            >
            </drop-down>
          </div>
        </div>
      </div>
    </div><br>
    <div class="form-group m-form__group row">
      <div class="form-group col-lg-12">
        <div class="row">
          <div class="col-lg-9">
            <drop-down
                    ref="productSelect"
                    :options="productsList"
                    v-model="selectedProduct"
                    placeholder="Select Product"
                    label="name"
            >
            </drop-down>
          </div>
        </div>
      </div>
    </div><br>
    <div class="form-group m-form__group row">
      <div class="form-group col-lg-12">
        <div class="row">
          <div class="col-lg-9">
            <drop-down
                    ref="colorSelect"
                    :options="colorsList"
                    v-model="modals.search.values.color"
                    placeholder="Select Color"
                    label="name"
            >
            </drop-down>
          </div>
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
            @click="searchStock"
    >Proceed
    </button>
  </template>
</modal>
