<template>
  <div class="profile">
    <div class="row justify-content-center info">
      <div class="col-xl-3 col-4">
        <form ref="formChangeAva" @submit.prevent="changeAvatar" enctype="multipart/form-data" >
          <div class="around-ava">
            <div v-if="isLoadingAva" class="loader">
              <div
                class="spinner-grow"
                style="width: 2rem; height: 2rem"
                role="status"
              >
                <span class="sr-only">Loading...</span>
              </div>
            </div>
            <img
              v-else
              :src="userCurrent.url_avatar"
              class="rounded-circle profile-photo mr-1"
              :class="{ 'img-ava' : user.id === userCurrent.id }"
              height="150px"
              width="150px"
              v-on="user.id === userCurrent.id ? { click : targetUpLoadAva} : {}"
            />
          </div>
          <input
            type="file"
            id="fileAvatar"
            class="file-hidden"
            @change="onFileAvatar"
          />
          <button ref="buttonSubmit" class="d-none">Submit</button>
        </form>
      </div>
      <div class="col-xl-6 col-8">
        <div class="d-flex mb-3">
          <h2 class="text-username mr-3">{{ userCurrent.username }}</h2>
          <router-link
            :to="{ name: 'settings.profile' }"
            class="btn btn-secondary"
            v-if="user.id == userCurrent.id"
            >Chỉnh sửa thông tin</router-link
          >
          <div v-else>
            <button
              v-if="statusFriend == ''"
              :class="{ 'btn-loading': isLoading == true }"
              class="btn btn-secondary"
              @click="handleFriend(userCurrent.id)"
            >
              Thêm bạn bè
            </button>
            <button
              v-else-if="statusFriend == '0'"
              :class="{ 'btn-loading': isLoading == true }"
              class="btn btn-info"
              @click="handleFriend(userCurrent.id)"
            >
              Hủy lời mời
            </button>
            <button
              v-else-if="statusFriend == 'special'"
              :class="{ 'btn-loading': isLoading == true }"
              class="btn btn-info"
              @click="handleFriend(userCurrent.id)"
            >
              Chấp nhận kết bạn
            </button>
            <button
              v-else-if="statusFriend == '1'"
              :class="{ 'btn-loading': isLoading == true }"
              class="btn btn-primary"
              @click="handleFriend(userCurrent.id)"
            >
              Hủy kết bạn
            </button>
          </div>
        </div>
        <div class="d-flex mb-3">
          <span class="mr-4">
            <span class="font-weight-bold">{{ posts.length }}</span> hình ảnh
          </span>
          <span class="mr-4">
            <span class="font-weight-bold">{{ countFriend }}</span> bạn bè
          </span>
        </div>
        <h1 class="text-name">{{ userCurrent.name }}</h1>
      </div>
    </div>
    <div class="divine-horizon mb-3"></div>
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="left-banner mb-3">
          <h4 class="text-information">Giới thiệu</h4>
          <div class="text-information">
            <span>
              <img
                class="icon"
                src="https://static.xx.fbcdn.net/rsrc.php/v3/yk/r/X_t0JnueVu-.png"
                alt
              />
              Sống tại
              <span class="font-weight-bold"
                >{{ userCurrent.city }}, {{ userCurrent.country }}</span
              >
            </span>
          </div>
          <div class="text-information">
            <span>
              <img
                class="icon"
                src="https://static.xx.fbcdn.net/rsrc.php/v3/yB/r/ODICuZSjkMe.png"
                alt
              />
              Sinh ngày
              <span class="font-weight-bold">{{
                userCurrent.date_of_birth
              }}</span>
            </span>
          </div>
          <div class="text-information">
            <span>
              <img
                class="icon"
                src="https://static.xx.fbcdn.net/rsrc.php/v3/yq/r/S0aTxIHuoYO.png"
                alt
              />
              Trạng thái
              <span class="font-weight-bold">{{ userCurrent.status }}</span>
            </span>
          </div>
        </div>
        <div class="left-banner mb-3">
          <h4 class="text-information">Liên hệ</h4>
          <div class="text-information">
            <span>
              <img
                class="icon"
                src="https://img.icons8.com/wired/64/000000/email.png"
              />
              Email
              <span class="font-weight-bold">{{ userCurrent.email }}</span>
            </span>
          </div>
          <div class="text-information">
            <span>
              <img
                class="icon"
                src="https://img.icons8.com/material-outlined/48/000000/phone.png"
              />
              Số điện thoại
              <span class="font-weight-bold">{{ userCurrent.phone }}</span>
            </span>
          </div>
          <div class="text-information">
            <span>
              <img
                class="icon"
                src="https://img.icons8.com/metro/26/000000/facebook-new.png"
              />
              Facebook
              <span class="font-weight-bold"
                ><a :href="userCurrent.link_fb" target="_blank">{{
                  userCurrent.name
                }}</a></span
              >
            </span>
          </div>
        </div>

        <div class="left-banner">
          <h4 class="text-information">Sở thích</h4>
          <div
            class="interests"
            v-for="interest in interests"
            :key="interest.id"
          >
            <img :src="interest.url_icon" alt="" width="25px" height="25px" />
            {{ interest.name }}
          </div>
        </div>
      </div>

      <div class="col-md-7">
        <div v-if="user.id == userCurrent.id" class="left-banner mb-3">
          <h4 class="text-information">Đăng bài</h4>
          <form
            @submit.prevent="post"
            @keydown="form.onKeydown($event)"
            enctype="multipart/form-data"
          >
            <div class="form-group">
              <input
                placeholder="Title"
                v-model="form.title"
                :class="{ 'is-invalid': form.errors.has('title') }"
                class="form-control"
                type="text"
                name="title"
              />
              <has-error :form="form" field="title" />
            </div>
            <div class="form-group">
              <label for="file-input">
                <label
                  :class="{ 'is-invalid': form.errors.has('url_image') }"
                  class="btn btn-light"
                  @click="choseImage"
                >
                  <span>
                    <img
                      src="https://img.icons8.com/plasticine/100/000000/image.png"
                      width="30px"
                    /> </span
                  >Chọn ảnh
                </label>
              </label>
              <img v-if="urlImage" :src="urlImage" width="100" height="100" />
              <input
                type="file"
                ref="file"
                id="imagePost"
                class="d-none"
                @change="onFileImage"
              />
              <has-error :form="form" field="url_image" />
            </div>
            <div class="form-group">
              <v-button
                v-if="form.title == '' || urlImage == ''"
                class="btn btn-secondary btn-block"
                disabled
                >Đăng bài</v-button
              >
              <v-button
                :loading="form.busy"
                :class="{ 'btn-loading': isLoading == true }"
                v-else
                class="btn-lg btn-block text-light d-flex justify-content-center align-items-center"
                >Đăng bài</v-button
              >
            </div>
          </form>
        </div>
        <div class="list-post" v-if="posts.length > 0">
          <div
            v-for="(post, index) in posts"
            :key="post.id"
            class="left-banner mb-3"
          >
            <div class="d-flex justify-content-between header-post">
              <span>
                <img :src="userCurrent.url_avatar" alt class="rounded-circle" />
                {{ userCurrent.name }}
              </span>
              <div v-if="user.id == userCurrent.id" class="icon-post">
                <img
                  style="cursor: pointer"
                  src="https://img.icons8.com/cute-clipart/50/000000/edit.png"
                  @click="selectEditPost(post, index)"
                  width="30px"
                />
                <img
                  style="cursor: pointer"
                  src="https://img.icons8.com/flat_round/50/000000/delete-sign.png"
                  @click="deletePost(post.id, index)"
                  width="30px"
                />
              </div>
            </div>
            <p v-if="!post.isEdit" class="title">{{ post.title }}</p>
            <div
              v-else
              class="d-flex justify-content-between"
              style="padding: 10px"
            >
              <input
                type="text"
                class="form-control"
                v-model="selectedPost.title"
              />
              <button class="btn btn-light" @click="updatePost(index)">
                Sửa
              </button>
            </div>
            <img :src="post.url_image" class="image-post" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import Form from "vform";
export default {
  middleware: "auth",

  metaInfo() {
    return { title: "Profile" };
  },

  data() {
    return {
      urlImage: "",
      userCurrent: {},
      form: new Form({
        title: "",
        url_image: "",
      }),
      posts: [],
      isLoading: false,
      selectedPost: {},
      statusFriend: "",
      countFriend: "",
      interests: [],
      url_avatar : "",
      isLoadingAva : false
    };
  },

  methods: {
    checkUserIsUserCurrent()
    {
      return this.user.id === this.userCurrent.id
    },
    async post() {
      this.isLoading = true;
      const formData = new FormData();
      formData.set("url_image", this.form.url_image);
      formData.set("title", this.form.title);
      axios
        .post("api/posts", formData )
        .then((response) => {
          this.isLoading = false;
          this.form.title = "";
          this.form.url_image = "";
          this.urlImage = "";
          this.posts.unshift({ ...response.data, isEdit: false });
        })
        .catch((error) => {
          this.isLoading = false;
          console.log(error);
        });
    },
    onFileImage(e) {
      const file = e.target.files[0];
      this.urlImage = URL.createObjectURL(file);
      this.form.url_image = e.target.files[0];
    },
    choseImage() {
      document.getElementById("imagePost").click();
    },
    async getUserCurrent() {
      await axios
        .get("/api/show/" + this.$route.params.username)
        .then((response) => {
          this.userCurrent = response.data;

          this.getStatusFriend();

          this.getCountFriend();

          this.getListPostCurrent();

          this.getInterest();
        })
        .catch((e) => {
          this.$router.push({ name: "notFound" });
        });
    },
    async getListPostCurrent() {
      await axios
        .get("/api/posts/" + this.$route.params.username)
        .then((response) => {
          this.posts = response.data;
          this.posts.forEach((item) => {
            this.$set(item, "isEdit", false);
          });
        });
    },
    selectEditPost(post, index) {
      this.selectedPost = { ...post };
      post.isEdit = true;
    },
    updatePost(index) {
      axios
        .put("/api/posts/" + this.selectedPost.id, {
          title: this.selectedPost.title,
        })
        .then((response) => {
          this.posts[index].title = this.selectedPost.title;
          this.posts[index].isEdit = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deletePost(id, index) {
      if (confirm("Do you really want to delete?")) {
        axios
          .delete("/api/posts/" + id)
          .then((resp) => {
            this.posts.splice(index, 1);
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    handleFriend(id) {
      this.isLoading = true;
      axios
        .post("/api/friends/" + id)
        .then((response) => {
          this.isLoading = false;
          this.statusFriend = response.data.status;
          if (response.data.status == "1") {
            this.countFriend++;
          } else if (response.data.status == "") {
            this.countFriend--;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getStatusFriend() {
      await axios
        .get("/api/friends/status/" + this.$route.params.username)
        .then((response) => {
          this.statusFriend = response.data.status;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getCountFriend() {
      await axios
        .get("/api/friends/count/" + this.$route.params.username)
        .then((response) => {
          this.countFriend = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getInterest() {
      axios
        .get("/api/interests/name/" + this.$route.params.username)
        .then((response) => {
          this.interests = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    targetUpLoadAva() {
      document.getElementById("fileAvatar").click();
    },
    onFileAvatar(e) {
      const file = e.target.files[0];
      this.isLoadingAva = true
      this.url_avatar = file
        
      this.$refs.buttonSubmit.click()
    },
    changeAvatar() {
      const formData = new FormData();
      formData.set("url_avatar", this.url_avatar);
      axios.post('/api/settings/profile/avatar',formData)
      .then((response) => {
        this.userCurrent.url_avatar = response.data
        this.isLoadingAva = false
      })
    }
  },

  created() {
    this.getUserCurrent();
  },

  computed: mapGetters({
    user: "auth/user",
  }),
};
</script>
<style scoped>
.text-username {
  font-size: 28px;
  line-height: 32px;
  font-weight: 300;
  color: rgba(var(--i1d, 38, 38, 38), 1);
}
.text-name {
  font: inherit;
  font-weight: 600;
  font-size: 1em;
}
.info {
  padding: 30px;
}
.divine-horizon {
  margin: auto;
  border-bottom: 1px solid pink;
  width: 95%;
}
.left-banner {
  background-color: white;
  border-radius: 10px;
  border: 0.5px solid #343837;
}
.text-information {
  padding: 5px 5px;
  color: black;
}
.icon {
  margin-right: 5px;
  width: 20px;
}
.title {
  padding: 20px 10px;
}
.image-post {
  width: 100%;
  padding: 0px 10px 10px;
}
.header-post {
  padding: 10px 5px 0px;
}
.header-post img {
  width: 40px;
  height: 40px;
}
.header-post span {
  font-weight: bold;
}

.interests {
  margin: 5px;
}
.file-hidden {
  display: none;
}
.img-ava {
  cursor: pointer;
}
.around-ava {
  width: 150px;
  height: 150px;
  position: relative;
}
.loader {
  position: absolute;
  left: 45%;
  top: 35%;
}
</style>