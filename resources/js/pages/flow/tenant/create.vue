<template>
  <div class="d-flex justify-content-center">
    <form-wizard color="#0d6efd"  shape="tab" class="col-6" >
      <tab-content title="Personal details">
        My first tab content
      </tab-content>
      <tab-content title="Additional Info">
        My second tab content
      </tab-content>
      <tab-content title="Last step">
        Yuhuuu! This seems pretty damn simple
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
  }
}
</script>

<style scoped>

</style>
