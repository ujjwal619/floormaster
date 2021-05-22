<template>
  <modal :title="getTitle" :backdrop-close="false" @close="handleClose">
    <loading :loading="loading" />
    <div slot="modal-body" class="px-2">
      
      <div class="row">
        <label class="col-3 text-right">Supplier:</label>
        <label class="col-8 ml-2">{{ supplier.trading_name }}</label>
      </div>
      <div class="row pt-1">
        <label class="col-3 text-right">Range:</label>
        <label class="col-8 ml-2">{{ product.name }}</label>
      </div>
      <div class="row pt-1">
        <label class="col-3 text-right">Alias:</label>
        <label class="col-8 ml-2">{{ product.alias }}</label>
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Enter Color:</label>
        <input 
            type="text" 
            class="col-8 form-control ml-2" 
            v-model="model.name" 
            name="color" 
            v-validate="`excluded:${variantNames}`"
          />
          <label class="col-10 text-right error">{{ errors.first('color') }}</label>
          <label v-show="isColorEmpty" class="col-10 text-right error">The Color Field is Required.</label>
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Re-Order @:</label>
        <input 
            type="number" 
            class="col-8 form-control ml-2" 
            v-model="model.reorder" 
          />
      </div>
      <div class="row pt-3" v-show="!isEdit">
        <label class="col-3 text-right">Colors of this Range:</label>
        <ul class="col-8 ml-2">
          <li v-for="color in updatedColors" :key="color.id">{{ color.name }}</li>
        </ul>
      </div>
    </div>
    <template slot="modal-footer">
      <template v-if="!isEdit">
        <button type="button" class="btn action-buttons" @click="saveColor">Save Color</button>
        <button type="button" class="btn action-buttons" @click="handleFinished">Finished</button>
      </template>
      <template v-else>
        <button type="button" class="btn action-buttons mr-3" @click="removeColor" >Remove</button>
        <button type="button" class="btn action-buttons" @click="updateColor">Finished ></button>
        <button type="button" class="btn action-buttons" @click="handleClose">cancel</button>
      </template>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import { LoadingMixin } from '../../../../common/mixins'
import {
  getColorsByProduct,
} from "../../../api/calls";

export default {
  name: "AddColor",
  mixins: [LoadingMixin],
  components: {
    Modal
  },
  props: {
    colors: {
      type: Array,
      default: [],
    },
    selectedColor: {
      type: Object,
      default: () => ({}),
    },
    product: {
      type: Object,
      required: true,
    },
    supplier: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    model: {},
    modelCache: {},
    updatedColors: [],
    isColorEmpty: false,
  }),
  computed: {
    isEdit() {
      return !!this.selectedColor.name;
    },
    getTitle() {
      return this.isEdit ? 'Edit Color' : 'Add Colors to Range';
    },
    variantNames() {
      const colors = [...this.updatedColors];
      if (this.isEdit) {
        const colorIndex = colors.findIndex(color => color.name === this.modelCache.name);
        colors.splice(colorIndex, 1);
      }
      return colors.map(color => color.name);
    },
  },
  created() {
    this.updatedColors = [...this.colors];
    this.model = { ...this.selectedColor };
    this.modelCache = { ...this.selectedColor };
  },
  methods: {
    removeColor() {
      let confirmation = confirm('Are you sure you want to delete?');
      if (confirmation) {
        const colorIndex = this.updatedColors.findIndex(color => color.name === this.modelCache.name);
        this.updatedColors.splice(colorIndex, 1);
        this.handleFinished();
      }
    },
    fetchColors() {
      this.enableLoading();
      getColorsByProduct(this.product.id)
        .then(({ data }) => {
          // this.colors = data.data;
        })
        .catch(() => {
          console.log('could not fetch colors');
        })
        .finally(this.disableLoading);
    },
    validate() {
      console.log('validation called');
      return this.$validator.validate();
    },
    saveColor() {
      this.validate()
        .then(valid => {
          if (valid) {
            if (!this.model.name) {
              return this.isColorEmpty = true;
            }
            this.model.site_id = this.product.site_id || this.supplier.site_id;
            this.updatedColors.push({ ...this.model });
            this.model = {};
            this.isColorEmpty = false;
          }
        });
    },
    updateColor() {
      this.validate()
        .then(valid => {
          if (valid) {
            this.updatedColors.map(color => {
              if (color.name === this.modelCache.name) {
                color.name = this.model.name;
                color.reorder = this.model.reorder;
              }
            })
            this.handleFinished();
          }
        })
    },
    handleClose() {
      this.$emit("close");
    },
    handleFinished() {
      this.$emit('finished', this.updatedColors);
      this.handleClose();
    },
  }
};
</script>
