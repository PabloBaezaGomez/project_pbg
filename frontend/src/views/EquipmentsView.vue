<template>
  <div class="equipments-container">
    <div class="equipments-grid">
      <router-link 
        v-for="equipment in equipments" 
        :key="equipment.equipment_id" 
        :to="`/equipment/${equipment.equipment_id}`"
        class="equipment-card"
      >
        <img :src="getEquipmentIcon(equipment.type.icon)" :alt="equipment.equipment_name">
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

    const fetchEquipments = async () => {
      try {
        const response = await equipmentService.getAll()
        equipments.value = response.data
      } catch (error) {
        console.error('Error fetching equipments:', error)
      }
    }

    const getEquipmentIcon = (iconPath) => {
      return iconPath ? `http://localhost:8000/storage/${iconPath}` : '/img/default_equipment.png'
    }

    onMounted(fetchEquipments)

    return {
      equipments,
      getEquipmentIcon
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

.equipment-card img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  margin-bottom: 10px;
}

.equipment-card h3 {
  margin: 10px 0;
  font-size: 1.2em;
}

.type-name {
  color: #666;
  font-size: 0.9em;
}
</style>