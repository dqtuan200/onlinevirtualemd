<template>
  <div class="container">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required>
        <span class="error" v-if="errors.email">{{ errors.email[0] }}</span>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" required>
        <span class="error" v-if="errors.password">{{ errors.password[0] }}</span>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <p>Don't have an account? <nuxt-link to="/register">Register here</nuxt-link></p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
      errors: {}
    }
  },
  methods: {
    async login() {
      try {
        this.errors = {}
        const response = await this.$auth.loginWith('local', {
          data: {
            email: this.email,
            password: this.password
          }
        })

        // Manually set the user after successful login
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