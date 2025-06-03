<template>
  <div class="material-detail-container" v-if="material">
    <div class="material-info">
      <img :src="getMaterialTypeIcon(material.type.icon)" :alt="material.material_name" class="material-image" />
      <h2>{{ material.material_name }}</h2>
      <div class="type-info">
        <span>{{ material.type.name }}</span>
      </div>
      <p class="rarity">Rarity: {{ material.material_rarity }}</p>
      <p class="description">{{ material.material_description }}</p>
    </div>

    <!-- Add Monsters Section -->
    <div class="monsters-section" v-if="material.foes && material.foes.length > 0">
      <h3>Dropped by Monsters</h3>
      <div class="monsters-list">
        <router-link
          v-for="foe in material.foes"
          :key="foe.id"
          :to="`/monster/${foe.id}`"
          class="monster-item"
        >
          <img :src="getMonsterIcon(foe.icon)" :alt="foe.foe_name" class="monster-icon" />
          <div class="monster-info">
            <span class="monster-name">{{ foe.name }}</span>
            <span class="drop-rate">Drop Rate: {{ foe.drop_rate }}%</span>
          </div>
        </router-link>
      </div>
    </div>

    <!-- Add Equipment Section -->
    <div class="equipment-section">
      <h3>Used in Equipment</h3>
      <div class="equipment-list">
        <router-link
          v-for="equip in material.equipment"
          :key="equip.id"
          :to="`/equipment/${equip.id}`"
          class="equipment-item"
        >
          <img :src="getEquipmentTypeIcon(equip.type.icon)" :alt="equip.name" class="equipment-icon" />
          <div class="equipment-info">
            <span class="equipment-name">{{ equip.name }}</span>
            <span class="required-quantity">Required: {{ equip.required_quantity }}</span>
          </div>
        </router-link>
      </div>
    </div>

    <div v-if="authStore.token" class="user-material-section">
      <h3>Your Inventory</h3>
      <div class="quantity-control">
        <div class="quantity-display">
          <span class="quantity-label">Current:</span>
          <span class="quantity-value">{{ userQuantity }}</span>
        </div>
        <div class="quantity-update">
          <input type="number" v-model="quantityToAdd" min="1" placeholder="Amount to add" />
          <button @click="addMaterial" :disabled="isAdding" class="add-button">
            {{ isAdding ? 'Updating...' : 'Update Quantity' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { materialService } from '@/services/api'

export default {
  setup() {
    const route = useRoute()
    const authStore = useAuthStore()
    const material = ref(null)
    const userQuantity = ref(0)
    const quantityToAdd = ref(1)
    const isAdding = ref(false)

    const fetchMaterial = async () => {
      try {
        const response = await materialService.getOne(route.params.id)
        material.value = {
          material_id: response.data.data.material.id,
          material_name: response.data.data.material.name,
          material_description: response.data.data.material.description,
          material_rarity: response.data.data.material.rarity,
          type: {
            id: response.data.data.material.type.id,
            name: response.data.data.material.type.name,
            icon: response.data.data.material.type.icon,
          },
          foes: response.data.data.material.foes,
          equipment: response.data.data.material.equipment
        }
      } catch (error) {
        console.error('Error fetching material:', error)
      }
    }

    const fetchUserMaterial = async () => {
      if (!authStore.token) return
      try {
        const response = await materialService.getUserMaterials()
        const userMaterial = response.data.data.find(
          (m) => m.material_id === parseInt(route.params.id),
        )
        userQuantity.value = userMaterial ? userMaterial.quantity : 0
      } catch (error) {
        console.error('Error fetching user material:', error)
      }
    }

    const addMaterial = async () => {
      if (!authStore.token || quantityToAdd.value < 1) return

      isAdding.value = true
      try {
        await materialService.addMaterials([
          {
            material_id: parseInt(route.params.id),
            quantity: parseInt(quantityToAdd.value),
          },
        ])
        await fetchUserMaterial()
        quantityToAdd.value = 1
      } catch (error) {
        console.error('Error adding material:', error)
      } finally {
        isAdding.value = false
      }
    }

    const getMaterialTypeIcon = (iconPath) => {
      return iconPath ? `http://localhost:8000/storage/${iconPath}` : '/img/default_material_type.png'
    }

    const getMonsterIcon = (iconPath) => {
      return iconPath ? `http://localhost:8000/storage/${iconPath}` : '/img/default_monster.png'
    }

    const getEquipmentTypeIcon = (iconPath) => {
      return iconPath ? `http://localhost:8000/storage/${iconPath}` : '/img/default_equipment_type.png'
    }

    onMounted(() => {
      fetchMaterial()
      if (authStore.token) {
        fetchUserMaterial()
      }
    })

    return {
      material,
      userQuantity,
      quantityToAdd,
      isAdding,
      authStore,
      addMaterial,
      getMaterialTypeIcon,
      getMonsterIcon,
      getEquipmentTypeIcon
    }
  },
}
</script>

<style scoped>
.material-detail-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.material-info {
  text-align: center;
  margin-bottom: 30px;
}

.material-image {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 15px;
}

.type-info {
  margin: 10px 0;
  color: var(--accentcolor3);
}

.rarity {
  color: var(--accentcolor);
  font-weight: bold;
  margin: 10px 0;
}

.description {
  margin: 15px 0;
  color: var(--accentcolor2);
}

.user-material-section {
  margin-top: 30px;
  padding: 20px;
  border: 1px solid var(--color-border);
  border-radius: 8px;
}

.quantity {
  font-size: 1.2em;
  margin: 15px 0;
}

.add-material {
  display: flex;
  gap: 10px;
  margin-top: 15px;
}

.add-material input {
  flex: 1;
  padding: 8px;
  border: 1px solid var(--color-border);
  border-radius: 4px;
}

.add-button {
  padding: 8px 20px;
  background-color: var(--button);
  color: var(--textbutton);
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.add-button:disabled {
  background-color: var(--buttondisabled);
  cursor: not-allowed;
}

.add-button:hover:not(:disabled) {
  background-color: var(--buttonhover);
}

/* Add these new styles */
.quantity-control {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-top: 20px;
}

.quantity-display {
  display: flex;
  align-items: center;
  gap: 10px;
}

.quantity-label {
  font-weight: bold;
}

.quantity-value {
  font-size: 1.2em;
  color: #2c3e50;
  font-weight: bold;
}

.quantity-update {
  display: flex;
  gap: 10px;
}

/* Keep existing styles and add any additional ones needed */
.monsters-section,
.equipment-section {
  margin-top: 30px;
  padding: 20px;
  border: 1px solid var(--color-border);
  border-radius: 8px;
}

.monsters-list,
.equipment-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
  margin-top: 15px;
}

.monster-item,
.equipment-item {
  display: flex;
  align-items: center;
  padding: 10px;
  border: 1px solid var(--color-border);
  border-radius: 6px;
  text-decoration: none;
  color: inherit;
  transition: transform 0.2s, box-shadow 0.2s;
}

.monster-item:hover,
.equipment-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px var(--shadowcolor);
}

.monster-icon,
.equipment-icon {
  width: 40px;
  height: 40px;
  object-fit: cover;
  border-radius: 4px;
  margin-right: 12px;
}

.monster-info,
.equipment-info {
  display: flex;
  flex-direction: column;
}

.monster-name,
.equipment-name {
  font-weight: bold;
  margin-bottom: 4px;
}

.drop-rate,
.required-quantity {
  font-size: 0.9em;
  color: var(--accentcolor3);
}
</style>
