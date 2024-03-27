<template>
  <div id="app">
    
    <h1>Task Manager</h1>
    <!-- <RouterView /> -->
    <add-task v-if="!taskToEdit" @taskAdded="addTaskToList"></add-task>
    <edit-task v-if="taskToEdit" :task="taskToEdit" @edit-task="handleTaskEdit" @taskUpdated="updateTaskInList"  ></edit-task>
    <task-list v-if="!taskToEdit" :tasks="tasks" @delete-task="handleTaskDeletion" @edit-task="handleTaskEdit" ></task-list>
    <!-- <router-view></router-view> -->
  </div>
  <!-- </script> -->
</template>
<script>
import { RouterView } from "vue-router";
import TaskList from './js/components/TaskList.vue';
import AddTask from './js/components/AddTask.vue';
import EditTask from './js/components/EditTask.vue';
import DeleteTask from './js/components/DeleteTask.vue';
// import router from './router'; // Import your Vue router
import axios from 'axios';
export default {
  components: {
    TaskList,
    AddTask,
    EditTask
  },
  data() {
    return {
      tasks: [],
      taskToEdit: null
    };
  },
  created() {
    this.fetchTasks();
    // const taskId = this.$route.params.taskId;
    // if (taskId) {
    //   this.taskToEdit = this.tasks.find(task => task.id === taskId);
    // }
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await axios.get('/tasks');
        //console.log(response.data);
        this.tasks = response.data;

      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    },
    addTaskToList(task) {
      // console.log(task);
      this.tasks.push(task);

      // this.tasks.push(task); // Add new task to local list
      this.fetchTasks();
    },
    handleTaskEdit(taskId) {
      //console.log(taskId);
      this.taskToEdit = taskId; // Set task ID for editing
    },
    async getTask(taskID) {    
      console.log(taskId);  
        try {
          const response = await axios.get(`/tasks/${taskID}`);
          this.task = response.data;
          // console.log(this.task);
        } catch (error) {
          console.error('Error fetching task:', error);
        }
      },
    updateTaskInList(updatedTask) {
      this.tasks = this.tasks.map((task) => {
        return task.id === updatedTask.id ? updatedTask : task;
      });
    },

    handleTaskDeletion(taskId) {
      if (confirm('Are you sure you want to delete this task?')) {
        this.deleteTask(taskId);
      }
    },
    deleteTask(taskId) {
      axios.delete(`/tasks/${taskId}`)
        .then(() => {
          this.tasks = this.tasks.filter((task) => task.id !== taskId);
        })
        .catch((error) => {
          console.error('Error deleting task:', error);
        });
    },

  },


};


</script>