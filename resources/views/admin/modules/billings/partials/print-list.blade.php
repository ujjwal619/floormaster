<div class="form-container" id="section-to-print">
    <div class="col-xsmall-12 col-small-12" @keydown.esc="escKeyPress">
      <div class="row">
          <div class="col-6">
              <div class="row">
                <portlet-content :height="220" :onlybody="true" class="col-12 px-2">
                    <div slot="body" class="form-group p-2">
                        <div class="row pb-2">
                            <span class="h5 text-danger">
                              @{{ clientName }}
                            </span>
                        </div>
                        <div class="row pb-2">
                            <span class="h5 ">@{{ address.street }}</span>
                        </div>
                        <div class="row pb-2">
                            <span class="h5 col-lg-5">@{{ address.town }}</span>
                            <span class="h5 col-lg-1">@{{ address.state }}</span>
                            <span class="h5 col-lg-1">@{{ address.code }}</span>
                        </div>
                        <div class="row pb-2 mt-3">
                            <span class="h5">@{{ job.contact }}</span>
                        </div>
                        <br/>
                        <div class="row pb-2 mt-3">
                            <span class="h5">Re: @{{ job.project }}</span>
                        </div>
                      </div>
                </portlet-content>
              </div>
          </div>
          <div class="col-6 d-flex flex-column align-items-end px-1 pt-4">
            <span class="h2 text-warning text-bold">Tax Invoice</span>
            <span class="h5 text-warning">@{{ formatViewDate(invoice.date) }}</span>
            <span class="h5 text-warning">@{{ job.site.quote_prefix + '' + job.job_id + '/'+ invoice.id }}</span>
            <input type="text" class="h4 text-warning text-bold text-right" :value="invoice.amount.toFixed(2)" disabled style="width: 200px">
          </div>
      </div>
      <div class="row notes-block">
        <portlet-content :height="350" :onlybody="true" class="col-12 px-1">
            <div slot="body" class="p-2">
              <textarea cols="10" rows="12" v-model="model.remarks"></textarea>
            </div>
        </portlet-content>
      </div>
      <div class="row action-bar">
        <span class="h5 text-warning pl-1 pt-2 text-bold">
          Make any text changes that you may requie.
          Press your ESC key when completed.
        </span>
      </div>
    </div>

    <div class="col-xsmall-12 col-small-12 mt-1 action-bar">
        <portlet-content isform="true" :onlybody="true">
            <div slot="body" class="menu-bar d-flex justify-content-between">
              {{--<button class="btn action-buttons" @click="showPrintOrCancel">Print Or Cancel</button>--}}
              <span class="background-black text-truncate mr-3 my-1 p-1">
                  Blilling Text Editor
              </span>
            </div>
        </portlet-content>
    </div>

    <template v-if="mountPrintOrCancel">
      <print-or-cancel
        @close="hidePrintOrCancel"
        @print="escKeyPress"
      />
    </template>

    <template v-if="mountAllocateMit">
      <allocate-mit
        :job="job"
        :non-allocated-mit="nonAllocatedReceipts"
        @updated="mountAllocateMit = false"
        @close="mountAllocateMit = false"
      />
    </template>
</div>
