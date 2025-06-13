<template>
  <!-- Admin only view to create a monster -->
  <div class="new-monster-container">
    <h2>Create New Monster</h2>
    <form @submit.prevent="createMonster" class="monster-form" enctype="multipart/form-data">
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
          <option value="Small">Small</option>
          <option value="Big">Big</option>
        </select>
      </div>

      <div class="form-group">
        <label for="foe_icon">Monster Icon:</label>
        <input
          type="file"
          id="foe_icon"
          @change="handleIconUpload"
          accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml"
          required
          class="form-input file-input"
        />
        <div v-if="iconPreview" class="image-preview">
          <img :src="iconPreview" alt="Icon preview" class="preview-image" />
        </div>
      </div>

      <div class="form-group">
        <label for="foe_image">Monster Image:</label>
        <input
          type="file"
          id="foe_image"
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
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { foeService, materialService } from '@/services/api';

export default {
  setup() {
    const router = useRouter();
    const isSubmitting = ref(false);

    // Monster data to be created
    const monsterData = ref({
      foe_name: '',
      foe_type: '',
      foe_size: '',
      foe_description: ''
    });

    // Icon and image files and their previews
    const iconFile = ref(null);
    const imageFile = ref(null);
    const iconPreview = ref(null);
    const imagePreview = ref(null);

    // Monster types and available materials
    const foeTypes = ref([]);
    const materials = ref([]);
    // Materials that the monster can drop
    const materialDrops = ref([{ material_id: '', drop_rate: '' }]);

    // Validate image file type
    const validateFileType = (file) => {
      const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
      return allowedTypes.includes(file.type);
    };

    // Handle icon file upload and preview
    const handleIconUpload = (event) => {
      const file = event.target.files[0];
      if (file) {
        if (!validateFileType(file)) {
          alert('Icon must be a JPEG, PNG, JPG, GIF, or SVG file');
          event.target.value = ''; // Clear the file input
          iconFile.value = null;
          iconPreview.value = null;
          return;
        }
        iconFile.value = file;
        const reader = new FileReader();
        reader.onload = (e) => {
          iconPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    };

    // Handle main image file upload and preview
    const handleImageUpload = (event) => {
      const file = event.target.files[0];
      if (file) {
        if (!validateFileType(file)) {
          alert('Image must be a JPEG, PNG, JPG, GIF, or SVG file');
          event.target.value = ''; // Clear the file input
          imageFile.value = null;
          imagePreview.value = null;
          return;
        }
        imageFile.value = file;
        const reader = new FileReader();
        reader.onload = (e) => {
          imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    };

    // Submit the form to create the monster
    const createMonster = async () => {
      if (isSubmitting.value) return;
      isSubmitting.value = true;

      try {
        // Validate required fields before sending
        if (!monsterData.value.foe_name || !monsterData.value.foe_type ||
            !monsterData.value.foe_size || !monsterData.value.foe_description) {
          throw new Error('Please fill in all required fields');
        }

        if (!iconFile.value || !imageFile.value) {
          throw new Error('Both icon and image files are required');
        }

        // Filter valid materials
        const filteredMaterials = materialDrops.value.filter(
          material => material.material_id && material.drop_rate
        );

        // Build FormData to send files and data
        const formData = new FormData();
        formData.append('foe_name', monsterData.value.foe_name);
        formData.append('foe_type', monsterData.value.foe_type);
        formData.append('foe_size', monsterData.value.foe_size);
        formData.append('foe_description', monsterData.value.foe_description);
        formData.append('foe_icon', iconFile.value);
        formData.append('foe_image', imageFile.value);

        // Add materials data to FormData
        if (filteredMaterials.length > 0) {
          filteredMaterials.forEach((material, index) => {
            formData.append(`materials[${index}][material_id]`, material.material_id);
            formData.append(`materials[${index}][drop_rate]`, material.drop_rate);
          });
        }

        const response = await foeService.create(formData);
        if (response.data.success) {
          router.push('/monsters');
        }
      } catch (error) {
        console.error('Error creating monster:', error);
        let errorMessage = 'Error creating monster.';

        // Better error message handling
        if (error.response?.status === 422) {
          console.log('Validation errors:', error.response.data);
          if (error.response.data.errors) {
            const errors = Object.entries(error.response.data.errors)
              .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
              .join('\n');
            errorMessage += '\n\nValidation errors:\n' + errors;
          } else if (error.response.data.message) {
            errorMessage += '\n' + error.response.data.message;
          }
        } else if (error.message) {
          errorMessage += '\n' + error.message;
        }

        alert(errorMessage);
      } finally {
        isSubmitting.value = false;
      }
    };

    // Fetch available monster types
    const fetchFoeTypes = async () => {
      try {
        const response = await foeService.getTypes();
        foeTypes.value = response.data.data;
      } catch (error) {
        console.error('Error fetching foe types:', error);
      }
    };

    // Fetch available materials
    const fetchMaterials = async () => {
      try {
        const response = await materialService.getAll();
        materials.value = response.data;
      } catch (error) {
        console.error('Error fetching materials:', error);
      }
    };

    // Add a new material drop input if the last one is filled
    const checkAddNewMaterial = () => {
      const lastMaterial = materialDrops.value[materialDrops.value.length - 1];
      if (lastMaterial.material_id && lastMaterial.drop_rate) {
        materialDrops.value.push({ material_id: '', drop_rate: '' });
      }
    };

    // Remove a material drop input
    const removeMaterial = (index) => {
      materialDrops.value.splice(index, 1);
    };

    // Fetch types and materials on mount
    onMounted(() => {
      fetchFoeTypes();
      fetchMaterials();
    });

    return {
      monsterData,
      foeTypes,
      materials,
      materialDrops,
      isSubmitting,
      iconPreview,
      imagePreview,
      createMonster,
      checkAddNewMaterial,
      removeMaterial,
      handleIconUpload,
      handleImageUpload
    };
  }
};
</script>

<style scoped>
.new-monster-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.monster-form {
  background: var(--formbackground);
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
  border: 1px solid var(--inputbackground);
  border-radius: 4px;
  font-size: 16px;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: var(--button);
  box-shadow: 0 0 0 2px var(--shadowcolor);
}

.file-input {
  padding: 5px;
}

.form-textarea {
  resize: vertical;
}

.image-preview {
  margin-top: 10px;
}

.preview-image {
  max-width: 200px;
  max-height: 200px;
  border-radius: 4px;
  border: 1px solid var(--bordercard);
}

.materials-section {
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid var(--bordercolor);
}

.material-drop {
  display: grid;
  grid-template-columns: 1fr 1fr auto;
  gap: 15px;
  align-items: end;
  margin-bottom: 15px;
  padding: 15px;
  border-radius: 4px;
}

.remove-btn {
  background: var(--removebutton);
  color: var(--textcancelbutton);
  border: none;
  padding: 10px 15px;
  border-radius: 4px;
  cursor: pointer;
  height: fit-content;
}

.remove-btn:hover {
  background: var(--removebuttonhover);
}

.form-actions {
  display: flex;
  gap: 15px;
  margin-top: 30px;
}

.submit-btn {
  background: var(--button);
  color: var(--textbutton);
  border: none;
  padding: 0.75rem 2rem;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
}

.submit-btn:hover:not(:disabled) {
  background: var(--buttonhover);
}

.submit-btn:disabled {
  background: var(--buttondisabled);
  cursor: not-allowed;
}

.cancel-btn {
  background: var(--removebutton);
  color: var(--textcancelbutton);
  text-decoration: none;
  padding: 0.75rem 2rem;
  border-radius: 4px;
  display: inline-block;
}

.cancel-btn:hover {
  background: var(--removebuttonhover);
}
</style>
