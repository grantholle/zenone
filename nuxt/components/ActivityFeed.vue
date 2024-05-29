<template>
  <ul role="list" class="space-y-6">
    <li v-for="(activityItem, activityItemIdx) in activities" :key="activityItem.id" class="relative flex gap-x-4">
      <div :class="[activityItemIdx === activities.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
        <div class="w-px bg-gray-400" />
      </div>
      <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-black">
        <div class="h-1.5 w-1.5 rounded-full bg-gray-500 ring-1 ring-gray-300" />
      </div>
      <p class="flex-auto py-0.5 text-xs leading-5">
        <span class="font-medium">{{ activityItem.status?.description }}</span>
        <span class="block text-gray-400">{{ activityItem.status?.description }}</span>
      </p>
      <time :datetime="activityItem.dateTime" class="flex-none py-0.5 text-xs leading-5 text-gray-300">{{ activityItem.date }}</time>
    </li>
  </ul>
</template>

<script setup lang="ts">
import type { PropType } from "vue"
import type { Activity } from "~/composables/useShipments"

const props = defineProps({
  activities: Array as PropType<Activity[]>
})
</script>
