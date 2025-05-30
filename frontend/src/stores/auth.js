import { defineStore } from 'pinia'
import { authService } from '@/services/api'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token'),
        isAuthLoading: true // Initialize as true
    }),

    actions: {
        async initializeAuth() {
            console.log('initializeAuth: Starting initialization.')
            this.isAuthLoading = true
            const token = localStorage.getItem('token')
            console.log('initializeAuth: Token from localStorage:', token)
            if (token) {
                try {
                    const response = await authService.getCurrentUser()
                    // Extract user data from the nested structure
                    this.user = response.data.data
                    this.token = token
                    console.log('initializeAuth: getCurrentUser successful. User data:', JSON.stringify(this.user, null, 2))
                    console.log('initializeAuth: Token set:', this.token)
                } catch (error) {
                    console.error('initializeAuth: getCurrentUser failed:', error)
                    this.logout()
                } finally {
                    this.isAuthLoading = false
                }
            } else {
                console.log('initializeAuth: No token found in localStorage.')
                this.isAuthLoading = false
            }
        },
        setAuth(token, user) {
            this.token = token
            this.user = user
            localStorage.setItem('token', token)
        },

        async login(credentials) {
            try {
                this.isAuthLoading = true; // Set loading to true at the start of login
                const response = await authService.login(credentials)
                this.token = response.data.token
                this.user = response.data.user
                localStorage.setItem('token', this.token)
                console.log('Login successful. Response data:', JSON.stringify(response.data, null, 2))
                console.log('Auth store user after login:', JSON.stringify(this.user, null, 2))
                return response
            } finally {
                this.isAuthLoading = false; // Set loading to false after login attempt
            }
        },

        logout() {
            this.user = null
            this.token = null
            localStorage.removeItem('token')
            this.isAuthLoading = false; // Set loading to false on logout
        }
    }
})
