<template>
    <div class="edit-task" v-if="task">
      <h2>Edit Task</h2>
      <form @submit.prevent="updateTask">
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" id="title" v-model="task.title" required>
        </div>
        <div class="form-group">
          <label for="status">Status:</label>
          <select v-model="task.status" id="status">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <button type="submit">Update Task</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    // props: ['taskId'], // Get task ID from route parameter
    props: {
    taskId: {
      type: Number,
      required: true
    }
  },
  // props: {
  //   taskId: Number, // Specify type as Number (optional)
  // },
    data() {
      return {
        task: {},
      };
    },
    created() {
    
      
      const taskId = this.$route.params.taskId;
      if (!taskId) {
    this.$router.push({ name: 'task-list' }); // Redirect to task list
    return;
  }else{
    this.getTask(this.$route.params.taskId);
  }

    },
    // mounted(){
    //    console.log(this.$route.params.taskId);
      
    //   //this.getTask(this.$route.params.taskId);
    // },
    methods: {
      async getTask(taskID) {      
        try {
          const response = await axios.get(`/tasks/${taskID}`);
          this.task = response.data;
          // console.log(this.task);
        } catch (error) {
          console.error('Error fetching task:', error);
        }
      },
      async updateTask() {
        try {
          const response = await axios.put(`/tasks/${this.task.id}`, this.task);
          this.$emit('taskUpdated', response.data); // Emit event for updating the task list
          console.log(response.data);

        } catch (error) {
          console.error('Error updating task:', error);
        }
      },
    },
  };
  </script>
  <style scoped>
  /* Styles for AddTask component */
  .edit-task {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin: 1rem;
  }

  .edit-task h2 {
    margin-bottom: 1rem;
  }

  .edit-task form {
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

  .edit-task button {
    padding: 0.75rem 1rem;
    background-color: #4CAF50; /* Green */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
</style>