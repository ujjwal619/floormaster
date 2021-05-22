@extends('admin.layouts.main')

@section('title', 'Quotes List')

@section('breadcrumb')
	<li class="m-nav__item">
		<a href="" class="m-nav__link">
			<span class="m-nav__link-text">Quotes</span>
		</a>
	</li>
@endsection

@section('content')
	<portlet-content header="Quotes" subheader="list">
		<template slot="action_button">
			<a href="{{ route('admin.quotes.create') }}">
				<button
						class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
						title="Add new quote"
						data-toggle="tooltip"
				>
					<i class="fa fa-plus"></i>
				</button>
			</a>
		</template>
		<template slot="body">
			<div class="row m-0">
				<div class="col-md-12">
					<vue-table
							source="{{ route('admin.quotes.table') }}"
							:columns="['quote_number', 'company', 'project', 'action']"
					></vue-table>
				</div>
			</div>
		</template>
	</portlet-content>
@endsection
