<template>
  <div>
    <div class="d-flex align-items-center mt-2">
      <router-link
        :to="{ name: 'profile', params: { username: user.username } }"
        class="text-decoration-none text-dark"
      >
        <img :src="user.url_avatar" alt="" class="img" />
      </router-link>
      <div class="">
        <router-link
          :to="{ name: 'profile', params: { username: user.username } }"
          class="text-decoration-none text-dark"
        >
          <div class="text-username">{{ user.username }}</div>
        </router-link>
        <div class="text-name">{{ user.name }}</div>
      </div>
    </div>
    <div class="components mt-3">
      <h5 class="text-infomation">Những người có cùng sở thích</h5>
      <div class="listFriendSameInterest">
        <div v-if="isLoading" class="loader">
          <div
            class="spinner-grow"
            style="width: 3rem; height: 3rem"
            role="status"
          >
            <span class="sr-only">Loading...</span>
          </div>
        </div>
        <div v-for="user in peopleSameInterests" :key="user.id">
          <div class="d-flex align-items-center">
            <router-link
              :to="{ name: 'profile', params: { username: user.username } }"
              class="text-decoration-none text-dark"
            >
              <img :src="user.url_avatar" alt="" class="img" />
            </router-link>
            <div class="">
              <router-link
                :to="{ name: 'profile', params: { username: user.username } }"
                class="text-decoration-none text-dark"
              >
                <div class="text-username">{{ user.username }}</div>
              </router-link>
              <div class="text-name">{{ user.name }}</div>
            </div>
          </div>
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
      peopleSameInterests: [],
      isLoading: false,
    };
  },

  computed: mapGetters({
    user: "auth/user",
  }),

  methods: {
    getPeople() {
      this.isLoading = true;
      axios
        .get("/api/interests/people/" + this.user.id)
        .then((response) => {
          this.peopleSameInterests = response.data;
          this.isLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  created() {
    this.getPeople();
  },
};
</script>
<style scoped>
.img {
  height: 80px;
  width: 80px;
  padding: 10px;
  border-radius: 50%;
}
.text-username {
  font-weight: 600;
  text-decoration: none;
}
.text-name {
  color: #8e8e8e;
  font-size: 12px;
  line-height: 14px;
}
.components {
  background-color: white;
  border-radius: 10px;
  border: 0.5px solid #343837;
}
.text-infomation {
  padding: 10px 10px;
}
.listFriendSameInterest {
  position: relative;
}
.loader {
  position: absolute;
  left: 45%;
  top: 35%;
}
</style>