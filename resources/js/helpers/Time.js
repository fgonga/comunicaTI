import dayjs from 'dayjs';

export const Time = {
  get(element) {
    return this[element]();
  },

  today() {
    const hoje = dayjs().format('YYYY-MM-DD');
    return {
      de: hoje,
      ate: hoje,
    };
  },
  this_week() {
    const primeiro = dayjs().day(1);
    const ultimo = primeiro.add(6, 'day');
    return {
      de: primeiro.format('YYYY-MM-DD'),
      ate: ultimo.format('YYYY-MM-DD'),
    };
  },
  this_month() {
    const primeiro = dayjs().startOf('month');
    const ultimo = dayjs().endOf('month');
    return {
      de: primeiro.format('YYYY-MM-DD'),
      ate: ultimo.format('YYYY-MM-DD'),
    };
  },
  this_year() {
    const primeiro = dayjs().startOf('year');
    const ultimo = dayjs().endOf('year');
    return {
      de: primeiro.format('YYYY-MM-DD'),
      ate: ultimo.format('YYYY-MM-DD'),
    };
  },
  custom() {
    return {
      de: null,
      ate: null,
    };
  },
  sem_filtro() {
    return {
      de: null,
      ate: null,
    };
  },
};
