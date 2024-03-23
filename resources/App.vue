<template>
    <div id="app">
      <h1>Task Manager</h1>
      <!-- <task-list :tasks="tasks"></task-list> -->
      <add-task @taskAdded="addTaskToList"></add-task>
      <router-view></router-view> </div>
  <!-- </script> -->
</template>
  <script>
  import TaskList from './js/components/TaskList.vue';
  import AddTask from './js/components/AddTask.vue';
  import EditTask from './js/components/EditTask.vue';
  import DeleteTask from './js/components/DeleteTask.vue';
  import router from './router'; // Import your Vue router
  
  export default {
    components: {
      TaskList,
      AddTask,
      EditTask,
      DeleteTask
    },
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
      addTaskToList(task) {
        this.tasks.push(task); // Add new task to local list
      },
    },
    router, // Add the imported router object here

  };
  

  </script>
  