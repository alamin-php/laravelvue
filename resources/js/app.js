require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';

//Import vue router
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//Import V-Form
import { Form, HasError, AlertError } from 'vform'
window.Form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//Define some routes
let routes = [
{ path: '/category', component: require('./components/backend/CategoryComponent.vue').default },
{ path: '/post', component: require('./components/backend/PostComponent.vue').default },
{ path: '/example-component', component: require('./components/ExampleComponent.vue').default}
]

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


//Vue componet
Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
	router
}).$mount('#app')




//User-defain Method

Vue.filter('myDate', function (created) {
	return moment(created).format('MMMM Do YYYY');
});
