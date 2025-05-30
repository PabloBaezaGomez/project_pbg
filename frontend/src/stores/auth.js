import { defineStore } from 'pinia'
import { authService } from '@/services/api'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token')
    }),

    actions: {
        async initializeAuth() {
            const token = localStorage.getItem('token')
            if (token) {
                try {
                    const response = await authService.getCurrentUser()
                    this.user = response.data
                    this.token = token
                } catch (error) {
                    this.logout()
                }
            }
        },
        setAuth(token, user) {
            this.token = token
            this.user = user
            localStorage.setItem('token', token)
        },

        async login(credentials) {
            try {
                const response = await authService.login(credentials)
                this.token = response.data.token
                this.user = response.data.user
                localStorage.setItem('token', this.token)
                return response
            } catch (error) {
                throw error
            }
        },

        logout() {
            this.user = null
            this.token = null
            localStorage.removeItem('token')
        }
    }
})
