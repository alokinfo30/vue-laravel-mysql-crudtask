<template>
  <div class="task-list">
    <h2>Task List</h2>
    <ul v-if="tasks.length > 0">
      <li>
        <h3>Title</h3>
        <h3>Status</h3>
        <h3>Attachment</h3>
        <h3>Actions</h3>
      </li>

      <li v-for="task in tasks" :key="task.id">
        <p>{{ task.title }}</p>
        <p>{{ task.status }}</p>
        <!-- <p>{{ task.attachment }}</p> -->
       <p> <span v-if="task.attachment">
        <a :href="getAttachmentUrl(task.attachment)">Download Attachment</a>
      </span></p>
        <p>
          <RouterLink :to="{ path: '/tasks/' + task.id }" @click="$emit('edit-task', task.id)" >Edit</RouterLink>
          <button @click="$emit('delete-task', task.id)">Delete</button>
          <!-- <button @click="confirmDelete(task.id)">Delete</button> -->
        </p>
      </li>
    </ul>
    <p v-else>No tasks yet.</p>
  </div>

</template>

<script>
import axios from 'axios';
import { RouterLink } from 'vue-router';
// RouterLink, createRouterLink
export default {
  props: {
    tasks: [],
  },
  components: {
    RouterLink, // Register the component
  },
  data() {
    return {
      tasks: [],
      taskToEdit: null
    };
  },
  created() {
    this.fetchTasks();
  },
  methods: {
    getAttachmentUrl(filename) {
      
    // Use Axios or other methods to fetch a temporary URL from your Laravel API
    return axios.get(`/tasks/get-attachment-url/${filename}`)
      .then(response => response.data.url);
  },
    async fetchTasks() {
      try {
        const response = await axios.get('/tasks');
        this.tasks = response.data;
      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    },
    confirmDelete(taskId) {
      if (confirm('Are you sure you want to delete this task?')) {
        this.deleteTask(taskId);
      }
    },
    async deleteTask(taskId) {
      try {
        await axios.delete(`/tasks/${taskId}`);
        this.tasks = this.tasks.filter((task) => task.id !== taskId);
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    },
  },
};
</script>
<style scoped>
/* Styles for TaskList component */
.task-list {
  /* Add a class for easier styling */
  margin: 10rem;
}

.task-list h2 {
  margin-bottom: 1rem;
}

.task-list ul {
  list-style: none;
  /* Remove default bullet points */
  padding: 0;
  margin: 0;
}

.task-list li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 20rem;
  border-bottom: 1px solid #ddd;
}

.task-list li:last-child {
  border-bottom: none;
}

.task-list a {
  color: #4CAF50;
  /* Green */
  text-decoration: none;
}

.task-list a:hover {
  text-decoration: underline;
}

.task-list button {
  background-color: transparent;
  border: none;
  color: #f00;
  /* Red */
  cursor: pointer;
}
</style>