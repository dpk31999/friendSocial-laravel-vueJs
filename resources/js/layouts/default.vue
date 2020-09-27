<template>
  <div class="main-layout">
    <navbar v-if="authenticated" />

    <div class="container mt-4">
      <child />
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'
import { mapGetters } from 'vuex'

export default {
  name: 'MainLayout',

  components: {
    Navbar
  },

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>
