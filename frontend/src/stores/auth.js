import { defineStore } from 'pinia';
import { authService } from '@/services/api';
import router from '@/router';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token'),
    isAuthLoading: true, // Initialize as true
  }),

  actions: {
    // Initialize authentication state on app load
    async initializeAuth() {
      this.isAuthLoading = true;
      const token = localStorage.getItem('token');
      if (token) {
        try {
          const response = await authService.getCurrentUser();
          // Extract user data from the nested structure
          this.user = response.data.data;
          this.token = token;
        } catch (error) {
          console.error('initializeAuth: getCurrentUser failed:', error);
          this.logout();
        } finally {
          this.isAuthLoading = false;
        }
      } else {
        this.isAuthLoading = false;
      }
    },

    // Set authentication token and user
    setAuth(token, user) {
      this.token = token;
      this.user = user;
      localStorage.setItem('token', token);
    },

    // Handle user login
    async login(credentials) {
      try {
        this.isAuthLoading = true; // Set loading to true at the start of login
        const response = await authService.login(credentials);
        this.token = response.data.token;
        this.user = response.data.user;
        localStorage.setItem('token', this.token);
        return response;
      } finally {
        this.isAuthLoading = false; // Set loading to false after login attempt
      }
    },

    // Handle user logout
    async logout() {
      await authService.logout();

      this.token = null;
      this.user = null;
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      router.push('/monsters'); // Redirect to monsters page after logout
    },
  },
});
