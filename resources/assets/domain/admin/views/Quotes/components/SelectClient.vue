<template>
  <div class="row">
    <label class="text-right">Select Client</label>
    <drop-down
      placeholder="Search Client"
      v-model="client_id"
      :options="customers"
      name="client"
      label="trading_name"
      v-validate="'required'"
    />
    <span>{{ errors.first('client') }}</span>
  </div>
</template>

<script>
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: "SelectClient",
  components: {
    DropDown
  },
  props: {
    customers: {
      type: Array,
      required: true
    }
  },
  data: () => ({
    client_id: ""
  }),
  watch: {
    client_id(value) {
      if (value) {
        return this.$emit("client", { client_id: this.client_id });
      }
    }
  }
};
</script>

