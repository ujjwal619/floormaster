<template>

</template>

<script>
  import PortletContent from '../../../../common/components/Portlets/Content/PortletContent'
  import Form from '../../../../common/utitlities/Form'

  export default {
    name: "permission-form",
    data() {
      return {
        form: new Form(),
        loaded: true,
        formSubmitting: true,
        values: {
          name: '',
          title: ''
        }
      }
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
      permission: {
        required: false
      }
    },
    watch: {
      'values.name': function() {
        this.values.title = this.slugify(this.values.name);
      }
    },
    components: {
      PortletContent
    },
    mounted() {
      if (this.method === 'put') {
        this.loadPermission();
      }
    },
    methods: {
      submit() {
        this.form = new Form(this.values);
        this.form.onSubmit(this.method, this.url)
          .then(response => {
            this.$toastr('success', this.form.alertMessage, 'Success!!');
            window.location.href = this.redirecturl ? this.redirecturl : this.url;
          })
          .catch(errors => {
            this.$toastr('error', this.form.alertMessage, 'Error!!');
          });
      },
      slugify(text) {
        return text.toString().toLowerCase()
          .replace(/\s+/g, '-')
          .replace(/[^\w\-]+/g, '')
          .replace(/\-\-+/g, '-')
          .replace(/^-+/, '')
          .replace(/-+$/, '');
      },
      loadPermission() {
        this.values = JSON.parse(this.permission);
      }
    }
  }
</script>
