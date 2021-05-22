<div class="row">
  <div class="col-md-6">
    <portlet-content header="Product Type" subheader="Details" isform="true">
      <template slot="body">
        <div class="form-group m-form__group row" style="padding: 2% !important;">
          <div class="col-lg-6">
            <label class="required" for="gender">Name</label>
            <input type="text"
                   :class="{ 'input-error' : form.errors.has('product_type.name'), 'form-control': loaded }"
                   v-model="values.product_type.name">
            <span class="m-form__help danger"
                  v-if="form.errors.has('product_type.name')"
                  v-text="form.errors.get('product_type.name')"></span>
          </div>
          <div class="col-lg-6">
            <label class="required" for="gender">Unit Cost</label>
            <input type="text"
                   :class="{ 'input-error' : form.errors.has('product_type.unit_cost'), 'form-control': loaded }"
                   v-model="values.product_type.unit_cost"
                   @keypress="numberOnly">
            <span class="m-form__help danger"
                  v-if="form.errors.has('product_type.unit_cost')"
                  v-text="form.errors.get('product_type.unit_cost')"></span>
          </div>
        </div>
        <div class="form-group m-form__group row" style="padding: 2% !important;">
          <div class="col-lg-6">
            <label class="required" for="category_id">Category</label>
            <select :class="{ 'input-error' : form.errors.has('product_type.category_id'), 'form-control': loaded }"
                    v-model="values.product_type.category_id">
              <option value="">Select Category</option>
              @foreach($categories as $id => $category)
                <option value="{{ $id }}">{{ ucwords($category) }}</option>
              @endforeach
            </select>
            <span class="m-form__help danger"
                  v-if="form.errors.has('product_type.category_id')"
                  v-text="form.errors.get('product_type.category_id')"></span>
          </div>
          <div class="col-lg-6">
            <input type="checkbox" name="is_featured_material_product" v-model="values.product_type.is_featured"> Is Featured
          </div>
        </div>
      </template>
    </portlet-content>
    <portlet-content header="Variants" subheader="Details" isform="true">
      <template slot="body">
        <div class="form-group m-form__group row" style="padding: 2% !important;">
          <div class="col-md-6">
            <label for="gender">Variant Name</label>
            <input type="text"
                   :class="{ 'input-error' : form.errors.has('variants'), 'form-control': loaded }"
                   v-model="variant_name">
            <span class="m-form__help danger"
                  v-if="form.errors.has('variants')"
                  v-text="form.errors.get('variants')"></span>
          </div>
          <div class="col-md-3 pt-2">
            <button class="btn btn-primary m-btn--sm mt-4 pull-right" title="Save" data-toggle="tooltip"
                    @click="addNewVariant()">ADD
            </button>
          </div>
        </div>
        <hr/>
        <div class="col-md-6" style="padding: 0 0 3% 3% !important;">
          <table class="table">
            <tbody>
            <tr v-for="(variant, index) in values.variants" :key="index">
              <td width="80%">
                <span v-if="!variant.is_edit" v-text="variant.name"></span>
                <input type="text" v-else v-model="variant.name" class="form-control"/>
              </td>
              <td nowrap="">
                <a href="javascript:void(0)" class="btn btn-sm"
                   :class="variant.is_edit ? 'btn-success' : 'btn-primary'"
                   @click.prevent="handleVariantEditClick(index)">
                  <i class="fa" :class="variant.is_edit ? 'fa-save' : 'fa-edit'"></i>
                </a>
                <a href="javascript:void(0)"
                   class="btn btn-sm btn-danger"
                   @click.prevent="removeVariant(index, variant)"
                ><i class="fa fa-trash"></i></a>
              </td>
              <td>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </template>
    </portlet-content>

    <div class="form-group m-form__group row">
      <div class="col-lg-12">
        <button class="btn btn-success pull-right" @click="submit">Save</button>
      </div>
    </div>
  </div>
</div>
