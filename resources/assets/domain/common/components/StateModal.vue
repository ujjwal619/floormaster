<template>
  <modal title="Valid Australian States" @close="handleClose">
    <template slot="modal-body">
      <loading :loading="loading" />
      <div class="row form-container">
        <label class="col-12">
          To Ensure correct automatic Australian Post Code retieval please ensure 
          that your state or territory input conforms to these listed abbreviations.
        </label>
        <div class="col-12">
          <label class="required">States:</label>
          <drop-down 
            :options="states" 
            placeholder="Select States" 
            v-model="state" 
            :return-object="true" 
            name="state" 
            v-validate="'required'"
          />
          <label class="error">{{ errors.first('state') }}</label>
        </div>
        <div class="col-12 pt-3">
          <label class="required">Suburb:</label>
          <drop-down 
            ref="searchSuburb"
            :options="suburbs" 
            placeholder="Select Suburb" 
            v-model="suburb" 
            :return-object="true" 
            name="suburb" 
            label="suburb"
            v-validate="'required'"
          />
          <label class="error">{{ errors.first('suburb') }}</label>
        </div>
        <div class="col-12 pt-3">
          <label class="required">Code:</label>
          <drop-down 
            ref="searchCode"
            :options="codes" 
            placeholder="Select Code" 
            v-model="code" 
            :return-object="true" 
            name="code" 
            label="postcode"
            v-validate="'required'"
          >
            <template slot="singleLabel" slot-scope="{ data }">{{ data.postcode + ', type: ' + data.type + ', dc: ' + (data.dc || '')  }}</template>
            <template slot="option" slot-scope="{ data }"><span>{{ data.postcode + ', type: ' + data.type + ', dc: ' + (data.dc || '') }}</span></template>
          </drop-down>
          <label class="error">{{ errors.first('code') }}</label>
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
import Modal from "./Modal/Modal";
import { LoadingMixin } from "../../common/mixins";
import DropDown from "./DropDown/DropDown";
import { getStates, getAustralianPostcodes } from '../../admin/api/calls'

export default {
  name: "States",
  mixins: [LoadingMixin],
  components: {
    Modal,
    DropDown
  },
  data: () => ({
    states: [],
    suburbs: [],
    codes: [],
    state: {},
    suburb: {},
    code: {},
  }),
  created() {
    this.fetchStates();
  },
  watch: {
    state(value) {
      if (value && value.name) {
        this.suburb = {};
        this.code = {};
        this.$refs.searchSuburb.reset();
        this.$refs.searchCode.reset();
        this.fetchSuburbsByState(value.name);
      }
    },
    suburb(value) {
      if (value && value.suburb) {
        this.code = {};
        this.$refs.searchCode.reset();
        this.fetchCodeBySuburbAndState(value.suburb, this.state.name);
      }
    },
  },
  methods: {
    fetchSuburbsByState(state) {
      this.enableLoading();
      getAustralianPostcodes({'for': 'suburb', 'state': state})
        .then(({ data }) => {
          this.suburbs = data.data
        })
        .catch(() => {
          this.$toastr("error", 'Error in fetching suburbs', "Error!!");
        })
        .finally(this.disableLoading);
    },
    fetchCodeBySuburbAndState(suburb, state) {
      this.enableLoading();
      getAustralianPostcodes({'for': 'code', 'state': state, 'suburb': suburb})
        .then(({ data }) => {
          this.codes = data.data
        })
        .catch(() => {
          this.$toastr("error", 'Error in fetching codes', "Error!!");
        })
        .finally(this.disableLoading);
    },
    fetchStates() {
      getStates()
        .then(({ data }) => {
          this.states = data.data
        })
        .catch(() => {
          this.$toastr("error", 'Error in fetching states', "Error!!");
        })
    },
    handleClose() {
      this.$emit("close");
    },
    handleSelect() {
      this.$validator.validateAll().then(valid => {
        if (valid) {
          this.$emit("state", {
            'state': this.state.name,
            'suburb': this.suburb.suburb,
            'code': this.code.postcode  
          });
          this.handleClose();
        }
      });
    }
  }
};
</script>
