<div>
  <div :class="{'loading': formSubmitting, 'wrapper': formSubmitting}">
    <!--begin::Form-->
    <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
          @submit.prevent="submit">
      <div class="m-portlet__body" style="padding: inherit;">
        <div class="form-group m-form__group row">
          <div class="col-lg-6">
            <label class="required">Name</label>
            <input type="text" name="name"
                   :class="{ 'input-error' : form.errors.has('name'), 'form-control': loaded }"
                   placeholder="Name"
                   v-model="values.name">
            <span class="m-form__help danger"
                  v-if="form.errors.has('name')"
                  v-text="form.errors.get('name')"></span>
          </div>
          <div class="col-lg-6">
            <label class="required">Title</label>
            <input type="text" name="title"
                   :class="{ 'input-error' : form.errors.has('title'), 'form-control': loaded }"
                   placeholder="Title"
                   v-model="values.title">
            <span class="m-form__help danger"
                  v-if="form.errors.has('title')"
                  v-text="form.errors.get('title')"></span>
          </div>
        </div>

        <div class="form-group m-form__group row">
          <div class="col-lg-6">
            <button class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </form>
    <!--end::Form-->
  </div>
</div>
