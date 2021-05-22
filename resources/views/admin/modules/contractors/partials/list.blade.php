<div class="form-container">
    <div>
        <template v-if="currentPage !== 4 && currentPage !== 3">
            <template>
                <loading :loading="loading" />
            </template>
            <div class="col-xsmall-12 col-small-12">
                <div class="col-6 row" v-if="!isOldEntry">
                    <span class="col-lg-2 text-right h4">Store:</span>
                    <drop-down
                        v-show="!isOldEntry"
                        class="col-6"
                        :options="sites"
                        v-model="model.site_id"
                        style="max-height: 30px;"
                    />
                </div>
                <div class="pt-3" v-show="currentPage === 1">
                    @include('admin.modules.contractors.partials.page_1')
                </div>
                <div v-if="currentPage === 2 && hasPermission('contractors.paid.reports')">
                    @include('admin.modules.contractors.partials.page_2')
                </div>
                <!-- <div class="pt-3" v-show="currentPage === 3">
                    @include('admin.modules.contractors.partials.remit')
                </div> -->
            </div>

            <div class="col-xsmall-12 col-small-12 mt-3">
                <portlet-content isform="true" :onlybody="true">
                    <div slot="body" class="menu-bar d-flex justify-content-between">
                        <div class="mt-1">
                            <template v-if="currentPage === 3">
                                <button type="button" class="btn action-buttons" @click="openModal('TrashOrKeep')">Abort</button>
                                <button type="button" class="btn action-buttons" @click="remitContractor">Remit</button>
                            </template>
                            <template v-else>
                                <button type="button" class="btn action-buttons" @click="openModal('SearchContractor')">Search</button>
                                <button type="button" class="btn action-buttons">Report</button>
                                <button 
                                    v-if="hasPermission('contractors.add.contractor')"
                                    type="button" 
                                    class="btn action-buttons" 
                                    @click="openAddModal"
                                >Add</button>
                                <button 
                                    type="button" 
                                    class="btn action-buttons" 
                                    v-if="isOldEntry && hasPermission('contractors.pay.contractor')" 
                                    @click="openModal('SelectPayment')"
                                >Pay</button>
                                <button type="button" class="btn action-buttons" @click="mediaButton('prev')">< Prev</button>
                                <button type="button" class="btn action-buttons" @click="mediaButton('next')">Next ></button>
                                <button 
                                    type="button" 
                                    class="btn action-buttons" 
                                    v-if="isEditMode && currentPage !== 3 && hasPermission('contractors.edit.record')" 
                                    @click="editContractor"
                                >Save</button>
                                <button type="button" class="btn action-buttons ml-4" :class="{ 'active': currentPage === 1 }" @click="currentPage = 1">1</button>
                                <button
                                    v-if="hasPermission('contractors.paid.reports')"
                                    type="button" 
                                    class="btn action-buttons"
                                    :class="{ 'active': currentPage === 2 }" 
                                    @click="currentPage = 2"
                                >2</button>
                            </template>
                        </div>
                        <div>
                            
                            <span class="background-black text-truncate mr-3 my-1 p-1">
                                Contractors
                            </span>
                        </div>
                    </div>
                </portlet-content>
            </div>

            <template v-if="mountSearchContractor">
                <search-contractor
                        :sites="sites"
                        @selected="handleSelectedContractor"
                        @close="closeModal('SearchContractor')"
                />
            </template>

            <template v-if="mountAddModal">
                <add
                    :contractor="contractor"
                    @close="closeAddModal"
                    @modal:add-contractor="openNewContractor"
                    @modal:add-payable="newPayable"
                />
            </template>
            <template v-if="mountAddPayableModal">
                <contractor-payable-record
                    :payable-data="selectedPayableData"
                    :contractor="contractor"
                    :jobs="jobs"
                    @close="closeAddPayable"
                />
            </template>
            <template v-if="mountNewContractor">
                <new-contractor 
                    @close="closeNewContractor"
                />
            </template>
            <template v-if="mountSelectAccount">
                <select-account
                    :type="pickedAccount"
                    :title="accountTitle"
                    :options="accounts"
                    @selected="accountSelected"
                    @close="closeSelectAccount"
                />
            </template>
            <template v-if="mountSupplierAccount">
                <select-supplier-account
                    :type="pickedSupplierAccount"
                    :title="supplierAccountTitle"
                    :suppliers="suppliers"
                    :options="liabilityAccount"
                    @selected="supplierAccountSelected"
                    @close="closeSupplierAccount"
                />
            </template>
            <template v-if="mountSelectPayment">
                <select-payment
                    :site-id="model.site_id"
                    :current-contractor="model.id"
                    @remit="handleRemitPaid"
                    @close="closeModal('SelectPayment')"  
                />
            </template>
            <template v-if="mountTrashOrKeep">
                <trash-or-keep
                @trash-it="currentPage = 1"
                @close="closeModal('TrashOrKeep')"
                />
            </template>
        </template>
        <div v-else>
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
            @finish-print="remitCompleted"
        />

        </div>
    </div>
</div>
