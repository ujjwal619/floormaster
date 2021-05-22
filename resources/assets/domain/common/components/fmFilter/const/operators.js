export const EQUALS = 'equals';
export const NOT_EQUALS = 'not_equals';

export const STARTS_WITH = 'starts_with';
export const ENDS_WITH = 'ends_with';

export const CONTAINS = 'contains';
export const NOT_CONTAINS = 'not_contains';

export const GREATER_THAN = 'greater_than';
export const LESS_THAN = 'less_than';

export const TODAY = 'today';
export const YESTERDAY = 'yesterday';
export const LAST_7_DAYS = 'last_7_days';
export const LAST_30_DAYS = 'last_30_days';
export const CURRENT_MONTH = 'current_month';
export const LAST_MONTH = 'last_month';
export const CUSTOM = 'custom';

export const UNKNOWN = 'unknown';

const operatorQueryAlias = new Map();
operatorQueryAlias.set(TODAY, EQUALS);
operatorQueryAlias.set(YESTERDAY, EQUALS);
operatorQueryAlias.set(LAST_7_DAYS, GREATER_THAN);
operatorQueryAlias.set(LAST_30_DAYS, GREATER_THAN);
operatorQueryAlias.set(CURRENT_MONTH, GREATER_THAN);
operatorQueryAlias.set(LAST_MONTH, GREATER_THAN);
operatorQueryAlias.set(CUSTOM, GREATER_THAN);
operatorQueryAlias.set(UNKNOWN, EQUALS);
export const OPERATOR_QUERY_ALIAS_MAP = operatorQueryAlias;
