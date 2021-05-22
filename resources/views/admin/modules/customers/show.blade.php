@extends('admin.layouts.main')

@section('title', 'Customer Details')

@section('breadcrumb')
	<li class="m-nav__item">
		<a href="{{ route('admin.customers.index') }}" class="m-nav__link">
			<span class="m-nav__link-text">Customers</span>
		</a>
	</li>
	<li class="m-nav__separator">
		-
	</li>
	<li class="m-nav__item">
		<a href="#" class="m-nav__link">
			<span class="m-nav__link-text">{{ $customer->trading_name }}</span>
		</a>
	</li>
@endsection

@section('content')
	<portlet-content header="Customer" subheader="Details">
		<template slot="action_button">
			<delete-button
					submiturl="{{ route('admin.customers.destroy', $customer->id) }}"
					title="Delete Customer"
					swaltitle="Are you sure ?"
					swalsuccesstitle="Successfully deleted customer"
					itagclassname="fa fa-trash"
					method="delete"
					redirecturl="{{ route('admin.customers.index') }}"
			></delete-button>
			<edit-button
					url="{{ route('admin.customers.edit', $customer->id) }}"
					title="Edit Customer Details"
			>
			</edit-button>
		</template>
		<template slot="body">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<tr>
							<td><strong> Trading Name </strong></td>
							<td> {{ $customer->trading_name }}</td>
						</tr>
						<tr>
							<td><strong> Address </strong></td>
							<td>{{ $customer->formatted_address }}</td>
						</tr>
						<tr>
							<td><strong> Phone </strong></td>
							<td>{{ $customer->phone ?? "N/A" }}</td>
						</tr>
						<tr>
							<td><strong>Fax</strong></td>
							<td>{{ $customer->fax ?? "N/A" }}</td>
						</tr>
						
						<tr>
							<td><strong>ABN</strong></td>
							<td>{{ $customer->abn ?? "N/A" }}</td>
						</tr>
						
						<tr>
							<td><strong>ACN</strong></td>
							<td>{{ $customer->acn ?? "N/A" }}</td>
						</tr>
						
						<tr>
							<td><strong>Postal Address</strong></td>
							<td>{{ $customer->formatted_postal_address ?? "N/A" }}</td>
						</tr>
						<tr>
							<td><strong>Delivery Address</strong></td>
							<td>{{ $customer->formatted_delivery_address ?? "N/A" }}</td>
						</tr>
					</table>
				</div>
			</div>
		</template>
	</portlet-content>
@endsection
