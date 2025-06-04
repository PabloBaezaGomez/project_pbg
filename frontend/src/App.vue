<script setup>
import { RouterLink, RouterView } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { onMounted } from 'vue';

const authStore = useAuthStore();
// Import the auth store to manage authentication state

// Initialize authentication on mount
onMounted(async () => {
  try {
    await authStore.initializeAuth();
  } catch (error) {
    console.error('Auth initialization failed:', error);
  }
});
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
          <RouterLink to="/" class="auth-button" @click.prevent="authStore.logout">Logout</RouterLink>
        </template>
        <template v-else-if="!authStore.user && !authStore.isAuthLoading">
          <RouterLink to="/login" class="auth-button">Login</RouterLink>
          <RouterLink to="/register" class="auth-button">Register</RouterLink>
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
        <template
          v-if="
            !authStore.isAuthLoading &&
            authStore.user &&
            (authStore.user.role === 'admin' || authStore.user.user_type === 'admin')
          "
        >
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
  min-height: 100vh;
  flex-direction: column;
}

.header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 72px;
  background-color: var(--titlebackground);
  padding: 1rem;
  border-bottom: 2px solid var(--bordercolor);
  display: flex;
  align-items: center;
  justify-content: space-between;
  z-index: 200;
  box-sizing: border-box;
}

.title {
  flex: 1;
  display: flex;
  justify-content: center; /* Centra el título */
  align-items: center;
}

h1{
  color: var(--titlecolor);
}

.auth-buttons {
  position: absolute;
  right: 2rem;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  gap: 1.5rem; /* Más separación entre los elementos */
  align-items: center;
}

.auth-button,
.auth-buttons button {
  margin-left: 0.5rem;
  margin-right: 0.5rem;
}

.auth-buttons span {
  margin-right: 1rem;
}

.content-wrapper {
  display: flex;
  flex: 1;
  min-height: 100vh;
}

.sidebar {
  position: fixed;
  left: 0;
  top: 0;
  width: 25%;
  min-width: 200px;
  max-width: 320px;
  height: 100vh;
  background: var(--sidebarbackground);
  border-right: 1px solid var(--bordercolor);
  z-index: 100;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  box-sizing: border-box;
  padding-top: 72px;
  overflow-y: auto;
}

.sidebar-content {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
}

.sidebar a {
  padding: 0.5rem 1rem;
  text-decoration: none;
  color: var(--textcolor);
  border-radius: 0.25rem;
  width: 80%;
  text-align: center;
}

.sidebar a.router-link-active {
  background-color: var(--selectedbackground);
  font-weight: bold;
}

.main-content {
  flex: 1;
  padding: 2rem;
  min-width: 0;
  margin-left: 25%;
  margin-top: 72px;
}

@media (max-width: 1200px) {
  .sidebar {
    width: 220px;
    min-width: 0;
    max-width: none;
  }
  .main-content {
    margin-left: 220px;
  }
}

@media (max-width: 768px) {
  .app-container {
    flex-direction: column;
  }
  .header {
    position: static;
    width: 100%;
    height: auto;
    padding-top: 1rem;
    z-index: auto;
  }
  .content-wrapper {
    flex-direction: column;
  }
  .sidebar {
    position: static;
    width: 100%;
    min-width: 0;
    max-width: none;
    height: 56px; /* Altura fija para la barra de navegación */
    border-right: none;
    border-bottom: 1px solid var(--bordercolor);
    justify-content: center;
    align-items: center;
    padding-top: 0;
    padding-bottom: 0;
    background: white;
    z-index: auto;
    display: flex;
    flex-direction: row;
    overflow-x: auto;
  }
  .sidebar a {
    width: auto;
    min-width: 60px;
    font-size: 0.95em;
    text-align: center;
    padding: 0.4rem 0.5rem;
    margin: 0 0.15rem;
    display: flex;
    align-items: center;      /* Centra verticalmente el texto */
    justify-content: center;  /* Centra horizontalmente el texto */
    height: 100%;             /* Ocupa toda la altura de la barra */
    white-space: nowrap;
  }
  .sidebar-content {
    flex-direction: row;
    align-items: center;
    justify-content: center;
    width: 100%;
    gap: 0.3rem;
    display: flex;
    height: 100%;
  }
  .main-content {
    margin-left: 0;
    width: 100%;
    padding: 1rem;
    padding-top: 0;
  }
  .auth-buttons {
    position: static;
    right: unset;
    top: unset;
    transform: none;
    margin-left: auto;
    margin-right: 0;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
  }
}

.loading {
  padding: 0.5rem 1rem;
  color: var(--textcolor);
}

.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
}
</style>
