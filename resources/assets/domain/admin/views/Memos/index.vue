<template>
  <div class="form-container">
    <template>
      <loading :loading="loading" />
    </template>
    <div class="row">
      <span class="col-1 text-right h4">Store:</span>
      <drop-down
        class="col-3"
        :options="sites"
        v-model="selectedSite"
        style="max-height: 40px;"
        :default-selected="sites[0]"
      />
      <div class="col-1 ml-1">
        <button 
          type="button"
          class="btn bg-transparent border-dark"
          style="color: yellow;"
          @click="mountSetUser = true"
        >
          SET >>
        </button>
      </div>
      <h3 class="col-1" style="color: yellow">{{ selectedUser.username }}</h3>
      <h3 class="col-5 text-right" style="color: yellow;">
        Memos Requiring Action
      </h3>
    </div>
    <div class="table-wrap pt-2">
      <portlet-content :onlybody="true" :height="460">
        <template slot="body">
          <div class="col-xsmall-12" style="max-height: 450px;overflow-y: scroll;">
            <table class="table table-bordered">
              <thead>
              <tr>
                <td style="width: 10%">Id</td>
                <td style="width: 10%">Job</td>
                <td style="width: 15%">Time</td>
                <td style="width: 20%">Subject</td>
                <td style="width: 55%">Text</td>
              </tr>
              </thead>
              <tbody>
              <tr 
                v-for="memo in memos" 
                :key="memo.id"
              >
                <td style="width: 10%" @click="editMemo(memo)">&nbsp;</td>
                <td style="width: 10%" @click="redirectToReference(memo)">{{ getReferenceInfo(memo) }}</td>
                <td style="width: 15%" @click="editMemo(memo)">{{ formatViewDate(memo.date) + ' ' + memo.time }}</td>
                <td style="width: 20%" @click="editMemo(memo)">{{ memo.subject }}</td>
                <td style="width: 55%" @click="editMemo(memo)">{{ memo.details }}</td>  
              </tr>
              </tbody>
            </table>
          </div>
        </template>
      </portlet-content>
    </div>
    <div class="col-xsmall-12 col-small-12">
      <portlet-content isform="true" :onlybody="true">
        <template slot="body">
          <button type="button" class="btn action-buttons" @click="fetchMemoByUser(selectedUser.id)">Refresh</button>
          <button type="button" class="btn action-buttons" @click="mountAddMemo = true">Add</button>
        </template>
      </portlet-content>
    </div>

    <template v-if="mountAddMemo">
      <add-memo
        :site-id="selectedSite"
        :selected-memo="selectedMemoForEdit"
        @saved="memoSaved"
        @close="closeAddMemoModal"
      />
    </template>

    <template v-if="mountSetUser">
      <set-user
        :site-id="selectedSite"
        @selected="userSelected"
        @close="mountSetUser = false"
      />
    </template>
  </div>
</template>

<script>
  import { LoadingMixin } from "../../../common/mixins";
  import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
  import AddMemo from "./components/AddMemo";
  import SetUser from "./components/SetUser";
  import DropDown from '../../../common/components/DropDown/DropDown'
  import { 
    getUsers, 
    getMyProfile,
    getUserById,
    getMemosByUser,
    getSites
  } from "../../api/calls";
  import { formatViewDate } from '../../../common/utitlities/helpers';

  export default {
    name: "Memos",
    mixins: [LoadingMixin],
    components: {
      PortletContent,
      AddMemo,
      SetUser,
      DropDown
    },
    data: () => ({
      sites: [],
      selectedSite: '',
      mountAddMemo: false,
      mountSetUser: false,
      selectedUser: {},
      memos: [],
      selectedMemoForEdit: {},
    }),
    watch: {
      selectedUser: {
        deep: true,
        handler (user) {
          if (user.id) {
            this.fetchMemoByUser(user.id);
          }
        }
      }, 
    },
    created() {
      this.fetchSites();
      this.fetchMyProfile();
    },
    methods: {
      formatViewDate,
      getReferenceInfo(memo) {
        if (memo.reference) {
          if (memo.reference_type == 'job') {
            return memo.reference.job_id;
          }

          if (memo.reference_type == 'quote') {
            return memo.reference.quote_id;
          }
        }

        return '';
      },
      redirectToReference(memo) {
        if (memo.reference_type == 'job') {
          window.location.href = `/jobs/${memo.reference_id}/edit`;
        }

        if (memo.reference_type == 'quote') {
          window.location.href = `/quotes/${memo.reference_id}/edit`;
        }

        return;
      },
      closeAddMemoModal() {
        this.selectedMemoForEdit = {};
        this.mountAddMemo = false;
      },
      memoSaved() {
        this.fetchMemoByUser(this.selectedUser.id);
      },
      editMemo(memo) {
        this.selectedMemoForEdit = memo;
        this.mountAddMemo = true;
      },
      userSelected(userId) {
        this.fetchUserById(userId);
      },
      fetchUserById(userId) {
        this.enableLoading();
        getUserById(userId)
          .then(({ data }) => {
            this.selectedUser = data.data;
          })
          .catch(() => {
            this.$toastr("error", "Could not get memos for user.", "Error!!")
          })
          .finally(this.disableLoading);
      },
      fetchMyProfile() {
        this.enableLoading();
        getMyProfile()
            .then(({ data }) => {
              this.selectedUser = data.data;
            })
            .catch(() => {
              this.$toastr("error", "Could not get memos for user.", "Error!!")
            })
            .finally(this.disableLoading);
      },
      fetchMemoByUser(userId) {
        this.enableLoading();
        getMemosByUser(userId)
          .then(({ data }) => {
            this.memos = data.data;
          })
          .catch(() => {
            this.$toastr("error", "Could not get memos for user.", "Error!!")
          })
          .finally(this.disableLoading);
      },
      fetchSites() {
        this.enableLoading();
        getSites()
          .then(({ data }) => {
            this.sites = data.data;
          })
          .catch(() => {
            this.$toastr("error", "Could not get sites.", "Error!!")
          })
          .finally(this.disableLoading);
      },
    },
  }
</script>