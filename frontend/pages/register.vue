<template>
  <div class="container">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="name">
        <span class="error" v-if="errors.name">{{ errors.name[0] }}</span>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email">
        <span class="error" v-if="errors.email">{{ errors.email[0] }}</span>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password">
        <span class="error" v-if="errors.password">{{ errors.password[0] }}</span>
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" v-model="password_confirmation">
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p>Already have an account? <nuxt-link to="/login">Login here</nuxt-link></p>
    <p>Forgot password? <nuxt-link to="/forgot-password">click here</nuxt-link></p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      errors: {}
    }
  },
  methods: {
    async register() {
      try {
        this.errors = {}
        const response = await this.$axios.post('/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        })

        // Set the token
        this.$auth.setUserToken(response.data.access_token)

        // Manually set the user after successful registration
        if (response.data.user) {
          this.$auth.setUser(response.data.user)
          this.$store.dispatch('updateAuthState', { isLoggedIn: true, user: response.data.user })
        }

        this.$router.push('/')
      } catch (e) {
        if (e.response && e.response.data && e.response.data.errors) {
          this.errors = e.response.data.errors
        } else {
          console.error(e)
        }
      }
    }
  }
}
</script>
