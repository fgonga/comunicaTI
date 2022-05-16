<template>
  <div class="row w-100 flex-grow">
    <div class="col-xl-4 col-lg-6 mx-auto">
      <div class="auth-form-light text-left p-5">
        <div class="brand-logo">
          <img src="/images/logo-dark.svg">
        </div>
        <h4>{{ $t('novo_por_aqui') }}</h4>
        <h6 class="font-weight-light">{{$t('registar_e_facil')}}</h6>
        <form @submit.prevent="register" class="pt-3" @keydown="form.onKeydown($event)">
          <div class="form-group">
            <input v-model="form.name" type="text"
                   :class="{ 'is-invalid': form.errors.has('name') }"
                   class="form-control form-control-lg"
                   id="exampleInputUsername1"
                   placeholder="Seu nome">
            <has-error :form="form" field="name" />
          </div>
          <div class="form-group">
            <input v-model="form.nome" type="text"
                   :class="{ 'is-invalid': form.errors.has('nome') }"
                   class="form-control form-control-lg"
                   id="exampleInputUsername1"
                   placeholder="Nome da empresa">
            <has-error :form="form" field="nome" />
          </div>
          <div class="form-group">
            <input v-model="form.nif" type="text"
                   :class="{ 'is-invalid': form.errors.has('nif') }"
                   class="form-control form-control-lg"
                   id="exampleInputUsername1"
                    placeholder="NIF">
            <has-error :form="form" field="nif" />
          </div>
          <div class="form-group">
            <input v-model="form.email" name="email" type="email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control form-control-lg" id="exampleInputEmail1" :placeholder="$t('email')">
            <has-error :form="form" field="email" />
          </div>
          <div class="form-group">
            <input v-model="form.password" name="password" type="password" class="form-control form-control-lg" :class="{ 'is-invalid': form.errors.has('password') }" id="exampleInputPassword1" :placeholder="$t('password')">
            <has-error :form="form" field="password" />
          </div>
          <div class="form-group">
            <input v-model="form.password_confirmation" name="password_confirmation" type="password" class="form-control form-control-lg" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" id="exampleInputPassword1" placeholder="Confirme sua senha">
            <has-error :form="form" field="password_confirmation" />
          </div>
          <v-button :loading="form.busy" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" >
            {{ $t('register') }}
          </v-button>
          <div class="mb-4">
            <div class="form-check">
              <label class="form-check-label text-muted">
                <input type="checkbox" >
                <!--    TODO Adicionar termos e condições            -->
                Eu aceito todos os <a href="">Termos e Condições</a>
                <i class="input-helper"></i>
              </label>
            </div>
          </div>
          <div class="mt-3">

          </div>
          <div class="text-center mt-4 font-weight-light">
            Você já tem uma conta? <router-link :to="{name:'login'}" class="text-primary">{{$t('login')}}</router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--  <div class="row">
      <div class="col-lg-7 m-auto">
        <card v-if="mustVerifyEmail" :title="$t('register')">
          <div class="alert alert-success" role="alert">
            {{ $t('verify_email_address') }}
          </div>
        </card>
        <card v-else :title="$t('register')">
          <form @submit.prevent="register" @keydown="form.onKeydown($event)">
            &lt;!&ndash; Name &ndash;&gt;
            <div class="mb-3 row">
              <label class="col-md-3 col-form-label text-md-end">{{ $t('name') }}</label>
              <div class="col-md-7">
                <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
                <has-error :form="form" field="name" />
              </div>
            </div>

            &lt;!&ndash; Email &ndash;&gt;
            <div class="mb-3 row">
              <label class="col-md-3 col-form-label text-md-end">{{ $t('email') }}</label>
              <div class="col-md-7">
                <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
                <has-error :form="form" field="email" />
              </div>
            </div>

            &lt;!&ndash; Password &ndash;&gt;
            <div class="mb-3 row">
              <label class="col-md-3 col-form-label text-md-end">{{ $t('password') }}</label>
              <div class="col-md-7">
                <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                <has-error :form="form" field="password" />
              </div>
            </div>

            &lt;!&ndash; Password Confirmation &ndash;&gt;
            <div class="mb-3 row">
              <label class="col-md-3 col-form-label text-md-end">{{ $t('confirm_password') }}</label>
              <div class="col-md-7">
                <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
                <has-error :form="form" field="password_confirmation" />
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-7 offset-md-3 d-flex">
                &lt;!&ndash; Submit Button &ndash;&gt;
                <v-button :loading="form.busy">
                  {{ $t('register') }}
                </v-button>

                &lt;!&ndash; GitHub Register Button &ndash;&gt;
                <login-with-github />
              </div>
            </div>
          </form>
        </card>
      </div>
    </div>-->
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  components: {
    LoginWithGithub
  },
  layout:"auth",
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }),
    mustVerifyEmail: false
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = true
      } else {
        // Log in the user.
        const { data: { token } } = await this.form.post('/api/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })
        // Redirect home.
        await this.$router.push({name: 'flow.tenant.create'})
      }
    }
  }
}
</script>
