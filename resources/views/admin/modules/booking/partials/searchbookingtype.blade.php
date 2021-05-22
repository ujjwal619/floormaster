<modal :title="searchModalAction" :is-large="false" v-if="modals.searchBookingType.show"
       @close="modals.searchBookingType.show=false">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="form-group col-lg-12">
        <div class="row">
          <div class="col-lg-9">
            <drop-down
              :options="customBookingTypes"
              v-model="modals.searchBookingType.values.booking_type_id"
              placeholder="Select Booking Type"
              :default-selected="selectedBookingType"
            />
          </div>
        </div>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="modals.searchBookingType.show=false">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="searchBookingType"
    >Proceed
    </button>
  </template>
</modal>
