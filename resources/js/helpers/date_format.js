export function formatDateStandard(date) {
  var newDate = new Date(date).toLocaleString();
  var res =  (newDate).replace(',','');
  return res;
}

export function formatDateStandardDateOnly(date) {
  var newDate = new Date(date).toLocaleString();
  var res = newDate.split(',')[0];
  return res;
}

export function isTwoFourHrLater(date) {
  var twoFourHrLater = date >= new Date().toISOString().substr(0, 10) && date <= new Date(new Date().getTime() + 60 * 60 * 24 * 1000).toISOString().substr(0, 10);
  return twoFourHrLater;
}