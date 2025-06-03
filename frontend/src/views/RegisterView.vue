<template>
  <div class="register-container">
    <form @submit.prevent="handleRegister" class="register-form">
      <h2>Register</h2>

      <div class="form-group">
        <label for="user_name">Username</label>
        <input
          type="text"
          id="user_name"
          v-model="formData.user_name"
          required
        >
      </div>

      <div class="form-group">
        <label for="user_email">Email</label>
        <input
          type="email"
          id="user_email"
          v-model="formData.user_email"
          required
        >
      </div>

      <div class="form-group">
        <label for="user_password">Password</label>
        <input
          type="password"
          id="user_password"
          v-model="formData.user_password"
          required
        >
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input
          type="password"
          id="password_confirmation"
          v-model="formData.password_confirmation"
          required
        >
      </div>

      <div v-if="Object.keys(errors).length > 0" class="error-message">
        <ul>
          <li v-for="(errorList, field) in errors" :key="field">
            <template v-for="(error, index) in errorList" :key="index">
              {{ error }}
            </template>
          </li>
        </ul>
      </div>

      <button type="submit" :disabled="isLoading">
        {{ isLoading ? 'Registering...' : 'Register' }}
      </button>

      <div class="login-link">
        Already have an account?
        <router-link to="/login">Login here</router-link>
      </div>
    </form>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { authService } from '@/services/api'

export default {
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()
    const errors = ref({})
    const isLoading = ref(false)

    const formData = ref({
      user_name: '',
      user_email: '',
      user_password: '',
      password_confirmation: ''
    })

    const handleRegister = async () => {
      errors.value = {}
      isLoading.value = true

      try {
        const response = await authService.register(formData.value)
        console.log('Registration response:', response)

        // Check for the nested data structure
        if (response.data?.data?.token) {
          authStore.setAuth(response.data.data.token, response.data.data.user)
          router.push('/')
        } else if (response.data?.token) {
          // Fallback for direct token access
          authStore.setAuth(response.data.token, response.data.user)
          router.push('/')
        } else {
          errors.value = {
            general: ['Registration successful but login failed. Please try logging in.']
          }
          router.push('/login')
        }
      } catch (err) {
        console.error('Registration error:', err.response)

        if (err.response?.data?.errors) {
          errors.value = err.response.data.errors
        } else if (err.response?.status === 422) {
          errors.value = {
            general: ['Please check your input and try again']
          }
        } else if (err.response?.status === 409) {
          errors.value = {
            user_email: ['This email is already registered']
          }
        } else {
          errors.value = {
            general: [
              err.response?.data?.message ||
              err.message ||
              'Registration failed. Please try again.'
            ]
          }
        }
      } finally {
        isLoading.value = false
      }
    }

    return {
      formData,
      errors,
      isLoading,
      handleRegister
    }
  }
}
</script>

<style scoped>
.register-container {
  max-width: 400px;
  margin: 40px auto;
  padding: 20px;
}

.register-form {
  background: var(--formbackground);
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px var(--shadowcolor);
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: var(--accentcolor2);
}

input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid var(--inputbackground);
  border-radius: 4px;
  font-size: 1rem;
}

input:focus {
  outline: none;
  border-color: var(--button);
  box-shadow: 0 0 0 2px var(--shadowcolor);
}

button {
  width: 100%;
  padding: 10px;
  background: var(--button);
  color: var(--textbutton);
  border: none;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.2s;
}

button:hover:not(:disabled) {
  background: var(--buttonhover);
}

button:disabled {
  background: var(--buttondisabled);
  cursor: not-allowed;
}

.error-message {
  color: var(--errortext);
  margin-bottom: 15px;
  text-align: left;
}

.error-message ul {
  margin: 0;
  padding-left: 20px;
}

.error-message li {
  margin-bottom: 5px;
}

.login-link {
  text-align: center;
  margin-top: 15px;
}

.login-link a {
  color: var(--accentcolor);
  text-decoration: none;
}

.login-link a:hover {
  text-decoration: underline;
}
</style>
