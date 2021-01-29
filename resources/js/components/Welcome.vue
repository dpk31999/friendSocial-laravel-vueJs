<template>
    <div class="container" style="position: relative">
        <div class="row">
            <div class="col-sm-6 d-none mr-4 d-sm-block" style="padding: 0 15%">
                <img src="https://www.mynameart.com/pics/i-love-my-best-friends-with-friend-name.jpg" width="450" height="610" alt="">
            </div>
            <div class="col-sm-4 ml-4 mt-5">
                <div class="top border bg-white d-flex flex-column justify-content-center">
                    <h1 class="logo-text">Fiend</h1>
                    <div class="form mr-5 ml-5">
                        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
                            <div class="form-group row">
                                <input placeholder="Email" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
                                <has-error :form="form" field="email" />
                            </div>
                            <div class="form-group row">
                                <input placeholder="Password" v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                                <has-error :form="form" field="password" />
                            </div>
                            <div class="form-group row mb-0">
                                    <v-button :loading="form.busy" class="btn btn-info btn-lg btn-block text-light d-flex justify-content-center align-items-center" style=" height: 40px">
                                        Log In
                                    </v-button>
                            </div>
                            <div class="or pt-4" style="position: relative">
                                <div class="border-top pt-3">
                                </div>
                                <div>
                                    <p class="text-center divine-line">OR</p>
                                </div>
                            </div>
                            <div class="fb d-flex justify-content-center">
                                <a class="text-decoration-none" @click="AuthProvider('facebook')" style="cursor : pointer;font-weight: bold"><p>Log in with Facebook</p></a>
                            </div>
                            <div class="d-flex justify-content-center">
                                <router-link class="text-forgot-password text-dark text-decoration-none" :to="{ name: 'password.request'}">Forgot your password</router-link>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="down mt-4 border bg-white d-flex justify-content-center">
                    <p style="padding: 5px; margin-top: 15px">Don't have an account? <router-link class="text-signup" :to="{ name: 'register'    }">Sign up</router-link></p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import Form from 'vform'

export default {
    
    middleware: 'guest',

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
      this.$router.push({ name: 'home' })
    },

    AuthProvider(provider) {

        var self = this

        this.$auth.authenticate(provider)
        .then(response =>{
            
        self.SocialLogin(provider,response)

        })
        .catch(err => {
            console.log({err:err})
        })

    },

    SocialLogin(provider,response){

        this.$http.post('/sociallogin/'+provider,response).then(response => {

            console.log(response.data)

        }).catch(err => {
            console.log({err:err})
        })
    },
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