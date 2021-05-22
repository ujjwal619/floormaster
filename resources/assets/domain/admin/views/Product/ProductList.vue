<template></template>

<script type="text/ecmascript-6">
  import PortletTabs from '../../../common/components/Portlets/Tab/PortletTabs'
  import PortletTab from '../../../common/components/Portlets/Tab/PortletTab'
  import VueTable from '../../../common/components/Datatable/DataTable'
  import Modal from '../../../common/components/Modal/Modal'

  export default {
    name: 'product-list',
    props: ['productindexurl'],
    data() {
      return {
        selectedTab: '',
        productType: '',
        modals: {
          productTypes: {
            show: false,
            disableSave: false,
          }
        }
      }
    },
    components: {
      PortletTab,
      PortletTabs,
      VueTable,
      Modal
    },
    methods: {
      /**
       * Handle the tab change event.
       * @param tab
       */
      handleTabChange(tab) {
        this.selectedTab = tab;
      },
      /**
       * Shows modal along with resetting the form.
       **/
      showModal(modal) {
        this.modals[modal].show = true;
      },
      /**
       * Hides modal along with resetting the form.
       **/
      hideModal(modal) {
        this.modals[modal].show = false;
      },
      /**
       * Proceeds the process fo creating product.
       */
      proceedToCreateProduct() {
        if(!this.productType) {
          this.$toastr('error', 'Please Select a Product type', 'Error');

          return false;
        }

        window.location = `${this.productindexurl}/${this.productType}/create`;
      }
    }
  }
</script>
