<template>
  <div class="equipment-detail-container" v-if="equipment">
    <div class="equipment-info">
      <img :src="equipment.equipment_image" :alt="equipment.equipment_name" class="equipment-image">
      <h2>{{ equipment.equipment_name }}</h2>
      <div class="type-info">
        <span>{{ equipment.type.name }}</span>
      </div>
      <p class="description">{{ equipment.equipment_description }}</p>
    </div>

    <div class="materials-section">
      <h3>Required Materials</h3>
      <div class="materials-list">
        <router-link
          v-for="material in equipment.materials"
          :key="material.id"
          :to="`/material/${material.id}`"
          class="material-item"
        >
          <img :src="material.type.icon" :alt="material.name">
          <span>{{ material.name }}</span>
          <span class="quantity">x{{ material.required_quantity }}</span>
        </router-link>
      </div>
    </div>

    <div v-if="authStore.token" class="craft-section">
      <button @click="craftEquipment" :disabled="isCrafting" class="craft-button">
        {{ isCrafting ? 'Crafting...' : 'Craft Equipment' }}
      </button>

      <div v-if="craftResult" :class="['craft-result', craftResult.success ? 'success' : 'error']">
        <p>{{ craftResult.message }}</p>
        <ul v-if="!craftResult.success && craftResult.missing_materials">
          <li v-for="material in craftResult.missing_materials" :key="material.material_id">
            {{ material.material_name }}: Need {{ material.required }}, Have {{ material.has }}
            (Missing: {{ material.missing }})
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { equipmentService } from '@/services/api'

export default {
  setup() {
    const route = useRoute()
    const authStore = useAuthStore()
    const equipment = ref(null)
    const isCrafting = ref(false)
    const craftResult = ref(null)

    const fetchEquipment = async () => {
      try {
        const response = await equipmentService.getOne(route.params.id)
        equipment.value = response.data.data.equipment
      } catch (error) {
        console.error('Error fetching equipment:', error)
      }
    }

    const craftEquipment = async () => {
      isCrafting.value = true
      craftResult.value = null

      try {
        const response = await equipmentService.craft(equipment.value.equipment_id)
        craftResult.value = {
          success: true,
          message: response.data.message
        }
      } catch (error) {
        craftResult.value = {
          success: false,
          message: error.response.data.message,
          missing_materials: error.response.data.missing_materials
        }
      } finally {
        isCrafting.value = false
      }
    }

    onMounted(fetchEquipment)

    return {
      equipment,
      authStore,
      isCrafting,
      craftResult,
      craftEquipment
    }
  }
}
</script>

<style scoped>
.equipment-detail-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.equipment-info {
  text-align: center;
  margin-bottom: 30px;
}

.equipment-image {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 15px;
}

.type-info {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin: 10px 0;
}

.type-icon {
  width: 30px;
  height: 30px;
}

.materials-section {
  margin: 20px 0;
}

.materials-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 15px;
  margin-top: 15px;
}

.material-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  text-decoration: none; /* Add this */
  color: inherit; /* Add this */
  transition: transform 0.2s, box-shadow 0.2s; /* Add this */
}

.material-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.material-item img {
  width: 40px;
  height: 40px;
  object-fit: cover;
}

.quantity {
  margin-left: auto;
  font-weight: bold;
}

.craft-button {
  width: 100%;
  padding: 15px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1.1em;
  transition: background-color 0.2s;
}

.craft-button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

.craft-button:hover:not(:disabled) {
  background-color: #45a049;
}

.craft-result {
  margin-top: 20px;
  padding: 15px;
  border-radius: 5px;
}

.craft-result.success {
  background-color: #dff0d8;
  color: #3c763d;
  border: 1px solid #d6e9c6;
}

.craft-result.error {
  background-color: #f2dede;
  color: #a94442;
  border: 1px solid #ebccd1;
}

.craft-result ul {
  margin-top: 10px;
  padding-left: 20px;
}

.craft-result li {
  margin: 5px 0;
}
</style>
