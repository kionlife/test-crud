import {createRouter, createWebHistory} from 'vue-router';
import Login from '../components/Auth/Login.vue';
import Register from '../components/Auth/Register.vue';
import Employee from '../components/Employee/Employee.vue'; 
import EmployeeEdit from '../components/Employee/EmployeeEdit.vue'; 
import EmployeeView from '../components/Employee/EmployeeView.vue'; 
import EmployeeCreate from '../components/Employee/EmployeeCreate.vue';
import Dashboard from '../components/Dashboard/Dashboard.vue';
import NotFound from '../components//NotFound/NotFound.vue';

const routes = [
    {
        path : '/login',
        component : Login,
        name : 'login'
    },
    {
        path : '/register',
        component : Register,
        name : 'register'
    },
    {
        path : '/dashboard',
        component : Dashboard,
        name : 'dashboard'
    },
    {
        path : '/employee',
        component : Employee,
        name : 'employee',
    },
    {
        path : '/employee-create',
        component : EmployeeCreate,
        name : 'employee-create'
    },
    {
        path : '/employee-edit/:id',
        component : EmployeeEdit,
        name : 'employee-edit'
    },
    {
        path : '/employee-view/:id',
        component : EmployeeView,
        name : 'employee-view'
    },
    {
        path : '/employee-delete/:id',
        component : Employee,
        name : 'employee-delete'
    },
    {
        path : '/:pathMatch(.*)*',
        component : NotFound,
        name : 'notfound'
    },
];

const router = createRouter({
    history : createWebHistory(),
    routes
});

// Auth checking guard
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('accessToken');
    
    if (to.path === '/login' || to.path === '/register') {
        if(token){
            return next({name : 'notfound'});
        }else {
            return next();
        }
   }
  
    if (!token) {
      return next('/login');
    }

    next();
  });

export default router;