<template>
  <div class="row">
    <label class="text-right">Choose Primary Rep</label>
    <drop-down
      placeholder="Search Primary Rep"
      v-model="primary_rep"
      :options="sales"
      name="sales"
      v-validate="'required'"
    />
    <span>{{ errors.first('sales') }}</span>
  </div>
</template>

<script>
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: "ChoosePrimaryRep",
  components: {
    DropDown
  },
  props: {
    sales: {
      type: Array,
      required: true
    }
  },
  data: () => ({
    primary_rep: ""
  }),
  watch: {
    primary_rep(value) {
      if (value) {
        return this.$emit("primaryrep", this.primary_rep);
      }
    }
  }
};
</script>

