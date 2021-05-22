<template>
  <div>
    <div class="row">
      <label class="col-4 text-right">Remmitance Number: </label>
      <label class="col-7">{{ remit.cheque_number }}</label>
    </div>
    <div class="row pt-1">
      <label class="col-4 text-right">Remmitance Date: </label>
      <label class="col-7">{{ remit.cheque_date || remit.transaction_date }}</label>
    </div>
    <div class="row pt-1">
      <label class="col-4 text-right">Payee</label>
      <input class="col-7 form-control" type="text" v-model="model.payee_name" name="payee" v-validate="'required'">
      <label class="error">{{ errors.first('payee') }}</label>
    </div>
    <div class="row pt-1">
      <label class="col-4 text-right pr-2">Street</label>
      <input class="col-7 form-control" type="text" v-model="model.payee_street">
    </div>
    <div class="row pt-1">
      <label class="col-4 text-right pr-2">Town/Suburb</label>
      <input class="col-7 form-control" type="text" v-model="model.payee_town">
    </div>
    <div class="row pt-1">
      <label class="col-3 text-right pr-2">State</label>
      <input class="col-3 form-control" type="text" v-model="model.payee_state">
      <label class="col-2 text-right pr-2">Code</label>
      <input class="col-3 form-control" type="text" v-model="model.payee_code">
    </div>
    <div class="row pt-2">
      <label class="col-4 text-right pr-2">Notes</label>
      <input class="col-7 form-control" type="text" v-model="model.notes[0]" />
    </div>
    <div class="row pt-1">
      <label class="col-4 text-right pr-2">&nbsp;</label>
      <input class="col-7 form-control" type="text" v-model="model.notes[1]" />
    </div>
    <div class="row pt-1">
      <label class="col-4 text-right pr-2">&nbsp;</label>
      <input class="col-7 form-control" type="text" v-model="model.notes[2]" />
    </div>
    <div class="row pt-1">
      <label class="col-4 text-right pr-2">&nbsp;</label>
      <input class="col-7 form-control" type="text" v-model="model.notes[3]" />
    </div>
  </div>  
</template>

<script>
export default {
  name: 'CreateManual',
  data: () => ({
    model: {
      payee_name: '',
      payee_street: '',
      payee_town: '',
      payee_state: '',
      payee_code: '',
      notes: [],
    },
  }),
  props: {
    remit: {
      type: Object,
      default: {}
    },
    currentSupplier: {
      type: Object,
      default: {}
    },
  },
  watch: {
    model: {
      deep: true,
      handler(value) {
        return this.$emit('updated', value);
      }
    },
  },
  mounted() {
    this.fetchSupplier();
  },
  methods: {
    fetchSupplier() {
      axios.get(`/api/suppliers/${this.currentSupplier}`)
        .then(({ data }) => {
          const supplier = data.data;
          this.model.payee_name = supplier.trading_name;
          this.model.payee_street = supplier.street;
          this.model.payee_town = supplier.suburb;
          this.model.payee_state = supplier.state;
          this.model.payee_code = supplier.code;
        })
        .catch(error => console.log("could not fetch suppliers"));
    }
  }
};
</script>
