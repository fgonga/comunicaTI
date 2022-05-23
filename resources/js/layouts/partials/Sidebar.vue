<template>
  <section class="app-sidebar">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item nav-category">{{$t('balance')}}</li>
        <li class="nav-item" v-on:click="collapseAll">
          <span ref="#"  @click="mostrarOuOcular" class="nav-link" >
            <span class="icon-bg"><i class="mdi mdi-currency-usd menu-icon"></i></span>
            <span class="menu-title">
              <span v-if="mostrar">1.000.000,00 AOA</span>
              <span v-else>************</span>
            </span>
          </span>
        </li>
        <li class="nav-item">
          <a class="nav-link" v-b-toggle="'ui-basic'" href="http://localhost:8080">
            <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
            <span class="menu-title">Painel</span>
          </a>
        </li>
        <li class="nav-item nav-category">Relacionamento</li>
        <li class="nav-item">
          <router-link :to="{name : 'contacts.index'}" class="nav-link" v-b-toggle="'ui-basic'"  >
            <span class="icon-bg"><i class="mdi mdi-contacts menu-icon"></i></span>
            <span class="menu-title">Contactos</span>
          </router-link>
        </li>
        <li class="nav-item">
          <span class="nav-link" v-b-toggle="'form-elements'">
            <span class="icon-bg"><i class="mdi mdi-message  menu-icon"></i></span>
            <span class="menu-title">SMS</span>
            <i class="menu-arrow"></i>
          </span>
          <b-collapse accordion="sidebar-accordion" id="form-elements">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <router-link class="nav-link" to="/forms/basic-elements/">Envio rapido</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/forms/basic-elements/">Criar campanha</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/forms/basic-elements/">Listar campanhas</router-link>
              </li>
            </ul>
          </b-collapse>
        </li>
        <li class="nav-item nav-category">Geral</li>
        <li class="nav-item">
          <span class="nav-link" v-b-toggle="'charts-dropdown'">
            <span class="icon-bg"><i class="mdi mdi-chart-bar menu-icon"></i></span>
            <span class="menu-title">Tráfego</span>
            <i class="menu-arrow"></i>
          </span>
          <b-collapse accordion="sidebar-accordion" id="charts-dropdown">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <router-link class="nav-link" to="/charts/chartjs/">SMS MT (Saída)</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/charts/chartjs/">Estatisticas</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/charts/chartjs/">Monitoramento</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/charts/chartjs/">Relatórios</router-link>
              </li>
            </ul>
          </b-collapse>
        </li>
        <li class="nav-item">
          <span class="nav-link" v-b-toggle="'table-dropdown'">
            <span class="icon-bg"><i class="mdi mdi-card-plus menu-icon"></i></span>
            <span class="menu-title">Cobrança</span>
            <i class="menu-arrow"></i>
          </span>
          <b-collapse accordion="sidebar-accordion" id="table-dropdown">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Comprar crédito</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Pagamento automatico</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Métodos de pagamento</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Detalhes de faturamento</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Transações</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Facturas</router-link>
              </li>
            </ul>
          </b-collapse>
        </li>
        <li class="nav-item">
          <span class="nav-link" v-b-toggle="'table-dropdown2'">
            <span class="icon-bg"><i class="mdi mdi-currency-usd menu-icon"></i></span>
            <span class="menu-title">Preço</span>
            <i class="menu-arrow"></i>
          </span>
          <b-collapse accordion="sidebar-accordion" id="table-dropdown2">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Mensagens de texto</router-link>
              </li>
            </ul>
          </b-collapse>
        </li>
        <li class="nav-item">
          <span class="nav-link" v-b-toggle="'table-dropdown3'">
            <span class="icon-bg"><i class="mdi mdi-settings-outline menu-icon"></i></span>
            <span class="menu-title">Definições</span>
            <i class="menu-arrow"></i>
          </span>
          <b-collapse accordion="sidebar-accordion" id="table-dropdown3">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Lista de permissões de IP</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Lista de permissões de URLs</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/"> Padrões de SMS</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Otimizações de SMS</router-link>
              </li>
            </ul>
          </b-collapse>
        </li>
        <li class="nav-item">
          <span class="nav-link" v-b-toggle="'table-dropdown'">
            <span class="icon-bg"><i class="mdi mdi-api menu-icon"></i></span>
            <span class="menu-title">API</span>
            <i class="menu-arrow"></i>
          </span>
          <b-collapse accordion="sidebar-accordion" id="table-dropdown">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Chaves de API</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Crédenciais</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/tables/basic-tables/">Ganchos da Web</router-link>
              </li>
            </ul>
          </b-collapse>
        </li>
        <li class="nav-item nav-category">Preciso de ajuda</li>
        <li class="nav-item">
          <a class="nav-link" v-b-toggle="'ui-basic'" href="http://localhost:8080">
            <span class="icon-bg"><i class="mdi mdi-file-document menu-icon"></i></span>
            <span class="menu-title">Documentação</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" v-b-toggle="'ui-basic'" href="http://localhost:8080">
            <span class="icon-bg"><i class="mdi mdi-chat menu-icon"></i></span>
            <span class="menu-title">Apoio suporte</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" v-b-toggle="'ui-basic'" href="http://localhost:8080">
            <span class="icon-bg"><i class="mdi mdi-chat-alert menu-icon"></i></span>
            <span class="menu-title">Bate papo ao vivo</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" v-b-toggle="'ui-basic'" href="http://localhost:8080">
            <span class="icon-bg"><i class="mdi mdi-state-machine menu-icon"></i></span>
            <span class="menu-title">Status</span>
          </a>
        </li>
      </ul>
    </nav>
  </section>
</template>

<script>
export default {
  name: 'sidebar',
  data () {
    return {
      collapses: [
        { show: false },
        { show: false },
        { show: false }
      ],
      mostrar: false
    }
  },

  methods: {
    mostrarOuOcular(){
      this.mostrar = !this.mostrar;
    },
    collapseAll() {
      var exp_element = document.getElementsByClassName("show");
      if (exp_element.length > 0) {
        var elm_id = exp_element[0].id;
        this.$root.$emit("bv::toggle::collapse", elm_id);
      }
    }
  },
  mounted () {
    const body = document.querySelector('body')
    // add class 'hover-open' to sidebar navitem while hover in sidebar-icon-only menu
    document.querySelectorAll('.sidebar .nav-item').forEach(function (el) {
      el.addEventListener('mouseover', function () {
        if (body.classList.contains('sidebar-icon-only')) {
          el.classList.add('hover-open')
        }
      })
      el.addEventListener('mouseout', function () {
        if (body.classList.contains('sidebar-icon-only')) {
          el.classList.remove('hover-open')
        }
      })
    })
  },
  watch:{
    $route () {
      document.querySelector('#sidebar').classList.toggle('active');
    }
  }
}
</script>
