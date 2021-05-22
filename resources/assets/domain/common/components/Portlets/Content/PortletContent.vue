<template>
  <div class="portlet">
    <div class="m-portlet" :style="getStyle">
      <div class="m-portlet__head" v-if="!onlybody">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              {{ header }}
              <small>{{ subheader }}</small>
            </h3>
          </div>
        </div>
        <div class="m-portlet__head-tools">
          <ul class="m-portlet__nav">
            <li class="m-portlet__nav-item">
              <div class="m--align-right m--align-push">
                <slot name="action_button"></slot>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="m-portlet__body" :class="{'forform': isform }">
        <slot name="body"></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PortletContent",
  props: {
    header: {
      type: String,
      required: false
    },
    subheader: {
      type: String,
      required: false
    },
    isform: {
      type: String
    },
    onlybody: {
      type: Boolean,
      default: false
    },
    height: {
      type: Number,
      default: 0
    }
  },
  computed: {
    getStyle() {
      return this.height > 0 ? `height: ${this.height}px;` : "";
    }
  }
};
</script>

<style scoped>
.forform {
  padding: inherit !important;
}
</style>
