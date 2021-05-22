<template></template>

<script type="text/ecmascript-6">
    import PortletTab from '../../../common/components/Portlets/Tab/PortletTab'
    import PortletTabs from '../../../common/components/Portlets/Tab/PortletTabs'
    import VueTable from '../../../common/components/Datatable/DataTable'

    export default {
        name: "UsersList",
        components: {
            PortletTab,
            PortletTabs,
            VueTable
        },
        data() {
            return {
                selectedTab: '',
            }
        },
        methods: {
            /**
             * Handle the tab change event.
             * @param tab
             */
            handleTabChange(tab) {
                this.selectedTab = tab;
            }
        }
    }
</script>

<style scoped>

</style>