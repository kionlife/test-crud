import { createApp } from 'vue/dist/vue.esm-bundler.js';
import Employee from './components/Employee/Employee.vue';
import Login from './components/Auth/Login.vue';
import Register from './components/Auth/Register.vue';
import Dashboard from './components/Dashboard/Dashboard.vue';
import EmployeeEdit from './components/Employee/EmployeeEdit.vue';
import App from './components/App.vue';
import EmployeeCreate from './components/Employee/EmployeeCreate.vue';
import Store from './components/Store/Store.js';
import NotFound from './components/NotFound/NotFound.vue';
import routes from './router/index.js';
import ToastPlugin from 'vue-toast-notification';
import {LoadingPlugin} from 'vue-loading-overlay';
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import 'vue-toast-notification/dist/theme-bootstrap.css';
import 'vue-loading-overlay/dist/css/index.css';
import './bootstrap';

const app = createApp({
    components : {
        App,
        Dashboard,
        Employee,
        Login,
        Register,
        EmployeeEdit,
        EmployeeCreate,
        NotFound,
        
    },
});

library.add(fas);
app.component('icon', FontAwesomeIcon);
app.use(routes);
app.use(Store);
app.use(LoadingPlugin);
app.use(ToastPlugin);
app.mount('#app');


