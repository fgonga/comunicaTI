<template>
  <div class="card">
    <div class=" card-body p-2 border-0">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="m-0 p-0">Novo contacto</h5>
        <b-button @click="close" variant="defautl" size="xs">  <i class="mdi mdi-window-close"></i></b-button>
      </div>

      <hr class="my-0">

      <div class="form-group my-0 mb-2 mt-2">
        <input v-model="contact.name" type="text" class="col-12 form-control form-control-sm form-conectati" placeholder="O nome do contacto">
      </div>
      <div class="form-group my-0 mb-2">
        <input type="number" v-model="contact.number" class="col-12 form-control form-control-sm form-conectati" placeholder="Número de telefone">
      </div>

      <div class="form-group my-0 ">
        <multiselect class="form-conectati" v-model="tags_in_contact" tag-placeholder="Adicionar uma nova tag" placeholder="Pesquise ou adicione uma tag" label="nome" track-by="id" :options="tags" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
      </div>
      <div v-if="validation_errors" class="mt-2">
        <ValidationErrors :errors="validation_errors" v-if="validation_errors"/>
      </div>
      <div class="form-group my-0 mt-2">
        <b-button :disabled="busy" @click="handleStore" variant="primary" class="col-12">Salvar</b-button>
      </div>
    </div>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import TagService from "~/services/TagService";
import ContactService from "~/services/ContactService";
import ValidationErrors from '~/pages/components/ValidationErrors';
export default {
  name: "NewContact",
  components:{
    Multiselect,ValidationErrors
  },
  data () {
    return {
      busy:false,
      tags: [],
      tags_in_contact: [],
      validation_errors:'',
      contact: {
        name: '',
        number: '',
        tags: []
      }
    }
  },
  created() {
    this.create();
  },
  methods:{
    close(){
      return this.$emit("close",null);
    },
    addTag (newTag) {
      TagService.store({nome:newTag}).then(response =>{
        this.tags.unshift(response.data);
        this.tags_in_contact.unshift(response.data);
        this.$emit("addTag", response.data);
      }).catch(error => {

      });
    },
    handleStore(){
      // Todo Validar os dados
      this.store();
    },
    store(){
      this.busy = true;
      this.contact.tags  = this.tags_in_contact.map(a => a.id)
      ContactService.store(this.contact).then(response =>{
        this.busy = false;
        this.$emit("stored",response.data);
        this.clear();
      }).catch(error => {
        this.busy = false;
        if (error.response.status === 422) {
          this.validation_errors = '';
          this.validation_errors = error.response.data.errors;
        }
      });
    },
    create(){
      TagService.index().then(response =>{
        this.tags = response.data;
      }).catch(error => {
      });
    },
    clear(){
      this.contact.name = '';
      this.contact.number = '';
      this.contact.tags = [];
      this.tags_in_contact = [];
    }
  }
}
</script>


