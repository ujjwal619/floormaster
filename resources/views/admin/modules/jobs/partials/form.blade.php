<div class="form-container">
	<div class="row" v-show="page===1">
		@include('admin.modules.jobs.partials.page_1')
	</div>
	<div class="row" v-show="page===2">
		@include('admin.modules.jobs.partials.page_2')
	</div>
	<div class="row" v-show="page===3">
		@include('admin.modules.jobs.partials.page_3')
	</div>

	<!-- <div class="row">
		<div class="col-xsmall-12 col-small-12 d-flex justify-content-end">
			<button class="btn btn-success" @click="submit" >Save</button>
		</div>
	</div> -->

	<template v-if="mountProductModal">
    <select-product
      :site-id="Object.keys(site).length ? site.id : selectedSite.id"
      :is-stock-data-needed="true"
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

	<template v-if="mountForceJob">
    <force-job
      :current-price="materialLabourCostTotal"
      :inclusive-price="values.job.gst_inclusive_quote"
      @close="closeModal('ForceJob')"
      @forced="handleForcedPrice"
    />
  </template>

	<template v-if="mountQuoteToJobInv">
    <quote-to-job-inv
      @close="closeQuoteToJobInv"
      :job="job"
      @modal:receipts="openJobReceiptModal"
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

	<template v-if="mountSearchJob">
    <search-job
      @close="closeSearchJob"
    />
  </template>

  <template v-if="mountJobModal">
    <job-modal
    	@close="closeJobModal"
			@jobdata="addJobData"
    />
  </template>

  <template v-if="mountTermsModal && site.id">
    <terms-modal
      :site-id="site.id"
      :term-id="Number(values.job.term.id)"
      @term="handleTermUpdate"
      @close="closeModal('TermsModal')"
    />
  </template>
  <template v-if="mountDeleteReceipt">
    <delete-receipt
      :receipt="selectedMitForDelete"
      @deleted="receiptDeleted"
      @close="closeModal('DeleteReceipt')"
    />
  </template>
  <template v-if="mountAddMemo">
    <add-memo
      :site-id="job.site_id"
      :selected-memo="selectedMemoForEdit"
      :job="job"
      @saved="memoSaved"
      @close="closeAddMemoModal"
    />
  </template>

	<div class="col-xsmall-12 col-small-12">
		<portlet-content isform="true" :onlybody="true">
			<template slot="body">
			@if(request()->segment(2) === 'create')
        <button type="button" class="btn action-buttons" @click="openJobModal">Add</button>
			@endif

      <button type="button" class="btn action-buttons" @click="openSearchJob">Search</button>
      <button
        v-if="hasPermission('job.access.edit.screen.1') && hasPermission('job.access.edit.costing')" 
        type="button" 
        class="btn action-buttons" 
        @click="submit" 
      >Save</button>

			@if(request()->segment(3) === 'edit')
        <a class="btn action-buttons" href="/jobs/create">New Job</a>
        <button type="button" class="btn action-buttons" @click="updateModalStatus('Update', true)">Update</button>
        <button 
          v-if="!job.shop_id"
          type="button" 
          class="btn action-buttons" 
          @click="mountSelectShopModal = true"
        >Select B.U.</button>
        <button type="button" class="btn action-buttons" @click="mediaButton('prev')">< Prev</button>
        <button type="button" class="btn action-buttons" @click="mediaButton('next')">Next ></button>
			@endif
				<button type="button" class="btn action-buttons" @click.prevent="page = 1" :class="{ currentPage : page=== 1}">
					1
				</button>
				<button type="button" class="btn action-buttons" @click.prevent="page = 2" :class="{ currentPage : page=== 2}">
					2
				</button>
				<button type="button" class="btn action-buttons" @click.prevent="page = 3" :class="{ currentPage : page=== 3}">
					3
				</button>
			</template>
		</portlet-content>
	</div>
	@if(request()->segment(3) === 'edit')
		@include('admin.modules.jobs.partials.add-invoice')
    @include('admin.modules.jobs.partials.newjob')
    @include('admin.modules.booking.partials.addbooking')
	@endif

  @include('admin.modules.stock.partials.addstock')

	<template v-if="mountUpdate">
    <update
			@close="updateModalStatus('Update', false)"
			@modal:invoicing="updateModalStatus('Invoice', true)"
			@modal:receipts="updateModalStatus('Receipt', true)"
			@modal:edit-retention="updateModalStatus('EditRetention', true)"
			@modal:allocate-mit="updateModalStatus('AllocateMIT', true)"
			@modal:allocate-labour="updateModalStatus('AllocateLabour', true)"
    />
  </template>
	<template v-if="mountInvoice">
    <create-invoice
			:job="job"
      :invoices="invoices"
      :net-quote-price="netQuotePrice"
      :total-billed-invoice="totalBilledInvoice"
      :gst="Number(this.values.job.gst)"
			@close="updateModalStatus('Invoice', false)"
    />
  </template>
	<template v-if="mountReceipt">
    <create-receipt
			:job="job"
      :invoices="invoices"
      :page="jobInvoiceReceiptPage"
      :selected-invoice-id="jobInvoiceReceiptInvoiceId"
      @close="updateModalStatus('Receipt', false)"
			@saved="refreshJobPage"
    />
  </template>
  <template v-if="mountStateModal">
    <state-modal
      @state="selectNewState"
      @close="updateModalStatus('StateModal', false)"
    />
  </template>
  <template v-if="mountSelectShopModal && !values.job.shop_id">
    <select-shop
      :site-id="job.site_id"
      :job-id="job.id"
      @close="updateModalStatus('SelectShopModal', false)"
    />
  </template>
  <template v-if="mountEditRetention">
    <edit-retention
      :job="job"
      @updated="refreshJobPage"
			@close="updateModalStatus('EditRetention', false)"
    />
  </template>
  <template v-if="mountAllocateMIT">
    <allocate-mit
      :job="job"
      :non-allocated-mit="nonAllocatedReceipts"
      @updated="refreshJobPage"
			@close="updateModalStatus('AllocateMIT', false)"
    />
  </template>
  <template v-if="mountAllocateLabour">
    <allocate-labour
      :job="job"
      :net-labour-cost="labourGrandTotal"
      :net-labour-allocated="netLabourAllocated"
      @updated="refreshJobPage(2)"
			@close="updateModalStatus('AllocateLabour', false)"
    />
  </template>
</div>
