import Form from '../utitlities/Form'
import Loading from '../components/Loader/Loading'
import { getMyProfile } from '../../admin/api/calls';

const BookingMixin = {
  data() {
    return {
      modals: {
        newBooking: {
          show: false,
          values: {
            booking_type_id: '',
            numeric_column_headings: ['', '', '', '']
          }
        }
      },
      bookingModalSelectedBookingType: {},
    };
  },
  watch: {
    'modals.newBooking.values.booking_type_id': {
      handler: function (bookingTypeId) {
        if (bookingTypeId) {
          this.bookingModalSelectedBookingType = this.getBookingTypeById(bookingTypeId);
          let bookingTypeNumericColumnHeadings = this.bookingModalSelectedBookingType.numeric_column_headings;
          let bookingTypeNumericColumnHeadingsNew = ['', '', '', ''];
          console.log(this.bookingModalSelectedBookingType)
          if(Array.isArray(bookingTypeNumericColumnHeadings)) {
            bookingTypeNumericColumnHeadingsNew = bookingTypeNumericColumnHeadings;
          } else {
            bookingTypeNumericColumnHeadingsNew = JSON.parse(bookingTypeNumericColumnHeadings);
          }
          this.bookingModalSelectedBookingType.numeric_column_headings = bookingTypeNumericColumnHeadingsNew;
        }
      }
    },
  },
  computed: {
    // bookingModalSelectedBookingType() {
    //   const bookingId = this.modals.newBooking.values.booking_type_id;
    //   if (!!bookingId) {
    //     const bookingType = this.getBookingTypeById(bookingId);
    //     bookingType.numeric_column_headings = bookingType.numeric_column_headings ? JSON.parse(bookingType.numeric_column_headings) : ['', '', '', ''];

    //     return bookingType;
    //   }
    //   return {};
    // },
  },
  methods: {
    handleAddBookingModalClose() {
      this.modals.newBooking.show = false;
      this.modals.newBooking.isEdit = false;
    },
    getBookingTypeById(id) {
      const bookingTypes = [...this.bookingTypes];
      const bookingType = bookingTypes.find(bookingType => bookingType.id === id) || {};
      return bookingType;
    },
    saveBooking() {
      const isOldEntry = this.modals.newBooking.isEdit;
      const method = isOldEntry ? 'put' : 'post';
      const url = isOldEntry ? `/bookings/${this.modals.newBooking.values.id}` : '/bookings'
      const msg = isOldEntry ? "update" : "create";
      this.validate().then(valid => {
        if (valid) {
          this.enableLoading();
          axios[method](url, this.modals.newBooking.values)
            .then(() => {
              this.$toastr('success', 'Booking Saved successfully', 'Success!!');
              window.location.href = this.redirecturl;
            })
            .catch(response => {
              console.log(response, this.form)
              this.$toastr('error', 'Could not save booking.', 'Error!!')
            })
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
  },
};
export { BookingMixin };


export const LoadingMixin = {
  components: {
    Loading,
  },
  data() {
    return {
      loading: false,
    };
  },
  methods: {
    enableLoading() {
      this.loading = true;
    },
    disableLoading() {
      this.loading = false;
    }
  }
}

export const CurrentUserMixin = {
  data() {
    return {
      currentUser: {
        permissions: [],
      },
      isSuperAdmin: false,
    }
  },
  computed: {
    currentUserPermissions() {
      return this.currentUser.permissions.map(permission => permission.name)
    },
  },
  created() {
    this.fetchMyProfile();
  },
  methods: {
    fetchMyProfile() {
      return getMyProfile()
        .then(({ data }) => {
          this.currentUser = data.data;
          this.isSuperAdmin = data.meta.is_super_admin;
        })
    },
    hasPermission(permission) {
      if (this.isSuperAdmin) {
        return true;
      }
      
      return this.currentUserPermissions.includes(permission);
    }
  },
}

export const refsMixin = {
  methods: {
    execCallback(cb, ...params) {
      if (cb && typeof cb === 'function') {
        cb(...params);
      }
    },
    __refAction(ref, action) {
      if (!this.$refs[ref]) {
        return Promise.reject(new Error(`Ref ${ref} could not be accessed`));
      }
      if (!action) {
        return Promise.reject(new Error(`Action ${action} could not be accessed`));
      }
      if (!this.$refs[ref][action]) {
        return Promise.reject(new Error(`Action ${action} could not be found on the ref ${ref}`));
      }
      if (typeof this.$refs[ref][action] !== 'function') {
        return Promise.reject(new Error(`Action ${action} is not a method of the ref ${ref}`));
      }
      return Promise.resolve(this.$refs[ref][action]());
    },
    refAction(ref, action, successHandler, errorHandler) {
      return this.__refAction(ref, action)
        .then((value) => {
          this.execCallback(successHandler, value);
        })
        .catch((err) => {
          this.execCallback(errorHandler, err);
        });
    },
    refsActions(refs, actions, successHandlers, errorHandlers) {
      if (refs && Array.isArray(refs) && actions) {
        const hasMultipleActions = Array.isArray(actions);
        const hasMultipleSuccessHandlers = Array.isArray(successHandlers);
        const hasMultipleErrorHandlers = Array.isArray(errorHandlers);
        refs.forEach((ref, index) => {
          const action = hasMultipleActions ? actions[index] : actions;
          this.__refAction(ref, action)
            .then((value) => {
              if (successHandlers) {
                const successHandler = hasMultipleSuccessHandlers ? successHandlers[index] : successHandlers;
                this.execCallback(successHandler, value);
              }
            })
            .catch((error) => {
              if (errorHandlers) {
                const errorHandler = hasMultipleErrorHandlers ? errorHandlers[index] : errorHandlers;
                this.execCallback(errorHandler, error);
              }
            });
        });
      }
    },
  },
};