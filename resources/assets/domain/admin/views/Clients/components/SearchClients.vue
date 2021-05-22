<template>
  <modal title="Search Client" @close="handleClose">
    <template slot="modal-body">
      <div class="row">
        <label class="required">Store:</label>
        <drop-down
          :options="sites"
          placeholder="Select Store"
          v-model="storeId"
        />
      </div>
      <div class="row pt-2">
        <label class="required">Select Client:</label>
        <drop-down
          :options="clients"
          placeholder="Select Client"
          v-model="clientId"
          v-validate="'required'"
          name="client"
          label="trading_name"
        />
        <label class="error">{{ errors.first('client') }}</label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleSelect">OK</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: "SearchClient",
  components: {
    Modal,
    DropDown
  },
  props: {
    sites: {
      type: Array,
      reqired: true
    }
  },
  data: () => ({
    storeId: null,
    clientId: null,
    clients: []
  }),
  watch: {
    storeId(value) {
      if (value) {
        axios
          .get(`/api/sites/${value}/clients`)
          .then(({ data }) => (this.clients = data.data))
          .catch(error => {
            this.$toastr("error", "Could not fetch Client Data", "Error!!");
          });
      }
    }
  },
  computed: {
    stopUserSelect() {
      return !this.userId;
    }
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    handleSelect() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', this.clientId);
        }
      });
    },
    validate() {
      return this.$validator.validate();
    }
  }
};
</script>
