<modal title="Edit Sell Prices" :is-large="true" v-if="modals.sellPrice.show"
       @close="hideSellPriceModal">
  <template slot="modal-body">
    <div class="form-group">
      <div class="mb-5">
        <div class="row">
          <div class="col-lg-3">
            To clear a Sell Price type 0 (zero) in the appropriate GST Sell @ box.
          </div>
          <div class="col-lg-9">
            <div class="mb-4">
              <div class="row border">
                <p>Current GST Trade Sell: $@{{ Number(gstTradeSell).toFixed(2) }} with $@{{ Number(netTradeSell).toFixed(2) }}.. margin and @{{ Number(gpTrade).toFixed(2) }}% GP.</p>
                <span class="float-right">Whole Dollars only <input type="checkbox" v-model="product.trade_sell.whole"/> </span>
                <div class="row">
                  <div class="col-lg-4">
                    <code>Either</code>GST Sell @: <input type="number" class="form-control" v-model="product.trade_sell.gst_sell"/>
                  </div>
                  <div class="col-lg-4">
                    <code>Or</code>Add $: <input type="number" class="form-control" v-model="product.trade_sell.add_dollar"/>
                  </div>
                  <div class="col-lg-4">
                    <code>Or</code>Add %: <input type="number" class="form-control" v-model="product.trade_sell.add_percent"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="row border">
              <p>Current GST Retail Sell: $@{{ Number(gstRetailSell).toFixed(2) }} with $@{{ Number(netRetailSell).toFixed(2) }}.. margin and @{{ Number(gpRetail).toFixed(2) }}% GP.</p>
              <span class="text-right row">Whole Dollars only <input type="checkbox" v-model="product.retail_sell.whole"/> </span>
              <div class="row">
                <div class="col-lg-4">
                  <code>Either</code>GST Sell @: <input type="number" class="form-control" v-model="product.retail_sell.gst_sell"/>
                </div>
                <div class="col-lg-4">
                  <code>Or</code>Add $: <input type="number" class="form-control" v-model="product.retail_sell.add_dollar"/>
                </div>
                <div class="col-lg-4">
                  <code>Or</code>Add %: <input type="number" class="form-control" v-model="product.retail_sell.add_percent"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row border">
        {{--<p>Current GST Installed: $@{{ Number(gstInstalledSell).toFixed(2) }} with $@{{ Number(netSumInstalledSell).toFixed(2) }}.. margin and @{{ Number(gpInstalled).toFixed(2)}}% GP.</p>--}}
        <div class="col-lg-12">
          <div class="col-lg-6">
            <div class="col-lg-12">
              Whole Dollars only <input type="checkbox" v-model="product.installed.whole"/>
            </div>
            <div class="col-lg-12 mb-2">
              <div class="row">
                <div class="col-lg-5">
                  Extra Materials:
                </div>
                <div class="col-lg-4">
                  <input type="number" class="form-control" v-model="product.installed.extra_materials"/>
                </div>
              </div>
            </div>
            <div class="col-lg-12 mb-2">
              <div class="row">
                <div class="col-lg-5">
                  Labours:
                </div>
                <div class="col-lg-4">
                  <input type="number" class="form-control" v-model="product.installed.labours"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6"></div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-3">
              Other: <input type="number" class="form-control" v-model="product.installed.other"/>
            </div>
            <div class="col-lg-3">
              <code>Either</code>GST Sell @: <input type="number" class="form-control" v-model="product.installed.gst_sell"/>
            </div>
            <div class="col-lg-3">
              <code>Or</code>Add $: <input type="number" class="form-control" v-model="product.installed.add_dollar"/>
            </div>
            <div class="col-lg-3">
              <code>Or</code>Add %: <input type="number" class="form-control" v-model="product.installed.add_percent"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="hideSellPriceModal">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="calculateAndHide"
    >Proceed
    </button>
  </template>
</modal>
