<template>
  <div class="ag-menu-container" :class="{ 'ag-menu--disabled': disabled }" @click="toggle">
    <slot name="base"></slot>
    <transition-group tag="div"
                      name="list-down"
                      class="ag-menu"
                      :class="[
                        { 'ag-menu--shown': showList },
                        isRight ? 'ag-menu--right' : 'ag-menu--left',
                      ]"
                      ref="fmMenu">
      <template v-if="showList">
        <form key="form" class="ui form ag-menu__form" @submit.prevent v-if="searchable">
          <input type="text"
                 placeholder="Search ..."
                 ref="search"
                 class="ui input"
                 @input="search"
                 @click.stop
                 autofocus>
          <button type="submit" class="ag-menu__form-button" @click.stop>
            <ag-icon icon="search" class="ag-icon--semi-light-grey"></ag-icon>
          </button>
        </form>
        <div key="items" class="ag-menu__item ag-scroll">
          <slot name="item"></slot>
        </div>
      </template>
    </transition-group>
    <div class="ag-menu--fixed" v-if="showList" @click.stop="toggle" v-click-outside="hide"></div>
  </div>
</template>
<script>
  import FmIcon from './functional/FmIcon';
  import VClickOutside from 'v-click-outside';

  export default {
    name: 'fm-menu',
    props: {
      searchable: {
        type: Boolean,
      },
      fixed: {
        type: Boolean,
      },
      disabled: {
        type: Boolean,
      },
      isRight: {
        type: Boolean,
      },
    },
    components: {
      FmIcon,
    },
    directives: {
      ClickOutside: VClickOutside.directive,
    },
    data() {
      return {
        showList: false,
        debounceTime: 500,
      };
    },
    watch: {
      showList(newValue) {
        this.$nextTick(() => {
          if (newValue && this.$refs.search) {
            this.$refs.search.focus();
          }
        });
      },
      fixed(isFixed) {
        if (isFixed) {
          this.setFixed();
        } else {
          this.resetFixed();
        }
      },
    },
    beforeDestroy() {
      this.resetFixed();
    },
    methods: {
      changeVisibility(visible) {
        if (visible) {
          this.show();
        } else {
          this.hide();
        }
      },
      toggle() {
        if (!this.disabled) {
          this.changeVisibility(!this.showList);
        }
      },
      show() {
        if (this.fixed) {
          this.setFixed();
        }
        this.showList = true;
        this.$emit('shown');
      },
      hide() {
        this.showList = false;
        this.$emit('hidden');
      },
      search(e) {
        this.$emit('search', e.target.value);
      },
      setFixed() {
        this.$nextTick(() => {
          const elBounds = this.$el.getBoundingClientRect();
          if (elBounds.x) {
            const menuEl = this.$refs.fmMenu.$el;
            if (menuEl) {
              menuEl.style.position = 'fixed';
              menuEl.style.top = `${elBounds.y + 20}px`;
              menuEl.style.right = `calc(100% - ${elBounds.x}px)`;
            }
          }
        });
      },
      resetFixed() {
        const menuEl = this.$refs.fmMenu.$el;
        if (menuEl) {
          menuEl.removeAttribute('style');
        }
      },
    },
  };
</script>
