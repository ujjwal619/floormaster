<template></template>

<script type="text/ecmascript-6">
  import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
  import Form from "../../../common/utitlities/Form";
  import EditButton from '../../../common/components/Buttons/EditButton'

  export default {
    name: 'profile',
    data() {
      return {
        loaded: true,
        form: new Form(),
      }
    },
    components: {
      PortletContent,
      EditButton,
    }
  }
</script>
