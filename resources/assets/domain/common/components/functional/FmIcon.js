export default {
    name: 'fm-icon',
    functional: true,
    props: {
      icon: {
        type: String,
        required: true,
      },
    },
    render(createElement, context) {
      return createElement('svg', {
        class: [
          'ag-icon',
          context.data.staticClass,
        ],
        attrs: {
          'aria-hidden': true,
        },
      }, [
        createElement('use', {
          attrs: {
            'xlink:href': `#ag-icon-${context.props.icon}`,
          },
        }),
      ]);
    },
  };
  