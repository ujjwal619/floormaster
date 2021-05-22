<div class="form-container">
	<template>
        <loading :loading="loading" />
		<!-- ssadf -->
    </template>
	<div class="col-xsmall-12 col-small-12">
		<div class="row">
			<div class="col-3">
				<div class="row">
					<span class="col-lg-2 text-right h4">Store:</span>
					<drop-down
									class="col-9"
									:options="sites"
									v-model="selectedSite"
									style="max-height: 40px;"
									:default-selected="sites[0]"
					/>
				</div>
			</div>
			<div class="col-3">
				<div class="row">
					<span class="col-lg-2 text-right h4">Month:</span>
					<drop-down
									class="col-5"
									:options="allMonths"
									v-model="selectedMonth"
									:return-object="true"
									style="max-height: 40px;"
									:default-selected="allMonths[0]"
					/>
				</div>
			</div>
		</div>
		<div class="row pt-3">
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
							:account-total-type="accountTotalType"
							:accounts="accounts"
							@edit="openEditModal"
					/>
				</div>
			</portlet>
		</div>
	</div>

	<div class="col-xsmall-12 col-small-12 pb-3 mr-1">
		<h6 class="row text-white float-right">
			<b>@{{ getViewFiscalYear() }}</b>
		</h6>
	</div>

	<div class="col-xsmall-12 col-small-12">
			<portlet-content isform="true" :onlybody="true">
					<div slot="body" class="menu-bar d-flex justify-content-between">
							<div class="mt-1">
									<button type="button" class="btn action-buttons">Report</button>
									<button 
										v-if="hasPermission('account.chart.add.to.chart')"
										type="button" 
										class="btn action-buttons" 
										@click="addNewAccount"
									>Add</button>
									<button 
										v-if="hasPermission('account.chart.edit.chart')"
										type="button" 
										class="btn action-buttons" 
										@click="openUpdateModal"
										:class="{ 'disabled' : isGlRecordingOff }"
										:disabled="isGlRecordingOff"
										:title="updateButtonTitle"
									>
										Update
									</button>
							</div>
							<span class="background-black text-truncate mr-3 my-1 p-1">
									Chart of Accounts - @{{ selectedTabData.name }}
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

	<template v-if="mountUpdateModal">
		<update-modal 
			@close="mountUpdateModal = false"
			@rebuild="mountRebuildChartBalance = true"
			@close-period="mountClosePeriod = true"
		/>
	</template>

	<template v-if="mountRebuildChartBalance">
		<rebuild-chart-balance-modal
			@saved="handleRebuild"
			@close="mountRebuildChartBalance = false"
		/>
	</template>

	<template v-if="mountClosePeriod">
		<close-period-modal
			@current-period="mountCurrentYearError = true"
			@close="mountClosePeriod = false"
		/>
	</template>

	<template v-if="mountCurrentYearError">
        <fm-error
            message="This financial period is still current and can't be closed."
            @close="mountCurrentYearError = false"
        />
    </template>
</div>
