//Define some routes
export let routes = [
{ path: '/developer', component: require('./components/backend/DeveloperComponent.vue').default },
{ path: '/users', component: require('./components/backend/UserComponent.vue').default },
{ path: '/profile', component: require('./components/backend/ProfileComponent.vue').default },
{ path: '/category', component: require('./components/backend/CategoryComponent.vue').default },
{ path: '/post', component: require('./components/backend/PostComponent.vue').default },
//Frontpage routes
{ path: '/blog', component: require('./components/frontend/blog/BlogPost.vue').default}
]