<template>
  <modal title="Job Terms" @close="handleClose">
    <template slot="modal-body">
        <div class="row">
          <label class="required">Select Terms:</label>
          <drop-down 
            :options="terms" 
            placeholder="Select Term" 
            v-model="term" 
            name="term" 
            :default-selected="selectedTerm"
            v-validate="'required'" 
          />
          <label class="error">{{ errors.first('term') }}</label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="handleSelect"
      >Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "./Modal/Modal";
import DropDown from "./DropDown/DropDown";
import { getTermsBySite } from '../../admin/api/calls'

export default {
  name: "Terms",
  props: {
    siteId: {
      type: Number,
      required: true,
    },
    termId: {
      type: Number,
      default: NaN,
    },
  },
  components: {
    Modal,
    DropDown
  },
  data: () => ({
    terms: [],
    term: NaN,
    selectedTerm: {},
  }),
  created() {
    this.fetchTerms()
      .then(() => {
        if (this.termId) {
          this.selectedTerm = this.terms.find(term => term.id === this.termId);
        }
      });
  },
  methods: {
    fetchTerms() {
      return getTermsBySite(this.siteId)
        .then(({ data }) => {
          this.terms = data.data
        })
        .catch(() => {
          this.$toastr("error", 'Error in fetching terms', "Error!!");
        })
    },
    handleClose() {
      this.$emit("close");
    },
    handleSelect() {
      this.$validator.validateAll().then(valid => {
        if (valid) {
          this.$emit("term", { ...this.terms.find(term => term.id === this.term) });
          this.handleClose();
        }
      });
    }
  }
};
</script>
