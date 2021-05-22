<template>
    <div class="row">
        <div class="col-6">
            <div class="row">
                <portlet-content :height="758" :onlybody="true" class="col-12 px-2">
                    <div slot="body" class="form-group p-2">
                        <b>Super User</b>
                        <input :disabled="!isEditMode" type="checkbox" :value="true" v-model="superUser">
                        <div class="col-lg-2 pb-2">
                            <span class="background-black text-truncate"> Job Control</span>
                        </div>
                        <div class="jobsource-permission permissions--column">
                            <span 
                                v-for="(permission, index) in getJobControlPermission" 
                                :key="index"
                                :class="{ 'mb-2 mt-3' : permission.is_header }"
                            >
                                <label :class="{ 'pl-4': !permission.is_header }">
                                    <input :disabled="!isEditMode" type="checkbox" :value="permission.name" v-model="selected">
                                    <span :class="[permission.is_header ? 'h5 text-primary' : 'h6' ]">{{ permission.display_name }}</span>
                                </label>
                            </span>
                        </div>
                    </div>
                </portlet-content>
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <portlet-content :height="300" :onlybody="true" class="px-2 col-12">
                    <div slot="body" class=" p-2">
                        <div class="d-flex justify-content-between">
                            <span class="background-black text-truncate">Creditors</span>
                            <span class="h6 text-primary">NB A/C chart access also controls Journal Access</span>
                        </div>
                        <div class="creditors-permission permissions--column">
                            <span 
                                v-for="(permission, index) in getCreditorsPermission" 
                                :key="index"
                                :class="{ 'mb-2 mt-3' : permission.is_header }"
                            >
                                <label :class="{ 'pl-4': !permission.is_header }">
                                    <input :disabled="!isEditMode" type="checkbox" :value="permission.name" v-model="selected">
                                    <span :class="[permission.is_header ? 'h5 text-primary' : 'h6' ]">{{ permission.display_name }}</span>
                                </label>
                            </span>
                        </div>
                    </div>
                </portlet-content>
                <portlet-content :height="250" :onlybody="true" class="px-2 col-12">
                    <div slot="body" class=" p-2">
                        <span class="background-black text-truncate">Stock Control</span>
                        <div class="stockcontrol-permission permissions--column">
                            <span 
                                v-for="(permission, index) in getStockControlPermission" 
                                :key="index"
                                :class="{ 'mb-2 mt-3' : permission.is_header }"
                            >
                                <label :class="{ 'pl-4': !permission.is_header }">
                                    <input :disabled="!isEditMode" type="checkbox" :value="permission.name" v-model="selected">
                                    <span :class="[permission.is_header ? 'h5 text-primary' : 'h6' ]">{{ permission.display_name }}</span>
                                </label>
                            </span>
                        </div>
                    </div>
                </portlet-content>
                <portlet-content :height="200" :onlybody="true" class="px-2 col-12">
                    <div slot="body" class=" p-2">
                        <div class="d-flex justify-content-between w-90">
                            <span class="background-black text-truncate">Bookings</span>
                            <span class="background-black text-truncate">Prices</span>
                            <span class="background-black text-truncate">Fax</span>
                            <span class="background-black text-truncate">General</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="permissions--column">
                                <span 
                                    v-for="(permission, index) in getBookingsPermission" 
                                    :key="index"
                                    :class="{ 'mb-2 mt-3' : permission.is_header }"
                                >
                                    <label :class="{ 'pl-4': !permission.is_header }">
                                        <input :disabled="!isEditMode" type="checkbox" :value="permission.name" v-model="selected">
                                        <span :class="[permission.is_header ? 'h5 text-primary' : 'h6' ]">{{ permission.display_name }}</span>
                                    </label>
                                </span>
                            </div>
                            <div class="permissions--column">
                                <span 
                                    v-for="(permission, index) in getPricesPermission" 
                                    :key="index"
                                    :class="{ 'mb-2 mt-3' : permission.is_header }"
                                >
                                    <label :class="{ 'pl-4': !permission.is_header }">
                                        <input :disabled="!isEditMode" type="checkbox" :value="permission.name" v-model="selected">
                                        <span :class="[permission.is_header ? 'h5 text-primary' : 'h6' ]">{{ permission.display_name }}</span>
                                    </label>
                                </span>
                            </div>
                            <div class="permissions--column">
                                <span 
                                    v-for="(permission, index) in getFaxPermission" 
                                    :key="index"
                                    :class="{ 'mb-2 mt-3' : permission.is_header }"
                                >
                                    <label :class="{ 'pl-4': !permission.is_header }">
                                        <input :disabled="!isEditMode" type="checkbox" :value="permission.name" v-model="selected">
                                        <span :class="[permission.is_header ? 'h5 text-primary' : 'h6' ]">{{ permission.display_name }}</span>
                                    </label>
                                </span>
                            </div>
                            <div class="permissions--column justify-content-center pt-3">
                                <span 
                                    v-for="(permission, index) in getGeneralPermission" 
                                    :key="index"
                                >
                                    <label>
                                        <input :disabled="!isEditMode" type="checkbox" :value="permission.name" v-model="selected">
                                        <span class="h5 text-danger">{{ permission.display_name }}</span>
                                    </label>
                                </span>
                                <div class="d-inline-flex align-items-center">
                                    <label class="pr-1">Minimum GP%:</label><input type="number" class="minimum-gp--input">
                                </div>
                            </div>
                        </div>      
                        
                    </div>
                </portlet-content>
            </div>
        </div>
    </div>
</template>

<script>
import PortletContent from "../../../../common/components/Portlets/Content/PortletContent";

const PERMISSION_MAP = {
  job_control: "Job Control",
  general: "General",
  prices: "Prices",
  fax: "Fax",
  bookings: "Bookings",
  stock_control: "Stock Control",
  creditors: "Creditors"
};

export default {
    name: "Permission",
    props: {
      selectedData: {
        type: Array,
        default: () => ([]),
      },
      isEditMode: {
        type: Boolean,
        required: true,
      },
      isSuperAdmin: {
        type: Boolean,
        required: true,
      },
    },
    components: {
      PortletContent,
    },
    data() {
      return {
        data: {},
        collapse: {},
        selected: [],
        superUser: ''
      };
    },
    watch: {
      selected(newData) {
        if (newData) {
          this.$emit('input', newData);
        }
      },
      selectedData() {
        this.selected = this.selectedData;
      },
      superUser(data) {
        this.$emit('superuser', data);
      },
      isSuperAdmin() {
        this.superUser = this.isSuperAdmin;
      }
    },
    computed: {
      permissionKeys() {
        return Object.keys(this.data);
      },
      getJobControlPermission() {
        return this.getPermission("job_control");
      },
      getCreditorsPermission() {
        return this.getPermission("creditors");
      },
      getStockControlPermission() {
        return this.getPermission("stock_control");
      },
      getGeneralPermission() {
        return this.getPermission("general");
      },
      getPricesPermission() {
        return this.getPermission("prices");
      },
      getFaxPermission() {
        return this.getPermission("fax");
      },
      getBookingsPermission() {
        return this.getPermission("bookings");
      },
    },
    methods: {
      getPermission(type) {
        const permissionKey = PERMISSION_MAP[type];
        if (permissionKey && this.data) {
          return this.data[permissionKey];
        } else {
          return [];
        }
      },
      hasSelected(key) {
        return this.data[key].some(permission => this.selectedData.includes(permission.id));
      },
      fetchPermissions() {
        return axios.get("/api/permissions")
          .then(({ data }) => this.setPermissions(data.data))
          .catch(({ response }) => Agentcis.alert(response.data.message || 'Something went wrong', 'danger'));
      },
      setPermissions(data) {
        this.data = data;
      },
      getPermissionId(keyIndex) {
        return this.data[this.permissionKeys[keyIndex]];
      },
    },
    created() {
      this.fetchPermissions();
    },
}
</script>

<style scoped>
.jobsource-permission {
  height: 700px;
}

.permissions--column {
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
}

.creditors-permission {
  height: 270px;
}

.stockcontrol-permission {
  height: 200px;
}

.minimum-gp--input {
  display: inline-block;
  width: 70px;
}

.w-90 {
  width: 90%;
}

</style>