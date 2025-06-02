<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { onMounted } from 'vue' // Remove ref import as it's no longer needed for isAuthLoading

const authStore = useAuthStore()
// const isAuthLoading = ref(true) // Remove this line

onMounted(async () => {
  try {
    await authStore.initializeAuth()
  } catch (error) {
    console.error('Auth initialization failed:', error)
  }
})
</script>

<template>
  <div class="app-container">
    <header class="header">
      <div class="title">
        <h1>Monster Hunter PBG</h1>
      </div>
      <div class="auth-buttons">
        <template v-if="authStore.user && !authStore.isAuthLoading">
          <span>Welcome, {{ authStore.user.user_name }}</span>
          <button @click="authStore.logout">Logout</button>
        </template>
        <template v-else-if="!authStore.user && !authStore.isAuthLoading">
          <RouterLink to="/login">Login</RouterLink>
          <RouterLink to="/register">Register</RouterLink>
        </template>
        <template v-else>
          <span>Loading authentication...</span>
        </template>
      </div>
    </header>

    <div class="content-wrapper">
      <nav class="sidebar">
        <RouterLink to="/monsters">Monsters</RouterLink>
        <RouterLink to="/equipments">Equipments</RouterLink>
        <RouterLink to="/materials">Materials</RouterLink>
        <template v-if="!authStore.isAuthLoading && authStore.user">
          <RouterLink to="/UserEquipments">My Equipment</RouterLink>
        </template>
        <template v-if="!authStore.isAuthLoading && authStore.user && (authStore.user.role === 'admin' || authStore.user.user_type === 'admin')">
          <RouterLink to="/newEquipment">New Equipment</RouterLink>
          <RouterLink to="/newMonster">New Monster</RouterLink>
          <RouterLink to="/newMaterial">New Material</RouterLink>
        </template>
      </nav>

      <main class="main-content">
        <RouterView v-if="!authStore.isAuthLoading" />
        <div v-else class="loading-container">
          <p>Loading application...</p>
        </div>
      </main>
    </div>
  </div>
</template>

<style scoped>
.app-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.header {
  background-color: var(--color-background-soft);
  padding: 1rem;
  border-bottom: 1px solid var(--color-border);
  display: flex;
  align-items: center; /* Centra verticalmente los elementos del header */
  justify-content: space-between; /* Espacia el título y los botones */
}

.title {
  font-size: 1rem;
  color: var(--color-text);
  text-align: center;
  flex: 1;
}

.username {
  padding: 0.5rem 1rem;
  color: var(--color-text);
  display: flex;
  align-items: center;
}

.auth-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  align-items: center;
}

.auth-button {
  padding: 0.5rem 1rem;
  text-decoration: none;
  color: var(--color-text);
  background-color: var(--color-border);
  border-radius: 0.25rem;
}

.content-wrapper {
  display: flex;
  flex: 1;
}

.sidebar {
  width: 25%;
  min-width: 200px;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  border-right: 1px solid var(--color-border);
  flex-shrink: 0;
}

.sidebar a {
  padding: 0.5rem 1rem;
  text-decoration: none;
  color: var(--color-text);
  border-radius: 0.25rem;
}

.sidebar a.router-link-active {
  background-color: var(--color-border);
  font-weight: bold;
}

.main-content {
  flex: 1;
  padding: 2rem;
}

@media (max-width: 768px) {
  .content-wrapper {
    flex-direction: column;
  }

  .sidebar {
    width: 100%;
    border-right: none;
    border-bottom: 1px solid var(--color-border);
  }

  .main-content {
    width: 100%;
  }
}

.loading {
  padding: 0.5rem 1rem;
  color: var(--color-text);
}

.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
}
</style>
