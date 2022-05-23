import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import BootstrapVue from 'bootstrap-vue'
import VueSweetalert2 from 'vue-sweetalert2'
import VueTelInput from 'vue-tel-input';
import '~/plugins'
import '~/components'
import VueAxios from 'vue-axios';
import Vuelidate from 'vuelidate';
import axios from 'axios';
import money from 'v-money';
import Chartkick from 'vue-chartkick';
import Chart from 'chart.js';
import VCalendar from 'v-calendar';
import filters from '~/helpers/filters';
Vue.config.productionTip = false;
const options = {
  confirmButtonColor: '#1c84c6',
  reverseButtons: true,
  confirmButtonText: 'Confirmar',
  cancelButtonText: 'Não',
};
/* eslint-disable no-new */
import VueChartkick from 'vue-chartkick'




Vue.use(VueTelInput)
Vue.use(VueSweetalert2, options);
Vue.use(VueTelInput);
// Requisições http
Vue.use(VueAxios, axios);
// Filtros no front end
Vue.use(filters);
// Input com dinheiro
Vue.use(money, {
  decimal: ',',
  thousands: '.',
  prefix: '',
  suffix: ' AOA',
  precision: 2,
  masked: true,
});
// Pacote com components boostra usando vue
Vue.use(BootstrapVue, {
  BTable: {
    emptyText: 'Não há registos para mostrar.',
    emptyFilteredText: 'Não há registos que correspondam à sua pesquisa.',
    showEmpty: true,
  },
});

// Validações dos imputs

// graficos
Vue.use(Chartkick.use(Chart));
Vue.use(VCalendar);

Vue.use(BootstrapVue)
Vue.use(VueSweetalert2)
Vue.config.productionTip = false


Vue.use(VueChartkick)
new Vue({
  i18n,
  store,
  router,
  ...App
})
