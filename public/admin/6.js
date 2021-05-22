webpackJsonp([6],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/FilterItem.vue":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _get = __webpack_require__("./node_modules/lodash/fp/get.js");

var _get2 = _interopRequireDefault(_get);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'FilterItem',
  props: {
    operator: {
      type: Object,
      required: true
    },
    isChecked: {
      type: Boolean
    }
  },
  watch: {
    isChecked: {
      immediate: true,
      handler: function handler(val, oldVal) {
        var _this = this;

        if (val && val !== oldVal) {
          this.$nextTick(function () {
            // @TODO: need to refactor in case of Vue js update to 2.6 or above
            var elm = (0, _get2.default)('default[0].elm')(_this.$slots);
            if (elm && elm.focus) {
              elm.focus();
            }
          });
        }
      }
    }
  }
}; //
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

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/FilterType.vue":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _helpers = __webpack_require__("./resources/assets/domain/common/utitlities/helpers.js");

var _FilterItem = __webpack_require__("./resources/assets/domain/common/components/fmFilter/FilterItem.vue");

var _FilterItem2 = _interopRequireDefault(_FilterItem);

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

exports.default = {
  name: 'FilterType',
  components: {
    FilterItem: _FilterItem2.default
  },
  props: {
    operators: {
      type: Array,
      required: true
    },
    operator: {
      type: String,
      required: true
    }
  },
  methods: {
    getComponentKey: function getComponentKey() {
      return 'filter-type-' + (0, _helpers.uniqueKey)();
    }
  }
};

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterString.vue":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _FilterTypeMixin = __webpack_require__("./resources/assets/domain/common/components/fmFilter/FilterTypeMixin.js");

var _FilterTypeMixin2 = _interopRequireDefault(_FilterTypeMixin);

var _humanizedOperator = __webpack_require__("./resources/assets/domain/common/components/fmFilter/const/humanizedOperator.js");

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

var OPERATORS = [_humanizedOperator.IS, _humanizedOperator.IS_NOT, _humanizedOperator.STARTS_WITH, _humanizedOperator.ENDS_WITH, _humanizedOperator.CONTAINS, _humanizedOperator.NOT_CONTAINS, _humanizedOperator.UNKNOWN];

exports.default = {
  name: 'FilterString',
  mixins: [_FilterTypeMixin2.default],
  props: {
    filter: {
      type: Object,
      required: true
    }
  },
  OPERATORS: OPERATORS,
  UNKNOWN: _humanizedOperator.UNKNOWN,
  watch: {
    operator: function operator(value) {
      if (value === _humanizedOperator.UNKNOWN.id) {
        this.value = ' ';
      }
    }
  },
  methods: {
    showInput: function showInput(_ref) {
      var id = _ref.id;

      return id !== _humanizedOperator.UNKNOWN.id && id === this.operator;
    }
  }
};

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5e334686\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterType.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", "", {"version":3,"sources":[],"names":[],"mappings":"","file":"FilterType.vue","sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-669ac442\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterItem.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.filter-item[data-v-669ac442] {\n  margin: 1rem;\n}\n.filter-item__label + *[data-v-669ac442] {\n  margin-top: 5px !important;\n}\n", "", {"version":3,"sources":["/home/manjul/Projects/floor-management/resources/assets/domain/common/components/fmFilter/resources/assets/domain/common/components/fmFilter/FilterItem.vue"],"names":[],"mappings":";AAoDA;EACA,aAAA;CACA;AAEA;EACA,2BAAA;CACA","file":"FilterItem.vue","sourcesContent":["<template>\n  <div class=\"filter-item ag-flex ag-flex-column\">\n    <div class=\"ag-flex ag-align-center filter-item__label\">\n      <label class=\"ag-flex\">\n        <input\n          type=\"radio\"\n          class=\"col-hr-1\"\n          :value=\"operator.id\"\n          :checked=\"isChecked\"\n          @input=\"$emit('input', $event.target.value)\"\n        />\n        {{ operator.value }}\n      </label>\n    </div>\n    <slot></slot>\n  </div>\n</template>\n\n<script>\n  import get from 'lodash/fp/get';\n\n  export default {\n    name: 'FilterItem',\n    props: {\n      operator: {\n        type: Object,\n        required: true,\n      },\n      isChecked: {\n        type: Boolean,\n      },\n    },\n    watch: {\n      isChecked: {\n        immediate: true,\n        handler(val, oldVal) {\n          if (val && (val !== oldVal)) {\n            this.$nextTick(() => {\n              // @TODO: need to refactor in case of Vue js update to 2.6 or above\n              const elm = get('default[0].elm')(this.$slots);\n              if (elm && elm.focus) {\n                elm.focus();\n              }\n            });\n          }\n        },\n      },\n    },\n  };\n</script>\n\n<style scoped>\n  .filter-item {\n    margin: 1rem;\n  }\n\n  .filter-item__label + * {\n    margin-top: 5px !important;\n  }\n</style>\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-82dd569a\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterString.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", "", {"version":3,"sources":[],"names":[],"mappings":"","file":"FilterString.vue","sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5e334686\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/FilterType.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "span",
    _vm._l(_vm.operators, function(operatorObj) {
      return _c(
        "filter-item",
        {
          key: operatorObj.id + "-" + _vm.getComponentKey(),
          attrs: {
            operator: operatorObj,
            "is-checked": operatorObj.id === _vm.operator
          },
          on: {
            input: function($event) {
              _vm.$emit("update:operator", $event)
            }
          }
        },
        [_vm._t("default", null, { operator: operatorObj })],
        2
      )
    }),
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5e334686", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-669ac442\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/FilterItem.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "filter-item ag-flex ag-flex-column" },
    [
      _c("div", { staticClass: "ag-flex ag-align-center filter-item__label" }, [
        _c("label", { staticClass: "ag-flex" }, [
          _c("input", {
            staticClass: "col-hr-1",
            attrs: { type: "radio" },
            domProps: { value: _vm.operator.id, checked: _vm.isChecked },
            on: {
              input: function($event) {
                _vm.$emit("input", $event.target.value)
              }
            }
          }),
          _vm._v("\n      " + _vm._s(_vm.operator.value) + "\n    ")
        ])
      ]),
      _vm._v(" "),
      _vm._t("default")
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
    require("vue-hot-reload-api")      .rerender("data-v-669ac442", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-82dd569a\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterString.vue":
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
          return _c("input", {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.showInput(operatorObj),
                expression: "showInput(operatorObj)"
              }
            ],
            attrs: { type: "text" },
            domProps: { value: _vm.value },
            on: {
              input: function($event) {
                _vm.value = $event.target.value.toLowerCase()
              }
            }
          })
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
    require("vue-hot-reload-api")      .rerender("data-v-82dd569a", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5e334686\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterType.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5e334686\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterType.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("9b856982", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5e334686\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterType.vue", function() {
     var newContent = require("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5e334686\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterType.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-669ac442\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterItem.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-669ac442\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterItem.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("61bb374a", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-669ac442\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterItem.vue", function() {
     var newContent = require("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-669ac442\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterItem.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-82dd569a\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterString.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-82dd569a\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterString.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("26a30dd1", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-82dd569a\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterString.vue", function() {
     var newContent = require("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-82dd569a\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterString.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/assets/domain/common/components/fmFilter/FilterItem.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-669ac442\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterItem.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/FilterItem.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-669ac442\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/FilterItem.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-669ac442"
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
Component.options.__file = "resources/assets/domain/common/components/fmFilter/FilterItem.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-669ac442", Component.options)
  } else {
    hotAPI.reload("data-v-669ac442", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/domain/common/components/fmFilter/FilterType.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5e334686\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterType.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/FilterType.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5e334686\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/FilterType.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-5e334686"
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
Component.options.__file = "resources/assets/domain/common/components/fmFilter/FilterType.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5e334686", Component.options)
  } else {
    hotAPI.reload("data-v-5e334686", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/domain/common/components/fmFilter/FilterTypeMixin.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _FilterType = __webpack_require__("./resources/assets/domain/common/components/fmFilter/FilterType.vue");

var _FilterType2 = _interopRequireDefault(_FilterType);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  components: {
    FilterType: _FilterType2.default
  },
  props: {
    filter: {
      type: Object,
      required: true
    }
  },
  data: function data() {
    return {
      operator: '',
      value: ''
    };
  },
  watch: {
    operator: function operator(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.emitUpdate();
      }
    },
    value: function value(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.emitUpdate();
      }
    }
  },
  created: function created() {
    this.operator = this.filter.operator || 'equals';
    this.value = this.filter.value || null;
  },

  methods: {
    emitUpdate: function emitUpdate() {
      if (this.operator) {
        this.$emit('update', {
          operator: this.operator,
          value: this.value
        });
      }
    }
  }
};

/***/ }),

/***/ "./resources/assets/domain/common/components/fmFilter/types/FilterString.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-82dd569a\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterString.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterString.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-82dd569a\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/types/FilterString.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-82dd569a"
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
Component.options.__file = "resources/assets/domain/common/components/fmFilter/types/FilterString.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-82dd569a", Component.options)
  } else {
    hotAPI.reload("data-v-82dd569a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVySXRlbS52dWUiLCJ3ZWJwYWNrOi8vL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlclR5cGUudnVlIiwid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTdHJpbmcudnVlIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlclR5cGUudnVlP2MyMGMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVySXRlbS52dWU/MzE1YyIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTdHJpbmcudnVlP2RmNmQiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyVHlwZS52dWU/N2JkMiIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJJdGVtLnZ1ZT9mNzQ0Iiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlclN0cmluZy52dWU/ZDZhMCIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJUeXBlLnZ1ZT82YmNhIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlckl0ZW0udnVlP2RhNzIiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyU3RyaW5nLnZ1ZT9hNDlkIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlckl0ZW0udnVlIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlclR5cGUudnVlIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlclR5cGVNaXhpbi5qcyIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTdHJpbmcudnVlIl0sIm5hbWVzIjpbImNvbXBvbmVudHMiLCJGaWx0ZXJUeXBlIiwicHJvcHMiLCJmaWx0ZXIiLCJ0eXBlIiwiT2JqZWN0IiwicmVxdWlyZWQiLCJkYXRhIiwib3BlcmF0b3IiLCJ2YWx1ZSIsIndhdGNoIiwibmV3VmFsdWUiLCJvbGRWYWx1ZSIsImVtaXRVcGRhdGUiLCJjcmVhdGVkIiwibWV0aG9kcyIsIiRlbWl0Il0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7QUFtQkE7Ozs7OztrQkFFQTtBQUNBLG9CQURBO0FBRUE7QUFDQTtBQUNBLGtCQURBO0FBRUE7QUFGQSxLQURBO0FBS0E7QUFDQTtBQURBO0FBTEEsR0FGQTtBQVdBO0FBQ0E7QUFDQSxxQkFEQTtBQUVBLGFBRkEsbUJBRUEsR0FGQSxFQUVBLE1BRkEsRUFFQTtBQUFBOztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsV0FO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QUFLQyxVQUFMO0FBQ0Q7QUFDRixLQUxJO0FBTUxKLFNBTkssaUJBTUNFLFFBTkQsRUFNV0MsUUFOWCxFQU1xQjtBQUN4QixVQUFJRCxhQUFhQyxRQUFqQixFQUEyQjtBQUN6QixhQUFLQyxVQUFMO0FBQ0Q7QUFDRjtBQVZJLEdBZE07QUEwQmJDLFNBMUJhLHFCQTBCSDtBQUNSLFNBQUtOLFFBQUwsR0FBZ0IsS0FBS0wsTUFBTCxDQUFZSyxRQUFaLElBQXdCLFFBQXhDO0FBQ0EsU0FBS0MsS0FBTCxHQUFhLEtBQUtOLE1BQUwsQ0FBWU0sS0FBWixJQUFxQixJQUFsQztBQUNELEdBN0JZOztBQThCYk0sV0FBUztBQUNQRixjQURPLHdCQUNNO0FBQ1gsVUFBSSxLQUFLTCxRQUFULEVBQW1CO0FBQ2pCLGFBQUtRLEtBQUwsQ0FBVyxRQUFYLEVBQXFCO0FBQ25CUixvQkFBVSxLQUFLQSxRQURJO0FBRW5CQyxpQkFBTyxLQUFLQTtBQUZPLFNBQXJCO0FBSUQ7QUFDRjtBQVJNO0FBOUJJLEM7Ozs7Ozs7QUNGZjtBQUNBO0FBQ0E7QUFDQSxFQUFFLG1CQUFPLENBQUMsMFdBQW1TO0FBQzdTO0FBQ0EseUJBQXlCLG1CQUFPLENBQUMsdURBQXdFO0FBQ3pHO0FBQ0EscUJBQXFCLG1CQUFPLENBQUMsNmNBQTBZO0FBQ3ZhO0FBQ0EsdUJBQXVCLG1CQUFPLENBQUMsb1JBQTZQO0FBQzVSO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxJQUFJLEtBQVUsR0FBRztBQUNqQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0gsQ0FBQzs7QUFFRCIsImZpbGUiOiI2LmpzIiwic291cmNlc0NvbnRlbnQiOlsiPHRlbXBsYXRlPlxuICA8ZGl2IGNsYXNzPVwiZmlsdGVyLWl0ZW0gYWctZmxleCBhZy1mbGV4LWNvbHVtblwiPlxuICAgIDxkaXYgY2xhc3M9XCJhZy1mbGV4IGFnLWFsaWduLWNlbnRlciBmaWx0ZXItaXRlbV9fbGFiZWxcIj5cbiAgICAgIDxsYWJlbCBjbGFzcz1cImFnLWZsZXhcIj5cbiAgICAgICAgPGlucHV0XG4gICAgICAgICAgdHlwZT1cInJhZGlvXCJcbiAgICAgICAgICBjbGFzcz1cImNvbC1oci0xXCJcbiAgICAgICAgICA6dmFsdWU9XCJvcGVyYXRvci5pZFwiXG4gICAgICAgICAgOmNoZWNrZWQ9XCJpc0NoZWNrZWRcIlxuICAgICAgICAgIEBpbnB1dD1cIiRlbWl0KCdpbnB1dCcsICRldmVudC50YXJnZXQudmFsdWUpXCJcbiAgICAgICAgLz5cbiAgICAgICAge3sgb3BlcmF0b3IudmFsdWUgfX1cbiAgICAgIDwvbGFiZWw+XG4gICAgPC9kaXY+XG4gICAgPHNsb3Q+PC9zbG90PlxuICA8L2Rpdj5cbjwvdGVtcGxhdGU+XG5cbjxzY3JpcHQ+XG4gIGltcG9ydCBnZXQgZnJvbSAnbG9kYXNoL2ZwL2dldCc7XG5cbiAgZXhwb3J0IGRlZmF1bHQge1xuICAgIG5hbWU6ICdGaWx0ZXJJdGVtJyxcbiAgICBwcm9wczoge1xuICAgICAgb3BlcmF0b3I6IHtcbiAgICAgICAgdHlwZTogT2JqZWN0LFxuICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgIH0sXG4gICAgICBpc0NoZWNrZWQ6IHtcbiAgICAgICAgdHlwZTogQm9vbGVhbixcbiAgICAgIH0sXG4gICAgfSxcbiAgICB3YXRjaDoge1xuICAgICAgaXNDaGVja2VkOiB7XG4gICAgICAgIGltbWVkaWF0ZTogdHJ1ZSxcbiAgICAgICAgaGFuZGxlcih2YWwsIG9sZFZhbCkge1xuICAgICAgICAgIGlmICh2YWwgJiYgKHZhbCAhPT0gb2xkVmFsKSkge1xuICAgICAgICAgICAgdGhpcy4kbmV4dFRpY2soKCkgPT4ge1xuICAgICAgICAgICAgICAvLyBAVE9ETzogbmVlZCB0byByZWZhY3RvciBpbiBjYXNlIG9mIFZ1ZSBqcyB1cGRhdGUgdG8gMi42IG9yIGFib3ZlXG4gICAgICAgICAgICAgIGNvbnN0IGVsbSA9IGdldCgnZGVmYXVsdFswXS5lbG0nKSh0aGlzLiRzbG90cyk7XG4gICAgICAgICAgICAgIGlmIChlbG0gJiYgZWxtLmZvY3VzKSB7XG4gICAgICAgICAgICAgICAgZWxtLmZvY3VzKCk7XG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgIH1cbiAgICAgICAgfSxcbiAgICAgIH0sXG4gICAgfSxcbiAgfTtcbjwvc2NyaXB0PlxuXG48c3R5bGUgc2NvcGVkPlxuICAuZmlsdGVyLWl0ZW0ge1xuICAgIG1hcmdpbjogMXJlbTtcbiAgfVxuXG4gIC5maWx0ZXItaXRlbV9fbGFiZWwgKyAqIHtcbiAgICBtYXJnaW4tdG9wOiA1cHggIWltcG9ydGFudDtcbiAgfVxuPC9zdHlsZT5cblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyByZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJJdGVtLnZ1ZSIsIjx0ZW1wbGF0ZT5cbiAgPHNwYW4+XG4gICAgPGZpbHRlci1pdGVtXG4gICAgICB2LWZvcj1cIm9wZXJhdG9yT2JqIGluIG9wZXJhdG9yc1wiXG4gICAgICA6a2V5PVwiYCR7b3BlcmF0b3JPYmouaWR9LSR7Z2V0Q29tcG9uZW50S2V5KCl9YFwiXG4gICAgICA6b3BlcmF0b3I9XCJvcGVyYXRvck9ialwiXG4gICAgICA6aXMtY2hlY2tlZD1cIm9wZXJhdG9yT2JqLmlkID09PSBvcGVyYXRvclwiXG4gICAgICBAaW5wdXQ9XCIkZW1pdCgndXBkYXRlOm9wZXJhdG9yJywgJGV2ZW50KVwiXG4gICAgPlxuICAgICAgPHNsb3QgOm9wZXJhdG9yPVwib3BlcmF0b3JPYmpcIj48L3Nsb3Q+XG4gICAgPC9maWx0ZXItaXRlbT5cbiAgPC9zcGFuPlxuPC90ZW1wbGF0ZT5cblxuPHNjcmlwdD5cbiAgaW1wb3J0IHsgdW5pcXVlS2V5IH0gZnJvbSAnLi4vLi4vdXRpdGxpdGllcy9oZWxwZXJzJztcbiAgaW1wb3J0IEZpbHRlckl0ZW0gZnJvbSAnLi9GaWx0ZXJJdGVtLnZ1ZSc7XG5cbiAgZXhwb3J0IGRlZmF1bHQge1xuICAgIG5hbWU6ICdGaWx0ZXJUeXBlJyxcbiAgICBjb21wb25lbnRzOiB7XG4gICAgICBGaWx0ZXJJdGVtLFxuICAgIH0sXG4gICAgcHJvcHM6IHtcbiAgICAgIG9wZXJhdG9yczoge1xuICAgICAgICB0eXBlOiBBcnJheSxcbiAgICAgICAgcmVxdWlyZWQ6IHRydWUsXG4gICAgICB9LFxuICAgICAgb3BlcmF0b3I6IHtcbiAgICAgICAgdHlwZTogU3RyaW5nLFxuICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgIH0sXG4gICAgfSxcbiAgICBtZXRob2RzOiB7XG4gICAgICBnZXRDb21wb25lbnRLZXkoKSB7XG4gICAgICAgIHJldHVybiBgZmlsdGVyLXR5cGUtJHt1bmlxdWVLZXkoKX1gO1xuICAgICAgfSxcbiAgICB9LFxuICB9O1xuPC9zY3JpcHQ+XG5cbjxzdHlsZSBzY29wZWQ+XG5cbjwvc3R5bGU+XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyVHlwZS52dWUiLCI8dGVtcGxhdGU+XG4gIDxmaWx0ZXItdHlwZVxuICAgIDpvcGVyYXRvcnM9XCIkb3B0aW9ucy5PUEVSQVRPUlNcIlxuICAgIDpvcGVyYXRvci5zeW5jPVwib3BlcmF0b3JcIlxuICA+XG4gICAgPGlucHV0XG4gICAgICB0eXBlPVwidGV4dFwiXG4gICAgICA6dmFsdWU9XCJ2YWx1ZVwiXG4gICAgICBAaW5wdXQ9XCJ2YWx1ZSA9ICRldmVudC50YXJnZXQudmFsdWUudG9Mb3dlckNhc2UoKVwiXG4gICAgICBzbG90LXNjb3BlPVwieyBvcGVyYXRvcjogb3BlcmF0b3JPYmogfVwiXG4gICAgICB2LXNob3c9XCJzaG93SW5wdXQob3BlcmF0b3JPYmopXCJcbiAgICA+XG4gIDwvZmlsdGVyLXR5cGU+XG48L3RlbXBsYXRlPlxuXG48c2NyaXB0PlxuICBpbXBvcnQgRmlsdGVyVHlwZU1peGluIGZyb20gJy4uL0ZpbHRlclR5cGVNaXhpbic7XG4gIGltcG9ydCB7XG4gICAgSVMsXG4gICAgSVNfTk9ULFxuICAgIFNUQVJUU19XSVRILFxuICAgIEVORFNfV0lUSCxcbiAgICBDT05UQUlOUyxcbiAgICBOT1RfQ09OVEFJTlMsXG4gICAgVU5LTk9XTixcbiAgfSBmcm9tICcuLi9jb25zdC9odW1hbml6ZWRPcGVyYXRvcic7XG5cbiAgY29uc3QgT1BFUkFUT1JTID0gW0lTLCBJU19OT1QsIFNUQVJUU19XSVRILCBFTkRTX1dJVEgsIENPTlRBSU5TLCBOT1RfQ09OVEFJTlMsIFVOS05PV05dO1xuXG4gIGV4cG9ydCBkZWZhdWx0IHtcbiAgICBuYW1lOiAnRmlsdGVyU3RyaW5nJyxcbiAgICBtaXhpbnM6IFtGaWx0ZXJUeXBlTWl4aW5dLFxuICAgIHByb3BzOiB7XG4gICAgICBmaWx0ZXI6IHtcbiAgICAgICAgdHlwZTogT2JqZWN0LFxuICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgIH0sXG4gICAgfSxcbiAgICBPUEVSQVRPUlMsXG4gICAgVU5LTk9XTixcbiAgICB3YXRjaDoge1xuICAgICAgb3BlcmF0b3IodmFsdWUpIHtcbiAgICAgICAgaWYgKHZhbHVlID09PSBVTktOT1dOLmlkKSB7XG4gICAgICAgICAgdGhpcy52YWx1ZSA9ICcgJztcbiAgICAgICAgfVxuICAgICAgfSxcbiAgICB9LFxuICAgIG1ldGhvZHM6IHtcbiAgICAgIHNob3dJbnB1dCh7IGlkIH0pIHtcbiAgICAgICAgcmV0dXJuIGlkICE9PSBVTktOT1dOLmlkICYmIGlkID09PSB0aGlzLm9wZXJhdG9yO1xuICAgICAgfSxcbiAgICB9LFxuICB9O1xuPC9zY3JpcHQ+XG5cbjxzdHlsZSBzY29wZWQ+XG5cbjwvc3R5bGU+XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyU3RyaW5nLnZ1ZSIsImV4cG9ydHMgPSBtb2R1bGUuZXhwb3J0cyA9IHJlcXVpcmUoXCIuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9saWIvY3NzLWJhc2UuanNcIikodHJ1ZSk7XG4vLyBpbXBvcnRzXG5cblxuLy8gbW9kdWxlXG5leHBvcnRzLnB1c2goW21vZHVsZS5pZCwgXCJcXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cXG5cIiwgXCJcIiwge1widmVyc2lvblwiOjMsXCJzb3VyY2VzXCI6W10sXCJuYW1lc1wiOltdLFwibWFwcGluZ3NcIjpcIlwiLFwiZmlsZVwiOlwiRmlsdGVyVHlwZS52dWVcIixcInNvdXJjZVJvb3RcIjpcIlwifV0pO1xuXG4vLyBleHBvcnRzXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyP3NvdXJjZU1hcCEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlcj97XCJ2dWVcIjp0cnVlLFwiaWRcIjpcImRhdGEtdi01ZTMzNDY4NlwiLFwic2NvcGVkXCI6dHJ1ZSxcImhhc0lubGluZUNvbmZpZ1wiOnRydWV9IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJUeXBlLnZ1ZVxuLy8gbW9kdWxlIGlkID0gLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXIvaW5kZXguanM/e1widnVlXCI6dHJ1ZSxcImlkXCI6XCJkYXRhLXYtNWUzMzQ2ODZcIixcInNjb3BlZFwiOnRydWUsXCJoYXNJbmxpbmVDb25maWdcIjp0cnVlfSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyVHlwZS52dWVcbi8vIG1vZHVsZSBjaHVua3MgPSA2IDcgOCA5IiwiZXhwb3J0cyA9IG1vZHVsZS5leHBvcnRzID0gcmVxdWlyZShcIi4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyL2xpYi9jc3MtYmFzZS5qc1wiKSh0cnVlKTtcbi8vIGltcG9ydHNcblxuXG4vLyBtb2R1bGVcbmV4cG9ydHMucHVzaChbbW9kdWxlLmlkLCBcIlxcbi5maWx0ZXItaXRlbVtkYXRhLXYtNjY5YWM0NDJdIHtcXG4gIG1hcmdpbjogMXJlbTtcXG59XFxuLmZpbHRlci1pdGVtX19sYWJlbCArICpbZGF0YS12LTY2OWFjNDQyXSB7XFxuICBtYXJnaW4tdG9wOiA1cHggIWltcG9ydGFudDtcXG59XFxuXCIsIFwiXCIsIHtcInZlcnNpb25cIjozLFwic291cmNlc1wiOltcIi9ob21lL21hbmp1bC9Qcm9qZWN0cy9mbG9vci1tYW5hZ2VtZW50L3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlckl0ZW0udnVlXCJdLFwibmFtZXNcIjpbXSxcIm1hcHBpbmdzXCI6XCI7QUFvREE7RUFDQSxhQUFBO0NBQ0E7QUFFQTtFQUNBLDJCQUFBO0NBQ0FcIixcImZpbGVcIjpcIkZpbHRlckl0ZW0udnVlXCIsXCJzb3VyY2VzQ29udGVudFwiOltcIjx0ZW1wbGF0ZT5cXG4gIDxkaXYgY2xhc3M9XFxcImZpbHRlci1pdGVtIGFnLWZsZXggYWctZmxleC1jb2x1bW5cXFwiPlxcbiAgICA8ZGl2IGNsYXNzPVxcXCJhZy1mbGV4IGFnLWFsaWduLWNlbnRlciBmaWx0ZXItaXRlbV9fbGFiZWxcXFwiPlxcbiAgICAgIDxsYWJlbCBjbGFzcz1cXFwiYWctZmxleFxcXCI+XFxuICAgICAgICA8aW5wdXRcXG4gICAgICAgICAgdHlwZT1cXFwicmFkaW9cXFwiXFxuICAgICAgICAgIGNsYXNzPVxcXCJjb2wtaHItMVxcXCJcXG4gICAgICAgICAgOnZhbHVlPVxcXCJvcGVyYXRvci5pZFxcXCJcXG4gICAgICAgICAgOmNoZWNrZWQ9XFxcImlzQ2hlY2tlZFxcXCJcXG4gICAgICAgICAgQGlucHV0PVxcXCIkZW1pdCgnaW5wdXQnLCAkZXZlbnQudGFyZ2V0LnZhbHVlKVxcXCJcXG4gICAgICAgIC8+XFxuICAgICAgICB7eyBvcGVyYXRvci52YWx1ZSB9fVxcbiAgICAgIDwvbGFiZWw+XFxuICAgIDwvZGl2PlxcbiAgICA8c2xvdD48L3Nsb3Q+XFxuICA8L2Rpdj5cXG48L3RlbXBsYXRlPlxcblxcbjxzY3JpcHQ+XFxuICBpbXBvcnQgZ2V0IGZyb20gJ2xvZGFzaC9mcC9nZXQnO1xcblxcbiAgZXhwb3J0IGRlZmF1bHQge1xcbiAgICBuYW1lOiAnRmlsdGVySXRlbScsXFxuICAgIHByb3BzOiB7XFxuICAgICAgb3BlcmF0b3I6IHtcXG4gICAgICAgIHR5cGU6IE9iamVjdCxcXG4gICAgICAgIHJlcXVpcmVkOiB0cnVlLFxcbiAgICAgIH0sXFxuICAgICAgaXNDaGVja2VkOiB7XFxuICAgICAgICB0eXBlOiBCb29sZWFuLFxcbiAgICAgIH0sXFxuICAgIH0sXFxuICAgIHdhdGNoOiB7XFxuICAgICAgaXNDaGVja2VkOiB7XFxuICAgICAgICBpbW1lZGlhdGU6IHRydWUsXFxuICAgICAgICBoYW5kbGVyKHZhbCwgb2xkVmFsKSB7XFxuICAgICAgICAgIGlmICh2YWwgJiYgKHZhbCAhPT0gb2xkVmFsKSkge1xcbiAgICAgICAgICAgIHRoaXMuJG5leHRUaWNrKCgpID0+IHtcXG4gICAgICAgICAgICAgIC8vIEBUT0RPOiBuZWVkIHRvIHJlZmFjdG9yIGluIGNhc2Ugb2YgVnVlIGpzIHVwZGF0ZSB0byAyLjYgb3IgYWJvdmVcXG4gICAgICAgICAgICAgIGNvbnN0IGVsbSA9IGdldCgnZGVmYXVsdFswXS5lbG0nKSh0aGlzLiRzbG90cyk7XFxuICAgICAgICAgICAgICBpZiAoZWxtICYmIGVsbS5mb2N1cykge1xcbiAgICAgICAgICAgICAgICBlbG0uZm9jdXMoKTtcXG4gICAgICAgICAgICAgIH1cXG4gICAgICAgICAgICB9KTtcXG4gICAgICAgICAgfVxcbiAgICAgICAgfSxcXG4gICAgICB9LFxcbiAgICB9LFxcbiAgfTtcXG48L3NjcmlwdD5cXG5cXG48c3R5bGUgc2NvcGVkPlxcbiAgLmZpbHRlci1pdGVtIHtcXG4gICAgbWFyZ2luOiAxcmVtO1xcbiAgfVxcblxcbiAgLmZpbHRlci1pdGVtX19sYWJlbCArICoge1xcbiAgICBtYXJnaW4tdG9wOiA1cHggIWltcG9ydGFudDtcXG4gIH1cXG48L3N0eWxlPlxcblwiXSxcInNvdXJjZVJvb3RcIjpcIlwifV0pO1xuXG4vLyBleHBvcnRzXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyP3NvdXJjZU1hcCEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlcj97XCJ2dWVcIjp0cnVlLFwiaWRcIjpcImRhdGEtdi02NjlhYzQ0MlwiLFwic2NvcGVkXCI6dHJ1ZSxcImhhc0lubGluZUNvbmZpZ1wiOnRydWV9IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJJdGVtLnZ1ZVxuLy8gbW9kdWxlIGlkID0gLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXIvaW5kZXguanM/e1widnVlXCI6dHJ1ZSxcImlkXCI6XCJkYXRhLXYtNjY5YWM0NDJcIixcInNjb3BlZFwiOnRydWUsXCJoYXNJbmxpbmVDb25maWdcIjp0cnVlfSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVySXRlbS52dWVcbi8vIG1vZHVsZSBjaHVua3MgPSA2IDcgOCA5IiwiZXhwb3J0cyA9IG1vZHVsZS5leHBvcnRzID0gcmVxdWlyZShcIi4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyL2xpYi9jc3MtYmFzZS5qc1wiKSh0cnVlKTtcbi8vIGltcG9ydHNcblxuXG4vLyBtb2R1bGVcbmV4cG9ydHMucHVzaChbbW9kdWxlLmlkLCBcIlxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblxcblwiLCBcIlwiLCB7XCJ2ZXJzaW9uXCI6MyxcInNvdXJjZXNcIjpbXSxcIm5hbWVzXCI6W10sXCJtYXBwaW5nc1wiOlwiXCIsXCJmaWxlXCI6XCJGaWx0ZXJTdHJpbmcudnVlXCIsXCJzb3VyY2VSb290XCI6XCJcIn1dKTtcblxuLy8gZXhwb3J0c1xuXG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlcj9zb3VyY2VNYXAhLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXI/e1widnVlXCI6dHJ1ZSxcImlkXCI6XCJkYXRhLXYtODJkZDU2OWFcIixcInNjb3BlZFwiOnRydWUsXCJoYXNJbmxpbmVDb25maWdcIjp0cnVlfSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyU3RyaW5nLnZ1ZVxuLy8gbW9kdWxlIGlkID0gLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXIvaW5kZXguanM/e1widnVlXCI6dHJ1ZSxcImlkXCI6XCJkYXRhLXYtODJkZDU2OWFcIixcInNjb3BlZFwiOnRydWUsXCJoYXNJbmxpbmVDb25maWdcIjp0cnVlfSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyU3RyaW5nLnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDYiLCJ2YXIgcmVuZGVyID0gZnVuY3Rpb24oKSB7XG4gIHZhciBfdm0gPSB0aGlzXG4gIHZhciBfaCA9IF92bS4kY3JlYXRlRWxlbWVudFxuICB2YXIgX2MgPSBfdm0uX3NlbGYuX2MgfHwgX2hcbiAgcmV0dXJuIF9jKFxuICAgIFwic3BhblwiLFxuICAgIF92bS5fbChfdm0ub3BlcmF0b3JzLCBmdW5jdGlvbihvcGVyYXRvck9iaikge1xuICAgICAgcmV0dXJuIF9jKFxuICAgICAgICBcImZpbHRlci1pdGVtXCIsXG4gICAgICAgIHtcbiAgICAgICAgICBrZXk6IG9wZXJhdG9yT2JqLmlkICsgXCItXCIgKyBfdm0uZ2V0Q29tcG9uZW50S2V5KCksXG4gICAgICAgICAgYXR0cnM6IHtcbiAgICAgICAgICAgIG9wZXJhdG9yOiBvcGVyYXRvck9iaixcbiAgICAgICAgICAgIFwiaXMtY2hlY2tlZFwiOiBvcGVyYXRvck9iai5pZCA9PT0gX3ZtLm9wZXJhdG9yXG4gICAgICAgICAgfSxcbiAgICAgICAgICBvbjoge1xuICAgICAgICAgICAgaW5wdXQ6IGZ1bmN0aW9uKCRldmVudCkge1xuICAgICAgICAgICAgICBfdm0uJGVtaXQoXCJ1cGRhdGU6b3BlcmF0b3JcIiwgJGV2ZW50KVxuICAgICAgICAgICAgfVxuICAgICAgICAgIH1cbiAgICAgICAgfSxcbiAgICAgICAgW192bS5fdChcImRlZmF1bHRcIiwgbnVsbCwgeyBvcGVyYXRvcjogb3BlcmF0b3JPYmogfSldLFxuICAgICAgICAyXG4gICAgICApXG4gICAgfSksXG4gICAgMVxuICApXG59XG52YXIgc3RhdGljUmVuZGVyRm5zID0gW11cbnJlbmRlci5fd2l0aFN0cmlwcGVkID0gdHJ1ZVxubW9kdWxlLmV4cG9ydHMgPSB7IHJlbmRlcjogcmVuZGVyLCBzdGF0aWNSZW5kZXJGbnM6IHN0YXRpY1JlbmRlckZucyB9XG5pZiAobW9kdWxlLmhvdCkge1xuICBtb2R1bGUuaG90LmFjY2VwdCgpXG4gIGlmIChtb2R1bGUuaG90LmRhdGEpIHtcbiAgICByZXF1aXJlKFwidnVlLWhvdC1yZWxvYWQtYXBpXCIpICAgICAgLnJlcmVuZGVyKFwiZGF0YS12LTVlMzM0Njg2XCIsIG1vZHVsZS5leHBvcnRzKVxuICB9XG59XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvdGVtcGxhdGUtY29tcGlsZXI/e1wiaWRcIjpcImRhdGEtdi01ZTMzNDY4NlwiLFwiaGFzU2NvcGVkXCI6dHJ1ZSxcImJ1YmxlXCI6e1widHJhbnNmb3Jtc1wiOnt9fX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyVHlwZS52dWVcbi8vIG1vZHVsZSBpZCA9IC4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3RlbXBsYXRlLWNvbXBpbGVyL2luZGV4LmpzP3tcImlkXCI6XCJkYXRhLXYtNWUzMzQ2ODZcIixcImhhc1Njb3BlZFwiOnRydWUsXCJidWJsZVwiOntcInRyYW5zZm9ybXNcIjp7fX19IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9dGVtcGxhdGUmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlclR5cGUudnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gNiA3IDggOSIsInZhciByZW5kZXIgPSBmdW5jdGlvbigpIHtcbiAgdmFyIF92bSA9IHRoaXNcbiAgdmFyIF9oID0gX3ZtLiRjcmVhdGVFbGVtZW50XG4gIHZhciBfYyA9IF92bS5fc2VsZi5fYyB8fCBfaFxuICByZXR1cm4gX2MoXG4gICAgXCJkaXZcIixcbiAgICB7IHN0YXRpY0NsYXNzOiBcImZpbHRlci1pdGVtIGFnLWZsZXggYWctZmxleC1jb2x1bW5cIiB9LFxuICAgIFtcbiAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwiYWctZmxleCBhZy1hbGlnbi1jZW50ZXIgZmlsdGVyLWl0ZW1fX2xhYmVsXCIgfSwgW1xuICAgICAgICBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiYWctZmxleFwiIH0sIFtcbiAgICAgICAgICBfYyhcImlucHV0XCIsIHtcbiAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImNvbC1oci0xXCIsXG4gICAgICAgICAgICBhdHRyczogeyB0eXBlOiBcInJhZGlvXCIgfSxcbiAgICAgICAgICAgIGRvbVByb3BzOiB7IHZhbHVlOiBfdm0ub3BlcmF0b3IuaWQsIGNoZWNrZWQ6IF92bS5pc0NoZWNrZWQgfSxcbiAgICAgICAgICAgIG9uOiB7XG4gICAgICAgICAgICAgIGlucHV0OiBmdW5jdGlvbigkZXZlbnQpIHtcbiAgICAgICAgICAgICAgICBfdm0uJGVtaXQoXCJpbnB1dFwiLCAkZXZlbnQudGFyZ2V0LnZhbHVlKVxuICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgICAgfSksXG4gICAgICAgICAgX3ZtLl92KFwiXFxuICAgICAgXCIgKyBfdm0uX3MoX3ZtLm9wZXJhdG9yLnZhbHVlKSArIFwiXFxuICAgIFwiKVxuICAgICAgICBdKVxuICAgICAgXSksXG4gICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgX3ZtLl90KFwiZGVmYXVsdFwiKVxuICAgIF0sXG4gICAgMlxuICApXG59XG52YXIgc3RhdGljUmVuZGVyRm5zID0gW11cbnJlbmRlci5fd2l0aFN0cmlwcGVkID0gdHJ1ZVxubW9kdWxlLmV4cG9ydHMgPSB7IHJlbmRlcjogcmVuZGVyLCBzdGF0aWNSZW5kZXJGbnM6IHN0YXRpY1JlbmRlckZucyB9XG5pZiAobW9kdWxlLmhvdCkge1xuICBtb2R1bGUuaG90LmFjY2VwdCgpXG4gIGlmIChtb2R1bGUuaG90LmRhdGEpIHtcbiAgICByZXF1aXJlKFwidnVlLWhvdC1yZWxvYWQtYXBpXCIpICAgICAgLnJlcmVuZGVyKFwiZGF0YS12LTY2OWFjNDQyXCIsIG1vZHVsZS5leHBvcnRzKVxuICB9XG59XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvdGVtcGxhdGUtY29tcGlsZXI/e1wiaWRcIjpcImRhdGEtdi02NjlhYzQ0MlwiLFwiaGFzU2NvcGVkXCI6dHJ1ZSxcImJ1YmxlXCI6e1widHJhbnNmb3Jtc1wiOnt9fX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVySXRlbS52dWVcbi8vIG1vZHVsZSBpZCA9IC4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3RlbXBsYXRlLWNvbXBpbGVyL2luZGV4LmpzP3tcImlkXCI6XCJkYXRhLXYtNjY5YWM0NDJcIixcImhhc1Njb3BlZFwiOnRydWUsXCJidWJsZVwiOntcInRyYW5zZm9ybXNcIjp7fX19IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9dGVtcGxhdGUmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlckl0ZW0udnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gNiA3IDggOSIsInZhciByZW5kZXIgPSBmdW5jdGlvbigpIHtcbiAgdmFyIF92bSA9IHRoaXNcbiAgdmFyIF9oID0gX3ZtLiRjcmVhdGVFbGVtZW50XG4gIHZhciBfYyA9IF92bS5fc2VsZi5fYyB8fCBfaFxuICByZXR1cm4gX2MoXCJmaWx0ZXItdHlwZVwiLCB7XG4gICAgYXR0cnM6IHsgb3BlcmF0b3JzOiBfdm0uJG9wdGlvbnMuT1BFUkFUT1JTLCBvcGVyYXRvcjogX3ZtLm9wZXJhdG9yIH0sXG4gICAgb246IHtcbiAgICAgIFwidXBkYXRlOm9wZXJhdG9yXCI6IGZ1bmN0aW9uKCRldmVudCkge1xuICAgICAgICBfdm0ub3BlcmF0b3IgPSAkZXZlbnRcbiAgICAgIH1cbiAgICB9LFxuICAgIHNjb3BlZFNsb3RzOiBfdm0uX3UoW1xuICAgICAge1xuICAgICAgICBrZXk6IFwiZGVmYXVsdFwiLFxuICAgICAgICBmbjogZnVuY3Rpb24ocmVmKSB7XG4gICAgICAgICAgdmFyIG9wZXJhdG9yT2JqID0gcmVmLm9wZXJhdG9yXG4gICAgICAgICAgcmV0dXJuIF9jKFwiaW5wdXRcIiwge1xuICAgICAgICAgICAgZGlyZWN0aXZlczogW1xuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgbmFtZTogXCJzaG93XCIsXG4gICAgICAgICAgICAgICAgcmF3TmFtZTogXCJ2LXNob3dcIixcbiAgICAgICAgICAgICAgICB2YWx1ZTogX3ZtLnNob3dJbnB1dChvcGVyYXRvck9iaiksXG4gICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJzaG93SW5wdXQob3BlcmF0b3JPYmopXCJcbiAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIGF0dHJzOiB7IHR5cGU6IFwidGV4dFwiIH0sXG4gICAgICAgICAgICBkb21Qcm9wczogeyB2YWx1ZTogX3ZtLnZhbHVlIH0sXG4gICAgICAgICAgICBvbjoge1xuICAgICAgICAgICAgICBpbnB1dDogZnVuY3Rpb24oJGV2ZW50KSB7XG4gICAgICAgICAgICAgICAgX3ZtLnZhbHVlID0gJGV2ZW50LnRhcmdldC52YWx1ZS50b0xvd2VyQ2FzZSgpXG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9KVxuICAgICAgICB9XG4gICAgICB9XG4gICAgXSlcbiAgfSlcbn1cbnZhciBzdGF0aWNSZW5kZXJGbnMgPSBbXVxucmVuZGVyLl93aXRoU3RyaXBwZWQgPSB0cnVlXG5tb2R1bGUuZXhwb3J0cyA9IHsgcmVuZGVyOiByZW5kZXIsIHN0YXRpY1JlbmRlckZuczogc3RhdGljUmVuZGVyRm5zIH1cbmlmIChtb2R1bGUuaG90KSB7XG4gIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgaWYgKG1vZHVsZS5ob3QuZGF0YSkge1xuICAgIHJlcXVpcmUoXCJ2dWUtaG90LXJlbG9hZC1hcGlcIikgICAgICAucmVyZW5kZXIoXCJkYXRhLXYtODJkZDU2OWFcIiwgbW9kdWxlLmV4cG9ydHMpXG4gIH1cbn1cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlcj97XCJpZFwiOlwiZGF0YS12LTgyZGQ1NjlhXCIsXCJoYXNTY29wZWRcIjp0cnVlLFwiYnVibGVcIjp7XCJ0cmFuc2Zvcm1zXCI6e319fSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXRlbXBsYXRlJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTdHJpbmcudnVlXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlci9pbmRleC5qcz97XCJpZFwiOlwiZGF0YS12LTgyZGQ1NjlhXCIsXCJoYXNTY29wZWRcIjp0cnVlLFwiYnVibGVcIjp7XCJ0cmFuc2Zvcm1zXCI6e319fSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXRlbXBsYXRlJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTdHJpbmcudnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gNiIsIi8vIHN0eWxlLWxvYWRlcjogQWRkcyBzb21lIGNzcyB0byB0aGUgRE9NIGJ5IGFkZGluZyBhIDxzdHlsZT4gdGFnXG5cbi8vIGxvYWQgdGhlIHN0eWxlc1xudmFyIGNvbnRlbnQgPSByZXF1aXJlKFwiISEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi01ZTMzNDY4NlxcXCIsXFxcInNjb3BlZFxcXCI6dHJ1ZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlclR5cGUudnVlXCIpO1xuaWYodHlwZW9mIGNvbnRlbnQgPT09ICdzdHJpbmcnKSBjb250ZW50ID0gW1ttb2R1bGUuaWQsIGNvbnRlbnQsICcnXV07XG5pZihjb250ZW50LmxvY2FscykgbW9kdWxlLmV4cG9ydHMgPSBjb250ZW50LmxvY2Fscztcbi8vIGFkZCB0aGUgc3R5bGVzIHRvIHRoZSBET01cbnZhciB1cGRhdGUgPSByZXF1aXJlKFwiIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyL2xpYi9hZGRTdHlsZXNDbGllbnQuanNcIikoXCI5Yjg1Njk4MlwiLCBjb250ZW50LCBmYWxzZSwge30pO1xuLy8gSG90IE1vZHVsZSBSZXBsYWNlbWVudFxuaWYobW9kdWxlLmhvdCkge1xuIC8vIFdoZW4gdGhlIHN0eWxlcyBjaGFuZ2UsIHVwZGF0ZSB0aGUgPHN0eWxlPiB0YWdzXG4gaWYoIWNvbnRlbnQubG9jYWxzKSB7XG4gICBtb2R1bGUuaG90LmFjY2VwdChcIiEhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtNWUzMzQ2ODZcXFwiLFxcXCJzY29wZWRcXFwiOnRydWUsXFxcImhhc0lubGluZUNvbmZpZ1xcXCI6dHJ1ZX0hLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9GaWx0ZXJUeXBlLnZ1ZVwiLCBmdW5jdGlvbigpIHtcbiAgICAgdmFyIG5ld0NvbnRlbnQgPSByZXF1aXJlKFwiISEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi01ZTMzNDY4NlxcXCIsXFxcInNjb3BlZFxcXCI6dHJ1ZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlclR5cGUudnVlXCIpO1xuICAgICBpZih0eXBlb2YgbmV3Q29udGVudCA9PT0gJ3N0cmluZycpIG5ld0NvbnRlbnQgPSBbW21vZHVsZS5pZCwgbmV3Q29udGVudCwgJyddXTtcbiAgICAgdXBkYXRlKG5ld0NvbnRlbnQpO1xuICAgfSk7XG4gfVxuIC8vIFdoZW4gdGhlIG1vZHVsZSBpcyBkaXNwb3NlZCwgcmVtb3ZlIHRoZSA8c3R5bGU+IHRhZ3NcbiBtb2R1bGUuaG90LmRpc3Bvc2UoZnVuY3Rpb24oKSB7IHVwZGF0ZSgpOyB9KTtcbn1cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyIS4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXI/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LTVlMzM0Njg2XCIsXCJzY29wZWRcIjp0cnVlLFwiaGFzSW5saW5lQ29uZmlnXCI6dHJ1ZX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlclR5cGUudnVlXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyL2luZGV4LmpzIS4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LTVlMzM0Njg2XCIsXCJzY29wZWRcIjp0cnVlLFwiaGFzSW5saW5lQ29uZmlnXCI6dHJ1ZX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlclR5cGUudnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gNiA3IDggOSIsIi8vIHN0eWxlLWxvYWRlcjogQWRkcyBzb21lIGNzcyB0byB0aGUgRE9NIGJ5IGFkZGluZyBhIDxzdHlsZT4gdGFnXG5cbi8vIGxvYWQgdGhlIHN0eWxlc1xudmFyIGNvbnRlbnQgPSByZXF1aXJlKFwiISEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi02NjlhYzQ0MlxcXCIsXFxcInNjb3BlZFxcXCI6dHJ1ZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlckl0ZW0udnVlXCIpO1xuaWYodHlwZW9mIGNvbnRlbnQgPT09ICdzdHJpbmcnKSBjb250ZW50ID0gW1ttb2R1bGUuaWQsIGNvbnRlbnQsICcnXV07XG5pZihjb250ZW50LmxvY2FscykgbW9kdWxlLmV4cG9ydHMgPSBjb250ZW50LmxvY2Fscztcbi8vIGFkZCB0aGUgc3R5bGVzIHRvIHRoZSBET01cbnZhciB1cGRhdGUgPSByZXF1aXJlKFwiIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyL2xpYi9hZGRTdHlsZXNDbGllbnQuanNcIikoXCI2MWJiMzc0YVwiLCBjb250ZW50LCBmYWxzZSwge30pO1xuLy8gSG90IE1vZHVsZSBSZXBsYWNlbWVudFxuaWYobW9kdWxlLmhvdCkge1xuIC8vIFdoZW4gdGhlIHN0eWxlcyBjaGFuZ2UsIHVwZGF0ZSB0aGUgPHN0eWxlPiB0YWdzXG4gaWYoIWNvbnRlbnQubG9jYWxzKSB7XG4gICBtb2R1bGUuaG90LmFjY2VwdChcIiEhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtNjY5YWM0NDJcXFwiLFxcXCJzY29wZWRcXFwiOnRydWUsXFxcImhhc0lubGluZUNvbmZpZ1xcXCI6dHJ1ZX0hLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9GaWx0ZXJJdGVtLnZ1ZVwiLCBmdW5jdGlvbigpIHtcbiAgICAgdmFyIG5ld0NvbnRlbnQgPSByZXF1aXJlKFwiISEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi02NjlhYzQ0MlxcXCIsXFxcInNjb3BlZFxcXCI6dHJ1ZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlckl0ZW0udnVlXCIpO1xuICAgICBpZih0eXBlb2YgbmV3Q29udGVudCA9PT0gJ3N0cmluZycpIG5ld0NvbnRlbnQgPSBbW21vZHVsZS5pZCwgbmV3Q29udGVudCwgJyddXTtcbiAgICAgdXBkYXRlKG5ld0NvbnRlbnQpO1xuICAgfSk7XG4gfVxuIC8vIFdoZW4gdGhlIG1vZHVsZSBpcyBkaXNwb3NlZCwgcmVtb3ZlIHRoZSA8c3R5bGU+IHRhZ3NcbiBtb2R1bGUuaG90LmRpc3Bvc2UoZnVuY3Rpb24oKSB7IHVwZGF0ZSgpOyB9KTtcbn1cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyIS4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXI/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LTY2OWFjNDQyXCIsXCJzY29wZWRcIjp0cnVlLFwiaGFzSW5saW5lQ29uZmlnXCI6dHJ1ZX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlckl0ZW0udnVlXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyL2luZGV4LmpzIS4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LTY2OWFjNDQyXCIsXCJzY29wZWRcIjp0cnVlLFwiaGFzSW5saW5lQ29uZmlnXCI6dHJ1ZX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlckl0ZW0udnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gNiA3IDggOSIsIi8vIHN0eWxlLWxvYWRlcjogQWRkcyBzb21lIGNzcyB0byB0aGUgRE9NIGJ5IGFkZGluZyBhIDxzdHlsZT4gdGFnXG5cbi8vIGxvYWQgdGhlIHN0eWxlc1xudmFyIGNvbnRlbnQgPSByZXF1aXJlKFwiISEuLi8uLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi04MmRkNTY5YVxcXCIsXFxcInNjb3BlZFxcXCI6dHJ1ZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlclN0cmluZy52dWVcIik7XG5pZih0eXBlb2YgY29udGVudCA9PT0gJ3N0cmluZycpIGNvbnRlbnQgPSBbW21vZHVsZS5pZCwgY29udGVudCwgJyddXTtcbmlmKGNvbnRlbnQubG9jYWxzKSBtb2R1bGUuZXhwb3J0cyA9IGNvbnRlbnQubG9jYWxzO1xuLy8gYWRkIHRoZSBzdHlsZXMgdG8gdGhlIERPTVxudmFyIHVwZGF0ZSA9IHJlcXVpcmUoXCIhLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1zdHlsZS1sb2FkZXIvbGliL2FkZFN0eWxlc0NsaWVudC5qc1wiKShcIjI2YTMwZGQxXCIsIGNvbnRlbnQsIGZhbHNlLCB7fSk7XG4vLyBIb3QgTW9kdWxlIFJlcGxhY2VtZW50XG5pZihtb2R1bGUuaG90KSB7XG4gLy8gV2hlbiB0aGUgc3R5bGVzIGNoYW5nZSwgdXBkYXRlIHRoZSA8c3R5bGU+IHRhZ3NcbiBpZighY29udGVudC5sb2NhbHMpIHtcbiAgIG1vZHVsZS5ob3QuYWNjZXB0KFwiISEuLi8uLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi04MmRkNTY5YVxcXCIsXFxcInNjb3BlZFxcXCI6dHJ1ZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlclN0cmluZy52dWVcIiwgZnVuY3Rpb24oKSB7XG4gICAgIHZhciBuZXdDb250ZW50ID0gcmVxdWlyZShcIiEhLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtODJkZDU2OWFcXFwiLFxcXCJzY29wZWRcXFwiOnRydWUsXFxcImhhc0lubGluZUNvbmZpZ1xcXCI6dHJ1ZX0hLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9GaWx0ZXJTdHJpbmcudnVlXCIpO1xuICAgICBpZih0eXBlb2YgbmV3Q29udGVudCA9PT0gJ3N0cmluZycpIG5ld0NvbnRlbnQgPSBbW21vZHVsZS5pZCwgbmV3Q29udGVudCwgJyddXTtcbiAgICAgdXBkYXRlKG5ld0NvbnRlbnQpO1xuICAgfSk7XG4gfVxuIC8vIFdoZW4gdGhlIG1vZHVsZSBpcyBkaXNwb3NlZCwgcmVtb3ZlIHRoZSA8c3R5bGU+IHRhZ3NcbiBtb2R1bGUuaG90LmRpc3Bvc2UoZnVuY3Rpb24oKSB7IHVwZGF0ZSgpOyB9KTtcbn1cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyIS4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXI/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LTgyZGQ1NjlhXCIsXCJzY29wZWRcIjp0cnVlLFwiaGFzSW5saW5lQ29uZmlnXCI6dHJ1ZX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlclN0cmluZy52dWVcbi8vIG1vZHVsZSBpZCA9IC4vbm9kZV9tb2R1bGVzL3Z1ZS1zdHlsZS1sb2FkZXIvaW5kZXguanMhLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXIvaW5kZXguanM/e1widnVlXCI6dHJ1ZSxcImlkXCI6XCJkYXRhLXYtODJkZDU2OWFcIixcInNjb3BlZFwiOnRydWUsXCJoYXNJbmxpbmVDb25maWdcIjp0cnVlfSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyU3RyaW5nLnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDYiLCJ2YXIgZGlzcG9zZWQgPSBmYWxzZVxuZnVuY3Rpb24gaW5qZWN0U3R5bGUgKHNzckNvbnRleHQpIHtcbiAgaWYgKGRpc3Bvc2VkKSByZXR1cm5cbiAgcmVxdWlyZShcIiEhdnVlLXN0eWxlLWxvYWRlciFjc3MtbG9hZGVyP3NvdXJjZU1hcCEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXIvaW5kZXg/e1xcXCJ2dWVcXFwiOnRydWUsXFxcImlkXFxcIjpcXFwiZGF0YS12LTY2OWFjNDQyXFxcIixcXFwic2NvcGVkXFxcIjp0cnVlLFxcXCJoYXNJbmxpbmVDb25maWdcXFwiOnRydWV9IS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvcj90eXBlPXN0eWxlcyZpbmRleD0wIS4vRmlsdGVySXRlbS52dWVcIilcbn1cbnZhciBub3JtYWxpemVDb21wb25lbnQgPSByZXF1aXJlKFwiIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9jb21wb25lbnQtbm9ybWFsaXplclwiKVxuLyogc2NyaXB0ICovXG52YXIgX192dWVfc2NyaXB0X18gPSByZXF1aXJlKFwiISFiYWJlbC1sb2FkZXI/e1xcXCJjYWNoZURpcmVjdG9yeVxcXCI6dHJ1ZSxcXFwicHJlc2V0c1xcXCI6W1tcXFwiZW52XFxcIix7XFxcIm1vZHVsZXNcXFwiOmZhbHNlLFxcXCJ0YXJnZXRzXFxcIjp7XFxcImJyb3dzZXJzXFxcIjpbXFxcIj4gMiVcXFwiXSxcXFwidWdsaWZ5XFxcIjp0cnVlfX1dLFxcXCJiYWJlbC1wcmVzZXQtZW52XFxcIl0sXFxcInBsdWdpbnNcXFwiOltcXFwidHJhbnNmb3JtLW9iamVjdC1yZXN0LXNwcmVhZFxcXCIsW1xcXCJ0cmFuc2Zvcm0tcnVudGltZVxcXCIse1xcXCJwb2x5ZmlsbFxcXCI6ZmFsc2UsXFxcImhlbHBlcnNcXFwiOmZhbHNlfV0sXFxcInN5bnRheC1keW5hbWljLWltcG9ydFxcXCJdfSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT1zY3JpcHQmaW5kZXg9MCEuL0ZpbHRlckl0ZW0udnVlXCIpXG4vKiB0ZW1wbGF0ZSAqL1xudmFyIF9fdnVlX3RlbXBsYXRlX18gPSByZXF1aXJlKFwiISEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvdGVtcGxhdGUtY29tcGlsZXIvaW5kZXg/e1xcXCJpZFxcXCI6XFxcImRhdGEtdi02NjlhYzQ0MlxcXCIsXFxcImhhc1Njb3BlZFxcXCI6dHJ1ZSxcXFwiYnVibGVcXFwiOntcXFwidHJhbnNmb3Jtc1xcXCI6e319fSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vRmlsdGVySXRlbS52dWVcIilcbi8qIHRlbXBsYXRlIGZ1bmN0aW9uYWwgKi9cbnZhciBfX3Z1ZV90ZW1wbGF0ZV9mdW5jdGlvbmFsX18gPSBmYWxzZVxuLyogc3R5bGVzICovXG52YXIgX192dWVfc3R5bGVzX18gPSBpbmplY3RTdHlsZVxuLyogc2NvcGVJZCAqL1xudmFyIF9fdnVlX3Njb3BlSWRfXyA9IFwiZGF0YS12LTY2OWFjNDQyXCJcbi8qIG1vZHVsZUlkZW50aWZpZXIgKHNlcnZlciBvbmx5KSAqL1xudmFyIF9fdnVlX21vZHVsZV9pZGVudGlmaWVyX18gPSBudWxsXG52YXIgQ29tcG9uZW50ID0gbm9ybWFsaXplQ29tcG9uZW50KFxuICBfX3Z1ZV9zY3JpcHRfXyxcbiAgX192dWVfdGVtcGxhdGVfXyxcbiAgX192dWVfdGVtcGxhdGVfZnVuY3Rpb25hbF9fLFxuICBfX3Z1ZV9zdHlsZXNfXyxcbiAgX192dWVfc2NvcGVJZF9fLFxuICBfX3Z1ZV9tb2R1bGVfaWRlbnRpZmllcl9fXG4pXG5Db21wb25lbnQub3B0aW9ucy5fX2ZpbGUgPSBcInJlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlckl0ZW0udnVlXCJcblxuLyogaG90IHJlbG9hZCAqL1xuaWYgKG1vZHVsZS5ob3QpIHsoZnVuY3Rpb24gKCkge1xuICB2YXIgaG90QVBJID0gcmVxdWlyZShcInZ1ZS1ob3QtcmVsb2FkLWFwaVwiKVxuICBob3RBUEkuaW5zdGFsbChyZXF1aXJlKFwidnVlXCIpLCBmYWxzZSlcbiAgaWYgKCFob3RBUEkuY29tcGF0aWJsZSkgcmV0dXJuXG4gIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgaWYgKCFtb2R1bGUuaG90LmRhdGEpIHtcbiAgICBob3RBUEkuY3JlYXRlUmVjb3JkKFwiZGF0YS12LTY2OWFjNDQyXCIsIENvbXBvbmVudC5vcHRpb25zKVxuICB9IGVsc2Uge1xuICAgIGhvdEFQSS5yZWxvYWQoXCJkYXRhLXYtNjY5YWM0NDJcIiwgQ29tcG9uZW50Lm9wdGlvbnMpXG4gIH1cbiAgbW9kdWxlLmhvdC5kaXNwb3NlKGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgZGlzcG9zZWQgPSB0cnVlXG4gIH0pXG59KSgpfVxuXG5tb2R1bGUuZXhwb3J0cyA9IENvbXBvbmVudC5leHBvcnRzXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlckl0ZW0udnVlXG4vLyBtb2R1bGUgaWQgPSAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlckl0ZW0udnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gNiA3IDggOSIsInZhciBkaXNwb3NlZCA9IGZhbHNlXG5mdW5jdGlvbiBpbmplY3RTdHlsZSAoc3NyQ29udGV4dCkge1xuICBpZiAoZGlzcG9zZWQpIHJldHVyblxuICByZXF1aXJlKFwiISF2dWUtc3R5bGUtbG9hZGVyIWNzcy1sb2FkZXI/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleD97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtNWUzMzQ2ODZcXFwiLFxcXCJzY29wZWRcXFwiOnRydWUsXFxcImhhc0lubGluZUNvbmZpZ1xcXCI6dHJ1ZX0hLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9GaWx0ZXJUeXBlLnZ1ZVwiKVxufVxudmFyIG5vcm1hbGl6ZUNvbXBvbmVudCA9IHJlcXVpcmUoXCIhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2NvbXBvbmVudC1ub3JtYWxpemVyXCIpXG4vKiBzY3JpcHQgKi9cbnZhciBfX3Z1ZV9zY3JpcHRfXyA9IHJlcXVpcmUoXCIhIWJhYmVsLWxvYWRlcj97XFxcImNhY2hlRGlyZWN0b3J5XFxcIjp0cnVlLFxcXCJwcmVzZXRzXFxcIjpbW1xcXCJlbnZcXFwiLHtcXFwibW9kdWxlc1xcXCI6ZmFsc2UsXFxcInRhcmdldHNcXFwiOntcXFwiYnJvd3NlcnNcXFwiOltcXFwiPiAyJVxcXCJdLFxcXCJ1Z2xpZnlcXFwiOnRydWV9fV0sXFxcImJhYmVsLXByZXNldC1lbnZcXFwiXSxcXFwicGx1Z2luc1xcXCI6W1xcXCJ0cmFuc2Zvcm0tb2JqZWN0LXJlc3Qtc3ByZWFkXFxcIixbXFxcInRyYW5zZm9ybS1ydW50aW1lXFxcIix7XFxcInBvbHlmaWxsXFxcIjpmYWxzZSxcXFwiaGVscGVyc1xcXCI6ZmFsc2V9XSxcXFwic3ludGF4LWR5bmFtaWMtaW1wb3J0XFxcIl19IS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvcj90eXBlPXNjcmlwdCZpbmRleD0wIS4vRmlsdGVyVHlwZS52dWVcIilcbi8qIHRlbXBsYXRlICovXG52YXIgX192dWVfdGVtcGxhdGVfXyA9IHJlcXVpcmUoXCIhIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlci9pbmRleD97XFxcImlkXFxcIjpcXFwiZGF0YS12LTVlMzM0Njg2XFxcIixcXFwiaGFzU2NvcGVkXFxcIjp0cnVlLFxcXCJidWJsZVxcXCI6e1xcXCJ0cmFuc2Zvcm1zXFxcIjp7fX19IS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvcj90eXBlPXRlbXBsYXRlJmluZGV4PTAhLi9GaWx0ZXJUeXBlLnZ1ZVwiKVxuLyogdGVtcGxhdGUgZnVuY3Rpb25hbCAqL1xudmFyIF9fdnVlX3RlbXBsYXRlX2Z1bmN0aW9uYWxfXyA9IGZhbHNlXG4vKiBzdHlsZXMgKi9cbnZhciBfX3Z1ZV9zdHlsZXNfXyA9IGluamVjdFN0eWxlXG4vKiBzY29wZUlkICovXG52YXIgX192dWVfc2NvcGVJZF9fID0gXCJkYXRhLXYtNWUzMzQ2ODZcIlxuLyogbW9kdWxlSWRlbnRpZmllciAoc2VydmVyIG9ubHkpICovXG52YXIgX192dWVfbW9kdWxlX2lkZW50aWZpZXJfXyA9IG51bGxcbnZhciBDb21wb25lbnQgPSBub3JtYWxpemVDb21wb25lbnQoXG4gIF9fdnVlX3NjcmlwdF9fLFxuICBfX3Z1ZV90ZW1wbGF0ZV9fLFxuICBfX3Z1ZV90ZW1wbGF0ZV9mdW5jdGlvbmFsX18sXG4gIF9fdnVlX3N0eWxlc19fLFxuICBfX3Z1ZV9zY29wZUlkX18sXG4gIF9fdnVlX21vZHVsZV9pZGVudGlmaWVyX19cbilcbkNvbXBvbmVudC5vcHRpb25zLl9fZmlsZSA9IFwicmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyVHlwZS52dWVcIlxuXG4vKiBob3QgcmVsb2FkICovXG5pZiAobW9kdWxlLmhvdCkgeyhmdW5jdGlvbiAoKSB7XG4gIHZhciBob3RBUEkgPSByZXF1aXJlKFwidnVlLWhvdC1yZWxvYWQtYXBpXCIpXG4gIGhvdEFQSS5pbnN0YWxsKHJlcXVpcmUoXCJ2dWVcIiksIGZhbHNlKVxuICBpZiAoIWhvdEFQSS5jb21wYXRpYmxlKSByZXR1cm5cbiAgbW9kdWxlLmhvdC5hY2NlcHQoKVxuICBpZiAoIW1vZHVsZS5ob3QuZGF0YSkge1xuICAgIGhvdEFQSS5jcmVhdGVSZWNvcmQoXCJkYXRhLXYtNWUzMzQ2ODZcIiwgQ29tcG9uZW50Lm9wdGlvbnMpXG4gIH0gZWxzZSB7XG4gICAgaG90QVBJLnJlbG9hZChcImRhdGEtdi01ZTMzNDY4NlwiLCBDb21wb25lbnQub3B0aW9ucylcbiAgfVxuICBtb2R1bGUuaG90LmRpc3Bvc2UoZnVuY3Rpb24gKGRhdGEpIHtcbiAgICBkaXNwb3NlZCA9IHRydWVcbiAgfSlcbn0pKCl9XG5cbm1vZHVsZS5leHBvcnRzID0gQ29tcG9uZW50LmV4cG9ydHNcblxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyVHlwZS52dWVcbi8vIG1vZHVsZSBpZCA9IC4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyVHlwZS52dWVcbi8vIG1vZHVsZSBjaHVua3MgPSA2IDcgOCA5IiwiaW1wb3J0IEZpbHRlclR5cGUgZnJvbSAnLi9GaWx0ZXJUeXBlLnZ1ZSc7XG5cbmV4cG9ydCBkZWZhdWx0IHtcbiAgY29tcG9uZW50czoge1xuICAgIEZpbHRlclR5cGUsXG4gIH0sXG4gIHByb3BzOiB7XG4gICAgZmlsdGVyOiB7XG4gICAgICB0eXBlOiBPYmplY3QsXG4gICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICB9LFxuICB9LFxuICBkYXRhOiAoKSA9PiAoe1xuICAgIG9wZXJhdG9yOiAnJyxcbiAgICB2YWx1ZTogJycsXG4gIH0pLFxuICB3YXRjaDoge1xuICAgIG9wZXJhdG9yKG5ld1ZhbHVlLCBvbGRWYWx1ZSkge1xuICAgICAgaWYgKG5ld1ZhbHVlICE9PSBvbGRWYWx1ZSkge1xuICAgICAgICB0aGlzLmVtaXRVcGRhdGUoKTtcbiAgICAgIH1cbiAgICB9LFxuICAgIHZhbHVlKG5ld1ZhbHVlLCBvbGRWYWx1ZSkge1xuICAgICAgaWYgKG5ld1ZhbHVlICE9PSBvbGRWYWx1ZSkge1xuICAgICAgICB0aGlzLmVtaXRVcGRhdGUoKTtcbiAgICAgIH1cbiAgICB9LFxuICB9LFxuICBjcmVhdGVkKCkge1xuICAgIHRoaXMub3BlcmF0b3IgPSB0aGlzLmZpbHRlci5vcGVyYXRvciB8fCAnZXF1YWxzJztcbiAgICB0aGlzLnZhbHVlID0gdGhpcy5maWx0ZXIudmFsdWUgfHwgbnVsbDtcbiAgfSxcbiAgbWV0aG9kczoge1xuICAgIGVtaXRVcGRhdGUoKSB7XG4gICAgICBpZiAodGhpcy5vcGVyYXRvcikge1xuICAgICAgICB0aGlzLiRlbWl0KCd1cGRhdGUnLCB7XG4gICAgICAgICAgb3BlcmF0b3I6IHRoaXMub3BlcmF0b3IsXG4gICAgICAgICAgdmFsdWU6IHRoaXMudmFsdWUsXG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgIH0sXG4gIH0sXG59O1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyVHlwZU1peGluLmpzIiwidmFyIGRpc3Bvc2VkID0gZmFsc2VcbmZ1bmN0aW9uIGluamVjdFN0eWxlIChzc3JDb250ZXh0KSB7XG4gIGlmIChkaXNwb3NlZCkgcmV0dXJuXG4gIHJlcXVpcmUoXCIhIXZ1ZS1zdHlsZS1sb2FkZXIhY3NzLWxvYWRlcj9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4P3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi04MmRkNTY5YVxcXCIsXFxcInNjb3BlZFxcXCI6dHJ1ZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlclN0cmluZy52dWVcIilcbn1cbnZhciBub3JtYWxpemVDb21wb25lbnQgPSByZXF1aXJlKFwiIS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9jb21wb25lbnQtbm9ybWFsaXplclwiKVxuLyogc2NyaXB0ICovXG52YXIgX192dWVfc2NyaXB0X18gPSByZXF1aXJlKFwiISFiYWJlbC1sb2FkZXI/e1xcXCJjYWNoZURpcmVjdG9yeVxcXCI6dHJ1ZSxcXFwicHJlc2V0c1xcXCI6W1tcXFwiZW52XFxcIix7XFxcIm1vZHVsZXNcXFwiOmZhbHNlLFxcXCJ0YXJnZXRzXFxcIjp7XFxcImJyb3dzZXJzXFxcIjpbXFxcIj4gMiVcXFwiXSxcXFwidWdsaWZ5XFxcIjp0cnVlfX1dLFxcXCJiYWJlbC1wcmVzZXQtZW52XFxcIl0sXFxcInBsdWdpbnNcXFwiOltcXFwidHJhbnNmb3JtLW9iamVjdC1yZXN0LXNwcmVhZFxcXCIsW1xcXCJ0cmFuc2Zvcm0tcnVudGltZVxcXCIse1xcXCJwb2x5ZmlsbFxcXCI6ZmFsc2UsXFxcImhlbHBlcnNcXFwiOmZhbHNlfV0sXFxcInN5bnRheC1keW5hbWljLWltcG9ydFxcXCJdfSEuLi8uLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT1zY3JpcHQmaW5kZXg9MCEuL0ZpbHRlclN0cmluZy52dWVcIilcbi8qIHRlbXBsYXRlICovXG52YXIgX192dWVfdGVtcGxhdGVfXyA9IHJlcXVpcmUoXCIhIS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlci9pbmRleD97XFxcImlkXFxcIjpcXFwiZGF0YS12LTgyZGQ1NjlhXFxcIixcXFwiaGFzU2NvcGVkXFxcIjp0cnVlLFxcXCJidWJsZVxcXCI6e1xcXCJ0cmFuc2Zvcm1zXFxcIjp7fX19IS4uLy4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvcj90eXBlPXRlbXBsYXRlJmluZGV4PTAhLi9GaWx0ZXJTdHJpbmcudnVlXCIpXG4vKiB0ZW1wbGF0ZSBmdW5jdGlvbmFsICovXG52YXIgX192dWVfdGVtcGxhdGVfZnVuY3Rpb25hbF9fID0gZmFsc2Vcbi8qIHN0eWxlcyAqL1xudmFyIF9fdnVlX3N0eWxlc19fID0gaW5qZWN0U3R5bGVcbi8qIHNjb3BlSWQgKi9cbnZhciBfX3Z1ZV9zY29wZUlkX18gPSBcImRhdGEtdi04MmRkNTY5YVwiXG4vKiBtb2R1bGVJZGVudGlmaWVyIChzZXJ2ZXIgb25seSkgKi9cbnZhciBfX3Z1ZV9tb2R1bGVfaWRlbnRpZmllcl9fID0gbnVsbFxudmFyIENvbXBvbmVudCA9IG5vcm1hbGl6ZUNvbXBvbmVudChcbiAgX192dWVfc2NyaXB0X18sXG4gIF9fdnVlX3RlbXBsYXRlX18sXG4gIF9fdnVlX3RlbXBsYXRlX2Z1bmN0aW9uYWxfXyxcbiAgX192dWVfc3R5bGVzX18sXG4gIF9fdnVlX3Njb3BlSWRfXyxcbiAgX192dWVfbW9kdWxlX2lkZW50aWZpZXJfX1xuKVxuQ29tcG9uZW50Lm9wdGlvbnMuX19maWxlID0gXCJyZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTdHJpbmcudnVlXCJcblxuLyogaG90IHJlbG9hZCAqL1xuaWYgKG1vZHVsZS5ob3QpIHsoZnVuY3Rpb24gKCkge1xuICB2YXIgaG90QVBJID0gcmVxdWlyZShcInZ1ZS1ob3QtcmVsb2FkLWFwaVwiKVxuICBob3RBUEkuaW5zdGFsbChyZXF1aXJlKFwidnVlXCIpLCBmYWxzZSlcbiAgaWYgKCFob3RBUEkuY29tcGF0aWJsZSkgcmV0dXJuXG4gIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgaWYgKCFtb2R1bGUuaG90LmRhdGEpIHtcbiAgICBob3RBUEkuY3JlYXRlUmVjb3JkKFwiZGF0YS12LTgyZGQ1NjlhXCIsIENvbXBvbmVudC5vcHRpb25zKVxuICB9IGVsc2Uge1xuICAgIGhvdEFQSS5yZWxvYWQoXCJkYXRhLXYtODJkZDU2OWFcIiwgQ29tcG9uZW50Lm9wdGlvbnMpXG4gIH1cbiAgbW9kdWxlLmhvdC5kaXNwb3NlKGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgZGlzcG9zZWQgPSB0cnVlXG4gIH0pXG59KSgpfVxuXG5tb2R1bGUuZXhwb3J0cyA9IENvbXBvbmVudC5leHBvcnRzXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlclN0cmluZy52dWVcbi8vIG1vZHVsZSBpZCA9IC4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyU3RyaW5nLnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDYiXSwic291cmNlUm9vdCI6IiJ9