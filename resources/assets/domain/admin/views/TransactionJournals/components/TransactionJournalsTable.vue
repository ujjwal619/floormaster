<template>
  <div class="col-xsmall-12">
    <table class="table table-bordered" style="max-height: 650px;overflow-y: scroll;">
      <tbody>
      <tr v-for="account in spacedAccounts" :key="account.id">
        <td style="width: 5%">
          <input type="checkbox" disabled>
        </td>
        <td style="width: 70%">
          <span v-html="getSpacing(account.space)"></span>
          <span @click="editAccount(account)">{{ account.code }} {{ account.name }}</span>
        </td>
        <td style="width: 12.5%">{{ account.opening_balance }}</td>
        <td style="width: 12.5%">
          <template v-if="account.type === 1">{{ account.header_balance }}</template>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    name: 'TransactionJournalsTable',
    props: {
      accounts: {
        type: Array,
        default: [],
      }
    },
    computed: {
      spacedAccounts() {
        let newArray = [];
        this.accounts.map(account => {
          if (!account.reports_to) {
            newArray.push({ ...account, space: 0, headerBalance: 0 });
          } else {
            const parentAcc = newArray.find(newAcc => newAcc.id === account.reports_to) || {};
            newArray.push({ ...account, space: (parentAcc.space + 1) });
          }
          return;
        });

        let totalsArray = [];

        const revArr = newArray.reverse().map((revEl, index, arr) => {
          if (!revEl.reports_to) {
            return revEl;
          }
          const parentAcc = arr.find(newAcc => newAcc.id === revEl.reports_to) || {};
          totalsArray[parentAcc.id] = totalsArray[parentAcc.id] ? totalsArray[parentAcc.id] : 0;
          if (revEl.type === 2) {
            totalsArray[parentAcc.id] += revEl.opening_balance;
          } else if(revEl.type === 1 && totalsArray[revEl.id]) {
            totalsArray[parentAcc.id] += totalsArray[revEl.id];
          }
          return revEl;
        });
        return newArray.map(arr => (totalsArray[arr.id] && arr.type === 1) ? { ...arr, header_balance: totalsArray[arr.id] }: arr).reverse();
      },
    },
    methods: {
      getSpacing(space) {
        let spaces = '';
        for (let i = 0; i < space; i++) {
          spaces += '&nbsp;&nbsp;';
        }
        return spaces;
      },
      editAccount(account) {
        this.$emit('edit', account);
      },
    },
  }
</script>
