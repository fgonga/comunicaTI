import dayjs from 'dayjs';

const duration = require('dayjs/plugin/duration');
const relativeTime = require('dayjs/plugin/relativeTime');
const locale_pt = require('dayjs/locale/pt');
const localizedFormat = require('dayjs/plugin/localizedFormat');

export function timeformat(value, format = 'DD-MM-YYYY') {
  return value ? dayjs(value).format(format) : '';
}

export function humanize(value) {
  dayjs.extend(relativeTime);
  dayjs.extend(duration);
  dayjs.locale('pt');
  return value ? dayjs().to(dayjs(value)) : '';
}

export function mes(dia = 1, mes, formato) {
  dayjs.locale('pt');
  dayjs.extend(localizedFormat);
  const ano = dayjs().format('YYYY');
  const data = `${ano}-${mes}-${dia}`;
  return dia ? dayjs(data).format(formato) : '';
}
