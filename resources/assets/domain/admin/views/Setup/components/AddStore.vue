<template>
  <modal title="Add Store" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group row">
        <div class="col-10">
          <div class="row">
            <label class="col-5 text-right pr-3">Store Name:</label>
            <input 
              type="text" 
              class="col-7 form-control" 
              v-model="model.name" 
              v-validate="'required'" 
              name="name"
            />
            <label class="error">{{ errors.first('name') }}</label>
          </div>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="handleSave"
      >Add</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import Form from "../../../../common/utitlities/Form";
import { LoadingMixin } from '../../../../common/mixins/index'

export default {
  name: "AddStore",
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
          this.saveStore();
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    saveStore() {
      this.enableLoading();
      axios.post('/api/sites', this.model)
        .then(data => {
          this.$toastr(
            "success",
            `Successfully created Store`,
            "Success!!"
          );
          this.$emit("saved");
          this.handleClose();
        })
        .catch(error => {
          this.$toastr("error", `Error in creating Store`, "Error!!");
        })
        .finally(this.disableLoading);
    }
  }
};
</script>
