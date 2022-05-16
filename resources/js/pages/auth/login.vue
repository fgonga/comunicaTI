<template>
  <div class="col-xl-4 col-lg-6 mx-auto">
    <div class="auth-form-light text-left p-5">
      <div class="brand-logo">
        <img src="images/logo-dark.svg">
      </div>
      <h4>{{ $t('ola_vamos_comecar') }}</h4>
      <h6 class="font-weight-light">{{$t('faca_login_para_continuar')}}</h6>
      <form @submit.prevent="login" @keydown="form.onKeydown($event)">
        <div class="form-group">
          <input type="email"  :class="{ 'is-invalid': form.errors.has('email') }" v-model="form.email" class="form-control form-control-lg" id="exampleInputEmail1" :placeholder="$t('email')">
          <has-error :form="form" field="email" /> </div>
        <div class="form-group">
          <input type="password"   :class="{ 'is-invalid': form.errors.has('password') }" class="form-control form-control-lg" id="exampleInputPassword1" :placeholder="$t('password')">
          <has-error :form="form" field="password" />
        </div>
        <div class="mt-3">
          <v-button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" :loading="form.busy">
            {{ $t('login') }}
          </v-button>
        </div>

        <div class="my-2 d-flex justify-content-between align-items-center">
          <checkbox v-model="remember " class="auth-link checkbox-inline text-black" name="remember">
            {{ $t('remember_me') }}
          </checkbox>
          <router-link :to="{ name: 'password.request' }"  class=" auth-link text-black ">{{ $t('forgot_password') }}
          </router-link>

        </div>
        <div class="mb-2">
          <!--     TODO  - Verificar o porque que não apresenta o github login     <login-with-github />-->
          <button type="button" class="btn btn-block btn-facebook auth-form-btn">
            <i class="mdi mdi-facebook mr-2"></i>{{$t('conecte_se_usando_o_facebook')}}
          </button>
        </div>
        <div class="text-center mt-4 font-weight-light">
          {{$t('nao_tem_uma_conta') }}
          <router-link :to="{name:'register'}" class="text-primary">{{$t('cadastre_se')}}</router-link>
        </div>
      </form>
    </div>
  </div>
  <!--  <div class="row">
      <div class="col-lg-7 m-auto">
        <card :title="$t('login')">
          <form @submit.prevent="login" @keydown="form.onKeydown($event)">
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

            &lt;!&ndash; Remember Me &ndash;&gt;
            <div class="mb-3 row">
              <div class="col-md-3" />
              <div class="col-md-7 d-flex">
                <checkbox v-model="remember" name="remember">
                  {{ $t('remember_me') }}
                </checkbox>

                <router-link :to="{ name: 'password.request' }" class="small ms-auto my-auto">
                  {{ $t('forgot_password') }}
                </router-link>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-7 offset-md-3 d-flex">
                &lt;!&ndash; Submit Button &ndash;&gt;
                <v-button :loading="form.busy">
                  {{ $t('login') }}
                </v-button>

                &lt;!&ndash; GitHub Login Button &ndash;&gt;
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
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  components: {
    LoginWithGithub
  },

  middleware: 'guest',
  layout: 'auth',
  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.redirect()
    },

    redirect () {
      const intendedUrl = Cookies.get('intended_url')

      if (intendedUrl) {
        Cookies.remove('intended_url')
        this.$router.push({ path: intendedUrl })
      } else {
        this.$router.push({ name: 'home' })
      }
    }
  }
}
</script>
