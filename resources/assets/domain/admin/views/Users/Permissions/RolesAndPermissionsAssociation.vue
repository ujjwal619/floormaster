<template></template>

<script type="text/ecmascript-6">
  export default {
    name: 'role-permission-association',
    data() {
      return {

      }
    },
    props: ['permissionbaseurl'],
    methods: {
      togglePermission(roleId, permissionId) {
        console.log(this.permissionbaseurl);
        let permissionToggleUrl = `${this.permissionbaseurl}/${permissionId}/role/${roleId}/toggle`;
        axios.get(permissionToggleUrl)
          .then(response => {
            this.$toastr('success', response.data.message, 'Success!!');
          })
          .catch(errors => {
            this.$toastr('error', 'Something went wrong.', 'Error!!');
          })
      }
    }
  }
</script>
