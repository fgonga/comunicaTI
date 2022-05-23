import dinheiro from './dinheiro';
import { timeformat, humanize, mes } from './timeconvert';

export default {
  install(Vue) {
    Vue.filter('dinheiro', dinheiro);
    Vue.filter('timeformat', timeformat);
    Vue.filter('humanize', humanize);
    Vue.filter('mes', mes);
  },
};
