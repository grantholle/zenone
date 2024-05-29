<template>
  <div class="w-full py-6 px-4">
    <div class="max-w-2xl mx-auto">
      <div class="px-4 sm:px-0 flex items-start justify-between">
        <div>
          <h3 class="text-base font-semibold leading-7 text-white">Shipment Information for {{ shipment.data.tracking_number }}</h3>
          <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-400">Shipment details and activity.</p>
        </div>
        <AppButton @click.prevent="update">Refresh</AppButton>
      </div>
      <div class="mt-6 border-t border-white/10 mb-5">
        <dl class="divide-y divide-white/10">
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-white">Origin</dt>
            <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ shipment.data.origin }}</dd>
          </div>
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-white">Destination</dt>
            <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ shipment.data.destination }}</dd>
          </div>
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-white">Weight</dt>
            <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ shipment.data.weight }}</dd>
          </div>
        </dl>
      </div>

      <ActivityFeed :activities="shipment?.activity || []" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { getShipment, updateShipment } from "~/composables/useShipments";
import type { ShipmentResponse } from "~/composables/useShipments";
import ActivityFeed from "~/components/ActivityFeed.vue";

const route = useRoute()
const shipment = ref<ShipmentResponse>({})
shipment.value = await getShipment(route.params.id as string)

const update = async () => {
  shipment.value = await updateShipment(route.params.id as string)
}
</script>
