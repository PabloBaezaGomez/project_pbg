import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
})

// Add request interceptor to include auth token
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

export const authService = {
  login: (credentials) => api.post('/login', credentials),
  register: (userData) => api.post('/register', userData),
  logout: () => api.post('/logout'),
  getCurrentUser: () => api.get('/user')
}

export const equipmentService = {
  getAll: () => api.get('/equipment'),
  getUserEquipment: () => api.get('/user/equipment'),
  getOne: (id) => api.get(`/equipment/${id}`),
  craft: (equipmentId) => api.post('/equipment/craft', { equipment_id: equipmentId }),
}

export const materialService = {
  getAll: () => api.get('/materials'),
  getUserMaterials: () => api.get('/user/materials'),
  getOne: (id) => api.get(`/materials/${id}`),
  addMaterials: (materials) =>
    api.post('/materials/add', {
      materials: materials.map((m) => ({ material_id: m.material_id, amount: m.quantity })),
    }),
}

export const foeService = {
  getAll: () => api.get('/foes'),
  getOne: (id) => api.get(`/foes/${id}`),
  getMaterials: (id) => api.get(`/foes/${id}/materials`),
}

export default api
