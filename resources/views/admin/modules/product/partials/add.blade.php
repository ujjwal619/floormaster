<div class="form-container">
  <div class="row" v-show="isEdit">
    <h3 class="col-2" style="color: yellow">@{{ selectedSupplier.trading_name }}</h3>
    <h3 class="col-9 text-center" style="color: yellow">@{{ product.name }}</h3>
    <h3 class="col-1" style="color: yellow">@{{ selectedSupplier.id }}</h3>
  </div>
  <div class="row">
    <div class="col-xsmall-6">
      <div class="row">
        <div class="col-xsmall-12 ">
          <portlet-content :onlybody="true">
            <template slot="body">
              <div class="form-group m-form__group row">
                <div class="col-xsmall-12 col-small-12">
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">Store:</label>
                    </div>
                    <div class="col-small-8">
                      <b>@{{ selectedSupplier.site.name }}</b>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label>Supplier:</label>
                    </div>
                    <div class="col-small-9">
                      <b>@{{ selectedSupplier.trading_name }}</b>
                      <!-- <drop-down
                              :options="suppliersSiteWise"
                              v-model="product.supplier_id"
                              placeholder="Select Supplier"
                              :default-selected="getSupplierById(selectedProduct.supplier_id)"
                              label="trading_name"
                      /> -->
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">Range Name:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="text"
                             :class="{ 'input-error' : form.errors.has('name'), 'form-control': loaded }"
                             v-model="product.name"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('name')"
                            v-text="form.errors.get('name')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label>Category:</label>
                    </div>
                    <div class="col-small-9">
                      <drop-down
                              :options="categories"
                              v-model="product.category_id"
                              placeholder="Select Category"
                              :default-selected="getCategoryById(selectedProduct.category_id)"
                              label="title"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">UPC:</label>
                    </div>
                    <div class="col-small-9">
                      <div class="row">
                        <div class="col-small-1">
                          <span>@{{ product.supplier_id }} - </span>
                        </div>
                        <div class="col-small-11">
                          <input type="number"
                                 :class="{ 'input-error' : form.errors.has('upc'), 'form-control': loaded }"
                                 v-model="product.upc"
                          >
                        </div>
                      </div>
                      <span class="form-error"
                            v-if="form.errors.has('upc')"
                            v-text="form.errors.get('upc')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">Alias:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="text"
                             :class="{ 'input-error' : form.errors.has('alias'), 'form-control': loaded }"
                             v-model="product.alias"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('alias')"
                            v-text="form.errors.get('alias')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">Price Base:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="text"
                             :class="{ 'input-error' : form.errors.has('price_base'), 'form-control': loaded }"
                             v-model="product.price_base"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('price_base')"
                            v-text="form.errors.get('price_base')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">List Cost:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="number"
                             :class="{ 'input-error' : form.errors.has('list_cost'), 'form-control': loaded }"
                             v-model="product.list_cost"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('list_cost')"
                            v-text="form.errors.get('list_cost')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">Discount:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="number"
                             :class="{ 'input-error' : form.errors.has('discount'), 'form-control': loaded }"
                             v-model="product.discount"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('discount')"
                            v-text="form.errors.get('discount')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">Levy:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="number"
                             :class="{ 'input-error' : form.errors.has('levy'), 'form-control': loaded }"
                             v-model="product.levy"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('levy')"
                            v-text="form.errors.get('levy')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">Net Cost:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="number"
                             disabled
                             :class="{ 'input-error' : form.errors.has('net_cost'), 'form-control': loaded }"
                             v-model="product.net_cost"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('net_cost')"
                            v-text="form.errors.get('net_cost')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">GST:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="number"
                             :class="{ 'input-error' : form.errors.has('gst'), 'form-control': loaded }"
                             v-model="product.gst"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('gst')"
                            v-text="form.errors.get('gst')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">Width:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="number"
                             step="0.1"
                             :class="{ 'input-error' : form.errors.has('width'), 'form-control': loaded }"
                             v-model="product.width"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('width')"
                            v-text="form.errors.get('width')"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-small-2">
                      <label class="required">Unit:</label>
                    </div>
                    <div class="col-small-9">
                      <input type="text"
                             :class="{ 'input-error' : form.errors.has('unit'), 'form-control': loaded }"
                             v-model="product.unit"
                      >
                      <span class="form-error"
                            v-if="form.errors.has('unit')"
                            v-text="form.errors.get('unit')"></span>
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </portlet-content>
        </div>
      </div>
    </div>
    <div class="col-xsmall-6">
      <div class="col-xsmall-12 table-wrap">
        <portlet-content :onlybody="true" isform="true" :height="380">
          <template slot="body">
            <div class="row p-2">
              <span class="col-2 background-black mr-3">
                  Colorways
              </span>  
              <button
                  class="btn btn-primary btn-sm col-2"
                  @click="mountAddColor = true"
                >
                  Add>>
              </button>
            </div>
            <hr/>
            <div class="row pl-3">
              <div 
                class="col-3" 
                v-for="(variant, index) in variants" 
                :key="index"
                @click="openVariantEditModal(variant, index)"
              >
                @{{ variant.name }}
              </div>
            </div>
          </template>
        </portlet-content>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xsmall-6">
      <portlet-content header="Sell Prices" subheader="Details" isform="true">
          <template slot="body">
            <button style="background: transparent;" @click="showSellPriceModal">
              <table>
                <thead>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Net Sell</td>
                  <td>with GST</td>
                  <td>Margin</td>
                  <td>GP%</td>
                  <td>Price achived by...</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td>Trade</td>
                  <td>$@{{ Number(netTradeSell).toFixed(2) }}</td>
                  <td>$@{{ Number(gstTradeSell).toFixed(2) }}</td>
                  <td>$@{{ Number(tradeMargin).toFixed(2) }}</td>
                  <td>@{{ Number(gpTrade).toFixed() }}%</td>
                  <td v-if="productTradeSell.gst_sell">Nominated Sell Price</td>
                  <td v-if="productTradeSell.add_dollar">Marked up $@{{ Number(tradeMargin).toFixed(2) }}</td>
                  <td v-if="productTradeSell.add_percent">Marked up @{{ productTradeSell.add_percent }}%</td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td>R.R.P.</td>
                  <td>$@{{ Number(netRetailSell).toFixed(2) }}</td>
                  <td>$@{{ Number(gstRetailSell).toFixed(2) }}</td>
                  <td>$@{{ Number(retailMargin).toFixed(2) }}</td>
                  <td>@{{ Number(gpRetail).toFixed() }}%</td>
                  <td v-if="productRetailSell.gst_sell">Nominated Sell Price</td>
                  <td v-if="productRetailSell.add_dollar">Marked up $@{{ Number(retailMargin).toFixed(2) }}</td>
                  <td v-if="productRetailSell.add_percent">Marked up @{{ productRetailSell.add_percent }}%</td>
                </tr>
                </tbody>
                <thead>
                <tr>
                  <td>Installed Materials</td>
                  <td>Labour</td>
                  <td>Other</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>$@{{ installedExtraMaterials }}</td>
                  <td>$@{{ installedLabours }}</td>
                  <td>$@{{ installedOther }}</td>
                  <td>$@{{ Number(netInstalledSell).toFixed(2) }}</td>
                  <td>$@{{ Number(gstInstalledSell).toFixed(2) }}</td>
                  <td>$@{{ Number(installedMargin).toFixed(2) }}</td>
                  <td>@{{ Number(gpInstalled).toFixed() }}%</td>
                  <td v-if="productInstalledSell.gst_sell">Nominated Sell Price</td>
                  <td v-if="productInstalledSell.add_dollar">Marked up $@{{ Number(installedMargin).toFixed(2) }}</td>
                  <td v-if="productInstalledSell.add_percent">Marked up @{{ productInstalledSell.add_percent }}%</td>
                </tr>
                </tbody>
              </table>
            </button>

            <p>
              <input type="checkbox" v-model="product.act_on_me"><span style="color: red;"> Act On Me</span>
              <input type="checkbox" v-model="product.non_product"><span style="color: red;"> Non Product</span>
            </p>
            <input type="checkbox" v-model="product.exclude_from_report"><span style="color: red;"> Exclude from Reports</span>
          </template>
        </portlet-content>
    </div>
  </div>
  <div class="row">
    <div class="col-xsmall-12 col-small-12">
      <button class="btn btn-success pull-right" @click="saveProduct">Save</button>
      <a class="btn btn-success pull-right mr-3" @click="handleCancel">Cancel</a>
    </div>
  </div>
  @include('admin.modules.product.partials.sellPrice')
  <template v-if="mountAddColor">
      <add-color
        :selected-color="selectedVariant"
        :product="selectedProduct"
        :supplier="selectedSupplier"
        :colors="variants"
        @close="closeAddColorModal"
        @finished="savingColorFinished"
      />
    </template>
</div>
