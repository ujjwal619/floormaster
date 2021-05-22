<script>
import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import { LoadingMixin } from '../../../common/mixins';
import { 
    formatViewDate, 
    displayMoney,
    displayNumber
} from '../../../common/utitlities/helpers';
import SearchDeliveryOrders from './components/SearchDeliveryOrders';

export default {
    name: 'DeliveredOrders',
    mixins: [LoadingMixin],
    components: {
        PortletContent,
        SearchDeliveryOrders,
    },
    props: {
      deliveryOrderId: {
        type: Number,
        default: 0
      }
    },
    data: () => ({
        mountSearchDeliveryOrdersModal: false,
        deliveryOrder: {
            supplier_details: {},
            delivery_address: {},
            color: {
                product: {}
            },
        },
    }),
    computed: {
        primarySalesPersonName() {
            const salesPerson = this.job.primary_sales_person ? this.job.primary_sales_person[0] : {};

            return salesPerson.name;
        },
        job() {
            return this.deliveryOrder.job || {};
        },
    },
    created() {
      if (!this.deliveryOrderId) {
        this.fetchDeliveryOrderIndex();
      } else {
        this.fetchDeliveryOrder(this.deliveryOrderId);
      }
    },
    methods: {
        formatViewDate,
        displayMoney,
        displayNumber,
        closeModal(name) {
            if (name) {
                this[`mount${name}`] = false;
            }
        },
        openModal(name) {
            if (name) {
                this[`mount${name}`] = true;
            }
        },
        handleSelectDelivery(order) {
            this.closeModal('SearchDeliveryOrdersModal');
            this.fetchDeliveryOrder(order);
        },
        fetchDeliveryOrderIndex() {
            this.enableLoading();
            axios.get("/api/delivery-orders/index")
            .then(({ data }) => {
            if (data.data.id) {
                this.fetchDeliveryOrder(data.data.id);
            } else {
                this.$toastr('error', 'No records.', 'Error!!')
            }
            })
            .catch(error => console.log(error))
            .finally(this.disableLoading);
        },
        fetchDeliveryOrder(id) {
            this.enableLoading();
            axios.get(`/api/delivery-orders/${id}`).then(({ data }) => {
                this.deliveryOrder = data.data;
            })
            .catch(error => console.log(error))
            .finally(() => this.disableLoading());
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
