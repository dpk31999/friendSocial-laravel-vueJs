<template>
  <card class="settings-card">
    <div class="card-header">Sở thích</div>
    <form @submit.prevent="updateInterests">
      <div class="btn-group checkbox-group">
        <div class="row justify-content-center">
          <div
            class="col-4 around-checkbox"
            v-for="interest in interests"
            :key="interest.id"
          >
            <label class="btn btn-outline-secondary form-check-label" :class="{ 'active' : checkInterest(interest.id) }">
              <input
                type="checkbox"
                class="form-check-input input-checkbox"
                autocomplete="off"
                name="interests[]"
                :value="interest.id"
                v-model="checked"
                checked

                @click="target(interest.id)"
              />
              <img :src="interest.url_icon" alt="" width="25px" height="25px" />
              {{ interest.name }}
            </label>
          </div>
        </div>
      </div>
      <v-button
        :class="{ 'btn-loading': isLoading == true }"
        class="btn-lg btn-block text-light d-flex justify-content-center align-items-center"
        >Submit</v-button
      >
    </form>
  </card>
</template>
<script>
import Form from "vform";
import { mapGetters } from "vuex";
export default {
  scrollToTop: false,

  metaInfo() {
    return { title: "Interest" };
  },

  data: () => ({
    checked: [],
    interests: [],
    isLoading: false,
    chose : []
  }),

  computed: mapGetters({
    user: "auth/user",
  }),

  methods: {
      target(id){
          if(!this.chose.includes(id))
          {
            this.chose.push(id)
          }
          else{
              const index = this.chose.indexOf(id)
              if (index > -1) {
                this.chose.splice(index, 1);
                }
          }
      },

      checkInterest(id){
          return this.checked.includes(id)
      },

    getInterest() {
      axios
        .get("/api/interests")
        .then((response) => {
          this.interests = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getMyInterest() {
      axios
        .get("/api/interests/" + this.user.id)
        .then((response) => {
          this.checked = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    updateInterests() {
      this.isLoading = true;
      axios
        .put("/api/interests/" + this.user.id, {
          interests: this.chose,
        })
        .then((response) => {
          this.checked = response.data;
          this.isLoading = false;
          this.chose = []
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  created() {
    this.getInterest();
    this.getMyInterest();
  },
};
</script>
<style scoped>
.input-checkbox {
  display: none;
}
.checkbox-group {
  margin: 20px;
}
.around-checkbox {
  padding-bottom: 10px;
}
</style>