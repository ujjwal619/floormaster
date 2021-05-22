<template>
  <modal :title="title" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group row">
        <div class="col-10">
          <div class="row">
            <label class="col-5 text-right pr-3">Shop Name:</label>
            <input 
              type="text" 
              class="col-7 form-control" 
              v-model="model.name" 
              v-validate="'required'" 
              name="name"
            />
            <label class="error">{{ errors.first('name') }}</label>
          </div>
          <div class="row pt-3">
            <label class="col-5 text-right pr-3">GL Suffix:</label>
            <input type="text" class="col-7 form-control" v-model="model.gl_suffix" />
          </div>
          <div class="row pt-3">
            <label class="col-5 text-right pr-3">Letterhead Path:</label>
            <input type="text" class="col-7 form-control" v-model="model.letterhead_path" />
          </div>
          <!-- <div class="row pt-3">
            <label class="col-5 text-right pr-3">Street:</label>
            <input v-model="model.address.street" class="col-7 form-control" type="text" />
          </div>
          <div class="row pt-3">
            <label class="col-5 text-right pr-3">Town:</label>
            <input v-model="model.address.town" class="col-7 form-control" type="text" />
          </div>
          <div class="row pt-3">
            <label class="col-5 text-right pr-3">State/Code:</label>
            <input v-model="model.address.state" class="col-3 form-control" type="text" />
            <input v-model="model.address.code" class="col-3 form-control" type="number" />
          </div> -->
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="handleSave"
      >{{ title }}</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import Form from "../../../../common/utitlities/Form";
import { LoadingMixin } from '../../../../common/mixins/index'

export default {
  name: "AddShop",
  mixins: [LoadingMixin],
  components: {
    Modal
  },
  props: {
    shopData: {
      type: Object,
      default: () => ({})
    },
    siteId: {
      type: Number,
      required: true,
    }
  },
  data: () => ({
    model: {
      name: "",
      gl_suffix: "",
      letterhead_path: "",
      address: {
        street: "",
        town: "",
        state: "",
        code: null
      }
    },
    form: new Form()
  }),
  computed: {
    stopSiteSave() {
      return !this.model.name;
    },
    isEdit() {
      return !!Object.keys(this.shopData).length;
    },
    title() {
      return this.isEdit ? 'Update Shop' : 'Add Shop' ;
    },
  },
  mounted() {
    if (this.isEdit) {
      this.model = this.shopData;
      this.model.address = this.shopData.address || {};
    }
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    handleSave() {
      this.validate().then(valid => {
        if (valid) {
          this.saveShop();
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    saveShop() {
      const method = this.shopData.id ? "put" : "post";
      const url = this.shopData.id ? `/api/shops/${this.shopData.id}` : `/api/sites/${this.siteId}/shops`;
      const message = this.shopData.id ? "edit" : "create";

      this.enableLoading();
      axios[method](url, this.model)
        .then(data => {
          this.$toastr(
            "success",
            `Successfully ${message}ed Shop`,
            "Success!!"
          );
          this.$emit("saved");
          this.handleClose();
        })
        .catch(error => {
          this.$toastr("error", `Error in ${message}ing Shop`, "Error!!");
        })
        .finally(this.disableLoading);
    }
  }
};
</script>
