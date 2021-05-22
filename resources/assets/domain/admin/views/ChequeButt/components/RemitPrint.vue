<template>
  <div class="container">
    <div>
      <div class="container-heading margin-t-20">
        <h1 class="container-heading__name container-heading__width">CRONULLA CARPETS</h1>
        <div class="container-heading__address">
          <h6>94-98 Parraweena Road</h6>
          <h6>Taren Point, NSW, 2229</h6>
        </div>
      </div>
      <div class="container-heading">
        <div class="container-heading__subhead container-heading__width">
          <h6>Established 1948</h6>
          <h6>ABN 35 167 849 845</h6>
        </div>
        <div class="container-heading__contact margin-t-5">
          <h6>PHONE (02) 9 525 2155</h6>
          <h6>FAX (02) 9 525 2155</h6>
        </div>
      </div>
    </div>
    <div class="container-subhead margin-t-20">
      <h4 class="bold">Remittance Advice</h4>
      <h4 class="bold">{{ remit.transaction_date }}</h4>
      <h6>Cheque</h6>
      <h6>{{ remit.cheque_number }}</h6>
    </div>
    <h6>
      Cheque payee: {{ remit.payee_name }}
    </h6>

    <table class="margin-t-20 minimalistBlack">
      <thead>
        <tr>
          <th>Our Ref</th>
          <th>Your Ref</th>
          <th>Invoice $</th>
          <th>Adjustment</th>
          <th>Discount</th>
          <th>GST</th>
          <th>Payment</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in remit.items" :key="index">
          <td>{{ item.order_no }}</td>
          <td>{{ item.supplier_reference }}</td>
          <td>${{ item.invoice_amount }}</td>
          <td>${{ item.adjustment }}</td>
          <td>{{ item.discount }}</td>
          <td>{{ item.gst }}</td>
          <td>${{ item.gross_payment.toFixed(2) }}</td>
        </tr>
      </tbody>
    </table>
  </div>  
</template>

<script>
export default {
  name: 'RemitPrint',
  props: {
    remit: {
      type: Object,
      required: true,
    },
  },
  mounted() {
    window.onafterprint = this.sendBack();
    window.print();
  },
  beforeDestroy() {
    window.onafterprint = '';
  },
  methods: {
    sendBack() {
      window.location.href=`/cheque-butt`;
    },
  }
};
</script>

<style>
@media print {
  header {
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
