<div class="form-container">
  <div class="col-xsmall-12 col-small-12">
    <div class="row">
      <h3 class="col-2" style="color: yellow">@{{ selectedSupplier.trading_name }}</h3>
      <h3 class="col-3" style="color: yellow"></h3>
      <h3 class="col-2" style="color: yellow">@{{ selectedSupplier.site.name }}</h3>
      <h3 class="col-2" style="color: yellow"></h3>
      <h3 class="col-2" style="color: yellow"></h3>
      <h3 class="col-1" style="color: yellow">@{{ selectedSupplier.id }}</h3>
    </div>

    <div class="table-wrap">
      <portlet-content :onlybody="true" :height="460">
        <template slot="body">
          <div class="col-xsmall-12" style="max-height: 450px;overflow-y: scroll;">
            <table class="">
              <thead>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="border-left border-right border-top font-weight-bold" colspan="3">Trade</td>
                <td class="border-left border-right border-top font-weight-bold" colspan="3">Retail</td>
                <td class="border-left border-right border-top font-weight-bold" colspan="3">Installed</td>
                <td></td>
              </tr>
              <tr>
                <td style="width: 10%">UPC</td>
                <td style="width: 15%">Supplier's Range Name</td>
                <td style="width: 15%">Your Alias (if applicable)</td>
                <td style="width: 5%">List</td>
                <td style="width: 5%" class="border-left">Net Sell</td>
                <td style="width: 5%">with GST</td>
                <td style="width: 5%" class="border-right">Margin</td>
                <td style="width: 5%;" class="border-left">Net Sell</td>
                <td style="width: 5%">with GST</td>
                <td style="width: 5%" class="border-right">Margin</td>
                <td style="width: 5%" class="border-left">Net Sell</td>
                <td style="width: 5%">with GST</td>
                <td style="width: 5%" class="border-right">Margin</td>
                <td style="width: 10%">Actions</td>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(product, index) in products" :key="product.id">
                <td>@{{ selectedSupplier.id }} - @{{ product.upc || product.id }}</td>
                <td>@{{ product.name }}</td>
                <td>@{{ product.alias }}</td>
                <td>@{{ product.list_cost }}</td>
                <td
                    :class="{ 'border-bottom': isLastRow(index) }"
                    class="border-left">
                  $@{{ isEmpty(product.trade_sell) ? 0 : product.trade_sell.net_sell }}
                </td>
                <td
                    :class="{ 'border-bottom': isLastRow(index) }">
                  $@{{ isEmpty(product.trade_sell) ? 0 : Number(product.trade_sell.with_gst).toFixed(2) }}</td>
                <td
                    :class="{ 'border-bottom': isLastRow(index) }"
                    class="border-right">
                  $@{{ isEmpty(product.trade_sell) ? 0 : Number(product.trade_sell.margin).toFixed(2) }}</td>
                <td
                    :class="{ 'border-bottom': isLastRow(index) }"
                    class="border-left">
                  $@{{ isEmpty(product.retail_sell) ? 0 : Number(product.retail_sell.net_sell).toFixed(2) }}</td>
                <td
                    :class="{ 'border-bottom': isLastRow(index) }">
                  $@{{ isEmpty(product.retail_sell) ? 0 : Number(product.retail_sell.with_gst).toFixed(2) }}</td>
                <td
                    :class="{ 'border-bottom': isLastRow(index) }"
                    class="border-right">
                  $@{{ isEmpty(product.retail_sell) ? 0 : Number(product.retail_sell.margin).toFixed(2) }}</td>
                <td
                    :class="{ 'border-bottom': isLastRow(index) }"
                    class="border-left">
                  $@{{ isEmpty(product.installed) ? 0 : Number(product.installed.net_sell).toFixed(2) }}</td>
                <td
                    :class="{ 'border-bottom': isLastRow(index) }">
                  $@{{ isEmpty(product.installed) ? 0 : Number(product.installed.with_gst).toFixed(2) }}</td>
                <td
                    class="border-right"
                    :class="{ 'border-bottom': isLastRow(index) }">
                  $@{{ isEmpty(product.installed) ? 0 : Number(product.installed.margin).toFixed(2) }}</td>
                <td>
                  <a type="button" :href="getProductEditUrl(product.id)" class="btn">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <button 
                    v-if="isUsersSite"
                    type="button" 
                    @click="deleteProduct(product.id)" 
                    class="btn">
                    <i class="fa fa-close"></i>
                  </button>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </template>
      </portlet-content>
    </div>
  </div>

  <div class="col-xsmall-12 col-small-12">
    <portlet-content isform="true" :onlybody="true">
      <template slot="body">
        <button type="button" class="btn action-buttons" @click="openModal('SearchSupplier')">Choose Supplier</button>
        <button 
          v-if="isUsersSite"
          type="button" 
          @click="redirectToAddProduct" 
          class="btn action-buttons"
        >Add Product
        </button>
        <button type="button" @click="openAddCategoryModal" class="btn action-buttons">Add Category</button>
        <button type="button" @click="showSearchCategoryModal($options.CATEGORY_OPTIONS.UPDATE)" class="btn action-buttons">Update Category</button>
      </template>
    </portlet-content>
  </div>

  @include('admin.modules.product.partials.addCategory')
  <template v-if="mountSearchSupplier">
    <search-supplier
            :sites="shareSites"
            @selected="handleSelectedSupplier"
            @close="closeModal('SearchSupplier')"
    />
  </template>
  @include('admin.modules.product.partials.searchcategory')
</div>
