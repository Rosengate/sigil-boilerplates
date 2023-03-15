import { createRouter, createWebHistory } from 'vue-router'
import IndexPage from '../views/IndexPage.vue'
import ComponentsPage from "@/views/Utils/ComponentsPage.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: IndexPage
    },
    {
      path: '/components',
      component: ComponentsPage
    }
  ]
})

export default router
