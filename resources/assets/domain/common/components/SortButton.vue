<template functional>
  <button
    v-if="props.sort"
    type="button"
    class="transparent-button paddingNone"
    v-on="listeners"
  >
    <i class="fa" :class="`fa-${$options.methods.sortIcon(props.sort)}`"></i>
    <!-- <component
      :is="injections.components.AgIcon"
      :icon="$options.methods.sortIcon(props.sort)"
      class="ag-icon--white ag-icon--md"
    /> -->
  </button>
</template>

<script>
  const SORT_ORDERS = ['asc', 'dsc'];

  export default {
    name: 'SortButton',
    props: {
      sort: {
        type: String,
        default: '',
      },
    },
    inject: {
      components: {
        default: {
        //   AgIcon: () => import('script/components/functional/AgIcon'),
        },
      },
    },
    methods: {
      sortIcon(sort) {
        if (!sort) {
          return '';
        }
        let icon = 'sort';
        if (SORT_ORDERS.includes(sort)) {
          icon += sort === 'dsc' ? '-down' : '-up';
        }
        return icon;
      },
    },
  };
</script>

<style scoped>
  button {
    color: inherit;
  }
</style>
