<template>
  <div>
    <div class="components">
      <div v-if="listFriend.length > 0">
        <h4 class="name-list">Danh sách bạn bè</h4>
        <div class="d-flex align-items-center">
          <div
            class="friend-border"
            v-for="friend in listFriend"
            :key="friend.id"
          >
            <router-link :to="{ name : 'profile' , params : {username: friend.username}}"  data-toggle="tooltip" data-placement="bottom" :title="friend.name" >
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
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      listFriend: [],
    };
  },

  computed: mapGetters({
    user: "auth/user",
  }),

  methods: {
    getFriend() {
      axios
        .get("/api/friends/" + this.user.id)
        .then((response) => {
          this.listFriend = response.data;
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
</style>    