import api from './api'

export default {
  login(credentials) {
    return api.post('/auth/login', credentials)
  },
  // Add other auth-related methods
}