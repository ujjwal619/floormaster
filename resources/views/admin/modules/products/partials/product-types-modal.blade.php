<modal title="Create Product" :is-large="false" v-if="modals.productTypes.show"
       @close="hideModal('productTypes')">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-lg-12">
        <label class="required">
          Select Product Type
        </label>
        <select v-model="productType" class="form-control">
          <option value="">Select Product Type</option>
          @foreach($productTypes as $productType)
            <option value="{{ $productType }}">{{ strtoupper($productType) }}</option>
            @endforeach
        </select>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="hideModal('productTypes')">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="proceedToCreateProduct"
            :disabled="modals.productTypes.disableSave">Proceed
    </button>
  </template>
</modal>
