<div class="form-container">
  <template>
  <loading :loading="loading" /></template>
  <div class="row" v-show="page===1">
    @include('admin.modules.quotes.partials.page_1')
  </div>
  <div class="row" v-show="page===2">
    @include('admin.modules.quotes.partials.page_2')
  </div>

  <template v-if="mountProductModal">
    <select-product
      :site-id="Object.keys(site).length ? site.id : selectedSite.id"
      :pre-selected-variants="selectedVariantIds"
      @close="closeProductModal"
      @product="handleProductAdd"
    />
  </template>

  <template v-if="mountEditMaterialProduct">
    <edit-material-product
      :is-extra-field="false"
      :material-product="selectedMaterialProduct"
      @close="closeModal('EditMaterialProduct')"
      @product="handleMaterialProductEdit"
    />
  </template>
  <template v-if="mountEditLabourProduct">
    <edit-labour-product
      :is-extra-field="true"
      :labour-product="selectedLabourProduct"
      @close="closeModal('EditLabourProduct')"
      @product="handleLabourProductEdit"
    />
  </template>

  <template v-if="mountForceQuote">
    <force-quote
      :current-price="materialLabourCostTotal"
      :inclusive-price="values.quote.gst_inclusive_quote"
      @close="closeModal('ForceQuote')"
      @forced="handleForcedPrice"
    />
  </template>

  <template v-if="mountTermsModal && site.id">
    <terms-modal
      :site-id="site.id"
      :term-id="Number(values.quote.term.id)"
      @term="handleTermUpdate"
      @close="closeModal('TermsModal')"
    />
  </template>

  <template v-if="mountStaffModal">
    <staff-modal
      :store-id="Object.keys(site).length ? site.id : selectedSite.id"
      :staff="selectedStaff"
      @saved="addSalesStaff"
      @updated="updateSalesStaff"
      @close="closeStaffModalHandler"
    />
  </template>

  <template v-if="mountSearchQuote">
    <search-quote
      @close="closeSearchQuote"
    />
  </template>

  <template v-if="mountAddMemo">
    <add-memo
      :site-id="quote.site_id"
      :quote="quote"
      :selected-memo="selectedMemoForEdit"
      @saved="memoSaved"
      @close="closeAddMemoModal"
    />
  </template>

  <template v-if="mountQuoteModal">
    <quote-modal
      :customers="customers"
      :templates="templates"
      @close="closeQuoteModal"
      @quotedata="addQuoteData"
    />
  </template>

  <template v-if="mountStateModal">
    <state-modal
      @state="selectNewState"
      @close="closeModal('StateModal')"
    />
  </template>

  <div class="row pt-2">
    <div class="col-xsmall-12 col-small-12">
      <portlet-content isform="true" :onlybody="true">
        <template slot="body">
          @if(request()->segment(2) === 'create')
            <button type="button" class="btn action-buttons" @click="openQuoteModal">Add</button>
          @endif
          <button 
            type="button" 
            class="btn action-buttons" 
            @click="openSearchQuote"
          >Search</button>
          <button 
            v-if="hasPermission('quote.access.edit.screen.1') && hasPermission('quote.access.edit.costing')"
            class="btn action-buttons" 
            @click="submit"
          >Save</button>
          @if(request()->segment(3) === 'edit')
            @can('quote.access.add.quote')
            <a 
              class="btn action-buttons" 
              href="/quotes/create"
            >New Quote</a>
            @endcan
            @can('quote.access.update.quote')
            <button 
                type="button" 
                class="btn action-buttons" 
                @click="openUpdateQuoteModal"
              >Update
            </button>
            @endcan
            @can('quote.access.delete.quote')
            <button 
                type="button" 
                class="btn action-buttons" 
                @click="deleteQuote"
              >Delete
            </button>
            @endcan
            <button type="button" class="btn action-buttons" @click="mediaButton('prev')">< Prev</button>
            <button type="button" class="btn action-buttons" @click="mediaButton('next')">Next ></button>
          @endif
          <button type="button" class="btn action-buttons" @click.prevent="page = 1" :class="{ currentPage : page=== 1}">
            1
          </button>
          <button type="button" class="btn action-buttons" @click.prevent="page = 2" :class="{ currentPage : page=== 2}">
            2
          </button>
        </template>
      </portlet-content>
    </div>
  </div>
  @if(request()->segment(3) === 'edit')
    <template v-if="mountUpdateQuoteModal">
      <update-quote-modal
        :quote="quote"
        @close="closeUpdateQuoteModal"
      />
    </template>
    @include('admin.modules.quotes.partials.newquote')
    @include('admin.modules.quotes.partials.new-memo')
    @include('admin.modules.quotes.partials.update_quote_to_job')
    @include('admin.modules.booking.partials.addbooking')
  @endif
</div>
