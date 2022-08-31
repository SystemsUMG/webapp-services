<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link :to="{ name: 'Home' }" class="nav-item nav-link">Home</router-link>
                    <router-link :to="{ name: 'Example' }" class="nav-item nav-link">Example</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view/>
    </div>
</template>

<script>
    export default {
        name: "App",
    }
</script>