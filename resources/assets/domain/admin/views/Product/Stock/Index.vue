<template>
</template>
<script type="text/ecmascript-6">
  import Modal          from "../../../../common/components/Modal/Modal"
  import PortletContent from "../../../../common/components/Portlets/Content/PortletContent"
  import Form           from "../../../../common/utitlities/Form"

  export default {
    name: "stocks",
    props: {
      url: { type: String, required: true}
    },
    data() {
      return {
        values: {},
        form: new Form(),
        modals: {
          addStock: {
            show: false,
          },
        },
      }
    },
    components: {
      PortletContent,
      Modal,
    },
    methods: {
      updateStock() {

        this.form = new Form(this.values);

        $("html, body").animate({scrollTop: 0}, "slow");
        this.form.onSubmit('post', this.url)
        .then(response => {
          this.$toastr('success', this.form.alertMessage, 'Success!!');
          location.reload();
        })
        .catch(errors => {
          this.$toastr('error', this.form.alertMessage, 'Error!!');
        });
      },
    },
  }

</script>
