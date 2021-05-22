webpackJsonp([4,6],{

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
		10
	],
	"./FilterDate.vue": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterDate.vue",
		10
	],
	"./FilterNumber": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterNumber.vue",
		9
	],
	"./FilterNumber.vue": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterNumber.vue",
		9
	],
	"./FilterSelect": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterSelect.vue",
		8
	],
	"./FilterSelect.vue": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterSelect.vue",
		8
	],
	"./FilterString": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterString.vue",
		7
	],
	"./FilterString.vue": [
		"./resources/assets/domain/common/components/fmFilter/types/FilterString.vue",
		7
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWUiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWU/NjM1ZCIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJNZW51LnZ1ZT8xY2QzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlPzk2YWEiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWUiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvY29uc3QvaHVtYW5pemVkT3BlcmF0b3IuanMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMgbGF6eSBeXFwuXFwvRmlsdGVyLiokIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2Z1bmN0aW9uYWwvRm1JY29uLmpzIl0sIm5hbWVzIjpbIk9QRVJBVE9SIiwiREVGQVVMVF9GSUxURVJfVEVYVCIsIm9wZXJhdG9yIiwidmFsdWUiLCJJUyIsImlkIiwiRVFVQUxTIiwiSVNfTk9UIiwiTk9UX0VRVUFMUyIsIlNUQVJUU19XSVRIIiwiRU5EU19XSVRIIiwiQ09OVEFJTlMiLCJOT1RfQ09OVEFJTlMiLCJHUkVBVEVSX1RIQU4iLCJMRVNTX1RIQU4iLCJUT0RBWSIsIm1lc3NhZ2UiLCJZRVNURVJEQVkiLCJMQVNUXzdfREFZUyIsIkxBU1RfMzBfREFZUyIsIkNVUlJFTlRfTU9OVEgiLCJMQVNUX01PTlRIIiwiQ1VTVE9NIiwiVU5LTk9XTiIsIm5hbWUiLCJmdW5jdGlvbmFsIiwicHJvcHMiLCJpY29uIiwidHlwZSIsIlN0cmluZyIsInJlcXVpcmVkIiwicmVuZGVyIiwiY3JlYXRlRWxlbWVudCIsImNvbnRleHQiLCJjbGFzcyIsImRhdGEiLCJzdGF0aWNDbGFzcyIsImF0dHJzIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBOENBOzs7O0FBQ0E7Ozs7OztBQUVBO0FBQ0E7QUFBQTtBQUFBOztBQUVBO0FBQ0E7QUFBQTtBQUFBOztrQkFFQTtBQUNBLG9CQURBO0FBRUE7QUFDQTtBQURBLEdBRkE7QUFLQTtBQUNBO0FBQ0Esa0JBREE7QUFFQTtBQUZBO0FBREEsR0FMQTtBQVdBO0FBQUE7QUFDQTtBQURBO0FBQUEsR0FYQTtBQWNBO0FBQ0EscUJBREEsK0JBQ0E7QUFBQTs7QUFDQTtBQUFBO0FBQUE7QUFDQSxLQUhBO0FBSUEsYUFKQSx1QkFJQTtBQUNBO0FBQ0EsS0FOQTtBQU9BLDBCQVBBLG9DQU9BO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQWZBO0FBZ0JBLGNBaEJBLHdCQWdCQTtBQUFBLG9CQUNBLFdBREE7QUFBQSxVQUNBLEtBREEsV0FDQSxLQURBO0FBQUEsVUFDQSxLQURBLFdBQ0EsS0FEQTs7QUFFQTtBQUNBO0FBQ0E7QUFwQkEsR0FkQTtBQW9DQTtBQUNBO0FBQ0EscUJBREE7QUFFQSxhQUZBLG1CQUVBLEtBRkEsRUFFQSxRQUZBLEVBRUE7QUFBQTs7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGFBRkEsTUFFQTtBQUNBO0FBQ0E7QUFDQSxXQU5BO0FBT0E7QUFDQTtBQVpBO0FBREEsR0FwQ0E7QUFvREEsU0FwREEscUJBb0RBO0FBQ0E7QUFD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QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7QUFDRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EscUM7Ozs7Ozs7Ozs7Ozs7a0JDOUNlO0FBQ1hDLFFBQU0sU0FESztBQUVYQyxjQUFZLElBRkQ7QUFHWEMsU0FBTztBQUNMQyxVQUFNO0FBQ0pDLFlBQU1DLE1BREY7QUFFSkMsZ0JBQVU7QUFGTjtBQURELEdBSEk7QUFTWEMsUUFUVyxrQkFTSkMsYUFUSSxFQVNXQyxPQVRYLEVBU29CO0FBQzdCLFdBQU9ELGNBQWMsS0FBZCxFQUFxQjtBQUMxQkUsYUFBTyxDQUNMLFNBREssRUFFTEQsUUFBUUUsSUFBUixDQUFhQyxXQUZSLENBRG1CO0FBSzFCQyxhQUFPO0FBQ0wsdUJBQWU7QUFEVjtBQUxtQixLQUFyQixFQVFKLENBQ0RMLGNBQWMsS0FBZCxFQUFxQjtBQUNuQkssYUFBTztBQUNMLG9DQUEwQkosUUFBUVAsS0FBUixDQUFjQztBQURuQztBQURZLEtBQXJCLENBREMsQ0FSSSxDQUFQO0FBZUQ7QUF6QlUsQyIsImZpbGUiOiI0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiPHRlbXBsYXRlPlxuICA8ZGl2XG4gICAgY2xhc3M9XCJmaWx0ZXItbWVudSBhZy1mbGV4LXdyYXAgcmVsYXRpdmVQb3NpdGlvblwiXG4gICAgOmNsYXNzPVwieyAnZmlsdGVyLW1lbnUtLWVycm9yJzogc2hvd0Vycm9yIH1cIlxuICAgIHJlZj1cImZpbHRlck1lbnVcIlxuICA+XG4gICAgPGRpdiBjbGFzcz1cImZpbHRlci1tZW51X19iYXNlIGFnLWZsZXggYWctYWxpZ24tY2VudGVyXCI+XG4gICAgICA8YnV0dG9uXG4gICAgICAgIHR5cGU9XCJidXR0b25cIlxuICAgICAgICBjbGFzcz1cInRydW5jYXRlIHRyYW5zcGFyZW50LWJ1dHRvbiBmaWx0ZXItbWVudV9fbGFiZWxcIlxuICAgICAgICA6dGl0bGU9XCJmaWx0ZXJUZXh0XCJcbiAgICAgICAgQGNsaWNrPVwidG9nZ2xlXCJcbiAgICAgID5cbiAgICAgICAgPHN0cm9uZz4ge3sgZmlsdGVyLmxhYmVsIH19IDwvc3Ryb25nPlxuICAgICAgICA8dGVtcGxhdGUgdi1pZj1cInNob3dFcnJvclwiPmlzIG1pc3NpbmcgdmFsdWU8L3RlbXBsYXRlPlxuICAgICAgICA8dGVtcGxhdGUgdi1lbHNlPnt7IGh1bWFuaXplZE9wZXJhdG9yVmFsdWUgfX08L3RlbXBsYXRlPlxuICAgICAgPC9idXR0b24+XG4gICAgICA8YnV0dG9uXG4gICAgICAgIHR5cGU9XCJidXR0b25cIlxuICAgICAgICBjbGFzcz1cInRyYW5zcGFyZW50LWJ1dHRvbiBhZy1mbGV4IGFnLWFsaWduLWNlbnRlciBhZy1mbGV4LXNocmluay0wIGNvbC1oci0xIGZpbHRlci1tZW51X19idXR0b25cIlxuICAgICAgICA6Y2xhc3M9XCJzaG93RXJyb3IgPyAndGV4dC1wcmltYXJ5LXJlZCcgOiAndGV4dC0tbWlkLWdyZXknXCJcbiAgICAgICAgdGl0bGU9XCJSZW1vdmUgdGhpcyBmaWx0ZXJcIlxuICAgICAgICBAY2xpY2s9XCIkZW1pdCgncmVtb3ZlJywgZmlsdGVyKVwiXG4gICAgICA+XG4gICAgICAgIDxmbS1pY29uIGljb249XCJ0aW1lc1wiIGNsYXNzPVwiYWctaWNvbi0tbWQgYWctaWNvbi0tY3VycmVudFwiLz5cbiAgICAgIDwvYnV0dG9uPlxuICAgIDwvZGl2PlxuICAgIDx0cmFuc2l0aW9uIG5hbWU9XCJsaXN0LWRvd25cIj5cbiAgICAgIDxmb3JtXG4gICAgICAgIGNsYXNzPVwiZmlsdGVyLW1lbnVfX2xpc3QgdWkgZm9ybVwiXG4gICAgICAgIHYtc2hvdz1cInZpc2libGVcIlxuICAgICAgICBAc3VibWl0LnByZXZlbnQ9XCJoaWRlXCJcbiAgICAgID5cbiAgICAgICAgPGtlZXAtYWxpdmU+XG4gICAgICAgICAgPGNvbXBvbmVudFxuICAgICAgICAgICAgOmlzPVwiY3VycmVudEZpbHRlclR5cGVcIlxuICAgICAgICAgICAgOmZpbHRlcj1cImZpbHRlclwiXG4gICAgICAgICAgICBAdXBkYXRlPVwiaGFuZGxlRmlsdGVyVXBkYXRlXCJcbiAgICAgICAgICA+PC9jb21wb25lbnQ+XG4gICAgICAgIDwva2VlcC1hbGl2ZT5cbiAgICAgIDwvZm9ybT5cbiAgICA8L3RyYW5zaXRpb24+XG4gIDwvZGl2PlxuPC90ZW1wbGF0ZT5cblxuPHNjcmlwdD5cbiAgaW1wb3J0IEZtSWNvbiBmcm9tICcuLi9mdW5jdGlvbmFsL0ZtSWNvbic7XG4gIGltcG9ydCBPUEVSQVRPUl9WQUxVRV9JRF9NQVAsIHsgREVGQVVMVF9GSUxURVJfVEVYVCB9IGZyb20gJy4vY29uc3QvaHVtYW5pemVkT3BlcmF0b3InO1xuXG4gIGNvbnN0IEhVTUFOSVpFRF9PUEVSQVRPUl9NQVAgPSBuZXcgTWFwKCk7XG4gIE9QRVJBVE9SX1ZBTFVFX0lEX01BUC5mb3JFYWNoKG9wZXJhdG9yID0+IEhVTUFOSVpFRF9PUEVSQVRPUl9NQVAuc2V0KG9wZXJhdG9yLmlkLCBvcGVyYXRvci52YWx1ZSwgb3BlcmF0b3IubWVzc2FnZSkpO1xuXG4gIGNvbnN0IE9QRVJBVE9SX01FU1NBR0VfTUFQID0gbmV3IE1hcCgpO1xuICBPUEVSQVRPUl9WQUxVRV9JRF9NQVAuZm9yRWFjaChvcGVyYXRvciA9PiBPUEVSQVRPUl9NRVNTQUdFX01BUC5zZXQob3BlcmF0b3IuaWQsIG9wZXJhdG9yLm1lc3NhZ2UpKTtcblxuICBleHBvcnQgZGVmYXVsdCB7XG4gICAgbmFtZTogJ0ZpbHRlck1lbnUnLFxuICAgIGNvbXBvbmVudHM6IHtcbiAgICAgIEZtSWNvbixcbiAgICB9LFxuICAgIHByb3BzOiB7XG4gICAgICBmaWx0ZXI6IHtcbiAgICAgICAgdHlwZTogT2JqZWN0LFxuICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgIH0sXG4gICAgfSxcbiAgICBkYXRhOiAoKSA9PiAoe1xuICAgICAgdmlzaWJsZTogdHJ1ZSxcbiAgICB9KSxcbiAgICBjb21wdXRlZDoge1xuICAgICAgY3VycmVudEZpbHRlclR5cGUoKSB7XG4gICAgICAgIHJldHVybiAoKSA9PiBpbXBvcnQoYC4vdHlwZXMvRmlsdGVyJHt0aGlzLmZpbHRlci50eXBlfWApO1xuICAgICAgfSxcbiAgICAgIHNob3dFcnJvcigpIHtcbiAgICAgICAgcmV0dXJuICF0aGlzLmZpbHRlci52YWx1ZSAmJiAhdGhpcy52aXNpYmxlO1xuICAgICAgfSxcbiAgICAgIGh1bWFuaXplZE9wZXJhdG9yVmFsdWUoKSB7XG4gICAgICAgIGNvbnN0IHZhbHVlID0gdGhpcy5maWx0ZXIudmFsdWUgfHwgJyc7XG4gICAgICAgIGNvbnN0IG9wZXJhdG9yID0gSFVNQU5JWkVEX09QRVJBVE9SX01BUC5nZXQodGhpcy5maWx0ZXIub3BlcmF0b3IpIHx8ICcnO1xuICAgICAgICBjb25zdCBvcGVyYXRvck1lc3NhZ2UgPSBPUEVSQVRPUl9NRVNTQUdFX01BUC5nZXQodGhpcy5maWx0ZXIub3BlcmF0b3IpO1xuICAgICAgICBpZiAodHlwZW9mIG9wZXJhdG9yTWVzc2FnZSA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgICAgIHJldHVybiBvcGVyYXRvck1lc3NhZ2UoeyBvcGVyYXRvciwgdmFsdWUgfSkgfHwgJyc7XG4gICAgICAgIH1cbiAgICAgICAgcmV0dXJuIERFRkFVTFRfRklMVEVSX1RFWFQoeyBvcGVyYXRvciwgdmFsdWUgfSkgfHwgJyc7XG4gICAgICB9LFxuICAgICAgZmlsdGVyVGV4dCgpIHtcbiAgICAgICAgY29uc3QgeyBsYWJlbCwgdmFsdWUgfSA9IHRoaXMuZmlsdGVyO1xuICAgICAgICBjb25zdCBtZXNzYWdlID0gdmFsdWUgPyB0aGlzLmh1bWFuaXplZE9wZXJhdG9yVmFsdWUgOiAnaXMgbWlzc2luZyB2YWx1ZSc7XG4gICAgICAgIHJldHVybiBgJHtsYWJlbH0gJHttZXNzYWdlfWA7XG4gICAgICB9LFxuICAgIH0sXG4gICAgd2F0Y2g6IHtcbiAgICAgIHZpc2libGU6IHtcbiAgICAgICAgaW1tZWRpYXRlOiB0cnVlLFxuICAgICAgICBoYW5kbGVyKHZhbHVlLCBvbGRWYWx1ZSkge1xuICAgICAgICAgIGlmICh2YWx1ZSAhPT0gb2xkVmFsdWUpIHtcbiAgICAgICAgICAgIHRoaXMuJG5leHRUaWNrKCgpID0+IHtcbiAgICAgICAgICAgICAgaWYgKHZhbHVlKSB7XG4gICAgICAgICAgICAgICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCB0aGlzLmhhbmRsZUNsaWNrKTtcbiAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBkb2N1bWVudC5yZW1vdmVFdmVudExpc3RlbmVyKCdjbGljaycsIHRoaXMuaGFuZGxlQ2xpY2spO1xuICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICB9LFxuICAgIH0sXG4gICAgY3JlYXRlZCgpIHtcbiAgICAgIGlmICh0aGlzLmZpbHRlci5zYXZlZCkge1xuICAgICAgICB0aGlzLmhpZGUoKTtcbiAgICAgIH1cbiAgICB9LFxuICAgIGJlZm9yZURlc3Ryb3koKSB7XG4gICAgICBkb2N1bWVudC5yZW1vdmVFdmVudExpc3RlbmVyKCdjbGljaycsIHRoaXMuaGFuZGxlQ2xpY2spO1xuICAgIH0sXG4gICAgbWV0aG9kczoge1xuICAgICAgaGFuZGxlQ2xpY2soZXZlbnQpIHtcbiAgICAgICAgaWYgKHRoaXMudmlzaWJsZSkge1xuICAgICAgICAgIGNvbnN0IHsgdGFyZ2V0IH0gPSBldmVudDtcbiAgICAgICAgICBjb25zdCB7IGZpbHRlck1lbnUgfSA9IHRoaXMuJHJlZnM7XG4gICAgICAgICAgaWYgKHRhcmdldCAhPT0gZmlsdGVyTWVudSAmJiAhZmlsdGVyTWVudS5jb250YWlucyh0YXJnZXQpKSB7XG4gICAgICAgICAgICB0aGlzLmhpZGUoKTtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0sXG4gICAgICB0b2dnbGUoKSB7XG4gICAgICAgIGlmICh0aGlzLnZpc2libGUpIHtcbiAgICAgICAgICB0aGlzLmhpZGUoKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICB0aGlzLnNob3coKTtcbiAgICAgICAgfVxuICAgICAgfSxcbiAgICAgIHNob3coKSB7XG4gICAgICAgIHRoaXMudmlzaWJsZSA9IHRydWU7XG4gICAgICB9LFxuICAgICAgaGlkZSgpIHtcbiAgICAgICAgdGhpcy52aXNpYmxlID0gZmFsc2U7XG4gICAgICB9LFxuICAgICAgaGFuZGxlRmlsdGVyVXBkYXRlKHsgb3BlcmF0b3IsIHZhbHVlIH0pIHtcbiAgICAgICAgY29uc3QgdXBkYXRlZEZpbHRlciA9IHsgLi4udGhpcy5maWx0ZXIsIG9wZXJhdG9yLCB2YWx1ZSB9O1xuICAgICAgICB0aGlzLiRlbWl0KCd1cGRhdGU6ZmlsdGVyJywgdXBkYXRlZEZpbHRlcik7XG4gICAgICB9LFxuICAgIH0sXG4gIH07XG48L3NjcmlwdD5cblxuXG48c3R5bGUgc2NvcGVkPlxuICAuZmlsdGVyLW1lbnVfX2Jhc2Uge1xuICAgIGJhY2tncm91bmQtY29sb3I6ICNkYmRiZGI7XG4gICAgYm9yZGVyLXJhZGl1czogMnB4O1xuICAgIGhlaWdodDogMzBweDtcbiAgICBtYXgtd2lkdGg6IDMwMHB4O1xuICB9XG5cbiAgLmZpbHRlci1tZW51X19iYXNlOmFmdGVyIHtcbiAgICBjb250ZW50OiAnJztcbiAgICBwb3NpdGlvbjogYWJzb2x1dGU7XG4gICAgdG9wOiAwO1xuICAgIGxlZnQ6IDA7XG4gICAgaGVpZ2h0OiAxMDAlO1xuICAgIHdpZHRoOiAxMDAlO1xuICAgIGJhY2tncm91bmQtY29sb3I6IHJnYmEoMCwgMCwgMCwgLjAzKTtcbiAgICBvcGFjaXR5OiAwO1xuICAgIHRyYW5zaXRpb246IDI1MG1zIGVhc2Ugb3BhY2l0eTtcbiAgfVxuXG4gIC5maWx0ZXItbWVudTpmb2N1cyA+IC5maWx0ZXItbWVudV9fYmFzZTphZnRlcixcbiAgLmZpbHRlci1tZW51OmZvY3VzLXdpdGhpbiA+IC5maWx0ZXItbWVudV9fYmFzZTphZnRlcixcbiAgLmZpbHRlci1tZW51OmhvdmVyID4gLmZpbHRlci1tZW51X19iYXNlOmFmdGVyIHtcbiAgICBvcGFjaXR5OiAxO1xuICB9XG5cbiAgLmZpbHRlci1tZW51LS1lcnJvciAuZmlsdGVyLW1lbnVfX2Jhc2Uge1xuICAgIGJhY2tncm91bmQtY29sb3I6ICNmMmM2YzY7XG4gICAgY29sb3I6ICNlZDU5NWE7XG4gIH1cblxuICAuZmlsdGVyLW1lbnVfX2xhYmVsIHtcbiAgICBjb2xvcjogaW5oZXJpdDtcbiAgICB6LWluZGV4OiAxO1xuICAgIHBhZGRpbmc6IDVweCA1cHggNXB4IDEwcHg7XG4gIH1cblxuICAuZmlsdGVyLW1lbnVfX2J1dHRvbiB7XG4gICAgb3BhY2l0eTogMDtcbiAgICBwYWRkaW5nOiA1cHg7XG4gICAgdHJhbnNpdGlvbjogYWxsIDMwMG1zIGVhc2UtaW4tb3V0O1xuICAgIHotaW5kZXg6IDE7XG4gIH1cblxuICAuZmlsdGVyLW1lbnVfX2Jhc2U6Zm9jdXMtd2l0aGluIC5maWx0ZXItbWVudV9fYnV0dG9uLFxuICAuZmlsdGVyLW1lbnVfX2Jhc2U6aG92ZXIgLmZpbHRlci1tZW51X19idXR0b24ge1xuICAgIG9wYWNpdHk6IDE7XG4gIH1cblxuICAuZmlsdGVyLW1lbnVfX2xpc3Qge1xuICAgIGJhY2tncm91bmQtY29sb3I6ICNmZmY7XG4gICAgYm9yZGVyLXJhZGl1czogM3B4O1xuICAgIGJvcmRlcjogMXB4IHNvbGlkICNmMmYyZjI7XG4gICAgYm94LXNoYWRvdzogMCAxcHggM3B4IHJnYmEoMCwgMCwgMCwgLjIpO1xuICAgIGxlZnQ6IDA7XG4gICAgbWluLXdpZHRoOiAyMDBweDtcbiAgICBwb3NpdGlvbjogYWJzb2x1dGU7XG4gICAgdG9wOiAzMHB4O1xuICAgIHotaW5kZXg6IDI7XG4gIH1cbjwvc3R5bGU+XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWUiLCJleHBvcnRzID0gbW9kdWxlLmV4cG9ydHMgPSByZXF1aXJlKFwiLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvbGliL2Nzcy1iYXNlLmpzXCIpKHRydWUpO1xuLy8gaW1wb3J0c1xuXG5cbi8vIG1vZHVsZVxuZXhwb3J0cy5wdXNoKFttb2R1bGUuaWQsIFwiXFxuLmZpbHRlci1tZW51X19iYXNlW2RhdGEtdi02Mjg2MzIyYl0ge1xcbiAgYmFja2dyb3VuZC1jb2xvcjogI2RiZGJkYjtcXG4gIGJvcmRlci1yYWRpdXM6IDJweDtcXG4gIGhlaWdodDogMzBweDtcXG4gIG1heC13aWR0aDogMzAwcHg7XFxufVxcbi5maWx0ZXItbWVudV9fYmFzZVtkYXRhLXYtNjI4NjMyMmJdOmFmdGVyIHtcXG4gIGNvbnRlbnQ6ICcnO1xcbiAgcG9zaXRpb246IGFic29sdXRlO1xcbiAgdG9wOiAwO1xcbiAgbGVmdDogMDtcXG4gIGhlaWdodDogMTAwJTtcXG4gIHdpZHRoOiAxMDAlO1xcbiAgYmFja2dyb3VuZC1jb2xvcjogcmdiYSgwLCAwLCAwLCAuMDMpO1xcbiAgb3BhY2l0eTogMDtcXG4gIC13ZWJraXQtdHJhbnNpdGlvbjogMjUwbXMgZWFzZSBvcGFjaXR5O1xcbiAgdHJhbnNpdGlvbjogMjUwbXMgZWFzZSBvcGFjaXR5O1xcbn1cXG4uZmlsdGVyLW1lbnU6Zm9jdXMgPiAuZmlsdGVyLW1lbnVfX2Jhc2VbZGF0YS12LTYyODYzMjJiXTphZnRlcixcXG4uZmlsdGVyLW1lbnU6Zm9jdXMtd2l0aGluID4gLmZpbHRlci1tZW51X19iYXNlW2RhdGEtdi02Mjg2MzIyYl06YWZ0ZXIsXFxuLmZpbHRlci1tZW51OmhvdmVyID4gLmZpbHRlci1tZW51X19iYXNlW2RhdGEtdi02Mjg2MzIyYl06YWZ0ZXIge1xcbiAgb3BhY2l0eTogMTtcXG59XFxuLmZpbHRlci1tZW51LS1lcnJvciAuZmlsdGVyLW1lbnVfX2Jhc2VbZGF0YS12LTYyODYzMjJiXSB7XFxuICBiYWNrZ3JvdW5kLWNvbG9yOiAjZjJjNmM2O1xcbiAgY29sb3I6ICNlZDU5NWE7XFxufVxcbi5maWx0ZXItbWVudV9fbGFiZWxbZGF0YS12LTYyODYzMjJiXSB7XFxuICBjb2xvcjogaW5oZXJpdDtcXG4gIHotaW5kZXg6IDE7XFxuICBwYWRkaW5nOiA1cHggNXB4IDVweCAxMHB4O1xcbn1cXG4uZmlsdGVyLW1lbnVfX2J1dHRvbltkYXRhLXYtNjI4NjMyMmJdIHtcXG4gIG9wYWNpdHk6IDA7XFxuICBwYWRkaW5nOiA1cHg7XFxuICAtd2Via2l0LXRyYW5zaXRpb246IGFsbCAzMDBtcyBlYXNlLWluLW91dDtcXG4gIHRyYW5zaXRpb246IGFsbCAzMDBtcyBlYXNlLWluLW91dDtcXG4gIHotaW5kZXg6IDE7XFxufVxcbi5maWx0ZXItbWVudV9fYmFzZTpmb2N1cy13aXRoaW4gLmZpbHRlci1tZW51X19idXR0b25bZGF0YS12LTYyODYzMjJiXSxcXG4uZmlsdGVyLW1lbnVfX2Jhc2U6aG92ZXIgLmZpbHRlci1tZW51X19idXR0b25bZGF0YS12LTYyODYzMjJiXSB7XFxuICBvcGFjaXR5OiAxO1xcbn1cXG4uZmlsdGVyLW1lbnVfX2xpc3RbZGF0YS12LTYyODYzMjJiXSB7XFxuICBiYWNrZ3JvdW5kLWNvbG9yOiAjZmZmO1xcbiAgYm9yZGVyLXJhZGl1czogM3B4O1xcbiAgYm9yZGVyOiAxcHggc29saWQgI2YyZjJmMjtcXG4gIC13ZWJraXQtYm94LXNoYWRvdzogMCAxcHggM3B4IHJnYmEoMCwgMCwgMCwgLjIpO1xcbiAgICAgICAgICBib3gtc2hhZG93OiAwIDFweCAzcHggcmdiYSgwLCAwLCAwLCAuMik7XFxuICBsZWZ0OiAwO1xcbiAgbWluLXdpZHRoOiAyMDBweDtcXG4gIHBvc2l0aW9uOiBhYnNvbHV0ZTtcXG4gIHRvcDogMzBweDtcXG4gIHotaW5kZXg6IDI7XFxufVxcblwiLCBcIlwiLCB7XCJ2ZXJzaW9uXCI6MyxcInNvdXJjZXNcIjpbXCIvaG9tZS9tYW5qdWwvUHJvamVjdHMvZmxvb3ItbWFuYWdlbWVudC9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJNZW51LnZ1ZVwiXSxcIm5hbWVzXCI6W10sXCJtYXBwaW5nc1wiOlwiO0FBb0pBO0VBQ0EsMEJBQUE7RUFDQSxtQkFBQTtFQUNBLGFBQUE7RUFDQSxpQkFBQTtDQUNBO0FBRUE7RUFDQSxZQUFBO0VBQ0EsbUJBQUE7RUFDQSxPQUFBO0VBQ0EsUUFBQTtFQUNBLGFBQUE7RUFDQSxZQUFBO0VBQ0EscUNBQUE7RUFDQSxXQUFBO0VBQ0EsdUNBQUE7RUFBQSwrQkFBQTtDQUNBO0FBRUE7OztFQUdBLFdBQUE7Q0FDQTtBQUVBO0VBQ0EsMEJBQUE7RUFDQSxlQUFBO0NBQ0E7QUFFQTtFQUNBLGVBQUE7RUFDQSxXQUFBO0VBQ0EsMEJBQUE7Q0FDQTtBQUVBO0VBQ0EsV0FBQTtFQUNBLGFBQUE7RUFDQSwwQ0FBQTtFQUFBLGtDQUFBO0VBQ0EsV0FBQTtDQUNBO0FBRUE7O0VBRUEsV0FBQTtDQUNBO0FBRUE7RUFDQSx1QkFBQTtFQUNBLG1CQUFBO0VBQ0EsMEJBQUE7RUFDQSxnREFBQTtVQUFBLHdDQUFBO0VBQ0EsUUFBQTtFQUNBLGlCQUFBO0VBQ0EsbUJBQUE7RUFDQSxVQUFBO0VBQ0EsV0FBQTtDQUNBXCIsXCJmaWxlXCI6XCJGaWx0ZXJNZW51LnZ1ZVwiLFwic291cmNlc0NvbnRlbnRcIjpbXCI8dGVtcGxhdGU+XFxuICA8ZGl2XFxuICAgIGNsYXNzPVxcXCJmaWx0ZXItbWVudSBhZy1mbGV4LXdyYXAgcmVsYXRpdmVQb3NpdGlvblxcXCJcXG4gICAgOmNsYXNzPVxcXCJ7ICdmaWx0ZXItbWVudS0tZXJyb3InOiBzaG93RXJyb3IgfVxcXCJcXG4gICAgcmVmPVxcXCJmaWx0ZXJNZW51XFxcIlxcbiAgPlxcbiAgICA8ZGl2IGNsYXNzPVxcXCJmaWx0ZXItbWVudV9fYmFzZSBhZy1mbGV4IGFnLWFsaWduLWNlbnRlclxcXCI+XFxuICAgICAgPGJ1dHRvblxcbiAgICAgICAgdHlwZT1cXFwiYnV0dG9uXFxcIlxcbiAgICAgICAgY2xhc3M9XFxcInRydW5jYXRlIHRyYW5zcGFyZW50LWJ1dHRvbiBmaWx0ZXItbWVudV9fbGFiZWxcXFwiXFxuICAgICAgICA6dGl0bGU9XFxcImZpbHRlclRleHRcXFwiXFxuICAgICAgICBAY2xpY2s9XFxcInRvZ2dsZVxcXCJcXG4gICAgICA+XFxuICAgICAgICA8c3Ryb25nPiB7eyBmaWx0ZXIubGFiZWwgfX0gPC9zdHJvbmc+XFxuICAgICAgICA8dGVtcGxhdGUgdi1pZj1cXFwic2hvd0Vycm9yXFxcIj5pcyBtaXNzaW5nIHZhbHVlPC90ZW1wbGF0ZT5cXG4gICAgICAgIDx0ZW1wbGF0ZSB2LWVsc2U+e3sgaHVtYW5pemVkT3BlcmF0b3JWYWx1ZSB9fTwvdGVtcGxhdGU+XFxuICAgICAgPC9idXR0b24+XFxuICAgICAgPGJ1dHRvblxcbiAgICAgICAgdHlwZT1cXFwiYnV0dG9uXFxcIlxcbiAgICAgICAgY2xhc3M9XFxcInRyYW5zcGFyZW50LWJ1dHRvbiBhZy1mbGV4IGFnLWFsaWduLWNlbnRlciBhZy1mbGV4LXNocmluay0wIGNvbC1oci0xIGZpbHRlci1tZW51X19idXR0b25cXFwiXFxuICAgICAgICA6Y2xhc3M9XFxcInNob3dFcnJvciA/ICd0ZXh0LXByaW1hcnktcmVkJyA6ICd0ZXh0LS1taWQtZ3JleSdcXFwiXFxuICAgICAgICB0aXRsZT1cXFwiUmVtb3ZlIHRoaXMgZmlsdGVyXFxcIlxcbiAgICAgICAgQGNsaWNrPVxcXCIkZW1pdCgncmVtb3ZlJywgZmlsdGVyKVxcXCJcXG4gICAgICA+XFxuICAgICAgICA8Zm0taWNvbiBpY29uPVxcXCJ0aW1lc1xcXCIgY2xhc3M9XFxcImFnLWljb24tLW1kIGFnLWljb24tLWN1cnJlbnRcXFwiLz5cXG4gICAgICA8L2J1dHRvbj5cXG4gICAgPC9kaXY+XFxuICAgIDx0cmFuc2l0aW9uIG5hbWU9XFxcImxpc3QtZG93blxcXCI+XFxuICAgICAgPGZvcm1cXG4gICAgICAgIGNsYXNzPVxcXCJmaWx0ZXItbWVudV9fbGlzdCB1aSBmb3JtXFxcIlxcbiAgICAgICAgdi1zaG93PVxcXCJ2aXNpYmxlXFxcIlxcbiAgICAgICAgQHN1Ym1pdC5wcmV2ZW50PVxcXCJoaWRlXFxcIlxcbiAgICAgID5cXG4gICAgICAgIDxrZWVwLWFsaXZlPlxcbiAgICAgICAgICA8Y29tcG9uZW50XFxuICAgICAgICAgICAgOmlzPVxcXCJjdXJyZW50RmlsdGVyVHlwZVxcXCJcXG4gICAgICAgICAgICA6ZmlsdGVyPVxcXCJmaWx0ZXJcXFwiXFxuICAgICAgICAgICAgQHVwZGF0ZT1cXFwiaGFuZGxlRmlsdGVyVXBkYXRlXFxcIlxcbiAgICAgICAgICA+PC9jb21wb25lbnQ+XFxuICAgICAgICA8L2tlZXAtYWxpdmU+XFxuICAgICAgPC9mb3JtPlxcbiAgICA8L3RyYW5zaXRpb24+XFxuICA8L2Rpdj5cXG48L3RlbXBsYXRlPlxcblxcbjxzY3JpcHQ+XFxuICBpbXBvcnQgRm1JY29uIGZyb20gJy4uL2Z1bmN0aW9uYWwvRm1JY29uJztcXG4gIGltcG9ydCBPUEVSQVRPUl9WQUxVRV9JRF9NQVAsIHsgREVGQVVMVF9GSUxURVJfVEVYVCB9IGZyb20gJy4vY29uc3QvaHVtYW5pemVkT3BlcmF0b3InO1xcblxcbiAgY29uc3QgSFVNQU5JWkVEX09QRVJBVE9SX01BUCA9IG5ldyBNYXAoKTtcXG4gIE9QRVJBVE9SX1ZBTFVFX0lEX01BUC5mb3JFYWNoKG9wZXJhdG9yID0+IEhVTUFOSVpFRF9PUEVSQVRPUl9NQVAuc2V0KG9wZXJhdG9yLmlkLCBvcGVyYXRvci52YWx1ZSwgb3BlcmF0b3IubWVzc2FnZSkpO1xcblxcbiAgY29uc3QgT1BFUkFUT1JfTUVTU0FHRV9NQVAgPSBuZXcgTWFwKCk7XFxuICBPUEVSQVRPUl9WQUxVRV9JRF9NQVAuZm9yRWFjaChvcGVyYXRvciA9PiBPUEVSQVRPUl9NRVNTQUdFX01BUC5zZXQob3BlcmF0b3IuaWQsIG9wZXJhdG9yLm1lc3NhZ2UpKTtcXG5cXG4gIGV4cG9ydCBkZWZhdWx0IHtcXG4gICAgbmFtZTogJ0ZpbHRlck1lbnUnLFxcbiAgICBjb21wb25lbnRzOiB7XFxuICAgICAgRm1JY29uLFxcbiAgICB9LFxcbiAgICBwcm9wczoge1xcbiAgICAgIGZpbHRlcjoge1xcbiAgICAgICAgdHlwZTogT2JqZWN0LFxcbiAgICAgICAgcmVxdWlyZWQ6IHRydWUsXFxuICAgICAgfSxcXG4gICAgfSxcXG4gICAgZGF0YTogKCkgPT4gKHtcXG4gICAgICB2aXNpYmxlOiB0cnVlLFxcbiAgICB9KSxcXG4gICAgY29tcHV0ZWQ6IHtcXG4gICAgICBjdXJyZW50RmlsdGVyVHlwZSgpIHtcXG4gICAgICAgIHJldHVybiAoKSA9PiBpbXBvcnQoYC4vdHlwZXMvRmlsdGVyJHt0aGlzLmZpbHRlci50eXBlfWApO1xcbiAgICAgIH0sXFxuICAgICAgc2hvd0Vycm9yKCkge1xcbiAgICAgICAgcmV0dXJuICF0aGlzLmZpbHRlci52YWx1ZSAmJiAhdGhpcy52aXNpYmxlO1xcbiAgICAgIH0sXFxuICAgICAgaHVtYW5pemVkT3BlcmF0b3JWYWx1ZSgpIHtcXG4gICAgICAgIGNvbnN0IHZhbHVlID0gdGhpcy5maWx0ZXIudmFsdWUgfHwgJyc7XFxuICAgICAgICBjb25zdCBvcGVyYXRvciA9IEhVTUFOSVpFRF9PUEVSQVRPUl9NQVAuZ2V0KHRoaXMuZmlsdGVyLm9wZXJhdG9yKSB8fCAnJztcXG4gICAgICAgIGNvbnN0IG9wZXJhdG9yTWVzc2FnZSA9IE9QRVJBVE9SX01FU1NBR0VfTUFQLmdldCh0aGlzLmZpbHRlci5vcGVyYXRvcik7XFxuICAgICAgICBpZiAodHlwZW9mIG9wZXJhdG9yTWVzc2FnZSA9PT0gJ2Z1bmN0aW9uJykge1xcbiAgICAgICAgICByZXR1cm4gb3BlcmF0b3JNZXNzYWdlKHsgb3BlcmF0b3IsIHZhbHVlIH0pIHx8ICcnO1xcbiAgICAgICAgfVxcbiAgICAgICAgcmV0dXJuIERFRkFVTFRfRklMVEVSX1RFWFQoeyBvcGVyYXRvciwgdmFsdWUgfSkgfHwgJyc7XFxuICAgICAgfSxcXG4gICAgICBmaWx0ZXJUZXh0KCkge1xcbiAgICAgICAgY29uc3QgeyBsYWJlbCwgdmFsdWUgfSA9IHRoaXMuZmlsdGVyO1xcbiAgICAgICAgY29uc3QgbWVzc2FnZSA9IHZhbHVlID8gdGhpcy5odW1hbml6ZWRPcGVyYXRvclZhbHVlIDogJ2lzIG1pc3NpbmcgdmFsdWUnO1xcbiAgICAgICAgcmV0dXJuIGAke2xhYmVsfSAke21lc3NhZ2V9YDtcXG4gICAgICB9LFxcbiAgICB9LFxcbiAgICB3YXRjaDoge1xcbiAgICAgIHZpc2libGU6IHtcXG4gICAgICAgIGltbWVkaWF0ZTogdHJ1ZSxcXG4gICAgICAgIGhhbmRsZXIodmFsdWUsIG9sZFZhbHVlKSB7XFxuICAgICAgICAgIGlmICh2YWx1ZSAhPT0gb2xkVmFsdWUpIHtcXG4gICAgICAgICAgICB0aGlzLiRuZXh0VGljaygoKSA9PiB7XFxuICAgICAgICAgICAgICBpZiAodmFsdWUpIHtcXG4gICAgICAgICAgICAgICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCB0aGlzLmhhbmRsZUNsaWNrKTtcXG4gICAgICAgICAgICAgIH0gZWxzZSB7XFxuICAgICAgICAgICAgICAgIGRvY3VtZW50LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgdGhpcy5oYW5kbGVDbGljayk7XFxuICAgICAgICAgICAgICB9XFxuICAgICAgICAgICAgfSk7XFxuICAgICAgICAgIH1cXG4gICAgICAgIH0sXFxuICAgICAgfSxcXG4gICAgfSxcXG4gICAgY3JlYXRlZCgpIHtcXG4gICAgICBpZiAodGhpcy5maWx0ZXIuc2F2ZWQpIHtcXG4gICAgICAgIHRoaXMuaGlkZSgpO1xcbiAgICAgIH1cXG4gICAgfSxcXG4gICAgYmVmb3JlRGVzdHJveSgpIHtcXG4gICAgICBkb2N1bWVudC5yZW1vdmVFdmVudExpc3RlbmVyKCdjbGljaycsIHRoaXMuaGFuZGxlQ2xpY2spO1xcbiAgICB9LFxcbiAgICBtZXRob2RzOiB7XFxuICAgICAgaGFuZGxlQ2xpY2soZXZlbnQpIHtcXG4gICAgICAgIGlmICh0aGlzLnZpc2libGUpIHtcXG4gICAgICAgICAgY29uc3QgeyB0YXJnZXQgfSA9IGV2ZW50O1xcbiAgICAgICAgICBjb25zdCB7IGZpbHRlck1lbnUgfSA9IHRoaXMuJHJlZnM7XFxuICAgICAgICAgIGlmICh0YXJnZXQgIT09IGZpbHRlck1lbnUgJiYgIWZpbHRlck1lbnUuY29udGFpbnModGFyZ2V0KSkge1xcbiAgICAgICAgICAgIHRoaXMuaGlkZSgpO1xcbiAgICAgICAgICB9XFxuICAgICAgICB9XFxuICAgICAgfSxcXG4gICAgICB0b2dnbGUoKSB7XFxuICAgICAgICBpZiAodGhpcy52aXNpYmxlKSB7XFxuICAgICAgICAgIHRoaXMuaGlkZSgpO1xcbiAgICAgICAgfSBlbHNlIHtcXG4gICAgICAgICAgdGhpcy5zaG93KCk7XFxuICAgICAgICB9XFxuICAgICAgfSxcXG4gICAgICBzaG93KCkge1xcbiAgICAgICAgdGhpcy52aXNpYmxlID0gdHJ1ZTtcXG4gICAgICB9LFxcbiAgICAgIGhpZGUoKSB7XFxuICAgICAgICB0aGlzLnZpc2libGUgPSBmYWxzZTtcXG4gICAgICB9LFxcbiAgICAgIGhhbmRsZUZpbHRlclVwZGF0ZSh7IG9wZXJhdG9yLCB2YWx1ZSB9KSB7XFxuICAgICAgICBjb25zdCB1cGRhdGVkRmlsdGVyID0geyAuLi50aGlzLmZpbHRlciwgb3BlcmF0b3IsIHZhbHVlIH07XFxuICAgICAgICB0aGlzLiRlbWl0KCd1cGRhdGU6ZmlsdGVyJywgdXBkYXRlZEZpbHRlcik7XFxuICAgICAgfSxcXG4gICAgfSxcXG4gIH07XFxuPC9zY3JpcHQ+XFxuXFxuXFxuPHN0eWxlIHNjb3BlZD5cXG4gIC5maWx0ZXItbWVudV9fYmFzZSB7XFxuICAgIGJhY2tncm91bmQtY29sb3I6ICNkYmRiZGI7XFxuICAgIGJvcmRlci1yYWRpdXM6IDJweDtcXG4gICAgaGVpZ2h0OiAzMHB4O1xcbiAgICBtYXgtd2lkdGg6IDMwMHB4O1xcbiAgfVxcblxcbiAgLmZpbHRlci1tZW51X19iYXNlOmFmdGVyIHtcXG4gICAgY29udGVudDogJyc7XFxuICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcXG4gICAgdG9wOiAwO1xcbiAgICBsZWZ0OiAwO1xcbiAgICBoZWlnaHQ6IDEwMCU7XFxuICAgIHdpZHRoOiAxMDAlO1xcbiAgICBiYWNrZ3JvdW5kLWNvbG9yOiByZ2JhKDAsIDAsIDAsIC4wMyk7XFxuICAgIG9wYWNpdHk6IDA7XFxuICAgIHRyYW5zaXRpb246IDI1MG1zIGVhc2Ugb3BhY2l0eTtcXG4gIH1cXG5cXG4gIC5maWx0ZXItbWVudTpmb2N1cyA+IC5maWx0ZXItbWVudV9fYmFzZTphZnRlcixcXG4gIC5maWx0ZXItbWVudTpmb2N1cy13aXRoaW4gPiAuZmlsdGVyLW1lbnVfX2Jhc2U6YWZ0ZXIsXFxuICAuZmlsdGVyLW1lbnU6aG92ZXIgPiAuZmlsdGVyLW1lbnVfX2Jhc2U6YWZ0ZXIge1xcbiAgICBvcGFjaXR5OiAxO1xcbiAgfVxcblxcbiAgLmZpbHRlci1tZW51LS1lcnJvciAuZmlsdGVyLW1lbnVfX2Jhc2Uge1xcbiAgICBiYWNrZ3JvdW5kLWNvbG9yOiAjZjJjNmM2O1xcbiAgICBjb2xvcjogI2VkNTk1YTtcXG4gIH1cXG5cXG4gIC5maWx0ZXItbWVudV9fbGFiZWwge1xcbiAgICBjb2xvcjogaW5oZXJpdDtcXG4gICAgei1pbmRleDogMTtcXG4gICAgcGFkZGluZzogNXB4IDVweCA1cHggMTBweDtcXG4gIH1cXG5cXG4gIC5maWx0ZXItbWVudV9fYnV0dG9uIHtcXG4gICAgb3BhY2l0eTogMDtcXG4gICAgcGFkZGluZzogNXB4O1xcbiAgICB0cmFuc2l0aW9uOiBhbGwgMzAwbXMgZWFzZS1pbi1vdXQ7XFxuICAgIHotaW5kZXg6IDE7XFxuICB9XFxuXFxuICAuZmlsdGVyLW1lbnVfX2Jhc2U6Zm9jdXMtd2l0aGluIC5maWx0ZXItbWVudV9fYnV0dG9uLFxcbiAgLmZpbHRlci1tZW51X19iYXNlOmhvdmVyIC5maWx0ZXItbWVudV9fYnV0dG9uIHtcXG4gICAgb3BhY2l0eTogMTtcXG4gIH1cXG5cXG4gIC5maWx0ZXItbWVudV9fbGlzdCB7XFxuICAgIGJhY2tncm91bmQtY29sb3I6ICNmZmY7XFxuICAgIGJvcmRlci1yYWRpdXM6IDNweDtcXG4gICAgYm9yZGVyOiAxcHggc29saWQgI2YyZjJmMjtcXG4gICAgYm94LXNoYWRvdzogMCAxcHggM3B4IHJnYmEoMCwgMCwgMCwgLjIpO1xcbiAgICBsZWZ0OiAwO1xcbiAgICBtaW4td2lkdGg6IDIwMHB4O1xcbiAgICBwb3NpdGlvbjogYWJzb2x1dGU7XFxuICAgIHRvcDogMzBweDtcXG4gICAgei1pbmRleDogMjtcXG4gIH1cXG48L3N0eWxlPlxcblwiXSxcInNvdXJjZVJvb3RcIjpcIlwifV0pO1xuXG4vLyBleHBvcnRzXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyP3NvdXJjZU1hcCEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlcj97XCJ2dWVcIjp0cnVlLFwiaWRcIjpcImRhdGEtdi02Mjg2MzIyYlwiLFwic2NvcGVkXCI6dHJ1ZSxcImhhc0lubGluZUNvbmZpZ1wiOnRydWV9IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJNZW51LnZ1ZVxuLy8gbW9kdWxlIGlkID0gLi9ub2RlX21vZHVsZXMvY3NzLWxvYWRlci9pbmRleC5qcz9zb3VyY2VNYXAhLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXIvaW5kZXguanM/e1widnVlXCI6dHJ1ZSxcImlkXCI6XCJkYXRhLXYtNjI4NjMyMmJcIixcInNjb3BlZFwiOnRydWUsXCJoYXNJbmxpbmVDb25maWdcIjp0cnVlfSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvRmlsdGVyTWVudS52dWVcbi8vIG1vZHVsZSBjaHVua3MgPSA0IiwidmFyIHJlbmRlciA9IGZ1bmN0aW9uKCkge1xuICB2YXIgX3ZtID0gdGhpc1xuICB2YXIgX2ggPSBfdm0uJGNyZWF0ZUVsZW1lbnRcbiAgdmFyIF9jID0gX3ZtLl9zZWxmLl9jIHx8IF9oXG4gIHJldHVybiBfYyhcbiAgICBcImRpdlwiLFxuICAgIHtcbiAgICAgIHJlZjogXCJmaWx0ZXJNZW51XCIsXG4gICAgICBzdGF0aWNDbGFzczogXCJmaWx0ZXItbWVudSBhZy1mbGV4LXdyYXAgcmVsYXRpdmVQb3NpdGlvblwiLFxuICAgICAgY2xhc3M6IHsgXCJmaWx0ZXItbWVudS0tZXJyb3JcIjogX3ZtLnNob3dFcnJvciB9XG4gICAgfSxcbiAgICBbXG4gICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcImZpbHRlci1tZW51X19iYXNlIGFnLWZsZXggYWctYWxpZ24tY2VudGVyXCIgfSwgW1xuICAgICAgICBfYyhcbiAgICAgICAgICBcImJ1dHRvblwiLFxuICAgICAgICAgIHtcbiAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcInRydW5jYXRlIHRyYW5zcGFyZW50LWJ1dHRvbiBmaWx0ZXItbWVudV9fbGFiZWxcIixcbiAgICAgICAgICAgIGF0dHJzOiB7IHR5cGU6IFwiYnV0dG9uXCIsIHRpdGxlOiBfdm0uZmlsdGVyVGV4dCB9LFxuICAgICAgICAgICAgb246IHsgY2xpY2s6IF92bS50b2dnbGUgfVxuICAgICAgICAgIH0sXG4gICAgICAgICAgW1xuICAgICAgICAgICAgX2MoXCJzdHJvbmdcIiwgW192bS5fdihcIiBcIiArIF92bS5fcyhfdm0uZmlsdGVyLmxhYmVsKSArIFwiIFwiKV0pLFxuICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgIF92bS5zaG93RXJyb3JcbiAgICAgICAgICAgICAgPyBbX3ZtLl92KFwiaXMgbWlzc2luZyB2YWx1ZVwiKV1cbiAgICAgICAgICAgICAgOiBbX3ZtLl92KF92bS5fcyhfdm0uaHVtYW5pemVkT3BlcmF0b3JWYWx1ZSkpXVxuICAgICAgICAgIF0sXG4gICAgICAgICAgMlxuICAgICAgICApLFxuICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICBfYyhcbiAgICAgICAgICBcImJ1dHRvblwiLFxuICAgICAgICAgIHtcbiAgICAgICAgICAgIHN0YXRpY0NsYXNzOlxuICAgICAgICAgICAgICBcInRyYW5zcGFyZW50LWJ1dHRvbiBhZy1mbGV4IGFnLWFsaWduLWNlbnRlciBhZy1mbGV4LXNocmluay0wIGNvbC1oci0xIGZpbHRlci1tZW51X19idXR0b25cIixcbiAgICAgICAgICAgIGNsYXNzOiBfdm0uc2hvd0Vycm9yID8gXCJ0ZXh0LXByaW1hcnktcmVkXCIgOiBcInRleHQtLW1pZC1ncmV5XCIsXG4gICAgICAgICAgICBhdHRyczogeyB0eXBlOiBcImJ1dHRvblwiLCB0aXRsZTogXCJSZW1vdmUgdGhpcyBmaWx0ZXJcIiB9LFxuICAgICAgICAgICAgb246IHtcbiAgICAgICAgICAgICAgY2xpY2s6IGZ1bmN0aW9uKCRldmVudCkge1xuICAgICAgICAgICAgICAgIF92bS4kZW1pdChcInJlbW92ZVwiLCBfdm0uZmlsdGVyKVxuICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgICAgfSxcbiAgICAgICAgICBbXG4gICAgICAgICAgICBfYyhcImZtLWljb25cIiwge1xuICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJhZy1pY29uLS1tZCBhZy1pY29uLS1jdXJyZW50XCIsXG4gICAgICAgICAgICAgIGF0dHJzOiB7IGljb246IFwidGltZXNcIiB9XG4gICAgICAgICAgICB9KVxuICAgICAgICAgIF0sXG4gICAgICAgICAgMVxuICAgICAgICApXG4gICAgICBdKSxcbiAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICBfYyhcInRyYW5zaXRpb25cIiwgeyBhdHRyczogeyBuYW1lOiBcImxpc3QtZG93blwiIH0gfSwgW1xuICAgICAgICBfYyhcbiAgICAgICAgICBcImZvcm1cIixcbiAgICAgICAgICB7XG4gICAgICAgICAgICBkaXJlY3RpdmVzOiBbXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBuYW1lOiBcInNob3dcIixcbiAgICAgICAgICAgICAgICByYXdOYW1lOiBcInYtc2hvd1wiLFxuICAgICAgICAgICAgICAgIHZhbHVlOiBfdm0udmlzaWJsZSxcbiAgICAgICAgICAgICAgICBleHByZXNzaW9uOiBcInZpc2libGVcIlxuICAgICAgICAgICAgICB9XG4gICAgICAgICAgICBdLFxuICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZmlsdGVyLW1lbnVfX2xpc3QgdWkgZm9ybVwiLFxuICAgICAgICAgICAgb246IHtcbiAgICAgICAgICAgICAgc3VibWl0OiBmdW5jdGlvbigkZXZlbnQpIHtcbiAgICAgICAgICAgICAgICAkZXZlbnQucHJldmVudERlZmF1bHQoKVxuICAgICAgICAgICAgICAgIHJldHVybiBfdm0uaGlkZSgkZXZlbnQpXG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9LFxuICAgICAgICAgIFtcbiAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICBcImtlZXAtYWxpdmVcIixcbiAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgIF9jKF92bS5jdXJyZW50RmlsdGVyVHlwZSwge1xuICAgICAgICAgICAgICAgICAgdGFnOiBcImNvbXBvbmVudFwiLFxuICAgICAgICAgICAgICAgICAgYXR0cnM6IHsgZmlsdGVyOiBfdm0uZmlsdGVyIH0sXG4gICAgICAgICAgICAgICAgICBvbjogeyB1cGRhdGU6IF92bS5oYW5kbGVGaWx0ZXJVcGRhdGUgfVxuICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgIF0sXG4gICAgICAgICAgICAgIDFcbiAgICAgICAgICAgIClcbiAgICAgICAgICBdLFxuICAgICAgICAgIDFcbiAgICAgICAgKVxuICAgICAgXSlcbiAgICBdLFxuICAgIDFcbiAgKVxufVxudmFyIHN0YXRpY1JlbmRlckZucyA9IFtdXG5yZW5kZXIuX3dpdGhTdHJpcHBlZCA9IHRydWVcbm1vZHVsZS5leHBvcnRzID0geyByZW5kZXI6IHJlbmRlciwgc3RhdGljUmVuZGVyRm5zOiBzdGF0aWNSZW5kZXJGbnMgfVxuaWYgKG1vZHVsZS5ob3QpIHtcbiAgbW9kdWxlLmhvdC5hY2NlcHQoKVxuICBpZiAobW9kdWxlLmhvdC5kYXRhKSB7XG4gICAgcmVxdWlyZShcInZ1ZS1ob3QtcmVsb2FkLWFwaVwiKSAgICAgIC5yZXJlbmRlcihcImRhdGEtdi02Mjg2MzIyYlwiLCBtb2R1bGUuZXhwb3J0cylcbiAgfVxufVxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3RlbXBsYXRlLWNvbXBpbGVyP3tcImlkXCI6XCJkYXRhLXYtNjI4NjMyMmJcIixcImhhc1Njb3BlZFwiOnRydWUsXCJidWJsZVwiOntcInRyYW5zZm9ybXNcIjp7fX19IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9dGVtcGxhdGUmaW5kZXg9MCEuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlci9pbmRleC5qcz97XCJpZFwiOlwiZGF0YS12LTYyODYzMjJiXCIsXCJoYXNTY29wZWRcIjp0cnVlLFwiYnVibGVcIjp7XCJ0cmFuc2Zvcm1zXCI6e319fSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXRlbXBsYXRlJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJNZW51LnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDQiLCIvLyBzdHlsZS1sb2FkZXI6IEFkZHMgc29tZSBjc3MgdG8gdGhlIERPTSBieSBhZGRpbmcgYSA8c3R5bGU+IHRhZ1xuXG4vLyBsb2FkIHRoZSBzdHlsZXNcbnZhciBjb250ZW50ID0gcmVxdWlyZShcIiEhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtNjI4NjMyMmJcXFwiLFxcXCJzY29wZWRcXFwiOnRydWUsXFxcImhhc0lubGluZUNvbmZpZ1xcXCI6dHJ1ZX0hLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9GaWx0ZXJNZW51LnZ1ZVwiKTtcbmlmKHR5cGVvZiBjb250ZW50ID09PSAnc3RyaW5nJykgY29udGVudCA9IFtbbW9kdWxlLmlkLCBjb250ZW50LCAnJ11dO1xuaWYoY29udGVudC5sb2NhbHMpIG1vZHVsZS5leHBvcnRzID0gY29udGVudC5sb2NhbHM7XG4vLyBhZGQgdGhlIHN0eWxlcyB0byB0aGUgRE9NXG52YXIgdXBkYXRlID0gcmVxdWlyZShcIiEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLXN0eWxlLWxvYWRlci9saWIvYWRkU3R5bGVzQ2xpZW50LmpzXCIpKFwiZWZjNWJmNjBcIiwgY29udGVudCwgZmFsc2UsIHt9KTtcbi8vIEhvdCBNb2R1bGUgUmVwbGFjZW1lbnRcbmlmKG1vZHVsZS5ob3QpIHtcbiAvLyBXaGVuIHRoZSBzdHlsZXMgY2hhbmdlLCB1cGRhdGUgdGhlIDxzdHlsZT4gdGFnc1xuIGlmKCFjb250ZW50LmxvY2Fscykge1xuICAgbW9kdWxlLmhvdC5hY2NlcHQoXCIhIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyL2luZGV4LmpzP3NvdXJjZU1hcCEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXIvaW5kZXguanM/e1xcXCJ2dWVcXFwiOnRydWUsXFxcImlkXFxcIjpcXFwiZGF0YS12LTYyODYzMjJiXFxcIixcXFwic2NvcGVkXFxcIjp0cnVlLFxcXCJoYXNJbmxpbmVDb25maWdcXFwiOnRydWV9IS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXN0eWxlcyZpbmRleD0wIS4vRmlsdGVyTWVudS52dWVcIiwgZnVuY3Rpb24oKSB7XG4gICAgIHZhciBuZXdDb250ZW50ID0gcmVxdWlyZShcIiEhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvaW5kZXguanM/c291cmNlTWFwIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XFxcInZ1ZVxcXCI6dHJ1ZSxcXFwiaWRcXFwiOlxcXCJkYXRhLXYtNjI4NjMyMmJcXFwiLFxcXCJzY29wZWRcXFwiOnRydWUsXFxcImhhc0lubGluZUNvbmZpZ1xcXCI6dHJ1ZX0hLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9GaWx0ZXJNZW51LnZ1ZVwiKTtcbiAgICAgaWYodHlwZW9mIG5ld0NvbnRlbnQgPT09ICdzdHJpbmcnKSBuZXdDb250ZW50ID0gW1ttb2R1bGUuaWQsIG5ld0NvbnRlbnQsICcnXV07XG4gICAgIHVwZGF0ZShuZXdDb250ZW50KTtcbiAgIH0pO1xuIH1cbiAvLyBXaGVuIHRoZSBtb2R1bGUgaXMgZGlzcG9zZWQsIHJlbW92ZSB0aGUgPHN0eWxlPiB0YWdzXG4gbW9kdWxlLmhvdC5kaXNwb3NlKGZ1bmN0aW9uKCkgeyB1cGRhdGUoKTsgfSk7XG59XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9ub2RlX21vZHVsZXMvdnVlLXN0eWxlLWxvYWRlciEuL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyP3NvdXJjZU1hcCEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlcj97XCJ2dWVcIjp0cnVlLFwiaWRcIjpcImRhdGEtdi02Mjg2MzIyYlwiLFwic2NvcGVkXCI6dHJ1ZSxcImhhc0lubGluZUNvbmZpZ1wiOnRydWV9IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJNZW51LnZ1ZVxuLy8gbW9kdWxlIGlkID0gLi9ub2RlX21vZHVsZXMvdnVlLXN0eWxlLWxvYWRlci9pbmRleC5qcyEuL25vZGVfbW9kdWxlcy9jc3MtbG9hZGVyL2luZGV4LmpzP3NvdXJjZU1hcCEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zdHlsZS1jb21waWxlci9pbmRleC5qcz97XCJ2dWVcIjp0cnVlLFwiaWRcIjpcImRhdGEtdi02Mjg2MzIyYlwiLFwic2NvcGVkXCI6dHJ1ZSxcImhhc0lubGluZUNvbmZpZ1wiOnRydWV9IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9c3R5bGVzJmluZGV4PTAhLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9GaWx0ZXJNZW51LnZ1ZVxuLy8gbW9kdWxlIGNodW5rcyA9IDQiLCJ2YXIgZGlzcG9zZWQgPSBmYWxzZVxuZnVuY3Rpb24gaW5qZWN0U3R5bGUgKHNzckNvbnRleHQpIHtcbiAgaWYgKGRpc3Bvc2VkKSByZXR1cm5cbiAgcmVxdWlyZShcIiEhdnVlLXN0eWxlLWxvYWRlciFjc3MtbG9hZGVyP3NvdXJjZU1hcCEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc3R5bGUtY29tcGlsZXIvaW5kZXg/e1xcXCJ2dWVcXFwiOnRydWUsXFxcImlkXFxcIjpcXFwiZGF0YS12LTYyODYzMjJiXFxcIixcXFwic2NvcGVkXFxcIjp0cnVlLFxcXCJoYXNJbmxpbmVDb25maWdcXFwiOnRydWV9IS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvcj90eXBlPXN0eWxlcyZpbmRleD0wIS4vRmlsdGVyTWVudS52dWVcIilcbn1cbnZhciBub3JtYWxpemVDb21wb25lbnQgPSByZXF1aXJlKFwiIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9jb21wb25lbnQtbm9ybWFsaXplclwiKVxuLyogc2NyaXB0ICovXG52YXIgX192dWVfc2NyaXB0X18gPSByZXF1aXJlKFwiISFiYWJlbC1sb2FkZXI/e1xcXCJjYWNoZURpcmVjdG9yeVxcXCI6dHJ1ZSxcXFwicHJlc2V0c1xcXCI6W1tcXFwiZW52XFxcIix7XFxcIm1vZHVsZXNcXFwiOmZhbHNlLFxcXCJ0YXJnZXRzXFxcIjp7XFxcImJyb3dzZXJzXFxcIjpbXFxcIj4gMiVcXFwiXSxcXFwidWdsaWZ5XFxcIjp0cnVlfX1dLFxcXCJiYWJlbC1wcmVzZXQtZW52XFxcIl0sXFxcInBsdWdpbnNcXFwiOltcXFwidHJhbnNmb3JtLW9iamVjdC1yZXN0LXNwcmVhZFxcXCIsW1xcXCJ0cmFuc2Zvcm0tcnVudGltZVxcXCIse1xcXCJwb2x5ZmlsbFxcXCI6ZmFsc2UsXFxcImhlbHBlcnNcXFwiOmZhbHNlfV0sXFxcInN5bnRheC1keW5hbWljLWltcG9ydFxcXCJdfSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT1zY3JpcHQmaW5kZXg9MCEuL0ZpbHRlck1lbnUudnVlXCIpXG4vKiB0ZW1wbGF0ZSAqL1xudmFyIF9fdnVlX3RlbXBsYXRlX18gPSByZXF1aXJlKFwiISEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvdGVtcGxhdGUtY29tcGlsZXIvaW5kZXg/e1xcXCJpZFxcXCI6XFxcImRhdGEtdi02Mjg2MzIyYlxcXCIsXFxcImhhc1Njb3BlZFxcXCI6dHJ1ZSxcXFwiYnVibGVcXFwiOntcXFwidHJhbnNmb3Jtc1xcXCI6e319fSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vRmlsdGVyTWVudS52dWVcIilcbi8qIHRlbXBsYXRlIGZ1bmN0aW9uYWwgKi9cbnZhciBfX3Z1ZV90ZW1wbGF0ZV9mdW5jdGlvbmFsX18gPSBmYWxzZVxuLyogc3R5bGVzICovXG52YXIgX192dWVfc3R5bGVzX18gPSBpbmplY3RTdHlsZVxuLyogc2NvcGVJZCAqL1xudmFyIF9fdnVlX3Njb3BlSWRfXyA9IFwiZGF0YS12LTYyODYzMjJiXCJcbi8qIG1vZHVsZUlkZW50aWZpZXIgKHNlcnZlciBvbmx5KSAqL1xudmFyIF9fdnVlX21vZHVsZV9pZGVudGlmaWVyX18gPSBudWxsXG52YXIgQ29tcG9uZW50ID0gbm9ybWFsaXplQ29tcG9uZW50KFxuICBfX3Z1ZV9zY3JpcHRfXyxcbiAgX192dWVfdGVtcGxhdGVfXyxcbiAgX192dWVfdGVtcGxhdGVfZnVuY3Rpb25hbF9fLFxuICBfX3Z1ZV9zdHlsZXNfXyxcbiAgX192dWVfc2NvcGVJZF9fLFxuICBfX3Z1ZV9tb2R1bGVfaWRlbnRpZmllcl9fXG4pXG5Db21wb25lbnQub3B0aW9ucy5fX2ZpbGUgPSBcInJlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlXCJcblxuLyogaG90IHJlbG9hZCAqL1xuaWYgKG1vZHVsZS5ob3QpIHsoZnVuY3Rpb24gKCkge1xuICB2YXIgaG90QVBJID0gcmVxdWlyZShcInZ1ZS1ob3QtcmVsb2FkLWFwaVwiKVxuICBob3RBUEkuaW5zdGFsbChyZXF1aXJlKFwidnVlXCIpLCBmYWxzZSlcbiAgaWYgKCFob3RBUEkuY29tcGF0aWJsZSkgcmV0dXJuXG4gIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgaWYgKCFtb2R1bGUuaG90LmRhdGEpIHtcbiAgICBob3RBUEkuY3JlYXRlUmVjb3JkKFwiZGF0YS12LTYyODYzMjJiXCIsIENvbXBvbmVudC5vcHRpb25zKVxuICB9IGVsc2Uge1xuICAgIGhvdEFQSS5yZWxvYWQoXCJkYXRhLXYtNjI4NjMyMmJcIiwgQ29tcG9uZW50Lm9wdGlvbnMpXG4gIH1cbiAgbW9kdWxlLmhvdC5kaXNwb3NlKGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgZGlzcG9zZWQgPSB0cnVlXG4gIH0pXG59KSgpfVxuXG5tb2R1bGUuZXhwb3J0cyA9IENvbXBvbmVudC5leHBvcnRzXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlXG4vLyBtb2R1bGUgaWQgPSAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL0ZpbHRlck1lbnUudnVlXG4vLyBtb2R1bGUgY2h1bmtzID0gNCIsImltcG9ydCAqIGFzIE9QRVJBVE9SIGZyb20gJy4vb3BlcmF0b3JzJztcblxuZXhwb3J0IGNvbnN0IERFRkFVTFRfRklMVEVSX1RFWFQgPSAoeyBvcGVyYXRvciwgdmFsdWUgfSkgPT4gYCR7b3BlcmF0b3J9ICR7dmFsdWV9YDtcblxuZXhwb3J0IGNvbnN0IElTID0ge1xuICBpZDogT1BFUkFUT1IuRVFVQUxTLFxuICB2YWx1ZTogJ2lzJyxcbn07XG5cbmV4cG9ydCBjb25zdCBJU19OT1QgPSB7XG4gIGlkOiBPUEVSQVRPUi5OT1RfRVFVQUxTLFxuICB2YWx1ZTogJ2lzIG5vdCcsXG59O1xuXG5leHBvcnQgY29uc3QgU1RBUlRTX1dJVEggPSB7XG4gIGlkOiBPUEVSQVRPUi5TVEFSVFNfV0lUSCxcbiAgdmFsdWU6ICdzdGFydHMgd2l0aCcsXG59O1xuXG5leHBvcnQgY29uc3QgRU5EU19XSVRIID0ge1xuICBpZDogT1BFUkFUT1IuRU5EU19XSVRILFxuICB2YWx1ZTogJ2VuZHMgd2l0aCcsXG59O1xuXG5leHBvcnQgY29uc3QgQ09OVEFJTlMgPSB7XG4gIGlkOiBPUEVSQVRPUi5DT05UQUlOUyxcbiAgdmFsdWU6ICdjb250YWlucycsXG59O1xuXG5leHBvcnQgY29uc3QgTk9UX0NPTlRBSU5TID0ge1xuICBpZDogT1BFUkFUT1IuTk9UX0NPTlRBSU5TLFxuICB2YWx1ZTogJ2RvZXMgbm90IGNvbnRhaW4nLFxufTtcblxuZXhwb3J0IGNvbnN0IEdSRUFURVJfVEhBTiA9IHtcbiAgaWQ6IE9QRVJBVE9SLkdSRUFURVJfVEhBTixcbiAgdmFsdWU6ICdpcyBncmVhdGVyIHRoYW4nLFxufTtcblxuZXhwb3J0IGNvbnN0IExFU1NfVEhBTiA9IHtcbiAgaWQ6IE9QRVJBVE9SLkxFU1NfVEhBTixcbiAgdmFsdWU6ICdpcyBsZXNzIHRoYW4nLFxufTtcblxuZXhwb3J0IGNvbnN0IFRPREFZID0ge1xuICBpZDogT1BFUkFUT1IuVE9EQVksXG4gIHZhbHVlOiAnaXMgdG9kYXknLFxuICBtZXNzYWdlOiAoeyBvcGVyYXRvciB9KSA9PiBgJHtvcGVyYXRvcn1gLFxufTtcblxuZXhwb3J0IGNvbnN0IFlFU1RFUkRBWSA9IHtcbiAgaWQ6IE9QRVJBVE9SLllFU1RFUkRBWSxcbiAgdmFsdWU6ICdpcyB5ZXN0ZXJkYXknLFxuICBtZXNzYWdlOiAoeyBvcGVyYXRvciB9KSA9PiBgJHtvcGVyYXRvcn1gLFxufTtcblxuZXhwb3J0IGNvbnN0IExBU1RfN19EQVlTID0ge1xuICBpZDogT1BFUkFUT1IuTEFTVF83X0RBWVMsXG4gIHZhbHVlOiAnaXMgbGFzdCA3IGRheXMnLFxuICBtZXNzYWdlOiAoeyBvcGVyYXRvciB9KSA9PiBgJHtvcGVyYXRvcn1gLFxufTtcblxuZXhwb3J0IGNvbnN0IExBU1RfMzBfREFZUyA9IHtcbiAgaWQ6IE9QRVJBVE9SLkxBU1RfMzBfREFZUyxcbiAgdmFsdWU6ICdpcyBsYXN0IDMwIGRheXMnLFxuICBtZXNzYWdlOiAoeyBvcGVyYXRvciB9KSA9PiBgJHtvcGVyYXRvcn1gLFxufTtcblxuZXhwb3J0IGNvbnN0IENVUlJFTlRfTU9OVEggPSB7XG4gIGlkOiBPUEVSQVRPUi5DVVJSRU5UX01PTlRILFxuICB2YWx1ZTogJ2lzIGN1cnJlbnQgbW9udGgnLFxuICBtZXNzYWdlOiAoeyBvcGVyYXRvciB9KSA9PiBgJHtvcGVyYXRvcn1gLFxufTtcblxuZXhwb3J0IGNvbnN0IExBU1RfTU9OVEggPSB7XG4gIGlkOiBPUEVSQVRPUi5MQVNUX01PTlRILFxuICB2YWx1ZTogJ2lzIGxhc3QgbW9udGgnLFxuICBtZXNzYWdlOiAoeyBvcGVyYXRvciB9KSA9PiBgJHtvcGVyYXRvcn1gLFxufTtcblxuZXhwb3J0IGNvbnN0IENVU1RPTSA9IHtcbiAgaWQ6IE9QRVJBVE9SLkNVU1RPTSxcbiAgdmFsdWU6ICdpcyBjdXN0b20nLFxuICBtZXNzYWdlOiAoeyB2YWx1ZSB9KSA9PiBgaXMgZnJvbSAke3ZhbHVlfWAsXG59O1xuXG5leHBvcnQgY29uc3QgVU5LTk9XTiA9IHtcbiAgaWQ6IE9QRVJBVE9SLlVOS05PV04sXG4gIHZhbHVlOiAnaXMgbm90IGtub3duJyxcbn07XG5cbmV4cG9ydCBkZWZhdWx0IFtcbiAgSVMsXG4gIElTX05PVCxcbiAgU1RBUlRTX1dJVEgsXG4gIEVORFNfV0lUSCxcbiAgQ09OVEFJTlMsXG4gIE5PVF9DT05UQUlOUyxcbiAgR1JFQVRFUl9USEFOLFxuICBMRVNTX1RIQU4sXG4gIFRPREFZLFxuICBZRVNURVJEQVksXG4gIExBU1RfN19EQVlTLFxuICBMQVNUXzMwX0RBWVMsXG4gIENVUlJFTlRfTU9OVEgsXG4gIExBU1RfTU9OVEgsXG4gIENVU1RPTSxcbiAgVU5LTk9XTixcbl07XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci9jb25zdC9odW1hbml6ZWRPcGVyYXRvci5qcyIsInZhciBtYXAgPSB7XG5cdFwiLi9GaWx0ZXJEYXRlXCI6IFtcblx0XHRcIi4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMvRmlsdGVyRGF0ZS52dWVcIixcblx0XHQxMFxuXHRdLFxuXHRcIi4vRmlsdGVyRGF0ZS52dWVcIjogW1xuXHRcdFwiLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJEYXRlLnZ1ZVwiLFxuXHRcdDEwXG5cdF0sXG5cdFwiLi9GaWx0ZXJOdW1iZXJcIjogW1xuXHRcdFwiLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJOdW1iZXIudnVlXCIsXG5cdFx0OVxuXHRdLFxuXHRcIi4vRmlsdGVyTnVtYmVyLnZ1ZVwiOiBbXG5cdFx0XCIuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlck51bWJlci52dWVcIixcblx0XHQ5XG5cdF0sXG5cdFwiLi9GaWx0ZXJTZWxlY3RcIjogW1xuXHRcdFwiLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTZWxlY3QudnVlXCIsXG5cdFx0OFxuXHRdLFxuXHRcIi4vRmlsdGVyU2VsZWN0LnZ1ZVwiOiBbXG5cdFx0XCIuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlclNlbGVjdC52dWVcIixcblx0XHQ4XG5cdF0sXG5cdFwiLi9GaWx0ZXJTdHJpbmdcIjogW1xuXHRcdFwiLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcy9GaWx0ZXJTdHJpbmcudnVlXCIsXG5cdFx0N1xuXHRdLFxuXHRcIi4vRmlsdGVyU3RyaW5nLnZ1ZVwiOiBbXG5cdFx0XCIuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzL0ZpbHRlclN0cmluZy52dWVcIixcblx0XHQ3XG5cdF1cbn07XG5mdW5jdGlvbiB3ZWJwYWNrQXN5bmNDb250ZXh0KHJlcSkge1xuXHR2YXIgaWRzID0gbWFwW3JlcV07XG5cdGlmKCFpZHMpXG5cdFx0cmV0dXJuIFByb21pc2UucmVqZWN0KG5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIgKyByZXEgKyBcIicuXCIpKTtcblx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18uZShpZHNbMV0pLnRoZW4oZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oaWRzWzBdKTtcblx0fSk7XG59O1xud2VicGFja0FzeW5jQ29udGV4dC5rZXlzID0gZnVuY3Rpb24gd2VicGFja0FzeW5jQ29udGV4dEtleXMoKSB7XG5cdHJldHVybiBPYmplY3Qua2V5cyhtYXApO1xufTtcbndlYnBhY2tBc3luY0NvbnRleHQuaWQgPSBcIi4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZm1GaWx0ZXIvdHlwZXMgbGF6eSByZWN1cnNpdmUgXlxcXFwuXFxcXC9GaWx0ZXIuKiRcIjtcbm1vZHVsZS5leHBvcnRzID0gd2VicGFja0FzeW5jQ29udGV4dDtcblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvZG9tYWluL2NvbW1vbi9jb21wb25lbnRzL2ZtRmlsdGVyL3R5cGVzIGxhenkgXlxcLlxcL0ZpbHRlci4qJFxuLy8gbW9kdWxlIGlkID0gLi9yZXNvdXJjZXMvYXNzZXRzL2RvbWFpbi9jb21tb24vY29tcG9uZW50cy9mbUZpbHRlci90eXBlcyBsYXp5IHJlY3Vyc2l2ZSBeXFwuXFwvRmlsdGVyLiokXG4vLyBtb2R1bGUgY2h1bmtzID0gNCIsImV4cG9ydCBkZWZhdWx0IHtcbiAgICBuYW1lOiAnZm0taWNvbicsXG4gICAgZnVuY3Rpb25hbDogdHJ1ZSxcbiAgICBwcm9wczoge1xuICAgICAgaWNvbjoge1xuICAgICAgICB0eXBlOiBTdHJpbmcsXG4gICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgfSxcbiAgICB9LFxuICAgIHJlbmRlcihjcmVhdGVFbGVtZW50LCBjb250ZXh0KSB7XG4gICAgICByZXR1cm4gY3JlYXRlRWxlbWVudCgnc3ZnJywge1xuICAgICAgICBjbGFzczogW1xuICAgICAgICAgICdhZy1pY29uJyxcbiAgICAgICAgICBjb250ZXh0LmRhdGEuc3RhdGljQ2xhc3MsXG4gICAgICAgIF0sXG4gICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgJ2FyaWEtaGlkZGVuJzogdHJ1ZSxcbiAgICAgICAgfSxcbiAgICAgIH0sIFtcbiAgICAgICAgY3JlYXRlRWxlbWVudCgndXNlJywge1xuICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAneGxpbms6aHJlZic6IGAjYWctaWNvbi0ke2NvbnRleHQucHJvcHMuaWNvbn1gLFxuICAgICAgICAgIH0sXG4gICAgICAgIH0pLFxuICAgICAgXSk7XG4gICAgfSxcbiAgfTtcbiAgXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vcmVzb3VyY2VzL2Fzc2V0cy9kb21haW4vY29tbW9uL2NvbXBvbmVudHMvZnVuY3Rpb25hbC9GbUljb24uanMiXSwic291cmNlUm9vdCI6IiJ9