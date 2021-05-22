<template>

</template>

<script>
  import {BookingMixin, LoadingMixin, CurrentUserMixin} from "../../../common/mixins/index"
  import axios from 'axios';
  import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
  import Modal from '../../../common/components/Modal/Modal'
  import DropDown from '../../../common/components/DropDown/DropDown'
  import Form from '../../../common/utitlities/Form';
  import { 
    getSites, 
    getBookings, 
    isMySite, 
    getBookingTypes
  } from '../../api/calls'

  const BOOKING_TYPE_OPTIONS = {
    SET: 'set_booking_type',
    UPDATE: 'update_booking_type',
  };

  export default {
    name: "Bookings",
    mixins: [BookingMixin, LoadingMixin, CurrentUserMixin],
    components: {
      PortletContent,
      Modal,
      DropDown
    },
    data() {
      return {
        currentDate: moment().format('dddd D MMMM YYYY'),
        modals: {
          // newBooking: {
          //   isEdit: false,
          //   values: {
          //     numeric_column_headings: []
          //   }
          // },
          newBookingType: {
            show: false,
            isEdit: false,
            values: {
              numeric_column_headings: ['', '', '', '']
            }
          },
          searchBookingType: {
            show: false,
            afterAction: BOOKING_TYPE_OPTIONS.SET,
            values: {}
          },
          values: {},
        },
        form: new Form(),
        sites: [],
        alteredSites: [
          {
            id: 0,
            name: 'All Stores',
          }
        ],
        selectedSite: '',
        bookings: [],
        bookingTypes: [],
        isUsersSite: false,
      };
    },
    BOOKING_TYPE_OPTIONS,
    computed: {
      selectedBookingTypeId() {
        return this.modals.searchBookingType.values.booking_type_id;
      },
      selectedBookingType() {
        return this.bookingTypes.find(type => type.id === this.selectedBookingTypeId) || {};
      },
      selectedBookingTypeName() {
        return this.selectedBookingType.name || 'All Bookings';
      },
      customBookingTypes() {
        const allBookingTypes = {
          id: 0,
          name: 'All Booking Types',
        }

        const bookingTypes = [];
        bookingTypes.push(allBookingTypes);
        return [ ...bookingTypes, ...this.bookingTypes];
      },
      searchModalAction() {
        return this.modals.searchBookingType.afterAction === BOOKING_TYPE_OPTIONS.SET ? 'Set Booking Type' : 'Select Booking Type For Edit';
      },
      bookingTypeModalAction() {
        return this.modals.newBookingType.isEdit ? 'Update Booking Type' : 'Add new Booking Type';
      },
      redirecturl() {
        const id = this.selectedBookingType.id;
        return id ? `/bookings?booking_type=${this.selectedBookingType.id}` : '/bookings';
      },
      selectedSiteData() {
          return this.sites.find(site => site.id === this.selectedSite);
        },
    },
    watch: {
      selectedSite: {
        handler(id) {
          if (this.modals.searchBookingType.values.booking_type_id) {
            this.modals.searchBookingType.values.booking_type_id = undefined;  
          }
          this.isThisMySite(id);
          this.fetchBookings(id, this.selectedBookingTypeId);
          this.fetchBookingTypes(id);
        }
      }
    },
    created() {
      this.fetchSites();
    },
    methods: {
      isThisMySite(siteId) {
        isMySite(siteId)
          .then(({ data }) => {
            this.isUsersSite = data.data.is_my_site;
          })
          .catch(() => {
            console.log('could not fetch accounts.');
          })
      },
      bookingTotal(column = 0) {
        return this.bookings.reduce((sum, booking) => {
          if (column == 4) {
            return sum + Number(booking.text_column_heading);
          }
          const numericColumns = this.getNumericColumnBooking(booking);
          return sum + Number(numericColumns[column]);
        }, 0); 
      },
      getNumericColumnBooking(booking) {
        const heading = JSON.parse(booking.numeric_column_headings);
        if (Array.isArray(heading)) {
          return heading;
        }
        return ['', '', '', ''];
      },
      closeBookingTypeModal () {
        this.modals.newBookingType.show=false;
        this.modals.newBookingType.isEdit=false;
        this.modals.newBookingType.values={
          numeric_column_headings: ['', '', '', '']
        };
      },
      openAddBookingModal() {
        this.modals.newBooking.values.site_id = this.selectedSite;
        this.modals.newBooking.show=true;
      },
      saveBookingType() {
        this.modals.newBookingType.values.site_id = this.selectedSite;
        this.form = new Form(this.modals.newBookingType.values);
        const method = this.modals.newBookingType.isEdit ? 'put' : 'post';
        const url = this.modals.newBookingType.isEdit ? `/booking-types/${this.modals.newBookingType.values.id}` : '/booking-types';
        this.form.onSubmit(method, url)
          .then(() => {
            this.$toastr('success', this.form.alertMessage, 'Success!!');
            // window.location.href = this.getBookingUrl();
          })
          .catch(() => {
            this.$toastr('error', this.form.alertMessage, 'Error!!')
          })
      },
      showEditBookingModal(booking) {
        this.modals.newBooking.values = {
          id: booking.id,
          site_id: booking.site_id,
          booking_type_id: booking.booking_type_id,
          date: booking.date,
          job_id: booking.job_id,
          customer: booking.customer,
          location: booking.location,
          phone: booking.phone,
          note: booking.note,
          for: booking.for,
          estimated_time_of_arrival: booking.estimated_time_of_arrival,
          estimated_time_on_site: booking.estimated_time_on_site,
          numeric_column_headings: this.getNumericColumnBooking(booking),
          text_column_heading: booking.text_column_heading,
          related_job_id: booking.related_job_id,
          related_quote_id: booking.related_quote_id,
        };
        this.modals.newBooking.isEdit = true
        this.modals.newBooking.show = true
      },
      showSearchBookingModal(action) {
        this.modals.searchBookingType.afterAction = action;
        this.modals.searchBookingType.show = true
      },
      searchBookingType() {
        this.modals.searchBookingType.show = false;
        if (
          this.modals.searchBookingType.afterAction === BOOKING_TYPE_OPTIONS.SET
        ) {
          this.fetchBookings(this.selectedSite, this.selectedBookingTypeId);
        }
        if (this.modals.searchBookingType.afterAction === BOOKING_TYPE_OPTIONS.UPDATE) {
          this.showBookingTypeModal();
        }
      },
      showBookingTypeModal() {
        console.log('here');
        const bookingTypeId = this.selectedBookingTypeId;
        if (bookingTypeId) {
          const bookingType = this.getBookingTypeById(bookingTypeId);
          console.log(bookingType);
          this.modals.newBookingType.isEdit = true;
          this.modals.newBookingType.values = {
            id: bookingType.id,
            name: bookingType.name,
            default_day_limit: bookingType.default_day_limit,
            numeric_column_headings:  Array.isArray(bookingType.numeric_column_headings) ? 
              bookingType.numeric_column_headings : 
              JSON.parse(bookingType.numeric_column_headings),
            text_column_heading: bookingType.text_column_heading,
          };
        }
        this.modals.newBookingType.show = true;
      },
      deleteBooking(id) {
        const isConfirmed = window.confirm('Are you sure?')
        if (isConfirmed) {
          axios.delete(`/bookings/${id}`)
            .then(() => {
              this.$toastr('success', 'Successfully Deleted Booking', 'Success!!');
              // window.location.href = this.getBookingUrl()
              this.fetchBookings(this.selectedSite, this.selectedBookingTypeId);
            })
            .catch(() => {
              this.$toastr('error', this.form.alertMessage, 'Error!!')
            })
        }
      },
      removeBookingType() {
        const id = this.modals.newBookingType.values.id;
        const isConfirmed = window.confirm('Are you sure?')
        if (isConfirmed) {
          axios.delete(`/booking-types/${id}`)
            .then(() => {
              this.$toastr('success', 'Successfully Deleted Booking Type', 'Success!!');
              window.location.href = '/bookings';
            })
            .catch(() => {
              this.$toastr('error', 'Could not delete booking type.', 'Error!!')
            })
        }
      },
      fetchSites() {
        this.enableLoading();
        getSites({for: 'share-site'}).then(({ data }) => {
          this.sites = data.data;
          this.alteredSites = [...this.alteredSites, ...data.data];
        })
        .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
        .finally(this.disableLoading);
      },
      fetchBookings(siteId, bookingTypeId) {
        getBookings({
          site_id: siteId, 
          booking_type_id: bookingTypeId
        }).then(({ data }) => {
          this.bookings = data.data;
          
        })
        .catch(err => this.$toastr("error", "Could not get bookings.", "Error!!"))
      },
      fetchBookingTypes(siteId) {
        getBookingTypes({
          site_id: siteId, 
        }).then(({ data }) => {
          this.bookingTypes = data.data;
          
        })
        .catch(err => this.$toastr("error", "Could not get booking types.", "Error!!"))
      },
      handleAddBookingModalClose() {
        console.log('colse add');
        this.modals.newBooking = {
            isEdit: false,
            show: false,
            values: {
              numeric_column_headings: []
            }
          };
      },
    },
  }
</script>
