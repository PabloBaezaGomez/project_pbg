<template>
  <!-- Shows the user all the materials with their images -->
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
import { ref, onMounted } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { materialService } from '@/services/api';

export default {
  setup() {
    const authStore = useAuthStore();
    const materials = ref([]);
    const userMaterials = ref({});
    const materialQuantities = ref({});
    const isAdding = ref(false);

    // Fetch all materials from the API
    const fetchMaterials = async () => {
      try {
        const response = await materialService.getAll();
        materials.value = response.data;
      } catch (error) {
        console.error('Error fetching materials:', error);
      }
    }

    // Fetch user materials quantities from the API
    const fetchUserMaterials = async () => {
      if (!authStore.token) return;

      try {
        const response = await materialService.getUserMaterials();
        const materialsData = response.data.data || response.data;
        userMaterials.value = materialsData.reduce((acc, material) => {
          acc[material.material_id] = material.pivot ? material.pivot.quantity : material.quantity;
          return acc;
        }, {})
      } catch (error) {
        console.error('Error fetching user materials:', error);
      }
    }

    // Function to add all materials with specified quantities
    const addAllMaterials = async () => {
      if (!authStore.token) return;

      const materialsToAdd = Object.entries(materialQuantities.value)
        .filter(([quantity]) => quantity > 0)
        .map(([materialId, quantity]) => ({
          material_id: parseInt(materialId),
          quantity: parseInt(quantity),
        }))

      if (materialsToAdd.length === 0) return;

      isAdding.value = true;
      try {
        await materialService.addMaterials(materialsToAdd);
        await fetchUserMaterials();
        materialQuantities.value = {};
      } catch (error) {
        console.error('Error adding materials:', error);
      } finally {
        isAdding.value = false;
      }
    }

    // Function to get the material type icon URL
    const getMaterialTypeIcon = (iconPath) => {
      return iconPath
        ? `http://localhost:8000/storage/${iconPath}`
        : '/img/default_material_type.png'
    }

    // Fetch materials and user materials when the component is mounted
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
  z-index: 10;
  margin-bottom: 1rem;
}

.add-all-button {
  width: 100%;
  padding: 1rem;
  background-color: var(--button);
  color: var(--textbutton);
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1.1em;
  transition: background-color 0.2s;
}

.add-all-button:disabled {
  background-color: var(--buttondisabled);
  cursor: not-allowed;
}

.add-all-button:hover:not(:disabled) {
  background-color: var(--buttonhover);
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
  border: 1px solid var(--bordercard);
  border-radius: 8px;
  padding: 15px;
  background-color: var(--backgroundcard);
  transition:
    transform 0.2s,
    box-shadow 0.2s;
  display: flex;
  flex-direction: column;
  align-items: center; 
  justify-content: center; 
  text-align: center; 
}

.material-link {
  text-decoration: none;
  color: inherit;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  align-items: center; 
}

.material-link:hover {
  background-color: #00000000;
  text-decoration: none;
}

.material-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 8px var(--shadowcolor);
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
  color: var(--accentcolor2);
  font-size: 0.9em;
  margin: 5px 0;
}

.material-rarity {
  color: var(--accentcolor);
  font-weight: bold;
  margin: 5px 0;
}

.material-description {
  font-size: 0.9em;
  margin: 10px 0;
  color: var(--accentcolor2);
}

.material-actions {
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid var(--bordercard);
}

.current-quantity {
  font-weight: bold;
  color: var(--accentcolor3);
  margin-bottom: 10px;
}

.add-material input {
  width: 100%;
  padding: 8px;
  border: 1px solid var(--inputborder);
  border-radius: 4px;
  margin-top: 5px;
}

@media (max-width: 768px) {
  .materials-grid {
    grid-template-columns: 1fr;
  }
}
</style>
