<template>
  <div class="add-task">   
    <h2>{{ isEditing ? 'Edit Task' : 'Add Task' }}</h2>
    <form @submit.prevent="submitTask">
      <div class="form-group">
        <label for="title">Title</label>
        <input v-model="task.title" type="text" id="title" required>
      </div>
      <div class="form-group">
        <label for="status">Status</label>
        <select v-model="task.status" id="status" required>
          <option value="pending">Pending</option>
          <option value="completed">Completed</option>
        </select>
      </div>
      <div class="form-group">
        <label for="attachment">Attachment</label>
        <input v-on:change="handleFileChange" type="file" id="attachment">
      </div>
      <button type="submit">{{ isEditing ? 'Save' : 'Add' }}</button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    task: { // Prop to receive a task object (optional for editing)
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      isEditing: false,
      attachment: null, // Store the selected file object
    };
  },
  methods: {
    async submitTask() {
      const formData = new FormData(); // Use FormData for file uploads
      formData.append('title', this.task.title);
      formData.append('status', this.task.status);

      if (this.attachment) {
        formData.append('attachment', this.attachment);
      }

      // Implement logic to submit the form data (e.g., using axios)
      try {
        const response = await axios.post('/tasks', formData, { // Adjust URL
          headers: {
            'Content-Type': 'multipart/form-data', // Required for file uploads
          },
        });
        this.$emit('submitTask', response.data); // Emit event with the response
        this.clearForm(); // Clear the form after successful submission
      } catch (error) {
        console.error('Error submitting task:', error);
        // Handle errors (e.g., display an error message)
      }
    },
    clearForm() {
      this.task.title = '';
      this.task.status = 'pending';
      this.attachment = null;
    },
  },
  created() {
    this.isEditing = this.task.id !== undefined;
  },
};
</script>
  
  <style scoped>
/* Styles for AddTask component */
.add-task {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 10rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  margin: 1rem;
}

.add-task h2 {
  margin-bottom: 1rem;
}

.add-task form {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold;
}

.form-group input[type="text"],
.form-group select {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
}

.form-group input[type="file"] {
  padding: 0.5rem;
}

.add-task button {
  padding: 0.75rem 1rem;
  background-color: #4CAF50;
  /* Green */
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
</style>
  