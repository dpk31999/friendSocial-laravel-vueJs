<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
      <router-link
        :to="{ name: user ? 'home' : 'welcome' }"
        class="navbar-brand"
      >
        {{ appName }}
      </router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarToggler"
        aria-controls="navbarToggler"
        aria-expanded="false"
      >
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-4">
          <li class="nav-item">
            <div class="content">
              <autocomplete
                aria-label="Search Wikipedia"
                placeholder="Search Wikipedia"
                :search="search"
              >
                <template #result="{ result, props }">
                  <router-link
                        :to="{ name: 'profile', params: { username: result.username } }"
                        class="text-decoration-none text-dark"
                        style="cursor: pointer;"
                      >
                  <li
                    v-bind="props"
                    class="wiki-result"
                  >
                    <div class="d-flex align-items-center mt-2">
                      
                        <img :src="result.url_avatar" alt="" class="img" />
                      <div class="">
                          <div class="text-username">{{ result.username }}</div>
                        <div class="text-name">{{ result.name }}</div>
                      </div>
                    </div>
                  </li>
                  </router-link>
                </template>
              </autocomplete>
            </div>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <!-- Authenticated -->
          <div class="mr-4">
            <router-link
              :to="{ name: 'home' }"
              :class="[{ active: $route.name === 'home' }]"
              class="item-header btn btn-outline-secondary ml-2"
            >
              <img
                src="https://img.icons8.com/dusk/64/000000/home.png"
                width="25px"
              />
              Trang chủ
            </router-link>
            <router-link
              :to="{ name: 'message' }"
              :class="[
                {
                  active:
                    $route.name === 'message' || $route.name === 'message.user',
                },
              ]"
              @click.native="removeItemInArray"
              class="item-header btn btn-outline-secondary ml-2"
            >
              <img
                src="https://img.icons8.com/dusk/64/000000/messaging-.png"
                width="25px"
              />
              Tin nhắn
              <span class="pending" v-if="countUnread.length > 0"
                >(<span>{{ countUnread.length }}</span
                >)</span
              >
            </router-link>
            <div class="item-header btn btn-outline-secondary ml-2">
              <img
                src="https://img.icons8.com/dusk/64/000000/hearts.png"
                width="25px"
              />
              Thông báo
              <span class="pending">(2)</span>
            </div>
          </div>
          <li v-if="user" class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle text-dark"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img
                :src="user.url_avatar"
                class="rounded-circle profile-photo mr-1"
              />
            </a>
            <div class="dropdown-menu">
              <router-link
                :to="{ name: 'profile', params: { username: user.username } }"
                class="dropdown-item pl-3"
              >
                <fa icon="cog" fixed-width />
                Profiles
              </router-link>

              <router-link
                :to="{ name: 'settings.profile' }"
                class="dropdown-item pl-3"
              >
                <fa icon="cog" fixed-width />
                {{ $t("settings") }}
              </router-link>

              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t("logout") }}
              </a>
            </div>
          </li>
          <!-- Guest -->
          <template v-else>
            <li class="nav-item">
              <router-link
                :to="{ name: 'login' }"
                class="nav-link"
                active-class="active"
              >
                {{ $t("login") }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link
                :to="{ name: 'register' }"
                class="nav-link"
                active-class="active"
              >
                {{ $t("register") }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from "vuex";
import LocaleDropdown from "./LocaleDropdown";
import Autocomplete from "@trevoreyre/autocomplete-vue";

export default {
  components: {
    LocaleDropdown,
    Autocomplete,
  },

  data: () => ({
    appName: window.config.appName,
    countUnread: [],
    count: 1,
    arraySearch: [],
    searchText : '',
    countries : ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United Arab Emirates","United Kingdom","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"],
    wikiUrl : 'https://en.wikipedia.org',
    wikiParams : 'action=query&list=search&format=json&origin=*'
  }),

  computed: mapGetters({
    user: "auth/user",
  }),

  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch("auth/logout");

      // Redirect to login.
      this.$router.push({ name: "login" });
    },
    getCountMessageUnread() {
      axios
        .get("/api/friends/" + this.user.id)
        .then((response) => {
          response.data.map((res) => {
            if (res.unread > 0) {
              this.countUnread.push({ id: res.id });
            }
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    checkUserExistInArray(user) {
      this.countUnread.map((res) => {
        if (res.id == data.user_from.id) {
          return false;
        }
      });
      return true;
    },
    removeItemInArray() {
      this.countUnread = [];
    },
    search(input) {
      return new Promise(resolve => {

        if (input.length < 2) {
          return resolve([])
        }

        axios.post('/api/search', {
          value : input
        })
        // .then(response => response.json())
        .then(response => {
          resolve(response.data)
        })
      })
    },
    
  },

  created() {
    this.getCountMessageUnread();
  },

  mounted() {
    let pusher = new Pusher("2a039f54d3cd24112198", {
      cluster: "ap1",
    });

    let channel = pusher.subscribe("channel-chat");
    channel.bind("event-chat", (data) => {
      if (
        this.user.id == data.user_to.id &&
        this.checkUserExistInArray(data.user_from)
      ) {
        this.countUnread.push(data.user_from);
      }
    });
  },
};
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -0.375rem 0;
}
.content {
  border-radius: 5%;
}
.item-header {
  position: relative;
}
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
.autocomplete-result {
  cursor: default;
  background-repeat: no-repeat;
  background-position: 12px;
}
.wiki-result {
  border-top: 1px solid #eee;
  padding: 0px 10px;
  background: transparent;
}
</style>
