<template>
    <div v-if="showConfirm">
      <p>Are you sure you want to delete this task?</p>
      <button @click="deleteTask">Delete</button>
      <button @click="cancelDelete">Cancel</button>
    </div>
  </template>
  
  <script>
  export default {
    // props: ['taskId'],
    props: {
    taskId: {
      type: Number,
      required: true
    }
  },
    data() {
      return {
        showConfirm: false,
      };
    },
    methods: {
      confirmDelete() {
        this.showConfirm = true;
      },
      async deleteTask() {
        try {
          await axios.delete(`/tasks/${this.taskId}`);
          this.$emit('taskDeleted'); // Emit event for handling deletion in parent component
          this.showConfirm = false;
        } catch (error) {
          console.error('Error deleting task:', error);
        }
      },
      cancelDelete() {
        this.showConfirm = false;
      },
    },
  };
  </script>
  