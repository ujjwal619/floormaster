<template>
  <portlet-content :height="465" :onlybody="true">
    <div slot="body" class="row">
      <div class="col-12 pl-3">
        <div class="row table-wrap">
          <table class="table">
              <tbody>
              <tr class="row col-12">
                  <td class="table-head col-1">&nbsp;</td>
                  <td class="table-head col-1">Date</td>
                  <td class="table-head col-1">Name</td>
                  <td class="table-head col-1">Job</td>
                  <td class="table-head col-1">Code</td>
                  <td class="table-head col-2">Account</td>
                  <td class="table-head col-1 text-right">Debit</td>
                  <td class="table-head col-1">Code</td>
                  <td class="table-head col-2">Account</td>
                  <td class="table-head col-1 text-right">Credit</td>
              </tr>
              </tbody>
          </table>
        </div>
        <div class="row table-wrap" style="max-height: 420px;overflow-y: auto;scrollbar-width: none;">
          <table class="table">
            <tbody>
              <tr class="row col-12 pb-1"  v-for="journal in journals" :key="journal.id" @click="emitJournalClick(journal)" >
                <td class="form-control col-1">{{ journal.id }}</td>
                <td class="form-control col-1">{{ formatViewDate(journal.date) }}</td>
                <td class="form-control col-1">{{ journal.name }}</td>
                <td class="form-control col-1">{{ journal.job ? journal.job.site.quote_prefix + '' + journal.job.job_id : '' }}</td>
                <td class="form-control col-1">{{ journal.debit_account ? journal.debit_account.code : '' }}</td>
                <td class="form-control col-2">{{ journal.debit_account ? journal.debit_account.name : '' }}</td>
                <td class="form-control col-1 text-right">{{ displayMoney(journal.debit_amount) }}</td>
                <td class="form-control text-primary col-1">{{ journal.credit_account ? journal.credit_account.code : '' }}</td>
                <td class="form-control text-primary col-2">{{ journal.credit_account ? journal.credit_account.name : '' }}</td>
                <td class="form-control text-primary col-1 text-right">{{ displayMoney(journal.credit_amount) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </portlet-content>
</template>

<script>
  import PortletContent from "../../../../common/components/Portlets/Content/PortletContent";
  import TransactionJournalMixin from '../TransactionJournalMixin';

  export default {
    name: 'SalesTable',
    mixins: [TransactionJournalMixin],
    components: {
      PortletContent,
    },
    props: {
      journals: {
        type: Array,
        default: [],
      },
    },
  }
</script>
