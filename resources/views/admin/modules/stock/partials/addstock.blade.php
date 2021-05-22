<modal :title="getTitle" :is-large="false" v-if="modals.addStock.show"
       @close="handleStockItemModalClose">
  <template slot="modal-body">
    <div class="form-group">
        <div class="col-lg-8">
            <div class="row pb-2" v-if="currentPageIndex < 3">
                <label class="col-lg-4" style="text-align: right">Supplier:</label>
                <label class="col-lg-8">@{{ supplier.trading_name }}</label>
            </div>
            <div class="row pb-2" v-if="currentPageIndex < 2">
                <label class="col-lg-4" style="text-align: right">Range:</label>
                <label class="col-lg-8">@{{ product.name }}</label>
            </div>
            <div class="row pb-2" v-if="currentPageIndex < 2">
                <label class="col-lg-4" style="text-align: right">Colour:</label>
                <label class="col-lg-8">@{{ color.name }}</label>
            </div>
        </div>
    </div>
    <component
      ref="dynamicComponent"
      :data="modals.addStock.values"
      :is="currentPage" 
      :stock-data="getPageData" 
      :supplier="supplier" 
      :product="product"
      :stock-list="newStock"
      :color="color"
      @updated:values="valuesUpdateHandler"
      @updated:stock-data="stockDataUpdateHandler"
      @add:new-item="addNewItemHandler"
    />
  </template>
  <template slot="modal-footer">
    <button
      v-if="isFirstPage" 
      type="button"
      class="btn action-buttons"
      @click="handleStockItemModalClose"
    >Cancel
    </button>
    <template v-else>
      <button 
        v-if="currentPageIndex !== 2"
        type="button"
        class="btn action-buttons"
        @click="goPrevPage"
      > < Back
      </button>
    </template>
    <button 
      v-if="!isLastPage"
      type="button"
      class="btn action-buttons"
      @click="goNextPageHandler"
    >Next >
    </button>
    <button 
      v-else
      type="button"
      class="btn action-buttons"
      @click="saveFutureStock"
    >Finish
    </button>
  </template>
  <loading :loading="loading" />
</modal>
