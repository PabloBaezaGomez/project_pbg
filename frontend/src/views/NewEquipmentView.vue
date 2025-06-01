<template>
  <div class="new-equipment-container">
    <h2>Create New Equipment</h2>
    <form @submit.prevent="createEquipment" class="equipment-form" enctype="multipart/form-data">
      <div class="form-group">
        <label for="equipment_name">Equipment Name:</label>
        <input
          type="text"
          id="equipment_name"
          v-model="equipmentData.equipment_name"
          required
          class="form-input"
        />
      </div>

      <div class="form-group">
        <label for="equipment_type">Equipment Type:</label>
        <select
          id="equipment_type"
          v-model="equipmentData.equipment_type"
          required
          class="form-select"
        >
          <option value="">Select a type</option>
          <option
            v-for="type in equipmentTypes"
            :key="type.equipment_type_id"
            :value="type.equipment_type_id"
          >
            {{ type.equipment_type_name }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="equipment_stat">Equipment Stat:</label>
        <input
          type="number"
          id="equipment_stat"
          v-model="equipmentData.equipment_stat"
          required
          min="1"
          class="form-input"
        />
      </div>

      <div class="form-group">
        <label for="equipment_image">Equipment Image:</label>
        <input
          type="file"
          id="equipment_image"
          @change="handleImageUpload"
          accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml"
          required
          class="form-input file-input"
        />
        <div v-if="imagePreview" class="image-preview">
          <img :src="imagePreview" alt="Image preview" class="preview-image" />
        </div>
      </div>

      <div class="form-group">
        <label for="equipment_description">Description:</label>
        <textarea
          id="equipment_description"
          v-model="equipmentData.equipment_description"
          required
          class="form-textarea"
          rows="4"
        ></textarea>
      </div>

      <div class="materials-section">
        <h3>Required Materials</h3>
        <div
          v-for="(material, index) in materialRequirements"
          :key="index"
          class="material-requirement"
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
            <label>Required Quantity:</label>
            <input
              type="number"
              v-model="material.quantity"
              min="1"
              class="form-input"
              @input="checkAddNewMaterial"
            />
          </div>
          <button
            v-if="materialRequirements.length > 1"
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
          {{ isSubmitting ? 'Creating...' : 'Create Equipment' }}
        </button>
        <router-link to="/equipments" class="cancel-btn">Cancel</router-link>
      </div>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { equipmentService, materialService } from '@/services/api'

export default {
  setup() {
    const router = useRouter()
    const isSubmitting = ref(false)

    const equipmentData = ref({
      equipment_name: '',
      equipment_type: '',
      equipment_stat: '',
      equipment_description: ''
    })

    const imageFile = ref(null)
    const imagePreview = ref(null)

    const equipmentTypes = ref([])
    const materials = ref([])
    const materialRequirements = ref([{ material_id: '', quantity: '' }])

    const validateFileType = (file) => {
      const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml']
      return allowedTypes.includes(file.type)
    }

    const handleImageUpload = (event) => {
      const file = event.target.files[0]
      if (file) {
        if (!validateFileType(file)) {
          alert('Image must be a JPEG, PNG, JPG, GIF, or SVG file')
          event.target.value = ''
          imageFile.value = null
          imagePreview.value = null
          return
        }
        imageFile.value = file
        const reader = new FileReader()
        reader.onload = (e) => {
          imagePreview.value = e.target.result
        }
        reader.readAsDataURL(file)
      }
    }

    const createEquipment = async () => {
      console.log('equipmentData:', equipmentData.value)
      console.log('imageFile:', imageFile.value)
      if (isSubmitting.value) return
      isSubmitting.value = true

      try {
        if (!equipmentData.value.equipment_name || !equipmentData.value.equipment_type ||
            !equipmentData.value.equipment_stat || !equipmentData.value.equipment_description) {
          throw new Error('Please fill in all required fields')
        }

        if (!imageFile.value) {
          throw new Error('Equipment image is required')
        }

        const filteredMaterials = materialRequirements.value.filter(
          material => material.material_id && material.quantity
        )

        console.log('Image file:', imageFile.value);
        console.log('Image file type:', imageFile.value?.type);
        console.log('Image file size:', imageFile.value?.size);

        const formData = new FormData()
        formData.append('equipment_name', equipmentData.value.equipment_name)
        formData.append('equipment_type', equipmentData.value.equipment_type)
        formData.append('equipment_stat', equipmentData.value.equipment_stat)
        formData.append('equipment_description', equipmentData.value.equipment_description)
        formData.append('equipment_image', imageFile.value)

        if (filteredMaterials.length > 0) {
          filteredMaterials.forEach((material, index) => {
            formData.append(`materials[${index}][material_id]`, material.material_id)
            formData.append(`materials[${index}][quantity]`, material.quantity)
          })
        }
        console.log('Form data:', formData)

        const response = await equipmentService.create(formData)
        if (response.data.success) {
          router.push('/equipments')  // Change from '/equipment' to '/equipments'
        }
      } catch (error) {
        console.error('Error creating equipment:', error)
        let errorMessage = 'Error creating equipment.'

        if (error.response?.status === 422) {
          if (error.response.data.errors) {
            const errors = Object.entries(error.response.data.errors)
              .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
              .join('\n')
            errorMessage += '\n\nValidation errors:\n' + errors
          } else if (error.response.data.message) {
            errorMessage += '\n' + error.response.data.message
          }
        } else if (error.message) {
          errorMessage += '\n' + error.message
        }

        alert(errorMessage)
      } finally {
        isSubmitting.value = false
      }
    }

    const fetchEquipmentTypes = async () => {
      try {
        const response = await equipmentService.getTypes()
        equipmentTypes.value = response.data.data
      } catch (error) {
        console.error('Error fetching equipment types:', error)
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
      const lastMaterial = materialRequirements.value[materialRequirements.value.length - 1]
      if (lastMaterial.material_id && lastMaterial.quantity) {
        materialRequirements.value.push({ material_id: '', quantity: '' })
      }
    }

    const removeMaterial = (index) => {
      materialRequirements.value.splice(index, 1)
    }

    onMounted(() => {
      fetchEquipmentTypes()
      fetchMaterials()
    })

    return {
      equipmentData,
      imageFile,
      imagePreview,
      equipmentTypes,
      materials,
      materialRequirements,
      isSubmitting,
      handleImageUpload,
      createEquipment,
      checkAddNewMaterial,
      removeMaterial
    }
  }
}
</script>

<style scoped>
.new-equipment-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;
}

.equipment-form {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 1.5rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #333;
}

.form-input,
.form-select,
.form-textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.file-input {
  padding: 0.5rem;
}

.image-preview {
  margin-top: 1rem;
}

.preview-image {
  max-width: 200px;
  max-height: 200px;
  border-radius: 4px;
  border: 1px solid #ddd;
}

.materials-section {
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid #eee;
}

.material-requirement {
  display: flex;
  gap: 1rem;
  align-items: end;
  margin-bottom: 1rem;
  padding: 1rem;
  background: #f8f9fa;
  border-radius: 4px;
}

.material-requirement .form-group {
  flex: 1;
  margin-bottom: 0;
}

.remove-btn {
  background: #dc3545;
  color: white;
  border: none;
  padding: 0.75rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  height: fit-content;
}

.remove-btn:hover {
  background: #c82333;
}

.form-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid #eee;
}

.submit-btn {
  background: #007bff;
  color: white;
  border: none;
  padding: 0.75rem 2rem;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
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
  padding: 0.75rem 2rem;
  border-radius: 4px;
  display: inline-block;
}

.cancel-btn:hover {
  background: #545b62;
}

h2 {
  color: #333;
  margin-bottom: 2rem;
}

h3 {
  color: #555;
  margin-bottom: 1rem;
}
</style>
