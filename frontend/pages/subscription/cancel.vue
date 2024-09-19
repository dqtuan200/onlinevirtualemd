<!-- pages/subscription/cancel.vue -->
<template>
  <div class="subscription-cancel">
    <h1>Subscription Cancelled</h1>
    <p>Your subscription process has been cancelled. No charges have been made.</p>
    <nuxt-link to="/packages" class="btn-return">Return to Packages</nuxt-link>
  </div>
</template>

<script>
export default {
  name: 'SubscriptionCancel'
}
</script>

<style scoped>
.subscription-cancel {
  text-align: center;
  padding: 2rem;
}
.btn-return {
  display: inline-block;
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  background-color: #007bff;
  color: white;
  text-decoration: none;
  border-radius: 4px;
}
</style>