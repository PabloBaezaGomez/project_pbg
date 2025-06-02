<template>
  <div class="monster-detail-container" v-if="monster">
    <div class="monster-info">
      <img :src=getMonsterImage(monster.foe.foe_image) :alt="monster.foe.foe_name" class="monster-image">
      <h2>{{ monster.foe.foe_name }}</h2>
      <div class="monster-type">
        <span>Type: {{ monster.foe.type.foe_type_name }}</span>
      </div>
      <p class="monster-size">Size: {{ monster.foe.foe_size }}</p>
      <p>Description:</p>
      <p class="description">{{ monster.foe.foe_description }}</p>
    </div>

    <div class="materials-section">
      <h3>Droppable Materials</h3>
      <div class="materials-list">
        <router-link
          v-for="material in monster.materials"
          :key="material.material_id"
          :to="`/material/${material.material_id}`"
          class="material-item"
        >
          <img :src=getMaterialTypeIcon(material.type.material_type_icon) :alt="material.material_name">
          <div class="material-info">
            <span class="material-name">{{ material.material_name }}</span>
            <span class="material-rarity">Rarity: {{ material.material_rarity }}</span>
          </div>
          <span class="drop-rate">Drop Rate: {{ material.pivot.drop_rate }}%</span>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { foeService } from '@/services/api'

export default {
  setup() {
    const route = useRoute()
    const monster = ref(null)

    const fetchMonster = async () => {
      try {
        const response = await foeService.getOne(route.params.id)
        monster.value = response.data.data // Store the entire data object
      } catch (error) {
        console.error('Error fetching monster:', error)
      }
    }

    onMounted(fetchMonster)

    return {
      monster,
      getMonsterImage: (imagePath) => {
        return `http://localhost:8000/storage/${imagePath}`
      },
      getMaterialTypeIcon: (iconPath) => {
        return iconPath ? `http://localhost:8000/storage/${iconPath}` : '/img/default_material.png'
      }
    }
  }
}
</script>

<style scoped>
.monster-detail-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.monster-info {
  text-align: center;
  margin-bottom: 30px;
}

.monster-image {
  width: 50%;
  height: 50%;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 15px;
}

.monster-level {
  font-size: 1.2em;
  color: #666;
  margin: 10px 0;
}

.description {
  margin: 20px 0;
  line-height: 1.6;
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

.drop-rate {
  margin-left: auto;
  color: #4CAF50;
  font-weight: bold;
}

.monster-type {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin: 10px 0;
  font-size: 1.1em;
  color: #444;
}

.monster-size {
  font-size: 1.1em;
  color: #666;
  margin: 10px 0;
}

.material-info {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.material-name {
  font-weight: bold;
}

.material-rarity {
  font-size: 0.9em;
  color: #666;
}
</style>
