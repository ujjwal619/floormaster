<template>
  <div>
    <div class="row pl-3">
      <div class="col-12">
        <label class="required">Select Primary Rep:</label>
        <drop-down
          :options="repList"
          placeholder="Search Rep"
          v-model="primaryRep"
          v-validate="'required'"
          name="primary sales person"
        />
        <label class="error">{{ errors.first('primary sales person') }}</label>
      </div>
    </div>
  </div>
</template>

<script>
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: "PrimaryRep",
  components: {
    DropDown
  },
  props: {
    repList: {
      type: Array,
      required: true
    }
  },
  data: () => ({
    primaryRep: null
  }),
  watch: {
    primaryRep: {
      handler(value) {
        this.$emit("primaryRep", this.primaryRep);
      }
    }
  }
};
</script>

