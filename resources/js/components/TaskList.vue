<template>
    <div class="task-list">
      <h2>Tasks</h2>
      <ul v-if="tasks.length">
        <li v-for="task in tasks" :key="task.id">
          {{ task.title }} ({{ task.status }})
          <a :href="'/tasks/' + task.id + '/edit'">Edit</a>
          <button @click="deleteTask(task.id)">Delete</button>
        </li>
      </ul>
      <p v-else>No tasks yet.</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        tasks: [],
      };
    },
    created() {
      this.fetchTasks();
    },
    methods: {
      async fetchTasks() {
        try {
          const response = await axios.get('/tasks');
          this.tasks = response.data;
        } catch (error) {
          console.error('Error fetching tasks:', error);
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
  .task-list { /* Add a class for easier styling */
    margin: 1rem;
  }

  .task-list h2 {
    margin-bottom: 1rem;
  }

  .task-list ul {
    list-style: none; /* Remove default bullet points */
    padding: 0;
    margin: 0;
  }

  .task-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 1rem;
    border-bottom: 1px solid #ddd;
  }

  .task-list li:last-child {
    border-bottom: none;
  }

  .task-list a {
    color: #4CAF50; /* Green */
    text-decoration: none;
  }

  .task-list a:hover {
    text-decoration: underline;
  }

  .task-list button {
    background-color: transparent;
    border: none;
    color: #f00; /* Red */
    cursor: pointer;
  }
</style>
  