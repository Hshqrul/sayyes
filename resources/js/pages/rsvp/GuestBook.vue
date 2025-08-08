<script setup lang="ts">
import { ref, onMounted } from 'vue'
import Alert from '@/components/ui/alert/Alert.vue'
import AlertDescription from '@/components/ui/alert/AlertDescription.vue'
import AlertTitle from '@/components/ui/alert/AlertTitle.vue'
import { BadgeCheckIcon, MoonIcon } from 'lucide-vue-next'
import moment from 'moment'
import Separator from '@/components/ui/separator/Separator.vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const props = defineProps<{
  event: {
    event_name: string
    description?: string
  }
  rsvps: {
    name: string
    attendence: boolean
    no_of_pax?: number
    notes: string
    created_at: string
  }[]
}>()

const visibleItems = ref<any[]>([])

onMounted(() => {
  const observer = new IntersectionObserver((entries) => {
    const [entry] = entries
    if (entry.isIntersecting) {
      revealItems()
      observer.disconnect()
    }
  }, {
    threshold: 0.1,
  })

  const section = document.querySelector('#guestbook')
  if (section) observer.observe(section)
})

function revealItems() {
  props.rsvps.forEach((item, index) => {
    setTimeout(() => {
      visibleItems.value.push(item)
    }, index * 150) // stagger each by 150ms
  })
}
</script>
<style scoped>
.fade-in-enter-active {
  transition: all 0.6s ease-in-out;
}

.fade-in-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.fade-in-enter-to {
  opacity: 1;
  transform: translateY(0);
}
</style>
<template>
  <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-transparent p-6 md:p-10">
    <div class="flex w-full flex-col gap-6">
      <div class="flex flex-col gap-6">
        <div class="isolate md:isolate-auto flex flex-col gap-4">
          <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
            aria-hidden="true">
            <div
              class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]"
              style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
          </div>

          <div class="flex flex-col gap-4 mb-4">
            <Separator class="my-8" />
            <div class="text-center">
              <h1 class="text-xl font-extrabold tracking-tight">Guests Book</h1>
              <p class="text-md text-muted-foreground tracking-tight">All wishes for bride & groom</p>
            </div>
            <Separator class="my-8" />

            <div class="grid grid-auto-rows md:grid-cols-2 gap-6 lg:grid-cols-3 overflow-y-auto max-h-[500px]">
              <TransitionGroup name="fade-in" tag="div" class="contents">
                <div v-for="(item, index) in visibleItems" :key="index">
                  <Alert :class="{
                    'bg-indigo-200/20 border-indigo-200 text-indigo-600 dark:bg-indigo-500/15 dark:border-indigo-600 dark:text-indigo-400': item.attendence == true,
                    'bg-yellow-200/20 border-amber-200 text-yellow-600 dark:bg-yellow-700/20 dark:border-yellow-600 dark:text-yellow-400': item.attendence == false,
                  }">
                    <AlertDescription class="pt-2 pb-2 relative overflow-hidden text-ellipsis">
                      <p class="italic text-md break-words" :class="{
                        'text-indigo-600 dark:text-indigo-400': item.attendence == true,
                        'text-yellow-600 dark:text-yellow-400': item.attendence == false,
                      }">
                        <svg class="w-4 h-4 mb-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                          <path
                            d="M7.17 3.1C4.57 5.08 3 8.03 3 11v7a3 3 0 0 0 3 3h3v-7H7v-2c0-1.61.79-3.09 2.11-4.03l-1.94-1.87zm9 0C13.57 5.08 12 8.03 12 11v7a3 3 0 0 0 3 3h3v-7h-2v-2c0-1.61.79-3.09 2.11-4.03l-1.94-1.87z" />
                        </svg>
                        "{{ item.notes }}"
                      </p>
                    </AlertDescription>
                    <AlertTitle>
                      <div class="flex items-center text-gray-800 dark:text-gray-200 gap-1">
                        {{ item.name }}
                        <component :is="item.attendence == true ? BadgeCheckIcon : MoonIcon"
                          :class="item.attendence == true ? 'text-green-500' : 'text-gray-500'"
                          class="h-3 w-3 flex shrink-0" aria-hidden="true" />
                      </div>
                    </AlertTitle>
                    <AlertTitle class="text-muted-foreground text-xs dark:text-muted-foreground/80">
                      {{ moment(item?.created_at).startOf('hour').fromNow() }}
                    </AlertTitle>
                  </Alert>
                </div>
              </TransitionGroup>
            </div>

            <div class="flex justify-end mt-4">
              <div class="flex flex-col text-right">
                <p class="text-md font-bold tracking-tight">
                  {{ event.event_name }}
                </p>
                <p class="text-sm text-muted-foreground tracking-tight">
                  {{ event.description }}
                </p>
              </div>
            </div>
          </div>

          <div aria-hidden="true"
            class="absolute inset-x-0 top-[calc(80%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(80%-30rem)]">
            <div
              class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"
              style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
