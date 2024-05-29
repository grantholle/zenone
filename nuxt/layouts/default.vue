<template>
  <div class="flex flex-col min-h-screen w-full justify-between">
    <header class="py-6 px-4 bg-gray-900 flex justify-between shadow-md">
      <h1 class="text-2xl font-bold text-gray-100">My App</h1>
      <div>
        <template v-if="user">
          <span class="text-gray-100">Hi, {{ user.name }}!</span>
          <AppButton @click="logout" class="ml-4">Log out</AppButton>
        </template>
        <template v-else>
          <AppButton href="/login">Log in</AppButton>
        </template>
      </div>
    </header>
    <main class="flex-1 flex">
      <slot />
    </main>
    <footer class="text-center px-4 py-6 bg-cyan-950">
      &copy; 2024 <a href="https://grantholle.com" class="text-cyan-50 hover:underline">Grant Holle</a>
    </footer>
  </div>
</template>

<script setup lang="ts">
const { user, logout } = useSanctumAuth()
</script>
