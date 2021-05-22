<template></template>

<script type="text/ecmascript-6">
  import Form from "../../../../common/utitlities/Form";
  import PortletContent from '../../../../common/components/Portlets/Content/PortletContent'
  import Vue from "vue";

  export default {
    name: 'product-type-form',
    props: {
      url: {
        required: true
      },
      method: {
        type: String,
        default: "post"
      },
      producttype: {
        required: false
      },
      selectedvariants: {
        required: false
      },
      redirecturl: {
        required: true
      }
    },
    data() {
      return {
        form: new Form(),
        loaded: true,
        formSubmitting: true,
        variant_name: '',
        values: {
          product_type: {
            category_id: '',
            is_featured: false,
          },
          variants: [],
          deletedVariants: []
        },
      }
    },
    components: {
      PortletContent
    },
    mounted() {
      if (this.method === 'patch') {
        this.loadProductType();
      }
    },
    methods: {
      /**
       * Proceed towards the form submission.
       *  */
      submit() {
        this.form = new Form(this.values);
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
       * Load product type on edit
       */
      loadProductType() {
        this.values.product_type = JSON.parse(this.producttype);
        this.values.variants = JSON.parse(this.selectedvariants);
      },
      /**
       * Handle variant edit click.
       * @param index
       */
      handleVariantEditClick(index) {
        let variants = [...this.values.variants];
        let variant = variants[index];
        variant.is_edit = !variant.is_edit;

        Vue.set(this.values.variants, index, variant);
      },
      /**
       * Add new variant to data object.
       */
      addNewVariant() {
        if (!!this.variant_name) {
          let variant = {
            name: this.variant_name,
          };
          this.values.variants.push(variant);
          this.variant_name = null;
        }
      },
      /**
       * Remove the variant when index is provided.
       * @param {int} index
       * @param {Object} variant
       */
      removeVariant(index, variant) {
        if (variant.hasOwnProperty('id')) {
          this.values.deletedVariants.push(variant.id);
        }
        this.values.variants.splice(index, 1);
      },
    }
  }
</script>
