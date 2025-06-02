<template>
  <div class="materials-container">
    <div v-if="authStore.token" class="sticky-header">
      <button @click="addAllMaterials" :disabled="isAdding" class="add-all-button">
        {{ isAdding ? 'Adding materials...' : 'Add All Materials' }}
      </button>
    </div>

    <div class="materials-grid">
      <div v-for="material in materials" :key="material.material_id" class="material-card">
        <router-link :to="`/material/${material.material_id}`" class="material-link">
          <img :src="getMaterialTypeIcon(material.type.icon)" :alt="material.material_name" />
          <h3>{{ material.material_name }}</h3>
          <p class="material-type">{{ material.type.name }}</p>
          <p class="material-rarity">Rarity: {{ material.material_rarity }}</p>
          <p class="material-description">{{ material.material_description }}</p>
        </router-link>

        <div v-if="authStore.token" class="material-actions">
          <p class="current-quantity" v-if="userMaterials[material.material_id]">
            Current: {{ userMaterials[material.material_id] }}
          </p>
          <div class="add-material">
            <input
              type="number"
              v-model="materialQuantities[material.material_id]"
              min="1"
              placeholder="Quantity"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { materialService } from '@/services/api'

export default {
  setup() {
    const authStore = useAuthStore()
    const materials = ref([])
    const userMaterials = ref({})
    const materialQuantities = ref({})
    const isAdding = ref(false)

    const fetchMaterials = async () => {
      try {
        const response = await materialService.getAll()
        materials.value = response.data
      } catch (error) {
        console.error('Error fetching materials:', error)
      }
    }

    const fetchUserMaterials = async () => {
      if (!authStore.token) return

      try {
        const response = await materialService.getUserMaterials()
        const materialsData = response.data.data || response.data
        userMaterials.value = materialsData.reduce((acc, material) => {
          acc[material.material_id] = material.pivot ? material.pivot.quantity : material.quantity
          return acc
        }, {})
      } catch (error) {
        console.error('Error fetching user materials:', error)
      }
    }

    const addAllMaterials = async () => {
      if (!authStore.token) return

      const materialsToAdd = Object.entries(materialQuantities.value)
        .filter(([_, quantity]) => quantity > 0)
        .map(([materialId, quantity]) => ({
          material_id: parseInt(materialId),
          quantity: parseInt(quantity),
        }))

      if (materialsToAdd.length === 0) return

      isAdding.value = true
      try {
        await materialService.addMaterials(materialsToAdd)
        await fetchUserMaterials()
        materialQuantities.value = {}
      } catch (error) {
        console.error('Error adding materials:', error)
      } finally {
        isAdding.value = false
      }
    }

    const getMaterialTypeIcon = (iconPath) => {
      return iconPath
        ? `http://localhost:8000/storage/${iconPath}`
        : '/img/default_material_type.png'
    }

    onMounted(() => {
      fetchMaterials()
      if (authStore.token) {
        fetchUserMaterials()
      }
    })

    return {
      materials,
      userMaterials,
      materialQuantities,
      isAdding,
      authStore,
      addAllMaterials,
      getMaterialTypeIcon,
    }
  },
}
</script>

<style scoped>
.materials-container {
  padding: 20px;
}

.sticky-header {
  position: sticky;
  top: 0;
  background-color: white;
  padding: 1rem;
  z-index: 10;
  border-bottom: 1px solid var(--color-border);
  margin-bottom: 1rem;
}

.add-all-button {
  width: 100%;
  padding: 1rem;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1.1em;
  transition: background-color 0.2s;
}

.add-all-button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

.add-all-button:hover:not(:disabled) {
  background-color: #45a049;
}

.materials-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

@media (max-width: 768px) {
  .materials-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 480px) {
  .materials-grid {
    grid-template-columns: 1fr;
  }
}

.material-card {
  border: 1px solid var(--color-border);
  border-radius: 8px;
  padding: 15px;
  background-color: white;
  transition:
    transform 0.2s,
    box-shadow 0.2s;
  display: flex;
  flex-direction: column;
  align-items: center; /* Centra horizontalmente los elementos */
  justify-content: center; /* Centra verticalmente los elementos */
  text-align: center; /* Centra el texto */
}

.material-link {
  text-decoration: none;
  color: inherit;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  align-items: center; /* Centra el contenido del link */
}

.material-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.material-card img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  margin-bottom: 10px;
}

.material-card h3 {
  margin: 10px 0;
  font-size: 1.2em;
}

.material-type {
  color: #666;
  font-size: 0.9em;
  margin: 5px 0;
}

.material-rarity {
  color: #45a049;
  font-weight: bold;
  margin: 5px 0;
}

.material-description {
  font-size: 0.9em;
  margin: 10px 0;
  color: #666;
}

.material-actions {
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid var(--color-border);
}

.current-quantity {
  font-weight: bold;
  color: #2c3e50;
  margin-bottom: 10px;
}

.add-material input {
  width: 100%;
  padding: 8px;
  border: 1px solid var(--color-border);
  border-radius: 4px;
  margin-top: 5px;
}

@media (max-width: 768px) {
  .materials-grid {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  }
}
</style>
