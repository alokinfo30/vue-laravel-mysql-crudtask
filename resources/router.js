import { createRouter, createWebHistory } from 'vue-router';
import EditTask from './js/components/EditTask.vue'; // Import EditTask component
import TaskList from './js/components/TaskList.vue';
import AddTask from './js/components/AddTask.vue';
import DeleteTask from './js/components/DeleteTask.vue';

const routes = [
    {
      path: '/',
      component: TaskList, // Assuming ListTask component for task listing
    },
    {
      path: '/tasks',
      component: TaskList, // Use same component for both listing and adding tasks
      children: [ // Nested route for adding tasks
        {
          path: 'add',
          component: AddTask,
        },
      ],
    },
    {
      path: '/tasks/:taskId/edit',
      component: EditTask,
      props: true, // Pass task ID as prop to EditTask
    },
    {
      path: '/tasks/:taskId/delete', // Route for deleting a task
      component: DeleteTask, // Assuming DeleteTask component for deletion confirmation/handling
      props: true, // Pass task ID as prop to DeleteTask
    },
  ];
  


const router = createRouter({
  history: createWebHistory(), // Assuming you want browser-like history mode
  routes,
});

export  default router;
