<template>
  <div class="equipments-container">
    <h2>Your Equipment</h2>
    <div class="equipments-grid">
      <router-link 
        v-for="equipment in equipments" 
        :key="equipment.equipment_id" 
        :to="`/equipment/${equipment.equipment_id}`"
        class="equipment-card"
      >
        <img :src="equipment.type.icon" :alt="equipment.equipment_name">
        <h3>{{ equipment.equipment_name }}</h3>
        <p class="type-name">{{ equipment.type.name }}</p>
      </router-link>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { equipmentService } from '@/services/api'

export default {
  setup() {
    const equipments = ref([])

    const fetchUserEquipments = async () => {
      try {
        const response = await equipmentService.getUserEquipment()
        // If API returns { success, data }, use response.data.data
        equipments.value = response.data.data || response.data
      } catch (error) {
        console.error('Error fetching user equipment:', error)
      }
    }

    onMounted(fetchUserEquipments)

    return {
      equipments
    }
  }
}
</script>

<style scoped>
.equipments-container {
  padding: 20px;
}
.equipments-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}
.equipment-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 15px;
  text-align: center;
  text-decoration: none;
  color: inherit;
  transition: transform 0.2s, box-shadow 0.2s;
  display: block;
}
.equipment-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.type-name {
  color: #888;
  font-size: 0.9em;
}
</style>