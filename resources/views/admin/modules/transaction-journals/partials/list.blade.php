<div class="form-container">
    <div class="col-xsmall-12 col-small-12">
      <div class="row"></div>
      <div class="col-12 row">
        <span class="col-lg-1 text-right h4">Store:</span>
        <drop-down
                class="col-3"
                :options="sites"
                v-model="selectedSite"
                style="max-height: 40px;"
                :default-selected="sites[0]"
        />
      </div>
        <div class="row pt-2">
            <div class="col-12 ml-1">
                <button
                    v-for="(item, index) in $options.TABS"
                    :key="item.id"
                    type="button"
                    class="btn col-1 tab-selector"
                    :class="{ active: currentTab === item.id }"
                    @click="selectTab(item.id)"
                >
                    @{{ item.name }}
                </button>
            </div>
        </div>
        <div class="table-wrap mt-2">
            <portlet-content :onlybody="true" :height="650">
                <div slot="body" class="row">
                    <div class="col-xsmall-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 5%">&nbsp;</th>
                                    <th style="width: 70%">Account</th>
                                    <th style="width: 12.5%" class="text-center">A/C Balance</th>
                                    <th style="width: 12.5%" class="text-center text-primary">Header Balance</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    
                    <accounts-table
                        :current-tab="currentTab"
                        :accounts="accounts"
                        @edit="openEditModal"
                    />

            </portlet>
        </div>
            
    </div>

    <div class="col-xsmall-12 col-small-12 mt-3">
        <portlet-content isform="true" :onlybody="true">
            <div slot="body" class="menu-bar d-flex justify-content-between">
                <div class="mt-1">
                    <button type="button" class="btn action-buttons">Report</button>
                    <button type="button" class="btn action-buttons" @click="addNewAccount">Add</button>
                </div>
                <span class="background-black text-truncate mr-3 my-1 p-1">
                    Chart of Accounts - 
                </span>
            </div>
        </portlet-content>
    </div>
    <template v-if="mountNewAccountsModal">
        <new-accounts-modal 
            :tab-data="selectedTabData"
            @close="closeNewAccount"
            :header-accounts="headerAccounts"
            @saved="handleAccountSave"
            :account="selectedAccount"
            :selected-site="selectedSiteData"
        />
    </template>
</div>
