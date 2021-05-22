<div class="col-xsmall-12 col-small-12">
	<div class="table-wrap">
		<portlet-content onlybody>
			<template slot="body">
				<div class="col-xsmall-12" style="max-height: 120px;overflow-y: scroll;">
					<table class="table table-bordered">
						<tbody>
						<tr>
							<td>UPC</td>
							<td>Quantity</td>
							<td>Supplier</td>
							<td>Range</td>
							<td>Color</td>
							<td>List Price</td>
							<td>Disc %</td>
							<td>GST</td>
							<td>Levy</td>
							<td>Extension</td>
						</tr>
						<tr v-for="(material,index) in values.materials">
							<td></td>
							<td>@{{ material.quantity }}</td>
							<td></td>
							<td>@{{ material.product_name }}</td>
							<td>@{{ material.variant_name }}</td>
							<td>@{{ material.unit }}</td>
							<td></td>
							<td>10</td>
							<td></td>
							<td>@{{ material.total }}</td>
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
							<tr v-for="(material,index) in values.labours">
								<td style="width: 10%">@{{ material.quantity }}</td>
								<td style="width: 10%">@{{ material.product }}</td>
								<td style="width: 10%">@{{ material.unit }}</td>
								<td style="width: 10%">@{{ material.total }}</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>Labour:</td>
								<td>$ @{{ labourGrandTotal }}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</template>
			</portlet-content>
		</div>
	</div>
</div>
