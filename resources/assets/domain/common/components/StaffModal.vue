<template>
  <modal title="Select Sales Rep" @close="handleClose">
    <template slot="modal-body">
      <div class="row">
        <label class="col-4 text-right">Select Sales Person</label>
        <div class="col-7">
          <drop-down
            ref="salesPersonSelect"
            placeholder="Search Sales Person"
            v-model="model.sales_id"
            :options="salesStaffs"
            :default-selected="selectedStaff"
            v-validate="'required'"
            name="sales person"
          />
          <label class="error">{{ errors.first('sales person') }}</label>
        </div>
      </div>
      <div class="row pt-3">
        <label class="col-4 text-right">Priority</label>
        <div class="col-7">
          <drop-down
            ref="priority"
            placeholder="Select Priority"
            v-model="model.priority"
            :options="$options.PRIORITY"
            :default-selected="selectedPriority"
            v-validate="'required'"
            name="priority"
          />
          <label class="error">{{ errors.first('priority') }}</label>
        </div>
      </div>
      <div class="row pt-3">
        <label class="col-4 text-right">Split %</label>
        <div class="col-7">
          <input type="number" name="split%" v-validate="'required|decimal:2'" v-model="model.commission" />
          <label class="error">{{ errors.first('split%') }}</label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="saveButtonHandler">{{ this.isEdit ? 'Update' : 'Add' }} Sales Rep</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "./Modal/Modal";
import DropDown from "./DropDown/DropDown";

const PRIORITY = [
  { id: "primary", name: "Primary" },
  { id: "secondary", name: "Secondary" }
];

export default {
  name: "StaffModal",
  components: {
    DropDown,
    Modal
  },
  props: {
    storeId: {
      type: Number,
      default: 0
    },
    staff: {
      type: Object,
      default: () => ({}),
    },
  },
  PRIORITY,
  data: () => ({
    model: {
      sales_id: "",
      priority: "",
      commission: ""
    },
    salesStaffs: [],
    sites: [],
    store_id: "",
    selectedStaff: {},
    selectedPriority: {},
  }),
  computed: {
    isEdit() {
      return !!this.selectedStaff.id;
    },
  },
  watch: {
    store_id: {
      handler(id) {
        this.fetchSalesStaff(id);
      }
    }
  },
  created() {
    if (this.storeId) {
      this.fetchSalesStaff(this.storeId)
        .then(() => {
          if (Object.keys(this.staff).length) {
            this.selectedStaff = this.salesStaffs.find(salesStaff => salesStaff.id === this.staff.sales_id);
            this.selectedPriority = PRIORITY.find(priority => priority.id === this.staff.priority);
            this.model.commission = this.staff.commission;
          }
        });       
    }
  },
  methods: {
    fetchSalesStaff(id) {
      return axios
        .get(`/api/sites/${id}/sales_staff`)
        .then(({ data }) => {
          this.salesStaffs = data.data;
        })
        .catch(err => console.log(err));
    },
    fetchSites() {
      axios
        .get("/api/sites")
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(err => console.log(err));
    },
    saveButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          if (Object.keys(this.staff).length) {
            this.$emit("updated", { selectedSale: { ...this.model }, index: this.staff.index });
          } else {
            this.$emit("saved", { ...this.model });
          }
          this.handleClose();
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>
