<template>
  <fm-table
    :columns="columns"
    :records="records"
  >
    <template v-for="column in columns" :slot="`th-${column.id}`">
      <template :name="`th-${column.id}`">
        {{ column.label }}
        <sort-button
          v-if="!!sortable[column.id]"
          :sort="sortable[column.id]"
          @click="emitSort(column.id)"
        />
      </template>
    </template>
    <template v-for="col in columns" :slot="col.id" slot-scope="scope">
      <slot :name="col.id" v-bind="{ ...scope }"></slot>
    </template>
  </fm-table>
</template>

<script>
  import FmTable from './Index.vue';
  import SortButton from '../SortButton';

  // sort
  // {
  //   sort: '' | 'asc' | 'dsc' | 'default',
  // }

  export default {
    name: 'SortableFmTable',
    components: {
      FmTable,
      SortButton,
    },
    props: {
      columns: {
        type: Array,
      },
      records: {
        type: Array,
      },
      sortable: {
        type: Object,
      },
    },
    methods: {
      emitSort(id) {
        const value = this.sortable[id] === 'asc' ? `-${id}` : `${id}`;
        const sortable = {};
        Object.keys(this.sortable).forEach((column) => {
          sortable[column] = 'default';
        });
        sortable[id] = this.sortable[id] === 'asc' ? 'dsc' : 'asc';
        this.$emit('sort', {
          sort: value,
          sortable,
        });
      },
    },
  };
</script>

<style scoped>
  button {
    color: inherit;
  }
</style>
