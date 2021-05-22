import { formatViewDate, displayMoney } from '../../../common/utitlities/helpers';

export default {
    methods: {
        formatViewDate,
        displayMoney,
        emitJournalClick(journal) {
            this.$emit('edit', journal)
        }
    },
}
