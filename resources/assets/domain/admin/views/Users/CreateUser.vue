<template>

</template>

<script>
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import Form from "../../../common/utitlities/Form";

export default {
  name: "create-user",
  data() {
    return {
      form: new Form(),
      loaded: true,
      formSubmitting: true,
      values: {
        role: "",
        full_name: {}
      }
    };
  },
  props: {
    url: {
      required: true
    },
    method: {
      type: String,
      default: "post"
    },
    user: {
      required: false
    }
  },
  components: {
    PortletContent
  },
  methods: {
    submit() {
      this.form = new Form(this.values);
      this.form
        .onSubmit(this.method, this.url)
        .then(response => {
          this.$toastr("success", this.form.alertMessage, "Success!!");
          window.location.href = this.url;
        })
        .catch(errors => {
          this.$toastr("error", this.form.alertMessage, "Error!!");
        });
    }
  },
  mounted() {
    if (this.method === "patch") {
      this.values = JSON.parse(this.user);
    }
  }
};
</script>

<style scoped>
</style>