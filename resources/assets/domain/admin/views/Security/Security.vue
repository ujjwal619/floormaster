<script>
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import Modal from "../../../common/components/Modal/Modal";
import AddUser from "./components/AddUser";
import SearchUser from "./components/SearchUser";
import ChangePassword from "./components/ChangePassword";
import DropDown from "../../../common/components/DropDown/DropDown";
import Permission from "./components/Permission";
import { getMyProfile, getUserById, putUser, getSites } from '../../api/calls';

export default {
  name: "Security",
  components: {
    AddUser,
    ChangePassword,
    DropDown,
    Modal,
    PortletContent,
    SearchUser,
    Permission
  },
  props: {},
  data: () => ({
    isEdit: false,
    mountAddUser: false,
    mountChangePassword: false,
    mountSearchUser: false,
    permissions: {},
    sites: [],
    user: {
      id: "",
      sites: [],
      username: "",
      is_super_admin: false,
    },
    backupUserData: {},
    defaultPermissions: [],
    selectedPermissions: [],
  }),
  computed: {
    isEditMode() {
      return !!this.isEdit;
    },
    defaultSites() {
      // return this.user.sites.map(site => site.id);
    },
  },
  created() {
    this.fetchSites();
    this.fetchCurrentUser();
  },
  methods: {
    setUserUpdatedPermission(permission) {
      this.user.permissions = [...permission];
    },
    setUserSuperUser(data) {
      this.user.is_super_admin = data;
    },
    cancelEditMode() {
      this.user = Object.assign({}, { ...this.backupUserData });
      if (this.$refs.siteDropdown) {
        this.$refs.siteDropdown.reset();
      }
      this.changeEditMode(false);
    },
    saveUserInfo() {
      putUser(this.user.id, this.user)
        .then(({ data }) => {
          this.fetchUser(this.user.id)
            .catch(error => {
              this.$toastr("error", `Could not fetch user data`, "Error!!");
            });
          this.$toastr("success", "Successfully edited User Info", "Success!!");
        })
        .catch(error => {
          this.$toastr("error", `Could not edit User Info`, "Error!!");
        })
        .finally(() => this.changeEditMode(false));
    },
    changeEditMode(value) {
      this.isEdit = value;
    },
    userCreated(id) {
      this.closeAddUserModal();
      this.fetchUser(id).catch(error => {
        this.$toastr("error", `Could not fetch user data`, "Error!!");
      });
    },
    fetchUser(id) {
      return getUserById(id).then(({ data }) => {
        this.user = data.data;
        this.user.is_super_admin = data.meta.is_super_admin;
        this.defaultPermissions = this.user.permissions.map(permission => permission.name);
        this.backupUserData = { ...data.data };
      });
    },
    fetchCurrentUser() {
      getMyProfile()
        .then(({ data }) => {
          this.user = { ...data.data };
          this.user.is_super_admin = data.meta.is_super_admin;
          this.defaultPermissions = this.user.permissions.map(permission => permission.name);
          this.backupUserData = { ...data.data };
        })
        .catch(error => {
          this.$toastr("error", `Could not fetch current user data`, "Error!!");
        });
    },
    fetchSites() {
      getSites().then(({ data }) => {
        this.sites = data.data;
      });
    },
    closeAddUserModal() {
      this.mountAddUser = false;
    },
    openAddUserModal() {
      this.mountAddUser = true;
    },
    closeSearchUserModal() {
      this.mountSearchUser = false;
    },
    userModalSearchHandler({ id = '' }) {
      this.closeSearchUserModal();
      if (id) {
        this.fetchUser(id)
          .then(() =>
            this.$toastr("success", "Successfully fetched user data", "Success!!")
          )
          .catch(error => {
            this.$toastr("error", `Could not fetch user data`, "Error!!");
          });
      }
    },
    openSearchUserModal() {
      this.mountSearchUser = true;
    },
    closeChangePasswordModal() {
      this.mountChangePassword = false;
    },
    openChangePasswordModal() {
      this.mountChangePassword = true;
    }
  }
};
</script>

<style scoped>
  .site-dropdown {
    min-width: 250px;
  }
</style>
