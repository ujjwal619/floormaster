<template>
  <modal title="Add Job Source" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="form-group row">
        <div class="col-md-5">
          <label class="required">Title</label>
          <input 
            type="text" 
            v-model="model.title" 
            name="title" 
            v-validate="'required'"
            autocomplete="off"
          />
          <label class="error">{{ errors.first('title') }}</label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleSave">Add Job Source</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import { LoadingMixin } from '../../../../common/mixins'

export default {
  name: "AddJobSource",
  mixins: [LoadingMixin],
  components: {
    Modal
  },
  props: {
    site: {
      type: Number,
      required: true
    },
    jobSource: {
      type: Object,
      default: () => ({})
    }
  },
  data: () => ({
    model: {
      title: "",
      name: ""
    }
  }),
  watch: {
    jobSource: {
      immediate: true,
      handler(sourceData) {
        this.model = { ...sourceData };
      }
    }
  },
  computed: {
    stopJobSave() {
      return !(this.model.title && this.model.name);
    }
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    validate() {
      return this.$validator.validate();
    },
    handleSave() {
      this.validate().then(valid => {
        if (valid) {
          this.saveJobSource();
        }
      });
    },
    saveJobSource() {
      const method = this.jobSource.id ? "put" : "post";
      const url = this.jobSource.id
        ? `api/sources/${this.jobSource.id}`
        : `api/sites/${this.site}/sources`;

      const message = this.jobSource.id ? "edit" : "add";

      this.enableLoading();
      axios[method](url, { ...this.model })
        .then(data => {
          this.$toastr(
            "success",
            `Successfully ${message}ed Job Source`,
            "Success!!"
          );
          this.$emit("saved");
          this.handleClose();
        })
        .catch(error => {
          this.$toastr("error", `Error in ${message}ing Job Source`, "Error!!");
        })
        .finally(this.disableLoading);
    }
  }
};
</script>
