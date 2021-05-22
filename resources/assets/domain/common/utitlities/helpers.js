var hasOwnProperty = Object.prototype.hasOwnProperty;
import shortid from 'shortid';
import moment from 'moment';

export function uniqueKey() {
  const id = shortid.generate();
  if (shortid.isValid(id)) {
    return id;
  }
}

export function isEmpty(obj) {

  // null and undefined are "empty"
  if (obj == null) return true;

  // Assume if it has a length property with a non-zero value
  // that that property is correct.
  if (obj.length > 0)    return false;
  if (obj.length === 0)  return true;

  // If it isn't an object at this point
  // it is empty, but it can't be anything *but* empty
  // Is it empty?  Depends on your application.
  if (typeof obj !== "object") return true;

  // Otherwise, does it have any properties of its own?
  // Note that this doesn't handle
  // toString and valueOf enumeration bugs in IE < 9
  for (var key in obj) {
    if (hasOwnProperty.call(obj, key)) return false;
  }

  return true;
}

export function displayMoney(money) {
  return accounting.formatMoney(money);
}

export function displayNumber(number) {
  return accounting.formatMoney(number, "");
}



export function isObject(obj) {
  return (typeof obj === "object") && (obj !== null)
}

export function frontEndDateFormat(date) {
  return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
}

export function backEndDateFormat(date) {
  return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD');
}


export function formatDate(date = new Date()) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

export function formatViewDate(date) {
  if (!date) {
    return '';
  }
  moment.defaultFormat = 'DD MMM YYYY';
  return moment(date).format();
}

export function getFiscalYear(when='start', startMonth='July') {
  const newDate = moment();
  const date = moment().month(startMonth);
  var startDate = date.startOf('month');
  if (moment().diff(date) < 0) {
    startDate = startDate.subtract(12, 'month');
  }
  const copyStartDate = moment(startDate);
  const endDate = copyStartDate.add(11, 'month').endOf('month');

  return when == 'start' ? formatDate(startDate) : formatDate(endDate);
}

export function getViewFiscalYear() {
  return formatViewDate(getFiscalYear()) + ' - ' + formatViewDate(getFiscalYear('end'));
}

export function getFiscalYearDateRangeForValidation() {
  const startDate = getFiscalYear();
  const endDate = getFiscalYear('end');
  return [
    formatDate(moment(startDate).subtract(1, 'days')),
    formatDate(moment(endDate).add(1, 'days'))
  ];
}

export function getCurrentMonth(when = 'start') {
  return when == 'start' ? formatDate(moment().startOf('month')) : formatDate(moment().endOf('month'));
}

export function getMonthRangeForValidation() {
  const startDate = getCurrentMonth();
  const endDate = getCurrentMonth('end');
  return [
    formatDate(moment(startDate).subtract(1, 'days')),
    formatDate(moment(endDate).add(1, 'days'))
  ];
}

export function alteredTableData(tableData, count) {
  const data = [...tableData];
  for(let i = data.length; i<count; i++) {
    data.push({});
  }
  console.log(data);
  return data;
}

export function getFiscalMonths(fiscalYearDate = getFiscalYear(), firstMonth = 'July') {
  const months = [];

  for(var i=0; i<12; i++) {
    const currentMonthDate = moment(fiscalYearDate).month(firstMonth).add('months', i).startOf('month');
    const currentMonthName = currentMonthDate.format('MMMM');

    months.push({
      name: currentMonthName,
      id: currentMonthName,
      date: formatDate(currentMonthDate),
      type: 'monthly'
    })
  }

  return months;
}