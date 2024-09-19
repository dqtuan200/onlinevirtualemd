<template>
  <div class="container">
    <h2>Reset Password</h2>
    <b-form @submit.prevent="resetPassword">
      <b-form-group id="email-group" label="Email address:" label-for="email">
        <b-form-input id="email" v-model="email" type="email" required placeholder="Enter email"></b-form-input>
      </b-form-group>

      <b-form-group id="password-group" label="New Password:" label-for="password">
        <b-form-input id="password" v-model="password" type="password" required
          placeholder="Enter new password"></b-form-input>
      </b-form-group>

      <b-form-group id="password-confirmation-group" label="Confirm New Password:" label-for="password_confirmation">
        <b-form-input id="password_confirmation" v-model="password_confirmation" type="password" required
          placeholder="Confirm new password"></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Reset Password</b-button>
    </b-form>
    <b-alert v-if="message" show variant="success" class="mt-3">{{ message }}</b-alert>
    <b-alert v-if="error" show variant="danger" class="mt-3">{{ error }}</b-alert>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
      password_confirmation: '',
      token: '',
      message: '',
      error: ''
    }
  },
  mounted() {
    // Get the token from the URL query parameter
    this.token = this.$route.query.token
    this.email = this.$route.query.email
  },
  methods: {
    async resetPassword() {
      try {
        const response = await this.$axios.post('/api/reset-password', {
          token: this.token,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        })
        this.message = response.data.message
        this.error = ''
        // Redirect to login page after successful password reset
        setTimeout(() => this.$router.push('/login'), 3000)
      } catch (error) {
        this.error = error.response.data.message || 'An error occurred'
        this.message = ''
      }
    }
  }
}
</script>