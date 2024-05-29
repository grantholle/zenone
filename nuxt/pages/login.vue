<template>
  <div class="flex items-start lg:items-center justify-center py-12 px-4 bg-gradient-to-b to-black from-cyan-950 w-full">
    <div class="w-full max-w-sm bg-gray-900/50 backdrop-blur-sm py-4 px-5 rounded-xl shadow">
      <h1 class="text-2xl font-bold text-gray-100 mb-4">Log in</h1>
      <form @submit.prevent="onSubmit">
        <fieldset class="space-y-5">
          <div>
            <AppLabel for="email">Email</AppLabel>
            <AppInput type="email" v-model="form.email" id="email" />
            <FieldError :error="store.errors.email" />
          </div>
          <div>
            <AppLabel for="password">Password</AppLabel>
            <AppInput type="password" v-model="form.password" id="password" />
          </div>
          <div>
            <AppButton type="submit" class="w-full">Log in</AppButton>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
useHead({
  title: 'Log in',
})
const form = reactive({
  email: '',
  password: '',
})
const store = useErrorBagStore()
const { login } = useSanctumAuth()

const onSubmit = async () => {
  try {
    await login(form)
  } catch (error) {
    store.setBag(error)
    form.password = ''
  }
}
</script>
