<modal :title="openingStockModalTitle" :is-large="true" v-if="modals.openingStock.show"
       @close="handleOpeningStockModalClose">
  <template slot="modal-body">
    <div class="form-group row">
        <div class="col-lg-5">
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">Dye/Batch:</label>
                <input class="col-lg-8 form-control" type="text" v-validate="'required'" name="batch" v-model="modals.openingStock.values.batch">
                <label class="error">@{{ errors.first('batch') }}</label>
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">Item/Roll No:</label>
                <input class="col-lg-8 form-control" type="text" v-validate="'required'" name="roll_no" v-model="modals.openingStock.values.roll_no">
                <label class="error">@{{ errors.first('roll_no') }}</label>
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">Size/Qty:</label>
                <input class="col-lg-8 form-control" type="number" v-validate="'required'" name="size" v-model="modals.openingStock.values.size" :disabled="isEditMode" >
                <label class="error">@{{ errors.first('size') }}</label>
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">Location:</label>
                <input class="col-lg-8 form-control" type="text" v-model="modals.openingStock.values.location"  >
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">NB:</label>
                <input class="col-lg-8 form-control" type="text" v-model="modals.openingStock.values.nb">
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">Supplier Inv #:</label>
                <input class="col-lg-8 form-control" type="text" v-model="modals.openingStock.values.supplier_inv_no">
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">List Price:</label>
                <input class="col-lg-8 form-control" type="number" v-model="modals.openingStock.values.unit_cost" :disabled="isEditMode">
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">Levy %:</label>
                <input class="col-lg-8 form-control" type="number" v-model="modals.openingStock.values.levy">
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">Sell @:</label>
                <input class="col-lg-8 form-control" type="number" v-model="modals.openingStock.values.selling_price">
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">Received Date:</label>
                <input class="col-lg-8 form-control" type="date" v-validate="'required'" name="received_date" v-model="modals.openingStock.values.received_date" :v-if="!isEditMode" >
                <label class="error">@{{ errors.first('received_date') }}</label>
            </div>
            <div class="row pb-2">
                <label class="col-lg-4" style="text-align: right">G.L. Date:</label>
                <input class="col-lg-8 form-control" type="date" v-validate="'required'" name="gl_date" v-model="modals.openingStock.values.gl_date" :v-if="!isEditMode" >
                <label class="error">@{{ errors.first('gl_date') }}</label>
            </div>
        </div>
        <div v-show="!isEditMode" class="col-lg-7 pl-3">
            <label>
                USE THIS PROCESS ONLY FOR OPENING STOCK <br/>
                Stock entered this way will create a single sided GL transaction. this will take your ledger out of balance. <br/>
                Stock Orders should be placed by using the Add button in the Future STock table of the product. 
                The purchase order is then updated as Received. <br/>
                Customer Orders are placed by using the 'ACT' button in their Job costing, then updated in the same way as Stock Orders.<br/>
                The Received Date is the age of the stock. G.L. Date determines the date used to transact the General Ledger. Both dates assume Today if blank. <br/>
            </label>
            <div class="mt-3">
                <label>This Batch </label>
                <textarea cols="8" rows="8" v-model="storedRolls" disabled >
                </textarea>
            </div>
        </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button
        type="button"
        class="btn action-buttons"
        @click="storeRoll"
        v-show="!isEditMode"
    >Store Roll
    </button>
    <button
        type="button"
        class="btn action-buttons"
        @click="saveCurrentStock"
    >Finished
    </button>
  </template>
</modal>
