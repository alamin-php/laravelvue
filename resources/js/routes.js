//Define some routes
export let routes = [
{ path: '/developer', component: require('./components/backend/DeveloperComponent.vue').default },
{ path: '/category', component: require('./components/backend/CategoryComponent.vue').default },
{ path: '/post', component: require('./components/backend/PostComponent.vue').default },
{ path: '/example-component', component: require('./components/ExampleComponent.vue').default}
]