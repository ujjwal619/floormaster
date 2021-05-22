<template>
  <modal title="Search Terms" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group m-form__group">
        <div class="col-12">
          <label class="required">Search Term:</label>
          <drop-down :options="terms" placeholder="Search Term" v-model="termId" name="term" v-validate="'required'" />
          <label class="error">{{ errors.first('term') }}</label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="handleSelect"
      >OK</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: "SearchTerms",
  components: {
    Modal,
    DropDown
  },
  data: () => ({
    termId: "",
    terms: []
  }),
  created() {
    axios.get("/api/terms").then(({ data }) => {
      this.terms = data.data || [];
    });
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    handleSelect() {
      this.$validator.validateAll
        .then(valid => {
          if (valid) {
            this.$emit("search-and-close", { id: this.termId });
          }
        });
    }
  }
};
</script>
