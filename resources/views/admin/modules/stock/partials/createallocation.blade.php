<modal 
    title="Create Allocation" 
    :is-large="true" 
    v-if="modals.allocation.show"
    :backdrop-close="false"
    @close="hideAllocationModal"
>
  <template slot="modal-body">
    <div class="form-group row">
        <div class="col-lg-8">
          <div class="row pb-2">
            <label class="col-lg-4 text-right">Shop:</label>
            <label>@{{ site.name }}</label>
          </div>
            <div class="row pb-2">
                <label class="col-lg-4 text-right">Client:</label>
                <input class="col-lg-8 form-control" type="text" v-model="modals.allocation.values.client">
            </div>
            <div class="row pb-2">
                <label class="col-lg-4 text-right">Project:</label>
                <input class="col-lg-8 form-control" type="text" v-model="modals.allocation.values.project">
            </div>
            <div class="row pb-2">
                <label class="col-lg-4 text-right">Amount:</label>
                <input class="col-lg-8 form-control" type="number" v-model="modals.allocation.values.amount">
            </div>
            <div class="row pb-2">
                <label class="col-lg-4 text-right">Job No:</label>
              <div class="col-lg-8">
                <drop-down
                    ref="shop"
                    :default-selected="modals.allocation.selected.job"
                    :options="jobs"
                    v-model="modals.allocation.values.job_id"
                    placeholder="Select Job"
                    label="job_id"
                />
              </div>
            </div>
            <div class="row pb-2">
                <label class="col-lg-4 text-right">Job Materials:</label>
              <div class="col-lg-8">
                <drop-down
                    ref="materialsSelect"
                    :default-selected="defaultJobMaterialSale"
                    :options="jobMaterials"
                    v-model="modals.allocation.values.job_material_id"
                    placeholder="Select Job Material"
                    label="total"
                >
                    <template slot="singleLabel" slot-scope="{ data }">@{{ 'Qty: ' + data.quantity + ', Act on: ' + data.actt_on + ', color: ' + data.variant_name }}</template>
                    <template slot="option" slot-scope="{ data }"><span>@{{ 'Qty: ' + data.quantity + ', Act on: ' + data.actt_on + ', color: ' + data.variant_name }}</span></template>
                </drop-down>
              </div>
            </div>
            <div class="row pb-2">
                <label class="col-lg-4 text-right">Date Required:</label>
                <input class="col-lg-8 form-control" type="date" v-model="modals.allocation.values.date_required">
            </div>
            <div class="row pb-2">
                <label class="col-lg-4 text-right">Notes:</label>
                <textarea class="col-lg-8" id="" cols="8" rows="2" v-model="modals.allocation.values.notes"></textarea>
            </div>
            <br />
            <div class="row pb-2">
                <label class="col-lg-4 text-right">Drop off Date:</label>
                <input class="col-lg-8 form-control" type="date" v-model="modals.allocation.values.drop_off_date">
            </div>
          <span>OR</span>
            <div class="row pb-2">
                <label class="col-lg-4 text-right">Hold for </label>
                <div class="col-lg-8" style="display: flex;">
                    <input class="col-lg-4 form-control" type="number" v-model="modals.allocation.values.hold_days">
                    <span class="ml-2">days</span>
                </div>
            </div>
        </div>
        <div class="col-lg-12 pl-3 pt-3">
            <div class="row">
                <div class="col-2"> </div>
                <span class=" col-8 h6">
                    If the Job exists you should use the ACT tools on that job's costing screen. <br/>
                    To allocate to current stock or existing orders choose 'Current or Future'. <br/>
                    An 'Unlinked Allocation' will not be tied to current stock. <br/>
                    An 'Unlinked Back Order' will not be tied to future stock. <br/>
                    You can use the Move tool later to link either allocation type. <br/>
                    This Allocation can be temporary by entering a Drop off Date or a number of days to hold. <br/>
                    It will be automatically deleted by the first workstation ro run FM on the morning of the 
                    Drop off Date, or Hold Days plus 1 day.
                </span>
            </div>
        </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button
        type="button"
        class="btn action-buttons"
        @click=""
    >Unlinked Back Order
    </button>
    <button
        type="button"
        class="btn action-buttons"
    >Unlinked Allocation
    </button>
    <button
        type="button"
        class="btn action-buttons"
        @click="currentOrFutureAllocation(modals.allocation.values)"
        :disabled="stopAllocation"
        :class="{ 'disabled': stopAllocation }"
    >Current or Future
    </button>
    <button
        type="button"
        class="btn action-buttons"
        @click="hideAllocationModal"
    >Cancel
    </button>
  </template>
</modal>
