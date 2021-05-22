<script>
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import UpdateBill from './components/UpdateBill';
import InvoiceExpense from './components/InvoiceExpense';
import Retention from './components/Retention';
import SearchBilling from './components/SearchBilling';
import { LoadingMixin, CurrentUserMixin } from "../../../common/mixins";
import { formatViewDate, displayMoney } from "../../../common/utitlities/helpers";
import DeleteReceipt from "../../../common/components/DeleteReceipt";

export default {
  name: "Billings",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    PortletContent,
    UpdateBill,
    InvoiceExpense,
    Retention,
    SearchBilling,
    DeleteReceipt
  },
  props: {
    invoiceId: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      invoice: {},
      model: {},
      mountUpdateBill: false,
      mountInvoiceExpense: false,
      mountRetention: false,
      mountSearchBilling: false,
      mountDeleteReceipt: false,
      netInvoice: '',
      gstAmount: '',
      isEditMode: false,
      modelCache: {},
      selectedReceiptForDelete: {},
    };
  },
  computed: {
    job() {
      return this.invoice.job || {};
    },
    salesCode() {
      return this.job.sales_code || {};
    },
    site() {
      return this.job.site || {};
    },
    jobInvoiceId() {
      return `${this.site.quote_prefix}${this.job.job_id}/${this.invoice.id}` || '';
    },
    clientName() {
      return `${this.job.title || ''} ${this.job.firstname || ''} ${this.job.trading_name || ''}` || '';
    },
    term() {
      return this.job.term || {};
    },
    quoteTerm() {
      const terms = this.term.terms || {};
      return terms.quote || '';
    },
    salesPerson() {
      const primarySalesRep = this.job.primary_sales_person || [];
      if (primarySalesRep.length) {
        return primarySalesRep[0];
      }

      return {};
    },
    receipts() {
      return this.invoice.receipts || [];
    },
    expenses() {
      return this.invoice.expenses || [];
    },
    address() {
      return this.job.address || {};
    },
    totalReceipts() {
      const total = this.receipts.reduce((sum, receipt) => {
        return sum + Number(receipt.amount);
      }, 0);

      return total.toFixed(2);
    },
    totalExpenses() {
      const total = this.expenses.reduce((sum, expense) => {
        return sum + Number(expense.net_amount);
      }, 0);

      return total.toFixed(2);
    },
    gst() {
      return Number(this.model.gst);
    },
    invoiceBalanceDue() {
      const value = Number(this.model.amount) - Number(this.totalReceipts) - Number(this.totalExpenses) - Number(this.model.retention_amount);
      return value.toFixed(2);
    },
  },
  watch: {
    'model.gst'(value) {
      this.calculateGstAmount(value);
      this.model.amount = (Number(this.model.net_invoice) + Number(this.gstAmount)).toFixed(2);
    },
    'model.net_invoice'(value) {
      this.calculateGstAmount(this.model.gst);
      this.model.amount = (Number(value) + Number(this.gstAmount)).toFixed(2);
    },
  },
  created() {
    if (!this.invoiceId) {
      this.enableLoading();
      axios.get('/api/invoices/index')
        .then(({ data }) => {
          this.fetchInvoiceDetail(data.data.id);
        })
        .catch(() => {
          this.$toastr('error', 'Could not fetch billing information.', 'Error!!')
        })
        .finally(this.disableLoading)
    } else {
      this.enableLoading();
      this.fetchInvoiceDetail(this.invoiceId)
        .catch(() => {
          console.log('could not fetch invoice')
        })
        .finally(this.disableLoading);
    }
  },
  methods: {
    formatViewDate,
    displayMoney,
    openReceiptDeleteModal(receipt) {
      console.log('clicked');
      this.selectedReceiptForDelete = { ...receipt };
      this.openModal('DeleteReceipt');
    },
    receiptDeleted() {
      this.fetchCurrentInvoice();
    },
    cancelEditMode() {
      this.model = { ...this.modelCache };
      this.isEditMode = false;
    },
    enableEditMode() {
      this.modelCache = { ...this.model };
      this.isEditMode = true;
    },
    openModal(type) {
      this[`mount${type}`] = true;
    },
    closeModal(type) {
      if (this[`mount${type}`]) {
        this[`mount${type}`] = false;
      }
    },
    calculateNetInvoice(amount, gst) {
      const netInvoice = (100 * Number(amount)) / (100 + Number(gst));
      this.model.net_invoice = netInvoice.toFixed(2);
    },
    calculateGstAmount(gst) {
      const gstAmount = (Number(this.model.net_invoice) * Number(gst)) / 100;
      this.gstAmount = gstAmount.toFixed(2);
    },
    fetchInvoiceDetail(id) {
      return axios.get(`/api/invoices/${id}`)
        .then(({ data }) => {
          this.invoice = data.data;
          let {retention_amount, retention_release_date, gst, notes, remarks, financed, amount, net_invoice, balance_due } = this.invoice;
          this.model = {remarks, retention_amount, gst: gst || this.job.gst, notes, financed, amount, net_invoice, balance_due};
          this.model.retention_release_date = retention_release_date || "";
          this.calculateNetInvoice(amount, this.gst);
          this.calculateGstAmount(this.gst);
        })
    },
    fetchCurrentInvoice() {
      this.fetchInvoiceDetail(this.invoice.id);
    },
    redirectToJob() {
      window.location.href = `/jobs/${this.job.id}/edit?page=3`;
    },
    updateInvoice() {
      this.enableLoading();
      axios.put(`api/jobs/${this.job.id}/invoice/${this.invoice.id}`, ({
        ...this.model,
        date: this.invoice.date,
      }))
        .then(() => {
          this.isEditMode = false;
          this.$toastr('success', 'Successfully updated invoice.', 'Success!!');
          this.fetchInvoiceDetail(this.invoice.id);
        })
        .catch(() => {
          this.$toastr('error', 'Could not update invoice.', 'Error!!');
        })
        .finally(this.disableLoading);
    },
  },
};
</script>

<style scoped>
.background-black {
  background-color: black;
  color: white;
  width: fit-content;
  padding: 3px;
}
</style>
