webpackJsonp([5,6],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/FmMenu.vue":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _FmIcon = __webpack_require__("./resources/assets/domain/common/components/functional/FmIcon.js");

var _FmIcon2 = _interopRequireDefault(_FmIcon);

var _vClickOutside = __webpack_require__("./node_modules/v-click-outside/dist/v-click-outside.umd.js");

var _vClickOutside2 = _interopRequireDefault(_vClickOutside);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

exports.default = {
  name: 'fm-menu',
  props: {
    searchable: {
      type: Boolean
    },
    fixed: {
      type: Boolean
    },
    disabled: {
      type: Boolean
    },
    isRight: {
      type: Boolean
    }
  },
  components: {
    FmIcon: _FmIcon2.default
  },
  directives: {
    ClickOutside: _vClickOutside2.default.directive
  },
  data: function data() {
    return {
      showList: false,
      debounceTime: 500
    };
  },

  watch: {
    showList: function showList(newValue) {
      var _this = this;

      this.$nextTick(function () {
        if (newValue && _this.$refs.search) {
          _this.$refs.search.focus();
        }
      });
    },
    fixed: function fixed(isFixed) {
      if (isFixed) {
        this.setFixed();
      } else {
        this.resetFixed();
      }
    }
  },
  beforeDestroy: function beforeDestroy() {
    this.resetFixed();
  },

  methods: {
    changeVisibility: function changeVisibility(visible) {
      if (visible) {
        this.show();
      } else {
        this.hide();
      }
    },
    toggle: function toggle() {
      if (!this.disabled) {
        this.changeVisibility(!this.showList);
      }
    },
    show: function show() {
      if (this.fixed) {
        this.setFixed();
      }
      this.showList = true;
      this.$emit('shown');
    },
    hide: function hide() {
      this.showList = false;
      this.$emit('hidden');
    },
    search: function search(e) {
      this.$emit('search', e.target.value);
    },
    setFixed: function setFixed() {
      var _this2 = this;

      this.$nextTick(function () {
        var elBounds = _this2.$el.getBoundingClientRect();
        if (elBounds.x) {
          var menuEl = _this2.$refs.fmMenu.$el;
          if (menuEl) {
            menuEl.style.position = 'fixed';
            menuEl.style.top = elBounds.y + 20 + 'px';
            menuEl.style.right = 'calc(100% - ' + elBounds.x + 'px)';
          }
        }
      });
    },
    resetFixed: function resetFixed() {
      var menuEl = this.$refs.fmMenu.$el;
      if (menuEl) {
        menuEl.removeAttribute('style');
      }
    }
  }
};

/***/ }),

/***/ "./node_modules/v-click-outside/dist/v-click-outside.umd.js":
/***/ (function(module, exports, __webpack_require__) {

!function(e,n){ true?module.exports=n():"function"==typeof define&&define.amd?define(n):e["v-click-outside"]=n()}(this,function(){var e="__v-click-outside",n="undefined"!=typeof window,t="undefined"!=typeof navigator,i=n&&("ontouchstart"in window||t&&navigator.msMaxTouchPoints>0)?["touchstart"]:["click"];function o(n,t){var o=function(e){var n="function"==typeof e;if(!n&&"object"!=typeof e)throw new Error("v-click-outside: Binding value must be a function or an object");return{handler:n?e:e.handler,middleware:e.middleware||function(e){return e},events:e.events||i,isActive:!(!1===e.isActive)}}(t.value),r=o.handler,d=o.middleware;o.isActive&&(n[e]=o.events.map(function(e){return{event:e,handler:function(e){return function(e){var n=e.el,t=e.event,i=e.handler,o=e.middleware;t.target!==n&&!n.contains(t.target)&&o(t)&&i(t)}({event:e,el:n,handler:r,middleware:d})}}}),n[e].forEach(function(t){var i=t.event,o=t.handler;return setTimeout(function(){n[e]&&document.documentElement.addEventListener(i,o,!1)},0)}))}function r(n){(n[e]||[]).forEach(function(e){return document.documentElement.removeEventListener(e.event,e.handler,!1)}),delete n[e]}var d={bind:o,update:function(e,n){var t=n.value,i=n.oldValue;JSON.stringify(t)!==JSON.stringify(i)&&(r(e),o(e,{value:t}))},unbind:r};return{install:function(e){e.directive("click-outside",d)},directive:d}});
//# sourceMappingURL=v-click-outside.umd.js.map


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-47afd1f2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/FmMenu.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "ag-menu-container",
      class: { "ag-menu--disabled": _vm.disabled },
      on: { click: _vm.toggle }
    },
    [
      _vm._t("base"),
      _vm._v(" "),
      _c(
        "transition-group",
        {
          ref: "fmMenu",
          staticClass: "ag-menu",
          class: [
            { "ag-menu--shown": _vm.showList },
            _vm.isRight ? "ag-menu--right" : "ag-menu--left"
          ],
          attrs: { tag: "div", name: "list-down" }
        },
        [
          _vm.showList
            ? [
                _vm.searchable
                  ? _c(
                      "form",
                      {
                        key: "form",
                        staticClass: "ui form ag-menu__form",
                        on: {
                          submit: function($event) {
                            $event.preventDefault()
                          }
                        }
                      },
                      [
                        _c("input", {
                          ref: "search",
                          staticClass: "ui input",
                          attrs: {
                            type: "text",
                            placeholder: "Search ...",
                            autofocus: ""
                          },
                          on: {
                            input: _vm.search,
                            click: function($event) {
                              $event.stopPropagation()
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "ag-menu__form-button",
                            attrs: { type: "submit" },
                            on: {
                              click: function($event) {
                                $event.stopPropagation()
                              }
                            }
                          },
                          [
                            _c("ag-icon", {
                              staticClass: "ag-icon--semi-light-grey",
                              attrs: { icon: "search" }
                            })
                          ],
                          1
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "div",
                  { key: "items", staticClass: "ag-menu__item ag-scroll" },
                  [_vm._t("item")],
                  2
                )
              ]
            : _vm._e()
        ],
        2
      ),
      _vm._v(" "),
      _vm.showList
        ? _c("div", {
            directives: [
              {
                name: "click-outside",
                rawName: "v-click-outside",
                value: _vm.hide,
                expression: "hide"
              }
            ],
            staticClass: "ag-menu--fixed",
            on: {
              click: function($event) {
                $event.stopPropagation()
                return _vm.toggle($event)
              }
            }
          })
        : _vm._e()
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-47afd1f2", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/domain/common/components/FmMenu.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/FmMenu.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-47afd1f2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/FmMenu.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/domain/common/components/FmMenu.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-47afd1f2", Component.options)
  } else {
    hotAPI.reload("data-v-47afd1f2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/domain/common/components/functional/FmIcon.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  name: 'fm-icon',
  functional: true,
  props: {
    icon: {
      type: String,
      required: true
    }
  },
  render: function render(createElement, context) {
    return createElement('svg', {
      class: ['ag-icon', context.data.staticClass],
      attrs: {
        'aria-hidden': true
      }
    }, [createElement('use', {
      attrs: {
        'xlink:href': '#ag-icon-' + context.props.icon
      }
    })]);
  }
};

/***/ })

});
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvRm1NZW51LnZ1ZSIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvdi1jbGljay1vdXRzaWRlL2Rpc3Qvdi1jbGljay1vdXRzaWRlLnVtZC5qcyIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9GbU1lbnUudnVlP2JlMWMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvRm1NZW51LnZ1ZSIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mdW5jdGlvbmFsL0ZtSWNvbi5qcyJdLCJuYW1lcyI6WyJuYW1lIiwiZnVuY3Rpb25hbCIsInByb3BzIiwiaWNvbiIsInR5cGUiLCJTdHJpbmciLCJyZXF1aXJlZCIsInJlbmRlciIsImNyZWF0ZUVsZW1lbnQiLCJjb250ZXh0IiwiY2xhc3MiLCJkYXRhIiwic3RhdGljQ2xhc3MiLCJhdHRycyJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7O0FBaUNBOzs7O0FBQ0E7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztrQkFFQTtBQUNBLGlCQURBO0FBRUE7QUFDQTtBQUNBO0FBREEsS0FEQTtBQUlBO0FBQ0E7QUFEQSxLQUpBO0FBT0E7QUFDQTtBQURBLEtBUEE7QUFVQTtBQUNBO0FBREE7QUFWQSxHQUZBO0FBZ0JBO0FBQ0E7QUFEQSxHQWhCQTtBQW1CQTtBQUNBO0FBREEsR0FuQkE7QUFzQkEsTUF0QkEsa0JBc0JBO0FBQ0E7QUFDQSxxQkFEQTtBQUVBO0FBRkE7QUFJQSxHQTNCQTs7QUE0QkE7QUFDQSxZQURBLG9CQUNBLFFBREEsRUFDQTtBQUFBOztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsT0FKQTtBQUtBLEtBUEE7QUFRQSxTQVJBLGlC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SSxLQUFVLEdBQUc7QUFDakI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNIO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNILENBQUM7O0FBRUQ7Ozs7Ozs7Ozs7Ozs7O2tCQ3hDZTtBQUNYQSxRQUFNLFNBREs7QUFFWEMsY0FBWSxJQUZEO0FBR1hDLFNBQU87QUFDTEMsVUFBTTtBQUNKQyxZQUFNQyxNQURGO0FBRUpDLGdCQUFVO0FBRk47QUFERCxHQUhJO0FBU1hDLFFBVFcsa0JBU0pDLGFBVEksRUFTV0MsT0FUWCxFQVNvQjtBQUM3QixXQUFPRCxjQUFjLEtBQWQsRUFBcUI7QUFDMUJFLGFBQU8sQ0FDTCxTQURLLEVBRUxELFFBQVFFLElBQVIsQ0FBYUMsV0FGUixDQURtQjtBQUsxQkMsYUFBTztBQUNMLHVCQUFlO0FBRFY7QUFMbUIsS0FBckIsRUFRSixDQUNETCxjQUFjLEtBQWQsRUFBcUI7QUFDbkJLLGFBQU87QUFDTCxvQ0FBMEJKLFFBQVFQLEtBQVIsQ0FBY0M7QUFEbkM7QUFEWSxLQUFyQixDQURDLENBUkksQ0FBUDtBQWVEO0FBekJVLEMiLCJmaWxlIjoiNS5qcyIsInNvdXJjZXNDb250ZW50IjpbIjx0ZW1wbGF0ZT5cbiAgPGRpdiBjbGFzcz1cImFnLW1lbnUtY29udGFpbmVyXCIgOmNsYXNzPVwieyAnYWctbWVudS0tZGlzYWJsZWQnOiBkaXNhYmxlZCB9XCIgQGNsaWNrPVwidG9nZ2xlXCI+XG4gICAgPHNsb3QgbmFtZT1cImJhc2VcIj48L3Nsb3Q+XG4gICAgPHRyYW5zaXRpb24tZ3JvdXAgdGFnPVwiZGl2XCJcbiAgICAgICAgICAgICAgICAgICAgICBuYW1lPVwibGlzdC1kb3duXCJcbiAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cImFnLW1lbnVcIlxuICAgICAgICAgICAgICAgICAgICAgIDpjbGFzcz1cIltcbiAgICAgICAgICAgICAgICAgICAgICAgIHsgJ2FnLW1lbnUtLXNob3duJzogc2hvd0xpc3QgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGlzUmlnaHQgPyAnYWctbWVudS0tcmlnaHQnIDogJ2FnLW1lbnUtLWxlZnQnLFxuICAgICAgICAgICAgICAgICAgICAgIF1cIlxuICAgICAgICAgICAgICAgICAgICAgIHJlZj1cImZtTWVudVwiPlxuICAgICAgPHRlbXBsYXRlIHYtaWY9XCJzaG93TGlzdFwiPlxuICAgICAgICA8Zm9ybSBrZXk9XCJmb3JtXCIgY2xhc3M9XCJ1aSBmb3JtIGFnLW1lbnVfX2Zvcm1cIiBAc3VibWl0LnByZXZlbnQgdi1pZj1cInNlYXJjaGFibGVcIj5cbiAgICAgICAgICA8aW5wdXQgdHlwZT1cInRleHRcIlxuICAgICAgICAgICAgICAgICBwbGFjZWhvbGRlcj1cIlNlYXJjaCAuLi5cIlxuICAgICAgICAgICAgICAgICByZWY9XCJzZWFyY2hcIlxuICAgICAgICAgICAgICAgICBjbGFzcz1cInVpIGlucHV0XCJcbiAgICAgICAgICAgICAgICAgQGlucHV0PVwic2VhcmNoXCJcbiAgICAgICAgICAgICAgICAgQGNsaWNrLnN0b3BcbiAgICAgICAgICAgICAgICAgYXV0b2ZvY3VzPlxuICAgICAgICAgIDxidXR0b24gdHlwZT1cInN1Ym1pdFwiIGNsYXNzPVwiYWctbWVudV9fZm9ybS1idXR0b25cIiBAY2xpY2suc3RvcD5cbiAgICAgICAgICAgIDxhZy1pY29uIGljb249XCJzZWFyY2hcIiBjbGFzcz1cImFnLWljb24tLXNlbWktbGlnaHQtZ3JleVwiPjwvYWctaWNvbj5cbiAgICAgICAgICA8L2J1dHRvbj5cbiAgICAgICAgPC9mb3JtPlxuICAgICAgICA8ZGl2IGtleT1cIml0ZW1zXCIgY2xhc3M9XCJhZy1tZW51X19pdGVtIGFnLXNjcm9sbFwiPlxuICAgICAgICAgIDxzbG90IG5hbWU9XCJpdGVtXCI+PC9zbG90PlxuICAgICAgICA8L2Rpdj5cbiAgICAgIDwvdGVtcGxhdGU+XG4gICAgPC90cmFuc2l0aW9uLWdyb3VwPlxuICAgIDxkaXYgY2xhc3M9XCJhZy1tZW51LS1maXhlZFwiIHYtaWY9XCJzaG93TGlzdFwiIEBjbGljay5zdG9wPVwidG9nZ2xlXCIgdi1jbGljay1vdXRzaWRlPVwiaGlkZVwiPjwvZGl2PlxuICA8L2Rpdj5cbjwvdGVtcGxhdGU+XG48c2NyaXB0PlxuICBpbXBvcnQgRm1JY29uIGZyb20gJy4vZnVuY3Rpb25hbC9GbUljb24nO1xuICBpbXBvcnQgVkNsaWNrT3V0c2lkZSBmcm9tICd2LWNsaWNrLW91dHNpZGUnO1xuXG4gIGV4cG9ydCBkZWZhdWx0IHtcbiAgICBuYW1lOiAnZm0tbWVudScsXG4gICAgcHJvcHM6IHtcbiAgICAgIHNlYXJjaGFibGU6IHtcbiAgICAgICAgdHlwZTogQm9vbGVhbixcbiAgICAgIH0sXG4gICAgICBmaXhlZDoge1xuICAgICAgICB0eXBlOiBCb29sZWFuLFxuICAgICAgfSxcbiAgICAgIGRpc2FibGVkOiB7XG4gICAgICAgIHR5cGU6IEJvb2xlYW4sXG4gICAgICB9LFxuICAgICAgaXNSaWdodDoge1xuICAgICAgICB0eXBlOiBCb29sZWFuLFxuICAgICAgfSxcbiAgICB9LFxuICAgIGNvbXBvbmVudHM6IHtcbiAgICAgIEZtSWNvbixcbiAgICB9LFxuICAgIGRpcmVjdGl2ZXM6IHtcbiAgICAgIENsaWNrT3V0c2lkZTogVkNsaWNrT3V0c2lkZS5kaXJlY3RpdmUsXG4gICAgfSxcbiAgICBkYXRhKCkge1xuICAgICAgcmV0dXJuIHtcbiAgICAgICAgc2hvd0xpc3Q6IGZhbHNlLFxuICAgICAgICBkZWJvdW5jZVRpbWU6IDUwMCxcbiAgICAgIH07XG4gICAgfSxcbiAgICB3YXRjaDoge1xuICAgICAgc2hvd0xpc3QobmV3VmFsdWUpIHtcbiAgICAgICAgdGhpcy4kbmV4dFRpY2soKCkgPT4ge1xuICAgICAgICAgIGlmIChuZXdWYWx1ZSAmJiB0aGlzLiRyZWZzLnNlYXJjaCkge1xuICAgICAgICAgICAgdGhpcy4kcmVmcy5zZWFyY2guZm9jdXMoKTtcbiAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgICAgfSxcbiAgICAgIGZpeGVkKGlzRml4ZWQpIHtcbiAgICAgICAgaWYgKGlzRml4ZWQpIHtcbiAgICAgICAgICB0aGlzLnNldEZpeGVkKCk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgdGhpcy5yZXNldEZpeGVkKCk7XG4gICAgICAgIH1cbiAgICAgIH0sXG4gICAgfSxcbiAgICBiZWZvcmVEZXN0cm95KCkge1xuICAgICAgdGhpcy5yZXNldEZpeGVkKCk7XG4gICAgfSxcbiAgICBtZXRob2RzOiB7XG4gICAgICBjaGFuZ2VWaXNpYmlsaXR5KHZpc2libGUpIHtcbiAgICAgICAgaWYgKHZpc2libGUpIHtcbiAgICAgICAgICB0aGlzLnNob3coKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICB0aGlzLmhpZGUoKTtcbiAgICAgICAgfVxuICAgICAgfSxcbiAgICAgIHRvZ2dsZSgpIHtcbiAgICAgICAgaWYgKCF0aGlzLmRpc2FibGVkKSB7XG4gICAgICAgICAgdGhpcy5jaGFuZ2VWaXNpYmlsaXR5KCF0aGlzLnNob3dMaXN0KTtcbiAgICAgICAgfVxuICAgICAgfSxcbiAgICAgIHNob3coKSB7XG4gICAgICAgIGlmICh0aGlzLmZpeGVkKSB7XG4gICAgICAgICAgdGhpcy5zZXRGaXhlZCgpO1xuICAgICAgICB9XG4gICAgICAgIHRoaXMuc2hvd0xpc3QgPSB0cnVlO1xuICAgICAgICB0aGlzLiRlbWl0KCdzaG93bicpO1xuICAgICAgfSxcbiAgICAgIGhpZGUoKSB7XG4gICAgICAgIHRoaXMuc2hvd0xpc3QgPSBmYWxzZTtcbiAgICAgICAgdGhpcy4kZW1pdCgnaGlkZGVuJyk7XG4gICAgICB9LFxuICAgICAgc2VhcmNoKGUpIHtcbiAgICAgICAgdGhpcy4kZW1pdCgnc2VhcmNoJywgZS50YXJnZXQudmFsdWUpO1xuICAgICAgfSxcbiAgICAgIHNldEZpeGVkKCkge1xuICAgICAgICB0aGlzLiRuZXh0VGljaygoKSA9PiB7XG4gICAgICAgICAgY29uc3QgZWxCb3VuZHMgPSB0aGlzLiRlbC5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKTtcbiAgICAgICAgICBpZiAoZWxCb3VuZHMueCkge1xuICAgICAgICAgICAgY29uc3QgbWVudUVsID0gdGhpcy4kcmVmcy5mbU1lbnUuJGVsO1xuICAgICAgICAgICAgaWYgKG1lbnVFbCkge1xuICAgICAgICAgICAgICBtZW51RWwuc3R5bGUucG9zaXRpb24gPSAnZml4ZWQnO1xuICAgICAgICAgICAgICBtZW51RWwuc3R5bGUudG9wID0gYCR7ZWxCb3VuZHMueSArIDIwfXB4YDtcbiAgICAgICAgICAgICAgbWVudUVsLnN0eWxlLnJpZ2h0ID0gYGNhbGMoMTAwJSAtICR7ZWxCb3VuZHMueH1weClgO1xuICAgICAgICAgICAgfVxuICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICB9LFxuICAgICAgcmVzZXRGaXhlZCgpIHtcbiAgICAgICAgY29uc3QgbWVudUVsID0gdGhpcy4kcmVmcy5mbU1lbnUuJGVsO1xuICAgICAgICBpZiAobWVudUVsKSB7XG4gICAgICAgICAgbWVudUVsLnJlbW92ZUF0dHJpYnV0ZSgnc3R5bGUnKTtcbiAgICAgICAgfVxuICAgICAgfSxcbiAgICB9LFxuICB9O1xuPC9zY3JpcHQ+XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvRm1NZW51LnZ1ZSIsIiFmdW5jdGlvbihlLG4pe1wib2JqZWN0XCI9PXR5cGVvZiBleHBvcnRzJiZcInVuZGVmaW5lZFwiIT10eXBlb2YgbW9kdWxlP21vZHVsZS5leHBvcnRzPW4oKTpcImZ1bmN0aW9uXCI9PXR5cGVvZiBkZWZpbmUmJmRlZmluZS5hbWQ/ZGVmaW5lKG4pOmVbXCJ2LWNsaWNrLW91dHNpZGVcIl09bigpfSh0aGlzLGZ1bmN0aW9uKCl7dmFyIGU9XCJfX3YtY2xpY2stb3V0c2lkZVwiLG49XCJ1bmRlZmluZWRcIiE9dHlwZW9mIHdpbmRvdyx0PVwidW5kZWZpbmVkXCIhPXR5cGVvZiBuYXZpZ2F0b3IsaT1uJiYoXCJvbnRvdWNoc3RhcnRcImluIHdpbmRvd3x8dCYmbmF2aWdhdG9yLm1zTWF4VG91Y2hQb2ludHM+MCk/W1widG91Y2hzdGFydFwiXTpbXCJjbGlja1wiXTtmdW5jdGlvbiBvKG4sdCl7dmFyIG89ZnVuY3Rpb24oZSl7dmFyIG49XCJmdW5jdGlvblwiPT10eXBlb2YgZTtpZighbiYmXCJvYmplY3RcIiE9dHlwZW9mIGUpdGhyb3cgbmV3IEVycm9yKFwidi1jbGljay1vdXRzaWRlOiBCaW5kaW5nIHZhbHVlIG11c3QgYmUgYSBmdW5jdGlvbiBvciBhbiBvYmplY3RcIik7cmV0dXJue2hhbmRsZXI6bj9lOmUuaGFuZGxlcixtaWRkbGV3YXJlOmUubWlkZGxld2FyZXx8ZnVuY3Rpb24oZSl7cmV0dXJuIGV9LGV2ZW50czplLmV2ZW50c3x8aSxpc0FjdGl2ZTohKCExPT09ZS5pc0FjdGl2ZSl9fSh0LnZhbHVlKSxyPW8uaGFuZGxlcixkPW8ubWlkZGxld2FyZTtvLmlzQWN0aXZlJiYobltlXT1vLmV2ZW50cy5tYXAoZnVuY3Rpb24oZSl7cmV0dXJue2V2ZW50OmUsaGFuZGxlcjpmdW5jdGlvbihlKXtyZXR1cm4gZnVuY3Rpb24oZSl7dmFyIG49ZS5lbCx0PWUuZXZlbnQsaT1lLmhhbmRsZXIsbz1lLm1pZGRsZXdhcmU7dC50YXJnZXQhPT1uJiYhbi5jb250YWlucyh0LnRhcmdldCkmJm8odCkmJmkodCl9KHtldmVudDplLGVsOm4saGFuZGxlcjpyLG1pZGRsZXdhcmU6ZH0pfX19KSxuW2VdLmZvckVhY2goZnVuY3Rpb24odCl7dmFyIGk9dC5ldmVudCxvPXQuaGFuZGxlcjtyZXR1cm4gc2V0VGltZW91dChmdW5jdGlvbigpe25bZV0mJmRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5hZGRFdmVudExpc3RlbmVyKGksbywhMSl9LDApfSkpfWZ1bmN0aW9uIHIobil7KG5bZV18fFtdKS5mb3JFYWNoKGZ1bmN0aW9uKGUpe3JldHVybiBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcihlLmV2ZW50LGUuaGFuZGxlciwhMSl9KSxkZWxldGUgbltlXX12YXIgZD17YmluZDpvLHVwZGF0ZTpmdW5jdGlvbihlLG4pe3ZhciB0PW4udmFsdWUsaT1uLm9sZFZhbHVlO0pTT04uc3RyaW5naWZ5KHQpIT09SlNPTi5zdHJpbmdpZnkoaSkmJihyKGUpLG8oZSx7dmFsdWU6dH0pKX0sdW5iaW5kOnJ9O3JldHVybntpbnN0YWxsOmZ1bmN0aW9uKGUpe2UuZGlyZWN0aXZlKFwiY2xpY2stb3V0c2lkZVwiLGQpfSxkaXJlY3RpdmU6ZH19KTtcbi8vIyBzb3VyY2VNYXBwaW5nVVJMPXYtY2xpY2stb3V0c2lkZS51bWQuanMubWFwXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy92LWNsaWNrLW91dHNpZGUvZGlzdC92LWNsaWNrLW91dHNpZGUudW1kLmpzXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy92LWNsaWNrLW91dHNpZGUvZGlzdC92LWNsaWNrLW91dHNpZGUudW1kLmpzXG4vLyBtb2R1bGUgY2h1bmtzID0gNSIsInZhciByZW5kZXIgPSBmdW5jdGlvbigpIHtcbiAgdmFyIF92bSA9IHRoaXNcbiAgdmFyIF9oID0gX3ZtLiRjcmVhdGVFbGVtZW50XG4gIHZhciBfYyA9IF92bS5fc2VsZi5fYyB8fCBfaFxuICByZXR1cm4gX2MoXG4gICAgXCJkaXZcIixcbiAgICB7XG4gICAgICBzdGF0aWNDbGFzczogXCJhZy1tZW51LWNvbnRhaW5lclwiLFxuICAgICAgY2xhc3M6IHsgXCJhZy1tZW51LS1kaXNhYmxlZFwiOiBfdm0uZGlzYWJsZWQgfSxcbiAgICAgIG9uOiB7IGNsaWNrOiBfdm0udG9nZ2xlIH1cbiAgICB9LFxuICAgIFtcbiAgICAgIF92bS5fdChcImJhc2VcIiksXG4gICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgX2MoXG4gICAgICAgIFwidHJhbnNpdGlvbi1ncm91cFwiLFxuICAgICAgICB7XG4gICAgICAgICAgcmVmOiBcImZtTWVudVwiLFxuICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImFnLW1lbnVcIixcbiAgICAgICAgICBjbGFzczogW1xuICAgICAgICAgICAgeyBcImFnLW1lbnUtLXNob3duXCI6IF92bS5zaG93TGlzdCB9LFxuICAgICAgICAgICAgX3ZtLmlzUmlnaHQgPyBcImFnLW1lbnUtLXJpZ2h0XCIgOiBcImFnLW1lbnUtLWxlZnRcIlxuICAgICAgICAgIF0sXG4gICAgICAgICAgYXR0cnM6IHsgdGFnOiBcImRpdlwiLCBuYW1lOiBcImxpc3QtZG93blwiIH1cbiAgICAgICAgfSxcbiAgICAgICAgW1xuICAgICAgICAgIF92bS5zaG93TGlzdFxuICAgICAgICAgICAgPyBbXG4gICAgICAgICAgICAgICAgX3ZtLnNlYXJjaGFibGVcbiAgICAgICAgICAgICAgICAgID8gX2MoXG4gICAgICAgICAgICAgICAgICAgICAgXCJmb3JtXCIsXG4gICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAga2V5OiBcImZvcm1cIixcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcInVpIGZvcm0gYWctbWVudV9fZm9ybVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgb246IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgc3VibWl0OiBmdW5jdGlvbigkZXZlbnQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZXZlbnQucHJldmVudERlZmF1bHQoKVxuICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICBfYyhcImlucHV0XCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgcmVmOiBcInNlYXJjaFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJ1aSBpbnB1dFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6IFwidGV4dFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiBcIlNlYXJjaCAuLi5cIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdXRvZm9jdXM6IFwiXCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgb246IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpbnB1dDogX3ZtLnNlYXJjaCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGljazogZnVuY3Rpb24oJGV2ZW50KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZXZlbnQuc3RvcFByb3BhZ2F0aW9uKClcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgICAgICBcImJ1dHRvblwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiYWctbWVudV9fZm9ybS1idXR0b25cIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczogeyB0eXBlOiBcInN1Ym1pdFwiIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgb246IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsaWNrOiBmdW5jdGlvbigkZXZlbnQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJhZy1pY29uXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImFnLWljb24tLXNlbWktbGlnaHQtZ3JleVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHsgaWNvbjogXCJzZWFyY2hcIiB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgMVxuICAgICAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgOiBfdm0uX2UoKSxcbiAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgXCJkaXZcIixcbiAgICAgICAgICAgICAgICAgIHsga2V5OiBcIml0ZW1zXCIsIHN0YXRpY0NsYXNzOiBcImFnLW1lbnVfX2l0ZW0gYWctc2Nyb2xsXCIgfSxcbiAgICAgICAgICAgICAgICAgIFtfdm0uX3QoXCJpdGVtXCIpXSxcbiAgICAgICAgICAgICAgICAgIDJcbiAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgIF1cbiAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgXSxcbiAgICAgICAgMlxuICAgICAgKSxcbiAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICBfdm0uc2hvd0xpc3RcbiAgICAgICAgPyBfYyhcImRpdlwiLCB7XG4gICAgICAgICAgICBkaXJlY3RpdmVzOiBbXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBuYW1lOiBcImNsaWNrLW91dHNpZGVcIixcbiAgICAgICAgICAgICAgICByYXdOYW1lOiBcInYtY2xpY2stb3V0c2lkZVwiLFxuICAgICAgICAgICAgICAgIHZhbHVlOiBfdm0uaGlkZSxcbiAgICAgICAgICAgICAgICBleHByZXNzaW9uOiBcImhpZGVcIlxuICAgICAgICAgICAgICB9XG4gICAgICAgICAgICBdLFxuICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiYWctbWVudS0tZml4ZWRcIixcbiAgICAgICAgICAgIG9uOiB7XG4gICAgICAgICAgICAgIGNsaWNrOiBmdW5jdGlvbigkZXZlbnQpIHtcbiAgICAgICAgICAgICAgICAkZXZlbnQuc3RvcFByb3BhZ2F0aW9uKClcbiAgICAgICAgICAgICAgICByZXR1cm4gX3ZtLnRvZ2dsZSgkZXZlbnQpXG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9KVxuICAgICAgICA6IF92bS5fZSgpXG4gICAgXSxcbiAgICAyXG4gIClcbn1cbnZhciBzdGF0aWNSZW5kZXJGbnMgPSBbXVxucmVuZGVyLl93aXRoU3RyaXBwZWQgPSB0cnVlXG5tb2R1bGUuZXhwb3J0cyA9IHsgcmVuZGVyOiByZW5kZXIsIHN0YXRpY1JlbmRlckZuczogc3RhdGljUmVuZGVyRm5zIH1cbmlmIChtb2R1bGUuaG90KSB7XG4gIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgaWYgKG1vZHVsZS5ob3QuZGF0YSkge1xuICAgIHJlcXVpcmUoXCJ2dWUtaG90LXJlbG9hZC1hcGlcIikgICAgICAucmVyZW5kZXIoXCJkYXRhLXYtNDdhZmQxZjJcIiwgbW9kdWxlLmV4cG9ydHMpXG4gIH1cbn1cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlcj97XCJpZFwiOlwiZGF0YS12LTQ3YWZkMWYyXCIsXCJoYXNTY29wZWRcIjpmYWxzZSxcImJ1YmxlXCI6e1widHJhbnNmb3Jtc1wiOnt9fX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvRm1NZW51LnZ1ZVxuLy8gbW9kdWxlIGlkID0gLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvdGVtcGxhdGUtY29tcGlsZXIvaW5kZXguanM/e1wiaWRcIjpcImRhdGEtdi00N2FmZDFmMlwiLFwiaGFzU2NvcGVkXCI6ZmFsc2UsXCJidWJsZVwiOntcInRyYW5zZm9ybXNcIjp7fX19IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9dGVtcGxhdGUmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL0ZtTWVudS52dWVcbi8vIG1vZHVsZSBjaHVua3MgPSA1IiwidmFyIGRpc3Bvc2VkID0gZmFsc2VcbnZhciBub3JtYWxpemVDb21wb25lbnQgPSByZXF1aXJlKFwiIS4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9jb21wb25lbnQtbm9ybWFsaXplclwiKVxuLyogc2NyaXB0ICovXG52YXIgX192dWVfc2NyaXB0X18gPSByZXF1aXJlKFwiISFiYWJlbC1sb2FkZXI/e1xcXCJjYWNoZURpcmVjdG9yeVxcXCI6dHJ1ZSxcXFwicHJlc2V0c1xcXCI6W1tcXFwiZW52XFxcIix7XFxcIm1vZHVsZXNcXFwiOmZhbHNlLFxcXCJ0YXJnZXRzXFxcIjp7XFxcImJyb3dzZXJzXFxcIjpbXFxcIj4gMiVcXFwiXSxcXFwidWdsaWZ5XFxcIjp0cnVlfX1dLFxcXCJiYWJlbC1wcmVzZXQtZW52XFxcIl0sXFxcInBsdWdpbnNcXFwiOltcXFwidHJhbnNmb3JtLW9iamVjdC1yZXN0LXNwcmVhZFxcXCIsW1xcXCJ0cmFuc2Zvcm0tcnVudGltZVxcXCIse1xcXCJwb2x5ZmlsbFxcXCI6ZmFsc2UsXFxcImhlbHBlcnNcXFwiOmZhbHNlfV0sXFxcInN5bnRheC1keW5hbWljLWltcG9ydFxcXCJdfSEuLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT1zY3JpcHQmaW5kZXg9MCEuL0ZtTWVudS52dWVcIilcbi8qIHRlbXBsYXRlICovXG52YXIgX192dWVfdGVtcGxhdGVfXyA9IHJlcXVpcmUoXCIhIS4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlci9pbmRleD97XFxcImlkXFxcIjpcXFwiZGF0YS12LTQ3YWZkMWYyXFxcIixcXFwiaGFzU2NvcGVkXFxcIjpmYWxzZSxcXFwiYnVibGVcXFwiOntcXFwidHJhbnNmb3Jtc1xcXCI6e319fSEuLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vRm1NZW51LnZ1ZVwiKVxuLyogdGVtcGxhdGUgZnVuY3Rpb25hbCAqL1xudmFyIF9fdnVlX3RlbXBsYXRlX2Z1bmN0aW9uYWxfXyA9IGZhbHNlXG4vKiBzdHlsZXMgKi9cbnZhciBfX3Z1ZV9zdHlsZXNfXyA9IG51bGxcbi8qIHNjb3BlSWQgKi9cbnZhciBfX3Z1ZV9zY29wZUlkX18gPSBudWxsXG4vKiBtb2R1bGVJZGVudGlmaWVyIChzZXJ2ZXIgb25seSkgKi9cbnZhciBfX3Z1ZV9tb2R1bGVfaWRlbnRpZmllcl9fID0gbnVsbFxudmFyIENvbXBvbmVudCA9IG5vcm1hbGl6ZUNvbXBvbmVudChcbiAgX192dWVfc2NyaXB0X18sXG4gIF9fdnVlX3RlbXBsYXRlX18sXG4gIF9fdnVlX3RlbXBsYXRlX2Z1bmN0aW9uYWxfXyxcbiAgX192dWVfc3R5bGVzX18sXG4gIF9fdnVlX3Njb3BlSWRfXyxcbiAgX192dWVfbW9kdWxlX2lkZW50aWZpZXJfX1xuKVxuQ29tcG9uZW50Lm9wdGlvbnMuX19maWxlID0gXCJyZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9GbU1lbnUudnVlXCJcblxuLyogaG90IHJlbG9hZCAqL1xuaWYgKG1vZHVsZS5ob3QpIHsoZnVuY3Rpb24gKCkge1xuICB2YXIgaG90QVBJID0gcmVxdWlyZShcInZ1ZS1ob3QtcmVsb2FkLWFwaVwiKVxuICBob3RBUEkuaW5zdGFsbChyZXF1aXJlKFwidnVlXCIpLCBmYWxzZSlcbiAgaWYgKCFob3RBUEkuY29tcGF0aWJsZSkgcmV0dXJuXG4gIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgaWYgKCFtb2R1bGUuaG90LmRhdGEpIHtcbiAgICBob3RBUEkuY3JlYXRlUmVjb3JkKFwiZGF0YS12LTQ3YWZkMWYyXCIsIENvbXBvbmVudC5vcHRpb25zKVxuICB9IGVsc2Uge1xuICAgIGhvdEFQSS5yZWxvYWQoXCJkYXRhLXYtNDdhZmQxZjJcIiwgQ29tcG9uZW50Lm9wdGlvbnMpXG4gIH1cbiAgbW9kdWxlLmhvdC5kaXNwb3NlKGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgZGlzcG9zZWQgPSB0cnVlXG4gIH0pXG59KSgpfVxuXG5tb2R1bGUuZXhwb3J0cyA9IENvbXBvbmVudC5leHBvcnRzXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL0ZtTWVudS52dWVcbi8vIG1vZHVsZSBpZCA9IC4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvRm1NZW51LnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDUiLCJleHBvcnQgZGVmYXVsdCB7XG4gICAgbmFtZTogJ2ZtLWljb24nLFxuICAgIGZ1bmN0aW9uYWw6IHRydWUsXG4gICAgcHJvcHM6IHtcbiAgICAgIGljb246IHtcbiAgICAgICAgdHlwZTogU3RyaW5nLFxuICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgIH0sXG4gICAgfSxcbiAgICByZW5kZXIoY3JlYXRlRWxlbWVudCwgY29udGV4dCkge1xuICAgICAgcmV0dXJuIGNyZWF0ZUVsZW1lbnQoJ3N2ZycsIHtcbiAgICAgICAgY2xhc3M6IFtcbiAgICAgICAgICAnYWctaWNvbicsXG4gICAgICAgICAgY29udGV4dC5kYXRhLnN0YXRpY0NsYXNzLFxuICAgICAgICBdLFxuICAgICAgICBhdHRyczoge1xuICAgICAgICAgICdhcmlhLWhpZGRlbic6IHRydWUsXG4gICAgICAgIH0sXG4gICAgICB9LCBbXG4gICAgICAgIGNyZWF0ZUVsZW1lbnQoJ3VzZScsIHtcbiAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgJ3hsaW5rOmhyZWYnOiBgI2FnLWljb24tJHtjb250ZXh0LnByb3BzLmljb259YCxcbiAgICAgICAgICB9LFxuICAgICAgICB9KSxcbiAgICAgIF0pO1xuICAgIH0sXG4gIH07XG4gIFxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2Z1bmN0aW9uYWwvRm1JY29uLmpzIl0sInNvdXJjZVJvb3QiOiIifQ==