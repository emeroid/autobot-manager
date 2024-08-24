<template>
  <div>
    <nav>
      <router-link to="/">Home</router-link>
      <router-link to="/autobots">Autobots</router-link>
    </nav>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
/* Add some styles to format your navigation */
nav {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}
</style>
