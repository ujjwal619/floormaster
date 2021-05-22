  <div class="form-container">
    <div class="col-xsmall-12 col-small-12">
        <template>
            <loading :loading="loading" />
        </template>
        <div class="row">
            <h3 class="col-10" style="color: yellow">@{{ supplier.trading_name }}: @{{ product.name }} @{{ color.name }}</h3>
            <h3 class="col-2 text-right" style="color: yellow;">
              @{{ supplier.id }} - @{{ product.upc || product.id }}
            </h3>
        </div>
        <div v-if="page === 1" class="row">
            <div class="col-5 p-2">
                <portlet-content :height="495" :onlybody="true">
                    <div slot="body">
                        <div class="row table-wrap px-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="table-head" style="width: 40%">Item </td>
                                        <td class="table-head" style="width: 10%">Amt </td>
                                        <td class="table-head text-blue" style="width: 10%">Sold </td>
                                        <td class="table-head text-red" style="width: 10%">4Sale </td>
                                        <td class="table-head text-blue" style="width: 10%">Loc </td>
                                        <td class="table-head" style="width: 5%">NB</td>
                                        <td class="table-head" style="width: 10%">Serial No</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="batch-list">
                            <div class="row table-wrap px-2"
                              v-for="(currentStockGroup, batch) in currentStocks"
                              :key="batch"
                            >
                                <h6 class="text-blue"> Batch: @{{ batch }}</h6>
                                <div class="col-xsmall-12" style="max-height: 120px;overflow-y: scroll;">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr v-for="currentStock in currentStockGroup" 
                                                @click="clickedOnCurrentStockCopy(currentStock)"
                                            >
                                                <td style="width: 40%" >@{{ currentStock.roll_no }}</td>
                                                <td style="width: 10%">@{{ currentStock.size }}</td>
                                                <td style="width: 10%" class="text-blue">@{{ currentStock.sold }}</td>
                                                <td style="width: 10%" class="text-red">@{{ (currentStock.size - currentStock.sold).toFixed(2) }}</td>
                                                <td style="width: 10%" class="text-blue">@{{ currentStock.location }}</td>
                                                <td style="width: 5%">@{{ currentStock.nb }}</td>
                                                <td style="width: 10%">@{{ currentStock.id }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-xsmall-12">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="width: 40%">&nbsp;</td>
                                                <td style="width: 10%">@{{ totalSize(currentStockGroup) }}</td>
                                                <td style="width: 10%" class="text-blue">@{{ totalSold(currentStockGroup) }}</td>
                                                <td style="width: 10%" class="text-red">@{{ total4Sale(currentStockGroup).toFixed(2) }}</td>
                                                <td style="width: 25%">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </portlet-content>
                <portlet-content :height="185" :onlybody="true">
                    <template slot="body">
                      <div class="row">
                        <div class="w-50">
                          <span class="text-bold"> Notes</span>
                          <textarea cols="5" rows="5" v-model="updatedStock.notes"></textarea>
                        </div>
                        <div class="w--50 pl-4 pt-3">
                          <div>
                            <span class="text-bold h6 text-right">Total Current Stock:</span>
                            <input class="form-control" disabled :value="stock.total_current_stock">
                          </div>
                          <div>
                            <span class="text-bold h6 text-right">Allocations & Back Orders:</span>
                            <input class="form-control" disabled :value="totalAllocationsAndBackOrders">
                          </div>
                          <div>
                            <span class="text-bold h6 text-right text-blue">Total 4 Sale: </span>
                            <input class="form-control" disabled :value="stock.current_stock_total_for_sell">
                          </div>
                        </div>
                      </div>
                    </template>
                </portlet-content>
            </div>
            <div class="col-7 p-2">
                <portlet-content :height="155" :onlybody="true" class="width-100p">
                    <div slot="body" class="row future-stock">
                        <div class="col-3 px-4 py-2 add-stock__area">
                            <div class="text-blue text-center">Click on Add button to order stock </div>
                                <button 
                                    v-if="isUsersSite"
                                    type="button" 
                                    class="btn action-buttons" 
                                    @click="addStockItemModal"
                                >
                                    Add
                                </button>
                            <div class="background-black mt-1" style="text-align:center;">Future Stock</div>
                        </div>
                        <div class="col-6">
                            <div class="col-xsmall-12 table-wrap">
                                <div style="max-height: 110px;overflow-y: scroll;">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td class="table-head" style="width: 25%">Amt</td>
                                            <td class="table-head" style="width: 25%">Due In</td>
                                            <td class="table-head" style="width: 25%">Order No</td>
                                            <td class="table-head" style="width: 25%" class="text-red">4 Sale</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="futureStock in futureStocks"
                                                @click="clickedOnFutureStockCopy(futureStock)"
                                            >
                                                <td style="width: 25%">@{{ (futureStock.quantity - futureStock.received).toFixed(2) }}</td>
                                                <td style="width: 25%">@{{ futureStock.delivery_date }}</td>
                                                <td style="width: 25%">@{{ futureStock.order_number }}</td>
                                                <td style="width: 25%" class="text-red">@{{ (futureStock.quantity - futureStock.sold) > 0 ? (futureStock.quantity - futureStock.received - futureStock.sold).toFixed(2) : '0.00' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <table class="table mt-2">
                                    <tbody>
                                        <tr>
                                            <td style="width: 25%">@{{ stock.total_future_stock }}</td>
                                            <td colspan="2" style="width: 50%"></td>
                                            <td class="text-red" style="width: 25%">@{{ stock.future_stock_total_for_sell }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-3 reorder-col">
                            <div class="reorder-item text-blue"> 
                                Re-Order @: 
                                <input type="number" style="width: 108px;" v-model="updatedStock.reorder">
                            </div>
                        </div>
                    </div>
                </portlet-content>
                <portlet-content :height="215" class="width-100p" :onlybody="true">
                    <div class="table-wrap" slot="body">
                        <div style="max-height: 165px;overflow-y: scroll;">
                            <table class="table table-bordered" >
                                <thead>
                                <tr>
                                    <td class="table-head" style="width: 25%">Client</td>
                                    <td class="table-head" style="width: 15%">Job</td>
                                    <td class="table-head" style="width: 15%">Order No</td>
                                    <td class="table-head" style="width: 15%" class="text-red">Required</td>
                                    <td class="table-head" style="width: 15%" class="text-blue">Amt</td>
                                    <td class="table-head" style="width: 15%" class="text-green">Drop Off</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="backOrder in color.back_orders" :key="backOrder.id" @click="clickedOnBackOrder(backOrder)" >
                                    <td style="width: 25%">@{{ backOrder.client }}</td>
                                    <td style="width: 15%">@{{ backOrder.job ? backOrder.job.job_id : '' }}</td>
                                    <td style="width: 15%">@{{ backOrder.is_linked ? backOrder.future_stock.order_number : '' }}</td>
                                    <td style="width: 15%" class="text-red">@{{ formatViewDate(backOrder.date_required) }}</td>
                                    <td style="width: 15%" class="text-blue">@{{ backOrder.amount }}</td>
                                  <td style="width: 15%" class="text-blue">@{{ backOrder.drop_off }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="background-black mt-2">Back Orders</div>
                    </div>
                </portlet-content>
                <portlet-content :height="306" :onlybody="true" class="width-100p">
                    <div class="table-wrap" slot="body">
                        <div style="max-height: 220px;overflow-y: scroll;">
                            <table class="table table-bordered mb-1">
                                <thead>
                                <tr>
                                    <td class="table-head" style="width: 25%">Sold to</td>
                                    <td class="table-head" style="width: 15%">Job</td>
                                    <td class="table-head" style="width: 15%">Item</td>
                                    <td class="table-head" style="width: 15%" class="text-red">Required</td>
                                    <td class="table-head" style="width: 15%" class="text-blue">Amt</td>
                                    <td class="table-head" style="width: 15%" class="text-green">Drop Off</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="allocation in color.allocations" :key="allocation.id" @click="clickedOnAllocation(allocation)" >
                                    <td style="width: 25%">@{{ allocation.client }}</td>
                                    <td style="width: 15%">@{{ allocation.job ? allocation.job.job_id : '' }}</td>
                                    <td style="width: 15%" class="text-green">@{{ allocation.is_linked ? allocation.current_stock.roll_no : '' }}</td>
                                    <td style="width: 15%">@{{ formatViewDate(allocation.date_required) }}</td>
                                    <td style="width: 15%" class="text-red">@{{ allocation.amount }}</td>
                                    <td style="width: 15%" class="text-blue">@{{ allocation.drop_off }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td style="width: 69%" colspan="4" class="text-red table-head text-right">Total Back Orders & Allocations:</td>
                                    <td style="width: 15%" class="text-blue">@{{ totalAllocationsAndBackOrders }}</td>
                                    <td class="table-head"></td>
                                </tr>
                            </tbody>
                            </table>
                        <div class="background-black">Allocations</div>
                    </div>
                </portlet-content>
            </div>
        </div>
        <div v-else class="row pt-2">
            <div class="col-12">
                <portlet-content :height="505" :onlybody="true">
                    <div slot="body" class="row">
                        <div class="col-12 px-4">
                            <div class="table-wrap">
                                <table class="table">
                                <tbody>
                                    <tr class="row col-12">
                                        <td class="table-head col-1">Item SN</td>
                                        <td class="table-head col-1">Sold To</td>
                                        <td class="table-head col-1">Project</td>
                                        <td class="table-head col-1">Job</td>
                                        <td class="table-head col-1">Item/Roll</td>
                                        <td class="table-head col-1">Batch</td>
                                        <td class="table-head col-1">Sup. Invoice</td>
                                        <td class="table-head col-1">Was</td>
                                        <td class="table-head col-1">Out</td>
                                        <td class="table-head col-1">Left</td>
                                        <td class="table-head col-1">Date</td>
                                        <td class="table-head col-1">Unit Cost</td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <div class="table-wrap" style="max-height: 455px;overflow-y: auto;">
                                <table class="table">
                                <tbody>
                                    <tr 
                                        class="row col-12" 
                                        v-for="dispatch in allDispatches" 
                                        :key="dispatch.id"
                                        @click="clickedOnDispatch(dispatch)" 
                                    >
                                        <td class="form-control col-1">@{{ dispatch.id }}</td>
                                        <td class="form-control col-1" v-html="getAllocationFromDispatch(dispatch).client"></td>
                                        <td class="form-control col-1" v-html="getJobFromDispatch(dispatch).project"></td>
                                        <td class="form-control col-1" v-html="getJobNo(dispatch)"></td>
                                        <td class="form-control col-1" v-html="getCurrentStockFromDispatch(dispatch, 'roll_no')"></td>
                                        <td class="form-control col-1" v-html="getCurrentStockFromDispatch(dispatch, 'batch')">&nbsp;</td>
                                        <td class="form-control col-1" v-html="getCurrentStockFromDispatch(dispatch, 'supplier_inv_no')">&nbsp;</td>
                                        <td class="form-control col-1">@{{ dispatch.was }}</td>
                                        <td class="form-control col-1">@{{ dispatch.amount }}</td>
                                        <td class="form-control col-1">@{{ dispatch.left }}</td>
                                        <td class="form-control col-1">@{{ formatViewDate(dispatch.created_at) }}</td>
                                        <td class="form-control col-1">@{{ dispatch.total }}</td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </portlet-content>
            </div>
        </div>
    </div>

    <div class="col-12 text-center">
        <span class="h5 text-warning">
            @{{ activeModeMessage }}
        </span>
    </div>

    <div class="col-xsmall-12 col-small-12">
        <portlet-content isform="true" :onlybody="true">
            <div slot="body" class="menu-bar">
                <div class="d-flex align-items-center pl-2">
                    <button 
                        type="button" 
                        class="btn action-buttons" 
                        @click="searchStockModal"
                    >Search</button>
                    <button 
                        type="button" 
                        class="btn action-buttons" 
                        v-if="page === 1"
                    >Report</button>
                    <button 
                        type="button" 
                        class="btn action-buttons" 
                        v-if="!isAnyModeActive && page === 1 && isUsersSite" 
                        @click="saveStock"
                    >Save</button>
                    <button 
                        type="button" 
                        class="btn action-buttons text-blue" 
                        v-if="!isAnyModeActive && page === 1 && isUsersSite"  
                        @click="addOpeningStockModal"
                    >Add</button>
                    <button 
                        type="button" 
                        class="btn action-buttons" 
                        v-if="!isAnyModeActive && page === 1 && isUsersSite"
                        @click="showAllocationModal"
                    >Allocate</button>
                    <!-- <button type="button" class="btn action-buttons text-red">Adjust</button> -->
                    <button 
                        type="button" 
                        class="btn action-buttons"
                        v-if="!isAnyModeActive && page === 1 && isUsersSite" 
                        @click="enableMoveMode"
                    >Move</button>
                    <!-- <button type="button" class="btn action-buttons">Swap</button> -->
                    <template v-if="!isAnyModeActive && page === 1 && isUsersSite">
                        <button type="button" class="btn action-buttons" @click="isEditMode = true">Edit</button>
                    </template>
                    <template v-if="!isAnyModeActive && page === 1 && isUsersSite">
                        <button type="button" class="btn action-buttons" @click="isDeleteMode = true">Delete</button>
                    </template>
                    <template v-if="!isAnyModeActive && page === 1 && isUsersSite">
                        <button type="button" class="btn action-buttons" @click="isDispatchMode = true">Dispatch</button>
                    </template>
                    <button 
                        type="button" 
                        class="btn action-buttons text-primary" 
                        @click="cancel" 
                        v-if="isAnyModeActive"
                    >Cancel</button>
                    <button 
                        type="button" 
                        class="btn action-buttons" 
                        @click="page = 2" 
                        v-if="page === 1"
                    >History</button>
                    <button 
                        type="button" 
                        class="btn action-buttons" 
                        @click="page = 1" 
                        v-if="page === 2"
                    >Stock Screen</button>
                </div>
                <span class="background-black mr-3 my-1 px-3">
                    Stock
                </span>
            </div>
        </portlet-content>
    </div>
    @include('admin.modules.stock.partials.addstock')
    @include('admin.modules.stock.partials.openingstock')
    @include('admin.modules.stock.partials.search')
    @include('admin.modules.stock.partials.createallocation')
    <template v-if="modals.allocateCurrentStock.show">
        <current-stock-allocation
            :supplier="supplier"
            :product="product"
            :color="color"
            :allocation-data="allocatingStock"
            :current-stock="selectedCurrentStock"
            @allocated="allocateStock"
            @hide="hideCurrentStockAllocation"
        />
    </template>
    <template v-if="mountFutureStock">
        <future-stock-allocation
            :future-stock="selectedFutureStock"
            :allocation-data="allocatingStock"
            :color="color"
            @allocated="futureStockAllocated"
            @close="closeFutureStockAllocation"
        />
    </template>
    <template v-if="mountFutureStockError">
        <future-stock-error
            @close="closeErrorModal('FutureStock')"
        />
    </template>
    <template v-if="mountCurrentStockError">
        <current-stock-error
            @close="closeErrorModal('CurrentStock')"
        />
    </template>
    <template v-if="mountMoveError">
        <move-error
            :module="moveData.errorModule"
            @close="closeErrorModal('Move')"
        />
    </template>
    <template v-if="mountEditAllocation">
        <edit-allocation
            :allocation="selectedAllocation"
            :jobs="jobs"
            :color="color"
            @unlink="openModal('UnlinkAllocation')"
            @close="closeModal('EditAllocation')"
        />
    </template>
    <template v-if="mountEditBackOrder">
        <edit-back-order
            :back-order="selectedBackOrder"
            :jobs="jobs"
            :color="color"
            @unlink="openModal('UnlinkBackOrder')"
            @close="closeModal('EditBackOrder')"
        />
    </template>
    <template v-if="mountUnlinkAllocation">
        <unlink-allocation
            :allocation="selectedAllocation"
            @close="closeModal('UnlinkAllocation')"
        />
    </template>
    <template v-if="mountUnlinkBackOrder">
        <unlink-back-order
            :back-order="selectedBackOrder"
            @close="closeModal('UnlinkBackOrder')"
        />
    </template>
    <template v-if="mountDeleteAllocation">
        <delete-allocation
            :allocation="selectedAllocation"
            @close="closeModal('DeleteAllocation')"
        />
    </template>
    <template v-if="mountDeleteBackOrder">
        <delete-back-order
            :back-order="selectedBackOrder"
            @close="closeModal('DeleteBackOrder')"
        />
    </template>
    <template v-if="mountDispatchAllocation">
        <dispatch-allocation
            :allocation="selectedAllocation"
            :jobs="jobs"
            :color="color"
            @next-dispatch="continueDispatchAllocation"
            @close="refreshStockPage"
        />
    </template>
  </div>
