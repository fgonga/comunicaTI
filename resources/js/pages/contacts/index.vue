<template>
  <div>
    <div  class="d-xl-flex justify-content-between align-items-start">
      <h2  class="text-dark font-weight-bold mb-2"> Lista de contatos </h2>
      <div  class="d-sm-flex justify-content-xl-between align-items-center mb-2">
        <b-button variant="primary" @click="show_new_contact=!show_new_contact"><i class="mdi mdi-plus"></i> Cadastrar cliente</b-button>
      </div>
    </div>
    <div class="row">

      <div class="col-3">
        <div class="card ">
          <div class=" card-body p-2">
            <div class="d-flex justify-content-between align-items-center">
              <h3 class="m-0 p-0">Tags</h3>
              <b-button variant="defautl" size="xs">  <i class="mdi mdi-plus"></i></b-button>
            </div>
          </div>
          <hr class="my-0">
          <ul style="list-style: none" class="list-group unstyled list-group-flush border-bottom  border-light" >
            <a  @click="selectTag(null,null)"  :class="{ active: active === null}" href="#" class="list-group-item  list-group-item-action py-2 px-2 d-flex justify-content-between align-items-start" >
              <div class="me-auto" >Todos os contatos</div>
            </a>
            <a  @click="selectTag(tag,tag.id)"  href="#" v-for="(tag) in tags"  :key="tag.id"   :class="{ active: tag.id === active}" class="list-group-item  list-group-item-action py-2 px-2 d-flex justify-content-between align-items-start" >
              <div class="me-auto" >{{tag.nome}}</div>
            </a>

          </ul>
        </div>

      </div>



      <div class="col" :class="{'col-md-5':show_new_contact}">
        <div class="card card-body">
          <b-table  :busy="contacts_busy"   @filtered="onFiltered"   :filter="filter" :current-page="current_page" :per-page="per_page" id="my-table" :responsive="true" size="sm" :striped="true"  thead-class="bg-primary text-white" :fields="thead" :items="contacts" class="mt-2" outlined show-empty>
            <template #table-busy>
              <div class="text-center text-primary my-2">
                <b-spinner class="align-middle" ></b-spinner>
                <strong>Carregando...</strong>
              </div>
            </template>
            <template #cell(tags)="row" >
              <b-badge @click="selectTag(tag)" variant="light" :key="tag.id" v-for="tag in row.value">{{tag.nome}}</b-badge>
            </template>
            <template #cell(action)="row" >
              <b-button variant="default"  class="text-primary" size="sm"><i class="mdi mdi-pencil"></i></b-button>
              <b-button @click="handleRemove(row)" variant="default"  class="text-danger" size="sm"><i class="mdi mdi-delete"></i></b-button>
            </template>
          </b-table>
          <b-pagination align="right" size="md" :total-rows="total_contacts" v-model="current_page" :per-page="per_page"></b-pagination>

        </div>
      </div>

      <div class=" col-md-4" v-show="show_new_contact">
        <NewContact @addTag="addTag" @close="show_new_contact = false" />
      </div>

    </div>
  </div>
</template>

<script>

import TagService from "~/services/TagService";
import ContactService from "~/services/ContactService";
import NewContact from "./components/NewContact";
export default {
  name: "index.vue",
  layout:"default",
  middleware:'auth',
  components: {
    NewContact
  },
  data () {
    return {
      show_new_contact: false,
      tags_busy: false,
      contacts_busy: false,
      tag_ative:null,
      active:null,
      filter:null,
      current_page: 1,
      per_page: 20,
      value: [],
      tags: [],
      contacts:[],
      thead: [
        {
          key: 'name',
          label: 'Nome',
          sortable: true
        },
        {
          key: 'number',
          label: 'Telefone',
          sortable: true,
        },
        {
          key: 'tags',
          label: 'Tags',
          sortable: false,
        },
        {
          key: 'action',
          label: '',
          sortable: false,
        },
      ]
    }
  },
  computed:{
    total_contacts(){
      return this.contacts.length;
    }
  },
  created() {
    this.create();
  },
  methods: {
    handleRemove(row){
      let self = this;

      this.$swal.fire({
        icon: 'warning',
        title: 'Você tem certeza?',
        html: `Esta ação eliminara permanentemente o contacto <b>${row.item.nome}</b>`,
        showCancelButton: true,
        confirmButtonText: 'Sim, eu tenho',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        reverseButtons: true,
        preConfirm: () => ContactService.destroy(row.item.id).then((response) => {
          self.items.splice(row.index, 1);
          self.$swal.fire(
            'Eliminado',
            '',
            'success',
          );
        }).catch((error) => {
          self.$swal.fire(
            '',
            'Lamentamos, não foi possível eliminar.',
            'error',
          );
        }),
        allowOutsideClick: () => !this.swal.isLoading(),
      }).then((result) => {
        if (result.isConfirmed) {

        }
      });
    },
    getContacts(tag_id){
      this.contacts_busy = true;
      TagService.contacts(tag_id).then(response =>{
        this.contacts_busy = false;
        this.contacts = response.data.contacts;
      }).catch(error => {
        this.contacts_busy = false;
      });
    },
    getAllContacts(){
      this.contacts_busy = true;
      ContactService.index().then(response =>{
        this.contacts_busy = false;
        this.contacts = response.data;
      }).catch(error => {
        this.contacts_busy = false;
      });
    },
    selectTag(tag){
      this.tag_ative = tag;
      this.active = tag ? tag.id : null;
      tag ? this.getContacts(tag.id) : this.getAllContacts();
    },
    getTags() {
      TagService.index().then(response =>{
        this.tags = response.data;
      }).catch(error => {
      });
    },
    create(){
      this.getTags();
      this.getAllContacts();
    },
    addTag (new_tag) {
      this.tags.unshift(new_tag);
    },
    onFiltered(filtered_items) {
      this.current_page = 1;
    }
  }
}
</script>

<style scoped>

</style>
