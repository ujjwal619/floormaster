<template>

</template>

<style scoped>
  .border-left {
    border-left: 1px solid white;
    /*box-shadow: 5px 0 5px 1px #ccc;*/
  }
  .border-right {
    border-right: 1px solid white;
  }
  .border-bottom {
    border-bottom: 1px solid white;
  }
  .border-top {
    border-top: 1px solid white;
  }
</style>

<script>
  import axios from 'axios';
  import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
  import Modal from '../../../common/components/Modal/Modal'
  import DropDown from '../../../common/components/DropDown/DropDown'
  import Form from '../../../common/utitlities/Form';
  import { LoadingMixin } from "../../../common/mixins";
  import { getSites, getAccountsBySite, getSuppliersBySite, isMySite } from "../../api/calls";
  import SearchSupplier from '../Suppliers/components/SearchSupplier'
  import { isEmpty } from "../../../common/utitlities/helpers";
  import AddColor from "./components/AddColor";

  const CATEGORY_OPTIONS = {
    SET: 'set_category',
    UPDATE: 'update_category',
  };

	export default {
		name: "Products",
    mixins: [LoadingMixin],
    components: {
      PortletContent,
      Modal,
      DropDown,
      SearchSupplier,
      AddColor
    },
    props: {
      products: {
        type: Array,
        default: () => ([])
      },
      // categories: {
      //   type: Array,
      //   default: () => ([])
      // },
      selectedSupplier: {
        type: [Object, Array],
        default: () => ({})
      },
      selectedProduct: {
        type: Object,
        default: () => ({})
      },
    },
    data() {
      return {
        mountAddColor: false,
        suppliersSiteWise: [],
        selectedSite: '',
        modals: {
          category: {
            show: false,
            isEdit: false,
            values: {},
          },
          searchSupplier: {
            show: false,
            values: {}
          },
          searchCategory: {
            show: false,
            afterAction: CATEGORY_OPTIONS.SET,
            values: {}
          },
          sellPrice: {
            show: false,
            values: {}
          },
        },
        sites: [],
        shareSites: [],
        mountSearchSupplier: '',
        form: new Form(),
        product: {
          supplier_id: this.selectedSupplier.id,
          trade_sell: {},
          retail_sell: {},
          installed: {},
          levy: this.selectedSupplier.levy_percent,
          gst: this.selectedSupplier.site.gst,
        },
        loaded: true,
        values: {
          variants: []
        },
        variantName: '',
        variants: [],
        gstTradeSell: 0,
        netTradeSell: 0,
        tradeMargin: 0,
        gpTrade: 0,
        gstRetailSell: 0,
        netRetailSell: 0,
        retailMargin: 0,
        gpRetail: 0,
        gstInstalledSell: 0,
        netInstalledSell: 0,
        installedMargin: 0,
        gpInstalled: 0,
        accounts: [],
        selectedVariant: {},
        selectedVariantIndex: '',
        categorySiteId: '',
        categoryCOSAccountId: '',
        categoryInventoryAccountId: '',
        categories: [],
        isUsersSite: false,
      };
    },
    CATEGORY_OPTIONS,
    computed: {
      defaultCategoryCosAccount() {
        if (this.modals.category.values.cos_account_id) {
          return this.findAccountById(this.modals.category.values.cos_account_id);
        }

        return {};
      },
      defaultCategoryInventoryAccount() {
        if (this.modals.category.values.inventory_account_id) {
          return this.findAccountById(this.modals.category.values.inventory_account_id);
        }

        return {};
      },
		  isEdit() {
		    return !!this.selectedProduct.id;
      },
      productCategoryTitle() {
		    return (this.modals.category.isEdit ? 'Update' : 'Add') + ' Product Category';
      },
      discountedCost() {
		    const listCost = Number(this.product.list_cost);
		    if (!this.product.discount) {
		      return listCost;
        }
        const discount = (listCost * Number(this.product.discount)) / 100;
        return listCost - discount;
      },
      netCost() {
		    if (!this.product.levy) {
		      return this.discountedCost;
        }
        const levy = (this.discountedCost * Number(this.product.levy)) / 100;
        return this.discountedCost + levy;
      },
      gst() {
		    return Number(this.product.gst) || 0;
      },
      productTradeSell() {
		    return this.product.trade_sell || {};
      },
      productRetailSell() {
        return this.product.retail_sell || {};
      },
      productInstalledSell() {
        return this.product.installed || {};
      },
      productListCost() {
		    return Number(this.product.list_cost);
      },
      productNetCost() {
		    return (Number(this.product.net_cost)).toFixed(2);
      },
      installedExtraMaterials() {
		    return Number(this.productInstalledSell.extra_materials) || 0;
      },
      installedLabours() {
        return Number(this.productInstalledSell.labours) || 0;
      },
      installedOther() {
        return Number(this.productInstalledSell.other) || 0;
      },
    },
    watch: {
		  selectedProduct: {
		    immediate: true,
        handler(product) {
		      if (product.supplier_id && !this.product.id) {
            this.product = product;
            this.product.upc = product.upc || product.id;
            this.product.trade_sell = isEmpty(product.trade_sell) ? {} : product.trade_sell;
            this.product.retail_sell = isEmpty(product.retail_sell) ? {} : product.retail_sell;
            this.product.installed = isEmpty(product.installed) ? {} : product.installed;
            this.netTradeSell = this.product.trade_sell.net_sell;
            this.gstTradeSell = this.product.trade_sell.with_gst;
            this.tradeMargin = this.product.trade_sell.margin;
            this.gpTrade = this.product.trade_sell.gp;
            this.netRetailSell = this.product.retail_sell.net_sell;
            this.gstRetailSell = this.product.retail_sell.with_gst;
            this.retailMargin = this.product.retail_sell.margin;
            this.gpRetail = this.product.retail_sell.gp;
            this.netInstalledSell = this.product.installed.net_sell;
            this.gstInstalledSell = this.product.installed.with_gst;
            this.installedMargin = this.product.installed.margin;
            this.gpInstalled = this.product.installed.gp;
            this.variants = product.product_variants;
            this.values.variants = product.product_variants;
          }
        }
      },
      netCost: {
		    handler(cost) {
		      this.product.net_cost = cost.toFixed(2);
        }
      },
      categorySiteId: {
		    handler(site) {
		      this.fetchAccountsBySite(site);
        }
      },
      // selectedSite: {
      //   handler(site) {
      //     this.fetchSuppliersBySite(site);
      //   }
      // },
      'product.list_cost': {
		    handler() {
		      console.log('at first');
		      this.calculateSellPrice();
        }
      },
      'product.discount': {
        handler() {
          this.calculateSellPrice();
        }
      },
      'product.levy': {
        handler() {
          this.calculateSellPrice();
        }
      },
      'modals.searchCategory.values.site_id': {
        handler(id) {
          this.fetchCategoriesBySite(id);
        }
      }
    },
    created() {
      this.fetchSites();
      this.fetchSitesForSharing();
      this.selectedSite = this.selectedSupplier.site_id;
      this.isThisMySite(this.selectedSupplier.site_id);
    },
    methods: {
      isEmpty,
      redirectToAddProduct() {
        window.location.href = `/products/create?supplier=${this.selectedSupplier.id}`
      },
      fetchSuppliersBySite(siteId) {
        this.enableLoading();
        getSuppliersBySite(siteId)
          .then(({ data }) => {
            this.suppliersSiteWise = data.data;
          })
          .catch(() => {
            console.log('could not fetch suppliers.');
          })
          .finally(this.disableLoading)
      },
      fetchAccountsBySite(siteId) {
        getAccountsBySite(siteId)
          .then(({ data }) => {
            this.accounts = data.data;
          })
          .catch(() => {
            console.log('could not fetch accounts.');
          })
      },
      isThisMySite(siteId) {
        isMySite(siteId)
          .then(({ data }) => {
            this.isUsersSite = data.data.is_my_site;
          })
          .catch(() => {
            console.log('could not my site.');
          })
      },
      findAccountById(id) {
        return this.accounts.find(account => account.id === id) || {};
      },
		  openAddCategoryModal() {
        this.modals.category.show=true;
      },
      openModal(type) {
        this[`mount${type}`] = true;
      },
      handleSelectedSupplier(supplier) {
        this.closeModal('SearchSupplier');
        if (supplier) {
          window.location.href = `/products?supplier=${supplier}`;
        }
      },
      closeModal(type) {
        this[`mount${type}`] = false;
      },
      fetchSites() {
        this.enableLoading();
        getSites()
          .then(({ data }) => {
            this.sites = data.data;
            this.fetchCategoriesBySite(this.selectedSupplier.site_id);
          })
          .catch(error => console.log(error))
          .finally(() => this.disableLoading());
      },
      fetchSitesForSharing() {
        this.enableLoading();
        getSites({for: 'share-site'})
          .then(({ data }) => {
            this.shareSites = data.data;
            this.fetchCategoriesBySite(this.selectedSupplier.site_id);
          })
          .catch(error => console.log(error))
          .finally(() => this.disableLoading());
      },
      fetchCategoriesBySite(siteId) {
        return axios.get(`/api/categories?site_id=${siteId}`)
        .then(({ data }) => {
          this.categories = data.data;
        })
      },
		  saveProduct() {
		    const product = this.product;
		    product.trade_sell.net_sell = this.netTradeSell;
		    product.trade_sell.with_gst = this.gstTradeSell;
		    product.trade_sell.margin = this.tradeMargin;
		    product.trade_sell.gp = this.gpTrade;
        product.retail_sell.net_sell = this.netRetailSell;
        product.retail_sell.with_gst = this.gstRetailSell;
        product.retail_sell.margin = this.retailMargin;
        product.retail_sell.gp = this.gpRetail;
        product.installed.net_sell = this.netInstalledSell;
        product.installed.with_gst = this.gstInstalledSell;
        product.installed.margin = this.installedMargin;
        product.installed.gp = this.gpInstalled;
        product.site_id = this.selectedSite;
		    product.variants = this.variants;
        this.form = new Form(this.product);
        const method = this.isEdit ? 'put' : 'post';
        const url = this.isEdit ? `/products/${this.selectedProduct.id}` : '/products';
        axios[method](url, this.product)
          .then(() => {
            this.$toastr('success', 'Product saved successfully.', 'Success!!');
            window.location.href = `/products?supplier=${this.product.supplier_id}`;
          })
          .catch(({response}) => {
            console.log(response, 445);
            this.$toastr('error', response.data.message, 'Error!!')
          })
      },
      handleCancel() {
        window.location.href = `/products?supplier=${this.product.supplier_id}`;
      },
      getSupplierById(id) {
        return this.suppliers.find(supplier => supplier.id === id);
      },
      getCategoryById(id) {
        return this.categories.find(category => category.id === id);
      },
      deleteProduct(id) {
        const isConfirmed = window.confirm('Are you sure?')
        if (isConfirmed) {
          axios.delete(`/products/${id}`)
            .then(() => {
              this.$toastr('success', 'Successfully Deleted Product', 'Success!!');
              window.location.href = `/products?supplier=${this.product.supplier_id}`;
            })
            .catch(() => {
              this.$toastr('error', 'Could not delete product', 'Error!!')
            })
        }
      },
      removeCategory() {
        const id = this.modals.category.values.id;
        const isConfirmed = window.confirm('Are you sure?')
        if (isConfirmed) {
          axios.delete(`/products/categories/${id}`)
            .then(() => {
              this.$toastr('success', 'Successfully Deleted Product Category', 'Success!!');
              window.location.href = '/products';
            })
            .catch(() => {
              this.$toastr('error', this.form.alertMessage, 'Error!!')
            })
        }
      },
      validate() {
        return this.$validator.validate();
      },
      saveCategory() {
        this.validate().then(valid => {
          if(valid) {
            this.modals.category.values.cos_account_id = this.categoryCOSAccountId;
            this.modals.category.values.inventory_account_id = this.categoryInventoryAccountId;
            this.modals.category.values.site_id = this.categorySiteId || this.modals.category.values.site_id;
            this.form = new Form(this.modals.category.values);
            const method = this.modals.category.isEdit ? 'put' : 'post';
            const url = this.modals.category.isEdit ? `/products/categories/${this.modals.category.values.id}` : '/products/categories';
            this.form.onSubmit(method, url)
              .then(() => {
                this.$toastr('success', this.form.alertMessage, 'Success!!');
                window.location.href = '/products';
              })
              .catch(() => {
                this.$toastr('error', this.form.alertMessage, 'Error!!')
              })
          }
        });
      },
      getProductEditUrl(id) {
		    return `/products/${id}/edit`;
      },
      addNewVariant() {
        if (!!this.variantName) {
          let variant = {
            name: this.variantName,
            site_id: this.selectedSite,
          };
          this.values.variants.push(variant);
          this.variants = this.values.variants.slice();
          this.variantName = '';
        }
      },
      savingColorFinished(colors) {
        this.variants = [];
        const newColors = colors;
        this.variants = newColors.slice();
        console.log(this.variants);
        this.closeAddColorModal();
      },
      closeAddColorModal() {
        this.mountAddColor = false;
        this.selectedVariant = {};
      },
      handleVariantEditClick(index) {
        let variants = [...this.variants];
        let variant = variants[index];

        variant.is_edit = !variant.is_edit;

        this.$set(this.variants, index, variant);
      },
      openVariantEditModal(variant, index) {
        this.selectedVariant = { ...variant };
        this.selectedVariantIndex = index;
        this.mountAddColor = true;
      },
      removeVariant(index) {
        this.variants.splice(index, 1);
      },
      showSearchModal() {
        this.modals.searchSupplier.show = true;
      },
      searchSupplier() {
        const supplier = this.modals.searchSupplier.values.supplier;
        if (supplier) {
          window.location.href = `/products?supplier=${supplier}`;
        }
      },
      hideSearchModal() {
        this.modals.searchSupplier.show = false;
      },
      showSearchCategoryModal(action) {
        this.modals.searchCategory.afterAction = action;
        this.modals.searchCategory.show = true
      },
      searchCategory() {
        // if (this.modals.searchBookingType.afterAction === BOOKING_TYPE_OPTIONS.SET) {
        //   window.location.href = `/bookings?booking_type=${this.modals.searchBookingType.values.booking_type_id}`
        // }
        if (this.modals.searchCategory.afterAction === CATEGORY_OPTIONS.UPDATE) {
          this.modals.searchCategory.show = false;
          this.showCategoryModal();
        }
      },
      showCategoryModal() {
        const categoryId = this.modals.searchCategory.values.category_id;
        if (categoryId) {
          const category = this.getCategoryById(categoryId);
          this.fetchAccountsBySite(category.site_id);
          this.modals.category.isEdit = true;
          this.modals.category.values = {
            id: category.id,
            title: category.title,
            site_id: category.site_id,
            inventory_account_id: category.inventory_account_id,
            cos_account_id: category.cos_account_id,
            site_name: category.site_name,
          };
        }
        this.modals.category.show = true;
      },
      hideCategoryModal() {

        this.modals.category.show = false;
        this.modals.category.values = {};
        this.modals.category.isEdit = false;
      },
      showSellPriceModal() {
		    this.modals.sellPrice.show = true;
      },
      calculateAndHide() {
        this.calculateSellPrice();
        this.hideSellPriceModal();
      },
      calculateSellPrice() {
        const tradeGstSell = Number(this.productTradeSell.gst_sell);
        const tradeAddDollar = Number(this.productTradeSell.add_dollar);
        const tradeAddPercent = Number(this.productTradeSell.add_percent);
        this.gstTradeSell = 0;
        this.netTradeSell = 0;
        this.tradeMargin = -Number(this.productNetCost);
        if (tradeGstSell) {
          // gst trade sell
          this.gstTradeSell = Number(tradeGstSell);
          // net trade sell
          if (!this.gst) {
            this.netTradeSell = Number(this.gstTradeSell);
          } else {
            const price = (100 * Number(this.gstTradeSell)) / (100 + Number(this.gst))
            this.netTradeSell = Number(price.toFixed(2));
          }
          // trade margin
          const margin = this.netTradeSell - Number(this.productNetCost);
          this.tradeMargin = Number(margin.toFixed(2));
        }
        if (tradeAddDollar) {
          // net trade sell
          const nettrade = tradeAddDollar + Number(this.productNetCost);
          this.netTradeSell = Number(nettrade.toFixed(2));
          // gst trade sell
          if (!this.gst) {
            this.gstTradeSell = this.netTradeSell;
          } else {
            const gsttrade = nettrade + (nettrade * (this.gst/100));
            this.gstTradeSell = Number(gsttrade.toFixed(2));
          }
          // trade margin
          this.tradeMargin = Number(this.productTradeSell.add_dollar);
        }
        if (tradeAddPercent) {
          // trade margin
          const trademargin = Number(this.productNetCost) * (tradeAddPercent/100);
          this.tradeMargin = Number(trademargin.toFixed(2));
          // net trade sell
          const tradesell = trademargin + Number(this.productNetCost);
          this.netTradeSell = Number(tradesell.toFixed(2));
          // gst trade sell
          if (!this.gst) {
            this.gstTradeSell = this.netTradeSell;
          } else {
            const gstTrade = Number(tradesell + (this.netTradeSell * (this.gst/100)));
            this.gstTradeSell = Number(gstTrade.toFixed(2));
          }
        }

        this.gpTrade = Number(this.netTradeSell) > 0 ? Number(Math.abs(Number((Number(this.tradeMargin) / Number(this.netTradeSell)) * 100)).toFixed()) : 0;

        const retailGstSell = Number(this.productRetailSell.gst_sell);
        const retailAddDollar = Number(this.productRetailSell.add_dollar);
        const retailAddPercent = Number(this.productRetailSell.add_percent);
        this.gstRetailSell = 0;
        this.netRetailSell = 0;
        this.retailMargin = -Number(this.productNetCost);
        if (retailGstSell) {
          // gst retail sell
          this.gstRetailSell = Number(retailGstSell).toFixed(2);
          // net retail sell
          if (!this.gst) {
            this.netRetailSell = this.gstRetailSell;
          } else {
            const price = (100 * this.gstRetailSell) / (100 + Number(this.gst))
            this.netRetailSell = Number(price.toFixed(2));
          }
          // retail margin
          const margin = this.netRetailSell - Number(this.productNetCost);
          this.retailMargin = Number(margin.toFixed(2));
        }
        if (retailAddDollar) {
          // net retail sell
          this.netRetailSell = retailAddDollar + Number(this.productNetCost);
          // gst retail sell
          if (!this.gst) {
            this.gstRetailSell = this.netRetailSell;
          } else {
            const gstretail = this.netRetailSell + (this.netRetailSell * (this.gst/100));
            this.gstRetailSell = Number(gstretail.toFixed(2));
          }
          // retail margin
          this.retailMargin = Number(retailAddDollar.toFixed(2));
        }
        if (retailAddPercent) { 
          // retail margin
          const retailmargin = Number(this.productNetCost) * (retailAddPercent/100);
          this.retailMargin = Number(retailmargin.toFixed(2));
          // net retail sell
          const netretail = retailmargin + Number(this.productNetCost);
          this.netRetailSell = Number(netretail.toFixed(2));
          // gst retail sell
          if (!this.gst) {
            this.gstRetailSell = this.netRetailSell;
          } else {
            const gstretail = netretail + (netretail * (this.gst/100));
            this.gstRetailSell = Number(gstretail.toFixed(2));
          }
        }

        this.gpRetail = Number(this.netRetailSell) > 0 ? Number(Math.abs(Number((Number(this.retailMargin) / Number(this.netRetailSell)) * 100)).toFixed()) : 0;

        const installedGstSell = Number(this.productInstalledSell.gst_sell);
        const installedAddDollar = Number(this.productInstalledSell.add_dollar);
        const installedAddPercent = Number(this.productInstalledSell.add_percent);
        this.gstInstalledSell = 0;
        this.netInstalledSell = 0;
        this.installedMargin = -Number(this.productNetCost);
        if(this.productInstalledSell.extra_materials) {
          this.installedMargin = this.installedMargin - Number(this.productInstalledSell.extra_materials);
        }
        if(this.productInstalledSell.labours) {
          this.installedMargin = this.installedMargin - Number(this.productInstalledSell.labours);
        }
        if(this.productInstalledSell.other) {
          this.installedMargin = this.installedMargin - Number(this.productInstalledSell.other);
        }
        this.installedMargin = this.installedMargin.toFixed(2);
        if (installedGstSell) {
          // gst installed sell
          this.gstInstalledSell = Number(installedGstSell);
          // net installed sell
          if (!this.gst) {
            this.netInstalledSell = this.gstInstalledSell;
          } else {
            const price = (100 * this.gstInstalledSell) / (100 + Number(this.gst))
            this.netInstalledSell = Number(price.toFixed(2));
          }
          // installed margin
          this.installedMargin = this.netInstalledSell
            - Number(this.productNetCost);
          if(this.productInstalledSell.extra_materials) {
            this.installedMargin = this.installedMargin - Number(this.productInstalledSell.extra_materials);
          }
          if(this.productInstalledSell.labours) {
            this.installedMargin = this.installedMargin - Number(this.productInstalledSell.labours);
          }
          if(this.productInstalledSell.other) {
            this.installedMargin = this.installedMargin - Number(this.productInstalledSell.other);
          }
          this.installedMargin = this.installedMargin.toFixed(2);
        }
        if (installedAddDollar) {
          // net installed sell
          this.netInstalledSell = installedAddDollar + Number(this.productNetCost);
          if(this.productInstalledSell.extra_materials) {
            this.netInstalledSell = this.netInstalledSell + Number(this.productInstalledSell.extra_materials);
          }
          if(this.productInstalledSell.labours) {
            this.netInstalledSell = this.netInstalledSell + Number(this.productInstalledSell.labours);
          }
          if(this.productInstalledSell.other) {
            this.netInstalledSell = this.netInstalledSell + Number(this.productInstalledSell.other);
          }
          this.netInstalledSell = Number(Number(this.netInstalledSell).toFixed(2));
          // gst installed sell
          if (!this.gst) {
            this.gstInstalledSell = this.netInstalledSell;
          } else {
            const gstinstalled = Number(this.netInstalledSell) + (Number(this.netInstalledSell) * (this.gst/100));
            this.gstInstalledSell = Number(gstinstalled.toFixed(2));
          }
          // installed margin
          this.installedMargin = this.productInstalledSell.add_dollar;
        }
        if (installedAddPercent) {
          // installed margin
          let productListCost = Number(this.productNetCost);
          if(this.productInstalledSell.extra_materials) {
            productListCost = productListCost + Number(this.productInstalledSell.extra_materials);
          }
          if(this.productInstalledSell.labours) {
            productListCost = productListCost + Number(this.productInstalledSell.labours);
          }
          if(this.productInstalledSell.other) {
            productListCost = productListCost + Number(this.productInstalledSell.other);
          }
          const installmargin = productListCost * (installedAddPercent/100);
          this.installedMargin = Number(installmargin.toFixed(2));
          // net installed sell
          const netinstalled = installmargin + productListCost;
          this.netInstalledSell = Number(netinstalled.toFixed(2));
          // gst installed sell
          if (!this.gst) {
            this.gstInstalledSell = this.netInstalledSell;
          } else {
            const gstinstalled = netinstalled + (netinstalled * (this.gst/100));
            this.gstInstalledSell = Number(gstinstalled.toFixed(2));
          }
        }

        this.gpInstalled = Number(this.netInstalledSell) > 0 ? Number(Math.abs(Number((Number(this.installedMargin) / Number(this.netInstalledSell)) * 100)).toFixed()) : 0;
      },
      hideSellPriceModal() {
        this.modals.sellPrice.show = false;
      },
      fillSalePrice() {},
      isLastRow(index) {
		    return (this.products.length - 1) === index;
      },
    },
	}
</script>
