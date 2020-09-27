<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        {{ appName }}
      </router-link>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-4">
          <li class="nav-item">
            <div class="content">
                <form class="typeahead" role="search">
                    <input type="search" name="q" class="form-control search-input" placeholder="Type something..." autocomplete="off">
                </form>
            </div>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <!-- Authenticated -->
          <div class="mr-4">
            <router-link :to="{ name: 'home' }" :class="[{active: $route.name === 'home'}]" class="item-header btn btn-outline-secondary ml-2">
              <img src="https://img.icons8.com/dusk/64/000000/home.png" width="25px" />
              Trang chủ
            </router-link>
            <router-link :to="{ name: 'message' }" :class="[{active: $route.name === 'message'}]" class="item-header btn btn-outline-secondary ml-2">
                <img src="https://img.icons8.com/dusk/64/000000/messaging-.png" width="25px" />
                Tin nhắn
                <span class="pending">(2)</span>
            </router-link>
            <div class="item-header btn btn-outline-secondary ml-2">
                <img src="https://img.icons8.com/dusk/64/000000/hearts.png" width="25px" />
                Thông báo
                <span class="pending">(2)</span>
            </div>
          </div>
          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark"
               href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
              <img :src="user.url_avatar" class="rounded-circle profile-photo mr-1">
            </a>
            <div class="dropdown-menu">
              <router-link :to="{ name : 'profile' , params : {username: user.username}}" class="dropdown-item pl-3">
                <fa icon="cog" fixed-width />
                Profiles
              </router-link>

              <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
                <fa icon="cog" fixed-width />
                {{ $t('settings') }}
              </router-link>

              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
            </div>
          </li>
          <!-- Guest -->
          <template v-else>
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                {{ $t('login') }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                {{ $t('register') }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
.content{
    border-radius: 5%;
}
.item-header{
  position: relative;
}
</style>
