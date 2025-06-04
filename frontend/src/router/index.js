import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  // Redirects
  {
    path: '/',
    redirect: '/monsters',
  },
  {
    path: '/dashboard',
    redirect: '/monsters',
  },
  // Views
  {
    path: '/monsters',
    name: 'Monsters',
    component: () => import('../views/MonstersView.vue'),
  },
  {
    path: '/newMonster',
    name: 'NewMonster',
    component: () => import('../views/NewMonsterView.vue'),
  },
  {
    path: '/equipments',
    name: 'Equipments',
    component: () => import('../views/EquipmentsView.vue'),
  },
  {
    path: '/UserEquipments',
    name: 'UserEquipments',
    component: () => import('../views/UserEquipmentsView.vue'),
  },
  {
    path: '/newEquipment',
    name: 'NewEquipment',
    component: () => import('../views/NewEquipmentView.vue'),
  },
  {
    path: '/materials',
    name: 'Materials',
    component: () => import('../views/MaterialsView.vue'),
  },
  {
    path: '/newMaterial',
    name: 'NewMaterial',
    component: () => import('../views/NewMaterialView.vue'),
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/LoginView.vue'),
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/RegisterView.vue'),
  },
  {
    path: '/logout',
    name: 'Logout',
    component: () => import('../views/LogoutView.vue'),
  },
  {
    path: '/monster/:id',
    name: 'Monster',
    component: () => import('../views/MonsterView.vue'),
  },
  {
    path: '/equipment/:id',
    name: 'Equipment',
    component: () => import('../views/EquipmentView.vue'),
  },
  {
    path: '/material/:id',
    name: 'Material',
    component: () => import('../views/MaterialView.vue'),
  },
  {
    path: '/newEquipment',
    name: 'newEquipment',
    component: () => import('../views/NewEquipmentView.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/newMaterial',
    name: 'NewMaterial',
    component: () => import('../views/NewMaterialView.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/newMonster',
    name: 'NewMonster',
    component: () => import('../views/NewMonsterView.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  // Catch-all route for 404 Not Found
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('../views/NotFoundView.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

import { watch } from 'vue'

// Navigation guard
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()

  // Wait until auth loading is finished
  if (authStore.isAuthLoading) {
    // Create a promise that resolves when isAuthLoading becomes false
    await new Promise((resolve) => {
      const unwatch = watch(
        () => authStore.isAuthLoading,
        (newVal) => {
          if (!newVal) {
            unwatch()
            resolve()
          }
        },
        { immediate: true }, // Check immediately in case it's already false
      )
    })
  }

  // Now proceed with navigation after auth is loaded
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth)
  const requiresAdmin = to.matched.some((record) => record.meta.requiresAdmin)

  if (requiresAuth && !authStore.token) {
    // If route requires auth and user is not authenticated
    next('/login')
  } else if (requiresAdmin && (!authStore.user || authStore.user.user_type !== 'admin')) {
    // If route requires admin and user is not admin
    next('/')
  } else {
    next()
  }
})

export default router
