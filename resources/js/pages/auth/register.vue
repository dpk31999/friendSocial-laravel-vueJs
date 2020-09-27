<template>
  <div class="row justify-content-md-center">
    <div class="col-sm-5">
      <div class="top border bg-white d-flex flex-column justify-content-center">
        <card v-if="mustVerifyEmail" :title="$t('register')">
          <div class="alert alert-success" role="alert">
            {{ $t('verify_email_address') }}
          </div>
        </card>
        <h1 v-else class="logo-text">Fiend</h1>
        <div class="form mr-5 ml-5">
          <form @submit.prevent="register" @keydown="form.onKeydown($event)">
            
            <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-9">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="name" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Username</label>
            <div class="col-md-9">
              <input v-model="form.username" :class="{ 'is-invalid': form.errors.has('username') }" class="form-control" type="text" name="username">
              <has-error :form="form" field="username" />
            </div>
          </div>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-9">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
            <div class="col-md-9">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password" />
            </div>
          </div>

          <!-- Password Confirmation -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
            <div class="col-md-9">
              <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
              <has-error :form="form" field="password_confirmation" />
            </div>
          </div>

          <div class="form-group row mb-0">
              <!-- Submit Button -->
              <v-button :loading="form.busy" class="btn btn-info btn-lg btn-block text-light d-flex justify-content-center align-items-center"
                style=" height: 40px">
                {{ $t('register') }}
              </v-button>
          </div>
          <div class="or pt-4" style="position: relative">
              <div class="border-top pt-3"></div>
              <div>
                <p class="text-center divine-line">OR</p>
              </div>
            </div>
            <div class="fb d-flex justify-content-center">
              <a href="/jaja" class="text-decoration-none">
                <p>Log in with Facebook</p>
              </a>
            </div>
          </form>
        </div>
      </div>
      <div class="down mt-4 border bg-white d-flex justify-content-center">
        <p style="padding: 5px; margin-top: 15px">
          Don't have an account?
          <router-link class="text-signup" :to="{ name: 'register'    }">Sign up</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  middleware: 'guest',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      name: '',
      username: '',
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
        this.$router.push({ name: 'home' })
      }
    }
  }
}
</script>
<style scoped>
    .logo-text{
        margin: 22px auto;
        text-align: center;
        background-repeat: no-repeat;
        background-position: 0 -130px;
        height: 51px;
        width: 175px;
    }
    .text-signup {
        color: rgba(var(--d69,0,149,246),1);
        font-size: 14px;
        line-height: 18px;
        text-decoration: none;
    }
    .divine-line {
        position: absolute;
        bottom: -10px;right: 40%;
        padding: 0 17px;
        background-color: white;
    }
    .text-forgot-password {
        font-size: 12px;
        line-height: 14px;
        text-align: center;
        padding-bottom: 14px;
    }
</style>