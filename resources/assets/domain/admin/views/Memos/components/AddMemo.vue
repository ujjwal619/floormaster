<template>
  <modal :title="getTitle" @close="handleClose">
    <loading :loading="loading" />
    <div slot="modal-body" class="px-2">
      <template v-if="hasJob">
        <div class="row">
          <label>{{ job.job_id }}</label>
        </div>
        <div class="row">
          <label>{{ job.trading_name }}</label>
        </div>
        <div class="row">
          <label>Re: {{ customerAddress.street + ', ' + customerAddress.town + ' ' + customerAddress.state + ' ' + customerAddress.code }}</label>
        </div>
      </template>
      <template v-if="hasQuote">
        <div class="row">
          <label>{{ quote.quote_id }}</label>
        </div>
        <div class="row">
          <label>{{ quote.trading_name }}</label>
        </div>
        <div class="row">
          <label>Re: {{ customerAddress.street + ', ' + customerAddress.town + ' ' + customerAddress.state + ' ' + customerAddress.code }}</label>
        </div>
      </template>
      <div class="row pt-3">
        <label class="col-3 text-right">Date:</label>
        <template v-if="isEdit">
          <label class="ml-2">{{ model.date }}</label>
        </template>
        <template v-else>
          <input 
            type="date" 
            class="col-8 form-control ml-2" 
            v-model="model.date" 
            name="date" v-validate="'required'"
          />
          <label class="col-10 text-right error">{{ errors.first('date') }}</label>
        </template>
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Time:</label>
        <template v-if="isEdit">
          <label class="ml-2">{{ model.time }}</label>
        </template>
        <template v-else>
          <input 
            type="time" 
            class="col-8 form-control ml-2" 
            v-model="model.time" 
            name="time" v-validate="'required'"
          />
          <label class="col-10 text-right error">{{ errors.first('time') }}</label>
        </template>
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">For Staff ID:</label>
        <drop-down
          class="col-8 ml-2"
          :options="users"
          placeholder="Select User"
          :default-selected="defaultSelectedUser"
          label="username"
          v-model="selectedUserId"
          name="staff id"
          v-validate="'required'"
        />
        <label class="col-10 text-right error">{{ errors.first('staff id') }}</label>
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Subject:</label>
        <input 
          type="text" 
          class="col-8 form-control ml-2" 
          v-model="model.subject" 
          name="subject" v-validate="'required'"
        />
        <label class="col-10 text-right error">{{ errors.first('subject') }}</label>
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Text:</label>
        <textarea 
          v-model="model.details" 
          name="text" 
          v-validate="'required|min:5'"
          class="col-8 ml-2"
        ></textarea>
        <label class="col-10 text-right error">{{ errors.first('text') }}</label>
      </div>
      <div class="row pt-3">
        <label class="col-3">&nbsp;</label>
        <input type="checkbox" class="ml-2" v-model="model.further_action"/>
        <label class="col-6 ml-1">Further Action Required</label>
      </div>
      <div class="row pt-3" v-show="isEdit">
        <label class="col-3">&nbsp;</label>
        <label class="col-8 ml-1">Uncheck 'Further Action Required' to remove this
          Memo from Active Memos
        </label>
      </div>
    </div>
    <template slot="modal-footer">
      <button v-show="isEdit" type="button" class="btn action-buttons mr-3" @click="removeMemo" >Remove</button>
      <button type="button" class="btn action-buttons" @click="saveMemo" >Save</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins'
import {
  getUsersBySite,
} from "../../../api/calls";

const BASE_STATE = {
  further_action: true,
}

export default {
  name: "AddMemo",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    siteId: {
      type: Number,
      required: true,
    },
    selectedMemo: {
      type: Object,
      default: () => {},
    },
    job: {
      type: Object,
      default: () => ({}),
    },
    quote: {
      type: Object,
      default: () => ({}),
    },
  },
  data: () => ({
    model: { ...BASE_STATE },
    users: [],
    selectedUserId: '',
  }),
  computed: {
    isEdit() {
      return !!this.selectedMemo.id;
    },
    getTitle() {
      return this.isEdit ? 'Edit Memo' : 'Add Memo';
    },
    defaultSelectedUser() {
      return this.isEdit ? this.selectedMemo.user : {};
    },
    hasJob() {
      return !!this.job.id;
    },
    hasQuote() {
      return !!this.quote.id;
    },
    customerAddress() {
      return this.hasJob ? this.job.address || {} : this.quote.adddress || {};
    },
  },
  watch: {
    selectedMemo: {
      immediate: true,
      deep: true,
      handler (memo) {
        if (memo.id) {
          this.model = { ...memo };
        }
      }
    },
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    removeMemo() {
      let confirmation = confirm('Are you sure you want to delete?');
      if (confirmation) {
        this.enableLoading();
        axios.delete(`/api/memos/${this.selectedMemo.id}`)
          .then(() => {
            this.$emit('saved');
            this.$toastr('success', `Successfully removed memo.`, 'Success!!')
          })
          .catch(() => {
            console.log('could not remove Memo');
          })
          .finally(() => {
            this.handleClose();
            this.disableLoading();
          });
      }
    },
    fetchUsers() {
      this.enableLoading();
      getUsersBySite(this.siteId)
        .then(({ data }) => {
          this.users = data.data;
        })
        .catch(() => {
          console.log('could not fetch users');
        })
        .finally(this.disableLoading);
    },
    validate() {
      return this.$validator.validate();
    },
    saveMemo() {
      this.validate()
        .then(valid => {
          if (valid) {
            this.enableLoading();
            let url = this.isEdit ? `/api/memos/${this.selectedMemo.id}` : '/api/memos';
            if (!this.isEdit && this.hasJob) {
              url = `/api/jobs/${this.job.id}/memos`;
            }
            if (!this.isEdit && this.hasQuote) {
              url = `/api/quotes/${this.quote.id}/memos`;
            }
            const method = this.isEdit ? 'put' : 'post';
            axios[method](url, { ...this.model, user_id: this.selectedUserId})
              .then(({ data }) => {
                this.$emit('saved');
                this.$toastr('success', `Successfully ${this.isEdit ? 'update' : 'create'}d memo.`, 'Success!!')
              })
              .catch(() => {
                this.$toastr('error', `Could not ${this.isEdit ? 'update' : 'create'} memo.`, 'Error!!')
              })
              .finally(() => {
                this.handleClose();
                this.disableLoading();
              })
          }
        });
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>
