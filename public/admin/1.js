webpackJsonp([1],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/FilterMenu.vue":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; //
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

var _FmIcon = __webpack_require__("./resources/assets/domain/common/components/functional/FmIcon.js");

var _FmIcon2 = _interopRequireDefault(_FmIcon);

var _humanizedOperator = __webpack_require__("./resources/assets/domain/common/components/fmFilter/const/humanizedOperator.js");

var _humanizedOperator2 = _interopRequireDefault(_humanizedOperator);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var HUMANIZED_OPERATOR_MAP = new Map();
_humanizedOperator2.default.forEach(function (operator) {
  return HUMANIZED_OPERATOR_MAP.set(operator.id, operator.value, operator.message);
});

var OPERATOR_MESSAGE_MAP = new Map();
_humanizedOperator2.default.forEach(function (operator) {
  return OPERATOR_MESSAGE_MAP.set(operator.id, operator.message);
});

exports.default = {
  name: 'FilterMenu',
  components: {
    FmIcon: _FmIcon2.default
  },
  props: {
    filter: {
      type: Object,
      required: true
    }
  },
  data: function data() {
    return {
      visible: true
    };
  },
  computed: {
    currentFilterType: function currentFilterType() {
      var _this = this;

      return function () {
        return __webpack_require__("./resources/assets/domain/common/components/fmFilter/types lazy recursive ^\\.\\/Filter.*$")("./Filter" + _this.filter.type);
      };
    },
    showError: function showError() {
      return !this.filter.value && !this.visible;
    },
    humanizedOperatorValue: function humanizedOperatorValue() {
      var value = this.filter.value || '';
      var operator = HUMANIZED_OPERATOR_MAP.get(this.filter.operator) || '';
      var operatorMessage = OPERATOR_MESSAGE_MAP.get(this.filter.operator);
      if (typeof operatorMessage === 'function') {
        return operatorMessage({ operator: operator, value: value }) || '';
      }
      return (0, _humanizedOperator.DEFAULT_FILTER_TEXT)({ operator: operator, value: value }) || '';
    },
    filterText: function filterText() {
      var _filter = this.filter,
          label = _filter.label,
          value = _filter.value;

      var message = value ? this.humanizedOperatorValue : 'is missing value';
      return label + ' ' + message;
    }
  },
  watch: {
    visible: {
      immediate: true,
      handler: function handler(value, oldValue) {
        var _this2 = this;

        if (value !== oldValue) {
          this.$nextTick(function () {
            if (value) {
              document.addEventListener('click', _this2.handleClick);
            } else {
              document.removeEventListener('click', _this2.handleClick);
            }
          });
        }
      }
    }
  },
  created: function created() {
    if (this.filter.saved) {
      this.hide();
    }
  },
  beforeDestroy: function beforeDestroy() {
    document.removeEventListener('click', this.handleClick);
  },

  methods: {
    handleClick: function handleClick(event) {
      if (this.visible) {
        var target = event.target;
        var filterMenu = this.$refs.filterMenu;

        if (target !== filterMenu && !filterMenu.contains(target)) {
          this.hide();
        }
      }
    },
    toggle: function toggle() {
      if (this.visible) {
        this.hide();
      } else {
        this.show();
      }
    },
    show: function show() {
      this.visible = true;
    },
    hide: function hide() {
      this.visible = false;
    },
    handleFilterUpdate: function handleFilterUpdate(_ref) {
      var operator = _ref.operator,
          value = _ref.value;

      var updatedFilter = _extends({}, this.filter, { operator: operator, value: value });
      this.$emit('update:filter', updatedFilter);
    }
  }
};

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6286322b\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterMenu.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.filter-menu__base[data-v-6286322b] {\n  background-color: #dbdbdb;\n  border-radius: 2px;\n  height: 30px;\n  max-width: 300px;\n}\n.filter-menu__base[data-v-6286322b]:after {\n  content: '';\n  position: absolute;\n  top: 0;\n  left: 0;\n  height: 100%;\n  width: 100%;\n  background-color: rgba(0, 0, 0, .03);\n  opacity: 0;\n  -webkit-transition: 250ms ease opacity;\n  transition: 250ms ease opacity;\n}\n.filter-menu:focus > .filter-menu__base[data-v-6286322b]:after,\n.filter-menu:focus-within > .filter-menu__base[data-v-6286322b]:after,\n.filter-menu:hover > .filter-menu__base[data-v-6286322b]:after {\n  opacity: 1;\n}\n.filter-menu--error .filter-menu__base[data-v-6286322b] {\n  background-color: #f2c6c6;\n  color: #ed595a;\n}\n.filter-menu__label[data-v-6286322b] {\n  color: inherit;\n  z-index: 1;\n  padding: 5px 5px 5px 10px;\n}\n.filter-menu__button[data-v-6286322b] {\n  opacity: 0;\n  padding: 5px;\n  -webkit-transition: all 300ms ease-in-out;\n  transition: all 300ms ease-in-out;\n  z-index: 1;\n}\n.filter-menu__base:focus-within .filter-menu__button[data-v-6286322b],\n.filter-menu__base:hover .filter-menu__button[data-v-6286322b] {\n  opacity: 1;\n}\n.filter-menu__list[data-v-6286322b] {\n  background-color: #fff;\n  border-radius: 3px;\n  border: 1px solid #f2f2f2;\n  -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .2);\n          box-shadow: 0 1px 3px rgba(0, 0, 0, .2);\n  left: 0;\n  min-width: 200px;\n  position: absolute;\n  top: 30px;\n  z-index: 2;\n}\n", "", {"version":3,"sources":["/home/manjul/Projects/floor-management/resources/assets/domain/common/components/fmFilter/resources/assets/domain/common/components/fmFilter/FilterMenu.vue"],"names":[],"mappings":";AAoJA;EACA,0BAAA;EACA,mBAAA;EACA,aAAA;EACA,iBAAA;CACA;AAEA;EACA,YAAA;EACA,mBAAA;EACA,OAAA;EACA,QAAA;EACA,aAAA;EACA,YAAA;EACA,qCAAA;EACA,WAAA;EACA,uCAAA;EAAA,+BAAA;CACA;AAEA;;;EAGA,WAAA;CACA;AAEA;EACA,0BAAA;EACA,eAAA;CACA;AAEA;EACA,eAAA;EACA,WAAA;EACA,0BAAA;CACA;AAEA;EACA,WAAA;EACA,aAAA;EACA,0CAAA;EAAA,kCAAA;EACA,WAAA;CACA;AAEA;;EAEA,WAAA;CACA;AAEA;EACA,uBAAA;EACA,mBAAA;EACA,0BAAA;EACA,gDAAA;UAAA,wCAAA;EACA,QAAA;EACA,iBAAA;EACA,mBAAA;EACA,UAAA;EACA,WAAA;CACA","file":"FilterMenu.vue","sourcesContent":["<template>\n  <div\n    class=\"filter-menu ag-flex-wrap relativePosition\"\n    :class=\"{ 'filter-menu--error': showError }\"\n    ref=\"filterMenu\"\n  >\n    <div class=\"filter-menu__base ag-flex ag-align-center\">\n      <button\n        type=\"button\"\n        class=\"truncate transparent-button filter-menu__label\"\n        :title=\"filterText\"\n        @click=\"toggle\"\n      >\n        <strong> {{ filter.label }} </strong>\n        <template v-if=\"showError\">is missing value</template>\n        <template v-else>{{ humanizedOperatorValue }}</template>\n      </button>\n      <button\n        type=\"button\"\n        class=\"transparent-button ag-flex ag-align-center ag-flex-shrink-0 col-hr-1 filter-menu__button\"\n        :class=\"showError ? 'text-primary-red' : 'text--mid-grey'\"\n        title=\"Remove this filter\"\n        @click=\"$emit('remove', filter)\"\n      >\n        <fm-icon icon=\"times\" class=\"ag-icon--md ag-icon--current\"/>\n      </button>\n    </div>\n    <transition name=\"list-down\">\n      <form\n        class=\"filter-menu__list ui form\"\n        v-show=\"visible\"\n        @submit.prevent=\"hide\"\n      >\n        <keep-alive>\n          <component\n            :is=\"currentFilterType\"\n            :filter=\"filter\"\n            @update=\"handleFilterUpdate\"\n          ></component>\n        </keep-alive>\n      </form>\n    </transition>\n  </div>\n</template>\n\n<script>\n  import FmIcon from '../functional/FmIcon';\n  import OPERATOR_VALUE_ID_MAP, { DEFAULT_FILTER_TEXT } from './const/humanizedOperator';\n\n  const HUMANIZED_OPERATOR_MAP = new Map();\n  OPERATOR_VALUE_ID_MAP.forEach(operator => HUMANIZED_OPERATOR_MAP.set(operator.id, operator.value, operator.message));\n\n  const OPERATOR_MESSAGE_MAP = new Map();\n  OPERATOR_VALUE_ID_MAP.forEach(operator => OPERATOR_MESSAGE_MAP.set(operator.id, operator.message));\n\n  export default {\n    name: 'FilterMenu',\n    components: {\n      FmIcon,\n    },\n    props: {\n      filter: {\n        type: Object,\n        required: true,\n      },\n    },\n    data: () => ({\n      visible: true,\n    }),\n    computed: {\n      currentFilterType() {\n        return () => import(`./types/Filter${this.filter.type}`);\n      },\n      showError() {\n        return !this.filter.value && !this.visible;\n      },\n      humanizedOperatorValue() {\n        const value = this.filter.value || '';\n        const operator = HUMANIZED_OPERATOR_MAP.get(this.filter.operator) || '';\n        const operatorMessage = OPERATOR_MESSAGE_MAP.get(this.filter.operator);\n        if (typeof operatorMessage === 'function') {\n          return operatorMessage({ operator, value }) || '';\n        }\n        return DEFAULT_FILTER_TEXT({ operator, value }) || '';\n      },\n      filterText() {\n        const { label, value } = this.filter;\n        const message = value ? this.humanizedOperatorValue : 'is missing value';\n        return `${label} ${message}`;\n      },\n    },\n    watch: {\n      visible: {\n        immediate: true,\n        handler(value, oldValue) {\n          if (value !== oldValue) {\n            this.$nextTick(() => {\n              if (value) {\n                document.addEventListener('click', this.handleClick);\n              } else {\n                document.removeEventListener('click', this.handleClick);\n              }\n            });\n          }\n        },\n      },\n    },\n    created() {\n      if (this.filter.saved) {\n        this.hide();\n      }\n    },\n    beforeDestroy() {\n      document.removeEventListener('click', this.handleClick);\n    },\n    methods: {\n      handleClick(event) {\n        if (this.visible) {\n          const { target } = event;\n          const { filterMenu } = this.$refs;\n          if (target !== filterMenu && !filterMenu.contains(target)) {\n            this.hide();\n          }\n        }\n      },\n      toggle() {\n        if (this.visible) {\n          this.hide();\n        } else {\n          this.show();\n        }\n      },\n      show() {\n        this.visible = true;\n      },\n      hide() {\n        this.visible = false;\n      },\n      handleFilterUpdate({ operator, value }) {\n        const updatedFilter = { ...this.filter, operator, value };\n        this.$emit('update:filter', updatedFilter);\n      },\n    },\n  };\n</script>\n\n\n<style scoped>\n  .filter-menu__base {\n    background-color: #dbdbdb;\n    border-radius: 2px;\n    height: 30px;\n    max-width: 300px;\n  }\n\n  .filter-menu__base:after {\n    content: '';\n    position: absolute;\n    top: 0;\n    left: 0;\n    height: 100%;\n    width: 100%;\n    background-color: rgba(0, 0, 0, .03);\n    opacity: 0;\n    transition: 250ms ease opacity;\n  }\n\n  .filter-menu:focus > .filter-menu__base:after,\n  .filter-menu:focus-within > .filter-menu__base:after,\n  .filter-menu:hover > .filter-menu__base:after {\n    opacity: 1;\n  }\n\n  .filter-menu--error .filter-menu__base {\n    background-color: #f2c6c6;\n    color: #ed595a;\n  }\n\n  .filter-menu__label {\n    color: inherit;\n    z-index: 1;\n    padding: 5px 5px 5px 10px;\n  }\n\n  .filter-menu__button {\n    opacity: 0;\n    padding: 5px;\n    transition: all 300ms ease-in-out;\n    z-index: 1;\n  }\n\n  .filter-menu__base:focus-within .filter-menu__button,\n  .filter-menu__base:hover .filter-menu__button {\n    opacity: 1;\n  }\n\n  .filter-menu__list {\n    background-color: #fff;\n    border-radius: 3px;\n    border: 1px solid #f2f2f2;\n    box-shadow: 0 1px 3px rgba(0, 0, 0, .2);\n    left: 0;\n    min-width: 200px;\n    position: absolute;\n    top: 30px;\n    z-index: 2;\n  }\n</style>\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6286322b\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/FilterMenu.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      ref: "filterMenu",
      staticClass: "filter-menu ag-flex-wrap relativePosition",
      class: { "filter-menu--error": _vm.showError }
    },
    [
      _c("div", { staticClass: "filter-menu__base ag-flex ag-align-center" }, [
        _c(
          "button",
          {
            staticClass: "truncate transparent-button filter-menu__label",
            attrs: { type: "button", title: _vm.filterText },
            on: { click: _vm.toggle }
          },
          [
            _c("strong", [_vm._v(" " + _vm._s(_vm.filter.label) + " ")]),
            _vm._v(" "),
            _vm.showError
              ? [_vm._v("is missing value")]
              : [_vm._v(_vm._s(_vm.humanizedOperatorValue))]
          ],
          2
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass:
              "transparent-button ag-flex ag-align-center ag-flex-shrink-0 col-hr-1 filter-menu__button",
            class: _vm.showError ? "text-primary-red" : "text--mid-grey",
            attrs: { type: "button", title: "Remove this filter" },
            on: {
              click: function($event) {
                _vm.$emit("remove", _vm.filter)
              }
            }
          },
          [
            _c("fm-icon", {
              staticClass: "ag-icon--md ag-icon--current",
              attrs: { icon: "times" }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("transition", { attrs: { name: "list-down" } }, [
        _c(
          "form",
          {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.visible,
                expression: "visible"
              }
            ],
            staticClass: "filter-menu__list ui form",
            on: {
              submit: function($event) {
                $event.preventDefault()
                return _vm.hide($event)
              }
            }
          },
          [
            _c(
              "keep-alive",
              [
                _c(_vm.currentFilterType, {
                  tag: "component",
                  attrs: { filter: _vm.filter },
                  on: { update: _vm.handleFilterUpdate }
                })
              ],
              1
            )
          ],
          1
        )
      ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6286322b", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6286322b\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterMenu.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6286322b\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterMenu.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("efc5bf60", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6286322b\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterMenu.vue", function() {
     var newContent = require("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6286322b\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./FilterMenu.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/assets/domain/common/components/fmFilter/FilterMenu.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6286322b\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/domain/common/components/fmFilter/FilterMenu.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],\"babel-preset-env\"],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/domain/common/components/fmFilter/FilterMenu.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6286322b\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/domain/common/components/fmFilter/FilterMenu.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-6286322b"
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
Component.options.__file = "resources/assets/domain/common/components/fmFilter/FilterMenu.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6286322b", Component.options)
  } else {
    hotAPI.reload("data-v-6286322b", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/domain/common/components/fmFilter/const/humanizedOperator.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.UNKNOWN = exports.CUSTOM = exports.LAST_MONTH = exports.CURRENT_MONTH = exports.LAST_30_DAYS = exports.LAST_7_DAYS = exports.YESTERDAY = exports.TODAY = exports.LESS_THAN = exports.GREATER_THAN = exports.NOT_CONTAINS = exports.CONTAINS = exports.ENDS_WITH = exports.STARTS_WITH = exports.IS_NOT = exports.IS = exports.DEFAULT_FILTER_TEXT = undefined;

var _operators = __webpack_require__("./resources/assets/domain/common/components/fmFilter/const/operators.js");

var OPERATOR = _interopRequireWildcard(_operators);

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

var DEFAULT_FILTER_TEXT = exports.DEFAULT_FILTER_TEXT = function DEFAULT_FILTER_TEXT(_ref) {
  var operator = _ref.operator,
      value = _ref.value;
  return operator + ' ' + value;
};

var IS = exports.IS = {
  id: OPERATOR.EQUALS,
  value: 'is'
};

var IS_NOT = exports.IS_NOT = {
  id: OPERATOR.NOT_EQUALS,
  value: 'is not'
};

var STARTS_WITH = exports.STARTS_WITH = {
  id: OPERATOR.STARTS_WITH,
  value: 'starts with'
};

var ENDS_WITH = exports.ENDS_WITH = {
  id: OPERATOR.ENDS_WITH,
  value: 'ends with'
};

var CONTAINS = exports.CONTAINS = {
  id: OPERATOR.CONTAINS,
  value: 'contains'
};

var NOT_CONTAINS = exports.NOT_CONTAINS = {
  id: OPERATOR.NOT_CONTAINS,
  value: 'does not contain'
};

var GREATER_THAN = exports.GREATER_THAN = {
  id: OPERATOR.GREATER_THAN,
  value: 'is greater than'
};

var LESS_THAN = exports.LESS_THAN = {
  id: OPERATOR.LESS_THAN,
  value: 'is less than'
};

var TODAY = exports.TODAY = {
  id: OPERATOR.TODAY,
  value: 'is today',
  message: function message(_ref2) {
    var operator = _ref2.operator;
    return '' + operator;
  }
};

var YESTERDAY = exports.YESTERDAY = {
  id: OPERATOR.YESTERDAY,
  value: 'is yesterday',
  message: function message(_ref3) {
    var operator = _ref3.operator;
    return '' + operator;
  }
};

var LAST_7_DAYS = exports.LAST_7_DAYS = {
  id: OPERATOR.LAST_7_DAYS,
  value: 'is last 7 days',
  message: function message(_ref4) {
    var operator = _ref4.operator;
    return '' + operator;
  }
};

var LAST_30_DAYS = exports.LAST_30_DAYS = {
  id: OPERATOR.LAST_30_DAYS,
  value: 'is last 30 days',
  message: function message(_ref5) {
    var operator = _ref5.operator;
    return '' + operator;
  }
};

var CURRENT_MONTH = exports.CURRENT_MONTH = {
  id: OPERATOR.CURRENT_MONTH,
  value: 'is current month',
  message: function message(_ref6) {
    var operator = _ref6.operator;
    return '' + operator;
  }
};

var LAST_MONTH = exports.LAST_MONTH = {
  id: OPERATOR.LAST_MONTH,
  value: 'is last month',
  message: function message(_ref7) {
    var operator = _ref7.operator;
    return '' + operator;
  }
};

var CUSTOM = exports.CUSTOM = {
  id: OPERATOR.CUSTOM,
  value: 'is custom',
  message: function message(_ref8) {
    var value = _ref8.value;
    return 'is from ' + value;
  }
};

var UNKNOWN = exports.UNKNOWN = {
  id: OPERATOR.UNKNOWN,
  value: 'is not known'
};

exports.default = [IS, IS_NOT, STARTS_WITH, ENDS_WITH, CONTAINS, NOT_CONTAINS, GREATER_THAN, LESS_THAN, TODAY, YESTERDAY, LAST_7_DAYS, LAST_30_DAYS, CURRENT_MONTH, LAST_MONTH, CUSTOM, UNKNOWN];

/***/ }),

/***/ "./resources/assets/domain/common/components/fmFilter/types lazy recursive ^\\.\\/Filter.*$":
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./FilterDate": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue",
		9
	],
	"./FilterDate.vue": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue",
		9
	],
	"./FilterNumber": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterNumber.vue",
		8
	],
	"./FilterNumber.vue": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterNumber.vue",
		8
	],
	"./FilterSelect": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterSelect.vue",
		7
	],
	"./FilterSelect.vue": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterSelect.vue",
		7
	],
	"./FilterString": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterString.vue",
		6
	],
	"./FilterString.vue": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterString.vue",
		6
	]
};
function webpackAsyncContext(req) {
	var ids = map[req];
	if(!ids)
		return Promise.reject(new Error("Cannot find module '" + req + "'."));
	return __webpack_require__.e(ids[1]).then(function() {
		return __webpack_require__(ids[0]);
	});
};
webpackAsyncContext.keys = function webpackAsyncContextKeys() {
	return Object.keys(map);
};
webpackAsyncContext.id = "./resources/assets/domain/common/components/fmFilter/types lazy recursive ^\\.\\/Filter.*$";
module.exports = webpackAsyncContext;

/***/ })

});
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWUiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWU/NjM1ZCIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJNZW51LnZ1ZT8xY2QzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlPzk2YWEiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWUiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvY29uc3QvaHVtYW5pemVkT3BlcmF0b3IuanMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMgbGF6eSBeXFwuXFwvRmlsdGVyLiokIl0sIm5hbWVzIjpbIk9QRVJBVE9SIiwiREVGQVVMVF9GSUxURVJfVEVYVCIsIm9wZXJhdG9yIiwidmFsdWUiLCJJUyIsImlkIiwiRVFVQUxTIiwiSVNfTk9UIiwiTk9UX0VRVUFMUyIsIlNUQVJUU19XSVRIIiwiRU5EU19XSVRIIiwiQ09OVEFJTlMiLCJOT1RfQ09OVEFJTlMiLCJHUkVBVEVSX1RIQU4iLCJMRVNTX1RIQU4iLCJUT0RBWSIsIm1lc3NhZ2UiLCJZRVNURVJEQVkiLCJMQVNUXzdfREFZUyIsIkxBU1RfMzBfREFZUyIsIkNVUlJFTlRfTU9OVEgiLCJMQVNUX01PTlRIIiwi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bGFzcz1cImZpbHRlci1tZW51IGFnLWZsZXgtd3JhcCByZWxhdGl2ZVBvc2l0aW9uXCJcbiAgICA6Y2xhc3M9XCJ7ICdmaWx0ZXItbWVudS0tZXJyb3InOiBzaG93RXJyb3IgfVwiXG4gICAgcmVmPVwiZmlsdGVyTWVudVwiXG4gID5cbiAgICA8ZGl2IGNsYXNzPVwiZmlsdGVyLW1lbnVfX2Jhc2UgYWctZmxleCBhZy1hbGlnbi1jZW50ZXJcIj5cbiAgICAgIDxidXR0b25cbiAgICAgICAgdHlwZT1cImJ1dHRvblwiXG4gICAgICAgIGNsYXNzPVwidHJ1bmNhdGUgdHJhbnNwYXJlbnQtYnV0dG9uIGZpbHRlci1tZW51X19sYWJlbFwiXG4gICAgICAgIDp0aXRsZT1cImZpbHRlclRleHRcIlxuICAgICAgICBAY2xpY2s9XCJ0b2dnbGVcIlxuICAgICAgPlxuICAgICAgICA8c3Ryb25nPiB7eyBmaWx0ZXIubGFiZWwgfX0gPC9zdHJvbmc+XG4gICAgICAgIDx0ZW1wbGF0ZSB2LWlmPVwic2hvd0Vycm9yXCI+aXMgbWlzc2luZyB2YWx1ZTwvdGVtcGxhdGU+XG4gICAgICAgIDx0ZW1wbGF0ZSB2LWVsc2U+e3sgaHVtYW5pemVkT3BlcmF0b3JWYWx1ZSB9fTwvdGVtcGxhdGU+XG4gICAgICA8L2J1dHRvbj5cbiAgICAgIDxidXR0b25cbiAgICAgICAgdHlwZT1cImJ1dHRvblwiXG4gICAgICAgIGNsYXNzPVwidHJhbnNwYXJlbnQtYnV0dG9uIGFnLWZsZXggYWctYWxpZ24tY2VudGVyIGFnLWZsZXgtc2hyaW5rLTAgY29sLWhyLTEgZmlsdGVyLW1lbnVfX2J1dHRvblwiXG4gICAgICAgIDpjbGFzcz1cInNob3dFcnJvciA/ICd0ZXh0LXByaW1hcnktcmVkJyA6ICd0ZXh0LS1taWQtZ3JleSdcIlxuICAgICAgICB0aXRsZT1cIlJlbW92ZSB0aGlzIGZpbHRlclwiXG4gICAgICAgIEBjbGljaz1cIiRlbWl0KCdyZW1vdmUnLCBmaWx0ZXIpXCJcbiAgICAgID5cbiAgICAgICAgPGZtLWljb24gaWNvbj1cInRpbWVzXCIgY2xhc3M9XCJhZy1pY29uLS1tZCBhZy1pY29uLS1jdXJyZW50XCIvPlxuICAgICAgPC9idXR0b24+XG4gICAgPC9kaXY+XG4gICAgPHRyYW5zaXRpb24gbmFtZT1cImxpc3QtZG93blwiPlxuICAgICAgPGZvcm1cbiAgICAgICAgY2xhc3M9XCJmaWx0ZXItbWVudV9fbGlzdCB1aSBmb3JtXCJcbiAgICAgICAgdi1zaG93PVwidmlzaWJsZVwiXG4gICAgICAgIEBzdWJtaXQucHJldmVudD1cImhpZGVcIlxuICAgICAgPlxuICAgICAgICA8a2VlcC1hbGl2ZT5cbiAgICAgICAgICA8Y29tcG9uZW50XG4gICAgICAgICAgICA6aXM9XCJjdXJyZW50RmlsdGVyVHlwZVwiXG4gICAgICAgICAgICA6ZmlsdGVyPVwiZmlsdGVyXCJcbiAgICAgICAgICAgIEB1cGRhdGU9XCJoYW5kbGVGaWx0ZXJVcGRhdGVcIlxuICAgICAgICAgID48L2NvbXBvbmVudD5cbiAgICAgICAgPC9rZWVwLWFsaXZlPlxuICAgICAgPC9mb3JtPlxuICAgIDwvdHJhbnNpdGlvbj5cbiAgPC9kaXY+XG48L3RlbXBsYXRlPlxuXG48c2NyaXB0PlxuICBpbXBvcnQgRm1JY29uIGZyb20gJy4uL2Z1bmN0aW9uYWwvRm1JY29uJztcbiAgaW1wb3J0IE9QRVJBVE9SX1ZBTFVFX0lEX01BUCwgeyBERUZBVUxUX0ZJTFRFUl9URVhUIH0gZnJvbSAnLi9jb25zdC9odW1hbml6ZWRPcGVyYXRvcic7XG5cbiAgY29uc3QgSFVNQU5JWkVEX09QRVJBVE9SX01BUCA9IG5ldyBNYXAoKTtcbiAgT1BFUkFUT1JfVkFMVUVfSURfTUFQLmZvckVhY2gob3BlcmF0b3IgPT4gSFVNQU5JWkVEX09QRVJBVE9SX01BUC5zZXQob3BlcmF0b3IuaWQsIG9wZXJhdG9yLnZhbHVlLCBvcGVyYXRvci5tZXNzYWdlKSk7XG5cbiAgY29uc3QgT1BFUkFUT1JfTUVTU0FHRV9NQVAgPSBuZXcgTWFwKCk7XG4gIE9QRVJBVE9SX1ZBTFVFX0lEX01BUC5mb3JFYWNoKG9wZXJhdG9yID0+IE9QRVJBVE9SX01FU1NBR0VfTUFQLnNldChvcGVyYXRvci5pZCwgb3BlcmF0b3IubWVzc2FnZSkpO1xuXG4gIGV4cG9ydCBkZWZhdWx0IHtcbiAgICBuYW1lOiAnRmlsdGVyTWVudScsXG4gICAgY29tcG9uZW50czoge1xuICAgICAgRm1JY29uLFxuICAgIH0sXG4gICAgcHJvcHM6IHtcbiAgICAgIGZpbHRlcjoge1xuICAgICAgICB0eXBlOiBPYmplY3QsXG4gICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgfSxcbiAgICB9LFxuICAgIGRhdGE6ICgpID0+ICh7XG4gICAgICB2aXNpYmxlOiB0cnVlLFxuICAgIH0pLFxuICAgIGNvbXB1dGVkOiB7XG4gICAgICBjdXJyZW50RmlsdGVyVHlwZSgpIHtcbiAgICAgICAgcmV0dXJuICgpID0+IGltcG9ydChgLi90eXBlcy9GaWx0ZXIke3RoaXMuZmlsdGVyLnR5cGV9YCk7XG4gICAgICB9LFxuICAgICAgc2hvd0Vycm9yKCkge1xuICAgICAgICByZXR1cm4gIXRoaXMuZmlsdGVyLnZhbHVlICYmICF0aGlzLnZpc2libGU7XG4gICAgICB9LFxuICAgICAgaHVtYW5pemVkT3BlcmF0b3JWYWx1ZSgpIHtcbiAgICAgICAgY29uc3QgdmFsdWUgPSB0aGlzLmZpbHRlci52YWx1ZSB8fCAnJztcbiAgICAgICAgY29uc3Qgb3BlcmF0b3IgPSBIVU1BTklaRURfT1BFUkFUT1JfTUFQLmdldCh0aGlzLmZpbHRlci5vcGVyYXRvcikgfHwgJyc7XG4gICAgICAgIGNvbnN0IG9wZXJhdG9yTWVzc2FnZSA9IE9QRVJBVE9SX01FU1NBR0VfTUFQLmdldCh0aGlzLmZpbHRlci5vcGVyYXRvcik7XG4gICAgICAgIGlmICh0eXBlb2Ygb3BlcmF0b3JNZXNzYWdlID09PSAnZnVuY3Rpb24nKSB7XG4gICAgICAgICAgcmV0dXJuIG9wZXJhdG9yTWVzc2FnZSh7IG9wZXJhdG9yLCB2YWx1ZSB9KSB8fCAnJztcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gREVGQVVMVF9GSUxURVJfVEVYVCh7IG9wZXJhdG9yLCB2YWx1ZSB9KSB8fCAnJztcbiAgICAgIH0sXG4gICAgICBmaWx0ZXJUZXh0KCkge1xuICAgICAgICBjb25zdCB7IGxhYmVsLCB2YWx1ZSB9ID0gdGhpcy5maWx0ZXI7XG4gICAgICAgIGNvbnN0IG1lc3NhZ2UgPSB2YWx1ZSA/IHRoaXMuaHVtYW5pemVkT3BlcmF0b3JWYWx1ZSA6ICdpcyBtaXNzaW5nIHZhbHVlJztcbiAgICAgICAgcmV0dXJuIGAke2xhYmVsfSAke21lc3NhZ2V9YDtcbiAgICAgIH0sXG4gICAgfSxcbiAgICB3YXRjaDoge1xuICAgICAgdmlzaWJsZToge1xuICAgICAgICBpbW1lZGlhdGU6IHRydWUsXG4gICAgICAgIGhhbmRsZXIodmFsdWUsIG9sZFZhbHVlKSB7XG4gICAgICAgICAgaWYgKHZhbHVlICE9PSBvbGRWYWx1ZSkge1xuICAgICAgICAgICAgdGhpcy4kbmV4dFRpY2soKCkgPT4ge1xuICAgICAgICAgICAgICBpZiAodmFsdWUpIHtcbiAgICAgICAgICAgICAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIHRoaXMuaGFuZGxlQ2xpY2spO1xuICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgIGRvY3VtZW50LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgdGhpcy5oYW5kbGVDbGljayk7XG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgIH1cbiAgICAgICAgfSxcbiAgICAgIH0sXG4gICAgfSxcbiAgICBjcmVhdGVkKCkge1xuICAgICAgaWYgKHRoaXMuZmlsdGVyLnNhdmVkKSB7XG4gICAgICAgIHRoaXMuaGlkZSgpO1xuICAgICAgfVxuICAgIH0sXG4gICAgYmVmb3JlRGVzdHJveSgpIHtcbiAgICAgIGRvY3VtZW50LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgdGhpcy5oYW5kbGVDbGljayk7XG4gICAgfSxcbiAgICBtZXRob2RzOiB7XG4gICAgICBoYW5kbGVDbGljayhldmVudCkge1xuICAgICAgICBpZiAodGhpcy52aXNpYmxlKSB7XG4gICAgICAgICAgY29uc3QgeyB0YXJnZXQgfSA9IGV2ZW50O1xuICAgICAgICAgIGNvbnN0IHsgZmlsdGVyTWVudSB9ID0gdGhpcy4kcmVmcztcbiAgICAgICAgICBpZiAodGFyZ2V0ICE9PSBmaWx0ZXJNZW51ICYmICFmaWx0ZXJNZW51LmNvbnRhaW5zKHRhcmdldCkpIHtcbiAgICAgICAgICAgIHRoaXMuaGlkZSgpO1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfSxcbiAgICAgIHRvZ2dsZSgpIHtcbiAgICAgICAgaWYgKHRoaXMudmlzaWJsZSkge1xuICAgICAgICAgIHRoaXMuaGlkZSgpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgIHRoaXMuc2hvdygpO1xuICAgICAgICB9XG4gICAgICB9LFxuICAgICAgc2hvdygpIHtcbiAgICAgICAgdGhpcy52aXNpYmxlID0gdHJ1ZTtcbiAgICAgIH0sXG4gICAgICBoaWRlKCkge1xuICAgICAgICB0aGlzLnZpc2libGUgPSBmYWxzZTtcbiAgICAgIH0sXG4gICAgICBoYW5kbGVGaWx0ZXJVcGRhdGUoeyBvcGVyYXRvciwgdmFsdWUgfSkge1xuICAgICAgICBjb25zdCB1cGRhdGVkRmlsdGVyID0geyAuLi50aGlzLmZpbHRlciwgb3BlcmF0b3IsIHZhbHVlIH07XG4gICAgICAgIHRoaXMuJGVtaXQoJ3VwZGF0ZTpmaWx0ZXInLCB1cGRhdGVkRmlsdGVyKTtcbiAgICAgIH0sXG4gICAgfSxcbiAgfTtcbjwvc2NyaXB0PlxuXG5cbjxzdHlsZSBzY29wZWQ+XG4gIC5maWx0ZXItbWVudV9fYmFzZSB7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogI2RiZGJkYjtcbiAgICBib3JkZXItcmFkaXVzOiAycHg7XG4gICAgaGVpZ2h0OiAzMHB4O1xuICAgIG1heC13aWR0aDogMzAwcHg7XG4gIH1cblxuICAuZmlsdGVyLW1lbnVfX2Jhc2U6YWZ0ZXIge1xuICAgIGNvbnRlbnQ6ICcnO1xuICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcbiAgICB0b3A6IDA7XG4gICAgbGVmdDogMDtcbiAgICBoZWlnaHQ6IDEwMCU7XG4gICAgd2lkdGg6IDEwMCU7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogcmdiYSgwLCAwLCAwLCAuMDMpO1xuICAgIG9wYWNpdHk6IDA7XG4gICAgdHJhbnNpdGlvbjogMjUwbXMgZWFzZSBvcGFjaXR5O1xuICB9XG5cbiAgLmZpbHRlci1tZW51OmZvY3VzID4gLmZpbHRlci1tZW51X19iYXNlOmFmdGVyLFxuICAuZmlsdGVyLW1lbnU6Zm9jdXMtd2l0aGluID4gLmZpbHRlci1tZW51X19iYXNlOmFmdGVyLFxuICAuZmlsdGVyLW1lbnU6aG92ZXIgPiAuZmlsdGVyLW1lbnVfX2Jhc2U6YWZ0ZXIge1xuICAgIG9wYWNpdHk6IDE7XG4gIH1cblxuICAuZmlsdGVyLW1lbnUtLWVycm9yIC5maWx0ZXItbWVudV9fYmFzZSB7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogI2YyYzZjNjtcbiAgICBjb2xvcjogI2VkNTk1YTtcbiAgfVxuXG4gIC5maWx0ZXItbWVudV9fbGFiZWwge1xuICAgIGNvbG9yOiBpbmhlcml0O1xuICAgIHotaW5kZXg6IDE7XG4gICAgcGFkZGluZzogNXB4IDVweCA1cHggMTBweDtcbiAgfVxuXG4gIC5maWx0ZXItbWVudV9fYnV0dG9uIHtcbiAgICBvcGFjaXR5OiAwO1xuICAgIHBhZGRpbmc6IDVweDtcbiAgICB0cmFuc2l0aW9uOiBhbGwgMzAwbXMgZWFzZS1pbi1vdXQ7XG4gICAgei1pbmRleDogMTtcbiAgfVxuXG4gIC5maWx0ZXItbWVudV9fYmFzZTpmb2N1cy13aXRoaW4gLmZpbHRlci1tZW51X19idXR0b24sXG4gIC5maWx0ZXItbWVudV9fYmFzZTpob3ZlciAuZmlsdGVyLW1lbnVfX2J1dHRvbiB7XG4gICAgb3BhY2l0eTogMTtcbiAgfVxuXG4gIC5maWx0ZXItbWVudV9fbGlzdCB7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogI2ZmZjtcbiAgICBib3JkZXItcmFkaXVzOiAzcHg7XG4gICAgYm9yZGVyOiAxcHggc29saWQgI2YyZjJmMjtcbiAgICBib3gtc2hhZG93OiAwIDFweCAzcHggcmdiYSgwLCAwLCAwLCAuMik7XG4gICAgbGVmdDogMDtcbiAgICBtaW4td2lkdGg6IDIwMHB4O1xuICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcbiAgICB0b3A6IDMwcHg7XG4gICAgei1pbmRleDogMjtcbiAgfVxuPC9zdHlsZT5cblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyByZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJNZW51LnZ1ZSIsImV4cG9ydHMgPSBtb2R1bGUuZXhwb3J0cyA9IHJlcXVpcmUoXCIuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9saWIvY3NzLWJhc2UuanNcIikodHJ1ZSk7XG4vLyBpbXBvcnRzXG5cblxuLy8gbW9kdWxlXG5leHBvcnRzLnB1c2goW21vZHVsZS5pZCwgXCJcXG4uZmlsdGVyLW1lbnVfX2Jhc2VbZGF0YS12LTYyODYzMjJiXSB7XFxuICBiYWNrZ3JvdW5kLWNvbG9yOiAjZGJkYmRiO1xcbiAgYm9yZGVyLXJhZGl1czogMnB4O1xcbiAgaGVpZ2h0OiAzMHB4O1xcbiAgbWF4LXdpZHRoOiAzMDBweDtcXG59XFxuLmZpbHRlci1tZW51X19iYXNlW2RhdGEtdi02Mjg2MzIyYl06YWZ0ZXIge1xcbiAgY29udGVudDogJyc7XFxuICBwb3NpdGlvbjogYWJzb2x1dGU7XFxuICB0b3A6IDA7XFxuICBsZWZ0OiAwO1xcbiAgaGVpZ2h0OiAxMDAlO1xcbiAgd2lkdGg6IDEwMCU7XFxuICBiYWNrZ3JvdW5kLWNvbG9yOiByZ2JhKDAsIDAsIDAsIC4wMyk7XFxuICBvcGFjaXR5OiAwO1xcbiAgLXdlYmtpdC10cmFuc2l0aW9uOiAyNTBtcyBlYXNlIG9wYWNpdHk7XFxuICB0cmFuc2l0aW9uOiAyNTBtcyBlYXNlIG9wYWNpdHk7XFxufVxcbi5maWx0ZXItbWVudTpmb2N1cyA+IC5maWx0ZXItbWVudV9fYmFzZVtkYXRhLXYtNjI4NjMyMmJdOmFmdGVyLFxcbi5maWx0ZXItbWVudTpmb2N1cy13aXRoaW4gPiAuZmlsdGVyLW1lbnVfX2Jhc2VbZGF0YS12LTYyODYzMjJiXTphZnRlcixcXG4uZmlsdGVyLW1lbnU6aG92ZXIgPiAuZmlsdGVyLW1lbnVfX2Jhc2VbZGF0YS12LTYyODYzMjJiXTphZnRlciB7XFxuICBvcGFjaXR5OiAxO1xcbn1cXG4uZmlsdGVyLW1lbnUtLWVycm9yIC5maWx0ZXItbWVudV9fYmFzZVtkYXRhLXYtNjI4NjMyMmJdIHtcXG4gIGJhY2tncm91bmQtY29sb3I6ICNmMmM2YzY7XFxuICBjb2xvcjogI2VkNTk1YTtcXG59XFxuLmZpbHRlci1tZW51X19sYWJlbFtkYXRhLXYtNjI4NjMyMmJdIHtcXG4gIGNvbG9yOiBpbmhlcml0O1xcbiAgei1pbmRleDogMTtcXG4gIHBhZGRpbmc6IDVweCA1cHggNXB4IDEwcHg7XFxufVxcbi5maWx0ZXItbWVudV9fYnV0dG9uW2RhdGEtdi02Mjg2MzIyYl0ge1xcbiAgb3BhY2l0eTogMDtcXG4gIHBhZGRpbmc6IDVweDtcXG4gIC13ZWJraXQtdHJhbnNpdGlvbjogYWxsIDMwMG1zIGVhc2UtaW4tb3V0O1xcbiAgdHJhbnNpdGlvbjogYWxsIDMwMG1zIGVhc2UtaW4tb3V0O1xcbiAgei1pbmRleDogMTtcXG59XFxuLmZpbHRlci1tZW51X19iYXNlOmZvY3VzLXdpdGhpbiAuZmlsdGVyLW1lbnVfX2J1dHRvbltkYXRhLXYtNjI4NjMyMmJdLFxcbi5maWx0ZXItbWVudV9fYmFzZTpob3ZlciAuZmlsdGVyLW1lbnVfX2J1dHRvbltkYXRhLXYtNjI4NjMyMmJdIHtcXG4gIG9wYWNpdHk6IDE7XFxufVxcbi5maWx0ZXItbWVudV9fbGlzdFtkYXRhLXYtNjI4NjMyMmJdIHtcXG4gIGJhY2tncm91bmQtY29sb3I6ICNmZmY7XFxuICBib3JkZXItcmFkaXVzOiAzcHg7XFxuICBib3JkZXI6IDFweCBzb2xpZCAjZjJmMmYyO1xcbiAgLXdlYmtpdC1ib3gtc2hhZG93OiAwIDFweCAzcHggcmdiYSgwLCAwLCAwLCAuMik7XFxuICAgICAgICAgIGJveC1zaGFkb3c6IDAgMXB4IDNweCByZ2JhKDAsIDAsIDAsIC4yKTtcXG4gIGxlZnQ6IDA7XFxuICBtaW4td2lkdGg6IDIwMHB4O1xcbiAgcG9zaXRpb246IGFic29sdXRlO1xcbiAgdG9wOiAzMHB4O1xcbiAgei1pbmRleDogMjtcXG59XFxuXCIsIFwiXCIsIHtcInZlcnNpb25cIjozLFwic291cmNlc1wiOltcIi9ob21lL21hbmp1bC9Qcm9qZWN0cy9mbG9vci1tYW5hZ2VtZW50L3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlXCJdLFwibmFtZXNcIjpbXSxcIm1hcHBpbmdzXCI6XCI7QUFvSkE7RUFDQSwwQkFBQTtFQUNBLG1CQUFBO0VBQ0EsYUFBQTtFQUNBLGlCQUFBO0NBQ0E7QUFFQTtFQUNBLFlBQUE7RUFDQSxtQkFBQTtFQUNBLE9BQUE7RUFDQSxRQUFBO0VBQ0EsYUFBQTtFQUNBLFlBQUE7RUFDQSxxQ0FBQTtFQUNBLFdBQUE7RUFDQSx1Q0FBQTtFQUFBLCtCQUFBO0NBQ0E7QUFFQTs7O0VBR0EsV0FBQTtDQUNBO0FBRUE7RUFDQSwwQkFBQTtFQUNBLGVBQUE7Q0FDQTtBQUVBO0VBQ0EsZUFBQTtFQUNBLFdBQUE7RUFDQSwwQkFBQTtDQUNBO0FBRUE7RUFDQSxXQUFBO0VBQ0EsYUFBQTtFQUNBLDBDQUFBO0VBQUEsa0NBQUE7RUFDQSxXQUFBO0NBQ0E7QUFFQTs7RUFFQSxXQUFBO0NBQ0E7QUFFQTtFQUNBLHVCQUFBO0VBQ0EsbUJBQUE7RUFDQSwwQkFBQTtFQUNBLGdEQUFBO1VBQUEsd0NBQUE7RUFDQSxRQUFBO0VBQ0EsaUJBQUE7RUFDQSxtQkFBQTtFQUNBLFVBQUE7RUFDQSxXQUFBO0NBQ0FcIixcImZpbGVcIjpcIkZpbHRlck1lbnUudnVlXCIsXCJzb3VyY2VzQ29udGVudFwiOltcIjx0ZW1wbGF0ZT5cXG4gIDxkaXZcXG4gICAgY2xhc3M9XFxcImZpbHRlci1tZW51IGFnLWZsZXgtd3JhcCByZWxhdGl2ZVBvc2l0aW9uXFxcIlxcbiAgICA6Y2xhc3M9XFxcInsgJ2ZpbHRlci1tZW51LS1lcnJvcic6IHNob3dFcnJvciB9XFxcIlxcbiAgICByZWY9XFxcImZpbHRlck1lbnVcXFwiXFxuICA+XFxuICAgIDxkaXYgY2xhc3M9XFxcImZpbHRlci1tZW51X19iYXNlIGFnLWZsZXggYWctYWxpZ24tY2VudGVyXFxcIj5cXG4gICAgICA8YnV0dG9uXFxuICAgICAgICB0eXBlPVxcXCJidXR0b25cXFwiXFxuICAgICAgICBjbGFzcz1cXFwidHJ1bmNhdGUgdHJhbnNwYXJlbnQtYnV0dG9uIGZpbHRlci1tZW51X19sYWJlbFxcXCJcXG4gICAgICAgIDp0aXRsZT1cXFwiZmlsdGVyVGV4dFxcXCJcXG4gICAgICAgIEBjbGljaz1cXFwidG9nZ2xlXFxcIlxcbiAgICAgID5cXG4gICAgICAgIDxzdHJvbmc+IHt7IGZpbHRlci5sYWJlbCB9fSA8L3N0cm9uZz5cXG4gICAgICAgIDx0ZW1wbGF0ZSB2LWlmPVxcXCJzaG93RXJyb3JcXFwiPmlzIG1pc3NpbmcgdmFsdWU8L3RlbXBsYXRlPlxcbiAgICAgICAgPHRlbXBsYXRlIHYtZWxzZT57eyBodW1hbml6ZWRPcGVyYXRvclZhbHVlIH19PC90ZW1wbGF0ZT5cXG4gICAgICA8L2J1dHRvbj5cXG4gICAgICA8YnV0dG9uXFxuICAgICAgICB0eXBlPVxcXCJidXR0b25cXFwiXFxuICAgICAgICBjbGFzcz1cXFwidHJhbnNwYXJlbnQtYnV0dG9uIGFnLWZsZXggYWctYWxpZ24tY2VudGVyIGFnLWZsZXgtc2hyaW5rLTAgY29sLWhyLTEgZmlsdGVyLW1lbnVfX2J1dHRvblxcXCJcXG4gICAgICAgIDpjbGFzcz1cXFwic2hvd0Vycm9yID8gJ3RleHQtcHJpbWFyeS1yZWQnIDogJ3RleHQtLW1pZC1ncmV5J1xcXCJcXG4gICAgICAgIHRpdGxlPVxcXCJSZW1vdmUgdGhpcyBmaWx0ZXJcXFwiXFxuICAgICAgICBAY2xpY2s9XFxcIiRlbWl0KCdyZW1vdmUnLCBmaWx0ZXIpXFxcIlxcbiAgICAgID5cXG4gICAgICAgIDxmbS1pY29uIGljb249XFxcInRpbWVzXFxcIiBjbGFzcz1cXFwiYWctaWNvbi0tbWQgYWctaWNvbi0tY3VycmVudFxcXCIvPlxcbiAgICAgIDwvYnV0dG9uPlxcbiAgICA8L2Rpdj5cXG4gICAgPHRyYW5zaXRpb24gbmFtZT1cXFwibGlzdC1kb3duXFxcIj5cXG4gICAgICA8Zm9ybVxcbiAgICAgICAgY2xhc3M9XFxcImZpbHRlci1tZW51X19saXN0IHVpIGZvcm1cXFwiXFxuICAgICAgICB2LXNob3c9XFxcInZpc2libGVcXFwiXFxuICAgICAgICBAc3VibWl0LnByZXZlbnQ9XFxcImhpZGVcXFwiXFxuICAgICAgPlxcbiAgICAgICAgPGtlZXAtYWxpdmU+XFxuICAgICAgICAgIDxjb21wb25lbnRcXG4gICAgICAgICAgICA6aXM9XFxcImN1cnJlbnRGaWx0ZXJUeXBlXFxcIlxcbiAgICAgICAgICAgIDpmaWx0ZXI9XFxcImZpbHRlclxcXCJcXG4gICAgICAgICAgICBAdXBkYXRlPVxcXCJoYW5kbGVGaWx0ZXJVcGRhdGVcXFwiXFxuICAgICAgICAgID48L2NvbXBvbmVudD5cXG4gICAgICAgIDwva2VlcC1hbGl2ZT5cXG4gICAgICA8L2Zvcm0+XFxuICAgIDwvdHJhbnNpdGlvbj5cXG4gIDwvZGl2PlxcbjwvdGVtcGxhdGU+XFxuXFxuPHNjcmlwdD5cXG4gIGltcG9ydCBGbUljb24gZnJvbSAnLi4vZnVuY3Rpb25hbC9GbUljb24nO1xcbiAgaW1wb3J0IE9QRVJBVE9SX1ZBTFVFX0lEX01BUCwgeyBERUZBVUxUX0ZJTFRFUl9URVhUIH0gZnJvbSAnLi9jb25zdC9odW1hbml6ZWRPcGVyYXRvcic7XFxuXFxuICBjb25zdCBIVU1BTklaRURfT1BFUkFUT1JfTUFQID0gbmV3IE1hcCgpO1xcbiAgT1BFUkFUT1JfVkFMVUVfSURfTUFQLmZvckVhY2gob3BlcmF0b3IgPT4gSFVNQU5JWkVEX09QRVJBVE9SX01BUC5zZXQob3BlcmF0b3IuaWQsIG9wZXJhdG9yLnZhbHVlLCBvcGVyYXRvci5tZXNzYWdlKSk7XFxuXFxuICBjb25zdCBPUEVSQVRPUl9NRVNTQUdFX01BUCA9IG5ldyBNYXAoKTtcXG4gIE9QRVJBVE9SX1ZBTFVFX0lEX01BUC5mb3JFYWNoKG9wZXJhdG9yID0+IE9QRVJBVE9SX01FU1NBR0VfTUFQLnNldChvcGVyYXRvci5pZCwgb3BlcmF0b3IubWVzc2FnZSkpO1xcblxcbiAgZXhwb3J0IGRlZmF1bHQge1xcbiAgICBuYW1lOiAnRmlsdGVyTWVudScsXFxuICAgIGNvbXBvbmVudHM6IHtcXG4gICAgICBGbUljb24sXFxuICAgIH0sXFxuICAgIHByb3BzOiB7XFxuICAgICAgZmlsdGVyOiB7XFxuICAgICAgICB0eXBlOiBPYmplY3QsXFxuICAgICAgICByZXF1aXJlZDogdHJ1ZSxcXG4gICAgICB9LFxcbiAgICB9LFxcbiAgICBkYXRhOiAoKSA9PiAoe1xcbiAgICAgIHZpc2libGU6IHRydWUsXFxuICAgIH0pLFxcbiAgICBjb21wdXRlZDoge1xcbiAgICAgIGN1cnJlbnRGaWx0ZXJUeXBlKCkge1xcbiAgICAgICAgcmV0dXJuICgpID0+IGltcG9ydChgLi90eXBlcy9GaWx0ZXIke3RoaXMuZmlsdGVyLnR5cGV9YCk7XFxuICAgICAgfSxcXG4gICAgICBzaG93RXJyb3IoKSB7XFxuICAgICAgICByZXR1cm4gIXRoaXMuZmlsdGVyLnZhbHVlICYmICF0aGlzLnZpc2libGU7XFxuICAgICAgfSxcXG4gICAgICBodW1hbml6ZWRPcGVyYXRvclZhbHVlKCkge1xcbiAgICAgICAgY29uc3QgdmFsdWUgPSB0aGlzLmZpbHRlci52YWx1ZSB8fCAnJztcXG4gICAgICAgIGNvbnN0IG9wZXJhdG9yID0gSFVNQU5JWkVEX09QRVJBVE9SX01BUC5nZXQodGhpcy5maWx0ZXIub3BlcmF0b3IpIHx8ICcnO1xcbiAgICAgICAgY29uc3Qgb3BlcmF0b3JNZXNzYWdlID0gT1BFUkFUT1JfTUVTU0FHRV9NQVAuZ2V0KHRoaXMuZmlsdGVyLm9wZXJhdG9yKTtcXG4gICAgICAgIGlmICh0eXBlb2Ygb3BlcmF0b3JNZXNzYWdlID09PSAnZnVuY3Rpb24nKSB7XFxuICAgICAgICAgIHJldHVybiBvcGVyYXRvck1lc3NhZ2UoeyBvcGVyYXRvciwgdmFsdWUgfSkgfHwgJyc7XFxuICAgICAgICB9XFxuICAgICAgICByZXR1cm4gREVGQVVMVF9GSUxURVJfVEVYVCh7IG9wZXJhdG9yLCB2YWx1ZSB9KSB8fCAnJztcXG4gICAgICB9LFxcbiAgICAgIGZpbHRlclRleHQoKSB7XFxuICAgICAgICBjb25zdCB7IGxhYmVsLCB2YWx1ZSB9ID0gdGhpcy5maWx0ZXI7XFxuICAgICAgICBjb25zdCBtZXNzYWdlID0gdmFsdWUgPyB0aGlzLmh1bWFuaXplZE9wZXJhdG9yVmFsdWUgOiAnaXMgbWlzc2luZyB2YWx1ZSc7XFxuICAgICAgICByZXR1cm4gYCR7bGFiZWx9ICR7bWVzc2FnZX1gO1xcbiAgICAgIH0sXFxuICAgIH0sXFxuICAgIHdhdGNoOiB7XFxuICAgICAgdmlzaWJsZToge1xcbiAgICAgICAgaW1tZWRpYXRlOiB0cnVlLFxcbiAgICAgICAgaGFuZGxlcih2YWx1ZSwgb2xkVmFsdWUpIHtcXG4gICAgICAgICAgaWYgKHZhbHVlICE9PSBvbGRWYWx1ZSkge1xcbiAgICAgICAgICAgIHRoaXMuJG5leHRUaWNrKCgpID0+IHtcXG4gICAgICAgICAgICAgIGlmICh2YWx1ZSkge1xcbiAgICAgICAgICAgICAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIHRoaXMuaGFuZGxlQ2xpY2spO1xcbiAgICAgICAgICAgICAgfSBlbHNlIHtcXG4gICAgICAgICAgICAgICAgZG9jdW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcignY2xpY2snLCB0aGlzLmhhbmRsZUNsaWNrKTtcXG4gICAgICAgICAgICAgIH1cXG4gICAgICAgICAgICB9KTtcXG4gICAgICAgICAgfVxcbiAgICAgICAgfSxcXG4gICAgICB9LFxcbiAgICB9LFxcbiAgICBjcmVhdGVkKCkge1xcbiAgICAgIGlmICh0aGlzLmZpbHRlci5zYXZlZCkge1xcbiAgICAgICAgdGhpcy5oaWRlKCk7XFxuICAgICAgfVxcbiAgICB9LFxcbiAgICBiZWZvcmVEZXN0cm95KCkge1xcbiAgICAgIGRvY3VtZW50LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgdGhpcy5oYW5kbGVDbGljayk7XFxuICAgIH0sXFxuICAgIG1ldGhvZHM6IHtcXG4gICAgICBoYW5kbGVDbGljayhldmVudCkge1xcbiAgICAgICAgaWYgKHRoaXMudmlzaWJsZSkge1xcbiAgICAgICAgICBjb25zdCB7IHRhcmdldCB9ID0gZXZlbnQ7XFxuICAgICAgICAgIGNvbnN0IHsgZmlsdGVyTWVudSB9ID0gdGhpcy4kcmVmcztcXG4gICAgICAgICAgaWYgKHRhcmdldCAhPT0gZmlsdGVyTWVudSAmJiAhZmlsdGVyTWVudS5jb250YWlucyh0YXJnZXQpKSB7XFxuICAgICAgICAgICAgdGhpcy5oaWRlKCk7XFxuICAgICAgICAgIH1cXG4gICAgICAgIH1cXG4gICAgICB9LFxcbiAgICAgIHRvZ2dsZSgpIHtcXG4gICAgICAgIGlmICh0aGlzLnZpc2libGUpIHtcXG4gICAgICAgICAgdGhpcy5oaWRlKCk7XFxuICAgICAgICB9IGVsc2Uge1xcbiAgICAgICAgICB0aGlzLnNob3coKTtcXG4gICAgICAgIH1cXG4gICAgICB9LFxcbiAgICAgIHNob3coKSB7XFxuICAgICAgICB0aGlzLnZpc2libGUgPSB0cnVlO1xcbiAgICAgIH0sXFxuICAgICAgaGlkZSgpIHtcXG4gICAgICAgIHRoaXMudmlzaWJsZSA9IGZhbHNlO1xcbiAgICAgIH0sXFxuICAgICAgaGFuZGxlRmlsdGVyVXBkYXRlKHsgb3BlcmF0b3IsIHZhbHVlIH0pIHtcXG4gICAgICAgIGNvbnN0IHVwZGF0ZWRGaWx0ZXIgPSB7IC4uLnRoaXMuZmlsdGVyLCBvcGVyYXRvciwgdmFsdWUgfTtcXG4gICAgICAgIHRoaXMuJGVtaXQoJ3VwZGF0ZTpmaWx0ZXInLCB1cGRhdGVkRmlsdGVyKTtcXG4gICAgICB9LFxcbiAgICB9LFxcbiAgfTtcXG48L3NjcmlwdD5cXG5cXG5cXG48c3R5bGUgc2NvcGVkPlxcbiAgLmZpbHRlci1tZW51X19iYXNlIHtcXG4gICAgYmFja2dyb3VuZC1jb2xvcjogI2RiZGJkYjtcXG4gICAgYm9yZGVyLXJhZGl1czogMnB4O1xcbiAgICBoZWlnaHQ6IDMwcHg7XFxuICAgIG1heC13aWR0aDogMzAwcHg7XFxuICB9XFxuXFxuICAuZmlsdGVyLW1lbnVfX2Jhc2U6YWZ0ZXIge1xcbiAgICBjb250ZW50OiAnJztcXG4gICAgcG9zaXRpb246IGFic29sdXRlO1xcbiAgICB0b3A6IDA7XFxuICAgIGxlZnQ6IDA7XFxuICAgIGhlaWdodDogMTAwJTtcXG4gICAgd2lkdGg6IDEwMCU7XFxuICAgIGJhY2tncm91bmQtY29sb3I6IHJnYmEoMCwgMCwgMCwgLjAzKTtcXG4gICAgb3BhY2l0eTogMDtcXG4gICAgdHJhbnNpdGlvbjogMjUwbXMgZWFzZSBvcGFjaXR5O1xcbiAgfVxcblxcbiAgLmZpbHRlci1tZW51OmZvY3VzID4gLmZpbHRlci1tZW51X19iYXNlOmFmdGVyLFxcbiAgLmZpbHRlci1tZW51OmZvY3VzLXdpdGhpbiA+IC5maWx0ZXItbWVudV9fYmFzZTphZnRlcixcXG4gIC5maWx0ZXItbWVudTpob3ZlciA+IC5maWx0ZXItbWVudV9fYmFzZTphZnRlciB7XFxuICAgIG9wYWNpdHk6IDE7XFxuICB9XFxuXFxuICAuZmlsdGVyLW1lbnUtLWVycm9yIC5maWx0ZXItbWVudV9fYmFzZSB7XFxuICAgIGJhY2tncm91bmQtY29sb3I6ICNmMmM2YzY7XFxuICAgIGNvbG9yOiAjZWQ1OTVhO1xcbiAgfVxcblxcbiAgLmZpbHRlci1tZW51X19sYWJlbCB7XFxuICAgIGNvbG9yOiBpbmhlcml0O1xcbiAgICB6LWluZGV4OiAxO1xcbiAgICBwYWRkaW5nOiA1cHggNXB4IDVweCAxMHB4O1xcbiAgfVxcblxcbiAgLmZpbHRlci1tZW51X19idXR0b24ge1xcbiAgICBvcGFjaXR5OiAwO1xcbiAgICBwYWRkaW5nOiA1cHg7XFxuICAgIHRyYW5zaXRpb246IGFsbCAzMDBtcyBlYXNlLWluLW91dDtcXG4gICAgei1pbmRleDogMTtcXG4gIH1cXG5cXG4gIC5maWx0ZXItbWVudV9fYmFzZTpmb2N1cy13aXRoaW4gLmZpbHRlci1tZW51X19idXR0b24sXFxuICAuZmlsdGVyLW1lbnVfX2Jhc2U6aG92ZXIgLmZpbHRlci1tZW51X19idXR0b24ge1xcbiAgICBvcGFjaXR5OiAxO1xcbiAgfVxcblxcbiAgLmZpbHRlci1tZW51X19saXN0IHtcXG4gICAgYmFja2dyb3VuZC1jb2xvcjogI2ZmZjtcXG4gICAgYm9yZGVyLXJhZGl1czogM3B4O1xcbiAgICBib3JkZXI6IDFweCBzb2xpZCAjZjJmMmYyO1xcbiAgICBib3gtc2hhZG93OiAwIDFweCAzcHggcmdiYSgwLCAwLCAwLCAuMik7XFxuICAgIGxlZnQ6IDA7XFxuICAgIG1pbi13aWR0aDogMjAwcHg7XFxuICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcXG4gICAgdG9wOiAzMHB4O1xcbiAgICB6LWluZGV4OiAyO1xcbiAgfVxcbjwvc3R5bGU+XFxuXCJdLFwic291cmNlUm9vdFwiOlwiXCJ9XSk7XG5cbi8vIGV4cG9ydHNcblxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXI/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LTYyODYzMjJiXCIsXCJzY29wZWRcIjp0cnVlLFwiaGFzSW5saW5lQ29uZmlnXCI6dHJ1ZX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyL2luZGV4LmpzP3NvdXJjZU1hcCEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XCJ2dWVcIjp0cnVlLFwiaWRcIjpcImRhdGEtdi02Mjg2MzIyYlwiLFwic2NvcGVkXCI6dHJ1ZSxcImhhc0lubGluZUNvbmZpZ1wiOnRydWV9IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJNZW51LnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDEiLCJ2YXIgcmVuZGVyID0gZnVuY3Rpb24oKSB7XG4gIHZhciBfdm0gPSB0aGlzXG4gIHZhciBfaCA9IF92bS4kY3JlYXRlRWxlbWVudFxuICB2YXIgX2MgPSBfdm0uX3NlbGYuX2MgfHwgX2hcbiAgcmV0dXJuIF9jKFxuICAgIFwiZGl2XCIsXG4gICAge1xuICAgICAgcmVmOiBcImZpbHRlck1lbnVcIixcbiAgICAgIHN0YXRpY0NsYXNzOiBcImZpbHRlci1tZW51IGFnLWZsZXgtd3JhcCByZWxhdGl2ZVBvc2l0aW9uXCIsXG4gICAgICBjbGFzczogeyBcImZpbHRlci1tZW51LS1lcnJvclwiOiBfdm0uc2hvd0Vycm9yIH1cbiAgICB9LFxuICAgIFtcbiAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwiZmlsdGVyLW1lbnVfX2Jhc2UgYWctZmxleCBhZy1hbGlnbi1jZW50ZXJcIiB9LCBbXG4gICAgICAgIF9jKFxuICAgICAgICAgIFwiYnV0dG9uXCIsXG4gICAgICAgICAge1xuICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwidHJ1bmNhdGUgdHJhbnNwYXJlbnQtYnV0dG9uIGZpbHRlci1tZW51X19sYWJlbFwiLFxuICAgICAgICAgICAgYXR0cnM6IHsgdHlwZTogXCJidXR0b25cIiwgdGl0bGU6IF92bS5maWx0ZXJUZXh0IH0sXG4gICAgICAgICAgICBvbjogeyBjbGljazogX3ZtLnRvZ2dsZSB9XG4gICAgICAgICAgfSxcbiAgICAgICAgICBbXG4gICAgICAgICAgICBfYyhcInN0cm9uZ1wiLCBbX3ZtLl92KFwiIFwiICsgX3ZtLl9zKF92bS5maWx0ZXIubGFiZWwpICsgXCIgXCIpXSksXG4gICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgX3ZtLnNob3dFcnJvclxuICAgICAgICAgICAgICA/IFtfdm0uX3YoXCJpcyBtaXNzaW5nIHZhbHVlXCIpXVxuICAgICAgICAgICAgICA6IFtfdm0uX3YoX3ZtLl9zKF92bS5odW1hbml6ZWRPcGVyYXRvclZhbHVlKSldXG4gICAgICAgICAgXSxcbiAgICAgICAgICAyXG4gICAgICAgICksXG4gICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgIF9jKFxuICAgICAgICAgIFwiYnV0dG9uXCIsXG4gICAgICAgICAge1xuICAgICAgICAgICAgc3RhdGljQ2xhc3M6XG4gICAgICAgICAgICAgIFwidHJhbnNwYXJlbnQtYnV0dG9uIGFnLWZsZXggYWctYWxpZ24tY2VudGVyIGFnLWZsZXgtc2hyaW5rLTAgY29sLWhyLTEgZmlsdGVyLW1lbnVfX2J1dHRvblwiLFxuICAgICAgICAgICAgY2xhc3M6IF92bS5zaG93RXJyb3IgPyBcInRleHQtcHJpbWFyeS1yZWRcIiA6IFwidGV4dC0tbWlkLWdyZXlcIixcbiAgICAgICAgICAgIGF0dHJzOiB7IHR5cGU6IFwiYnV0dG9uXCIsIHRpdGxlOiBcIlJlbW92ZSB0aGlzIGZpbHRlclwiIH0sXG4gICAgICAgICAgICBvbjoge1xuICAgICAgICAgICAgICBjbGljazogZnVuY3Rpb24oJGV2ZW50KSB7XG4gICAgICAgICAgICAgICAgX3ZtLiRlbWl0KFwicmVtb3ZlXCIsIF92bS5maWx0ZXIpXG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9LFxuICAgICAgICAgIFtcbiAgICAgICAgICAgIF9jKFwiZm0taWNvblwiLCB7XG4gICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImFnLWljb24tLW1kIGFnLWljb24tLWN1cnJlbnRcIixcbiAgICAgICAgICAgICAgYXR0cnM6IHsgaWNvbjogXCJ0aW1lc1wiIH1cbiAgICAgICAgICAgIH0pXG4gICAgICAgICAgXSxcbiAgICAgICAgICAxXG4gICAgICAgIClcbiAgICAgIF0pLFxuICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgIF9jKFwidHJhbnNpdGlvblwiLCB7IGF0dHJzOiB7IG5hbWU6IFwibGlzdC1kb3duXCIgfSB9LCBbXG4gICAgICAgIF9jKFxuICAgICAgICAgIFwiZm9ybVwiLFxuICAgICAgICAgIHtcbiAgICAgICAgICAgIGRpcmVjdGl2ZXM6IFtcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIG5hbWU6IFwic2hvd1wiLFxuICAgICAgICAgICAgICAgIHJhd05hbWU6IFwidi1zaG93XCIsXG4gICAgICAgICAgICAgICAgdmFsdWU6IF92bS52aXNpYmxlLFxuICAgICAgICAgICAgICAgIGV4cHJlc3Npb246IFwidmlzaWJsZVwiXG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIF0sXG4gICAgICAgICAgICBzdGF0aWNDbGFzczogXCJmaWx0ZXItbWVudV9fbGlzdCB1aSBmb3JtXCIsXG4gICAgICAgICAgICBvbjoge1xuICAgICAgICAgICAgICBzdWJtaXQ6IGZ1bmN0aW9uKCRldmVudCkge1xuICAgICAgICAgICAgICAgICRldmVudC5wcmV2ZW50RGVmYXVsdCgpXG4gICAgICAgICAgICAgICAgcmV0dXJuIF92bS5oaWRlKCRldmVudClcbiAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICAgIH0sXG4gICAgICAgICAgW1xuICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgIFwia2VlcC1hbGl2ZVwiLFxuICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgX2MoX3ZtLmN1cnJlbnRGaWx0ZXJUeXBlLCB7XG4gICAgICAgICAgICAgICAgICB0YWc6IFwiY29tcG9uZW50XCIsXG4gICAgICAgICAgICAgICAgICBhdHRyczogeyBmaWx0ZXI6IF92bS5maWx0ZXIgfSxcbiAgICAgICAgICAgICAgICAgIG9uOiB7IHVwZGF0ZTogX3ZtLmhhbmRsZUZpbHRlclVwZGF0ZSB9XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICAgMVxuICAgICAgICAgICAgKVxuICAgICAgICAgIF0sXG4gICAgICAgICAgMVxuICAgICAgICApXG4gICAgICBdKVxuICAgIF0sXG4gICAgMVxuICApXG59XG52YXIgc3RhdGljUmVuZGVyRm5zID0gW11cbnJlbmRlci5fd2l0aFN0cmlwcGVkID0gdHJ1ZVxubW9kdWxlLmV4cG9ydHMgPSB7IHJlbmRlcjogcmVuZGVyLCBzdGF0aWNSZW5kZXJGbnM6IHN0YXRpY1JlbmRlckZucyB9XG5pZiAobW9kdWxlLmhvdCkge1xuICBtb2R1bGUuaG90LmFjY2VwdCgpXG4gIGlmIChtb2R1bGUuaG90LmRhdGEpIHtcbiAgICByZXF1aXJlKFwidnVlLWhvdC1yZWxvYWQtYXBpXCIpICAgICAgLnJlcmVuZGVyKFwiZGF0YS12LTYyODYzMjJiXCIsIG1vZHVsZS5leHBvcnRzKVxuICB9XG59XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvdGVtcGxhdGUtY29tcGlsZXI/e1wiaWRcIjpcImRhdGEtdi02Mjg2MzIyYlwiLFwiaGFzU2NvcGVkXCI6dHJ1ZSxcImJ1YmxlXCI6e1widHJhbnNmb3Jtc1wiOnt9fX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWVcbi8vIG1vZHVsZSBpZCA9IC4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3RlbXBsYXRlLWNvbXBpbGVyL2luZGV4LmpzP3tcImlkXCI6XCJkYXRhLXYtNjI4NjMyMmJcIixcImhhc1Njb3BlZFwiOnRydWUsXCJidWJsZVwiOntcInRyYW5zZm9ybXNcIjp7fX19IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9dGVtcGxhdGUmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gMSIsIi8vIHN0eWxlLWxvYWRlcjogQWRkcyBzb21lIGNzcyB0byB0aGUgRE9NIGJ5IGFkZGluZyBhIDxzdHlsZT4gdGFnXG5cbi8vIGxvYWQgdGhlIHN0eWxlc1xudmFyIGNvbnRlbnQgPSByZXF1aXJlKFwiISEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi02Mjg2MzIyYlxcXCIsXFxcInNjb3BlZFxcXCI6dHJ1ZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlck1lbnUudnVlXCIpO1xuaWYodHlwZW9mIGNvbnRlbnQgPT09ICdzdHJpbmcnKSBjb250ZW50ID0gW1ttb2R1bGUuaWQsIGNvbnRlbnQsICcnXV07XG5pZihjb250ZW50LmxvY2FscykgbW9kdWxlLmV4cG9ydHMgPSBjb250ZW50LmxvY2Fscztcbi8vIGFkZCB0aGUgc3R5bGVzIHRvIHRoZSBET01cbnZhciB1cGRhdGUgPSByZXF1aXJlKFwiIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyL2xpYi9hZGRTdHlsZXNDbGllbnQuanNcIikoXCJlZmM1YmY2MFwiLCBjb250ZW50LCBmYWxzZSwge30pO1xuLy8gSG90IE1vZHVsZSBSZXBsYWNlbWVudFxuaWYobW9kdWxlLmhvdCkge1xuIC8vIFdoZW4gdGhlIHN0eWxlcyBjaGFuZ2UsIHVwZGF0ZSB0aGUgPHN0eWxlPiB0YWdzXG4gaWYoIWNvbnRlbnQubG9jYWxzKSB7XG4gICBtb2R1bGUuaG90LmFjY2VwdChcIiEhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtNjI4NjMyMmJcXFwiLFxcXCJzY29wZWRcXFwiOnRydWUsXFxcImhhc0lubGluZUNvbmZpZ1xcXCI6dHJ1ZX0hLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9GaWx0ZXJNZW51LnZ1ZVwiLCBmdW5jdGlvbigpIHtcbiAgICAgdmFyIG5ld0NvbnRlbnQgPSByZXF1aXJlKFwiISEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcXFwidnVlXFxcIjp0cnVlLFxcXCJpZFxcXCI6XFxcImRhdGEtdi02Mjg2MzIyYlxcXCIsXFxcInNjb3BlZFxcXCI6dHJ1ZSxcXFwiaGFzSW5saW5lQ29uZmlnXFxcIjp0cnVlfSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL0ZpbHRlck1lbnUudnVlXCIpO1xuICAgICBpZih0eXBlb2YgbmV3Q29udGVudCA9PT0gJ3N0cmluZycpIG5ld0NvbnRlbnQgPSBbW21vZHVsZS5pZCwgbmV3Q29udGVudCwgJyddXTtcbiAgICAgdXBkYXRlKG5ld0NvbnRlbnQpO1xuICAgfSk7XG4gfVxuIC8vIFdoZW4gdGhlIG1vZHVsZSBpcyBkaXNwb3NlZCwgcmVtb3ZlIHRoZSA8c3R5bGU+IHRhZ3NcbiBtb2R1bGUuaG90LmRpc3Bvc2UoZnVuY3Rpb24oKSB7IHVwZGF0ZSgpOyB9KTtcbn1cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyIS4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXI/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LTYyODYzMjJiXCIsXCJzY29wZWRcIjp0cnVlLFwiaGFzSW5saW5lQ29uZmlnXCI6dHJ1ZX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy92dWUtc3R5bGUtbG9hZGVyL2luZGV4LmpzIS4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3N0eWxlLWNvbXBpbGVyL2luZGV4LmpzP3tcInZ1ZVwiOnRydWUsXCJpZFwiOlwiZGF0YS12LTYyODYzMjJiXCIsXCJzY29wZWRcIjp0cnVlLFwiaGFzSW5saW5lQ29uZmlnXCI6dHJ1ZX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zdHlsZXMmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gMSIsInZhciBkaXNwb3NlZCA9IGZhbHNlXG5mdW5jdGlvbiBpbmplY3RTdHlsZSAoc3NyQ29udGV4dCkge1xuICBpZiAoZGlzcG9zZWQpIHJldHVyblxuICByZXF1aXJlKFwiISF2dWUtc3R5bGUtbG9hZGVyIWNzcy1sb2FkZXI/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleD97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtNjI4NjMyMmJcXFwiLFxcXCJzY29wZWRcXFwiOnRydWUsXFxcImhhc0lubGluZUNvbmZpZ1xcXCI6dHJ1ZX0hLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9GaWx0ZXJNZW51LnZ1ZVwiKVxufVxudmFyIG5vcm1hbGl6ZUNvbXBvbmVudCA9IHJlcXVpcmUoXCIhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2NvbXBvbmVudC1ub3JtYWxpemVyXCIpXG4vKiBzY3JpcHQgKi9cbnZhciBfX3Z1ZV9zY3JpcHRfXyA9IHJlcXVpcmUoXCIhIWJhYmVsLWxvYWRlcj97XFxcImNhY2hlRGlyZWN0b3J5XFxcIjp0cnVlLFxcXCJwcmVzZXRzXFxcIjpbW1xcXCJlbnZcXFwiLHtcXFwibW9kdWxlc1xcXCI6ZmFsc2UsXFxcInRhcmdldHNcXFwiOntcXFwiYnJvd3NlcnNcXFwiOltcXFwiPiAyJVxcXCJdLFxcXCJ1Z2xpZnlcXFwiOnRydWV9fV0sXFxcImJhYmVsLXByZXNldC1lbnZcXFwiXSxcXFwicGx1Z2luc1xcXCI6W1xcXCJ0cmFuc2Zvcm0tb2JqZWN0LXJlc3Qtc3ByZWFkXFxcIixbXFxcInRyYW5zZm9ybS1ydW50aW1lXFxcIix7XFxcInBvbHlmaWxsXFxcIjpmYWxzZSxcXFwiaGVscGVyc1xcXCI6ZmFsc2V9XSxcXFwic3ludGF4LWR5bmFtaWMtaW1wb3J0XFxcIl19IS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvcj90eXBlPXNjcmlwdCZpbmRleD0wIS4vRmlsdGVyTWVudS52dWVcIilcbi8qIHRlbXBsYXRlICovXG52YXIgX192dWVfdGVtcGxhdGVfXyA9IHJlcXVpcmUoXCIhIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlci9pbmRleD97XFxcImlkXFxcIjpcXFwiZGF0YS12LTYyODYzMjJiXFxcIixcXFwiaGFzU2NvcGVkXFxcIjp0cnVlLFxcXCJidWJsZVxcXCI6e1xcXCJ0cmFuc2Zvcm1zXFxcIjp7fX19IS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvcj90eXBlPXRlbXBsYXRlJmluZGV4PTAhLi9GaWx0ZXJNZW51LnZ1ZVwiKVxuLyogdGVtcGxhdGUgZnVuY3Rpb25hbCAqL1xudmFyIF9fdnVlX3RlbXBsYXRlX2Z1bmN0aW9uYWxfXyA9IGZhbHNlXG4vKiBzdHlsZXMgKi9cbnZhciBfX3Z1ZV9zdHlsZXNfXyA9IGluamVjdFN0eWxlXG4vKiBzY29wZUlkICovXG52YXIgX192dWVfc2NvcGVJZF9fID0gXCJkYXRhLXYtNjI4NjMyMmJcIlxuLyogbW9kdWxlSWRlbnRpZmllciAoc2VydmVyIG9ubHkpICovXG52YXIgX192dWVfbW9kdWxlX2lkZW50aWZpZXJfXyA9IG51bGxcbnZhciBDb21wb25lbnQgPSBub3JtYWxpemVDb21wb25lbnQoXG4gIF9fdnVlX3NjcmlwdF9fLFxuICBfX3Z1ZV90ZW1wbGF0ZV9fLFxuICBfX3Z1ZV90ZW1wbGF0ZV9mdW5jdGlvbmFsX18sXG4gIF9fdnVlX3N0eWxlc19fLFxuICBfX3Z1ZV9zY29wZUlkX18sXG4gIF9fdnVlX21vZHVsZV9pZGVudGlmaWVyX19cbilcbkNvbXBvbmVudC5vcHRpb25zLl9fZmlsZSA9IFwicmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWVcIlxuXG4vKiBob3QgcmVsb2FkICovXG5pZiAobW9kdWxlLmhvdCkgeyhmdW5jdGlvbiAoKSB7XG4gIHZhciBob3RBUEkgPSByZXF1aXJlKFwidnVlLWhvdC1yZWxvYWQtYXBpXCIpXG4gIGhvdEFQSS5pbnN0YWxsKHJlcXVpcmUoXCJ2dWVcIiksIGZhbHNlKVxuICBpZiAoIWhvdEFQSS5jb21wYXRpYmxlKSByZXR1cm5cbiAgbW9kdWxlLmhvdC5hY2NlcHQoKVxuICBpZiAoIW1vZHVsZS5ob3QuZGF0YSkge1xuICAgIGhvdEFQSS5jcmVhdGVSZWNvcmQoXCJkYXRhLXYtNjI4NjMyMmJcIiwgQ29tcG9uZW50Lm9wdGlvbnMpXG4gIH0gZWxzZSB7XG4gICAgaG90QVBJLnJlbG9hZChcImRhdGEtdi02Mjg2MzIyYlwiLCBDb21wb25lbnQub3B0aW9ucylcbiAgfVxuICBtb2R1bGUuaG90LmRpc3Bvc2UoZnVuY3Rpb24gKGRhdGEpIHtcbiAgICBkaXNwb3NlZCA9IHRydWVcbiAgfSlcbn0pKCl9XG5cbm1vZHVsZS5leHBvcnRzID0gQ29tcG9uZW50LmV4cG9ydHNcblxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWVcbi8vIG1vZHVsZSBpZCA9IC4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWVcbi8vIG1vZHVsZSBjaHVua3MgPSAxIiwiaW1wb3J0ICogYXMgT1BFUkFUT1IgZnJvbSAnLi9vcGVyYXRvcnMnO1xuXG5leHBvcnQgY29uc3QgREVGQVVMVF9GSUxURVJfVEVYVCA9ICh7IG9wZXJhdG9yLCB2YWx1ZSB9KSA9PiBgJHtvcGVyYXRvcn0gJHt2YWx1ZX1gO1xuXG5leHBvcnQgY29uc3QgSVMgPSB7XG4gIGlkOiBPUEVSQVRPUi5FUVVBTFMsXG4gIHZhbHVlOiAnaXMnLFxufTtcblxuZXhwb3J0IGNvbnN0IElTX05PVCA9IHtcbiAgaWQ6IE9QRVJBVE9SLk5PVF9FUVVBTFMsXG4gIHZhbHVlOiAnaXMgbm90Jyxcbn07XG5cbmV4cG9ydCBjb25zdCBTVEFSVFNfV0lUSCA9IHtcbiAgaWQ6IE9QRVJBVE9SLlNUQVJUU19XSVRILFxuICB2YWx1ZTogJ3N0YXJ0cyB3aXRoJyxcbn07XG5cbmV4cG9ydCBjb25zdCBFTkRTX1dJVEggPSB7XG4gIGlkOiBPUEVSQVRPUi5FTkRTX1dJVEgsXG4gIHZhbHVlOiAnZW5kcyB3aXRoJyxcbn07XG5cbmV4cG9ydCBjb25zdCBDT05UQUlOUyA9IHtcbiAgaWQ6IE9QRVJBVE9SLkNPTlRBSU5TLFxuICB2YWx1ZTogJ2NvbnRhaW5zJyxcbn07XG5cbmV4cG9ydCBjb25zdCBOT1RfQ09OVEFJTlMgPSB7XG4gIGlkOiBPUEVSQVRPUi5OT1RfQ09OVEFJTlMsXG4gIHZhbHVlOiAnZG9lcyBub3QgY29udGFpbicsXG59O1xuXG5leHBvcnQgY29uc3QgR1JFQVRFUl9USEFOID0ge1xuICBpZDogT1BFUkFUT1IuR1JFQVRFUl9USEFOLFxuICB2YWx1ZTogJ2lzIGdyZWF0ZXIgdGhhbicsXG59O1xuXG5leHBvcnQgY29uc3QgTEVTU19USEFOID0ge1xuICBpZDogT1BFUkFUT1IuTEVTU19USEFOLFxuICB2YWx1ZTogJ2lzIGxlc3MgdGhhbicsXG59O1xuXG5leHBvcnQgY29uc3QgVE9EQVkgPSB7XG4gIGlkOiBPUEVSQVRPUi5UT0RBWSxcbiAgdmFsdWU6ICdpcyB0b2RheScsXG4gIG1lc3NhZ2U6ICh7IG9wZXJhdG9yIH0pID0+IGAke29wZXJhdG9yfWAsXG59O1xuXG5leHBvcnQgY29uc3QgWUVTVEVSREFZID0ge1xuICBpZDogT1BFUkFUT1IuWUVTVEVSREFZLFxuICB2YWx1ZTogJ2lzIHllc3RlcmRheScsXG4gIG1lc3NhZ2U6ICh7IG9wZXJhdG9yIH0pID0+IGAke29wZXJhdG9yfWAsXG59O1xuXG5leHBvcnQgY29uc3QgTEFTVF83X0RBWVMgPSB7XG4gIGlkOiBPUEVSQVRPUi5MQVNUXzdfREFZUyxcbiAgdmFsdWU6ICdpcyBsYXN0IDcgZGF5cycsXG4gIG1lc3NhZ2U6ICh7IG9wZXJhdG9yIH0pID0+IGAke29wZXJhdG9yfWAsXG59O1xuXG5leHBvcnQgY29uc3QgTEFTVF8zMF9EQVlTID0ge1xuICBpZDogT1BFUkFUT1IuTEFTVF8zMF9EQVlTLFxuICB2YWx1ZTogJ2lzIGxhc3QgMzAgZGF5cycsXG4gIG1lc3NhZ2U6ICh7IG9wZXJhdG9yIH0pID0+IGAke29wZXJhdG9yfWAsXG59O1xuXG5leHBvcnQgY29uc3QgQ1VSUkVOVF9NT05USCA9IHtcbiAgaWQ6IE9QRVJBVE9SLkNVUlJFTlRfTU9OVEgsXG4gIHZhbHVlOiAnaXMgY3VycmVudCBtb250aCcsXG4gIG1lc3NhZ2U6ICh7IG9wZXJhdG9yIH0pID0+IGAke29wZXJhdG9yfWAsXG59O1xuXG5leHBvcnQgY29uc3QgTEFTVF9NT05USCA9IHtcbiAgaWQ6IE9QRVJBVE9SLkxBU1RfTU9OVEgsXG4gIHZhbHVlOiAnaXMgbGFzdCBtb250aCcsXG4gIG1lc3NhZ2U6ICh7IG9wZXJhdG9yIH0pID0+IGAke29wZXJhdG9yfWAsXG59O1xuXG5leHBvcnQgY29uc3QgQ1VTVE9NID0ge1xuICBpZDogT1BFUkFUT1IuQ1VTVE9NLFxuICB2YWx1ZTogJ2lzIGN1c3RvbScsXG4gIG1lc3NhZ2U6ICh7IHZhbHVlIH0pID0+IGBpcyBmcm9tICR7dmFsdWV9YCxcbn07XG5cbmV4cG9ydCBjb25zdCBVTktOT1dOID0ge1xuICBpZDogT1BFUkFUT1IuVU5LTk9XTixcbiAgdmFsdWU6ICdpcyBub3Qga25vd24nLFxufTtcblxuZXhwb3J0IGRlZmF1bHQgW1xuICBJUyxcbiAgSVNfTk9ULFxuICBTVEFSVFNfV0lUSCxcbiAgRU5EU19XSVRILFxuICBDT05UQUlOUyxcbiAgTk9UX0NPTlRBSU5TLFxuICBHUkVBVEVSX1RIQU4sXG4gIExFU1NfVEhBTixcbiAgVE9EQVksXG4gIFlFU1RFUkRBWSxcbiAgTEFTVF83X0RBWVMsXG4gIExBU1RfMzBfREFZUyxcbiAgQ1VSUkVOVF9NT05USCxcbiAgTEFTVF9NT05USCxcbiAgQ1VTVE9NLFxuICBVTktOT1dOLFxuXTtcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL2NvbnN0L2h1bWFuaXplZE9wZXJhdG9yLmpzIiwidmFyIG1hcCA9IHtcblx0XCIuL0ZpbHRlckRhdGVcIjogW1xuXHRcdFwiLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJEYXRlLnZ1ZVwiLFxuXHRcdDlcblx0XSxcblx0XCIuL0ZpbHRlckRhdGUudnVlXCI6IFtcblx0XHRcIi4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyRGF0ZS52dWVcIixcblx0XHQ5XG5cdF0sXG5cdFwiLi9GaWx0ZXJOdW1iZXJcIjogW1xuXHRcdFwiLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJOdW1iZXIudnVlXCIsXG5cdFx0OFxuXHRdLFxuXHRcIi4vRmlsdGVyTnVtYmVyLnZ1ZVwiOiBbXG5cdFx0XCIuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlck51bWJlci52dWVcIixcblx0XHQ4XG5cdF0sXG5cdFwiLi9GaWx0ZXJTZWxlY3RcIjogW1xuXHRcdFwiLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTZWxlY3QudnVlXCIsXG5cdFx0N1xuXHRdLFxuXHRcIi4vRmlsdGVyU2VsZWN0LnZ1ZVwiOiBbXG5cdFx0XCIuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlclNlbGVjdC52dWVcIixcblx0XHQ3XG5cdF0sXG5cdFwiLi9GaWx0ZXJTdHJpbmdcIjogW1xuXHRcdFwiLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTdHJpbmcudnVlXCIsXG5cdFx0NlxuXHRdLFxuXHRcIi4vRmlsdGVyU3RyaW5nLnZ1ZVwiOiBbXG5cdFx0XCIuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlclN0cmluZy52dWVcIixcblx0XHQ2XG5cdF1cbn07XG5mdW5jdGlvbiB3ZWJwYWNrQXN5bmNDb250ZXh0KHJlcSkge1xuXHR2YXIgaWRzID0gbWFwW3JlcV07XG5cdGlmKCFpZHMpXG5cdFx0cmV0dXJuIFByb21pc2UucmVqZWN0KG5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIgKyByZXEgKyBcIicuXCIpKTtcblx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18uZShpZHNbMV0pLnRoZW4oZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oaWRzWzBdKTtcblx0fSk7XG59O1xud2VicGFja0FzeW5jQ29udGV4dC5rZXlzID0gZnVuY3Rpb24gd2VicGFja0FzeW5jQ29udGV4dEtleXMoKSB7XG5cdHJldHVybiBPYmplY3Qua2V5cyhtYXApO1xufTtcbndlYnBhY2tBc3luY0NvbnRleHQuaWQgPSBcIi4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMgbGF6eSByZWN1cnNpdmUgXlxcXFwuXFxcXC9GaWx0ZXIuKiRcIjtcbm1vZHVsZS5leHBvcnRzID0gd2VicGFja0FzeW5jQ29udGV4dDtcblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzIGxhenkgXlxcLlxcL0ZpbHRlci4qJFxuLy8gbW9kdWxlIGlkID0gLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcyBsYXp5IHJlY3Vyc2l2ZSBeXFwuXFwvRmlsdGVyLiokXG4vLyBtb2R1bGUgY2h1bmtzID0gMSJdLCJzb3VyY2VSb290IjoiIn0=