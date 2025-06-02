<template>
  <div class="login-container">
    <form @submit.prevent="handleLogin">
      <h2>Login</h2>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" v-model="credentials.email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" v-model="credentials.password" required />
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import { useAuthStore } from '@/stores/auth'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export default {
  setup() {
    const authStore = useAuthStore()
    const router = useRouter()
    const credentials = ref({
      email: '',
      password: '',
    })

    const handleLogin = async () => {
      try {
        await authStore.login(credentials.value)
        router.push('/dashboard')
      } catch (error) {
        console.error('Login failed:', error)
      }
    }

    return {
      credentials,
      handleLogin,
    }
  },
}
</script>

<style scoped>
.login-container {
  min-height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f6f8fa;
}

.login-form {
  background: white;
  padding: 2rem 2.5rem;
  border-radius: 10px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 350px;
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
}

.login-form h2 {
  margin-bottom: 0.5rem;
  text-align: center;
  color: #333;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
}

label {
  font-size: 1em;
  color: #555;
}

input[type='email'],
input[type='password'] {
  padding: 0.6rem;
  border: 1px solid #d1d5db;
  border-radius: 5px;
  font-size: 1em;
  background: #f9fafb;
  transition: border 0.2s;
}

input[type='email']:focus,
input[type='password']:focus {
  border-color: #4CAF50;
  outline: none;
}

button[type='submit'] {
  margin-top: 0.5rem;
  padding: 0.7rem;
  background: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 1.1em;
  cursor: pointer;
  transition: background 0.2s;
}

button[type='submit']:hover {
  background: #2563eb;
}
</style>
