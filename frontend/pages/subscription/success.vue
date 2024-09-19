<!-- pages/subscription/success.vue -->
<template>
  <div class="subscription-success">
    <h1>Subscription Successful!</h1>
    <p>Thank you for your subscription. Your order has been processed successfully.</p>
    <p v-if="subscriptionDetails">
      Package: {{ subscriptionDetails.package_name }}<br>
      Duration: {{ subscriptionDetails.duration }}<br>
      Expires on: {{ subscriptionDetails.expires_at }}
    </p>
    <p v-else>Loading subscription details...</p>
    <nuxt-link to="/dashboard" class="btn-dashboard">Go to Dashboard</nuxt-link>
  </div>
</template>

<script>
export default {
  name: 'SubscriptionSuccess',
  data() {
    return {
      subscriptionDetails: null
    }
  },
  async mounted() {
    try {
      const response = await this.$axios.$get('/api/subscription/details');
      this.subscriptionDetails = response;
    } catch (error) {
      console.error('Failed to fetch subscription details:', error);
    }
  }
}
</script>

<style scoped>
.subscription-success {
  text-align: center;
  padding: 2rem;
}
.btn-dashboard {
  display: inline-block;
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  background-color: #28a745;
  color: white;
  text-decoration: none;
  border-radius: 4px;
}
</style>