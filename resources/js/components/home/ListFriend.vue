<template>
  <div>
    <div class="components">
      <div v-if="isLoading" class="loader">
        <div
          class="spinner-grow"
          style="width: 3rem; height: 3rem"
          role="status"
        >
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <div v-else>
        <div v-if="listFriend.length > 0">
          <h4 class="name-list">Danh sách bạn bè</h4>
          <div class="d-flex align-items-center">
            <div
              class="friend-border"
              v-for="friend in listFriend"
              :key="friend.id"
            >
              <router-link
                :to="{ name: 'profile', params: { username: friend.username } }"
                data-toggle="tooltip"
                data-placement="bottom"
                :title="friend.name"
              >
                <img :src="friend.url_avatar" alt="" class="img" />
              </router-link>
            </div>
          </div>
        </div>
        <div v-else>
          <h2>Hiện chưa có bạn bè</h2>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      listFriend: [],
      isLoading: false,
    };
  },

  computed: mapGetters({
    user: "auth/user",
  }),

  methods: {
    getFriend() {
      this.isLoading = true;
      axios
        .get("/api/friends/" + this.user.id)
        .then((response) => {
          this.listFriend = response.data;
          this.isLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  created() {
    this.getFriend();
  },
};
</script>
<style scoped>
.components {
  background-color: white;
  border-radius: 10px;
  border: 0.5px solid #343837;
  height: 120px;
  position: relative;
}
.img {
  height: 70px;
  width: 70px;
  padding: 10px;
  border-radius: 50%;
}
.name-list {
  padding: 10px 10px 0px;
}
.loader {
  position: absolute;
  left: 45%;
  top: 35%;
}
</style>    