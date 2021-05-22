<div class="col-xsmall-12 col-small-12">
	<div class="table-wrap">
		<portlet-content onlybody>
			<template slot="body">
				<div class="row">
					<div style="width: 6%;">
						<label>UPC</label>
					</div>
					<div style="width: 5%;">
						<label>Quantity</label>
					</div>
					<div style="width: 20%;">
						<label>Supplier</label>
					</div>
					<div style="width: 20%;">
						<label>Range</label>
					</div>
					<div style="width: 20%;">
						<label>Color</label>
					</div>
					<div style="width: 7%;">
						<label>List Price</label>
					</div>
					<div style="width: 5%;">
						<label>Disc %</label>
					</div>
					<div style="width: 5%;">
						<label>GST %</label>
					</div>
					<div style="width: 5%;">
						<label>Levy</label>
					</div>
					<div style="width: 7%;">
						<label>Extension</label>
					</div>
				</div>
				<div class="row" style="max-height: 150px;overflow-y: scroll;">
					<table class="table table-bordered">
						<tbody>
							<tr 
								v-for="(material,index) in values.materials"
								:key="index"
								@click="openEditMaterialProductModal(material, index)"
							>
								<td style="width: 6%;">@{{ material.product_upc }}</td>
								<td style="width: 5%;">@{{ material.quantity }}</td>
								<td style="width: 20%;">@{{ material.supplier_name }}</td>
								<td style="width: 20%;">@{{ material.product_name }}</td>
								<td style="width: 20%;">@{{ material.variant_name }}</td>
								<td style="width: 7%;" class="text-right">@{{ displayMoney(material.unit) }}</td>
								<td style="width: 5%;">@{{ material.discount || 0 }}%</td>
								<td style="width: 5%;">@{{ material.gst || 0 }}%</td>
								<td style="width: 5%;">@{{ material.levy || 0 }}%</td>
								<td style="width: 7%;" class="text-right">@{{ displayMoney(material.total) }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</template>
		</portlet-content>
	</div>
	
	<div class="row">
		<div class="col-xsmall-12 col-small-6 table-wrap">
			<portlet-content onlybody>
				<template slot="body">
					<div class="col-xsmall-12" style="max-height: 120px;overflow-y: scroll;">
						<table class="table table-bordered">
							<tbody>
							<tr>
								<td>Quantity</td>
								<td>Labour Item</td>
								<td>Rate</td>
								<td>Extension</td>
							</tr>
							<tr 
							v-for="(material,index) in values.labours"
							:key="index"
							@click="openEditLabourProductModal(material)"
							>
								<td style="width: 10%">@{{ material.quantity }}</td>
								<td style="width: 10%">@{{ material.product }}</td>
								<td style="width: 10%" class="text-right">@{{ displayMoney(material.unit) }}</td>
								<td style="width: 10%" class="text-right">@{{ displayMoney(material.total) }}</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>Labour:</td>
								<td class="text-right">@{{ displayMoney(labourGrandTotal) }}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</template>
			</portlet-content>
		</div>
		
		<div class="col-xsmall-12 col-small-6">
			<portlet-content onlybody>
				<template slot="body">
					<div class="row">
						<div class="col-md-5">
							
							<button @click="calculate" class="btn action-buttons" style="color: #036">Calculate >></button>
							<br/>
							
							<label>Commission Guide</label>
							<div class="row">
								<div class="col-small-3"><label>Com %</label></div>
								<div class="col-small-4">
									
									<input type="text" class="commissionInput" v-model="values.commission_percentage"
									/>
								</div>
								<div class="col-small-1">
									<label>=</label>
								</div>
								<div class="col-small-4">
									<input type="text" class="commissionInput" :value="commissionAmount" disabled/>
								</div>
							</div>
							
							<label>Quote Guide</label>
							<div class="row">
								<div class="col-small-3"><label>+%</label></div>
								<div class="col-small-4">
									<input type="text" class="commissionInput" v-model="values.guided_percentage"/>
								</div>
								<div class="col-small-1">
									<label>=</label>
								</div>
								<div class="col-small-4">
									<input type="text" disabled class="commissionInput" :value="guidedAmount"/>
								</div>
							</div>
							
							<label>Commission Notes:</label>
							<textarea v-model="values.notes"></textarea>
						
						</div>
						<div class="col-md-7">
							<div class="row">
								<div class="col-small-4">
								<label class="required text-right">Materials</label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">$</label>
								</div>
								<div class="col-small-4">
								<input type="text" name="company_name"
										disabled="disabled"
										:value="displayNumber(materialGrandTotal)"
										class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3"></div>
							</div>
							<div class="row">
								<div class="col-small-4">
								<label class="required text-right">Net Cost</label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">$</label>
								</div>
								<div class="col-small-4">
								<input type="text" name="company_name"
										disabled="disabled"
										:value="displayNumber(netCost)"
										class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3"></div>
							</div>
							
							<div class="row">
								<div class="col-small-4">
								<label class="required text-right">Costed Commission</label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">$</label>
								</div>
								<div class="col-small-4">
								<input 
									type="text" 
									name="company_name"
									v-model="values.quote.costed_commission"
									class="form-control inputWithDollar jobCalculationInputField"
								>
								</div>
								<div class="col-small-3"></div>
							</div>

							<div class="row">
								<div class="col-small-4">
								<label class="required text-right">Total Cost</label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">$</label>
								</div>
								<div class="col-small-4">
								<input type="text" name="company_name"
										disabled="disabled"
										:value="displayNumber(totalCost || 0)"
										class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3"></div>
							</div>
							
							<div class="row">
								<div class="col-small-4">
								<label class="required text-right" style="color: blue"><strong>Quote Price</strong></label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">$</label>
								</div>
								<div class="col-small-4">
								<input 
								
									type="text" 
									name="company_name"
									v-model="values.quote.quote_price"
									class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3">
								<label class="required" style="color: blue">
									<!-- <strong>Net</strong> -->
								</label>
								</div>
							</div>
							
							<div class="row">
								<div class="col-small-4">
								<div class="row">
									<label class="required col-5 text-right">GST</label>
									<input type="text" class="commissionInput col-5" v-model="values.quote.gst"/>
									<label class="required col-2">%</label>
								</div>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">$</label>
								</div>
								<div class="col-small-4">
								<input type="text" name="company_name"
										v-model="values.quote.gst_amount"
										class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3"></div>
							</div>
							
							
							<div class="row">
								<div class="col-small-4">
								<label class="required text-right" style="color: red"><strong>Total Charge</strong></label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">$</label>
								</div>
								<div class="col-small-4">
								<input type="text" name="company_name"
										disabled="disabled"
										:value="displayNumber(values.quote.gst_inclusive_quote)"
										class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3">
								<label class="required" style="color: red">
									<!-- <strong>with GST</strong> -->
								</label>
								</div>
							</div>

							<div class="row">
								<div class="col-small-4">
								<label class="required text-right">Margin:</label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">$</label>
								</div>
								<div class="col-small-4">
								<input type="text" name="company_name"
										disabled="disabled"
										:value="displayNumber(quoteMargin)"
										class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3">
								<label class="required" style="color: red">
									<!-- <strong>with GST</strong> -->
								</label>
								</div>
							</div>

							<div class="row">
								<div class="col-small-4">
								<label class="required text-right">Mark-Up %:</label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">&nbsp;</label>
								</div>
								<div class="col-small-4">
								<input type="text" name="company_name"
										disabled="disabled"
										:value="displayNumber(quoteMarkUp) + '%'"
										class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3">
								<label class="required" style="color: red">
									<!-- <strong>with GST</strong> -->
								</label>
								</div>
							</div>

							<div class="row">
								<div class="col-small-4">
								<label class="required text-right">GP %:</label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">&nbsp;</label>
								</div>
								<div class="col-small-4">
								<input type="text" name="company_name"
										disabled="disabled"
										:value="displayNumber(quoteGrossProfit) + '%'"
										class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3">
								<label class="required" style="color: red">
									<!-- <strong>with GST</strong> -->
								</label>
								</div>
							</div>

							<div class="row">
								<div class="col-small-4">
								<label class="required text-right">Quote Date:</label>
								</div>
								<div class="col-small-1">
								<label class="dollarLabelBeforTextBox">&nbsp;</label>
								</div>
								<div class="col-small-4">
								<input type="text" name="company_name"
										disabled="disabled"
										:value="formatViewDate(values.quote.quote_date)"
										class="form-control inputWithDollar jobCalculationInputField">
								</div>
								<div class="col-small-3">
								<label class="required" style="color: red">
									<!-- <strong>with GST</strong> -->
								</label>
								</div>
							</div>
						</div>
					</div>
				</template>
			</portlet-content>
		</div>
	
	</div>
	
	<div class="row">
		<div class="col-xsmall-12 col-small-6 table-wrap">
			<portlet-content header="Memos" subheader="">
				<template slot="action_button">
					<button class="btn btn-primary" @click="mountAddMemo=true">Add New</button>
				</template>
				<template slot="body">
					<div class="col-xsmall-12" style="max-height: 120px;overflow-y: scroll;">
						<table class="table table-bordered">
							<tbody>
							<tr>
								<td>Subject</td>
								<td>Date</td>
								<td>Staff</td>
								<td>Description</td>
							</tr>
								<tr v-for="memo in memos" @click="editMemoModal(memo)">
									<td>@{{ memo.subject }}</a></td>
									<td>@{{ formatViewDate(memo.date) }}</td>
									<td>@{{ memo.user.username }}</td>
									<td>@{{ memo.details }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</template>
			</portlet-content>
		</div>
    <div class="col-xsmall-12 col-small-6 table-wrap">
      <portlet-content header="Bookings" subheader="">
        <template slot="action_button">
          <button class="btn btn-primary" @click="showAddBookingModal">Add New</button>
        </template>
        <template slot="body">
          <div class="col-xsmall-12" style="max-height: 120px;overflow-y: scroll;">
            <table class="table table-bordered">
              <tbody>
              <tr>
                <td>Date</td>
                <td>Type</td>
                <td>For</td>
              </tr>
              @foreach($bookings ?? [] as $key => $booking)

                <tr>
                  <td><a href="/bookings?booking_type={{$booking->booking_type_id}}">{{ $booking->booking_date }}</a></td>
                  <td>{{ $booking->booking_type }}</td>
                  <td width="20%">{{ $booking->booking_for }}</td>
                </tr>

              @endforeach
              </tbody>
            </table>
          </div>
        </template>
      </portlet-content>
    </div>
	</div>
</div>
