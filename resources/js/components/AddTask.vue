<template>
  <div class="add-task">
    <h2>Add Task</h2>
    <div v-if="newTask.successMessage">{{ newTask.successMessage }}</div>
    <form @submit.prevent="addTask">
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" v-model="newTask.title" required>
      </div>
      <div class="form-group">
        <label for="status">Status:</label>
        <select v-model="newTask.status" id="status">
          <option value="pending">Pending</option>
          <option value="completed">Completed</option>
        </select>
      </div>
      <div class="form-group">
        <label for="attachment">Attachment (optional):</label>
        <input type="file" id="attachment" @change="onFileChange">
      </div>
      <button type="submit">Add Task</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      newTask: {
        title: '',
        status: 'pending',
        attachment: 'null', // Optional attachment field
        successMessage: null,
      },
    };
  },
  methods: {
    async addTask() {
      const formData = new FormData();
      formData.append('title', this.newTask.title);
      formData.append('status', this.newTask.status);

      // Handle optional attachment (if applicable)
      if (this.newTask.attachment) {
        formData.append('attachment', this.newTask.attachment);
      }

      try {
        const response = await axios.post('/tasks', formData, {
          headers: {
            'Content-Type': 'multipart/form-data', // Required for file uploads
          },
        });
//console.log(response.data);
     if(response.status === 201){
      this.newTask.successMessage =  'Task created successfully!';
      //this.tasks.push(response.data); // Update tasks array directly (caution)
      this.$emit('taskAdded', response.data); // Emit event with task data

     }
        
        this.newTask.title = ''; // Clear form after successful submission
        this.newTask.status = 'pending';
        this.newTask.attachment = 'null';
        
        // this.resetForm(); // Reset the form after successful submission
        //this.tasks.push(response.data); // Add newly created task to list
      } catch (error) {
        console.error('Error adding task:', error);
      }
    },
    onFileChange(event) {
      // Handle file change event here
      if (event.target.files && event.target.files.length > 0) {
      this.newTask.attachment = event.target.files[0];
      } else {
        // Empty attachment selected
        this.newTask.attachment = 'null'; // Clear attachment data in Vue state
      }

    }
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