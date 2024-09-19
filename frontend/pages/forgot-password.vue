<template>
  <div class="container">
    <h2>Forgot Password</h2>
    <b-form @submit.prevent="forgotPassword">
      <b-form-group id="email-group" label="Email address:" label-for="email">
        <b-form-input id="email" v-model="email" type="email" required placeholder="Enter email"></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Send Reset Link</b-button>
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
      message: '',
      error: ''
    }
  },
  methods: {
    async forgotPassword() {
      try {
        const response = await this.$axios.post('/api/forgot-password', {
          email: this.email
        })
        this.message = response.data.message
        this.error = ''
      } catch (error) {
        this.error = error.response.data.message || 'An error occurred'
        this.message = ''
      }
    }
  }
}
</script>