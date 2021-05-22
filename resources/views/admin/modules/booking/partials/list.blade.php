<div class="form-container">
    <div class="col-xsmall-12 col-small-12">
        <div class="col-12 row">
			<span class="col-lg-1 text-right h4">Store:</span>
			<drop-down
							class="col-3"
							:options="alteredSites"
							v-model="selectedSite"
							style="max-height: 40px;"
							:default-selected="sites[0]"
			/>
		</div>
        <div class="row">
            <div class="col-10"></div>
            <div class="col-2">
                <span class="text-right h4" style="color: yellow">@{{ currentDate }}</span>
            </div>
        </div>
        <div class="row pt-2">
          <h3 class="col-2" style="color: yellow">@{{ selectedBookingTypeName }}</h3>
          <button type="button"
                  @click="showSearchBookingModal($options.BOOKING_TYPE_OPTIONS.SET)"
                  class="btn col-1"
          >Set
          </button>
          <span class="col-3" style="color: yellow;">
              Only Bookings of the type displayed at left will be shown on the screen.
          </span>
        </div>

        <div class="table-wrap">
            <portlet-content :onlybody="true" :height="460">
                <template slot="body">
                    <div class="col-xsmall-12" style="max-height: 450px;overflow-y: scroll;">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td style="width: 8%">TYPE</td>
                                <td style="width: 8%">ETA</td>
                                <td style="width: 8%">CLIENT</td>
                                <td style="width: 8%">JOB</td>
                                <td style="width: 8%">LOCATION</td>
                                <td style="width: 8%">PHONE</td>
                                <template v-if="!!selectedBookingTypeId">
                                    <td  style="width: 3%"
                                        v-for="(numeric_column_heading, index) in JSON.parse(selectedBookingType.numeric_column_headings)"
                                        :key="index"
                                    >
                                        @{{ numeric_column_heading || '&nbsp;' }}
                                    </td>
                                </template>
                                <template v-else>
                                    <td style="width: 3%">#1</td>
                                    <td style="width: 3%">#2</td>
                                    <td style="width: 3%">#3</td>
                                    <td style="width: 3%">#4</td>
                                </template>
                                <td style="width: 3%">@{{ selectedBookingType.text_column_heading }}</td>
                                <td style="width: 8%">ETOS</td>
                                <td style="width: 8%">FOR</td>
                                <td style="width: 15%">Note</td>
                                <td style="width: 10%">Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="booking in bookings" :key="booking.id">
                                <td style="width: 8%">@{{ booking.booking_type_name }}</td>
                                <td style="width: 8%">@{{ booking.estimated_time_of_arrival }}</td>
                                <td style="width: 8%">@{{ booking.customer }}</td>
                                <td style="width: 8%">@{{ booking.job_id }}</td>
                                <td style="width: 8%">@{{ booking.location }}</td>
                                <td style="width: 8%">@{{ booking.phone }}</td>
                                <td 
                                    style="width: 3%" 
                                    v-for="(numeric_column_heading, index) in getNumericColumnBooking(booking)"
                                    :key="index"
                                >@{{ numeric_column_heading }}</td>
                                <td style="width: 3%">@{{ booking.text_column_heading }}</td>
                                <td style="width: 8%">@{{ booking.estimated_time_on_site }}</td>
                                <td style="width: 8%">@{{ booking.for }}</td>
                                <td style="width: 15%">@{{ booking.note }}</td>
                                <td style="width: 10%">
                                    <button 
                                        v-if="hasPermission('bookings.edit') && isUsersSite"
                                        type="button" 
                                        @click="showEditBookingModal(booking)" 
                                        class="btn"
                                    >
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button 
                                        v-if="hasPermission('bookings.edit') && isUsersSite"
                                        type="button" 
                                        @click="deleteBooking(booking.id)" 
                                        class="btn"
                                    >
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 8%">&nbsp;</td>
                                <td style="width: 8%">&nbsp;</td>
                                <td style="width: 8%">&nbsp;</td>
                                <td style="width: 8%">&nbsp;</td>
                                <td style="width: 8%">&nbsp;</td>
                                <td style="width: 8%">Total</td>
                                <td style="width: 3%">@{{ bookingTotal(0) }}</td>
                                <td style="width: 3%">@{{ bookingTotal(1) }}</td>
                                <td style="width: 3%">@{{ bookingTotal(2) }}</td>
                                <td style="width: 3%">@{{ bookingTotal(3) }}</td>
                                <td style="width: 3%">@{{ bookingTotal(4) }}</td>
                                <td style="width: 8%">&nbsp;</td>
                                <td style="width: 8%">&nbsp;</td>
                                <td style="width: 15%">&nbsp;</td>
                                <td style="width: 10%">&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
            </portlet-content>
        </div>
    </div>

    <div class="col-xsmall-12 col-small-12">
        <portlet-content isform="true" :onlybody="true">
            <template slot="body">
                <button 
                    v-if="hasPermission('bookings.add') && isUsersSite"
                    type="button" 
                    @click="openAddBookingModal" 
                    class="btn action-buttons"
                >Add Booking</button>
                <button 
                    v-if="hasPermission('bookings.add') && isUsersSite"
                    type="button" 
                    @click="modals.newBookingType.show=true" 
                    class="btn action-buttons"
                >Add Booking Type</button>
                <button
                    v-if="hasPermission('bookings.edit') && isUsersSite" 
                    type="button" 
                    @click="showSearchBookingModal($options.BOOKING_TYPE_OPTIONS.UPDATE)" 
                    class="btn action-buttons"
                >Update Booking Type</button>
            </template>
        </portlet-content>
    </div>

    @include('admin.modules.booking.partials.addbooking')
    @include('admin.modules.booking.partials.addbookingtype')
    @include('admin.modules.booking.partials.searchbookingtype')
</div>
