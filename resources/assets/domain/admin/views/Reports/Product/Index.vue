<template>
    <div class="form-container">
        <loading :loading="loading" />
        <choose-product-report-type
            v-if="mountChooseProductReportType"
            @choosenReportType="choosenReportType"
            @close="closeModal('ChooseProductReportType')"
        />
        <view-full-price-list-by-supplier-report
            v-if="mountViewFullPriceListBySupplierReport"
        />
        <view-short-price-list-report
            v-if="mountViewShortPriceListReport"
        />
        <view-material-only-report
            v-if="mountViewMaterialOnlyReport"
        />
        <view-colourways-report
            v-if="mountViewColourwaysReport"
        />
        <view-full-price-list-by-range-report
            v-if="mountViewFullPriceListByRangeReport"
        />
        <view-short-price-list-by-range-report
            v-if="mountViewShortPriceListByRangeReport"
        />
        <view-short-price-list-square-unit-report
            v-if="mountViewShortPriceListSquareUnitReport"
        />
    </div>
</template>

<script>

import { LoadingMixin } from '../../../../common/mixins';
import ChooseProductReportType from './components/ChooseProductReportType';
import ViewFullPriceListBySupplierReport from './components/FullPriceListBySupplier/Index'
import ViewFullPriceListByRangeReport from './components/FullPriceListByRange/Index'
import ViewShortPriceListByRangeReport from './components/ShortPriceListByRange/Index'
import ViewShortPriceListReport from './components/ShortPriceList/Index'
import ViewMaterialOnlyReport from './components/MaterialOnly/Index'
import ViewColourwaysReport from './components/Colourways/Index'
import ViewShortPriceListSquareUnitReport from './components/ShortPriceListSquareUnit/Index'

export default {
    name: 'ProductReport',
    mixins: [LoadingMixin],
    components: {
        ChooseProductReportType,
        ViewFullPriceListBySupplierReport,
        ViewShortPriceListReport,
        ViewMaterialOnlyReport,
        ViewFullPriceListByRangeReport,
        ViewShortPriceListByRangeReport,
        ViewColourwaysReport,
        ViewShortPriceListSquareUnitReport
    },
    data: () => ({
        mountChooseProductReportType: true,
        mountViewFullPriceListBySupplierReport: false,
        mountViewShortPriceListReport: false,
        mountViewMaterialOnlyReport: false,
        mountViewColourwaysReport: false,
        mountViewFullPriceListByRangeReport: false,
        mountViewShortPriceListByRangeReport: false,
        mountViewShortPriceListSquareUnitReport: false,
    }),
    created() {
        const urlParams = new URLSearchParams(window.location.search)
        if (urlParams.has('type')) {
            this.closeModal('ChooseProductReportType')
            this.choosenReportType(urlParams.get('type'));
        }
    },
    methods: {
        openModal(type) {
            this[`mount${type}`] = true;
        },
        closeModal(type) {
            this[`mount${type}`] = false;
        },
        choosenReportType(type) {
            this.closeModal('')
            if (type === 'FULL_PRICE_LIST_BY_SUPPLIER') {
                this.openModal('ViewFullPriceListBySupplierReport');
            } else if (type === 'SHORT_PRICE_LIST') {
                this.openModal('ViewShortPriceListReport');
            } else if (type === 'MATERIAL_ONLY') {
                this.openModal('ViewMaterialOnlyReport');
            } else if (type === 'COLOURWAYS') {
                this.openModal('ViewColourwaysReport');
            } else if (type === 'FULL_PRICE_LIST_BY_RANGE') {
                this.openModal('ViewFullPriceListByRangeReport');
            } else if (type === 'SHORT_PRICE_LIST_BY_RANGE') {
                this.openModal('ViewShortPriceListByRangeReport');
            } else if (type === 'SHORT_LIST_SQUARE_UNIT') {
                this.openModal('ViewShortPriceListSquareUnitReport');
            }
        },
    },
}
</script>
