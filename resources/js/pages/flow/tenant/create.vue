<template>
  <div class="d-flex justify-content-center">
    <form-wizard @on-complete="novoTenante" subtitle="" color="#181824" nextButtonText="Proximo" stepSize="sm"  backButtonText="Voltar" finishButtonText="Finalizar" shape="tab" class="col-6"  title="Nova empresa" >
      <tab-content title="Informações gerais">
        <div class="row">
          <div class="form-group col-12">
            <label for="">NIF</label>
            <input type="text" class="form-control" placeholder="Exemplo: 5000342343">
          </div>
        </div>
      </tab-content>


    </form-wizard>
  </div>
</template>

<script>
//local registration
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
export default {
  name: "create.vue",
  layout: 'default',
  components: {
    FormWizard,
    TabContent
  },
  methods:{
    novoTenante(){
      alert("Tenant criado com sucesso!")
    }
  }
}
</script>

<style scoped>

</style>
