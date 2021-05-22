<template>
  <modal title="Loan Sample" @close="handleClose" :is-large="true">
    <template slot="modal-body">
      <div class="row">
        <label class="text-right col-2">Loan To:</label>
        <label>Client SN: 388</label>
      </div>
      <div class="row">
        <label class="text-right col-2">Surname:</label>
        <label>Absolute Strata Management</label>
      </div>
      <div class="row pt-4">
        <div class="col-6 row">
          <label class="text-right col-4">Add Sample:</label>
          <drop-down
            :options="[]"
            v-model="model.sample"
            :multiple="true"
            :allow-empty="true"
            :close-on-select="false"
          />
        </div>
        <div class="col-6 row px-4">
          <fieldset>
            <legend>How long is this loan for?</legend>
            <label class="col-12">
              <input type="radio" v-model="model.duration" :value="1" />
              <span class="pl-1">Return Today</span>
            </label>
            <label class="col-12">
              <input type="radio" v-model="model.duration" :value="2" />
              <span class="pl-1">Return Tomorrow</span>
            </label>
            <label class="col-12">
              <input type="radio" v-model="model.duration" :value="3" />
              <span class="pl-1">Return Day After Tomorrow</span>
            </label>
            <div class="col-12">
              <label>
                <input type="radio" v-model="model.duration" :value="4" />
                <span class="pl-1">Specific Date</span>
              </label>
              <input type="date" v-model="model.duration_date" :disabled="!canEnterDate" />
            </div>
          </fieldset>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleSave">Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import Form from "../../../../common/utitlities/Form";
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: "SampleLoan",
  components: {
    Modal,
    DropDown
  },
  data: () => ({
    model: {
      sample: [],
      duration: null,
      dutation_date: ""
    }
  }),
  computed: {
    canEnterDate() {
      return this.model.duration === 4;
    }
  },
  watch: {
    "model.duration": {
      handler(value) {
        if (value !== 4) {
          this.model.duration_date = "";
        }
      }
    }
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    handleSave() {}
  }
};
</script>

<style scoped>
fieldset {
  min-width: auto;
  padding: 5px 15px;
  margin: auto;
  width: 100%;
  border: 2px solid rgb(192, 192, 192);
}

legend {
  width: auto;
  padding: unset;
  margin: unset;
  font-size: unset;
}
</style>
