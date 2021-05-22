<div class="form-container">
    <template>
        <loading :loading="loading" />
    </template>
    <div class="col-xsmall-12 col-small-12">
        <div class="row">
        <div class="col-12 row">
            <span class="col-lg-1 text-right h4">Store:</span>
            <drop-down
                class="col-3"
                :options="sites"
                v-model="selectedSite"
                style="max-height: 40px;"
                :default-selected="sites[0]"
            />
        </div>
            <div class="col-6 pt-3">
                <div class="row">
                    <portlet-content :height="580" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="form-group p-2">
                            <div class="row pb-2">
                                <div class="col-lg-2">
                                    <span class="background-black text-truncate"> Company Details</span>
                                </div>
                              <label class="col-lg-2 text-right">Trading Name:</label>
                              <input :disabled="!isEditMode" v-model="model.company_details.name" class="col-lg-8 form-control" type="text">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">Street:</label>
                                <input :disabled="!isEditMode" v-model="model.company_details.street" class="col-lg-8 form-control" type="text">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">Town:</label>
                                <input :disabled="!isEditMode" v-model="model.company_details.town" class="col-lg-6 form-control" type="text">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">State/Code:</label>
                                <input :disabled="!isEditMode" v-model="model.company_details.state" class="col-lg-2 form-control" type="text">
                                <input :disabled="!isEditMode" v-model="model.company_details.code" class="col-lg-2 form-control" type="number">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">Phone:</label>
                                <input :disabled="!isEditMode" v-model="model.company_details.phone" class="col-lg-6 form-control" type="number">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">Fax:</label>
                                <input :disabled="!isEditMode" v-model="model.company_details.fax" class="col-lg-6 form-control" type="number">
                            </div>
                            <br/>
                            <div class="row pb-2">
                                <label class="col-4 text-right text-primary">A.C.N.</label>
                                <input :disabled="!isEditMode" v-model="model.company_details.acn" class="col-3 form-control text-primary" type="number">
                                <label class="col-1 text-right">Group I.D.</label>
                                <input :disabled="!isEditMode" v-model="model.company_details.group_id" class="col-2 form-control" type="text">
                            </div>
                            <div class="row pb-2">
                                <label class="col-4 text-right text-primary">A.B.N</label>
                                <input :disabled="!isEditMode" v-model="model.company_details.abn" class="col-3 form-control text-primary" type="number">
                            </div>
                            <br/>
                            <br/>
                            <div class="row pb-2">
                                <div class="col-lg-2">
                                    <span class="background-black text-truncate">Postal Address</span>
                                </div>
                                <label class="col-lg-2 text-right">Street:</label>
                                <input :disabled="!isEditMode" v-model="model.postal_address.street" class="col-lg-8 form-control" type="text">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">Town:</label>
                                <input :disabled="!isEditMode" v-model="model.postal_address.town" class="col-lg-6 form-control" type="text">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">State/Code:</label>
                                <input :disabled="!isEditMode" v-model="model.postal_address.state" class="col-lg-2 form-control" type="text">
                                <input :disabled="!isEditMode" v-model="model.postal_address.code" class="col-lg-2 form-control" type="number">
                            </div>
                            <br/>
                            <br/>
                            <div class="row pb-2">
                                <div class="col-lg-2">
                                    <span class="background-black text-truncate">Delivery Address</span>
                                </div>
                                <label class="col-lg-2 text-right">Name:</label>
                                <input :disabled="!isEditMode" v-model="model.delivery_address.name" class="col-lg-8 form-control" type="text">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">Street:</label>
                                <input :disabled="!isEditMode" v-model="model.delivery_address.street" class="col-lg-6 form-control" type="text">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">Town:</label>
                                <input :disabled="!isEditMode" v-model="model.delivery_address.town" class="col-lg-6 form-control" type="text">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">State/Code:</label>
                                <input :disabled="!isEditMode" v-model="model.delivery_address.state" class="col-lg-2 form-control" type="text">
                                <input :disabled="!isEditMode" v-model="model.delivery_address.code" class="col-lg-2 form-control" type="number">
                            </div>
                            <div class="row pb-2">
                                <label class="col-lg-4 text-right">Phone:</label>
                                <input :disabled="!isEditMode" v-model="model.delivery_address.phone" class="col-lg-2 form-control" type="number">
                                <label class="col-lg-1 text-right">Fax:</label>
                                <input :disabled="!isEditMode" v-model="model.delivery_address.fax" class="col-lg-2 form-control" type="text">
                            </div>
                        </div>
                    </portlet-content>
                    {{--<portlet-content :height="190" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="row pb-2 p-2">
                            <div class="col-lg-3">
                                <span class="background-black text-truncate">Sites</span>
                            </div>
                            <div class="col-lg-8">&nbsp;</div>
                            <div class="col-lg-1">
                                <button type="button" class="btn action-buttons" @click="openAddSiteModal">Add</button>
                            </div>
                            <div class="col-lg-2">
                                &nbsp;
                            </div>
                            <div class="col-lg-8 mt-1" style="max-height: 130px;overflow-y: scroll;">
                                <table class="short-table table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%">Shop Name</th>
                                            <th style="width: 20%">GL Suffix</th>
                                            <th style="width: 40%">Letterhead Path</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(site, key) in sites" @dblClick="editSite(site)">
                                            <td style="width: 40%" >
                                               @{{ site.name }}
                                            </td>
                                            <td style="width: 20%">
                                              @{{ site.gl_suffix }}
                                            </td>
                                            <td style="width: 40%">
                                              @{{ site.letterhead_path }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </portlet-content> --}}
                    <portlet-content :height="120" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row pb-2">
                                <div class="col-lg-4">
                                    <span class="background-black text-truncate">Remittances Printing</span>
                                </div>
                                <div class="col-lg-4">
                                    <span class="background-black text-truncate">Automated Stock Control</span>
                                </div>
                                <div class="col-lg-4">
                                    <span class="background-black text-truncate">Prompts</span>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-4">
                                    <input :disabled="!isEditMode" type="radio" name="remittance"> 
                                    <span class="text-primary">Remittance on Letterhead</span>
                                </div>
                                <div class="col-lg-4">
                                    <input :disabled="!isEditMode" type="checkbox" name=""> 
                                    <span class="text-primary">Auto Generate Stock Tags</span>
                                </div>
                                <div class="col-lg-4">
                                    <input :disabled="!isEditMode" type="checkbox" name=""> 
                                    <span>Prompt Booking Serial No.</span>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-4">
                                    <input :disabled="!isEditMode" type="radio" name="remittance"> 
                                    <span class="text-primary">Custom Cheque Form</span>
                                </div>
                                <div class="col-lg-4">
                                    &nbsp;
                                </div>
                                <div class="col-lg-4">
                                    <input :disabled="!isEditMode" type="checkbox" name="" > 
                                    <span>Auto Change Invoice Text</span>
                                </div>
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="50" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row pb-2">
                                <div class="col-2">
                                    <span class="background-black text-truncate">Counters</span>
                                </div>
                                <div class="col-2 mr-2">
                                    <div class="row">
                                        <label class="col-6 text-right">Quotes/Jobs:</label>
                                        <input :disabled="!isEditMode" class="col-6 form-control" type="number">
                                    </div>
                                </div>
                                <div class="col-2 mr-2">
                                    <div class="row">
                                        <label class="col-5 text-right">Cheques:</label>
                                        <input :disabled="!isEditMode" class="col-6 form-control" type="number">
                                    </div>
                                </div>
                                <div class="col-2 mr-2">
                                    <div class="row">
                                        <label class="col-5 text-right">EFTs:</label>
                                        <input :disabled="!isEditMode" class="col-6 form-control" type="number">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        <label class="col-5 text-right">Orders:</label>
                                        <input :disabled="!isEditMode" class="col-6 form-control" type="number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </portlet-content>
                </div>
            </div>
            <div class="col-6 pt-3">
                <div class="row">
                    <portlet-content :height="200" :onlybody="true" class="col-6 px-2">
                        <div slot="body" class=" p-2">
                            <div class="row fm-flex fm-justify-between">
                                <span class="background-black text-truncate">Job Sources</span>
                                <button type="button" class="btn action-buttons" @click="openJobSourceModal">Add</button>
                            </div>
                            <div class="row mt-1">
                                <div class="col-2">&nbsp;</div>
                                <div class="col-8 mt-2" style="max-height: 145px;overflow-y: auto;">
                                    <table class="short-table table table-bordered">
                                        <tbody>
                                            <tr v-for="(jobSource, key) in jobSources" :key="key">
                                                <td @dblClick="editJobSource(jobSource)">
                                                   @{{ jobSource.title }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="200" :onlybody="true" class="col-6 px-2">
                        <div slot="body" class="p-2">
                            <div class="row fm-flex fm-justify-between">
                                <span class="background-black text-truncate">Sales Staff</span>
                                <button type="button" class="btn action-buttons" @click="openSalesStaffModal">Add</button>
                            </div>
                            <div class="row">
                                <div class="col-2">&nbsp;</div>
                                <div class="col-8 mt-2" style="max-height: 140px;overflow-y: auto;">
                                    <table class="short-table table table-bordered">
                                        <tbody>
                                            <tr v-for="staff in salesStaffs" :key="staff.id">
                                                <td  @dblClick="editSalesStaff(staff)">
                                                    @{{ staff.name }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="300" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row fm-flex-inline fm-space-between">
                                <div class="col-4">
                                    <span class="background-black text-truncate">Automated Memos</span>
                                </div>
                                <span class="text-primary text-truncate col-8">Selected user will receive Memos when the nominated event occurs.</span>
                            </div>
                            <div class="row pt-4">
                                <span class="text-right col-2 h5 text-bold">Notify:</span>
                                <div class="col-4 mr-2 ml-2">
                                    <drop-down
                                        :disabled="!isEditMode"
                                        :options="users"
                                        label="username"
                                        v-model="model.retention_release_user_id"
                                        :default-selected="model.retention_release_user"
                                    />
                                </div>
                                <input 
                                    :disabled="!isEditMode" 
                                    class="col-1 mr-2 form-control" 
                                    type="number"
                                    v-model="model.retention_release_days"
                                >
                                <label class="col-4">days before retention release</label>
                            </div>
                            <div class="row pt-3">
                                <label class="text-right col-2">&nbsp;</label>
                                <div class="col-4 mr-2 ml-2">
                                    <drop-down
                                        :disabled="!isEditMode"
                                        :options="users"
                                        label="username"
                                        v-model="model.customer_complaint_unresolved_user_id"
                                        :default-selected="model.customer_complaint_unresolved_user"
                                    />
                                </div>
                                <input 
                                    :disabled="!isEditMode" 
                                    class="col-1 mr-2 form-control" 
                                    type="number"
                                    v-model="model.customer_complaint_unresolved_days"
                                >
                                <label class="col-4">days Customer Complaint unresolved</label>
                            </div>
                            <div class="row pt-3">
                                <label class="text-right col-2">&nbsp;</label>
                                <div class="col-4 mr-2 ml-2">
                                    <drop-down
                                        :disabled="!isEditMode"
                                        :options="users"
                                        label="username"
                                        v-model="model.stock_below_reorder_user_id"
                                        :default-selected="model.stock_below_reorder_user"
                                    />
                                </div>
                                <label class="col-4">when stock for sale falls below Re-Order</label>
                            </div>
                            <div class="row pt-3">
                                <label class="text-right col-2">&nbsp;</label>
                                <div class="col-4 mr-2 ml-2">
                                    <drop-down
                                        :disabled="!isEditMode"
                                        :options="users"
                                        label="username"
                                        v-model="model.purchase_orders_overdue_user_id"
                                        :default-selected="model.purchase_orders_overdue_user"
                                    />
                                </div>
                                <label class="col-4">Purchase Orders are overdue</label>
                            </div>
                            <div class="row pt-3">
                                <label class="text-right col-2">&nbsp;</label>
                                <div class="col-4 mr-2 ml-2">
                                    <drop-down
                                        :disabled="!isEditMode"
                                        :options="users"
                                        label="username"
                                        v-model="model.jobs_invoiced_less_than_quoted_at_complition_user_id"
                                        :default-selected="model.jobs_invoiced_less_than_quoted_at_complition_user"
                                    />
                                </div>
                                <label class="col-4">Jobs invoiced < Quoted @ Completion</label>
                            </div>
                        </div>
                    </portlet-content>
                    <portlet-content :height="50" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2 fm-flex fm-justify-center">
                            <span class="text-blue mr-4">G.L. Recording is</span>
                            <input :disabled="!isEditMode" type="radio" name="gl_recording" v-model="model.gl_recording" value="1" class="mt-2"><span class="text-primary mr-2">ON</span>
                            <input :disabled="!isEditMode" type="radio" name="gl_recording" v-model="model.gl_recording" value="0" class="mt-2"><span class="text-red">OFF</span>
                        </div>
                    </portlet-content>
                    <portlet-content :height="390" :onlybody="true" class="col-12 px-2">
                        <div slot="body" class="p-2">
                            <div class="row">
                                <span class="background-white col-4">Current Year System Accounts</span>
                                <label class="col-1 text-right">GST%:</label>
                                <input :disabled="!isEditMode" class="col-1 text-danger form-control" type="number" v-model="model.gst">
                                <span class="background-white col-1 text-right mr-2">GST Basis:</span>
                                <input :disabled="!isEditMode" type="radio" name="basis" v-model="model.gst_basis" value="accrual" class="mt-2"><span class="col-1 text-primary">Accrual</span>
                                <input :disabled="!isEditMode" type="radio" name="basis" v-model="model.gst_basis" value="cash" class="mt-2"><span class="col-1 text-primary">Cash</span>
                                {{--<button type="button" class="btn action-buttons text-primary"><< Pick</button>--}}
                            </div>
                            <div class="row pt-3">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">GST Billed on Sales:</span>
                                <input type="text" class="col-4 form-control text-primary" v-model="model.gst_billed_on_sales.name" disabled>
                                <input type="text" class="col-2 form-control text-primary text-right" v-model="model.gst_billed_on_sales.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('gst_billed_on_sales')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">GST on Creditors:</span>
                                <input type="text" class="col-4 form-control text-primary" v-model="model.gst_on_creditors.name" disabled>
                                <input type="text" class="col-2 form-control text-primary text-right" v-model="model.gst_on_creditors.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('gst_on_creditors')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">Trade Creditors:</span>
                                <input type="text" class="col-4 form-control" v-model="model.trade_creditors.name" disabled>
                                <input type="text" class="col-2 form-control text-right" v-model="model.trade_creditors.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('trade_creditors')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">Trade Debtors:</span>
                                <input type="text" class="col-4 form-control" v-model="model.trade_debtors.name" disabled>
                                <input type="text" class="col-2 form-control text-right" v-model="model.trade_debtors.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('trade_debtors')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">Money in Trust:</span>
                                <input type="text" class="col-4 form-control" v-model="model.money_in_trust.name" disabled>
                                <input type="text" class="col-2 form-control text-right" v-model="model.money_in_trust.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('money_in_trust')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">Job Retention:</span>
                                <input type="text" class="col-4 form-control" v-model="model.job_retention.name" disabled>
                                <input type="text" class="col-2 form-control text-right" v-model="model.job_retention.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('job_retention')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">Cheque Account:</span>
                                <input type="text" class="col-4 form-control" v-model="model.cheque_account.name" disabled>
                                <input type="text" class="col-2 form-control text-right" v-model="model.cheque_account.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('cheque_account')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">Delivery-Baling:</span>
                                <input type="text" class="col-4 form-control" v-model="model.delivery_bailing.name" disabled>
                                <input type="text" class="col-2 form-control text-right" v-model="model.delivery_bailing.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('delivery_bailing')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">Discounts Received:</span>
                                <input type="text" class="col-4 form-control" v-model="model.discounts_received.name" disabled>
                                <input type="text" class="col-2 form-control text-right" v-model="model.discounts_received.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('discounts_received')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">Retained Earnings:</span>
                                <input type="text" class="col-4 form-control" v-model="model.retained_earnings.name" disabled>
                                <input type="text" class="col-2 form-control text-right" v-model="model.retained_earnings.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('retained_earnings')"
                                ><< Pick</button>
                            </div>
                            <div class="row">
                                <span class="background-white col-4 pr-3 h6 d-inline-flex justify-content-end align-items-center">Current Earnings:</span>
                                <input type="text" class="col-4 form-control" v-model="model.current_earnings.name" disabled>
                                <input type="text" class="col-2 form-control text-right" v-model="model.current_earnings.code" disabled>
                                <button
                                        :disabled="!isEditMode"
                                        type="button"
                                        class="btn action-buttons text-primary"
                                        @click="pickAccount('current_earnings')"
                                ><< Pick</button>
                            </div>
                        </div>
                    </portlet-content>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xsmall-12 col-small-12 mt-4">
        <portlet-content isform="true" :onlybody="true">
            <div slot="body" class="menu-bar fm-flex fm-justify-between">
                <div class="mt-1">
                    <button type="button" class="btn action-buttons" v-if="!isEditMode" @click="enableEditMode">Edit</button>
                    <button type="button" class="btn action-buttons" v-if="isEditMode" @click="saveStoreData">Save</button>
                    <button type="button" class="btn action-buttons" v-if="isEditMode" @click="cancelEditMode">Cancel</button>
                </div>
                <span class="background-black text-truncate mr-3 my-1">
                    Set-Up
                </span>
            </div>
        </portlet-content>
    </div>
    <template v-if="mountJobSource">
        <add-job-source
            :site="selectedSite"
            :job-source="selectedJobSource"
            @saved="jobSourceSaveHandler"
            @close="closeJobSourceModal"
        />
    </template>
    {{--<template v-if="mountAddSite">
        <add-site
            :site-data="selectedSite"
            @close="closeAddSiteModal"
        />
    </template>--}}
    <template v-if="mountSalesStaff">
        <sales-staff 
            :site="selectedSite"
            :sales-staff="selectedSalesStaff"
            @saved="salesStaffSaveHandler"
            @close="closeSalesStaffModal"
        />
    </template>
  <template v-if="mountSelectAccount">
    <select-account
            :type="accountModalFor"
            title="Select Account"
            :options="accounts"
            @selected="accountSelected"
            @close="closeSelectAccount"
    />
  </template>
</div>
