<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link :to="{name: 'home'}" class="nav-link">Главная</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'desks'}" class="nav-link">Доски</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>

</template>

<script>
export default {
    name: "App",
}
</script>

<style scoped>

</style>
