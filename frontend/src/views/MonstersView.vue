<template>
  <!-- Shows all the monsters with their icons and names -->
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
import { ref, onMounted } from 'vue';
import { foeService } from '@/services/api';

export default {
  setup() {
    const monsters = ref([]);

    // Fetch all monsters from the API
    const fetchMonsters = async () => {
      try {
        const response = await foeService.getAll()
        monsters.value = response.data.data
      } catch (error) {
        console.error('Error fetching monsters:', error)
      }
    }

    // Helper function to get the monster icon URL
    const getMonsterIcon = (iconPath) => {
      return iconPath ? `http://localhost:8000/storage/${iconPath}` : '/img/default_monster.png'
    }

    // Fetch monsters when the component is mounted
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
  background-color: var(--backgroundcard);
  border: 1px solid var(--bordercard);
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
  box-shadow: 0 4px 8px var(--shadowcolor);
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
  color: var(--accentcolor3);
  font-size: 0.9em;
  margin-top: 5px;
}

@media (max-width: 768px) {
  .monsters-grid {
    grid-template-columns: 1fr;
  }
}
</style>
