import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import RegistrationView from '../views/RegistrationView.vue'
import AddPerson from '../views/AddPerson.vue';
import EditPerson from '../views/EditPerson.vue';
import ViewPerson from '../views/ViewPerson.vue';
import AllPeople from '../views/AllPeople.vue';

const router = createRouter({
  history: createWebHistory('/zad1/'),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/all-people',
      name: 'all-people',      
      component: AllPeople
    },
    {
      path: '/view-person/:id',
      name: 'view-person',      
      component: ViewPerson
    },
    {
      path: '/add-person',
      name: 'add-person',      
      component: AddPerson
    },
    {
      path: '/edit-person/:id',
      name: 'edit-person',      
      component: EditPerson
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'registration',
      component: RegistrationView
    }
  ]
})

export default router