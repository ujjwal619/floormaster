@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('breadcrumb')
	<li class="m-nav__item">
		<a href="" class="m-nav__link">
			<span class="m-nav__link-text">Dashboard</span>
		</a>
	</li>
@endsection

@section('content')
	<div class="m-portlet m-portlet--tab">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
					<h1 class="m-portlet__head-text">Welcome {{ currentUser()->formatted_full_name }}</h1>
				</div>
			</div>
		</div>

		<div class="m-portlet__body">
			<!--begin::Section-->
			<div class="m-section m-section--last">
				<div class="m-section__content">
					<!--begin::Preview-->
					<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
						<div class="m-demo__preview">
							<div class="m-nav-grid">
								<div class="m-nav-grid__row">
									<a href="{{ route('admin.users.index') }}" class="m-nav-grid__item" style="background-color: darkred !important;">
										<i class="m-nav-grid__icon fa fa-users"></i>
										<span class="m-nav-grid__text text-white">
																		Users
																	</span>
									</a>
									<a href="{{ route('admin.permissions.index') }}" class="m-nav-grid__item" style="background-color: seagreen !important;">
										<i class="m-nav-grid__icon fa fa-universal-access"></i>
										<span class="m-nav-grid__text text-white">
																		Permission Management
																	</span>
									</a>
									<a href="{{ route('admin.job-sources.index') }}" class="m-nav-grid__item" style="background-color: darkred !important;">
										<i class="m-nav-grid__icon fa fa-suitcase"></i>
										<span class="m-nav-grid__text text-white">
																		Job Sources
																	</span>
									</a>
								</div>
								<div class="m-nav-grid__row">
									<a href="{{ route('admin.suppliers.index') }}" class="m-nav-grid__item" style="background-color: seagreen !important;">
										<i class="m-nav-grid__icon fa fa-bus"></i>
										<span class="m-nav-grid__text text-white">
																		Suppliers
																	</span>
									</a>
									<a href="{{ route('admin.customers.index') }}" class="m-nav-grid__item" style="background-color: darkred !important;">
										<i class="m-nav-grid__icon fa fa-handshake-o"></i>
										<span class="m-nav-grid__text text-white">
																		Customers
																	</span>
									</a>
									<a href="{{ route('admin.products.categories.index') }}" class="m-nav-grid__item" style="background-color: seagreen !important;">
										<i class="m-nav-grid__icon flaticon-interface-3"></i>
										<span class="m-nav-grid__text text-white">
																		Product Categories
																	</span>
									</a>
								</div>
							</div>
						</div>
					</div>
					<!--end::Preview-->
				</div>
			</div>
			<!--end::Section-->
		</div>
	</div>
@endsection
