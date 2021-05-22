@extends('admin.layouts.main')

@section('title', 'Add new customer')

@section('breadcrumb')
	<li class="m-nav__item">
		<a href="{{ route('admin.users.index') }}" class="m-nav__link">
			<span class="m-nav__link-text">Customers</span>
		</a>
	</li>
	<li class="m-nav__separator">
		-
	</li>
	<li class="m-nav__item">
		<a href="#" class="m-nav__link">
			<span class="m-nav__link-text">Create</span>
		</a>
	</li>
@endsection

@section('content')
	<create-customer inline-template url="{{ route('admin.customers.update', $customer->id) }}"
	                 jobsources="{{ json_encode($jobSources) }}" sales="{{ json_encode($salesStaffs) }}"
	                 customer="{{ json_encode($customer) }}"
	                 selectedsales="{{ json_encode($selectedSales) }}"
	                 selectedjobs="{{ json_encode($selectedJobSources) }}"
	                 selectedsites="{{ json_encode($sites) }}"
	                 settings="{{ json_encode($settings) }}"
	                 method="patch"
	>
		@include('admin.modules.customers.partials.form')
	</create-customer>
@endsection
