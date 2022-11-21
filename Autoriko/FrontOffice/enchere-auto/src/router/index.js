import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/Home.vue'),
    need_to_be_log: false
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import('../views/Contact.vue'),
    need_to_be_log: false
  },
  {
    path: '/guide',
    name: 'Guide',
    component: () => import('../views/Guide.vue'),
    need_to_be_log: false
  },
  {
    path: '/signin',
    name: 'Signin',
    component: () => import('../views/Authentication/Signin.vue'),
    need_to_be_log: false
  },
  {
    path: '/forgot_password',
    name: 'ForgotPassword',
    component: () => import('../views/Authentication/ForgotPassword.vue'),
    need_to_be_log: false
  },
  {
    path: '/signup',
    name: 'Signup',
    component: () => import('../views/Authentication/Signup.vue'),
    need_to_be_log: false
  },
  {
    path: '/signup_success',
    name: 'SignupSuccess',
    component: () => import('../views/Authentication/SignupSuccess.vue'),
    need_to_be_log: false
  },
  {
    path: '/ventes_panel',
    name: 'VentesPanel',
    component: () => import('../views/VentesPanel.vue'),
    need_to_be_log: false
  },
  {
    path: '/vente/:uuid',
    name: 'Vente',
    component: () => import('../views/Vente.vue'),
    need_to_be_log: false
  },
  {
    path: '/alertes',
    name: 'Alertes',
    component: () => import('../views/Alertes.vue'),
    need_to_be_log: true
  },
  {
    path: '/conversations',
    name: 'Conversations',
    component: () => import('../views/Conversations.vue'),
    need_to_be_log: true
  },
  {
    path: '/conversation/:uuid',
    name: 'Conversation',
    component: () => import('../views/Conversation.vue'),
    need_to_be_log: true
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const found = routes.find(element => element.name == to.name)

  if ((to.name == 'Signin' || to.name == 'Signup' || to.name == 'ForgotPassword') && store.state.userToken){
    next({ name: 'Home' })
  }
  else if((found && found.need_to_be_log == true) && !store.state.userToken){
    next({ name: 'Signin' })
  }
  else{
    next()
  }
  window.scrollTo(0, 0)
})

export default router
