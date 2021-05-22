<div class="form-container">
      <template>
        <loading :loading="loading" />
      </template>

      <div v-if="currentPage === 1 || currentPage === 2 || currentPage === 5">
      
        <div v-show="currentPage === 1">
          @include('admin.modules.suppliers.partials.page_1')
        </div>
        <div v-show="currentPage === 2">
          @include('admin.modules.suppliers.partials.page_2')
        </div>
        <div v-show="currentPage === 5">
          @include('admin.modules.suppliers.partials.report')
        </div>

        <div class="row col-12 pt-3">
          <div class="w-100">
              <portlet-content isform="true" :onlybody="true">
                  <div slot="body" class="menu-bar d-flex justify-content-between">
                      <div class="mt-1">
                        <template v-if="currentPage == 1 || currentPage === 2">
                            <!-- <button type="button" class="btn action-buttons" v-if="!isEditMode" @click="openReportPage">Report</button> -->
                            @can('suppliers.edit')
                            <button type="button" class="btn action-buttons" v-if="!isEditMode" @click="enableEditMode">Edit</button>
                            @endcan
                            @can('suppliers.delete')
                            <button type="button" class="btn action-buttons" v-if="!isEditMode" @click="deleteSupplier">Delete</button>
                            @endcan
                            <button type="button" class="btn action-buttons" v-if="!isEditMode" @click="openModal('SearchSupplier')">Search</button>
                            <button type="button" class="btn action-buttons" @click="saveHandler" v-if="isEditMode">Save</button>
                            @can('suppliers.add')
                            <button type="button" class="btn action-buttons" v-if="!isEditMode" @click="createNewSupplier">Add</button>
                            @endcan
                            <button type="button" class="btn action-buttons" v-if="isEditMode" @click="cancelEditMode">Cancel</button>
                            <button type="button" class="btn action-buttons" v-if="isOldEntry" @click="openModal('SelectPayment')">Pay</button>
                        </template>
                        <button type="button" class="btn action-buttons ml-4" :class="{ 'active': currentPage === 1 }" @click="currentPage = 1">1</button>
                        <button type="button" class="btn action-buttons":class="{ 'active': currentPage === 2 }" @click="currentPage = 2">2</button>
                      </div>
                      <span class="background-black text-truncate mr-3 my-1">
                          Suppliers
                      </span>
                  </div>
              </portlet-content>
          </div>
        </div>
      
        <template v-if="mountSearchSupplier">
            <search-supplier
                :sites="sites"
                @selected="handleSelectedSupplier"
                @close="closeModal('SearchSupplier')"  
            />
        </template>
        <template v-if="mountSelectPayment">
            <select-payment
                :site-id="model.site_id"
                :current-supplier="model.id"
                @remit="handleRemitPaid"
                @close="closeModal('SelectPayment')"  
            />
        </template>
        <template v-if="mountSelectAccount">
            <select-account
                :type="accountModalFor"
                :allow-empty="true"
                :title="accountModalTitle"
                :options="accounts"
                @selected="accountSelected"
                @close="closeSelectAccount"
            />
        </template>
        <template v-if="mountSelectCentralBilling">
            <select-central-billing
                :current-supplier="model"
                @selected="centralBillingSelected"
                @close="closeSelectCentralBilling"
            />
        </template>
        <template v-if="mountStateModal">
            <state-modal
                @state="selectNewState"
                @close="closeModal('StateModal')"
            />
        </template>
        <template v-if="mountAddRemittance">
            <add-remittance
                :site-id="model.site_id"
                :remittance-id="remit.id"
                :remit="remit"
                @updated="updateRemit"
                @close="closeModal('AddRemittance')"
            />
        </template>
        <template v-if="mountTrashOrKeep">
            <trash-or-keep
                @trash-it="currentPage = 1"
                @close="closeModal('TrashOrKeep')"
            />
        </template>
      </div>

        <template v-if="currentPage === 3">
            <remit
                :data="remit"
                :site-id="model.site_id"
                @update="loadRemit"
                @print="currentPage = 4"
                @trash="currentPage=1"
            />
        </template>
        <remit-print
            v-if="currentPage === 4"
            :remit="remit"
        /></div>
    </div>