<template>

</template>

<script>
  import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
  import Form from '../../../common/utitlities/Form'
  import Modal from '../../../common/components/Modal/Modal'
  import DropDown from '../../../common/components/DropDown/DropDown'
  import SearchTemplate from './components/SearchTemplate'

  let currentDate = new Date().toISOString().split('T')[0];

  export default {
    name: "AddTemplate",
    components: {
      PortletContent,
      Modal,
      DropDown,
      SearchTemplate
    },
    props: {
      template: {type: String, required: false, default: ""},
      products: {type: String, required: true},
      labourproducts: {type: String, required: true},
      url: {required: true, type: String},
      method: {required: true, type: String},
      redirecturl: {type: String, required: true},
    },
    data() {
      return {
        defaultStoreSelected: 0,
        form: new Form(),
        loaded: true,
        page: 1,
        formSubmitting: true,
        productVariants: [],
        mountSearchTemplate: false,
        values: {
          id: "",
          name: '',
          material: {
            selectedVariant: '',
            selectedProduct: '',
            unitCost: 1,
            quantity: 1,
            variantName: '',
          },
          labour: {
            selectedVariant: '',
            selectedProduct: '',
            unitCost: 1,
            quantity: 1,
            variantName: '',
          },
          materials: [],
          labours: []
        },
        sites: [],
      }
    },
    // watch: {
    //   template: {
    //     handler: function(template){
    //       if(!template) {
    //         return
    //       }
    //       this.values = JSON.parse(template);
    //       this.values.material = {};
    //       this.values.labour = {};
    //     },
    //     immediate: true
    //   }
    // },
    computed: {
      defaultStore() {
        return this.sites.find(site => site.id === this.defaultStoreSelected);
      },
      templateId() {
        return this.template ? JSON.parse(this.template).id : '';
      },
      /**
       * Calculate the product price.
       * @returns {number}
       */
      productPrice() {
        return this.values.material.quantity * this.values.material.unitCost;
      },
      /**
       * Calculate the product price.
       * @returns {number}
       */
      labourProductPrice() {
        return this.values.labour.quantity * this.values.labour.unitCost;
      },
      /**
       * Calculate the grand total.
       * @return {number}
       */
      materialGrandTotal() {
        const materials = this.values.materials;
        let sum = 0;
        for (let material of materials) {
          sum += parseInt(material.total);
        }

        return parseInt(sum);
      },
      /**
       * Calculate the grand total.
       * @return {number}
       */
      labourGrandTotal() {
        const labours = this.values.labours;
        let sum = 0;
        for (let labour of labours) {
          sum += parseFloat(labour.total);
        }

        return parseFloat(sum);
      },
      /**
       * Calculate the net cost.
       */
      netCost() {
        return this.labourGrandTotal + this.materialGrandTotal;
      },
      getSelectedSiteName() {
        if (this.values.site_id && this.sites.length) {
          return this.sites.find(site => site.id === this.values.site_id).name;
        }
        return "";
      },
      isOldEntry() {
        return !!this.values.id;
      }
    },
    created() {
      this.fetchSites();
    },
    methods: {
      openModal(type) {
        this[`mount${type}`] = true;
      },
      closeModal(type) {
        this[`mount${type}`] = false;
      },
      handleSelectedTemplate(template) {
        this.closeModal('SearchTemplate');
        window.location.href = `/templates/${template}/edit`
      },
      handleStoreChange(id) {
        if (id) {
          this.values.site_id = id;
        }
      },
      fetchSites() {
        axios.get("/api/sites").then(({ data }) => {
          this.sites = data.data;
        });
      },
      /**
       * Proceed towards the form submission.
       *  */
      submit() {
        this.form = new Form({
          name: this.values.name,
          material_products: this.values.materials,
          labour_products: this.values.labours,
          site_id: this.values.site_id,
        });

        $("html, body").animate({scrollTop: 0}, "slow");
        this.form.onSubmit(this.method, this.url)
          .then(response => {
            this.$toastr('success', this.form.alertMessage, 'Success!!');
            window.location.href = this.redirecturl;
          })
          .catch(errors => {
            this.$toastr('error', this.form.alertMessage, 'Error!!');
          });
      },
      /**
       * Handles the product select event.
       * @param {String} productId
       * */
      handleProductSelect(productId) {
        this.productVariants = [];
        this.values.material.selectedVariant = '';
        this.values.material.unitCost = 0;
        this.values.material.quantity = 1;

        if (productId !== '') {
          let product = this.getProductById(productId);
          this.values.material.unitCost = product.list_cost || 1;
          this.productVariants = product.product_variants;
        }
      },
      getProductById(id) {
        return JSON.parse(this.products).find(product => product.id === id) || {};
      },
      getLabourById(id) {
        return JSON.parse(this.labourproducts).find(product => product.id === id) || {};
      },
      getProductVariantById(id) {
        return this.productVariants.find(product => product.id === id) || {};
      },
      /**
       * Handles the product select event.
       * @param {String} productId
       * */
      handleLabourProductSelect(productId) {
        this.values.labour.selectedVariant = '';
        this.values.labour.unitCost = 0;
        this.values.labour.quantity = 1;

        if (productId !== '') {
          let product = this.getProductById(productId);
          this.values.labour.unitCost = product.unit_cost;
        }
      },
      /**
       * Handle variant select event.
       * **/
      handleVariantSelect(id) {
        let variant = this.getProductVariantById(id);
        this.values.material.variantName = variant.name;
      },
      /**
       * Add new material.
       */
      addNewMaterial() {
        let materialCollection = this.values.materials
        let exists = false
        materialCollection.forEach((material) => {
          if (material.product_id == this.values.material.selectedProduct && material.variant_id == this.values.material.selectedVariant) {
            exists = true
            return
          }
        })
        if (this.values.material.selectedProduct !== "" && this.values.material.selectedVariant !== "" && !exists) {
          let material = {
            product_name: this.getProductName(this.values.material.selectedProduct),
            product_id: this.values.material.selectedProduct,
            variant_name: this.values.material.variantName,
            variant_id: this.values.material.selectedVariant,
            quantity: this.values.material.quantity,
            unit: this.values.material.unitCost
          };
          material.total = this.productPrice;
          this.values.materials.push(material);

          this.values.material = {
            selectedVariant: '',
            selectedProduct: '',
            unitCost: 1,
            quantity: 1,
            variantName: '',
          };

        }
      },
      /**
       * Add new material.
       */
      addNewLabour() {
        let labour = {
          product: this.values.labour.product,
          quantity: this.values.labour.quantity,
          unit: this.values.labour.unitCost
        }
        labour.total = this.labourProductPrice

        this.values.labours.push(labour)

        this.values.labour = {
          unitCost: 1,
          quantity: 1,
          variantName: '',
        }
      },
      /**
       * Remove material from added materials list with given index.
       * @param {Number} index
       */
      removeMaterial(index) {
        this.values.materials.splice(index, 1);
      },
      /**
       * Remove material from added materials list with given index.
       * @param {Number} index
       */
      removeLabour(index) {
        this.values.labours.splice(index, 1);
      },
      /**
       * Generate product name from product id.
       * @param {Number} productId
       * @return {String}
       */
      getProductName(productId) {
        return this.getProductById(productId).name;
      },
      /**
       * Generate labour product name from product id.
       * @param {Number} productId
       * @return {String}
       */
      getLabourProductName(productId) {
        return this.getLabourById(productId).name;
      },
    },
    mounted() {
      if (this.template) {
        const template = JSON.parse(this.template);
        this.values.id = template.id;
        this.values.name = template.name;
        this.values.site_id = template.site_id;
        this.defaultStoreSelected = template.site_id;
        this.values.materials = template.material_products ? template.material_products : {};
        this.values.labours = template.labour_products ? template.labour_products : {};
      }
    }
  }
</script>

<style lang="scss">
    .m-portlet {
        .m-portlet__head {
            padding: 0 1.0rem;
        }

        .m-portlet__body {
            padding: 1.0rem 1.0rem;
        }
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .mt-28 {
        margin-top: 28px;
    }

    .currentPage {
        color: yellow !important;
        background: #848284;
    }

    .commissionInput {
        height: 1.5em;
    }
</style>
