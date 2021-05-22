<modal title="Search Supplier" :is-large="false" v-if="modals.searchSupplier.show"
       @close="hideSearchModal">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="form-group col-lg-12">
        <div class="row">
          <div class="col-lg-9">
            <drop-down
                    ref="supplierSelect"
                    :options="suppliers"
                    v-model="modals.searchSupplier.values.supplier"
                    placeholder="Select Supplier"
                    label="trading_name"
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
            @click="searchSupplier"
    >Proceed
    </button>
  </template>
</modal>
