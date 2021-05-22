<template>
  <div>
    <div class="row">
      <div class="col-2">&nbsp;</div>
      <label>
        Please confirm or change your Cheque Date <br/>
        The default Cheque number is one more than the last cheque drawn<br/>
        The Cheque counter on your setup screen will be updated with the number you use here
      </label>
    </div>
    <div class="row pt-3">
      <label class="col-4 text-right">Cheque Date</label>
      <div class="col-7">
        <input type="date" v-model="model.cheque_date" name="cheque date" v-validate="'required'">
        <label class="error">{{ errors.first('cheque date') }}</label>
      </div>
    </div>
    <div class="row pt-3">
      <label class="col-4 text-right">Cheque Number</label>
      <div class="col-7">
        <input type="text" v-model="model.cheque_number" name="cheque number" v-validate="'required'">
        <label class="error">{{ errors.first('cheque number') }}</label>
      </div>
    </div>
  </div>  
</template>

<script>
export default {
  name: 'ChequeDrawing',
  data: () => ({
    model: {
      cheque_date: '',
      cheque_number: 'C',
    },
  }),
  watch: {
    model: {
      deep: true,
      handler(value) {
        return this.$emit('updated', value);
      }
    },
  },
};
</script>
