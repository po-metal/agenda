import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

export function calculateEventDuraction(event) {
  if (event.start && event.end) {
    return moment(event.end).diff(moment(event.start), 'minutes');
  }
  return null;
}

export function  calculateEnd (start, duration) {
  var end = moment(start)
  end.add(duration, "minutes")
  return end.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD HH:mm")
}