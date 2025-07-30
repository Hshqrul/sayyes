<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { useColorMode } from '@vueuse/core'
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Monitor, Moon, Sun } from 'lucide-vue-next'

// Pass { disableTransition: false } to enable transitions
const mode = useColorMode()
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost">
                <Moon class="h-[1.2rem] w-[1.2rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" />
                <Sun class="absolute h-[1.2rem] w-[1.2rem] rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" />
                <span class="sr-only">Toggle theme</span>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuItem @click="mode = 'light'">
                <Sun class="mr-2 h-4 w-4" />
                Light
            </DropdownMenuItem>
            <DropdownMenuItem @click="mode = 'dark'">
                <Moon class="mr-2 h-4 w-4" />
                Dark
            </DropdownMenuItem>
            <DropdownMenuItem @click="mode = 'auto'">
                <Monitor class="mr-2 h-4 w-4" />
                System
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>