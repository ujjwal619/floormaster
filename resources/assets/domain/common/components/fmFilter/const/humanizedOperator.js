import * as OPERATOR from './operators';

export const DEFAULT_FILTER_TEXT = ({ operator, value }) => `${operator} ${value}`;

export const IS = {
  id: OPERATOR.EQUALS,
  value: 'is',
};

export const IS_NOT = {
  id: OPERATOR.NOT_EQUALS,
  value: 'is not',
};

export const STARTS_WITH = {
  id: OPERATOR.STARTS_WITH,
  value: 'starts with',
};

export const ENDS_WITH = {
  id: OPERATOR.ENDS_WITH,
  value: 'ends with',
};

export const CONTAINS = {
  id: OPERATOR.CONTAINS,
  value: 'contains',
};

export const NOT_CONTAINS = {
  id: OPERATOR.NOT_CONTAINS,
  value: 'does not contain',
};

export const GREATER_THAN = {
  id: OPERATOR.GREATER_THAN,
  value: 'is greater than',
};

export const LESS_THAN = {
  id: OPERATOR.LESS_THAN,
  value: 'is less than',
};

export const TODAY = {
  id: OPERATOR.TODAY,
  value: 'is today',
  message: ({ operator }) => `${operator}`,
};

export const YESTERDAY = {
  id: OPERATOR.YESTERDAY,
  value: 'is yesterday',
  message: ({ operator }) => `${operator}`,
};

export const LAST_7_DAYS = {
  id: OPERATOR.LAST_7_DAYS,
  value: 'is last 7 days',
  message: ({ operator }) => `${operator}`,
};

export const LAST_30_DAYS = {
  id: OPERATOR.LAST_30_DAYS,
  value: 'is last 30 days',
  message: ({ operator }) => `${operator}`,
};

export const CURRENT_MONTH = {
  id: OPERATOR.CURRENT_MONTH,
  value: 'is current month',
  message: ({ operator }) => `${operator}`,
};

export const LAST_MONTH = {
  id: OPERATOR.LAST_MONTH,
  value: 'is last month',
  message: ({ operator }) => `${operator}`,
};

export const CUSTOM = {
  id: OPERATOR.CUSTOM,
  value: 'is custom',
  message: ({ value }) => `is from ${value}`,
};

export const UNKNOWN = {
  id: OPERATOR.UNKNOWN,
  value: 'is not known',
};

export default [
  IS,
  IS_NOT,
  STARTS_WITH,
  ENDS_WITH,
  CONTAINS,
  NOT_CONTAINS,
  GREATER_THAN,
  LESS_THAN,
  TODAY,
  YESTERDAY,
  LAST_7_DAYS,
  LAST_30_DAYS,
  CURRENT_MONTH,
  LAST_MONTH,
  CUSTOM,
  UNKNOWN,
];
