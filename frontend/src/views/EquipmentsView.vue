<template>
  <!-- This page shows all the equipments in the database, with the icon of the type of weapon -->
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
import { ref, onMounted } from 'vue';
import { equipmentService } from '@/services/api';

export default {
  setup() {
    const equipments = ref([]);

    // Fetch all equipments from the API
    // and store them in the equipments ref
    const fetchEquipments = async () => {
      try {
        const response = await equipmentService.getAll();
        equipments.value = response.data;
      } catch (error) {
        console.error('Error fetching equipments:', error);
      }
    }

    // Builds the URL for the equipment icon
    const getEquipmentIcon = (iconPath) => {
      return `http://localhost:8000/storage/${iconPath}`;
    }

    // Fetch equipments when the component is mounted
    onMounted(fetchEquipments);

    return {
      equipments,
      getEquipmentIcon
    }
  }
}
</script>

<style scoped>
/* The styling of the component */
.equipments-container {
  padding: 20px;
}

.equipments-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

/**All the variables are in base.css */
.equipment-card {
  background-color: var(--backgroundcard);
  border: 1px solid var(--bordercolor);
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
  box-shadow: 0 4px 8px var(--shadowcolor);
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
  color: var(--text);
  font-size: 0.9em;
}

@media (max-width: 768px) {
  .equipments-grid {
    grid-template-columns: 1fr;
  }
}
</style>
