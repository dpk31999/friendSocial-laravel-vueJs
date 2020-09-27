<template>
  <div class="mt-5">
    <div v-if="listPost.length > 0" class="posts">
      <div v-for="post in listPost" :key="post.id" class="components mb-3">
        <div class="d-flex header-post">
          <span>
            <router-link
              :to="{ name: 'profile', params: { username: post.username } }"
              data-toggle="tooltip"
              data-placement="bottom"
              :title="post.name"
              class="text-decoration-none text-dark"
            >
              <img :src="post.url_avatar_user" alt class="img" />
              {{ post.username }}
            </router-link>
          </span>
        </div>
        <p class="title">{{ post.title }}</p>
        <img :src="post.url_image" class="image-post" />
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      listPost: [],
    };
  },

  computed: mapGetters({
    user: "auth/user",
  }),

  methods: {
    getPost() {
      axios
        .get("/api/posts/friend/" + this.user.id)
        .then((response) => {
          this.listPost = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  created() {
    this.getPost();
  },
};
</script>
<style scoped>
.title {
  padding: 10px;
}
.img {
  height: 70px;
  width: 70px;
  padding: 10px;
  border-radius: 50%;
}
.components {
  background-color: white;
  border-radius: 10px;
  border: 0.5px solid #343837;
}
.image-post {
  width: 100%;
  padding: 0px 10px 10px;
}
</style>