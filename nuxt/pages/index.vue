<template>
  <div class="w-full py-6 px-4">
    <Container>
      <form class="max-w-2xl mx-auto flex gap-5" @submit.prevent="onSubmit">
        <label class="sr-only" for="tracking_number">Tracking number</label>
        <div class="flex-1">
          <AppInput v-model="trackingNumber" id="tracking_number" class="sm:text-lg sm:py-1.5 px-3 w-full" placeholder="Enter tracking number" />
          <FieldError :error="store.errors.tracking_number" />
        </div>
        <AppButton type="submit" class="self-start">Track</AppButton>
      </form>

      <div class="mt-8 max-w-2xl mx-auto">
        <Spinner v-if="fetching" />
        <p v-else-if="!fetching && shipments.length === 0" class="text-center">
          You're not tracking any shipments yet. Add a tracking number to get started.
        </p>
        <ShipmentList v-else :shipments="shipments" />
      </div>
    </Container>
  </div>
</template>

<script setup lang="ts">
import { shipments, fetching, fetchShipments, createShipment } from "~/composables/useShipments"

definePageMeta({
  middleware: ['sanctum:auth'],
})

fetchShipments()
const store = useErrorBagStore()
const trackingNumber = ref<string>('')
const onSubmit = async () => {
  store.clearErrors()
  await createShipment(trackingNumber.value)
  trackingNumber.value = ''
}
</script>
