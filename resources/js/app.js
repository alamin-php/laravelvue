require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';

//Import vue editor
import 'v-markdown-editor/dist/index.css';
import Editor from 'v-markdown-editor'
// global register
Vue.use(Editor);

//Import vue router
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//Route import
import {routes} from './routes';

//Import V-Form
import { Form, HasError, AlertError } from 'vform'
window.Form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//Create the router instance and pass the `routes` option
const router = new VueRouter({
	mode: 'history',
  routes // short for `routes: routes`
})

//Fire import
window.Fire = new Vue();

// Import sweet alert
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 4000,
	timerProgressBar: true,
	onOpen: (toast) => {
		toast.addEventListener('mouseenter', Swal.stopTimer)
		toast.addEventListener('mouseleave', Swal.resumeTimer)
	}
});
window.Toast = Toast

// Vue Progressbar 
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: '#50d38a',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
})

//Passport component
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);


//Vue componet
Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
	router
}).$mount('#app')

//User-defain Method

Vue.filter('myDate', function (created) {
	return moment(created).format('MMMM Do YYYY');
});

Vue.filter('sortlength',function(text,length,suffix) {
	return text.substring(0,length)+suffix;
});