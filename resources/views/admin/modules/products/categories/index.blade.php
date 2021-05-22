@extends('admin.layouts.main') 
@section('title', 'Product Cateogories List') 
@section('breadcrumb')
<li class="m-nav__item">
	<a href="" class="m-nav__link">
			<span class="m-nav__link-text">Categories</span>
		</a>
</li>
@endsection
 
@section('content')
<category-list inline-template method="POST" url="{{ route('admin.products.categories.store') }}">
	<div>
	@include('admin.modules.products.categories.partials.form-modal')
		<portlet-content header="Categories" subheader="list">
			<template slot="action_button">
					<a @click.prevent="showModal('form')">
						<button
								class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
								title="Add new category"
								data-toggle="tooltip"
						>
							<i class="fa fa-plus"></i>
						</button>
					</a>
				</template>
			<template slot="body">
					<div class="row">
						<div class="col-md-12">
							<vue-table
									source="{{ route('admin.products.categories.table') }}"
									:columns="['title', 'description', 'action']"
									v-on:edit-pressed="handleEditAction"
							></vue-table>
						</div>
					</div>
				</template>
		</portlet-content>
	</div>
</category-list>
@endsection