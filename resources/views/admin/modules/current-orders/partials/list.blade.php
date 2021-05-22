<div class="form-container">
    <template>
        <loading :loading="loading" />
    </template>
    <div class="col-xsmall-12 col-small-12">
        <div class="row">
            <div class="col-4">
                <div class="row">
                    <portlet-content :height="228" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row">
                                <div class="col-7">
                                    <span class="background-black p-1">
                                        Supplier
                                    </span>
                                </div>
                                <span class="h6">Supplier SN: @{{ supplierId }}</span>
                            </div>
                            <div class="row py-3 mt-2">
                                <label class="col-lg-2 text-right">Supplier:</label>
                                <input class="col-lg-10 form-control" type="text" :value="supplierName" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2 text-right">Address:</label>
                                <input class="col-lg-10 form-control" type="text" :value="supplierDetails.street" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2" style="text-right">&nbsp;</label>
                                <input class="col-lg-4 form-control" type="text" :value="supplierDetails.state" disabled>
                                <input class="col-lg-3 form-control" type="text" :value="supplierDetails.suburb" disabled>
                                <input class="col-lg-3 form-control" type="text" value="" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2" style="text-right">Phone:</label>
                                <input class="col-lg-10 form-control" type="text" :value="supplierDetails.phone" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2" style="text-right">Fax:</label>
                                <input class="col-lg-10 form-control" type="text" :value="supplierDetails.fax" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2" style="text-right">Contact:</label>
                                <input class="col-lg-10 form-control" type="text" :value="supplierDetails.contact || currentOrder.sales_contact" disabled>
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="157" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row pb-2">
                                <label class="col-lg-2">Client:</label>
                                <input disabled class="col-lg-10 form-control" type="text" :value="currentOrder.client_name" >
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2">Job:</label>
                                <input class="col-lg-4 form-control" type="text" :value="jobId" disabled>
                                <button class="col-lg-2 btn action-buttons" type="button" @click="redirectToJob">Get Job</button>
                                <span class="col-lg-4">&nbsp;</span>
                            </div>
                            <div class="row pb-4">
                                <label class="col-lg-2">Rep:</label>
                                <input class="col-lg-10 form-control" type="text" :value="currentOrder.sales_rep" disabled >
                            </div>
                            <div class="row">
                                <label class="col-lg-3">Placed by:</label>
                                <input class="col-lg-5 form-control" type="text" :value="supplierDetails.contact" disabled>
                                <span class="col-lg-4">&nbsp;</span>
                            </div>
                        </div>
                    </portlet-content>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <portlet-content :height="205" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-1">
                            <div class="row">
                                <div class="col-lg-2">
                                    <span class="background-black p-1">
                                        Deliver to
                                    </span>
                                </div>
                                <textarea class="col-lg-10" name="" id="" cols="8" rows="1" disabled></textarea>
                            </div>
                            <div class="row py-2 mt-2">
                                <input class="form-control" type="text" :value="currentOrder.delivery_address.name" disabled>
                            </div>
                            <div class="row pb-2">
                                <input class="form-control" type="text" :value="currentOrder.delivery_address.street" disabled>
                            </div>
                            <div class="row pb-2">
                                <input class="form-control" type="text" :value="currentOrder.delivery_address.town" disabled>
                            </div>
                            <div class="row pb-2">
                                <input class="col-2 form-control" type="text" :value="currentOrder.delivery_address.state" disabled>
                                <input class="col-2 form-control" type="text" value="" disabled>
                            </div>
                            <div class="row pb-2">
                                <input class="col-4 form-control" type="text" :value="currentOrder.delivery_address.phone" disabled>
                                <span class="col-2">&nbsp;</span>
                                <label class="col-lg-2" style="text-right">Fax:</label>
                                <input class="col-lg-4 form-control" type="text" :value="currentOrder.delivery_address.fax" disabled>
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="180" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="pt-4">
                            <div class="row pb-2">
                                <label class="col-lg-5 text-right">Cost Price: </label>
                                <input class="col-lg-5 form-control text-right" type="text" :value="displayMoney(currentOrder.costed_price)" disabled>
                            </div>
                            <div class="row pb-2">
                            <label class="col-lg-5 text-right">Invoiced Received: </label>
                                <input class="col-lg-5 form-control text-right" type="text" :value="displayMoney(currentOrder.invoice_received_amount)" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-5 text-right">Due Date: </label>
                                <input v-if="!isEditMode" class="col-lg-5 form-control" type="text" :value="formatViewDate(currentOrder.due_date)" disabled>
                                <input v-else class="col-lg-5 form-control" type="date" v-model="model.due_date">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-5 text-right">Last Date Rcvd: </label>
                                <input class="col-lg-5 form-control" type="text" :value="formatViewDate(currentOrder.last_date_received)" disabled>
                            </div>
                        </div>
                    </portlet-content>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <portlet-content :height="265" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-3">
                            <div class="row">
                                <span class="col-3"></span>
                                <label class="col-3 text-right">
                                    System Generated Order Number:
                                </label>
                                <span class="text-primary h3">@{{ currentOrder.id }}</span>     
                            </div>
                            <div class="row pt-1">
                                <span class="col-3"></span>
                                <label class="col-3 text-right">
                                    Interim Order Number:
                                </label>
                                <span class="h5">@{{ currentOrder.interim_order_number }}</span>     
                            </div>
                            <div class="row pt-1">
                                <span class="col-3"></span>
                                <label class="col-3 text-right">
                                    Order Date:
                                </label>
                                <span class="h4">@{{ formatViewDate(currentOrder.created_at) }}</span>     
                            </div>
                            <div class="row pt-1">
                                <span class="col-3"></span>
                                <label class="col-3 text-right">
                                    Supplier's Reference:
                                </label>
                                <span class="h5">@{{ currentOrder.supplier_reference }}</span>     
                            </div>
                            <div class="row pt-3">
                                <label >
                                Purchase Orders stay in this file until they are Archived. The system asks if you
                                wish to Archive the Order when it determines that all SUpplier Invoices have
                                been married to the Order. (Updating).
                                You can also Archive the Order manually, using the Archive button.
                                Archived Orders are transferred to the Delivered Orders file.
                                </label>
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="120" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row pb-2">
                                <label class="col-lg-3">Date:</label>
                                <input class="col-lg-3 form-control text-right" type="text" value="" disabled>
                                <div class="col-lg-3">&nbsp;</div>
                                <div class="col-lg-3">
                                    <span class="background-red">Cancellation</span>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4" class="form-controls" style="text-right">Explanation:</label>
                            </div>
                            <div class="row pb-2">
                                <textarea name="" id="" cols="8" rows="1" disabled></textarea>
                            </div>
                        </div>
                    </portlet-content>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <portlet-content :height="125" :onlybody="true" class="col-12 px-2 mt-3">
                        <div slot="body" class="p-1">
                            <div class="row">
                                <span class="col-2 background-black">
                                    Central
                                    Billing
                                </span>
                                <input class="col-2 text form-control" type="text" value="" disabled>
                                <input class="col-5 text form-control pl-1" type="text" value="" disabled>
                            </div>
                            <div class="row">
                                <div class="col-5">&nbsp;</div>
                                <span class="col-7 text-right h6 mt-3">
                                    If a different Supplier Serial Number is entered here,
                                    then this item will be remitted to that Supplier.
                                </span>
                            </div>
                        </div>
                    </portlet-content>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <portlet-content :height="125" :onlybody="true" class="col-12 px-2 mt-3">
                        <div slot="body" class="p-1">
                            <div class="row">
                                <div class="col-1 background-black mb-5">
                                    Notes
                                </div>
                                <textarea class="col-11" cols="10" rows="2" disabled></textarea>
                            </div>
                        </div>
                    </portlet-content>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <portlet-content :height="240" :onlybody="true" class="col-12 px-1 mt-3">
                    <div slot="body" class="p-3">
                        <div class="row">
                            <span class="text-primary h4 col-12">
                                Please Supply...
                            </span>
                        </div>
                        <div class="row table-wrap">
                            <table class="table">
                                <tbody>
                                    <tr class="row col-12">
                                        <td class="table-head col-1">&nbsp;</td>
                                        <td class="table-head col-6">&nbsp;</td>
                                        <td class="table-head col-1">Job</td>
                                        <td class="table-head col-1">Due Date</td>
                                        <td class="table-head col-1">Received</td>
                                        <td class="table-head col-1">Pending</td>
                                        <td class="table-head col-1">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row table-wrap" style="max-height: 150px; overflow-y: auto;">
                            <table class="table">
                                <tbody>
                                    <tr class="row col-12 text-bold" v-for="(futureStock, index) in currentOrder.future_stocks" >
                                        <td class="col-1">
                                            <button class="btn action-buttons w-100" @click="showEditModal(futureStock)">Edit >> </button>
                                        </td>
                                        <template @click="redirectToStock(futureStock)">
                                          <td class="col-6 form-control" @click="redirectToStock(futureStock)">
                                            @{{ futureStock.quantity }} &nbsp;
                                            @{{ futureStock.unit }} &nbsp;
                                            @{{ futureStock.color ? futureStock.color.product.name : 'product_name' }},&nbsp;
                                            @{{ futureStock.color ? futureStock.color.name : '' }}
                                            <template v-if="futureStock.list_price">@ $@{{ futureStock.list_price }}</template>&nbsp;
                                            <template v-if="futureStock.discount">minus @{{ futureStock.discount }}% discount </template>
                                            <template v-if="futureStock.delivery">plus $@{{ futureStock.delivery }} handling </template>
                                            <!-- <template v-if="futureStock.color.product.supplier.levy_account">plus @{{ futureStock.levy }}% levy</template> -->
                                            <template v-if="futureStock.tax">plus @{{ futureStock.tax }}% GST</template>.
                                          </td>
                                          <td class="col-1 form-control">@{{ jobId }}</td>
                                          <td class="col-1 form-control">@{{ formatViewDate(futureStock.delivery_date) }}</td>
                                          <td class="col-1 form-control">@{{ futureStock.received }}</td>
                                          <td class="col-1 form-control">@{{ (futureStock.quantity - futureStock.received).toFixed(2)  }}</td>
                                        </template>
                                        <td class="col-1">
                                            <button class="btn action-buttons w-100" @click="showUpdateModal(futureStock)"><< Update </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </portlet-content>
            </div>
        </div>
        
        
    </div>

    <div class="col-xsmall-12 col-small-12">
        <portlet-content isform="true" :onlybody="true">
            <div slot="body" class="menu-bar py-1">
                <div>
                    <button type="button" class="btn action-buttons" v-if="!isEditMode" @click="openModal('SearchCurrentOrdersModal')">Search</button>
                    <button type="button" class="btn action-buttons" v-if="!isEditMode">Report</button>
                    <button
                        type="button" 
                        class="btn action-buttons" 
                        v-if="!isEditMode && hasPermission('orders.edit.order')" 
                        @click="enableEditMode"
                    >Edit</button>
                    <button
                        type="button" 
                        class="btn action-buttons" 
                        @click="saveCurrentOrder" 
                        v-if="isEditMode && hasPermission('orders.update.order')"
                    >Save</button>
                    <button type="button" class="btn action-buttons" v-if="isEditMode" @click="cancelEditMode">Cancel</button>
                    <button 
                        type="button" 
                        class="btn action-buttons" 
                        v-if="!isEditMode && hasPermission('orders.add.order')" 
                        @click="openModal('AddCurrentOrderModal')"
                    >Add</button>
                    <button 
                        type="button" 
                        class="btn action-buttons" 
                        v-if="!isEditMode && hasPermission('orders.delete.order')" 
                        @click="openArchiveModal"
                    >Archive</button>
                    <button type="button" class="btn action-buttons" v-if="!isEditMode && hasPermission('orders.delete.order')">Delete</button>
                    <button type="button" class="btn action-buttons" v-if="!isEditMode">Help</button>
                    <button type="button" class="btn action-buttons text-primary">index = ONO</button>
                </div>
                <span class="background-black mr-3 my-1 px-3">
                    Current Orders
                </span>
            </div>
        </portlet-content>
    </div>
    <template v-if="mountEditModal">
        <edit-order-modal 
            :order-data="selectedStock"
            @updated="futureStockUpdated"
            @close="hideEditModal"
        />
    </template>
    <template v-if="mountAddCurrentOrderModal">
        <add-current-order
            :current-order-data="addCurrentOrderData"
            :new-order="newlyAddedOrder"
            @addorderclicked="openAddOrderModal"
            @openaddsuppliermodal="openAddSupplierModal"
            @updated="currentOrderUpdated"
            @close="closeAddCurrentOrderModal"
        />
    </template>
    <template v-if="mountAddOrderModal">
        <add-order
            :return-to-add-current-order-modal="true"
            @updated="reopenAddCurrentOrderModal"
            @close="closeModal('AddOrderModal')"
        />
    </template>
    <template v-if="mountAddSupplierModal">
        <add-supplier
            :current-order-data="addCurrentOrderData"
            @updated="currentOrderUpdated"
            @close="closeModal('AddSupplierModal')"
        />
    </template>
    <template v-if="mountUpdateModal">
        <update-order-modal 
            :order-data="selectedStock"
            @close="hideUpdateModal"
            @modal:order-received="showOrderReceivedModal"
            @modal:enter-invoice="showMarryInvoiceModal"
        />
    </template>
    <template v-if="mountOrderRecieptModal">
        <order-receipt-modal
            :stock-data="selectedStock"
            @close="hideOrderReceipt"
        />
    </template>
    <template v-if="mountGeneralOrderRecieptModal">
        <receive-general-order
            :stock-data="selectedStock"
            :current-order="currentOrder"
            @received="refreshCurrentOrderPage"
            @close="closeModal('GeneralOrderReceiptModal')"
        />
    </template>
    <template v-if="mountMarryInvoiceModal">
        <marry-invoice-modal
            :future-stock="selectedStock"
            :current-order="currentOrder"
            @created="marryInvoiceCreated"
            @modal:archive="openArchiveModal"
            @close="hideMarryInvoiceModal"
        />
    </template>
    <template v-if="mountArchiveModal">
        <archive-current-order
            :future-stock="selectedStock"
            :current-order="currentOrder"
            @created="marryInvoiceCreated"
            @close="closeModal('ArchiveModal')"
        />
    </template>
    <template v-if="mountFmError">
        <fm-error
            message="If this general order is delivered then Archive it.
                Enter the Supplier's invoice by adding a manual Payable."
            @close="closeModal('FmError')"
        />
    </template>
    <template v-if="mountSearchCurrentOrdersModal">
        <search-current-orders
            @selected="loadCurrentOrderById"
            @close="closeModal('SearchCurrentOrdersModal')"
        />
    </template>
</div>
