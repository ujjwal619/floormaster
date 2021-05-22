<div class="form-container">
    <div class="col-xsmall-12 col-small-12">
        <permission
            :selected-data="defaultPermissions" 
            :is-super-admin="user.is_super_admin"
            v-model="selectedPermissions"
            :is-edit-mode="isEditMode"
            @input="setUserUpdatedPermission"
            @superuser="setUserSuperUser"
        />
    </div>

    <div class="col-xsmall-12 col-small-12 mt-3">
        <portlet-content isform="true" :onlybody="true">
            <div slot="body" class="menu-bar d-flex justify-content-between">
                <div class="mt-1 mb-1 col-4">
                    <button type="button" class="btn action-buttons" v-if="!isEditMode" @click="changeEditMode(true)">Edit</button>
                    <button type="button" class="btn action-buttons" v-if="isEditMode" @click="cancelEditMode">Cancel</button>
                    <button type="button" class="btn action-buttons" v-if="isEditMode" @click="saveUserInfo(true)">Save</button>
                    <button type="button" class="btn action-buttons" @click="openSearchUserModal">Search</button>
                    <button type="button" class="btn action-buttons" @click="openAddUserModal">Add</button>
                    <button type="button" class="btn action-buttons" >Delete</button>
                </div>
                <div class="d-inline-flex align-items-center col-7">
                    <div class="row">
                        <span class="h6 d-inline-flex pr-2 m-0 col-1">UserId</span>
                        <input type="text" class="form-control col-3" :disabled="!isEditMode" v-model="user.username">
                        <button type="button" class="btn action-buttons text-primary ml-2 col-2" @click="openChangePasswordModal" :disable="!user" >password</button>
                        <div class="col-5">
                            <drop-down
                                ref="siteDropdown"
                                :default-selected="backupUserData.sites"
                                class="site-dropdown"
                                :disabled="!isEditMode"
                                :options="sites"
                                v-model="user.sites"
                                :multiple="true"
                                :close-on-select="false"
                                name="sites"
                                :show-multiple-label="false"
                            >
                                <template slot="selection" slot-scope="{ data }">
                                    <span class="multiselect__single" v-if="data.values.length &amp;&amp; !data.isOpen">@{{ data.values.length }} sites selected</span>
                                </template>
                                <template slot="option" slot-scope="{ data }"><span>@{{ data.name }}</span></template>
                            </drop-down>
                        </div>
                    </div>
                </div>
                <span class="background-black text-truncate mr-3 my-1 col-1">
                    Security
                </span>
            </div>
        </portlet-content>
    </div>
    <template v-if="mountAddUser">
        <add-user
            @close="closeAddUserModal"
            :sites="sites"
            @created="userCreated"
        />
    </template>
    <template v-if="mountChangePassword">
        <change-password
            @close="closeChangePasswordModal"
            :user="user"
        />
    </template>
    <template v-if="mountSearchUser">
        <search-user
            @search-and-close="userModalSearchHandler"
            @close="closeSearchUserModal"
        />
    </template>
</div>
