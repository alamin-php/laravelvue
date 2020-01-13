<template>
    <div id="publicmain">
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
    	name:"FrontMasterComponent",
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
