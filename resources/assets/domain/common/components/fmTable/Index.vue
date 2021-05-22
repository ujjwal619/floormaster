<template functional>
  <table class="ag-table">
    <thead>
    <tr>
      <th
        v-for="(column, thIndex) in props.columns"
        :key="column.id"
        :class="column.class || ''"
      >
        <slot :name="`th-${column.id}`" v-bind="{ ...column, thIndex }">
          {{ column.label || '' }}
        </slot>
      </th>
    </tr>
    </thead>
    <tbody>
    <template v-if="props.records.length">
      <tr v-for="(record, trIndex) in props.records" :key="Math.random()">
        <td v-for="(column, tdIndex) in props.columns" :key="`${column.id}_${record_id}`">
          <slot :name="column.id" v-bind="{ ...record, tdIndex, trIndex }"> </slot>
        </td>
      </tr>
    </template>
    <tr v-else class="text-center">
      <td :colspan="props.columns.length">
        <slot name="no-records"> No records found</slot>
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
  export default {
    name: 'FmTable',
    props: {
      columns: {
        type: Array,
        default: () => [],
      },
      records: {
        type: Array,
        default: () => [],
      },
    },
  };
</script>

<style scoped>
  .ag-table {
    background-color: #fff;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
  }

  .ag-table th {
    background-color: rgb(87, 192, 239);
    color: #fff;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
  }

  .ag-table tbody tr:hover {
    background-color: rgba(87, 192, 239, .03);
  }

  .ag-table th,
  .ag-table td {
    padding: 10px 8px 15px 6px;
  }

  .ag-table tr td {
    border-bottom: 1px solid #ebebeb;
    max-width: 55rem;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>
