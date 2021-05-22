<script>
import UpdateOrderModal from './UpdateOrderModal';
import EditOrderModal from './EditOrderModal';
import OrderReceiptModal from './OrderReceiptModal';
import MarryInvoiceModal from './MarryInvoiceModal';
import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import ArchiveCurrentOrder from './ArchiveCurrentOrder';
import AddCurrentOrder from './components/AddCurrentOrder';
import AddSupplier from './components/AddSupplier';
import ReceiveGeneralOrder from './components/ReceiveGeneralOrder';
import AddOrder from './components/AddOrder';
import SearchCurrentOrders from './components/SearchCurrentOrders';
import { formatViewDate, displayMoney } from '../../../common/utitlities/helpers';
import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins';
import FmError from '../../../common/components/Error/FmError';

export default {
    name: 'CurrentOrders',
    mixins: [LoadingMixin, CurrentUserMixin],
    components: {
        EditOrderModal,
        PortletContent,
        UpdateOrderModal,
        OrderReceiptModal,
        MarryInvoiceModal,
        ArchiveCurrentOrder,
        SearchCurrentOrders,
        AddSupplier,
        AddCurrentOrder,
        AddOrder,
        ReceiveGeneralOrder,
        FmError
    },
    props: {
      orderId: {
        type: Number,
        default: 0
      }
    },
    data: () => ({
        mountEditModal: false,
        mountFmError: false,
        mountUpdateModal: false,
        mountOrderRecieptModal: false,
        mountGeneralOrderRecieptModal: false,
        mountMarryInvoiceModal: false,
        mountArchiveModal: false,
        mountSearchCurrentOrdersModal: false,
        mountAddCurrentOrderModal: false,
        mountAddOrderModal: false,
        mountAddSupplierModal: false,
        selectedStock: {},
        isEditMode: false,
        model: {},
        modelCache: {},
        currentOrder: {
            supplier_details: [],
            delivery_address: {},
        },
        addCurrentOrderData: {},
        newlyAddedOrder: {},
    }),
    created() {
        if (!this.orderId) {
            this.fetchCurrentOrderIndex();
        } else {
            this.fetchCurrentOrder(this.orderId);
        }
        this.model.due_date = this.currentOrder.due_date;
    },
    computed: {
        primarySalesPersonName() {
            const salesPerson = this.job.primary_sales_person ? this.job.primary_sales_person[0] : {};

            return salesPerson.name;
        },
        job() {
            return this.currentOrder.job || {};
        },
        site() {
            return this.currentOrder.site || {};
        },
        jobId() {
            if (!this.job.id) {
                return '';
            }
            return `${this.site.quote_prefix || ''}${this.job.job_id}`
        },
        supplierDetails() {
            return this.currentOrder.supplier_details || {};
        },
        supplierName() {
            return this.supplierDetails.trading_name || this.currentOrder.supplier_name;
        },
        supplierId() {
            return this.supplierDetails.id || this.currentOrder.supplier_id;
        },
    },
    methods: {
        formatViewDate,
        displayMoney,
        closeAddCurrentOrderModal() {
            // this.addCurrentOrderData = {};
            // this.newlyAddedOrder = {};
            this.closeModal('AddCurrentOrderModal');
        },
        currentOrderUpdated(currentOrderId) {
            // this.fetchCurrentOrder(currentOrderId);
            window.location.href = `/current-orders/${currentOrderId}`;
        },
        openAddSupplierModal(currentOrder) {
            this.addCurrentOrderData = {...currentOrder};
            this.openModal('AddSupplierModal');
        },
        reopenAddCurrentOrderModal(orderData) {
            this.newlyAddedOrder = {...orderData};
            this.openModal('AddCurrentOrderModal');
        },
        openAddOrderModal(currentOrder) {
            this.addCurrentOrderData = {...currentOrder};
            this.openModal('AddOrderModal');
        },
        fetchCurrentOrderIndex() {
            this.enableLoading();
            return axios.get(`/api/current-orders/index`)
                .then(({ data }) => {
                    if (data.data.id) {
                        this.fetchCurrentOrder(data.data.id);
                    } else {
                        this.$toastr('error', 'No records.', 'Error!!')
                    }
                })
                .catch(response => {
                    this.$toastr('error', 'Could not fetch current order', 'Error!!')
                })
                .finally(this.disableLoading);
        },
        fetchCurrentOrder(id) {
            return axios.get(`/api/current-orders/${id}`)
                .then(({ data }) => {
                    this.currentOrder = data.data;
                    if (data.data.job) {
                        this.currentOrder.client_name = data.data.job.trading_name;
                        this.currentOrder.sales_rep = this.primarySalesPersonName;
                    }
                    if (!this.currentOrder.supplier_name) {
                        this.currentOrder.supplier_name = this.supplierDetails.trading_name
                    }
                });
        },
        saveCurrentOrder() {
            this.enableLoading();
            const model = { ...this.model };
            return axios.put(`/api/current-orders/${this.currentOrder.id}`, model)
                .then(response => {
                    this.$toastr('success', 'Successfully updated current order', 'Success!!');
                    window.location.href = `/current-orders/${this.currentOrder.id}`;
                })
                .catch(response => {
                    this.$toastr('error', 'Could not update current order', 'Error!!')
                })
                .finally(() => this.disableLoading());
        },
        enableEditMode() {
            this.modelCache = { ...this.model };
            this.changeEditMode(true);
        },
        changeEditMode(type) {
            this.isEditMode = !!type;
        },
        cancelEditMode() {
            this.model = this.modelCache;
            this.changeEditMode(false);
        },
        openArchiveModal() {
            // this.fetchCurrentOrder(this.orderId);
            this.mountArchiveModal = true;
        },
        marryInvoiceCreated() {
            this.refreshCurrentOrderPage();
        },
        futureStockUpdated() {
            this.refreshCurrentOrderPage();
        },
        refreshCurrentOrderPage() {
            this.loadCurrentOrderById(this.currentOrder.id);
        },
        loadCurrentOrderById(id) {
            console.log('refreshing page', id)
            window.location.href = `/current-orders/${id}`;
        },
        openModal(name) {
            if (name) {
                this[`mount${name}`] = true;
            }
        },
        closeModal(name) {
            if (name) {
                this[`mount${name}`] = false;
            }
        },
        redirectToStock(futureStock) {
          window.location.href = `/color/${futureStock.variant_id}/stocks`
        },
        redirectToJob() {
            if (!this.job.id) {
                return
            }
            window.location.href = `/jobs/${this.job.id}/edit`
        },
        showEditModal(stock) {
            this.selectedStock =  stock;
            this.mountEditModal = true;
        },
        hideEditModal() {
            this.selectedStock = {};
            this.mountEditModal = false; 
        },
        showUpdateModal(stock) {
            this.selectedStock =  stock;
            this.mountUpdateModal = true;
        },
        hideUpdateModal(clearData) {
            if (clearData) {
                this.selectedStock = {};
            }
            this.mountUpdateModal = false; 
        },
        showOrderReceivedModal() {
            if (this.currentOrder.is_general) {
                return this.mountGeneralOrderRecieptModal = true;
            }

            return this.mountOrderRecieptModal = true;
        },
        hideOrderReceipt() {
            this.selectedStock =  {};
            this.mountOrderRecieptModal = false; 
        },
        showMarryInvoiceModal() {
            if (this.currentOrder.is_general) {
                return this.mountFmError = true;
            }

            return this.mountMarryInvoiceModal = true;
        },
        hideMarryInvoiceModal() {
            this.selectedStock =  {};
            this.mountMarryInvoiceModal = false; 
        },
    },
};
</script>

<style scoped>
.background-black {
    background: black;
    color: white;
    width: fit-content;
}
.background-red {
    background: red;
    color: white;
    width: fit-content;
}
.menu-bar {
    display: flex;
    justify-content: space-between;
}
</style>
