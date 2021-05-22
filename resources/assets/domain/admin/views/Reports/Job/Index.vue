<template>
    <div class="form-container">
        <loading :loading="loading" />
        <choose-job-report-type
            v-if="mountChooseJobReportType"
            @choosenReportType="choosenReportType"
            @close="closeModal('ChooseJobReportType')"
        />
        <date-filter
            v-if="mountDateFilter"
            :current-report-type="currentReportType"
            @dateFiltered="dateFiltered"
            @close="closeModal('DateFilter')"
        />
        <view-billing-report
            v-if="mountViewBillingReport"
            :filter-data="filterData"
        />
        <view-wip-report
            v-if="mountViewWIPReport"
        />
        <view-job-costs-report
            v-if="mountViewJobCostsReport"
            :filter-data="filterData"
        />
        <view-commission-report
            v-if="mountViewCommissionReport"
        />
        <view-taking-report
            v-if="mountViewTakingReport"
            :filter-data="filterData"
        />
        <view-mit-report
            v-if="mountViewMITReport"
            :filter-data="filterData"
        />
        <view-under-invoiced-report
            v-if="mountViewUnderInvoicedReport"
            :filter-data="filterData"
        />
    </div>
</template>

<script>

import { LoadingMixin } from '../../../../common/mixins';
import ChooseJobReportType from './components/ChooseJobReportType';
import DateFilter from './components/DateFilter';
import ViewWipReport from './components/WorkInProgress/Index'
import ViewBillingReport from './components/Billing/Index'
import ViewCommissionReport from './components/Commission/Index'
import ViewTakingReport from './components/Taking/Index'
import ViewJobCostsReport from './components/JobCosts/Index'
import ViewMitReport from './components/MoneyHeldInTrust/Index'
import ViewUnderInvoicedReport from './components/UnderInvoiced/Index'
import { getBillingReport } from '../../../api/calls';

const BILLING = 1;

export default {
    name: 'JobReport',
    mixins: [LoadingMixin],
    components: {
        ChooseJobReportType,
        DateFilter,
        ViewBillingReport,
        ViewWipReport,
        ViewCommissionReport,
        ViewTakingReport,
        ViewJobCostsReport,
        ViewMitReport,
        ViewUnderInvoicedReport,
    },
    data: () => ({
        mountChooseJobReportType: true,
        mountDateFilter: false,
        mountViewBillingReport: false,
        mountViewMITReport: false,
        mountViewWIPReport: false,
        mountViewJobCostsReport: false,
        mountViewCommissionReport: false,
        mountViewTakingReport: false,
        mountViewUnderInvoicedReport: false,
        billings: [],
        filterData: {},
        currentReportType: '',
    }),
    created() {
        const urlParams = new URLSearchParams(window.location.search)
        if (urlParams.has('type')) {
            this.closeModal('ChooseJobReportType')
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
            this.currentReportType = type;
            this.closeModal('')
            if (type === 'BILLING') {
                this.openModal('DateFilter');
                // this.openModal('ViewBillingReport');
            } else if (type === 'WIP') {
                this.openModal('ViewWIPReport');
            } else if (type === 'COMMISSION') {
                this.openModal('ViewCommissionReport');
            } else if (type === 'TAKING') {
                this.openModal('DateFilter');
            } else if (type === 'JOB_COSTS') {
                this.openModal('DateFilter');
            } else if (type === 'MIT') {
                this.openModal('DateFilter');
            } else if (type === 'UNDER_INVOICED') {
                this.openModal('DateFilter');
            }
        },
        dateFiltered({data, type}) {
            this.filterData = data;
            if (type === 'BILLING') {
                this.openModal('ViewBillingReport');
            } else if (type === 'TAKING') {
                this.openModal('ViewTakingReport');
            } else if (type === 'JOB_COSTS') {
                this.openModal('ViewJobCostsReport');
            } else if (type === 'MIT') {
                this.openModal('ViewMITReport');
            } else if (type === 'UNDER_INVOICED') {
                this.openModal('ViewUnderInvoicedReport');
            }
        },
    },
}
</script>
