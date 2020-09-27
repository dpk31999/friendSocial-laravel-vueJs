<template>
  <card :title="$t('your_info')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
      <alert-success :form="form" :message="$t('info_updated')" />

      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
        <div class="col-md-7">
          <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
          <has-error :form="form" field="name" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Username</label>
        <div class="col-md-7">
          <input v-model="form.username" :class="{ 'is-invalid': form.errors.has('username') }" class="form-control" type="text" name="username">
          <has-error :form="form" field="username" />
        </div>
      </div>

      <!-- Email -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
        <div class="col-md-7">
          <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
          <has-error :form="form" field="email" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Country</label>
        <div class="col-md-7">
          <input disabled v-model="form.country" :class="{ 'is-invalid': form.errors.has('country') }" value="Việt Nam" class="form-control" type="text" name="country">
          <has-error :form="form" field="country" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">City</label>
        <div class="col-md-7">
          <select v-model="form.city" name="city" class="form-control">
            <option v-for="city in dataCity" :key="city" :value="city">{{city}}</option>
          </select>
          <has-error :form="form" field="city" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Data of birth</label>
        <div class="col-md-7">
          <input v-model="form.date_of_birth" :class="{ 'is-invalid': form.errors.has('date_of_birth') }" class="form-control" type="text" name="date_of_birth">
          <has-error :form="form" field="date_of_birth" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Status</label>
        <div class="col-md-7">
          <select v-model="form.status" name="status" class="form-control">
            <option value="single">độc thân</option>
            <option value="inlove">đang trong một mối tình</option>
          </select>
          <has-error :form="form" field="date_of_birth" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Số điện thoại</label>
        <div class="col-md-7">
          <input v-model="form.phone" :class="{ 'is-invalid': form.errors.has('phone') }" class="form-control" type="text" name="phone">
          <has-error :form="form" field="phone" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Liên kết facebook</label>
        <div class="col-md-7">
          <input v-model="form.link_fb" :class="{ 'is-invalid': form.errors.has('link_fb') }" class="form-control" type="text" name="link_fb">
          <has-error :form="form" field="link_fb" />
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">
            {{ $t('update') }}  
          </v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import city from './city.json'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      url_avatar: '',
      name: '',
      username : '',
      email: '',
      country : '',
      city : '',
      interests: '',
      date_of_birth : '',
      status : '',
      phone : '',
      link_fb : ''
    }),
    dataCity : city
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      const { data } = await this.form.patch('/api/settings/profile')

      this.$store.dispatch('auth/updateUser', { user: data })
    }
  }
}
</script>
