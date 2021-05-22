<template></template>

<script>
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import Form from "../../../common/utitlities/Form";

export default {
  name: "job-source-form",
  data() {
    return {
      form: new Form(),
      loaded: true,
      formSubmitting: true,
      values: {
        name: "",
        title: ""
      }
    };
  },
  props: {
    url: {
      required: true
    },
    method: {
      required: true,
      type: String
    },
    redirecturl: {
      required: false,
      type: String
    },
    jobsource: {
      required: false
    }
  },
  watch: {
    "values.title": function() {
      this.values.name = this.slugify(this.values.title);
    }
  },
  components: {
    PortletContent
  },
  mounted() {
    if (this.method === "put") {
      this.loadJobSource();
    }
  },
  methods: {
    submit() {
      this.form = new Form(this.values);
      this.form
        .onSubmit(this.method, this.url)
        .then(response => {
          this.$toastr("success", this.form.alertMessage, "Success!!");
          window.location.href = this.redirecturl ? this.redirecturl : this.url;
        })
        .catch(errors => {
          this.$toastr("error", this.form.alertMessage, "Error!!");
        });
    },
    slugify(text) {
      return text
        .toString()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
    },
    loadJobSource() {
      this.values = JSON.parse(this.jobsource);
    }
  }
};
</script>
