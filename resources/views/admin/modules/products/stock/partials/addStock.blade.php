<modal title="Enter Opening Stock" :is-large="false" v-if="modals.addStock.show"
       @close="modals.addStock.show=false">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-lg-12">
        <div class="form-group">
          <label>Dye/Batch</label>
          <input type="text" v-model="values.batch" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('batch')"
                v-text="form.errors.get('batch')">
									</span>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="form-group">
          <label>Item/Roll no</label>
          <input type="text" v-model="values.roll_no" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('roll_no')"
                v-text="form.errors.get('roll_no')">
									</span>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="form-group">
          <label>Size</label>
          <input type="text" v-model="values.size" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('size')"
                v-text="form.errors.get('size')">
									</span>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="form-group">
          <label>Location</label>
          <input type="text" v-model="values.location" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('location')"
                v-text="form.errors.get('location')">
									</span>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="form-group">
          <label>NB</label>
          <input type="text" v-model="values.nb" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('nb')"
                v-text="form.errors.get('nb')">
									</span>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="form-group">
          <label>Supplier Inv #</label>
          <input type="text" v-model="values.supplier_inv_no" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('supplier_inv_no')"
                v-text="form.errors.get('supplier_inv_no')">
									</span>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="form-group">
          <label>Unit Cost</label>
          <input type="text" v-model="values.unit_cost" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('unit_cost')"
                v-text="form.errors.get('unit_cost')">
									</span>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="form-group">
          <label>Levy %</label>
          <input type="text" v-model="values.levy" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('levy')"
                v-text="form.errors.get('levy')">
									</span>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="form-group">
          <label>Sell @</label>
          <input type="text" v-model="values.selling_price" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('selling_price')"
                v-text="form.errors.get('selling_price')">
									</span>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="form-group">
          <label>Received Date</label>
          <input type="date" v-model="values.received_date" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('received_date')"
                v-text="form.errors.get('received_date')">
									</span>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="form-group">
          <label>GL Date</label>
          <input type="date" v-model="values.gl_date" class="form-control"/>
          <span class="form-error"
                v-if="form.errors.has('gl_date')"
                v-text="form.errors.get('gl_date')">
									</span>
        </div>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="modals.addStock.show=false">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="updateStock"
    >Submit
    </button>
  </template>
</modal>
