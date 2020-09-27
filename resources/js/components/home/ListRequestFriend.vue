<template>
  <div>
    <div class="components mt-3">
      <div v-if="listRequestFriend.length > 0">
        <h4 class="name-list">Danh sách yêu cầu kết bạn</h4>
        <div class="d-flex align-items-center">
          <div
            class="friend-border"
            v-for="request in listRequestFriend"
            :key="request.id"
          >
            <router-link
              :to="{ name: 'profile', params: { username: request.username } }"
              data-toggle="tooltip"
              data-placement="bottom"
              :title="request.name"
            >
              <img :src="request.url_avatar" alt="" class="img" />
            </router-link>
          </div>
        </div>
      </div>
      <div v-else>
        <h3 class="name-list">Hiện chưa có yêu cầu kết bạn</h3>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      listRequestFriend: [],
    };
  },

  computed: mapGetters({
    user: "auth/user",
  }),

  methods: {
    getRequestFriend() {
      axios
        .get("/api/friends/request/" + this.user.id)
        .then((response) => {
          this.listRequestFriend = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  created() {
    this.getRequestFriend();
  },
};
</script>
<style scoped>
.components {
  background-color: white;
  border-radius: 10px;
  border: 0.5px solid #343837;
}
.img {
  height: 70px;
  width: 70px;
  padding: 10px;
  border-radius: 50%;
}
.name-list {
  padding: 10px 10px;
}
</style>