<script lang="ts" setup>
// import type { Mail } from '../data/mail'
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
import Icon from '@/components/Icon.vue'

interface Mail {
    id: string | null
    user: string | null
    subject: string | null
    text: string | null
    read: boolean
    labels: string | null
    created_at: string | null
}

interface MailProps {
    // accounts: {
    //     label: string
    //     email: string
    //     icon: string
    // }[]
    mails: Mail[]
    // defaultLayout?: number[]
    // defaultCollapsed?: boolean
    // navCollapsedSize: number
}

const props = defineProps<MailProps>()
// const isCollapsed = ref(props.defaultCollapsed)
const selectedMail = ref<string | undefined>(props.mails.length > 0 ? props.mails[0].id : undefined)
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
            return item.user.name.toLowerCase().includes(searchValue)
                || item.user.email.toLowerCase().includes(searchValue)
                || item.subject.toLowerCase().includes(searchValue)
                || item.text.toLowerCase().includes(searchValue)
                || item.labels.some(label => label.toLowerCase().includes(searchValue));
        })
    }

    return output
})

const unreadMailList = computed(() => filteredMailList.value.filter(item => !item.read))
const readMailList = computed(() => filteredMailList.value.filter(item => item.read))
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
        <div class="flex-1">
            <Tabs default-value="all">
                <div class="flex items-center px-4 py-2">
                    <form class="w-45 md:w-auto flex-initial">
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
                            <p class="hidden md:block">
                                All
                            </p>
                            <Icon name="Mails" class="size-3.5 block md:hidden  text-muted-foreground" />
                        </TabsTrigger>
                        <TabsTrigger value="unread" class="group text-zinc-600 dark:text-zinc-200">
                            <p class="hidden md:block">
                                Unread
                            </p>
                            <Icon name="MailOpen" class="size-3.5 block md:hidden  text-muted-foreground" />
                        </TabsTrigger>
                        <TabsTrigger value="read" class="group text-zinc-600 dark:text-zinc-200">
                            <p class="hidden md:block">
                                Read
                            </p>
                            <Icon name="Mail" class="size-3.5 block md:hidden  text-muted-foreground" />
                        </TabsTrigger>
                    </TabsList>
                </div>
                <Separator />
                <TabsContent value="all" class="m-0">
                    <MailListDisplay v-model:selectedMail="selectedMail" :items="filteredMailList" />
                    <div class="ml-1 flex items-center justify-center rounded-full py-1 text-xs text-muted-foreground">
                        {{ filteredMailList.length }} of {{ props.mails.length }}
                    </div>
                </TabsContent>
                <TabsContent value="unread" class="m-0">
                    <MailListDisplay v-model:selectedMail="selectedMail" :items="unreadMailList" />
                    <div class="ml-1 flex items-center justify-center rounded-full py-1 text-xs text-muted-foreground">
                        {{ unreadMailList.length }} ( Missed ) of {{ props.mails.length }}
                    </div>
                </TabsContent>
                <TabsContent value="read" class="m-0">
                    <MailListDisplay v-model:selectedMail="selectedMail" :items="readMailList" />
                    <div class="ml-1 flex items-center justify-center rounded-full py-1 text-xs text-muted-foreground">
                        {{ readMailList.length }} ( Read ) of {{ props.mails.length }}
                    </div>
                </TabsContent>
            </Tabs>
        </div>
    </TooltipProvider>
</template>