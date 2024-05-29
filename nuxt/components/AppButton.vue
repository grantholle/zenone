<template>
  <component :is="component" v-bind="{ ...$attrs, ...props }" class="rounded-md bg-cyan-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600 disabled:bg-gray-700 disabled:cursor-not-allowed disabled:text-gray-400">
    <slot />
  </component>
</template>

<script setup>
const props = defineProps({
  type: {
    type: String,
    default: 'button',
  },
  to: String,
  href: String,
})
const component = computed(() => {
  if (props.to || props.href) {
    return resolveComponent('NuxtLink')
  }

  return 'button'
})
</script>
