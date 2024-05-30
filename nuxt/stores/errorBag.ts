import { FetchError } from 'ofetch'
import { defineStore } from 'pinia'

export const useErrorBagStore = defineStore('error-bag', () => {
  const errors = ref<{ [key: string]: string }>({})
  const hasErrors = computed(() => Object.keys(errors.value).length > 0)
  const setBag = (error: any): void => {
    if (error instanceof FetchError && error.response?.status === 422) {
      errors.value = Object.keys(error.response._data?.errors)
        .reduce((acc, key) => {
          acc[key] = error.response?._data.errors[key][0]
          return acc
        }, {} as { [key: string]: string })
    }
  }
  const clearErrors = (): void => {
    errors.value = {}
  }

  return {
    errors,
    hasErrors,
    setBag,
    clearErrors,
  }
})
