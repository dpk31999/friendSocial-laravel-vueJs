<template>
  <div class="row">
    <div class="col-md-3">
      <card class="settings-card">
        <div class="card-header">
          Chỉnh sửa
        </div>
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in tabs" :key="tab.route" class="nav-item">
            <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
              <img :src="tab.icon" alt="" width="30px" height="30px">
              {{ tab.name }}
            </router-link>
          </li>
        </ul>
      </card>
    </div>

    <div class="col-md-9">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'https://img.icons8.com/material/48/000000/user-male-circle--v1.png',
          name: 'Hồ sơ cá nhân',
          route: 'settings.profile'
        },
        {
          icon: 'https://img.icons8.com/material/48/000000/lock--v1.png',
          name: 'Mật khẩu',
          route: 'settings.password'
        },
        {
          icon: 'https://img.icons8.com/material/48/000000/resume--v1.png',
          name: 'Sở thích',
          route: 'settings.interests'
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
