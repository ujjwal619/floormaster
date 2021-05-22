<div class="col-12 row">
  <span class="col-lg-1 text-right h4">Store:</span>
  <input class="col-3 form-control" style="max-height: 40px;" v-if="isOldEntry" type="text" disabled :value="getSelectedSiteName">
  <drop-down
          v-else
          class="col-3"
          :options="sites"
          v-model="values.site_id"
          style="max-height: 40px;"
          :default-selected="defaultStore"
          @input="handleStoreChange"
  />
</div>

<div class="col-xsmall-12 col-small-7 pt-2">
  <div class="row">
    <div class="col-xsmall-12">
      <portlet-content header="Sales Staff" :onlybody="true">
        <template slot="body">

          <div class="form-group m-form__group row">
            <div class="col-xsmall-12">
              <div class="row">
                <div class="quote-id col-small-2">
                  <label class="required">Template</label>
                </div>
                <div class="col-small-7 ">
                  <input type="text"
                         name="name"
                         v-model="values.name"
                         :class="{ 'input-error' : form.errors.has('name'), 'form-control': loaded }"
                         placeholder="Template Name"
                  >
                  <span class="form-error"
                        v-if="form.errors.has('name')"
                        v-text="form.errors.get('name')"></span>
                </div>
                <div class="quote-id col-small-2">
                  <input type="text"
                         name="id"
                         :class="{ 'form-control': loaded }"
                         disabled
                         :value="templateId"
                  >
                </div>
              </div>
            </div>
          </div>

        </template>
      </portlet-content>
    </div>
    <div class="col-xsmall-12 table-wrap">
      <portlet-content header="Materials @ sell Price (incl. GST)">
        <template slot="body">
          <div class="form-group m-form__group row">
            <div class="col-small-3">
              <label class="required">Range</label>
              <drop-down
                      :options="JSON.parse(products)"
                      v-model="values.material.selectedProduct"
                      @input="handleProductSelect(values.material.selectedProduct)"
              />
            </div>
            <div class="col-small-3">
              <label class="required">Pattern</label>
              <drop-down
                      :options="productVariants"
                      v-model="values.material.selectedVariant"
                      @input="handleVariantSelect(values.material.selectedVariant)"
              />
            </div>
            <div class="col-small-1">
              <label class="required">Qty</label>
              <input type="text"
                     name="quantity"
                     :class="{ 'input-error' : form.errors.has('materials'), 'form-control': loaded }"
                     v-model="values.material.quantity"
              >
            </div>
            <div class="col-small-2">
              <label class="required">Unit sell</label>
              <input type="text"
                     name="product"
                     disabled
                     :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                     v-model="values.material.unitCost"
              >
            </div>
            <div class="col-small-1">
              <label class="required">Total</label>
              <input type="text"
                     name="product"
                     disabled
                     :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                     :value="productPrice"
              >
            </div>
            <div class="col-small-1">
              <button class="btn btn-primary m-btn--sm" style="margin-top: 20px"
                      @click="addNewMaterial"><i class="fa fa-plus"></i></button>
            </div>
          </div>
          <span class="form-error"
                v-if="form.errors.has('materials')">* Please select at least one material.</span>
          <div class="form-group m-form__group row pt-2">
            <div class="col-xsmall-12" style="max-height: 90px;overflow-y: scroll;">
              <table class="table table-bordered">
                <tbody>
                <tr v-for="(material,index) in values.materials">
                  <td>@{{ material.product_name }}</td>
                  <td>@{{ material.variant_name }}</td>
                  <td>@{{ material.quantity }}</td>
                  <td>@{{ material.unit }}</td>
                  <td>@{{ material.total }}</td>
                  <td class="text-center">
                    <button class="btn btn-danger" @click="removeMaterial(index)">Delete</button>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Grand Total</td>
                  <td class="text-center">$ @{{ materialGrandTotal }}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </portlet-content>
    </div>
    <div class="col-xsmall-12 table-wrap">
      <portlet-content header="Labour @ sell Price (incl. GST)">
        <template slot="body">
          <div class="form-group m-form__group row">
            <div class="col-small-3">
              <label class="required">Labour</label>
              {{--<drop-down--}}
                      {{--:options="JSON.parse(labourproducts)"--}}
                      {{--v-model="values.labour.selectedProduct"--}}
                      {{--@input="handleLabourProductSelect(values.labour.selectedProduct)"--}}
              {{--/>--}}
              <input type="text"
                       :class="{ 'input-error' : form.errors.has('labour.name'), 'form-control': loaded }"
                       v-model="values.labour.product"
              >
            </div>

            <div class="col-small-2">
              <label class="required">Qty</label>
              <input type="text"
                     name="quantity"
                     :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                     v-model="values.labour.quantity"
              >
            </div>
            <div class="col-small-3">
              <label class="required">Unit Charge</label>
              <input type="text"
                     name="product"
                     :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                     v-model="values.labour.unitCost"
              >
            </div>
            <div class="col-small-2">
              <label class="required">Total</label>
              <input type="text"
                     name="product"
                     disabled
                     :class="{ 'input-error' : form.errors.has('customer.trading_name'), 'form-control': loaded }"
                     :value="labourProductPrice"
              >
            </div>
            <div class="col-small-2">
              <button class="btn btn-primary m-btn--sm" style="margin-top: 20px"
                      @click="addNewLabour"><i class="fa fa-plus"></i></button>
            </div>
          </div>
          <span class="form-error"
                v-if="form.errors.has('labours')">* Please select at least one labour.</span>
          <div class="form-group m-form__group row">
            <div class="col-xsmall-12" style="max-height: 90px;overflow-y: scroll;">
              <table class="table table-bordered">
                <tbody>
                <tr v-for="(material,index) in values.labours">
                  <td style="width: 10%">@{{ material.product }}</td>
                  <td style="width: 10%">@{{ material.quantity }}</td>
                  <td style="width: 10%">@{{ material.unit }}</td>
                  <td style="width: 10%">@{{ material.total }}</td>
                  <td></td>
                  <td style="width: 10%" class="text-center">
                    <button class="btn btn-danger" @click="removeLabour(index)">Delete</button>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Grand Total</td>
                  <td class="text-center">$ @{{ labourGrandTotal }}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </template>
      </portlet-content>
    </div>
  </div>
</div>
