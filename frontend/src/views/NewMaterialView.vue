<template>
  <div class="new-material-container">
    <h2>Create New Material</h2>
    <form @submit.prevent="createMaterial" class="material-form">
      <div class="form-group">
        <label for="material_name">Material Name:</label>
        <input
          type="text"
          id="material_name"
          v-model="materialData.material_name"
          required
          class="form-input"
        />
      </div>

      <div class="form-group">
        <label for="material_type">Material Type:</label>
        <select
          id="material_type"
          v-model="materialData.material_type"
          required
          class="form-select"
        >
          <option value="">Select a type</option>
          <option
            v-for="type in materialTypes"
            :key="type.material_type_id"
            :value="type.material_type_id"
          >
            {{ type.material_type_name }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="material_description">Description:</label>
        <textarea
          id="material_description"
          v-model="materialData.material_description"
          required
          class="form-textarea"
          rows="4"
        ></textarea>
      </div>

      <div class="form-group">
        <label for="material_rarity">Rarity (1-9):</label>
        <input
          type="number"
          id="material_rarity"
          v-model="materialData.material_rarity"
          min="1"
          max="9"
          required
          class="form-input"
        />
      </div>

      <div class="monster-drops-section">
        <h3>Monster Drops (Optional)</h3>
        <div
          v-for="(monster, index) in monsterDrops"
          :key="index"
          class="monster-drop"
        >
          <div class="form-group">
            <label>Monster:</label>
            <select
              v-model="monster.monster_id"
              class="form-select"
              @change="checkAddNewMonster"
            >
              <option value="">Select a monster</option>
              <option
                v-for="mon in monsters"
                :key="mon.foe_id"
                :value="mon.foe_id"
              >
                {{ mon.foe_name }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <label>Drop Rate (%):</label>
            <input
              type="number"
              v-model="monster.drop_rate"
              min="0"
              max="100"
              step="0.01"
              class="form-input"
              @input="checkAddNewMonster"
            />
          </div>
          <button
            v-if="monsterDrops.length > 1"
            type="button"
            @click="removeMonster(index)"
            class="remove-btn"
          >
            Remove
          </button>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="submit-btn" :disabled="isSubmitting">
          {{ isSubmitting ? 'Creating...' : 'Create Material' }}
        </button>
        <router-link to="/materials" class="cancel-btn">Cancel</router-link>
      </div>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { materialService, foeService } from '@/services/api'

export default {
  name: 'NewMaterialView',
  setup() {
    const router = useRouter()
    const materialTypes = ref([])
    const monsters = ref([])
    const isSubmitting = ref(false)

    const materialData = ref({
      material_name: '',
      material_type: '',
      material_description: '',
      material_rarity: 1
    })

    const monsterDrops = ref([{ monster_id: '', drop_rate: '' }])

    const fetchMaterialTypes = async () => {
        try {
            const response = await materialService.getMaterialTypes()
            materialTypes.value = response.data.data
        } catch (error) {
            console.error('Error fetching material types:', error)
        }
    }

    const fetchMonsters = async () => {
      try {
        const response = await foeService.getAll()
        monsters.value = response.data.data
      } catch (error) {
        console.error('Error fetching monsters:', error)
      }
    }

    const checkAddNewMonster = () => {
      const lastMonster = monsterDrops.value[monsterDrops.value.length - 1]
      if (lastMonster.monster_id && lastMonster.drop_rate) {
        monsterDrops.value.push({ monster_id: '', drop_rate: '' })
      }
    }

    const removeMonster = (index) => {
      monsterDrops.value.splice(index, 1)
    }

    const createMaterial = async () => {
      try {
        isSubmitting.value = true

        const filteredMonsters = monsterDrops.value.filter(
          monster => monster.monster_id && monster.drop_rate
        )

        const materialPayload = {
          material_name: materialData.value.material_name,
          material_type: materialData.value.material_type,
          material_description: materialData.value.material_description,
          material_rarity: parseInt(materialData.value.material_rarity),
          foes: filteredMonsters.map(monster => ({
            foe_id: monster.monster_id,
            drop_rate: parseFloat(monster.drop_rate)
          }))
        }

        const response = await materialService.create(materialPayload)
        if (response.data.success) {
          router.push('/materials')
        }
      } catch (error) {
        console.error('Error creating material:', error)
      } finally {
        isSubmitting.value = false;
        router.push('/materials');
      }
    }

    onMounted(() => {
      fetchMaterialTypes()
      fetchMonsters()
    })

    return {
      materialData,
      materialTypes,
      monsters,
      monsterDrops,
      isSubmitting,
      createMaterial,
      checkAddNewMonster,
      removeMonster
    }
  }
}
</script>

<style scoped>
.new-material-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.material-form {
  background: #f9f9f9;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #333;
}

.form-input,
.form-select,
.form-textarea {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.form-textarea {
  resize: vertical;
}

.monster-drops-section {
  margin-top: 30px;
}

.monster-drop {
  display: grid;
  grid-template-columns: 1fr 1fr auto;
  gap: 15px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 4px;
  margin-bottom: 15px;
}

.remove-btn {
  background-color: #dc3545;
  color: white;
  border: none;
  padding: 8px 15px;
  border-radius: 4px;
  cursor: pointer;
  align-self: flex-end;
}

.form-actions {
  margin-top: 30px;
  display: flex;
  gap: 15px;
}

.submit-btn,
.cancel-btn {
  padding: 10px 20px;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  text-decoration: none;
}

.submit-btn {
  background-color: #45a049;
  color: white;
  border: none;
}

.submit-btn:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

.cancel-btn {
  background-color: #6c757d;
  color: white;
  border: none;
}
</style>
