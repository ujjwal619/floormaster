<modal :title="`${modals.newBooking.isEdit ? 'Update' : 'Add' } booking`" :is-large="false" v-if="modals.newBooking.show"
       @close="handleAddBookingModalClose">
  <template slot="modal-body">
    <div class="form-group row">
      <div class="col-lg-6">
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-4" style="text-align: right">Booking Type:</label>
            <div class="col-lg-8">
              <drop-down
                :options="bookingTypes"
                v-model="modals.newBooking.values.booking_type_id"
                placeholder="Booking Type"
                :default-selected="getBookingTypeById(modals.newBooking.values.booking_type_id)"
                name="booking type"
                v-validate="'required'"
              />
            </div>
          </div>
          <label class="error pt-2">@{{ errors.first('booking type') }}</label>
        </div>
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-4" style="text-align: right">Booking Date:</label>
            <input 
              class="col-lg-8 form-control" 
              type="date" 
              v-model="modals.newBooking.values.date"
              name="booking date"
              v-validate="'required'"
            >
            <label class="error pt-2">@{{ errors.first('booking date') }}</label>
          </div>
        </div>
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-4" style="text-align: right">Job Number:</label>
            <input class="col-lg-8 form-control" type="text" v-model="modals.newBooking.values.job_id">
          </div>
        </div>
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-4" style="text-align: right">Customer:</label>
            <input 
              class="col-lg-8 
              form-control" 
              type="text" 
              v-model="modals.newBooking.values.customer"
              name="customer"
              v-validate="'required'"
            />
            <label class="error pt-2">@{{ errors.first('customer') }}</label>
          </div>
        </div>
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-4" style="text-align: right">Location:</label>
            <input class="col-lg-8 form-control" type="text" v-model="modals.newBooking.values.location">
          </div>
        </div>
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-4" style="text-align: right">Phone:</label>
            <input class="col-lg-8 form-control" type="text" v-model="modals.newBooking.values.phone">
          </div>
        </div>
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-4" style="text-align: right">Notes:</label>
            <textarea class="col-lg-8"
                      v-model="modals.newBooking.values.note"
                      rows="1"
                      style="font-size: 12px;"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-7" style="text-align: right">Booking For (Person):</label>
            <input class="col-lg-5 form-control" style="background: #0c4c57" type="text" v-model="modals.newBooking.values.for">
          </div>
        </div>
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-7" style="text-align: right">Estimated Time of Arrival:</label>
            <input class="col-lg-5 form-control" type="time" v-model="modals.newBooking.values.estimated_time_of_arrival">
          </div>
        </div>
        <div class="form-group col-lg-12">
          <div class="row">
            <label class="col-lg-7" style="text-align: right">Estimated Time on Site (Hrs):</label>
            <input class="col-lg-5 form-control" type="number" v-model="modals.newBooking.values.estimated_time_on_site">
          </div>
        </div>
        <div 
          v-for="(numeric_column_heading, index) in bookingModalSelectedBookingType.numeric_column_headings"
          :key="index"
        >
          <div class="form-group col-lg-12">
            <div class="row">
              <label class="col-lg-7" style="text-align: right">@{{ numeric_column_heading }}:</label>
              <input class="col-lg-5 form-control" type="number" v-model="modals.newBooking.values.numeric_column_headings[index]">
            </div>
          </div>
        </div>
        <span class="form-error"
              v-if="form.errors.has('numeric_column_headings')"
              v-text="form.errors.get('numeric_column_headings')"></span>
        <div class="form-group col-lg-12" v-if="bookingModalSelectedBookingType">
          <div class="row">
            <label class="col-lg-7" style="text-align: right">@{{ bookingModalSelectedBookingType.text_column_heading }}:</label>
            <input class="col-lg-5 form-control" type="text" v-model="modals.newBooking.values.text_column_heading">
          </div>
        </div>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <a :href="`quotes/${modals.newBooking.values.related_quote_id}/edit`"
       v-if="modals.newBooking.values.related_quote_id"
       class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
    >Go To Quote
    </a>
    <a :href="`jobs/${modals.newBooking.values.related_job_id}/edit`"
            v-if="modals.newBooking.values.related_job_id"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
    >Go To Job
    </a>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="handleAddBookingModalClose">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="saveBooking"
            :disabled="loading"
    >Proceed
    </button>
  </template>
  <loading :loading="loading" />
</modal>
