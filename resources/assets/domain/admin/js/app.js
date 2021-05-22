/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require("./bootstrap")

import VueToastr from "@deveodk/vue-toastr"
import "@deveodk/vue-toastr/dist/@deveodk/vue-toastr.css"
import Vue from "vue"
import VeeValidate from 'vee-validate'
import AlertNotification from "../../common/components/Alert/AlertNotification"
import DeleteButton from "../../common/components/Buttons/DeleteButton"
import EditButton from "../../common/components/Buttons/EditButton"
import VueTable from "../../common/components/Datatable/DataTable"

import MemoAlert from "../../common/components/Memo/MemoAlert"
import Modal from "../../common/components/Modal/Modal"
/**************************************************
 * Components
 **************************************************/
import PortletContent from "../../common/components/Portlets/Content/PortletContent"
import Bookings from "../views/Bookings/Bookings"
import CreateCustomer from "../views/Customers/CreateCustomer"
import InstallationComplaints from "../views/InstallationComplaints/InstallationComplaints"
import AddJob from "../views/Jobs/AddJob"
import JobSourceForm from "../views/JobSource/JobSourceForm"
import CategoryList from "../views/Product/Category/Category"
import ProductList from "../views/Product/ProductList"
import ProductTypeForm from "../views/Product/Type/ProductTypeForm"
import AddQuote from "../views/Quotes/AddQuote"
import SupplierForm from "../views/Suppliers/SupplierForm"
import AddTemplate from "../views/Templates/AddTemplate"
import createUser from "../views/Users/CreateUser"
import PermissionForm from "../views/Users/Permissions/PermissionForm"
import RolePermissionAssociation from "../views/Users/Permissions/RolesAndPermissionsAssociation"
import Profile from "../views/Users/Profile"
import UserDetails from "../views/Users/UserDetails"
import Suppliers from '../views/Suppliers/Suppliers'
import Products from '../views/Product/Products'
import Stocks from "../views/Stocks/Stocks"
import CurrentOrders from "../views/CurrentOrders/CurrentOrders"
import Setup from "../views/Setup/Setup"
import Accounts from "../views/Accounts/Accounts"
import Contractors from "../views/Contractors/Contractors"
import Billings from "../views/Billings/Billings"
import Print from "../views/Billings/Print"
import Security from "../views/Security/Security"
import Terms from "../views/Terms/Terms"
import ChequeButt from "../views/ChequeButt/ChequeButt"
import Clients from "../views/Clients/Clients"
import AddTerm from "../views/Terms/AddTerm"
import StockAllocations from "../views/StockAllocations/StockAllocations"
import ActionRequired from "../views/ActionRequired/ActionRequired"
import CostingTemplates from '../views/CostingTemplates/Index';
import Memos from '../views/Memos';
import Payables from '../views/Payables/Index';
import CashBook from '../views/CashBook/Index';
import JobReport from '../views/Reports/Job/Index';
import SupplierReport from '../views/Reports/Supplier/Index';
import ProductReport from '../views/Reports/Product/Index';
import BankReconciliation from '../views/BankReconciliation/Index';
import DeliveredOrders from '../views/DeliveredOrders/DeliveredOrders';
import TransactionJournals from '../views/TransactionJournals/TransactionJournals';
import WorkInProgress from '../views/WorkInProgress/Index'
/**************************************************
 * View files
 **************************************************/
import UsersList from "../views/Users/UsersList"

Vue.use(VueToastr, {
  defaultPosition: "toast-top-right",
  defaultType: "info",
  defaultTimeout: 6000,
})

Vue.use(VeeValidate, {
  events: '',
});

/**
 * Initialize the vue app.
 */
Vue.mixin({
  methods: {
    numberOnly(event) {
      if ((event.charCode > 31 && (event.charCode < 48 || event.charCode > 57)) && event.charCode !== 46) {
        event.preventDefault()
      }

      if (event.target.value.indexOf(".") !== -1 && event.charCode === 46) {
        event.preventDefault()
      }
      return true
    },
  },
})

const app = new Vue({
  el: "#app",
  components: {
    UsersList,
    createUser,
    PortletContent,
    DeleteButton,
    AlertNotification,
    EditButton,
    PermissionForm,
    VueTable,
    RolePermissionAssociation,
    JobSourceForm,
    Profile,
    CreateCustomer,
    SupplierForm,
    UserDetails,
    Modal,
    CategoryList,
    AddQuote,
    ProductList,
    ProductTypeForm,
    AddJob,
    MemoAlert,
    AddTemplate,
    Bookings,
    Stocks,
    InstallationComplaints,
    Suppliers,
    Products,
    CurrentOrders,
    Setup,
    Accounts,
    Contractors,
    Billings,
    Print,
    Security,
    Terms,
    ChequeButt,
    Clients,
    AddTerm,
    StockAllocations,
    ActionRequired,
    CostingTemplates,
    Payables,
    CashBook,
    DeliveredOrders,
    Memos,
    TransactionJournals,
    BankReconciliation,
    JobReport,
    SupplierReport,
    ProductReport,
    WorkInProgress
  },
})

$(document).ready(function() {
  $("input[type=number]").on("focus", function() {
      $(this).on("keydown", function(event) {
          if (event.keyCode === 38 || event.keyCode === 40) {
              event.preventDefault();
          }
      });
  });
});