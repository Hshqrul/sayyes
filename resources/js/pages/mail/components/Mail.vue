<script lang="ts" setup>
import type { Mail } from '../data/mail'
import { refDebounced } from '@vueuse/core'
import {
    Search,
    X,
} from 'lucide-vue-next'
import { computed, ref } from 'vue'
import { Input } from '@/components/ui/input'
import { Separator } from '@/components/ui/separator'
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/components/ui/tabs'
import { TooltipProvider } from '@/components/ui/tooltip'
import MailListDisplay from './MailList.vue'

interface MailProps {
    accounts: {
        label: string
        email: string
        icon: string
    }[]
    mails: Mail[]
    defaultLayout?: number[]
    defaultCollapsed?: boolean
    navCollapsedSize: number
}

const props = withDefaults(defineProps<MailProps>(), {
    defaultCollapsed: false,
    defaultLayout: () => [265, 440, 655],
})

const isCollapsed = ref(props.defaultCollapsed)
const selectedMail = ref<string | undefined>(props.mails[0].id)
const searchValue = ref('')
const debouncedSearch = refDebounced(searchValue, 250)

const filteredMailList = computed(() => {
    let output: Mail[] = []
    const searchValue = debouncedSearch.value?.trim()
    if (!searchValue) {
        output = props.mails
    }

    else {
        output = props.mails.filter((item) => {
            const searchValue = debouncedSearch.value.toLowerCase();
            return item.name.toLowerCase().includes(searchValue)
                || item.email.toLowerCase().includes(searchValue)
                || item.subject.toLowerCase().includes(searchValue)
                || item.text.toLowerCase().includes(searchValue)
                || item.labels.some(label => label.toLowerCase().includes(searchValue));
        })
    }

    return output
})

const unreadMailList = computed(() => filteredMailList.value.filter(item => !item.read))

const selectedMailData = computed(() => props.mails.find(item => item.id === selectedMail.value))

const clearSearchValue = () => {
    searchValue.value = ''
}

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        clearSearchValue()
    }
})

</script>

<template>
    <TooltipProvider :delay-duration="0">
        <div class="flex-l">
            <Tabs default-value="all">
                <div class="flex items-center px-4 py-2">
                    <form class="w-full max-w-[175px] md:max-w-[800px]">
                        <div class="relative">
                            <Search class="absolute left-2 top-2.5 size-4 text-muted-foreground" />
                            <Input v-model="searchValue" placeholder="Search" class="pl-8 pr-8" />
                            <button v-if="searchValue" type="button"
                                class="absolute right-2 top-1 p-1.5 hover:bg-background/50 transition duration-200"
                                @click="clearSearchValue">
                                <X class="size-4 text-muted-foreground" />
                            </button>
                        </div>
                    </form>
                    <TabsList class="ml-auto">
                        <TabsTrigger value="all" class="group text-zinc-600 dark:text-zinc-200">
                            All
                            <!-- <span
                                class="ml-1 inline-flex items-center justify-center rounded-full text-xs text-slate-400 group-data-[state=active]:text-blue-500">
                                {{ filteredMailList.length }}
                            </span> -->
                        </TabsTrigger>

                        <TabsTrigger value="unread" class="group text-zinc-600 dark:text-zinc-200">
                            Unread
                            <!-- <span
                                class="ml-1 inline-flex items-center justify-center rounded-full text-xs text-slate-400 group-data-[state=active]:text-red-500">
                                {{ unreadMailList.length }}
                            </span> -->
                        </TabsTrigger>
                    </TabsList>
                </div>
                <Separator />
                <TabsContent value="all" class="m-0">
                    <MailListDisplay v-model:selected-mail="selectedMail" :items="filteredMailList" />
                </TabsContent>
                <TabsContent value="unread" class="m-0">
                    <MailListDisplay v-model:selected-mail="selectedMail" :items="unreadMailList" />
                </TabsContent>
            </Tabs>
        </div>
    </TooltipProvider>
</template>