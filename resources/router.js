import { createRouter, createWebHistory } from 'vue-router';
import EditTask from './js/components/EditTask.vue'; // Import EditTask component
import TaskList from './js/components/TaskList.vue';
import AddTask from './js/components/AddTask.vue';
import DeleteTask from './js/components/DeleteTask.vue';
import NotFound from './js/components/NotFound.vue';

const routes = [
    {
      path: '/',
      component: AddTask, // Assuming ListTask component for task listing
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
      path: '/tasks/:taskId',
      component: EditTask,
      props: true, // Pass task ID as prop to EditTask
    },
    {
      path: '/tasks/:taskId', // Route for deleting a task
      component: DeleteTask, // Assuming DeleteTask component for deletion confirmation/handling
      props: true, // Pass task ID as prop to DeleteTask
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'NotFound',
      component: NotFound
    },
  ];
  
const router = createRouter({
  history: createWebHistory(), // Assuming you want browser-like history mode
  routes: routes
});

export  default router;
