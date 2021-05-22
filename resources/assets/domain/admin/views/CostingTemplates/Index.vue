<template>
  <div class="form-container">
    <template>
      <loading :loading="loading" />
    </template>
    <template v-if="page === 1">
      <div class="row">
        <div class="col-7">
          <portlet-content :onlybody="true">
            <template slot="body">
              <div class="row">
                <div class="col-1">
                  <label class="text-right pt-2">Name</label>
                </div>
                <div class="col-11 row pl-2">
                  <div class="col-2">
                    <label>Title</label>
                    <input :disabled="!isEditMode" type="text" class="form-control" v-model="model.customer_details.title"/>
                  </div>
                  <div class="col-3">
                    <label class="ml-2">Given Name</label>
                    <input :disabled="!isEditMode" type="text" class="form-control ml-2" v-model="model.customer_details.given_name"/>
                  </div>
                  <div class="col-3">
                    <label class="ml-2">Surname/Company</label>
                    <input :disabled="!isEditMode" type="text" class="form-control ml-2" name="company_name" v-model="model.customer_details.surname"/>
                  </div>
                </div>
              </div>
              <div class="row pt-3">
                <div class="col-1">
                  <label class="text-right">Street</label>
                </div>
                <div class="col-11">
                  <input :disabled="!isEditMode" type="text" class="form-control" name="street" v-model="model.customer_details.street"/>
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-6 row">
                  <div class="col-2">
                    <label class="text-right pl-1">Town</label>
                  </div>
                  <div class="col-8">
                    <input :disabled="!isEditMode" type="text" class="form-control" name="town" v-model="model.customer_details.town"/>
                  </div>
                </div>
                <div class="col-3 row">
                  <div class="col-3">
                    <label class="text-right" for="gender">State</label>
                  </div>
                  <div class="col-8">
                    <input :disabled="!isEditMode" type="text" class="form-control" name="state" v-model="model.customer_details.state"/>
                  </div>
                </div>
                <div class="col-3 row">
                  <div class="col-3">
                    <label class="text-right" for="gender" >Code</label>
                  </div>
                  <div class="col-8">
                    <input :disabled="!isEditMode" type="text" class="form-control" name="code" v-model="model.customer_details.code"/>
                  </div>
                </div>
              </div>
              <div class="row pt-3">
                <div class="col-1">
                  <label class="text-right" for="gender">Contact</label>
                </div>
                <div class="col-11">
                  <input :disabled="!isEditMode" type="text" class="form-control" name="contact" v-model="model.customer_details.contact"/>
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-1">
                  <label class="text-right" for="gender">X Street</label>
                </div>
                <div class="col-11">
                  <input :disabled="!isEditMode" type="text" class="form-control" name="street" v-model="model.customer_details.xstreet"/>
                </div>
              </div>
              <div class="row py-2">
                <div class="col-1">
                  <label class="text-right">Project</label>
                </div>
                <div class="col-11">
                  <input :disabled="!isEditMode" type="text" class="form-control" name="project" v-model="model.customer_details.project"/>
                </div>
              </div>
            </template>
          </portlet-content>
        </div>
        <div class="col-5 row">
          <div class="col-12">
            <portlet-content :onlybody="true">
              <template slot="body">
                <div class="row">
                  <label class="pl-2 text-right">Store:</label>
                  <label v-if="isOldEntry" class="ml-1">{{ model.site.name }}</label>
                  <template v-else>
                    <drop-down
                      v-if="!isOldEntry"
                      class="col-6"
                      :options="sites"
                      v-model="selectedSite"
                      style="max-height: 40px;"
                      :default-selected="sites[0]"
                    />
                  </template>
                </div>
                <div class="py-2 d-flex justify-content-center row">
                  <label class="text-danger text-right">Template:</label>
                  <input
                    :disabled="!isEditMode"
                    type="text"
                    class="form-control text-danger col-7 ml-1"
                    v-model="model.name"
                  />
                  <label class="text-danger">{{ model.id }}</label>
                </div>
                <div class="row py-2">
                  <label class="pl-2 text-right">Sales Code:</label>
                  <input v-if="!isEditMode" disabled type="text" class="form-control col-4 ml-1" v-model="salesCode.code" />
                  <template v-else>
                    <drop-down
                      class="col-6"
                      :options="accounts"
                      v-model="model.sales_code_id"
                      :default-selected="salesCode"
                      label="code"
                      style="max-height: 40px;"
                    />
                  </template>

                  <div class="d-flex align-items-center">
                    <input :disabled="!isEditMode" type="checkbox" class="mr-2" />
                    <label class="text-dark-blue">Use Text Wizard</label>
                    <input :disabled="!isEditMode" type="checkbox" class="mx-2" />
                    <label class="text-dark-blue">Wizard Uses Supplier Name</label>
                  </div>
                </div>
              </template>
            </portlet-content>
          </div>
          <div class="col-12 pt-2">
            <portlet-content :onlybody="true">
              <template slot="body">
                <div class="row px-3 d-flex align-items-center">
                  <label class="mr-1 col-1 text-right">Home Ph:</label>
                  <input :disabled="!isEditMode" type="text" class="form-control col-4" v-model="model.customer_details.home_phone"/>
                  <label class="mr-1 col-1 text-right">Wk Ph:</label>
                  <input :disabled="!isEditMode" type="text" class="form-control col-4" v-model="model.customer_details.work_phone"/>
                </div>
                <div class="row px-3 pt-2 d-flex align-items-center">
                  <label class="mr-1 col-1 text-right">Mobile:</label>
                  <input :disabled="!isEditMode" type="text" class="form-control col-4" v-model="model.customer_details.mobile_phone"/>
                  <label class="mr-1 col-1 text-right">Fax:</label>
                  <input :disabled="!isEditMode" type="text" class="form-control col-4" v-model="model.customer_details.fax"/>
                </div>
                <div class="row px-3 py-2 d-flex align-items-center">
                  <label class="mr-1 col-1 text-right">Email:</label>
                  <input :disabled="!isEditMode" type="text" class="form-control col-8" v-model="model.customer_details.email"/>
                </div>
              </template>
            </portlet-content>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-5 pt-2">
          <portlet-content :onlybody="true">
            <template slot="body">
              <div class="row">
                <div class="col-2">
                  <span class="background-black">Quote Text</span>
                </div>
                <textarea :disabled="!isEditMode" class="col-10" cols="8" rows="15" v-model="model.customer_details.quote"></textarea>
              </div>
              <div class="row pt-2">
                <label class="col-2 text-right mr-1">Terms:</label>
                <div class="col-10 row">
                  <input :disabled="!isEditMode" type="number" class="form-control col-1" v-model="model.term"/>
                  <input disabled type="text" class="form-control col-1" />
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-1">&nbsp;</div>
                <textarea disabled class="col-11" cols="8" rows="2"></textarea>
              </div>
            </template>
          </portlet-content>
        </div>
        <div class="col-7 pt-2">
          <div class="col-xsmall-12 table-wrap">
            <portlet-content header="Materials @ sell Price (incl. GST)">
              <template slot="body">
                <button :disabled="!isEditMode" type="button" @click="openSelectProductModal">Add</button>
                <div class="form-group m-form__group row">
                  <div class="col-small-2">
                    <label class="required">Range</label>
                  </div>
                  <div class="col-small-2">
                    <label class="required">Variant</label>
                  </div>
                  <div class="col-small-2">
                    <label class="required">Qty</label>
                  </div>
                  <div class="col-small-2">
                    <label class="required">Unit Sell</label>
                  </div>
                  <div class="col-small-2">
                    <label class="required">Total</label>
                  </div>
                  <div class="col-small-1">
                    <label class="required">Action</label>
                  </div>
                </div>
                <div class="form-group m-form__group row pt-2">
                  <div class="col-xsmall-12" style="max-height: 90px;overflow-y: scroll;">
                    <table class="table table-bordered">
                      <tbody>
                      <tr 
                        v-for="(material,index) in model.material_products"
                        :key="index"
                      >
                      <td @click="openEditMaterialProductModal(material)">{{ material.product_name }}</td>
                      <td @click="openEditMaterialProductModal(material)">{{ material.variant_name }}</td>
                      <td @click="openEditMaterialProductModal(material)">{{ material.quantity }}</td>
                      <td @click="openEditMaterialProductModal(material)">{{ material.unit_sell }}</td>
                      <td @click="openEditMaterialProductModal(material)">{{ getMaterialTotalFirstPage(material) }}</td>
                      <td class="text-center">
                      <button :disabled="!isEditMode" class="btn btn-danger" @click="removeMaterial(index)">Delete</button>
                      </td>
                      </tr>
                      <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>$ {{ materialGrandTotalFirstPage }}</td>
                      <td class="text-center">Grand Total</td>
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
                    <input :disabled="!isEditMode" type="text"
                    v-model="newLabourData.product"
                    >
                  </div>

                  <div class="col-small-2">
                    <label class="required">Qty</label>
                    <input :disabled="!isEditMode" type="text"
                    name="quantity"
                    v-model="newLabourData.quantity"
                    >
                  </div>
                  <div class="col-small-3">
                    <label class="required">Unit Charge</label>
                    <input :disabled="!isEditMode" type="text"
                    name="product"
                    v-model="newLabourData.unitCost"
                    >
                  </div>
                  <div class="col-small-2">
                    <label class="required">Total</label>
                    <input type="text"
                    name="product"
                    disabled
                    :value="labourProductPrice"
                    >
                  </div>
                  <div class="col-small-2">
                    <label class="required">Action</label>
                    <button 
                      :disabled="!isEditMode" 
                      class="btn btn-primary m-btn--sm" 
                      @click="addNewLabour"
                    ><i class="fa fa-plus"></i></button>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <div class="col-xsmall-12" style="max-height: 90px;overflow-y: scroll;">
                    <table class="table table-bordered">
                      <tbody>
                      <tr 
                        v-for="(material,index) in model.labour_products"
                        :key="index"
                      >
                        <td @click="openEditLabourProductModal(material)" style="width: 25%">{{ material.product }}</td>
                        <td @click="openEditLabourProductModal(material)" style="width: 15%">{{ material.quantity }}</td>
                        <td @click="openEditLabourProductModal(material)" style="width: 25%">{{ material.unit }}</td>
                        <td 
                          @click="openEditLabourProductModal(material)" 
                          style="width: 10%"
                        >{{ material.total }}</td>
                        <td style="width: 15%" class="text-center">
                        <button :disabled="!isEditMode" class="btn btn-danger" @click="removeLabour(index)">Delete</button>
                        </td>
                      </tr>
                      <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>$ {{ labourGrandTotal }}</td>
                      <td class="text-center">Grand Total</td>
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
    </template>
    <template v-else>
      <div class="row">
        <div class="col-12">
          <portlet-content :onlybody="true">
            <div slot="body" class="row costing-table">
              <div class="col-12">
                <div class="row table-wrap">
                  <table class="table">
                    <tbody>
                      <tr class="row col-12">
                        <td class="table-head col-1">UPC</td>
                        <td class="table-head col-2">Supplier</td>
                        <td class="table-head col-1">Range</td>
                        <td class="table-head col-1">Colour</td>
                        <td class="table-head col-1">Quantity</td>
                        <td class="table-head col-1">List Price</td>
                        <td class="table-head col-1">Disc %</td>
                        <td class="table-head col-1">Tax%</td>
                        <td class="table-head col-1">Levy</td>
                        <td class="table-head col-1">Sell Price</td>
                        <td class="table-head col-1">Extension</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="row table-wrap" style="height: 240px;overflow-y: auto;">
                  <table class="table">
                    <tbody>
                      <tr 
                        v-for="(material,index) in model.material_products" 
                        :key="index"
                        class="row col-12"
                        @click="openEditMaterialProductModal(material)"
                      >
                        <td class="form-control col-1">
                          {{ material.supplier_id }} - {{ material.upc }}
                        </td>
                        <td class="form-control col-2">{{ material.supplier_name }}</td>
                        <td class="form-control col-1 text-primary">{{ material.product_name }}</td>
                        <td class="form-control col-1">{{ material.variant_name }}</td>
                        <td class="form-control col-1 text-right">{{ material.quantity }}</td>
                        <td class="form-control col-1 text-right">{{ displayMoney(material.unit) }}</td>
                        <td class="form-control col-1 text-right">{{ material.discount || 0 }}%</td>
                        <td class="form-control col-1 text-right">{{ material.gst || 0 }}%</td>
                        <td class="form-control col-1 text-right">{{ material.levy || 0 }}%</td>
                        <td class="form-control col-1 text-right text-primary">{{ material.sell_price }}</td>
                        <td class="form-control col-1 text-right">{{ displayMoney(material.total) }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="row pt-4">
                  <div class="col-6">
                    <div class="row table-wrap">
                      <table class="table">
                        <tbody>
                          <tr class="row col-12">
                            <td class="table-head col-3">Labour Item</td>
                            <td class="table-head col-2">Quantity</td>
                            <td class="table-head col-2">Unit Cost</td>
                            <td class="table-head col-2">Charge @</td>
                            <td class="table-head col-2">Extension</td>
                            <td class="table-head col-1">Tax %</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row table-wrap" style="height: 210px;overflow-y: auto;">
                      <table class="table">
                        <tbody>
                          <tr 
                            v-for="(material,index) in model.labour_products" 
                            :key="index"
                            class="row col-12"
                            @click="openEditLabourProductModal(material)"
                          >
                            <td class="form-control text-primary col-3">{{ material.product }}</td>
                            <td class="form-control col-2 text-right">{{ material.quantity }}</td>
                            <td class="form-control col-2 text-right">${{ material.unit }}</td>
                            <td class="form-control text-primary col-2 text-right">${{ material.charge || 0 }}</td>
                            <td class="form-control col-2 text-right">${{ material.total }}</td>
                            <td class="form-control col-1 text-right">${{ material.gst || 0 }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row pt-2 table-wrap">
                      <table class="table">
                        <tbody>
                          <tr class="row col-12">
                            <td class="table-head col-7">&nbsp;</td>
                            <td class="table-head col-2">Labour: </td>
                            <td class="form-control text-right table-head col-2">
                              ${{ labourGrandTotal }}
                            </td>
                            <td class="table-head col-2">&nbsp;</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-6 pl-5">
                    <div class="row">
                      <span class="col-5 background-black text-center">
                        Job Costing Template
                      </span>
                      <label class="col-4 text-right pr-2">Materials:</label>
                      <input type="text" disabled class="form-control text-right col-3" :value="displayMoney(materialGrandTotal)">
                    </div>
                    <div class="row pt-2">
                      <label class="col-9 text-right pr-2">Net Cost:</label>
                      <input type="text" disabled class="form-control text-right col-3" :value="displayMoney(netCost)">
                    </div>
                    <div class="row pt-2">
                      <label class="col-9 text-right pr-2">Costed Commission:</label>
                      <input type="text" :disabled="!isEditMode" v-model="model.costed_commission" class="form-control text-right col-3">
                    </div>
                    <div class="row pt-2">
                      <label class="col-9 text-right text-danger pr-2">Total Cost:</label>
                      <input type="text" disabled class="form-control text-right text-danger col-3" :value="displayMoney(totalCost)">
                    </div>
                    <div class="row pt-2">
                      <span class="col-2"></span>
                      <label class="col-3 text-right pr-2">Mark-up Guide:</label>
                      <input 
                        type="text" 
                        :disabled="!isEditMode" 
                        v-model="model.markup_guide" 
                        class="form-control text-right col-1"
                      >
                      <label class="col-1">% +%</label>
                      <label class="col-2 text-right text-primary pr-2">Quote Price:</label>
                      <input 
                        type="text" 
                        :disabled="!isEditMode" 
                        v-model="model.quote_price" 
                        class="form-control text-right text-primary col-3"
                      >
                    </div>
                    <div class="row pt-2">
                      <label class="col-9 text-right text-danger pr-2">Margin:</label>
                      <label class="col-3 text-right text-danger">{{ displayMoney(margin) }}</label>
                    </div>
                    <div class="row pt-2">
                      <label class="col-9 text-right text-danger pr-2">GP%:</label>
                      <label class="col-3 text-right text-danger">{{ gp || 0 }}%</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </portlet-content>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-12">
          <portlet-content :onlybody="true">
            <div slot="body" class="row">
              <div class="col-2">
                <label class="text-primary"> Job Notes</label>
                <textarea class="col-12 mt-1" cols="3" rows="4" disabled ></textarea>
              </div>
              <div class="col-10">
                <label>
                  This is the Costing Template section. Templates are designed to allow you to build up default costing screens to suit your company's needs. Typically
                  these include basic job types, ec. Direct Stick Carpet, Domestic Carpet, Commercial kitchen, Hospital Spec, etc.
                  <br/>
                  <br/>
                  Templates are the computer equivalent of pre-printed estimate sheets, with check list already filled in. When you create a new costing, you will select the
                  template/s that you require, then fill in the quantities, over-riding prices as necesssary.
                  <br/>
                  <br/>
                  when the new costing is saved, all checklist entries that do not have a quantity can be removed.
                  <br/>
                  <br/>
                  The templates can vary from a totally blank record, to a fully costed and quoted job type, such as repetative project homes and the like.
                  <br/>
                  <br/>
                  When you create new templates, it is advisable to allow one or more non-specific entries, eg. carpet or vinyl that relate to Price-List and Stock Categories,
                  so that you are prompted to enter a specific product. Costing entries are listed in the order of their creation.
                </label>
              </div>
            </div>
          </portlet-content>
        </div>
      </div>
    </template>
    <div class="row pt-2">
      <div class="col-12 mt-2">
        <portlet-content :onlybody="true" isform="true">
          <div slot="body" class="menu-bar d-flex justify-content-between">
            <div class="mt-1">
              <button type="button" class="btn action-buttons" @click="openModal('SearchTemplates')">Search</button>
              <button
                type="button"
                class="btn action-buttons"
                v-if="isOldEntry && !isEditMode"
                @click="enableEditMode"
              >Edit</button>
              <button
                type="button"
                class="btn action-buttons"
                v-if="isEditMode"
                @click="saveTemplateData"
              >Save</button>
              <button
                type="button"
                class="btn action-buttons"
                v-if="isEditMode"
                @click="cancelEditMode"
              >Cancel</button>
              <button 
                type="button" 
                class="btn action-buttons" 
                v-if="!isEditMode && hasPermission('job.template.add.template')" 
                @click="createNewTemplate"
              >Add</button>
              <button type="button" class="btn action-buttons">Copy</button>
              <button
                v-if="hasPermission('job.template.delete.template')" 
                type="button" 
                class="btn action-buttons" 
                :disabled="isEditMode" 
                @click="deleteTemplate"
                >Delete</button>
              <button type="button" class="btn action-buttons ml-2" :class="{ 'active': page === 1 }" @click="changePage(1)">
                1
              </button>
              <button type="button" class="btn action-buttons" :class="{ 'active': page === 2 }" @click="changePage(2)">
                2
              </button>
            </div>
            <span class="background-black text-truncate mr-3 my-1">Job Template</span>
          </div>
        </portlet-content>
      </div>
    </div>
    <search-templates
      v-if="mountSearchTemplates"
      @selected="handleSelectedTemplate"
      @close="closeModal('SearchTemplates')"
    />
    <select-product
      v-if="mountSelectProduct"
      :is-extra-field="true"
      :site-id="selectedSite || this.model.site.id"
      :pre-selected-variants="selectedVariantIds"
      @close="closeModal('SelectProduct')"
      @product="handleProductAdd"
    />
    <edit-material-product
      v-if="mountEditMaterialProduct"
      :is-extra-field="true"
      :material-product="selectedMaterialProduct"
      @close="closeModal('EditMaterialProduct')"
      @product="handleMaterialProductEdit"
    />
    <edit-labour-product
      v-if="mountEditLabourProduct"
      :is-extra-field="true"
      :labour-product="selectedLabourProduct"
      @close="closeModal('EditLabourProduct')"
      @product="handleLabourProductEdit"
    />
  </div>
</template>

<script>
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import SearchTemplates from './components/SearchTemplates';
import { LoadingMixin, CurrentUserMixin } from "../../../common/mixins";
import SelectProduct from "../Jobs/components/SelectProduct"
import { isEmpty, displayMoney } from "../../../common/utitlities/helpers";
import DropDown from "../../../common/components/DropDown/DropDown"
import { getSites } from "../../api/calls";
import EditMaterialProduct from "../../../common/components/EditMaterialProduct";
import EditLabourProduct from "../../../common/components/EditLabourProduct";
import { getAccountsBySite } from "../../api/calls"; 

const BASE_STATE = {
  customer_details: {},
  site: {},
  material_products: [],
  labour_products: [],
};

export default {
  name: "CostingTemplates",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    PortletContent,
    SearchTemplates,
    SelectProduct,
    DropDown,
    EditMaterialProduct,
    EditLabourProduct,
  },
  props: {
    templateId: {
      type: Number,
      default: 0
    }
  },
  computed: {
    isOldEntry() {
      return !!this.model.id;
    },
    materialGrandTotal() {
      const cost = this.model.material_products.reduce((sum, material) => sum + Number(material.total), 0)
      return cost.toFixed(2);
    },
    materialGrandTotalFirstPage() {
      const cost = this.model.material_products.reduce((sum, material) => sum + (Number(material.quantity) * Number(material.unit_sell || 0)), 0)
      return cost.toFixed(2);
    },
    labourGrandTotal() {
      const cost = this.model.labour_products.reduce((sum, material) => sum + Number(material.total), 0)
      return cost.toFixed(2);
    },
    netCost() {
      const netcost = Number(this.materialGrandTotal) + Number(this.labourGrandTotal);
      return netcost.toFixed(2);
    },
    totalCost() {
      const totalcost = Number(this.netCost) + Number(this.model.costed_commission || 0);
      return totalcost.toFixed(2);
    },
    margin() {
      const margin = Number(this.model.quote_price || 0) - Number(this.totalCost || 0);
      return margin.toFixed(2);
    },
    gp() {
      if (!this.model.quote_price) {
        return 0;
      }
      const value = (Number(this.margin) / Number(this.totalCost)) * 100;
      return value.toFixed(2);
    },
    labourProductPrice() {
      const cost = this.newLabourData.quantity * this.newLabourData.unitCost;
      return cost.toFixed(2);
    },
    selectedVariantIds() {
      if (!this.model.material_products.length) {
        return [];
      }
      return this.model.material_products.map(material => material.variant_id);
    },
    salesCode() {
      return this.model.sales_code || {};
    },
  },
  data: () => ({
    sites: [],
    isEditMode: false,
    model: { ...BASE_STATE },
    modelCache: { ...BASE_STATE },
    mountSearchTemplates: false,
    mountSelectProduct: false,
    mountEditMaterialProduct: false,
    mountEditLabourProduct: false,
    page: 1,
    newLabourData: {
      unitCost: 1,
      quantity: 1,
      variantName: '',
    },
    newMaterialData: {},
    selectedSite: '',
    accounts: [],
    selectedMaterialProduct: {},
    selectedLabourProduct: {},
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.model.material_products = [];
        this.fetchAccountsBySite(value);
      }
    },
  },
  created() {
    if (!this.templateId) {
      this.fetchCostingTemplateIndex();
    } else {
      this.fetchCostingTemplate(this.templateId);
    }
  },
  methods: {
    displayMoney,
    getMaterialTotalFirstPage(material) {
      const cost = Number(material.quantity) * Number(material.unit_sell || 0);
      return cost.toFixed(2);
    },
    handleMaterialProductEdit(product) {
      for (var i in this.model.material_products) {
        if (
            this.model.material_products[i].supplier_id === product.supplier_id 
            && this.model.material_products[i].product_id === product.product_id
            && this.model.material_products[i].variant_id === product.variant_id
          ) {
            this.model.material_products[i].discount = product.discount;
            this.model.material_products[i].gst = product.gst;
            this.model.material_products[i].upc = product.upc;
            this.model.material_products[i].levy = product.levy;
            this.model.material_products[i].quantity = product.quantity;
            this.model.material_products[i].total = product.total;
            this.model.material_products[i].unit = product.unit;
            this.model.material_products[i].sell_price = product.sell_price;
            this.model.material_products[i].unit_sell = product.unit_sell;
            break;
          }
      }
    },
    handleLabourProductEdit(labour) {
      for (var i in this.model.labour_products) {
        if (this.selectedLabourProduct.product === this.model.labour_products[i].product) {
            this.model.labour_products[i].product = labour.product;
            this.model.labour_products[i].quantity = labour.quantity;
            this.model.labour_products[i].unit = labour.unit;
            this.model.labour_products[i].charge = labour.charge;
            this.model.labour_products[i].total = labour.total;
            this.model.labour_products[i].gst = labour.gst;
            break;
          }
      }
    },
    openEditMaterialProductModal(material) {
      if (!this.isEditMode) {
        return false;
      }
      this.selectedMaterialProduct = { ...material };
      this.openModal('EditMaterialProduct');
    },
    openEditLabourProductModal(material) {
      if (!this.isEditMode) {
        return false;
      }
      this.selectedLabourProduct = { ...material };
      this.openModal('EditLabourProduct');
    },
    fetchAccountsBySite(siteId) {
      this.enableLoading();
      getAccountsBySite(siteId)
        .then(({ data }) => {
          this.accounts = data.data;
        })
        .catch(() => {
          console.log('could not fetch accounts');
        })
        .finally(this.disableLoading);
    },
    fetchAccountsByFamilyAndSite(family, siteId) {
      this.enableLoading();
      axios.get(`/accounts/${family}/sites/${siteId}`)
        .then(({ data }) => {
          this.accounts = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    deleteTemplate() {
      let confirmation = confirm('Are you sure to delete template?');
      if (confirmation) {
        this.enableLoading();
        axios.delete(`/api/templates/${this.model.id}`)
          .then(() => {
            this.$toastr('success', 'Successfully deleted template..', 'Success!!')
            this.model = { ...BASE_STATE },
            this.fetchCostingTemplateIndex();
          })
          .catch(() => {
            this.$toastr('error', 'Could not delete template..', 'Error!!')
          })
          .finally(() => this.disableLoading());
      }
    },
    createNewTemplate() {
      this.fetchSites();
      this.modelCache = this.model;
      this.model = BASE_STATE;
      this.changeEditMode(true);
    },
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    handleProductAdd(product) {
      this.model.material_products.push(product);
    },
    openSelectProductModal() {
      this.mountSelectProduct = true;
    },
    closeProductModal() {
      this.mountSelectProduct = false;
    },
    addNewLabour() {
      let labour = {
        product: this.newLabourData.product,
        quantity: this.newLabourData.quantity,
        unit: this.newLabourData.unitCost,
        gst: this.model.site.gst
      };
      labour.total = this.labourProductPrice

      this.model.labour_products.push(labour)

      this.newLabourData = {
        unitCost: 1,
        quantity: 1,
        variantName: '',
      }
    },
    removeMaterial(index) {
      this.model.material_products.splice(index, 1);
    },
    removeLabour(index) {
      this.model.labour_products.splice(index, 1);
    },
    fetchCostingTemplateIndex() {
      this.enableLoading();
      axios.get("/api/templates/index")
        .then(({ data }) => {
          if (data.data.id) {
            this.fetchCostingTemplate(data.data.id);
          } else {
            this.$toastr('error', 'No records.', 'Error!!')
          }
        })
        .catch(error => console.log(error))
        .finally(this.disableLoading);
    },
    fetchCostingTemplate(id) {
      this.enableLoading();
      axios.get(`/api/templates/${id}`).then(({ data }) => {
        this.fillModelWithData(data.data);
      })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fillModelWithData(template) {
      this.model = template;
      this.model.site = this.model.site || {};
      this.model.sales_code = this.model.sales_code || {};
      this.model.customer_details = isEmpty(this.model.customer_details) ? {} : this.model.customer_details;
    },
    enableEditMode() {
      this.fetchAccountsBySite(this.model.site_id);
      this.modelCache = { ...this.model };
      this.isEditMode = true;
    },
    changeEditMode(type) {
      this.isEditMode = !!type;
    },
    saveTemplateData() {
      this.enableLoading();
      const method = this.isOldEntry ? "put" : "post";
      const url = this.isOldEntry ? `/api/templates/${this.model.id}` : `/api/sites/${this.selectedSite}/templates`;
      const msg = this.isOldEntry ? "update" : "create";
      const model = { ...this.model };
      model.margin = this.margin;
      model.gp = this.gp;
      model.total_cost = this.totalCost;
      model.net_cost = this.netCost;
      model.material_total = this.materialGrandTotal;
      model.labour_total = Number(this.labourGrandTotal);
      return axios[method](url, model)
        .then(({ data }) => {
          axios.get(`/api/templates/${data.data.id}`)
            .then(({ data }) => {
              this.fillModelWithData(data.data);
            });
          this.changeEditMode(false);
          this.$toastr(
            "success",
            `Successfully ${msg}d template.`,
            "Success!!"
          );
        })
        .catch(error => {
          this.$toastr("error", `Could not ${msg} template.`, "Error!!");
        })
        .finally(() => this.disableLoading());
    },
    openModal(type) {
      if (type) {
        this[`mount${type}`] = true;
      }
    },
    closeModal(type) {
      if (type) {
        this[`mount${type}`] = false;
      }
    },
    changePage(page) {
      this.page = page;
    },
    handleSelectedTemplate(template) {
      this.closeModal('SearchTemplates');
      this.fetchCostingTemplate(template);
    },
    cancelEditMode() {
      this.model = { ...this.modelCache };
      this.changeEditMode(false);
    },
  },
};
</script>

<style scoped>
.text-dark-blue {
  color: blue;
}
.btn.active {
  background-color: cadetblue;
  box-shadow: none !important;
}
.costing-table {
  padding: 5px 30px;
}
.form-control {
  line-height: 24px !important;
}
</style>
