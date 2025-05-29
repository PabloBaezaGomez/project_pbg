<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { onMounted } from 'vue'

const authStore = useAuthStore()

onMounted(async () => {
  await authStore.initializeAuth()
})
</script>

<template>
  <div class="app-container">
    <header class="header">
      <div class="auth-buttons">
        <template v-if="!authStore.user">
          <RouterLink to="/login" class="auth-button">Login</RouterLink>
          <RouterLink to="/register" class="auth-button">Register</RouterLink>
        </template>
        <template v-else>
          <span class="username">Welcome, {{ authStore.user.user_name }}</span>
          <RouterLink to="/logout" class="auth-button">Logout</RouterLink>
        </template>
      </div>
    </header>

    <div class="content-wrapper">
      <nav class="sidebar">
        <RouterLink to="/monsters">Monsters</RouterLink>
        <RouterLink to="/equipments">Equipments</RouterLink>
        <RouterLink to="/materials">Materials</RouterLink>
        <template v-if="authStore.user">
          <RouterLink to="/UserEquipments">My Equipment</RouterLink>
        </template>
        <template v-if="authStore.user && authStore.user.isAdmin">
          <RouterLink to="/new-equipment">New Equipment</RouterLink>
          <RouterLink to="/new-monster">New Monster</RouterLink>
          <RouterLink to="/new-material">New Material</RouterLink>
        </template>
      </nav>

      <main class="main-content">
        <RouterView />
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
</style>
