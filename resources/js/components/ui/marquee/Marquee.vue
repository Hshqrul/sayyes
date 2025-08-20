<template>
  <div :class="cn(
    'group flex overflow-hidden p-2 [--duration:40s] [--gap:1rem] [gap:var(--gap)]',
    vertical ? 'flex-col' : 'flex-row',
    $props.class,
  )
    " @click="togglePause">
    <div v-for="index in repeat" :key="index" :class="cn(
      'flex shrink-0 justify-around [gap:var(--gap)]',
      vertical ? 'animate-marquee-vertical flex-col' : 'animate-marquee flex-row',
      pauseOnHover ? 'group-hover:[animation-play-state:paused]' : '',
    )
      " :style="{
        animationDirection: reverse ? 'reverse' : 'normal',
        animationPlayState: isPaused ? 'paused' : 'running',
      }">
      <slot />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { cn } from "@/lib/utils";
import { ref } from "vue";

const props = withDefaults(
  defineProps<{
    class?: string;
    reverse?: boolean;
    pauseOnHover?: boolean;
    pauseOnClick?: boolean;
    vertical?: boolean;
    repeat?: number;
  }>(),
  {
    pauseOnHover: false,
    pauseOnClick: false,
    vertical: false,
    repeat: 4,
  },
);

const isPaused = ref(false);

function togglePause() {
  if (props.pauseOnClick) {
    isPaused.value = !isPaused.value;
  }
}
</script>

<style scoped>
.animate-marquee {
  animation-name: marquee;
  animation-duration: var(--duration);
  animation-timing-function: linear;
  animation-iteration-count: infinite;
  /* ❌ remove this */
  /* animation-direction: reverse; */
}

.animate-marquee-vertical {
  animation: marquee-vertical var(--duration) linear infinite;
}

@keyframes marquee {
  from {
    transform: translateX(0);
  }

  to {
    transform: translateX(calc(-100% - var(--gap)));
  }
}

@keyframes marquee-vertical {
  from {
    transform: translateY(0);
  }

  to {
    transform: translateY(calc(-100% - var(--gap)));
  }
}
</style>
