<template></template>

<script type="text/ecmascript-6">
  import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
  import Modal from '../../../common/components/Modal/Modal'
  import Form from "../../../common/utitlities/Form";
  import EditButton from '../../../common/components/Buttons/EditButton'
  import DeleteButton from '../../../common/components/Buttons/DeleteButton'

  export default {
    name: 'user-details',
    props: ['changepasswordurl'],
    data() {
      return {
        loaded: true,
        form: new Form(),
        modals: {
          changePassword: {
            show: false,
            disableSave: false,
            values: {
              password: '',
              password_confirmation: ''
            }
          }
        }
      }
    },
    components: {
      PortletContent,
      Modal,
      EditButton,
      DeleteButton,
    },
    methods: {
      /**
       * Changes the password.
       **/
      changePassword() {
        this.modals.changePassword.disableSave = true;
        this.form = new Form(this.modals.changePassword.values);
        this.form.onSubmit('patch', this.changepasswordurl)
          .then(response => {
            this.modals.changePassword.disableSave = false;
            this.modals.changePassword.show = false;
            this.$toastr('success', this.form.alertMessage, 'Success!!');
          })
          .catch(errors => {
            this.modals.changePassword.disableSave = false;
            this.$toastr('error', this.form.alertMessage, 'Error!!');
          });
      },
      /**
       * Hides modal along with resetting the form.
       **/
      showModal(modal) {
        this.modals[modal].show = true;
        this.modals[modal].values = {};
        this.form = new Form();
      },
      /**
       * Hides modal along with resetting the form.
       **/
      hideModal(modal) {
        this.modals[modal].show = false;
        this.modals[modal].values = {};
        this.form = new Form();
      },
    }
  }
</script>
