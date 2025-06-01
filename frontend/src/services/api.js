import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    Accept: 'application/json',
  },
})

// Add request interceptor to include auth token and handle content type
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  // Only set Content-Type to application/json if it's not already defined
  // This prevents overriding 'multipart/form-data' for file uploads
  if (!config.headers['Content-Type'] && !config.headers['content-type']) {
    config.headers['Content-Type'] = 'application/json'
  }

  return config
})

export const authService = {
  login: (credentials) => api.post('/login', credentials),
  register: (userData) => api.post('/register', userData),
  logout: () => api.post('/logout'),
  getCurrentUser: () => api.get('/user'),
}

export const equipmentService = {
  getAll: () => api.get('/equipment'),
  getUserEquipment: () => api.get('/user/equipment'),
  getOne: (id) => api.get(`/equipment/${id}`),
  craft: (equipmentId) => api.post('/equipment/craft', { equipment_id: equipmentId }),
  getTypes: () => api.get('/equipment-types'),
  async create(formData) {
    const response = await api.post('/equipment', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })
    return response
  },
}

export const materialService = {
  getAll: () => api.get('/materials'),
  getUserMaterials: () => api.get('/user/materials'),
  getOne: (id) => api.get(`/materials/${id}`),
  addMaterials: (materials) =>
    api.post('/materials/add', {
      materials: materials.map((m) => ({ material_id: m.material_id, amount: m.quantity })),
    }),
  getMaterialTypes: () => api.get('/material-types'),
  create: (materialData) => api.post('/materials', materialData),
}

export const foeService = {
  getAll: () => api.get('/foes'),
  getOne: (id) => api.get(`/foes/${id}`),
  getMaterials: (id) => api.get(`/foes/${id}/materials`),
  getTypes: () => api.get('/foe-types'),
  async create(formData) {
    const response = await api.post('/foes', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })
    return response
  },
}

export default api
