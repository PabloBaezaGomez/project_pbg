<template>
  <div class="new-monster-container">
    <h2>Create New Monster</h2>
    <form @submit.prevent="createMonster" class="monster-form">
      <div class="form-group">
        <label for="foe_name">Monster Name:</label>
        <input
          type="text"
          id="foe_name"
          v-model="monsterData.foe_name"
          required
          class="form-input"
        />
      </div>

      <div class="form-group">
        <label for="foe_type">Monster Type:</label>
        <select
          id="foe_type"
          v-model="monsterData.foe_type"
          required
          class="form-select"
        >
          <option value="">Select a type</option>
          <option
            v-for="type in foeTypes"
            :key="type.foe_type_id"
            :value="type.foe_type_id"
          >
            {{ type.foe_type_name }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="foe_size">Monster Size:</label>
        <select
          id="foe_size"
          v-model="monsterData.foe_size"
          required
          class="form-select"
        >
          <option value="">Select size</option>
          <option value="small">Small</option>
          <option value="big">Big</option>
        </select>
      </div>

      <div class="form-group">
        <label for="foe_icon">Monster Icon URL:</label>
        <input
          type="text"
          id="foe_icon"
          v-model="monsterData.foe_icon"
          required
          class="form-input"
        />
      </div>

      <div class="form-group">
        <label for="foe_image">Monster Image URL:</label>
        <input
          type="text"
          id="foe_image"
          v-model="monsterData.foe_image"
          required
          class="form-input"
        />
      </div>

      <div class="form-group">
        <label for="foe_description">Description:</label>
        <textarea
          id="foe_description"
          v-model="monsterData.foe_description"
          required
          class="form-textarea"
          rows="4"
        ></textarea>
      </div>

      <div class="materials-section">
        <h3>Material Drops</h3>
        <div
          v-for="(material, index) in materialDrops"
          :key="index"
          class="material-drop"
        >
          <div class="form-group">
            <label>Material:</label>
            <select
              v-model="material.material_id"
              class="form-select"
              @change="checkAddNewMaterial"
            >
              <option value="">Select a material</option>
              <option
                v-for="mat in materials"
                :key="mat.material_id"
                :value="mat.material_id"
              >
                {{ mat.material_name }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <label>Drop Rate (%):</label>
            <input
              type="number"
              v-model="material.drop_rate"
              min="0"
              max="100"
              step="0.01"
              class="form-input"
              @input="checkAddNewMaterial"
            />
          </div>
          <button
            v-if="materialDrops.length > 1"
            type="button"
            @click="removeMaterial(index)"
            class="remove-btn"
          >
            Remove
          </button>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="submit-btn" :disabled="isSubmitting">
          {{ isSubmitting ? 'Creating...' : 'Create Monster' }}
        </button>
        <router-link to="/monsters" class="cancel-btn">Cancel</router-link>
      </div>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { foeService, materialService } from '@/services/api'

export default {
  setup() {
    const router = useRouter()
    const isSubmitting = ref(false)
    
    const monsterData = ref({
      foe_name: '',
      foe_type: '',
      foe_size: '',
      foe_description: '',
      foe_icon: '',
      foe_image: ''
    })
    
    const foeTypes = ref([])
    const materials = ref([])
    const materialDrops = ref([{ material_id: '', drop_rate: '' }])

    const fetchFoeTypes = async () => {
      try {
        const response = await foeService.getTypes()
        foeTypes.value = response.data.data
      } catch (error) {
        console.error('Error fetching foe types:', error)
      }
    }

    const fetchMaterials = async () => {
      try {
        const response = await materialService.getAll()
        materials.value = response.data
      } catch (error) {
        console.error('Error fetching materials:', error)
      }
    }

    const checkAddNewMaterial = () => {
      const lastMaterial = materialDrops.value[materialDrops.value.length - 1]
      if (lastMaterial.material_id && lastMaterial.drop_rate) {
        materialDrops.value.push({ material_id: '', drop_rate: '' })
      }
    }

    const removeMaterial = (index) => {
      materialDrops.value.splice(index, 1)
    }

    const createMonster = async () => {
      isSubmitting.value = true
      try {
        const filteredMaterials = materialDrops.value.filter(
          material => material.material_id && material.drop_rate
        )
        
        const payload = {
          ...monsterData.value,
          materials: filteredMaterials
        }
        
        await foeService.create(payload)
        router.push('/monsters')
      } catch (error) {
        console.error('Error creating monster:', error)
        alert('Error creating monster. Please try again.')
      } finally {
        isSubmitting.value = false
      }
    }

    onMounted(() => {
      fetchFoeTypes()
      fetchMaterials()
    })

    return {
      monsterData,
      foeTypes,
      materials,
      materialDrops,
      isSubmitting,
      createMonster,
      checkAddNewMaterial,
      removeMaterial
    }
  }
}
</script>

<style scoped>
.new-monster-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.monster-form {
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
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
}

.form-textarea {
  resize: vertical;
}

.materials-section {
  margin: 30px 0;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  border: 1px solid #ddd;
}

.material-drop {
  display: grid;
  grid-template-columns: 1fr 1fr auto;
  gap: 15px;
  align-items: end;
  margin-bottom: 15px;
  padding: 15px;
  background: #f5f5f5;
  border-radius: 4px;
}

.remove-btn {
  background: #dc3545;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 4px;
  cursor: pointer;
  height: fit-content;
}

.remove-btn:hover {
  background: #c82333;
}

.form-actions {
  display: flex;
  gap: 15px;
  margin-top: 30px;
}

.submit-btn {
  background: #007bff;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

.submit-btn:hover:not(:disabled) {
  background: #0056b3;
}

.submit-btn:disabled {
  background: #6c757d;
  cursor: not-allowed;
}

.cancel-btn {
  background: #6c757d;
  color: white;
  text-decoration: none;
  padding: 12px 24px;
  border-radius: 4px;
  display: inline-block;
}

.cancel-btn:hover {
  background: #545b62;
}
</style>