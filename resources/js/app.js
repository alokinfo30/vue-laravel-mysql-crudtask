// import './bootstrap';

//  import Vue from 'vue';
import App from '../App.vue';
import router from '../router.js'; // Assuming you're using Vue Router
import { createApp } from "vue";

// Vue.config.productionTip = false;

// const app = new Vue({
//     el: '#app',
//   router,
//   render: h => h(App),
// }).$mount('#app');

createApp(App).use(router).mount("#app");