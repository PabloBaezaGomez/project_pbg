<template>
  <div class="monsters-container">
    <div class="monsters-grid">
      <router-link 
        v-for="monster in monsters" 
        :key="monster.foe_id" 
        :to="`/monster/${monster.foe_id}`"
        class="monster-card"
      >
        <img :src=getMonsterIcon(monster.foe_icon) :alt="monster.foe_name">
        <h3>{{ monster.foe_name }}</h3>
        <p class="type-name">{{ monster.type.foe_type_name }}</p>
      </router-link>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { foeService } from '@/services/api'

export default {
  setup() {
    const monsters = ref([])

    const fetchMonsters = async () => {
      try {
        const response = await foeService.getAll()
        monsters.value = response.data.data
      } catch (error) {
        console.error('Error fetching monsters:', error)
      }
    }

    // Función para construir la URL de la imagen
    const getMonsterIcon = (iconPath) => {
      return iconPath ? `http://localhost:8000/storage/${iconPath}` : '/img/default_monster.png'
    }

    onMounted(fetchMonsters)

    return {
      monsters,
      getMonsterIcon
    }
  }
}
</script>

<style scoped>
.monsters-container {
  padding: 20px;
}

.monsters-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.monster-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 15px;
  text-align: center;
  text-decoration: none;
  color: inherit;
  transition: transform 0.2s, box-shadow 0.2s;
  display: block;
}

.monster-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.monster-card img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  margin-bottom: 10px;
}

.monster-card h3 {
  margin: 10px 0;
  font-size: 1.2em;
}

.type-name {
  color: #666;
  font-size: 0.9em;
  margin-top: 5px;
}
</style>