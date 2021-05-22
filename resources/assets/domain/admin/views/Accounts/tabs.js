export const TABS = [
  {id: 1, name: 'Assets'},
  {id: 2, name: 'Liabilities'},
  {id: 3, name: 'Equity'},
  {id: 4, name: 'Income'},
  {id: 5, name: 'OtherIncome'},
  {id: 6, name: 'CostOfSales'},
  {id: 7, name: 'Expenses'},
  {id: 8, name: 'OtherExpenses'},
];

export function findTab(id) {
  return TABS.find(tab => tab.id === id);
}
