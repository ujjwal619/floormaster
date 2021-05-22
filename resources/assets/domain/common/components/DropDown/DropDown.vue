<template>
  <multi-select
    ref="multiselect"
    v-model="selected"
    :options="options"
    :label="label"
    :placeholder="placeholder"
    :allow-empty="allowEmpty"
    :show-labels="false"
    track-by="id"
    @input="handleSelected"
    :disabled="disabled"
    :multiple="multiple"
    :close-on-select="closeOnSelect"
  >
    <template slot="singleLabel" slot-scope="props">
      <slot name="singleLabel" :data="props.option">{{ getOptionLabel(props.option) }}</slot>
    </template>
    <template v-if="!showMultipleLabel" slot="selection" slot-scope="{ values, isOpen }">
      <slot name="selection" :data="{values, isOpen}">
        <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span>
      </slot>
    </template>
    <template slot="option" slot-scope="props">
      <slot name="option" :data="props.option">{{ getOptionLabel(props.option) }}</slot>
    </template>
  </multi-select>
</template>

<script>
import MultiSelect from "vue-multiselect";
import { isObject } from "../../../common/utitlities/helpers";

export default {
  name: "DropDown",
  components: { MultiSelect },
  props: {
    options: { required: true, type: Array },
    placeholder: {
      required: false,
      type: String,
      default: "Select One"
    },
    disabled: {
      type: Boolean
    },
    label: {
      type: String,
      default: "name"
    },
    multiple: {
      type: Boolean,
      default: false
    },
    closeOnSelect: {
      type: Boolean,
      default: true
    },
    defaultSelected: {
      type: [Array, Object, String, Number],
      required: false
    },
    allowEmpty: {
      type: Boolean,
      default: false
    },
    returnObject: {
      type: Boolean,  
    },
    showMultipleLabel: {
      type: Boolean,
      default: true, 
    }
  },  
  data() {
    return {
      selected: null,
      preselectedValue: {}
    };
  },
  watch: {
    defaultSelected: {
      immediate: true,
      handler(selected) {
        if (selected) {
          this.selected = selected;
          this.emitInput(selected.id);
        }
      }
    }
  },
  methods: {
    handleSelected() {
      if (this.selected) {
        if (this.multiple) {
          this.emitInput(this.selected.map(selected => this.returnObject ? selected : selected.id));
        } else {
          this.emitInput(this.returnObject ? this.selected : this.selected.id);
        }
      }
    },
    emitInput(data) {
      this.$emit("input", data);
    },
    reset() {
      this.selected = null;
      this.selected = this.defaultSelected;
    },
    getOptionLabel(option) {
      if (isObject(option)) {
        return option[this.label];
      }
      return option;
    }
  }
};
</script>
