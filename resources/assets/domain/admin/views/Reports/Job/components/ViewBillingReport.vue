<template>
  <div class="container">
    <div class="row">
      <h3 class="col-2">
        <b>Billing</b>
      </h3> 
      <span class="col-9">&nbsp;</span>
      <button class="col-1 noprint" @click="print">Print</button>
    </div>
    <span class="text-right">{{ formatViewDate(new Date()) }}</span>
    <table class="margin-t-20 minimalistBlack">
      <thead>
        <tr>
          <th>Inv No.</th>
          <th>Inv Date</th>
          <th>&nbsp;</th>
          <th>Client</th>
          <th>Project</th>
          <th>Net</th>
          <th>GST</th>
          <th>Gross</th>
          <th>Bal Due</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(billing, index) in billings" :key="index">
          <td>{{ `${billing.job.job_id}/${billing.id}` }}</td>
          <td>{{ formatViewDate(billing.date) }}</td>
          <td>{{ billing.amount > 0 ? 'Tax Invoice' : 'Tax Credit' }}</td>
          <td>{{ billing.job.trading_name }}</td>
          <td>Re: {{ billing.job.project }}</td>
          <td>${{ billing.net_invoice }}</td>
          <td>${{ billing.gst_amount }}</td>
          <td>${{ billing.amount }}</td>
          <td>${{ billing.balance_due }}</td>
          <td>{{ getSalesPersonFromJob(billing.job).name }}</td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
          <td>${{ totalNetAmount }}</td>
          <td>${{ totalGSTAmount }}</td>
          <td>${{ totalGrossAmount }}</td>
          <td>${{ totalBalanceDueAmount }}</td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </div>  
</template>

<script>
import { formatViewDate } from '../../../../../common/utitlities/helpers';

export default {
  name: 'ViewBillingReport',
  props: {
    billings: {
      type: Array,
      required: true,
    },
  },
  mounted() {
    // window.onafterprint = this.sendBack();

  },
  computed: {
    totalNetAmount() {
      const total = this.billings.reduce((sum, invoice) => {
        return sum + Number(invoice.net_invoice);
      }, 0);

      return total.toFixed(2);
    },
    totalGSTAmount() {
      const total = this.billings.reduce((sum, invoice) => {
        return sum + Number(invoice.gst_amount);
      }, 0);

      return total.toFixed(2);
    },
    totalGrossAmount() {
      const total = this.billings.reduce((sum, invoice) => {
        return sum + Number(invoice.amount);
      }, 0);

      return total.toFixed(2);
    },
    totalBalanceDueAmount() {
      const total = this.billings.reduce((sum, invoice) => {
        return sum + Number(invoice.balance_due);
      }, 0);

      return total.toFixed(2);
    },
  },
  // beforeDestroy() {
  //   window.onafterprint = '';
  // },
  methods: {
    formatViewDate,
    print() {
      window.print();
    },
    // sendBack() {
    //   window.location.href=`/suppliers?supplier=${this.remit.supplier_id}`;
    // },
    getSalesPersonFromJob(job) {
      const primarySalesRep = job.primary_sales_person || [];
      if (primarySalesRep.length) {
        return primarySalesRep[0];
      }

      return {};
    }
  }
};
</script>

<style>
@media print {
  header {
    display: none;
  }
  .noprint {
    display: none;
  }
}

</style>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  background: white;
  width: 100%;
  max-width: 100%;
}
.container-heading {
  display: flex;
  justify-content: space-between;
}

.container-heading__name {
  display: inline-block;
  background-color: gray;
  color: white;
  font-weight: bold;
  text-align: center;
  padding-top: 7px;
}

.container-heading__contact {
  font-weight: bold;
}

.container-heading__subhead {
  display: inline-flex;
  justify-content: space-between;
}

.container-subhead {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  font-weight: bold;
}
.container-heading__width {
  width: 384px;
}
.margin-t-20 {
  margin-top: 20px;
}

.margin-t-5 {
  margin-top: 5px;
}

.bold {
  font-weight: bold;
}

table.minimalistBlack {
  border: 3px solid #000000;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.minimalistBlack td, table.minimalistBlack th {
  border: 1px solid #000000;
  padding: 5px 4px;
}
table.minimalistBlack tbody td {
  font-size: 13px;
}
table.minimalistBlack thead {
  background: #CFCFCF;
  background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  border-bottom: 3px solid #000000;
}
table.minimalistBlack thead th {
  font-size: 15px;
  font-weight: bold;
  color: #000000;
  text-align: left;
}
table.minimalistBlack tfoot {
  font-size: 14px;
  font-weight: bold;
  color: #000000;
  border-top: 3px solid #000000;
}
table.minimalistBlack tfoot td {
  font-size: 14px;
}
</style>
