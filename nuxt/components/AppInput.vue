<template>
  <input :type="type" v-model="localValue" class="block w-full rounded-md bg-gray-800 border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-600 placeholder:text-gray-200 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6" />
</template>

<script setup>
const props = defineProps({
  modelValue: [String, Number],
  type: {
    type: String,
    default: 'text',
  },
})
const emit = defineEmits(['update:modelValue'])
const localValue = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
})
</script>
