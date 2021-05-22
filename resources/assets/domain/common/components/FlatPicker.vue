<script>
import Flatpickr from 'flatpickr';

const camelToKebab = string => string.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();

const arrayify = obj => (obj instanceof Array ? obj : [obj]);

const cloneObject = obj => Object.assign({}, obj);

// Events to emit, copied from flatpickr source
const includedEvents = [
  'onChange',
  'onClose',
  'onDestroy',
  'onMonthChange',
  'onOpen',
  'onYearChange',
];

// Let's not emit these events by default
const excludedEvents = [
  'onValueUpdate',
  'onDayCreate',
  'onParseConfig',
  'onReady',
  'onPreCalendarPosition',
  'onKeyDown',
];

// Keep a copy of all events for later use
const allEvents = includedEvents.concat(excludedEvents);
// Passing these properties in `set()` method will cause flatpickr to trigger some callbacks
const configCallbacks = ['locale', 'showMonths'];

export default {
  name: 'Flatpicker',
  render() {
    return this.$scopedSlots.default({ fp: this });
  },
  props: {
    value: {
      default: null,
      required: false,
      validator(value) {
        return value === null || value instanceof Date || typeof value === 'string' || value instanceof String || value instanceof Array || typeof value === 'number';
      },
    },
    // https://chmln.github.io/flatpickr/options/
    config: {
      type: Object,
      default: () => ({
        wrap: false,
        defaultDate: null,
      }),
    },
    events: {
      type: Array,
      default: () => includedEvents,
    },
  },
  data() {
    return {
      fp: null,
    };
  },
  mounted() {
    if (this.fp) return;
    const safeConfig = cloneObject(this.config);
    this.events.forEach((hook) => {
      safeConfig[hook] = arrayify(safeConfig[hook] || []).concat((...args) => {
        this.$emit(camelToKebab(hook), ...args);
      });
    });
    safeConfig.defaultDate = this.value || safeConfig.defaultDate;
    this.fp = new Flatpickr(this.getElem(), safeConfig);
    this.fpInput().addEventListener('blur', this.onBlur);
  },
  methods: {
    getElem() {
      return this.config.wrap ? this.$el.parentNode : this.$el;
    },
    onInput(event) {
      this.$nextTick(() => {
        this.$emit('input', event.target.value);
      });
    },
    fpInput() {
      return this.fp.altInput || this.fp.input;
    },
    onBlur(event) {
      this.$emit('blur', event.target.value);
    },
  },
  watch: {
    config: {
      deep: true,
      handler(newConfig) {
        const safeConfig = cloneObject(newConfig);
        allEvents.forEach((hook) => {
          delete safeConfig[hook];
        });
        this.fp.set(safeConfig);

        configCallbacks.forEach((name) => {
          if (typeof safeConfig[name] !== 'undefined') {
            this.fp.set(name, safeConfig[name]);
          }
        });
      },
    },
    value(newValue) {
      if (newValue === this.$el.value) return;
      this.fp &&
      this.fp.setDate(newValue, true);
    },
  },
  beforeDestroy() {
    if (this.fp) {
      this.fpInput().removeEventListener('blur', this.onBlur);
      this.fp.destroy();
      this.fp = null;
    }
  },
};
</script>
