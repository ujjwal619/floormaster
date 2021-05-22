<template>
  <div class="form-container">
    <div class="row">
      <div class="col-12">
        <portlet-content :height="120" :onlybody="true" class="px-2" >
          <div slot="body" class="row">
            <div class="col-5 d-flex align-items-center row">
              <span class="text-primary col-2 text-right h4 pt-4">
                10
              </span>
              <div class="d-flex flex-column col-8">
                <label><span class="h6">Terms Name</span></label>
                <input type="text" class="text-primary w-100" value="Supply Only">
              </div>
            </div>
            <div class="col-7 d-flex row">
              <span class="background-black" style="height: fit-content;">
                Due Date <br/>
                Calculated
                from:
              </span>
              <div class="d-flex flex-column col-4 justify-content-center align-items-center" >
                <div>
                  <label>
                    <input type="radio" name="due-date-from">
                    <span class="h6">
                      100% Completion
                    </span>
                  </label>
                  <span class="font-weight-bold">OR</span>
                  <label>
                    <input type="radio" name="due-date-from">
                    <span class="h6">
                      Invoice Date
                    </span>
                  </label>
                </div>
              </div>
              <div class="d-flex flex-column justify-content-center col-6">
                <label class="d-inline-flex align-items-baseline"> 
                  <span class="h6">
                    Due by:
                  </span>
                  <input type="number" class="inline-block w-25 form-control mx-2">
                  <span class="h6">
                    Days After...
                  </span>
                </label>
                <label class="mt-2">
                  <input type="radio" name="completion">
                  <span class="h6">
                    Invoice/Completion
                  </span>
                </label>
                <span class="font-weight-bold">OR</span>
                <label>
                  <input type="radio" name="completion">
                  <span class="h6">
                    Month of Invoice/Completion
                  </span>
                </label>
              </div>
            </div>
          </div>
        </portlet-content>
      </div>
    </div>
    <div class="row pt-2">
      <div class="col-8">
        <portlet-content :height="418" :onlybody="true" class="pl-2">
          <div slot="body" class="row px-2">
            <label for="quote-terms">Quote Terms:</label>
            <textarea id="quote-terms" cols="15" rows="15"></textarea>
          </div>
        </portlet-content>
      </div>
      <div class="col-4 px-2">
        <portlet-content :height="200" header="Print Type" class="pr-2">
          <div slot="body" class="d-flex">
            <label>
              <input type="radio" name="print-type">
              Domestic
            </label>
            <label class="ml-2">
              <input type="radio" name="print-type">
              Commercial
            </label>
          </div>
        </portlet-content>
        <portlet-content :height="75" header="Print Type" class="pr-2">
          <div class="d-flex justify-content-center align-items-center" slot="body">
            <label class="d-inline-flex">
              Deposit% Required:
              <input type="text" class="ml-2 form-control">
            </label>          
          </div>
        </portlet-content>
        <portlet-content :height="65" header="Print Type" class="pr-2">
          <div class="d-flex justify-content-center align-items-center" slot="body">
            <label>
              <input type="checkbox" class="mr-2">
              Installer Bills Direct to Customer
            </label>          
          </div>
        </portlet-content>
        <portlet-content :height="65" header="Print Type" class="pr-2">
          <div class="d-flex justify-content-center align-items-center" slot="body">
            <label>
              <input type="checkbox" class="mr-2">
              Financed
            </label>          
          </div>
        </portlet-content>
      </div>
    </div>
    <div class="row pt-2">
      <div class="col-8">
        <portlet-content :height="300" :onlybody="true" class="pl-2">
          <template slot="body">
            <label for="invoice-terms">Invoice Terms:</label>
            <textarea id="invoice-terms" cols="15" rows="10"></textarea>
          </template>
        </portlet-content>
      </div>
      <div class="col-4 px-2">
        <portlet-content :height="300" :onlybody="true" class="pr-2">
          <template slot="body">
            <label>
              Enter as many sets of Terms as required. These will be available from
              the Add Quote or Add Job functions. Type in your terms continuously, the
              system will wrap words to the next line. The Enter key to Forces a 
              paragraph break. Your terms will print in a different font and will not
              format exactly as displayed on this screen.
              <br/><br/>
              Select how you want your Due Date calculated, enter the number of days
              that will add from either Completion date or Invoice date. This effects Work
              in Progress offstting. Select whether you want the days added to the 
              Invoice/Completion date or the end of that month.
              <br/><br/>
              There are 2 printingh options. Test by printing a Quote and an Invoice.
              <br/><br/>
              Enter the Deposit% required for these terms. This will effect your Low
              Deposit Reports.
              <br/><br/>
              Tag the Finance Option if these Jobs will be financed.
            </label>
          </template>
        </portlet-content>
      </div>
    </div>
    <div class="row pt-2">
      <div class="col-12 mt-4">
          <portlet-content isform="true" :onlybody="true">
              <div slot="body" class="menu-bar d-flex justify-content-between">
                  <div class="mt-1">
                    <button type="button" class="btn action-buttons" @click="showModal('SearchTerms')">Search</button>
                    <button type="button" class="btn action-buttons" v-if="!isEditMode" @click="enableEditMode">Edit</button>
                    <button type="button" class="btn action-buttons" v-if="isEditMode" @click="saveStoreData">Save</button>
                    <button type="button" class="btn action-buttons" v-if="isEditMode" @click="cancelEditMode">Cancel</button>
                    <button type="button" class="btn action-buttons" >Add</button>
                    <button type="button" class="btn action-buttons" >Delete</button>
                  </div>
                  <span class="background-black text-truncate mr-3 my-1">
                    Quote & Invoice Terms
                  </span>
              </div>
          </portlet-content>
      </div>
    </div>
    <search-terms
      v-if="mountSearchTerms"
      @close="hideModal('SearchTerms')"
    />
  </div>
</template>

<script>

import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import SearchTerms from './components/SearchTerms';
import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins/index'

export default {
  name: 'Terms',
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    PortletContent,
    SearchTerms,
  },
  data: () => ({
    isEditMode: false,
    mountSearchTerms: false,
  }),
  methods: {
    showModal(type) {
      if (type) {
        this[`mount${type}`] = true;
      }
    },
    hideModal(type) {
      if (type) {
        this[`mount${type}`] = false;
      }
    },
    enableEditMode() {},
    saveStoreData() {},
    cancelEditMode() {},
  }
}
</script>
