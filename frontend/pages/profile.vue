<template>
  <div class="container">
    <h1>Profile</h1>
    <div v-if="$auth.loggedIn">
      <p><strong>Name:</strong> {{ $auth.user.name }}</p>
      <p><strong>Email:</strong> {{ $auth.user.email }}</p>
      <button @click="refreshProfile" class="btn btn-secondary">Refresh Profile</button>
    </div>
    <div v-else>
      <p>Please log in to view your profile.</p>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  methods: {
    async refreshProfile() {
      try {
        await this.$auth.fetchUser()
      } catch (e) {
        console.error('Failed to refresh profile:', e)
      }
    }
  }
}
</script>