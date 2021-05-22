export const EFT = 1;
export const CHEQUE = 2;

export function viewPaymentType(type) {
    return type === EFT ? 'EFT' : 'Cheque';
}
