<template>
    <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line" role="tablist">
                    <li v-for="tab in tabs" class="nav-item m-tabs__item">
                        <a href="javascript:void(0)" class="nav-link m-tabs__link" :class="{'active' : tab.isActive }" role="tab" @click="selectTab(tab)" v-html="tab.title"></a>
                    </li>
                </ul>
            </div>
            <div class="m-portlet__head-caption" style="float: right !important; margin-top: 15px;">
                <div class="m-portlet__head-title">
                        <slot name="buttons"></slot>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PortletTabs",
        data() {
            return {
                tabs: []
            }
        },
        mounted() {
            this.tabs = this.$children;
            this.selectTab(this.tabs[0]);
        },
        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name === selectedTab.name)
                });
                this.$emit('tab-changed', selectedTab.name);
            }
        }
    }
</script>

<style scoped>

</style>