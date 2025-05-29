import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  {
    path: '/',
    redirect: '/monsters'
  },
  {
    path: '/dashboard',
    redirect: '/monsters'
  },
  // Add more routes as needed
  {
    path: '/monsters',
    name: 'Monsters',
    component: () => import('../views/MonstersView.vue')
  },
  {
    path: '/equipments',
    name: 'Equipments',
    component: () => import('../views/EquipmentsView.vue')
  },
  {
    path: '/UserEquipments',
    name: 'UserEquipments',
    component: () => import('../views/UserEquipmentsView.vue')
  },
  {
    path: '/materials',
    name: 'Materials',
    component: () => import('../views/MaterialsView.vue')
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/LoginView.vue')
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/RegisterView.vue')
  },
  {
    path: '/logout',
    name: 'Logout',
    component: () => import('../views/LogoutView.vue')
  },
  {
    path: '/monster/:id',
    name: 'Monster',
    component: () => import('../views/MonsterView.vue')
  },
  {
    path: '/equipment/:id',
    name: 'Equipment',
    component: () => import('../views/EquipmentView.vue')
  },
  {
    path: '/material/:id',
    name: 'Material',
    component: () => import('../views/MaterialView.vue')
  },
  {
    path: '/craftEquipment',
    name: 'CraftEquipment',
    component: () => import('../views/CraftEquipmentView.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/addMaterial',
    name: 'AddMaterial',
    component: () => import('../views/AddMaterialView.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/newEquipment',
    name: 'NewEquipment',
    component: () => import('../views/NewEquipmentView.vue'),
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/newMaterial',
    name: 'NewMaterial',
    component: () => import('../views/NewMaterialView.vue'),
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/newMonster',
    name: 'NewMonster',
    component: () => import('../views/NewMonsterView.vue'),
    meta: { requiresAuth: true, requiresAdmin: true }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Navigation guard
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
  const requiresAdmin = to.matched.some(record => record.meta.requiresAdmin)

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
