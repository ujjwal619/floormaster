<script>
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import PrintOrCancel from './PrintOrCancel';
import AllocateMit from "../Jobs/components/AllocateMIT"
import { getNonAllocatedReceipts } from "../../api/calls"
import { formatViewDate } from '../../../common/utitlities/helpers'

export default {
  name: "Print",
  components: {
    PortletContent,
    PrintOrCancel,
    AllocateMit,
  },
  data() {
    return {
      mountPrintOrCancel: false,
      mountAllocateMit: false,
      model: {},
      nonAllocatedReceipts: [],
    };
  },
  props: {
    invoice: {
      type: Object,
      required: true
    },
  },
  beforeDestroy() {
    window.onafterprint = '';
  },
  watch: {
    invoice: {
      immediate: true,
      handler(value) {
        this.model = {
          date: value.date,
          amount: value.amount,
          remarks: value.remarks,
          net_invoice: value.net_invoice,
          gst: value.gst
        }
      }
    }
  },
  computed: {
    address() {
      return this.job.address || {};
    },
    customer() {
      return this.job.customer || {};
    },
    clientName() {
      return `${this.job.title || ''} ${this.job.firstname || ''} ${this.job.trading_name || ''}` || '';
    },
    job() {
      return this.invoice.job || {};
    },
  },
  created() {
    getNonAllocatedReceipts(this.job.id)
      .then(({ data }) => {
        this.nonAllocatedReceipts = data.data;
        if (data.data.length) {
          this.mountAllocateMit = true;
        }
      })
      .catch(() => {
        console.log('could not fetc');
      })
  },
  methods: {
    formatViewDate,
    showPrintOrCancel() {
      this.mountPrintOrCancel = true;
    },
    hidePrintOrCancel() {
      this.mountPrintOrCancel = false;
    },
    escKeyPress() {
      this.hidePrintOrCancel();
      this.$nextTick().then(() => {
        window.onafterprint = this.saveAndSendBack();
        window.print();
      });
    },
    saveAndSendBack() {
      axios.put(`/api/jobs/${this.invoice.job.id}/invoice/${this.invoice.id}`, this.model)
        .then(() => {})
        .catch(() => {})
        .finally(() => {
          this.sendBack();
        })
    },
    sendBack() {
      window.location.href = `/jobs/${this.invoice.job.id}/edit?page=3`;
    }
  }
};
</script>

<style scoped>
.notes-block {
  margin-top: 15px !important;
}

.background-black {
  background-color: black;
  color: white;
  width: fit-content;
  padding: 3px;
}

</style>

<style>

@media print {
  body *{
    visibility: hidden;
  }
  .action-bar {
    display: none;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
}
</style>
