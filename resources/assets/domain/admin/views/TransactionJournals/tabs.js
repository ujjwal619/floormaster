export const ALL = 7;
export const GENERAL = 1;
export const PURCHASES = 2;
export const INVENTORY = 3;
export const SALES = 4;
export const RECEIPTS = 5;
export const DISBURSEMENTS = 6;

export const TABS = [
  {id: ALL, name: 'All'},
  {id: GENERAL, name: 'General'},
  {id: PURCHASES, name: 'Purchases'},
  {id: INVENTORY, name: 'Inventory'},
  {id: SALES, name: 'Sales'},
  {id: RECEIPTS, name: 'Receipts'},
  {id: DISBURSEMENTS, name: 'Disbursements'},
];

export function findTab(id) {
  return TABS.find(tab => tab.id === id);
}
