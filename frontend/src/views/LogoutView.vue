<template>
  <div class="logout-container">
    <h2>Logging out...</h2>
  </div>
</template>

<script>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { authService } from '@/services/api'

export default {
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()

    onMounted(async () => {
      try {
        await authStore.logout()
        router.push('/monsters')
      } catch (error) {
        console.error('Error during logout:', error)
        router.push('/monsters')
      }
    })
  },
}
</script>

<style scoped>
.logout-container {
  max-width: 400px;
  margin: 100px auto;
  text-align: center;
  padding: 20px;
}
</style>
