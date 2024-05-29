// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  srcDir: 'nuxt/',
  devtools: { enabled: false },
  runtimeConfig: {
    public: {
      apiBase: import.meta.env.APP_URL,
    }
  },
  sanctum: {
    baseUrl: import.meta.env.APP_URL,
  },
  modules: ["@nuxtjs/tailwindcss", "@pinia/nuxt", "nuxt-auth-sanctum"]
})
