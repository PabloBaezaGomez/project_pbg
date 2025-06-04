<!-- Error 404 definition -->
<template>
  <div class="not-found-container">
    <h1>404 - Not Found</h1>
    <p>The page you are looking for does not exist.</p>
    <RouterLink to="/monsters">Go to Monsters</RouterLink>
  </div>
</template>

<style scoped>
.not-found-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 60vh;
  text-align: center;
}
.not-found-container h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}
.not-found-container p {
  margin-bottom: 2rem;
}
</style>