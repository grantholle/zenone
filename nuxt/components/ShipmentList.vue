<template>
  <TransitionGroup tag="ul" name="list" role="list" class="divide-y divide-gray-700">
    <li v-for="shipment in shipments" :key="shipment.id" class="flex items-center justify-between gap-x-6 py-5">
      <div class="min-w-0">
        <div class="flex items-start gap-x-3">
          <p class="text-sm font-semibold leading-6">{{ shipment.tracking_number }}</p>
<!--          <p :class="[statuses['In progress'], 'rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset']">Coming</p>-->
        </div>
        <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-300">
          <p class="whitespace-nowrap">
            {{ shipment.status }}
          </p>
          <svg v-if="shipment.origin" viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
            <circle cx="1" cy="1" r="1" />
          </svg>
          <p v-if="shipment.origin" class="truncate">Shipped from {{ shipment.origin }}</p>
        </div>
      </div>
      <div class="flex flex-none items-center gap-x-4">
        <NuxtLink :href="`/shipments/${shipment.tracking_number}`" class="rounded-md bg-gray-900 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-600 hover:bg-gray-800 block">
          Details
        </NuxtLink>
      </div>
    </li>
  </TransitionGroup>
</template>

<script setup lang="ts">
import type { Shipment } from "~/composables/useShipments"
import type { PropType } from "vue"

const props = defineProps({
  shipments: Array as PropType<Shipment[]>,
})

const statuses = {
  Complete: 'text-green-700 bg-green-50 ring-green-600/20',
  'In progress': 'text-gray-600 bg-gray-50 ring-gray-500/10',
  Archived: 'text-yellow-800 bg-yellow-50 ring-yellow-600/20',
}
</script>

<style>
  .list-move,
  .list-enter-active,
  .list-leave-active {
    transition: all 1s cubic-bezier(0.075, 0.82, 0.165, 1);
  }

  .list-enter-from,
  .list-leave-to {
    opacity: 0;
    transform: translateX(-2rem);
  }

  .list-leave-active {
    position: absolute;
  }
</style>
