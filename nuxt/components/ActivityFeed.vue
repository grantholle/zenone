<template>
  <ul role="list" class="space-y-6">
    <li v-for="(activityItem, activityItemIdx) in activities" :key="`${activityItem.date}${activityItem.time}`" class="relative flex gap-x-4">
      <div :class="[activityItemIdx === ((activities?.length || 1) - 1) ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
        <div class="w-px bg-gray-400" />
      </div>
      <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-black">
        <div class="h-1.5 w-1.5 rounded-full bg-gray-500 ring-1 ring-gray-300" />
      </div>
      <p class="flex-auto py-0.5 text-xs leading-5">
        <span class="font-medium">{{ activityItem.status?.description }}</span>
        <span class="block text-gray-400">{{ activityItem.location?.address?.city }}<span v-if="activityItem.location?.address?.city && activityItem.location?.address?.country">, </span><span v-if="activityItem.location?.address?.country">{{ activityItem.location?.address?.country }}</span></span>
      </p>
      <time :datetime="dayjs.utc(`${activityItem.gmtDate} ${activityItem.gmtTime}`, 'YYYYMMDD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss')" class="flex-none py-0.5 text-xs leading-5 text-gray-300">{{ dayjs.utc(`${activityItem.gmtDate} ${activityItem.gmtTime}`, 'YYYYMMDD HH:mm:ss').tz(dayjs.tz.guess()).format('MMM DD, YYYY h:mma') }}</time>
    </li>
  </ul>
</template>

<script setup lang="ts">
import type { PropType } from "vue"
import type { Activity } from "~/composables/useShipments"
import dayjs from "dayjs"
import utc from 'dayjs/plugin/utc'
import timezone from 'dayjs/plugin/timezone'

dayjs.extend(utc)
dayjs.extend(timezone)

const props = defineProps({
  activities: Array as PropType<Activity[]>
})
</script>
