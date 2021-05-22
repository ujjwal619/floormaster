webpackJsonp([10],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _dateFns = __webpack_require__("./node_modules/date-fns/esm/index.js");

var _utils = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"utils\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

var _FilterTypeMixin = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"../FilterTypeMixin\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

var _FilterTypeMixin2 = _interopRequireDefault(_FilterTypeMixin);

var _humanizedOperator = __webpack_require__("./resources/assets/domain/common/components/fmFilter/const/humanizedOperator.js");

var _operators = __webpack_require__("./resources/assets/domain/common/components/fmFilter/const/operators.js");

var BASE_OPERATOR = _interopRequireWildcard(_operators);

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var OPERATORS = [_humanizedOperator.TODAY, _humanizedOperator.YESTERDAY, _humanizedOperator.LAST_7_DAYS, _humanizedOperator.LAST_30_DAYS, _humanizedOperator.CURRENT_MONTH]; //
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

var CONFIG = {
  inline: true,
  mode: 'range'
};

var FLATPICKER_ID = 'filter-datepicker-' + (0, _utils.uniqueKey)();

exports.default = {
  name: 'FilterDate',
  components: {
    Flatpicker: function Flatpicker() {
      return Promise.reject(function webpackMissingModule() { var e = new Error("Cannot find module \"components/Flatpicker\""); e.code = 'MODULE_NOT_FOUND';; return e; }());
    }
  },
  mixins: [_FilterTypeMixin2.default],
  OPERATORS: OPERATORS,
  CONFIG: CONFIG,
  FLATPICKER_ID: FLATPICKER_ID,
  watch: {
    operator: function operator(value) {
      if (value !== BASE_OPERATOR.CUSTOM) {
        this.value = this.formattedDate(this.relativeToDate(value));
      }
    }
  },
  created: function created() {
    this.operator = this.filter.operator || '';
  },

  methods: {
    showFlatpicker: function showFlatpicker(operator) {
      return operator === BASE_OPERATOR.CUSTOM && this.operator === BASE_OPERATOR.CUSTOM;
    },
    formattedDate: function formattedDate(value) {
      return (0, _dateFns.format)(value || new Date(), 'YYYY-MM-DD');
    },
    relativeToDate: function relativeToDate(relativeDate) {
      switch (relativeDate) {
        case BASE_OPERATOR.YESTERDAY:
          return (0, _dateFns.subDays)(new Date(), 1);
        case BASE_OPERATOR.LAST_7_DAYS:
          return (0, _dateFns.subDays)(new Date(), 7);
        case BASE_OPERATOR.LAST_30_DAYS:
          return (0, _dateFns.subDays)(new Date(), 30);
        case BASE_OPERATOR.CURRENT_MONTH:
          return (0, _dateFns.subDays)(new Date(), (0, _dateFns.getDate)(new Date()) - 1);
        case BASE_OPERATOR.LAST_MONTH:
          return (0, _dateFns.subMonths)(this.relativeToDate(BASE_OPERATOR.CURRENT_MONTH), 1);
        default:
        case BASE_OPERATOR.TODAY:
          return new Date();
      }
    }
  }
};

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-e5a22f60\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.flatpickr-calendar.inline {\n  position: absolute;\n  top: 35px;\n}\n.flatpickr-current-month input {\n  border-color: transparent !important;\n  padding: 0 0 0 .5ch !important;\n}\n", "", {"version":3,"sources":["/home/manjul/Projects/floor-management/resources/assets/domain/common/components/fmFilter/types/resources/assets/domain/common/components/fmFilter/types/FilterDate.vue"],"names":[],"mappings":";AAiHA;EACA,mBAAA;EACA,UAAA;CACA;AAEA;EACA,qCAAA;EACA,+BAAA;CACA","file":"FilterDate.vue","sourcesContent":["<template>\n  <filter-type\n    :operators=\"$options.OPERATORS\"\n    :operator.sync=\"operator\"\n  >\n    <div\n      class=\"relativePosition\"\n      slot-scope=\"{ operator: operatorObj }\"\n      v-if=\"showFlatpicker(operatorObj.id)\"\n    >\n      <flatpicker\n        :config=\"$options.CONFIG\"\n        placeholder=\"Select a date range\"\n        class=\"relativePosition\"\n      >\n        <input\n          type=\"text\"\n          class=\"flatpickr-input input\"\n          :name=\"$options.FLATPICKER_ID\"\n          slot-scope=\"{ fp }\"\n          v-model=\"value\"\n          data-input\n        />\n      </flatpicker>\n    </div>\n  </filter-type>\n</template>\n\n<script>\n  import {\n    subDays,\n    getDate,\n    subMonths,\n    format,\n  } from 'date-fns';\n  import { uniqueKey } from 'utils';\n  import FilterTypeMixin from '../FilterTypeMixin';\n  import {\n    TODAY,\n    YESTERDAY,\n    LAST_7_DAYS,\n    LAST_30_DAYS,\n    CURRENT_MONTH,\n    // LAST_MONTH,\n    // CUSTOM,\n  } from '../const/humanizedOperator';\n  import * as BASE_OPERATOR from '../const/operators';\n\n  const OPERATORS = [\n    TODAY,\n    YESTERDAY,\n    LAST_7_DAYS,\n    LAST_30_DAYS,\n    CURRENT_MONTH,\n    // LAST_MONTH,\n    // CUSTOM,\n  ];\n\n  const CONFIG = {\n    inline: true,\n    mode: 'range',\n  };\n\n  const FLATPICKER_ID = `filter-datepicker-${uniqueKey()}`;\n\n  export default {\n    name: 'FilterDate',\n    components: {\n      Flatpicker: () => import('components/Flatpicker'),\n    },\n    mixins: [FilterTypeMixin],\n    OPERATORS,\n    CONFIG,\n    FLATPICKER_ID,\n    watch: {\n      operator(value) {\n        if (value !== BASE_OPERATOR.CUSTOM) {\n          this.value = this.formattedDate(this.relativeToDate(value));\n        }\n      },\n    },\n    created() {\n      this.operator = this.filter.operator || '';\n    },\n    methods: {\n      showFlatpicker(operator) {\n        return operator === BASE_OPERATOR.CUSTOM && this.operator === BASE_OPERATOR.CUSTOM;\n      },\n      formattedDate(value) {\n        return format(value || new Date(), 'YYYY-MM-DD');\n      },\n      relativeToDate(relativeDate) {\n        switch (relativeDate) {\n          case BASE_OPERATOR.YESTERDAY:\n            return subDays(new Date(), 1);\n          case BASE_OPERATOR.LAST_7_DAYS:\n            return subDays(new Date(), 7);\n          case BASE_OPERATOR.LAST_30_DAYS:\n            return subDays(new Date(), 30);\n          case BASE_OPERATOR.CURRENT_MONTH:\n            return subDays(new Date(), getDate(new Date()) - 1);\n          case BASE_OPERATOR.LAST_MONTH:\n            return subMonths(this.relativeToDate(BASE_OPERATOR.CURRENT_MONTH), 1);\n          default:\n          case BASE_OPERATOR.TODAY:\n            return new Date();\n        }\n      },\n    },\n  };\n</script>\n\n<style>\n  .flatpickr-calendar.inline {\n    position: absolute;\n    top: 35px;\n  }\n\n  .flatpickr-current-month input {\n    border-color: transparent !important;\n    padding: 0 0 0 .5ch !important;\n  }\n</style>\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-e5a22f60\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("filter-type", {
    attrs: { operators: _vm.$options.OPERATORS, operator: _vm.operator },
    on: {
      "update:operator": function($event) {
        _vm.operator = $event
      }
    },
    scopedSlots: _vm._u([
      {
        key: "default",
        fn: function(ref) {
          var operatorObj = ref.operator
          return _vm.showFlatpicker(operatorObj.id)
            ? _c(
                "div",
                { staticClass: "relativePosition" },
                [
                  _c("flatpicker", {
                    staticClass: "relativePosition",
                    attrs: {
                      config: _vm.$options.CONFIG,
                      placeholder: "Select a date range"
                    },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(ref) {
                          var fp = ref.fp
                          return _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.value,
                                expression: "value"
                              }
                            ],
                            staticClass: "flatpickr-input input",
                            attrs: {
                              type: "text",
                              name: _vm.$options.FLATPICKER_ID,
                              "data-input": ""
                            },
                            domProps: { value: _vm.value },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.value = $event.target.value
                              }
                            }
                          })
                        }
                      }
                    ])
                  })
                ],
                1
              )
            : _vm._e()
        }
      }
    ])
  })
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-e5a22f60", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-e5a22f60\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-e5a22f60\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("021e9f14", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-e5a22f60\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterDate.vue", function() {
     var newContent = require("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-e5a22f60\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterDate.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-e5a22f60\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-e5a22f60\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "resources/assets/domain/common/components/fmFilter/types/FilterDate.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-e5a22f60", Component.options)
  } else {
    hotAPI.reload("data-v-e5a22f60", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyRGF0ZS52dWUiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyRGF0ZS52dWU/NTE4MSIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJEYXRlLnZ1ZT9iMDg4Iiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlckRhdGUudnVlPzIzNDAiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyRGF0ZS52dWUiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7O0FBNkJBOztBQU1BOztBQUNBOzs7O0FBQ0E7O0FBU0E7O0lBQUEsYTs7Ozs7O0FBRUEsaUJBQ0Esd0JBREEsRUFFQSw0QkFGQSxFQUdBLDhCQUhBLEVBSUEsK0JBSkEsRUFLQSxnQ0FMQSxFOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQVVBO0FBQ0EsY0FEQTtBQUVBO0FBRkE7O0FBS0E7O2tCQUVBO0FBQ0Esb0JBREE7QUFFQTtBQUNBO0FBQUE7QUFBQTtBQURBLEdBRkE7QUFLQSxxQ0FMQTtBQU1BLHNCQU5BO0FBT0EsZ0JBUEE7QUFRQSw4QkFSQTtBQVNBO0FBQ0EsWUFEQSxvQkFDQSxLQURBLEVBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUxBLEdBVEE7QUFnQkEsU0FoQkEscUJBZ0JBO0FBQ0E7QUFDQSxHQWxCQTs7QUFtQkE7QUFDQSxrQkFEQSwwQkFDQSxRQURBLEVBQ0E7QUFD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QUFDSDtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSCxDQUFDOztBQUVEIiwiZmlsZSI6IjEwLmpzIiwic291cmNlc0NvbnRlbnQiOlsiPHRlbXBsYXRlPlxuICA8ZmlsdGVyLXR5cGVcbiAgICA6b3BlcmF0b3JzPVwiJG9wdGlvbnMuT1BFUkFUT1JTXCJcbiAgICA6b3BlcmF0b3Iuc3luYz1cIm9wZXJhdG9yXCJcbiAgPlxuICAgIDxkaXZcbiAgICAgIGNsYXNzPVwicmVsYXRpdmVQb3NpdGlvblwiXG4gICAgICBzbG90LXNjb3BlPVwieyBvcGVyYXRvcjogb3BlcmF0b3JPYmogfVwiXG4gICAgICB2LWlmPVwic2hvd0ZsYXRwaWNrZXIob3BlcmF0b3JPYmouaWQpXCJcbiAgICA+XG4gICAgICA8ZmxhdHBpY2tlclxuICAgICAgICA6Y29uZmlnPVwiJG9wdGlvbnMuQ09ORklHXCJcbiAgICAgICAgcGxhY2Vob2xkZXI9XCJTZWxlY3QgYSBkYXRlIHJhbmdlXCJcbiAgICAgICAgY2xhc3M9XCJyZWxhdGl2ZVBvc2l0aW9uXCJcbiAgICAgID5cbiAgICAgICAgPGlucHV0XG4gICAgICAgICAgdHlwZT1cInRleHRcIlxuICAgICAgICAgIGNsYXNzPVwiZmxhdHBpY2tyLWlucHV0IGlucHV0XCJcbiAgICAgICAgICA6bmFtZT1cIiRvcHRpb25zLkZMQVRQSUNLRVJfSURcIlxuICAgICAgICAgIHNsb3Qtc2NvcGU9XCJ7IGZwIH1cIlxuICAgICAgICAgIHYtbW9kZWw9XCJ2YWx1ZVwiXG4gICAgICAgICAgZGF0YS1pbnB1dFxuICAgICAgICAvPlxuICAgICAgPC9mbGF0cGlja2VyPlxuICAgIDwvZGl2PlxuICA8L2ZpbHRlci10eXBlPlxuPC90ZW1wbGF0ZT5cblxuPHNjcmlwdD5cbiAgaW1wb3J0IHtcbiAgICBzdWJEYXlzLFxuICAgIGdldERhdGUsXG4gICAgc3ViTW9udGhzLFxuICAgIGZvcm1hdCxcbiAgfSBmcm9tICdkYXRlLWZucyc7XG4gIGltcG9ydCB7IHVuaXF1ZUtleSB9IGZyb20gJ3V0aWxzJztcbiAgaW1wb3J0IEZpbHRlclR5cGVNaXhpbiBmcm9tICcuLi9GaWx0ZXJUeXBlTWl4aW4nO1xuICBpbXBvcnQge1xuICAgIFRPREFZLFxuICAgIFlFU1RFUkRBWSxcbiAgICBMQVNUXzdfREFZUyxcbiAgICBMQVNUXzMwX0RBWVMsXG4gICAgQ1VSUkVOVF9NT05USCxcbiAgICAvLyBMQVNUX01PTlRILFxuICAgIC8vIENVU1RPTSxcbiAgfSBmcm9tICcuLi9jb25zdC9odW1hbml6ZWRPcGVyYXRvcic7XG4gIGltcG9ydCAqIGFzIEJBU0VfT1BFUkFUT1IgZnJvbSAnLi4vY29uc3Qvb3BlcmF0b3JzJztcblxuICBjb25zdCBPUEVSQVRPUlMgPSBbXG4gICAgVE9EQVksXG4gICAgWUVTVEVSREFZLFxuICAgIExBU1RfN19EQVlTLFxuICAgIExBU1RfMzBfREFZUyxcbiAgICBDVVJSRU5UX01PTlRILFxuICAgIC8vIExBU1RfTU9OVEgsXG4gICAgLy8gQ1VTVE9NLFxuICBdO1xuXG4gIGNvbnN0IENPTkZJRyA9IHtcbiAgICBpbmxpbmU6IHRydWUsXG4gICAgbW9kZTogJ3JhbmdlJyxcbiAgfTtcblxuICBjb25zdCBGTEFUUElDS0VSX0lEID0gYGZpbHRlci1kYXRlcGlja2VyLSR7dW5pcXVlS2V5KCl9YDtcblxuICBleHBvcnQgZGVmYXVsdCB7XG4gICAgbmFtZTogJ0ZpbHRlckRhdGUnLFxuICAgIGNvbXBvbmVudHM6IHtcbiAgICAgIEZsYXRwaWNrZXI6ICgpID0+IGltcG9ydCgnY29tcG9uZW50cy9GbGF0cGlja2VyJyksXG4gICAgfSxcbiAgICBtaXhpbnM6IFtGaWx0ZXJUeXBlTWl4aW5dLFxuICAgIE9QRVJBVE9SUyxcbiAgICBDT05GSUcsXG4gICAgRkxBVFBJQ0tFUl9JRCxcbiAgICB3YXRjaDoge1xuICAgICAgb3BlcmF0b3IodmFsdWUpIHtcbiAgICAgICAgaWYgKHZhbHVlICE9PSBCQVNFX09QRVJBVE9SLkNVU1RPTSkge1xuICAgICAgICAgIHRoaXMudmFsdWUgPSB0aGlzLmZvcm1hdHRlZERhdGUodGhpcy5yZWxhdGl2ZVRvRGF0ZSh2YWx1ZSkpO1xuICAgICAgICB9XG4gICAgICB9LFxuICAgIH0sXG4gICAgY3JlYXRlZCgpIHtcbiAgICAgIHRoaXMub3BlcmF0b3IgPSB0aGlzLmZpbHRlci5vcGVyYXRvciB8fCAnJztcbiAgICB9LFxuICAgIG1ldGhvZHM6IHtcbiAgICAgIHNob3dGbGF0cGlja2VyKG9wZXJhdG9yKSB7XG4gICAgICAgIHJldHVybiBvcGVyYXRvciA9PT0gQkFTRV9PUEVSQVRPUi5DVVNUT00gJiYgdGhpcy5vcGVyYXRvciA9PT0gQkFTRV9PUEVSQVRPUi5DVVNUT007XG4gICAgICB9LFxuICAgICAgZm9ybWF0dGVkRGF0ZSh2YWx1ZSkge1xuICAgICAgICByZXR1cm4gZm9ybWF0KHZhbHVlIHx8IG5ldyBEYXRlKCksICdZWVlZLU1NLUREJyk7XG4gICAgICB9LFxuICAgICAgcmVsYXRpdmVUb0RhdGUocmVsYXRpdmVEYXRlKSB7XG4gICAgICAgIHN3aXRjaCAocmVsYXRpdmVEYXRlKSB7XG4gICAgICAgICAgY2FzZSBCQVNFX09QRVJBVE9SLllFU1RFUkRBWTpcbiAgICAgICAgICAgIHJldHVybiBzdWJEYXlzKG5ldyBEYXRlKCksIDEpO1xuICAgICAgICAgIGNhc2UgQkFTRV9PUEVSQVRPUi5MQVNUXzdfREFZUzpcbiAgICAgICAgICAgIHJldHVybiBzdWJEYXlzKG5ldyBEYXRlKCksIDcpO1xuICAgICAgICAgIGNhc2UgQkFTRV9PUEVSQVRPUi5MQVNUXzMwX0RBWVM6XG4gICAgICAgICAgICByZXR1cm4gc3ViRGF5cyhuZXcgRGF0ZSgpLCAzMCk7XG4gICAgICAgICAgY2FzZSBCQVNFX09QRVJBVE9SLkNVUlJFTlRfTU9OVEg6XG4gICAgICAgICAgICByZXR1cm4gc3ViRGF5cyhuZXcgRGF0ZSgpLCBnZXREYXRlKG5ldyBEYXRlKCkpIC0gMSk7XG4gICAgICAgICAgY2FzZSBCQVNFX09QRVJBVE9SLkxBU1RfTU9OVEg6XG4gICAgICAgICAgICByZXR1cm4gc3ViTW9udGhzKHRoaXMucmVsYXRpdmVUb0RhdGUoQkFTRV9PUEVSQVRPUi5DVVJSRU5UX01PTlRIKSwgMSk7XG4gICAgICAgICAgZGVmYXVsdDpcbiAgICAgICAgICBjYXNlIEJBU0VfT1BFUkFUT1IuVE9EQVk6XG4gICAgICAgICAgICByZXR1cm4gbmV3IERhdGUoKTtcbiAgICAgICAgfVxuICAgICAgfSxcbiAgICB9LFxuICB9O1xuPC9zY3JpcHQ+XG5cbjxzdHlsZT5cbiAgLmZsYXRwaWNrci1jYWxlbmRhci5pbmxpbmUge1xuICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcbiAgICB0b3A6IDM1cHg7XG4gIH1cblxuICAuZmxhdHBpY2tyLWN1cnJlbnQtbW9udGggaW5wdXQge1xuICAgIGJvcmRlci1jb2xvcjogdHJhbnNwYXJlbnQgIWltcG9ydGFudDtcbiAgICBwYWRkaW5nOiAwIDAgMCAuNWNoICFpbXBvcnRhbnQ7XG4gIH1cbjwvc3R5bGU+XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyRGF0ZS52dWUiLCJleHBvcnRzID0gbW9kdWxlLmV4cG9ydHMgPSByZXF1aXJlKFwiLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvbGliL2Nzcy1iYXNlLmpzXCIpKHRydWUpO1xuLy8gaW1wb3J0c1xuXG5cbi8vIG1vZHVsZVxuZXhwb3J0cy5wdXNoKFttb2R1bGUuaWQsIFwiXFxuLmZsYXRwaWNrci1jYWxlbmRhci5pbmxpbmUge1xcbiAgcG9zaXRpb246IGFic29sdXRlO1xcbiAgdG9wOiAzNXB4O1xcbn1cXG4uZmxhdHBpY2tyLWN1cnJlbnQtbW9udGggaW5wdXQge1xcbiAgYm9yZGVyLWNvbG9yOiB0cmFuc3BhcmVudCAhaW1wb3J0YW50O1xcbiAgcGFkZGluZzogMCAwIDAgLjVjaCAhaW1wb3J0YW50O1xcbn1cXG5cIiwgXCJcIiwge1widmVyc2lvblwiOjMsXCJzb3VyY2VzXCI6W1wiL2hvbWUvbWFuanVsL1Byb2plY3RzL2Zsb29yLW1hbmFnZW1lbnQvcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyRGF0ZS52dWVcIl0sXCJuYW1lc1wiOltdLFwibWFwcGluZ3NcIjpcIjtBQWlIQTtFQUNBLG1CQUFBO0VBQ0EsVUFBQTtDQUNBO0FBRUE7RUFDQSxxQ0FBQTtFQUNBLCtCQUFBO0NBQ0FcIixcImZpbGVcIjpcIkZpbHRlckRhdGUudnVlXCIsXCJzb3VyY2VzQ29udGVudFwiOltcIjx0ZW1wbGF0ZT5cXG4gIDxmaWx0ZXItdHlwZVxcbiAgICA6b3BlcmF0b3JzPVxcXCIkb3B0aW9ucy5PUEVSQVRPUlNcXFwiXFxuICAgIDpvcGVyYXRvci5zeW5jPVxcXCJvcGVyYXRvclxcXCJcXG4gID5cXG4gICAgPGRpdlxcbiAgICAgIGNsYXNzPVxcXCJyZWxhdGl2ZVBvc2l0aW9uXFxcIlxcbiAgICAgIHNsb3Qtc2NvcGU9XFxcInsgb3BlcmF0b3I6IG9wZXJhdG9yT2JqIH1cXFwiXFxuICAgICAgdi1pZj1cXFwic2hvd0ZsYXRwaWNrZXIob3BlcmF0b3JPYmouaWQpXFxcIlxcbiAgICA+XFxuICAgICAgPGZsYXRwaWNrZXJcXG4gICAgICAgIDpjb25maWc9XFxcIiRvcHRpb25zLkNPTkZJR1xcXCJcXG4gICAgICAgIHBsYWNlaG9sZGVyPVxcXCJTZWxlY3QgYSBkYXRlIHJhbmdlXFxcIlxcbiAgICAgICAgY2xhc3M9XFxcInJlbGF0aXZlUG9zaXRpb25cXFwiXFxuICAgICAgPlxcbiAgICAgICAgPGlucHV0XFxuICAgICAgICAgIHR5cGU9XFxcInRleHRcXFwiXFxuICAgICAgICAgIGNsYXNzPVxcXCJmbGF0cGlja3ItaW5wdXQgaW5wdXRcXFwiXFxuICAgICAgICAgIDpuYW1lPVxcXCIkb3B0aW9ucy5GTEFUUElDS0VSX0lEXFxcIlxcbiAgICAgICAgICBzbG90LXNjb3BlPVxcXCJ7IGZwIH1cXFwiXFxuICAgICAgICAgIHYtbW9kZWw9XFxcInZhbHVlXFxcIlxcbiAgICAgICAgICBkYXRhLWlucHV0XFxuICAgICAgICAvPlxcbiAgICAgIDwvZmxhdHBpY2tlcj5cXG4gICAgPC9kaXY+XFxuICA8L2ZpbHRlci10eXBlPlxcbjwvdGVtcGxhdGU+XFxuXFxuPHNjcmlwdD5cXG4gIGltcG9ydCB7XFxuICAgIHN1YkRheXMsXFxuICAgIGdldERhdGUsXFxuICAgIHN1Yk1vbnRocyxcXG4gICAgZm9ybWF0LFxcbiAgfSBmcm9tICdkYXRlLWZucyc7XFxuICBpbXBvcnQgeyB1bmlxdWVLZXkgfSBmcm9tICd1dGlscyc7XFxuICBpbXBvcnQgRmlsdGVyVHlwZU1peGluIGZyb20gJy4uL0ZpbHRlclR5cGVNaXhpbic7XFxuICBpbXBvcnQge1xcbiAgICBUT0RBWSxcXG4gICAgWUVTVEVSREFZLFxcbiAgICBMQVNUXzdfREFZUyxcXG4gICAgTEFTVF8zMF9EQVlTLFxcbiAgICBDVVJSRU5UX01PTlRILFxcbiAgICAvLyBMQVNUX01PTlRILFxcbiAgICAvLyBDVVNUT00sXFxuICB9IGZyb20gJy4uL2NvbnN0L2h1bWFuaXplZE9wZXJhdG9yJztcXG4gIGltcG9ydCAqIGFzIEJBU0VfT1BFUkFUT1IgZnJvbSAnLi4vY29uc3Qvb3BlcmF0b3JzJztcXG5cXG4gIGNvbnN0IE9QRVJBVE9SUyA9IFtcXG4gICAgVE9EQVksXFxuICAgIFlFU1RFUkRBWSxcXG4gICAgTEFTVF83X0RBWVMsXFxuICAgIExBU1RfMzBfREFZUyxcXG4gICAgQ1VSUkVOVF9NT05USCxcXG4gICAgLy8gTEFTVF9NT05USCxcXG4gICAgLy8gQ1VTVE9NLFxcbiAgXTtcXG5cXG4gIGNvbnN0IENPTkZJRyA9IHtcXG4gICAgaW5saW5lOiB0cnVlLFxcbiAgICBtb2RlOiAncmFuZ2UnLFxcbiAgfTtcXG5cXG4gIGNvbnN0IEZMQVRQSUNLRVJfSUQgPSBgZmlsdGVyLWRhdGVwaWNrZXItJHt1bmlxdWVLZXkoKX1gO1xcblxcbiAgZXhwb3J0IGRlZmF1bHQge1xcbiAgICBuYW1lOiAnRmlsdGVyRGF0ZScsXFxuICAgIGNvbXBvbmVudHM6IHtcXG4gICAgICBGbGF0cGlja2VyOiAoKSA9PiBpbXBvcnQoJ2NvbXBvbmVudHMvRmxhdHBpY2tlcicpLFxcbiAgICB9LFxcbiAgICBtaXhpbnM6IFtGaWx0ZXJUeXBlTWl4aW5dLFxcbiAgICBPUEVSQVRPUlMsXFxuICAgIENPTkZJRyxcXG4gICAgRkxBVFBJQ0tFUl9JRCxcXG4gICAgd2F0Y2g6IHtcXG4gICAgICBvcGVyYXRvcih2YWx1ZSkge1xcbiAgICAgICAgaWYgKHZhbHVlICE9PSBCQVNFX09QRVJBVE9SLkNVU1RPTSkge1xcbiAgICAgICAgICB0aGlzLnZhbHVlID0gdGhpcy5mb3JtYXR0ZWREYXRlKHRoaXMucmVsYXRpdmVUb0RhdGUodmFsdWUpKTtcXG4gICAgICAgIH1cXG4gICAgICB9LFxcbiAgICB9LFxcbiAgICBjcmVhdGVkKCkge1xcbiAgICAgIHRoaXMub3BlcmF0b3IgPSB0aGlzLmZpbHRlci5vcGVyYXRvciB8fCAnJztcXG4gICAgfSxcXG4gICAgbWV0aG9kczoge1xcbiAgICAgIHNob3dGbGF0cGlja2VyKG9wZXJhdG9yKSB7XFxuICAgICAgICByZXR1cm4gb3BlcmF0b3IgPT09IEJBU0VfT1BFUkFUT1IuQ1VTVE9NICYmIHRoaXMub3BlcmF0b3IgPT09IEJBU0VfT1BFUkFUT1IuQ1VTVE9NO1xcbiAgICAgIH0sXFxuICAgICAgZm9ybWF0dGVkRGF0ZSh2YWx1ZSkge1xcbiAgICAgICAgcmV0dXJuIGZvcm1hdCh2YWx1ZSB8fCBuZXcgRGF0ZSgpLCAnWVlZWS1NTS1ERCcpO1xcbiAgICAgIH0sXFxuICAgICAgcmVsYXRpdmVUb0RhdGUocmVsYXRpdmVEYXRlKSB7XFxuICAgICAgICBzd2l0Y2ggKHJlbGF0aXZlRGF0ZSkge1xcbiAgICAgICAgICBjYXNlIEJBU0VfT1BFUkFUT1IuWUVTVEVSREFZOlxcbiAgICAgICAgICAgIHJldHVybiBzdWJEYXlzKG5ldyBEYXRlKCksIDEpO1xcbiAgICAgICAgICBjYXNlIEJBU0VfT1BFUkFUT1IuTEFTVF83X0RBWVM6XFxuICAgICAgICAgICAgcmV0dXJuIHN1YkRheXMobmV3IERhdGUoKSwgNyk7XFxuICAgICAgICAgIGNhc2UgQkFTRV9PUEVSQVRPUi5MQVNUXzMwX0RBWVM6XFxuICAgICAgICAgICAgcmV0dXJuIHN1YkRheXMobmV3IERhdGUoKSwgMzApO1xcbiAgICAgICAgICBjYXNlIEJBU0VfT1BFUkFUT1IuQ1VSUkVOVF9NT05USDpcXG4gICAgICAgICAgICByZXR1cm4gc3ViRGF5cyhuZXcgRGF0ZSgpLCBnZXREYXRlKG5ldyBEYXRlKCkpIC0gMSk7XFxuICAgICAgICAgIGNhc2UgQkFTRV9PUEVSQVRPUi5MQVNUX01PTlRIOlxcbiAgICAgICAgICAgIHJldHVybiBzdWJNb250aHModGhpcy5yZWxhdGl2ZVRvRGF0ZShCQVNFX09QRVJBVE9SLkNVUlJFTlRfTU9OVEgpLCAxKTtcXG4gICAgICAgICAgZGVmYXVsdDpcXG4gICAgICAgICAgY2FzZSBCQVNFX09QRVJBVE9SLlRPREFZOlxcbiAgICAgICAgICAgIHJldHVybiBuZXcgRGF0ZSgpO1xcbiAgICAgICAgfVxcbiAgICAgIH0sXFxuICAgIH0sXFxuICB9O1xcbjwvc2NyaXB0PlxcblxcbjxzdHlsZT5cXG4gIC5mbGF0cGlja3ItY2FsZW5kYXIuaW5saW5lIHtcXG4gICAgcG9zaXRpb246IGFic29sdXRlO1xcbiAgICB0b3A6IDM1cHg7XFxuICB9XFxuXFxuICAuZmxhdHBpY2tyLWN1cnJlbnQtbW9udGggaW5wdXQge1xcbiAgICBib3JkZXItY29sb3I6IHRyYW5zcGFyZW50ICFpbXBvcnRhbnQ7XFxuICAgIHBhZGRpbmc6IDAgMCAwIC41Y2ggIWltcG9ydGFudDtcXG4gIH1cXG48L3N0eWxlPlxcblwiXSxcInNvdXJjZVJvb3RcIjpcIlwifV0pO1xuXG4vLyBleHBvcnRzXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyP3NvdXJjZU1hcCEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlcj97XCJ2dWVcIjp0cnVlLFwiaWRcIjpcImRhdGEtdi1lNWEyMmY2MFwiLFwic2NvcGVkXCI6ZmFsc2UsXCJoYXNJbmxpbmVDb25maWdcIjp0cnVlfSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyRGF0ZS52dWVcbi8vIG1vZHVsZSBpZCA9IC4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LWU1YTIyZjYwXCIsXCJzY29wZWRcIjpmYWxzZSxcImhhc0lubGluZUNvbmZpZ1wiOnRydWV9IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJEYXRlLnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDEwIiwidmFyIHJlbmRlciA9IGZ1bmN0aW9uKCkge1xuICB2YXIgX3ZtID0gdGhpc1xuICB2YXIgX2ggPSBfdm0uJGNyZWF0ZUVsZW1lbnRcbiAgdmFyIF9jID0gX3ZtLl9zZWxmLl9jIHx8IF9oXG4gIHJldHVybiBfYyhcImZpbHRlci10eXBlXCIsIHtcbiAgICBhdHRyczogeyBvcGVyYXRvcnM6IF92bS4kb3B0aW9ucy5PUEVSQVRPUlMsIG9wZXJhdG9yOiBfdm0ub3BlcmF0b3IgfSxcbiAgICBvbjoge1xuICAgICAgXCJ1cGRhdGU6b3BlcmF0b3JcIjogZnVuY3Rpb24oJGV2ZW50KSB7XG4gICAgICAgIF92bS5vcGVyYXRvciA9ICRldmVudFxuICAgICAgfVxuICAgIH0sXG4gICAgc2NvcGVkU2xvdHM6IF92bS5fdShbXG4gICAgICB7XG4gICAgICAgIGtleTogXCJkZWZhdWx0XCIsXG4gICAgICAgIGZuOiBmdW5jdGlvbihyZWYpIHtcbiAgICAgICAgICB2YXIgb3BlcmF0b3JPYmogPSByZWYub3BlcmF0b3JcbiAgICAgICAgICByZXR1cm4gX3ZtLnNob3dGbGF0cGlja2VyKG9wZXJhdG9yT2JqLmlkKVxuICAgICAgICAgICAgPyBfYyhcbiAgICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICAgIHsgc3RhdGljQ2xhc3M6IFwicmVsYXRpdmVQb3NpdGlvblwiIH0sXG4gICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgX2MoXCJmbGF0cGlja2VyXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwicmVsYXRpdmVQb3NpdGlvblwiLFxuICAgICAgICAgICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICAgICAgICAgIGNvbmZpZzogX3ZtLiRvcHRpb25zLkNPTkZJRyxcbiAgICAgICAgICAgICAgICAgICAgICBwbGFjZWhvbGRlcjogXCJTZWxlY3QgYSBkYXRlIHJhbmdlXCJcbiAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgc2NvcGVkU2xvdHM6IF92bS5fdShbXG4gICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAga2V5OiBcImRlZmF1bHRcIixcbiAgICAgICAgICAgICAgICAgICAgICAgIGZuOiBmdW5jdGlvbihyZWYpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGZwID0gcmVmLmZwXG4gICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBfYyhcImlucHV0XCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkaXJlY3RpdmVzOiBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5hbWU6IFwibW9kZWxcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmF3TmFtZTogXCJ2LW1vZGVsXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlOiBfdm0udmFsdWUsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGV4cHJlc3Npb246IFwidmFsdWVcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIF0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZmxhdHBpY2tyLWlucHV0IGlucHV0XCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6IFwidGV4dFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbmFtZTogX3ZtLiRvcHRpb25zLkZMQVRQSUNLRVJfSUQsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBcImRhdGEtaW5wdXRcIjogXCJcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZG9tUHJvcHM6IHsgdmFsdWU6IF92bS52YWx1ZSB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG9uOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpbnB1dDogZnVuY3Rpb24oJGV2ZW50KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICgkZXZlbnQudGFyZ2V0LmNvbXBvc2luZykge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVyblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS52YWx1ZSA9ICRldmVudC50YXJnZXQudmFsdWVcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBdKVxuICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgOiBfdm0uX2UoKVxuICAgICAgICB9XG4gICAgICB9XG4gICAgXSlcbiAgfSlcbn1cbnZhciBzdGF0aWNSZW5kZXJGbnMgPSBbXVxucmVuZGVyLl93aXRoU3RyaXBwZWQgPSB0cnVlXG5tb2R1bGUuZXhwb3J0cyA9IHsgcmVuZGVyOiByZW5kZXIsIHN0YXRpY1JlbmRlckZuczogc3RhdGljUmVuZGVyRm5zIH1cbmlmIChtb2R1bGUuaG90KSB7XG4gIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgaWYgKG1vZHVsZS5ob3QuZGF0YSkge1xuICAgIHJlcXVpcmUoXCJ2dWUtaG90LXJlbG9hZC1hcGlcIikgICAgICAucmVyZW5kZXIoXCJkYXRhLXYtZTVhMjJmNjBcIiwgbW9kdWxlLmV4cG9ydHMpXG4gIH1cbn1cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlcj97XCJpZFwiOlwiZGF0YS12LWU1YTIyZjYwXCIsXCJoYXNTY29wZWRcIjpmYWxzZSxcImJ1YmxlXCI6e1widHJhbnNmb3Jtc1wiOnt9fX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyRGF0ZS52dWVcbi8vIG1vZHVsZSBpZCA9IC4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3RlbXBsYXRlLWNvbXBpbGVyL2luZGV4LmpzP3tcImlkXCI6XCJkYXRhLXYtZTVhMjJmNjBcIixcImhhc1Njb3BlZFwiOmZhbHNlLFwiYnVibGVcIjp7XCJ0cmFuc2Zvcm1zXCI6e319fSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXRlbXBsYXRlJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJEYXRlLnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDEwIiwiLy8gc3R5bGUtbG9hZGVyOiBBZGRzIHNvbWUgY3NzIHRvIHRoZSBET00gYnkgYWRkaW5nIGEgPHN0eWxlPiB0YWdcblxuLy8gbG9hZCB0aGUgc3R5bGVzXG52YXIgY29udGVudCA9IHJlcXVpcmUoXCIhIS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyL2luZGV4LmpzP3NvdXJjZU1hcCEuLi8uLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXIvaW5kZXguanM/e1xcXCJ2dWVcXFwiOnRydWUsXFxcImlkXFxcIjpcXFwiZGF0YS12LWU1YTIyZjYwXFxcIixcXFwic2NvcGVkXFxcIjpmYWxzZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlckRhdGUudnVlXCIpO1xuaWYodHlwZW9mIGNvbnRlbnQgPT09ICdzdHJpbmcnKSBjb250ZW50ID0gW1ttb2R1bGUuaWQsIGNvbnRlbnQsICcnXV07XG5pZihjb250ZW50LmxvY2FscykgbW9kdWxlLmV4cG9ydHMgPSBjb250ZW50LmxvY2Fscztcbi8vIGFkZCB0aGUgc3R5bGVzIHRvIHRoZSBET01cbnZhciB1cGRhdGUgPSByZXF1aXJlKFwiIS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyL2xpYi9hZGRTdHlsZXNDbGllbnQuanNcIikoXCIwMjFlOWYxNFwiLCBjb250ZW50LCBmYWxzZSwge30pO1xuLy8gSG90IE1vZHVsZSBSZXBsYWNlbWVudFxuaWYobW9kdWxlLmhvdCkge1xuIC8vIFdoZW4gdGhlIHN0eWxlcyBjaGFuZ2UsIHVwZGF0ZSB0aGUgPHN0eWxlPiB0YWdzXG4gaWYoIWNvbnRlbnQubG9jYWxzKSB7XG4gICBtb2R1bGUuaG90LmFjY2VwdChcIiEhLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtZTVhMjJmNjBcXFwiLFxcXCJzY29wZWRcXFwiOmZhbHNlLFxcXCJoYXNJbmxpbmVDb25maWdcXFwiOnRydWV9IS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vRmlsdGVyRGF0ZS52dWVcIiwgZnVuY3Rpb24oKSB7XG4gICAgIHZhciBuZXdDb250ZW50ID0gcmVxdWlyZShcIiEhLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtZTVhMjJmNjBcXFwiLFxcXCJzY29wZWRcXFwiOmZhbHNlLFxcXCJoYXNJbmxpbmVDb25maWdcXFwiOnRydWV9IS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vRmlsdGVyRGF0ZS52dWVcIik7XG4gICAgIGlmKHR5cGVvZiBuZXdDb250ZW50ID09PSAnc3RyaW5nJykgbmV3Q29udGVudCA9IFtbbW9kdWxlLmlkLCBuZXdDb250ZW50LCAnJ11dO1xuICAgICB1cGRhdGUobmV3Q29udGVudCk7XG4gICB9KTtcbiB9XG4gLy8gV2hlbiB0aGUgbW9kdWxlIGlzIGRpc3Bvc2VkLCByZW1vdmUgdGhlIDxzdHlsZT4gdGFnc1xuIG1vZHVsZS5ob3QuZGlzcG9zZShmdW5jdGlvbigpIHsgdXBkYXRlKCk7IH0pO1xufVxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vbm9kZV9tb2R1bGVzL3Z1ZS1zdHlsZS1sb2FkZXIhLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlcj9zb3VyY2VNYXAhLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXI/e1widnVlXCI6dHJ1ZSxcImlkXCI6XCJkYXRhLXYtZTVhMjJmNjBcIixcInNjb3BlZFwiOmZhbHNlLFwiaGFzSW5saW5lQ29uZmlnXCI6dHJ1ZX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlckRhdGUudnVlXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyL2luZGV4LmpzIS4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LWU1YTIyZjYwXCIsXCJzY29wZWRcIjpmYWxzZSxcImhhc0lubGluZUNvbmZpZ1wiOnRydWV9IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJEYXRlLnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDEwIiwidmFyIGRpc3Bvc2VkID0gZmFsc2VcbmZ1bmN0aW9uIGluamVjdFN0eWxlIChzc3JDb250ZXh0KSB7XG4gIGlmIChkaXNwb3NlZCkgcmV0dXJuXG4gIHJlcXVpcmUoXCIhIXZ1ZS1zdHlsZS1sb2FkZXIhY3NzLWxvYWRlcj9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4P3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi1lNWEyMmY2MFxcXCIsXFxcInNjb3BlZFxcXCI6ZmFsc2UsXFxcImhhc0lubGluZUNvbmZpZ1xcXCI6dHJ1ZX0hLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9GaWx0ZXJEYXRlLnZ1ZVwiKVxufVxudmFyIG5vcm1hbGl6ZUNvbXBvbmVudCA9IHJlcXVpcmUoXCIhLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2NvbXBvbmVudC1ub3JtYWxpemVyXCIpXG4vKiBzY3JpcHQgKi9cbnZhciBfX3Z1ZV9zY3JpcHRfXyA9IHJlcXVpcmUoXCIhIWJhYmVsLWxvYWRlcj97XFxcImNhY2hlRGlyZWN0b3J5XFxcIjp0cnVlLFxcXCJwcmVzZXRzXFxcIjpbW1xcXCJlbnZcXFwiLHtcXFwibW9kdWxlc1xcXCI6ZmFsc2UsXFxcInRhcmdldHNcXFwiOntcXFwiYnJvd3NlcnNcXFwiOltcXFwiPiAyJVxcXCJdLFxcXCJ1Z2xpZnlcXFwiOnRydWV9fV0sXFxcImJhYmVsLXByZXNldC1lbnZcXFwiXSxcXFwicGx1Z2luc1xcXCI6W1xcXCJ0cmFuc2Zvcm0tb2JqZWN0LXJlc3Qtc3ByZWFkXFxcIixbXFxcInRyYW5zZm9ybS1ydW50aW1lXFxcIix7XFxcInBvbHlmaWxsXFxcIjpmYWxzZSxcXFwiaGVscGVyc1xcXCI6ZmFsc2V9XSxcXFwic3ludGF4LWR5bmFtaWMtaW1wb3J0XFxcIl19IS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvcj90eXBlPXNjcmlwdCZpbmRleD0wIS4vRmlsdGVyRGF0ZS52dWVcIilcbi8qIHRlbXBsYXRlICovXG52YXIgX192dWVfdGVtcGxhdGVfXyA9IHJlcXVpcmUoXCIhIS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlci9pbmRleD97XFxcImlkXFxcIjpcXFwiZGF0YS12LWU1YTIyZjYwXFxcIixcXFwiaGFzU2NvcGVkXFxcIjpmYWxzZSxcXFwiYnVibGVcXFwiOntcXFwidHJhbnNmb3Jtc1xcXCI6e319fSEuLi8uLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vRmlsdGVyRGF0ZS52dWVcIilcbi8qIHRlbXBsYXRlIGZ1bmN0aW9uYWwgKi9cbnZhciBfX3Z1ZV90ZW1wbGF0ZV9mdW5jdGlvbmFsX18gPSBmYWxzZVxuLyogc3R5bGVzICovXG52YXIgX192dWVfc3R5bGVzX18gPSBpbmplY3RTdHlsZVxuLyogc2NvcGVJZCAqL1xudmFyIF9fdnVlX3Njb3BlSWRfXyA9IG51bGxcbi8qIG1vZHVsZUlkZW50aWZpZXIgKHNlcnZlciBvbmx5KSAqL1xudmFyIF9fdnVlX21vZHVsZV9pZGVudGlmaWVyX18gPSBudWxsXG52YXIgQ29tcG9uZW50ID0gbm9ybWFsaXplQ29tcG9uZW50KFxuICBfX3Z1ZV9zY3JpcHRfXyxcbiAgX192dWVfdGVtcGxhdGVfXyxcbiAgX192dWVfdGVtcGxhdGVfZnVuY3Rpb25hbF9fLFxuICBfX3Z1ZV9zdHlsZXNfXyxcbiAgX192dWVfc2NvcGVJZF9fLFxuICBfX3Z1ZV9tb2R1bGVfaWRlbnRpZmllcl9fXG4pXG5Db21wb25lbnQub3B0aW9ucy5fX2ZpbGUgPSBcInJlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlckRhdGUudnVlXCJcblxuLyogaG90IHJlbG9hZCAqL1xuaWYgKG1vZHVsZS5ob3QpIHsoZnVuY3Rpb24gKCkge1xuICB2YXIgaG90QVBJID0gcmVxdWlyZShcInZ1ZS1ob3QtcmVsb2FkLWFwaVwiKVxuICBob3RBUEkuaW5zdGFsbChyZXF1aXJlKFwidnVlXCIpLCBmYWxzZSlcbiAgaWYgKCFob3RBUEkuY29tcGF0aWJsZSkgcmV0dXJuXG4gIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgaWYgKCFtb2R1bGUuaG90LmRhdGEpIHtcbiAgICBob3RBUEkuY3JlYXRlUmVjb3JkKFwiZGF0YS12LWU1YTIyZjYwXCIsIENvbXBvbmVudC5vcHRpb25zKVxuICB9IGVsc2Uge1xuICAgIGhvdEFQSS5yZWxvYWQoXCJkYXRhLXYtZTVhMjJmNjBcIiwgQ29tcG9uZW50Lm9wdGlvbnMpXG4gIH1cbiAgbW9kdWxlLmhvdC5kaXNwb3NlKGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgZGlzcG9zZWQgPSB0cnVlXG4gIH0pXG59KSgpfVxuXG5tb2R1bGUuZXhwb3J0cyA9IENvbXBvbmVudC5leHBvcnRzXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlckRhdGUudnVlXG4vLyBtb2R1bGUgaWQgPSAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlckRhdGUudnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gMTAiXSwic291cmNlUm9vdCI6IiJ9