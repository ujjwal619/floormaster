<div class="row ">
	<div class="col-lg-6">
		<portlet-content header="Company" subheader="Details" isform="true">
			<template slot="body">
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-12">
							<label class="required">Trading Name</label>
							<input type="text"
							       name="company_name"
							       :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
							       v-model="values.customer.trading_name">
							<span class="form-error"
							      v-if="form.errors.has('customer.trading_name')"
							      v-text="form.errors.get('customer.trading_name')"></span>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label class="required">Street</label>
							<input type="text"
							       name="street"
							       :class="{ 'input-error' : form.errors.has('customer.address.street'), 'form-control': loaded }"
							       v-model="values.customer.address.street"
							>
							<span class="form-error"
							      v-if="form.errors.has('customer.address.street')"
							      v-text="form.errors.get('customer.address.street')"></span>
						</div>
						
						<div class="col-lg-6">
							<label class="required">Town</label>
							<input type="text"
							       name="town"
							       :class="{ 'input-error' : form.errors.has('customer.address.town'), 'form-control': loaded }"
							       v-model="values.customer.address.town">
							<span class="form-error"
							      v-if="form.errors.has('customer.address.town')"
							      v-text="form.errors.get('customer.address.town')"></span>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<div class="row">
								<div class="col-lg-5">
									<label class="required" for="gender">State </label>
									<input type="text"
									       name="state"
									       :class="{ 'input-error' : form.errors.has('customer.address.state'), 'form-control': loaded }"
									       v-model="values.customer.address.state">
									<span class="form-error"
									      v-if="form.errors.has('customer.address.state')"
									      v-text="form.errors.get('customer.address.state')"></span>
								</div>
								<div class="col-lg-7">
									<label class="required" for="gender">Code</label>
									<input type="text"
									       name="code"
									       :class="{ 'input-error' : form.errors.has('customer.address.code'), 'form-control': loaded }"
									       v-model="values.customer.address.code">
									<span class="form-error"
									      v-if="form.errors.has('customer.address.code')"
									      v-text="form.errors.get('customer.address.code')"></span>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<label class="required" for="gender">Phone</label>
							<input type="text"
							       name="phone"
							       :class="{ 'input-error' : form.errors.has('customer.phone'), 'form-control': loaded }"
							       v-model="values.customer.phone">
							<span class="form-error"
							      v-if="form.errors.has('customer.phone')"
							      v-text="form.errors.get('customer.phone')"></span>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label class="required">Fax</label>
							<input type="text"
							       name="fax"
							       :class="{ 'input-error' : form.errors.has('customer.fax'), 'form-control': loaded }"
							       v-model="values.customer.fax">
							<span class="form-error"
							      v-if="form.errors.has('customer.fax')"
							      v-text="form.errors.get('customer.fax')"></span>
						</div>
					</div>
					
					<hr/>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-3">
							<label class="required" for="gender">A.C.N</label>
							<input type="text"
							       :class="{ 'input-error' : form.errors.has('customer.acn'), 'form-control': loaded }"
							       v-model="values.customer.acn">
							<span class="form-error"
							      v-if="form.errors.has('customer.acn')"
							      v-text="form.errors.get('customer.acn')"></span>
						</div>
						
						<div class="col-lg-3">
							<label class="required" for="gender">Group ID</label>
							<input type="text"
							       name="group_id"
							       :class="{ 'input-error' : form.errors.has('customer.group_id'), 'form-control': loaded }"
							       v-model="values.customer.group_id">
							<span class="form-error"
							      v-if="form.errors.has('customer.group_id')"
							      v-text="form.errors.get('customer.group_id')"></span>
						</div>
						
						
						<div class="col-lg-6">
							<label class="required">A.B.N</label>
							<input type="text"
							       :class="{ 'input-error' : form.errors.has('customer.abn'), 'form-control': loaded }"
							       v-model="values.customer.abn">
							<span class="form-error"
							      v-if="form.errors.has('customer.abn')"
							      v-text="form.errors.get('customer.abn')"></span>
						</div>
					</div>
				
				
				</div>
			
			</template>
		</portlet-content>
		
		<portlet-content header="Postal" subheader="Address" isform="true">
			<template slot="body">
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-12">
							<label class="required">Street</label>
							<input type="text"
							       name="street"
							       :class="{ 'input-error' : form.errors.has('customer.postal_address.street'), 'form-control': loaded }"
							       v-model="values.customer.postal_address.street">
							<span class="form-error"
							      v-if="form.errors.has('customer.postal_address.street')"
							      v-text="form.errors.get('customer.postal_address.street')"></span>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label class="required">Town</label>
							<input type="text"
							       name="town"
							       :class="{ 'input-error' : form.errors.has('customer.postal_address.town'), 'form-control': loaded }"
							       v-model="values.customer.postal_address.town">
							<span class="form-error"
							      v-if="form.errors.has('customer.postal_address.town')"
							      v-text="form.errors.get('customer.postal_address.town')"></span>
						</div>
						
						<div class="col-lg-3">
							<label class="required" for="gender">State</label>
							<input type="text"
							       name="state"
							       :class="{ 'input-error' : form.errors.has('customer.postal_address.state'), 'form-control': loaded }"
							       v-model="values.customer.postal_address.state">
							<span class="form-error"
							      v-if="form.errors.has('customer.postal_address.state')"
							      v-text="form.errors.get('customer.postal_address.state')"></span>
						</div>
						
						<div class="col-lg-3">
							<label class="required">Code</label>
							<input type="text"
							       name="code"
							       :class="{ 'input-error' : form.errors.has('customer.postal_address.code'), 'form-control': loaded }"
							       v-model="values.customer.postal_address.code">
							<span class="form-error"
							      v-if="form.errors.has('customer.postal_address.code')"
							      v-text="form.errors.get('customer.postal_address.code')"></span>
						</div>
					
					</div>
				</div>
			</template>
		</portlet-content>
		
		<portlet-content header="Delivery" subheader="Address" isform="true">
			<template slot="body">
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-12">
							<label class="required">Name</label>
							<input type="text"
							       name="company_name"
							       :class="{ 'input-error' : form.errors.has('customer.delivery_address.name'), 'form-control': loaded }"
							
							       v-model="values.customer.delivery_address.name">
							<span class="form-error"
							      v-if="form.errors.has('customer.delivery_address.name')"
							      v-text="form.errors.get('customer.delivery_address.name')"></span>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label class="required">Street</label>
							<input type="text"
							       name="street"
							       :class="{ 'input-error' : form.errors.has('customer.delivery_address.street'), 'form-control': loaded }"
							       v-model="values.customer.delivery_address.street">
							<span class="form-error"
							      v-if="form.errors.has('customer.delivery_address.street')"
							      v-text="form.errors.get('customer.delivery_address.street')"></span>
						</div>
						<div class="col-lg-6">
							<label class="required">Town</label>
							<input type="text"
							       name="town"
							       :class="{ 'input-error' : form.errors.has('customer.delivery_address.town'), 'form-control': loaded }"
							       v-model="values.customer.delivery_address.town">
							<span class="form-error"
							      v-if="form.errors.has('customer.delivery_address.town')"
							      v-text="form.errors.get('customer.delivery_address.town')"></span>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<div class="row">
								<div class="col-lg-7">
									<label class="required" for="gender">State </label>
									<input type="text"
									       name="state"
									       :class="{ 'input-error' : form.errors.has('customer.delivery_address.state'), 'form-control': loaded }"
									       v-model="values.customer.delivery_address.state">
									<span class="form-error"
									      v-if="form.errors.has('customer.delivery_address.state')"
									      v-text="form.errors.get('customer.delivery_address.state')"></span>
								</div>
								<div class="col-lg-5">
									<label class="required" for="gender">Code</label>
									<input type="text"
									       name="code"
									       :class="{ 'input-error' : form.errors.has('customer.delivery_address.code'), 'form-control': loaded }"
									       v-model="values.customer.delivery_address.code">
									<span class="form-error"
									      v-if="form.errors.has('customer.delivery_address.code')"
									      v-text="form.errors.get('customer.delivery_address.code')"></span>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<label class="required" for="gender">Phone</label>
							<input type="text"
							       :class="{ 'input-error' : form.errors.has('customer.delivery_address.phone'), 'form-control': loaded }"
							       v-model="values.customer.delivery_address.phone">
							<span class="form-error"
							      v-if="form.errors.has('customer.delivery_address.phone')"
							      v-text="form.errors.get('customer.delivery_address.phone')"></span>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label class="required" for="gender">Fax</label>
							<input type="text"
							       :class="{ 'input-error' : form.errors.has('customer.delivery_address.fax'), 'form-control': loaded }"
							       v-model="values.customer.delivery_address.fax">
							<span class="form-error"
							      v-if="form.errors.has('customer.delivery_address.fax')"
							      v-text="form.errors.get('customer.delivery_address.fax')"></span>
						</div>
					</div>
			</template>
		</portlet-content>
	</div>
	<div class="col-lg-6">
		<div class="row">
			<div class="col-lg-6">
				<portlet-content header="Job Sources">
					<template slot="body">
						<div class="form-group m-form__group row">
							<div class="col-md-8">
								<select class="form-control" v-model="selectedJob" placeholder="Select job">
									<option value="">Select job source</option>
									<option v-for="(jobsource, key) in JSON.parse(jobsources)" :value="key"
									>
										@{{ jobsource }}
									</option>
								</select>
							</div>
							<div class="col-md-4">
								<button class="btn btn-primary m-btn--sm" title="Save" data-toggle="tooltip"
								        @click="addJobSources()">ADD
								</button>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-lg-12">
								<table class="table">
									<tbody>
									<tr v-for="jobId in values.selectedJobs">
										<td>@{{ getJobName(jobId) }}</td>
										<td width="15%">
											<button class="btn btn-danger m-btn--sm btn-sm"
											        @click="removeJobSource(jobId)"><i class="fa fa-trash"></i></button>
										</td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</template>
				</portlet-content>
			</div>
			
			<div class="col-lg-6">
				<portlet-content header="Sales Staff">
					<template slot="body">
						<div class="form-group m-form__group row">
							<div class="col-md-8">
								<select class="form-control" v-model="selectedSale" placeholder="Select job">
									<option value="">Select sales staff</option>
									<option v-for="(sale, key) in JSON.parse(sales)" :value="key"
									>
										@{{ getSalesName(key) }}
									</option>
								</select>
							</div>
							<div class="col-md-4">
								<button class="btn btn-primary m-btn--sm" title="Save" data-toggle="tooltip"
								        @click="addSalesStaff()">ADD
								</button>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-lg-12">
								<table class="table">
									<tbody>
									<tr v-for="salesId in values.selectedSales">
										<td>@{{ getSalesName(salesId) }}</td>
										<td width="15%">
											<button class="btn btn-danger m-btn--sm btn-sm"
											        @click="removeSalesStaff(salesId)"><i class="fa fa-trash"></i>
											</button>
										</td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</template>
				</portlet-content>
			</div>
		</div>
		
		<portlet-content header="Sites">
			<template slot="body">
				<div class="form-group m-form__group row">
					<div class="col-md-6">
						<label class="required" for="gender">Shop Name</label>
						<input type="text"
						       :class="{ 'input-error' : form.errors.has('shop_name'), 'form-control': loaded }"
						       v-model="shop_name">
						<span class="form-error"
						      v-if="form.errors.has('shop_name')"
						      v-text="form.errors.get('shop_name')"></span>
					</div>
					<div class="col-md-3">
						<label for="gender">G.L Suffix</label>
						<input type="text"
						       :class="{ 'input-error' : form.errors.has('gl_suffix'), 'form-control': loaded }"
						       v-model="gl_suffix">
						<span class="form-error"
						      v-if="form.errors.has('gl_suffix')"
						      v-text="form.errors.get('gl_suffix')"></span>
					</div>
					<div class="col-md-3">
						<button class="btn btn-primary m-btn--sm mt-28" title="Save" data-toggle="tooltip"
						        @click="addNewSite()">ADD
						</button>
					</div>
				</div>
				<hr/>
				<table class="table">
					<tbody>
					<tr v-for="(site, index) in values.sites" :key="index">
						<td width="50%">
							<span v-if="!site.is_edit" v-text="site.shop_name"></span>
							<input type="text" v-else v-model="site.shop_name" class="form-control"/>
						</td>
						<td width="30%">
							<span v-if="!site.is_edit" v-text="site.gl_suffix"></span>
							<input type="text" v-else v-model="site.gl_suffix" class="form-control"/>
						</td>
						<td nowrap="">
							<a href="javascript:void(0)" class="btn btn-sm"
							   :class="site.is_edit ? 'btn-success' : 'btn-primary'"
							   @click.prevent="handleSiteEditClick(index)">
								<i class="fa" :class="site.is_edit ? 'fa-save' : 'fa-edit'"></i>
							</a>
							<a href="javascript:void(0)"
							   class="btn btn-sm btn-danger"
							   @click.prevent="removeSite(index, site)"
							><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					</tbody>
				</table>
			</template>
		</portlet-content>
		
		{{--Minor check boxes and radio butons for form--}}
		<portlet-content :onlybody="true">
			<template slot="body">
				<h6>Remittance Printing</h6>
				<div class="m-radio-inline">
					<label class="m-radio">
						<input type="radio" value="letter_head" v-model="values.settings.remittance_printing">
						Remittance on LetterHead
						<span></span>
					</label>
					<label class="m-radio">
						<input type="radio" value="cheque_form" v-model="values.settings.remittance_printing">
						Cheque form
						<span></span>
					</label>
				</div>
				<hr/>
				<h6>Automated Stock Control</h6>
				<div class="m-checkbox-inline">
					<label class="m-checkbox">
						<input type="checkbox" value="auto_generate" v-model="values.settings.automated_stock_control">
						Auto Generate Stock Tags
						<span></span>
					</label>
				</div>
				<hr/>
				<h6>Prompts</h6>
				<div class="m-checkbox-inline">
					<label class="m-checkbox">
						<input type="checkbox" value="prompt_booking" v-model="values.settings.prompts">
						Prompt Booking Serial No
						<span></span>
					</label>
					<label class="m-checkbox">
						<input type="checkbox" value="auto_change" v-model="values.settings.prompts">
						Auto Change Invoice Text
						<span></span>
					</label>
				</div>
			</template>
		
		</portlet-content>
		
		{{--GL Recording--}}
		<portlet-content :onlybody="true">
			<template slot="body">
				<h6>G.L. Recording is: </h6>
				<div class="m-radio-inline">
					<label class="m-radio">
						<input type="radio" value="on" v-model="values.settings.gl_recording">
						On
						<span></span>
					</label>
					<label class="m-radio">
						<input type="radio" value="off" v-model="values.settings.gl_recording">
						Off
						<span></span>
					</label>
				</div>
				<hr/>
			</template>
		
		</portlet-content>
		<button class="btn btn-success pull-right" @click.prevent="submit">Save</button>
	</div>
</div>