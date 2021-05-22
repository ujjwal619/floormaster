import FilterType from './FilterType.vue';

export default {
  components: {
    FilterType,
  },
  props: {
    filter: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    operator: '',
    value: '',
  }),
  watch: {
    operator(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.emitUpdate();
      }
    },
    value(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.emitUpdate();
      }
    },
  },
  created() {
    this.operator = this.filter.operator || 'equals';
    this.value = this.filter.value || null;
  },
  methods: {
    emitUpdate() {
      if (this.operator) {
        this.$emit('update', {
          operator: this.operator,
          value: this.value,
        });
      }
    },
  },
};
