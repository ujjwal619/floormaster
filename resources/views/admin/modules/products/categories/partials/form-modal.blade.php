<modal title="Add new product category" :is-large="false" v-if="modals.form.show"
       @close="hideModal('form')">
	<template slot="modal-body">
		<div class="form-group m-form__group row">
			<div class="col-lg-12">
				<label class="required" for="title">
					Title
				</label>
				<input type="text"
				       name="title"
				       id="title"
				       :class="{ 'input-error' : form.errors.has('title'), 'form-control': loaded }"
				       v-model="modals.form.values.title">
				<span class="form-error"
				      v-if="form.errors.has('title')"
				      v-text="form.errors.get('title')"></span>
			</div>
		</div>
		<div class="form-group m-form__group row">
			<div class="col-lg-12">
				<label for="description">
					Description
				</label>
				<textarea name="description" id="description" cols="30" rows="4"
				          :class="{ 'input-error' : form.errors.has('description'), 'form-control': loaded }"
				          v-model="modals.form.values.description"
				></textarea>
				<span class="form-error"
				      v-if="form.errors.has('description')"
				      v-text="form.errors.get('description')"></span>
			</div>
		</div>
	</template>
	<template slot="modal-footer">
		<button type="button"
		        class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
		        @click="hideModal('form')">Cancel
		</button>
		<button type="button"
		        class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
		        @click="submitForm"
		        :disabled="modals.form.disableSave">Submit
		</button>
	</template>
</modal>
