<template></template>

<script type="text/ecmascript-6">
export default {
  name: "AlertNotification",
  props: ["errorsNotification", "flash"],
  created() {
    if (!(this.flash === "")) {
      let flash = JSON.parse(this.flash)[0];
      this.$toastr(flash.level, flash.message, flash.level.toUpperCase());
    }
    let errors = JSON.parse(this.errorsNotification);
    let errorsCount = Object.getOwnPropertyNames(errors).length - 1;
    if (errorsCount > 0) {
      this.$toastr("error", "Your form has errors. Please fix it.", "Error!!");
    }
  }
};
</script>

<style scoped>
</style>
