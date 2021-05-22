<template>
  <modal title="New Contractor" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="col-12">
        <div class="row">
          <label class="col-lg-4 text-right">Store:</label>
          <div class="col-7">
            <drop-down
              :options="sites"
              v-model="site_id"
              style="max-height: 40px;"
              name="store"
              v-validate="'required'"
            />
            <label class="error">{{ errors.first('store') }}</label>
          </div>
        </div>
        <div class="row pt-3">
          <label class="col-4 text-right">Enter Tax File Number:</label>
          <div class="col-7">
            <input class="form-control" type="text" v-model="tfn" name="TFN" v-validate="'required'">
            <label class="error">{{ errors.first('TFN') }}</label>
          </div>
        </div>
        <div class="row pt-4">
          <div class="col-lg-2">&nbsp;</div>
          <span class="h6 my-auto">
            New Contractors MUST have a Tax File Number.
            <br>Make sure that the TFN is correct.
            <br>You will not be able to change it later.
          </span>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleSave">OK</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from '../../../../common/components/DropDown/DropDown';
import { getSites } from '../../../api/calls';
import { LoadingMixin } from '../../../../common/mixins'
import axios from "axios";

export default {
  name: "NewContractor",
  mixins: [LoadingMixin],
  components: {
    Modal,
    DropDown
  },
  data: () => ({
    tfn: "",
    site_id: "",
    sites: [],
  }),
  created() {
    this.fetchSites();
    this.tfn = "";
  },
  methods: {
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .finally(() => this.disableLoading());
    },
    handleClose() {
      this.$emit("close", true);
    },
    emit(event) {
      this.$emit(event);
      this.$emit("close");
    },
    handleSave() {
      this.$validator.validateAll()
        .then((valid) => {
          if (valid) {
            this.saveTFN();
          }
        });
    },
    saveTFN() {
      this.enableLoading();
      axios
        .post(`/contractors`, { tfn: this.tfn, site_id: this.site_id })
        .then(() => {
          this.$toastr(
            "success",
            "Successfully saved the tax file number",
            "Success!!"
          );
          window.location.href = "/contractors";
        })
        .catch(() => {
          this.$toastr("error", "Could not save tax file number", "Error!!");
        })
        .finally(() => this.disableLoading());
    }
  }
};
</script>

