<template>
  <div>
    <div v-if="authenticated">
      <Home></Home>
    </div>
    <div v-else>
      <Welcome></Welcome>
    </div>
  </div>
</template>

<script>

import {mapGetters} from 'vuex'
import Welcome from '../components/Welcome'
import Home from '../components/Home'

export default {
  // middleware: 'auth',
  metaInfo(){
    return {title : "Home"}
  },
  computed : mapGetters({
    authenticated : 'auth/check'
  }),
  components: {
    Welcome,
    Home
  }
}
</script>
