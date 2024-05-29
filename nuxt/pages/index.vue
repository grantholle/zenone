<template>
  <div class="w-full py-6 px-4">
    <Container>
      <form class="max-w-2xl mx-auto flex gap-5" @submit.prevent="onSubmit">
        <label class="sr-only" for="tracking_number">Tracking number</label>
        <AppInput v-model="trackingNumber" id="tracking_number" class="sm:text-xl sm:py-2 px-3 w-full" placeholder="Enter tracking number" />
        <AppButton type="submit">Track</AppButton>
      </form>

      <div class="mt-8 max-w-2xl mx-auto">
        <div v-if="fetching">
          Loading...
        </div>
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

fetchShipments()
const trackingNumber = ref<string>('')
const onSubmit = async () => {
  await createShipment(trackingNumber.value)
  trackingNumber.value = ''
}
</script>
