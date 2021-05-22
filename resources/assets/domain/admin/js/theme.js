import {mUtil}         from "./../../common/theme/js/framework/base/util";
import {mApp}          from "./../../common/theme/js/framework/base/app";
import {mLayout}       from "./../../common/theme/js/demo/demo5/base/layout";
import {mQuickSidebar} from "./../../common/theme/js/snippets/base/quick-sidebar";

// require("./../../common/theme/js/framework/components/general/animate");
require("./../../common/theme/js/framework/components/general/dropdown");
// require("./../../common/theme/js/framework/components/general/example");
require("./../../common/theme/js/framework/components/general/header");
require("./../../common/theme/js/framework/components/general/menu");
// require("./../../common/theme/js/framework/components/general/messenger");
require("./../../common/theme/js/framework/components/general/offcanvas");
// require("./../../common/theme/js/framework/components/general/portlet");
require("./../../common/theme/js/framework/components/general/quicksearch");
require("./../../common/theme/js/framework/components/general/scroll-top");
require("./../../common/theme/js/framework/components/general/toggle");
// require("./../../common/theme/js/framework/components/general/wizard");

$(document).ready(function() {
    mUtil.init();
    mApp.init();
    mLayout.init();
    mQuickSidebar.init();
});
