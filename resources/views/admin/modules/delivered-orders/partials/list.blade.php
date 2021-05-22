<div class="form-container">
    <template>
        <loading :loading="loading" />
    </template>
    <div class="col-xsmall-12 col-small-12">
        <div class="row">
            <div class="col-4">
                <div class="row">
                    <portlet-content :height="220" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row">
                                <div class="col-7">
                                    <span class="background-black p-1">
                                        Supplier
                                    </span>
                                </div>
                                <span class="h6">Supplier SN: @{{ deliveryOrder.supplier_details.id }}</span>
                            </div>
                            <div class="row py-3 mt-2">
                                <label class="col-lg-2" style="text-right">Supplier:</label>
                                <input class="col-lg-10 form-control" type="text" :value="deliveryOrder.supplier_details.trading_name" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2" style="text-right">Address:</label>
                                <input class="col-lg-10 form-control" type="text" :value="deliveryOrder.supplier_details.street" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2" style="text-right">&nbsp;</label>
                                <input class="col-lg-4 form-control" type="text" :value="deliveryOrder.supplier_details.state" disabled>
                                <input class="col-lg-3 form-control" type="text" :value="deliveryOrder.supplier_details.suburb" disabled>
                                <input class="col-lg-3 form-control" type="text" value="" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2" style="text-right">Phone:</label>
                                <input class="col-lg-10 form-control" type="text" :value="deliveryOrder.supplier_details.phone" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2" style="text-right">Fax:</label>
                                <input class="col-lg-10 form-control" type="text" :value="deliveryOrder.supplier_details.fax" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2" style="text-right">Contact:</label>
                                <input class="col-lg-10 form-control" type="text" :value="deliveryOrder.supplier_details.contact" disabled>
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="150" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row pb-2">
                                <label class="col-lg-2">Client:</label>
                                <input class="col-lg-10 form-control" type="text" disabled :value="job.trading_name" >
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-2">Job:</label>
                                <input class="col-lg-4 form-control" type="text" disabled :value="job.job_id" >
                                <span class="col-lg-4">&nbsp;</span>
                            </div>
                            <div class="row pb-4">
                                <label class="col-lg-2">Rep:</label>
                                <input class="col-lg-10 form-control" type="text" :value="primarySalesPersonName" disabled >
                            </div>
                            <div class="row">
                                <label class="col-lg-3">Placed by:</label>
                                <input class="col-lg-5 form-control" type="text" value="" >
                                <span class="col-lg-4">&nbsp;</span>
                            </div>
                        </div>
                    </portlet-content>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <portlet-content :height="210" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-1">
                            <div class="row">
                                <div class="col-lg-2">
                                    <span class="background-black p-1">
                                        Deliver to
                                    </span>
                                </div>
                                <textarea class="col-lg-10" name="" id="" cols="8" rows="1"></textarea>
                            </div>
                            <div class="row py-2 mt-2">
                                <input class="form-control" type="text" :value="deliveryOrder.delivery_address.name" disabled>
                            </div>
                            <div class="row pb-2">
                                <input class="form-control" type="text" :value="deliveryOrder.delivery_address.street" disabled>
                            </div>
                            <div class="row pb-2">
                                <input class="form-control" type="text" :value="deliveryOrder.delivery_address.town" disabled>
                            </div>
                            <div class="row pb-2">
                                <input class="col-2 form-control" type="text" :value="deliveryOrder.delivery_address.state" disabled>
                                <input class="col-2 form-control" type="text" value="" disabled>
                            </div>
                            <div class="row pb-2">
                                <input class="col-4 form-control" type="text" :value="deliveryOrder.delivery_address.phone" disabled>
                                <span class="col-2">&nbsp;</span>
                                <label class="col-lg-2" style="text-right">Fax:</label>
                                <input class="col-lg-4 form-control" type="text" :value="deliveryOrder.delivery_address.fax" disabled>
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="160" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="pt-4">
                            <div class="row pb-2">
                                <label class="col-lg-5 text-right">Cost Price: </label>
                                <input class="col-lg-5 form-control text-right" type="text" :value="displayMoney(deliveryOrder.costed_price)" disabled>
                            </div>
                            <div class="row pb-2">
                            <label class="col-lg-5 text-right">Invoiced Received: </label>
                                <input class="col-lg-5 form-control text-right" type="text" :value="displayMoney(deliveryOrder.invoice_received_amount)" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-5 text-right">Due Date: </label>
                                <input class="col-lg-5 form-control" type="text" :value="formatViewDate(deliveryOrder.due_date)" disabled>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-5 text-right">Last Date Rcvd: </label>
                                <input class="col-lg-5 form-control" type="text" :value="formatViewDate(deliveryOrder.last_date_received)" disabled>
                            </div>
                        </div>
                    </portlet-content>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <portlet-content :height="250" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-3">
                            <div class="row">
                                <span class="col-3"></span>
                                <label class="col-3 text-right">
                                    System Generated Order Number:
                                </label>
                                <span class="text-primary h3">@{{ deliveryOrder.id }}</span>     
                            </div>
                            <div class="row pt-1">
                                <span class="col-3"></span>
                                <label class="col-3 text-right">
                                    Interim Order Number:
                                </label>
                                <span class="h5">@{{ deliveryOrder.interim_order_number }}</span>     
                            </div>
                            <div class="row pt-1">
                                <span class="col-3"></span>
                                <label class="col-3 text-right">
                                    Order Date:
                                </label>
                                <span class="h4">@{{ formatViewDate(deliveryOrder.order_date) }}</span>     
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="120" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row pb-2">
                                <label class="col-lg-3">Date:</label>
                                <input class="col-lg-3 form-control text-right" type="text" value="">
                                <div class="col-lg-3">&nbsp;</div>
                                <div class="col-lg-3">
                                    <span class="background-red">Cancellation</span>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4" class="form-controls" style="text-right">Explanation:</label>
                            </div>
                            <div class="row pb-2">
                                <textarea name="" id="" cols="8" rows="1"></textarea>
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
                                <input class="col-2 text form-control" type="text" value="">
                                <input class="col-5 text form-control pl-1" type="text" value="">
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
                                <textarea class="col-11" cols="10" rows="2"></textarea>
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
                                        <td class="table-head col-8">&nbsp;</td>
                                        <td class="table-head col-1">Job</td>
                                        <td class="table-head col-1">Due Date</td>
                                        <td class="table-head col-1">Received</td>
                                        <td class="table-head col-1">Pending</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row table-wrap" style="max-height: 150px;overflow-y: auto;">
                            <table class="table">
                                <tbody>
                                    <tr class="row col-12 text-bold" v-for="(futureStock, index) in deliveryOrder.future_stocks" >
                                        <td class="col-8 form-control">
                                            @{{ futureStock.quantity }} &nbsp; 
                                            @{{ futureStock.unit }} &nbsp; 
                                            @{{ futureStock.color.product.name }},&nbsp; 
                                            @{{ futureStock.color.name }} &nbsp;@
                                            <template v-if="futureStock.list_price">$@{{ futureStock.list_price }}</template>&nbsp;
                                            <template v-if="futureStock.discount">minus @{{ futureStock.discount }}% </template>
                                            <template v-if="futureStock.tax">plus @{{ futureStock.tax }}% GST</template>.
                                        </td>
                                        <td class="col-1 form-control">&nbsp;</td>
                                        <td class="col-1 form-control">@{{ formatViewDate(deliveryOrder.due_date) }}</td>
                                        <td class="col-1 form-control">@{{ displayNumber(futureStock.received) }}</td>
                                        <td class="col-1 form-control">@{{ displayNumber(futureStock.quantity - futureStock.received) }}</td>
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
                    <button 
                        type="button" 
                        class="btn action-buttons"
                        @click="openModal('SearchDeliveryOrdersModal')"
                    >Search</button>
                    <button type="button" class="btn action-buttons">Help</button>
                    <!-- <label>Use the 'Index=' button to change lookup '?' browsing order </label> -->
                    <button type="button" class="btn action-buttons text-primary">index = ONO</button>
                </div>
                <span class="background-black mr-3 my-1 px-3">
                    Delivered Orders
                </span>
            </div>
        </portlet-content>
    </div>
    <template v-if="mountSearchDeliveryOrdersModal">
        <search-delivery-orders
            @selected="handleSelectDelivery"
            @close="closeModal('SearchDeliveryOrdersModal')"
        />
    </template>
</div>
