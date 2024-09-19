<!-- pages/packages.vue -->
<template>
  <div>
    <h1>Membership Packages</h1>
    <div v-for="pkg in packages" :key="pkg.id">
      <h2>{{ pkg.name }}</h2>
      <p>{{ pkg.duration }}</p>
      <p>{{ pkg.price }}</p>
      <button @click="subscribe(pkg)" :disabled="isLoading">
        {{ isLoading ? 'Processing...' : 'Subscribe' }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isLoading: false,
      packages: []
    }
  },
  async fetch() {
    try {
      this.packages = await this.$axios.$get('/api/packages');
    } catch (error) {
      console.error('Error fetching packages:', error);
      // Handle error (e.g., show error message to user)
    }
  },
  middleware: 'auth',
  methods: {
    async subscribe(pkg) {
      this.isLoading = true;
      try {
        const response = await this.$axios.$post('/api/subscribe', {
          package_id: pkg.id
        });

        if (response.approve_link) {
          // Redirect the user to PayPal for approval
          window.location.href = response.approve_link;
        } else {
          throw new Error('PayPal approval link not received');
        }
      } catch (error) {
        console.error('Subscription error:', error);
        // Handle the error (e.g., show an error message to the user)
        if (error.response && error.response.data && error.response.data.error) {
          alert(`Subscription error: ${error.response.data.error}`);
        } else {
          alert('An error occurred while processing your subscription. Please try again.');
        }
        this.isLoading = false;
      } finally {
        
      }
    }
  }
}
</script>
