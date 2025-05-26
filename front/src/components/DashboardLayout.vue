<template>
  <div class="dashboard">
    <Sidebar />
    <div class="main-content">
      <Header />
      <router-view />
    </div>
  </div>
</template>

<script>
import Sidebar from './Sidebar.vue'
import Header from './Header.vue'

export default {
  components: { Sidebar, Header }
}
</script>

<style scoped>
.dashboard {
  display: flex;
  height: 100vh;
}
.main-content {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}
</style>
