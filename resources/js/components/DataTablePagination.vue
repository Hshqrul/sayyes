<script setup lang="ts">
import { type Table } from '@tanstack/vue-table'
import { type Task } from '../data/schema'
// import ChevronLeftIcon from '~icons/radix-icons/chevron-left'
// import ChevronRightIcon from '~icons/radix-icons/chevron-right'
// import DoubleArrowLeftIcon from '~icons/radix-icons/double-arrow-left'
// import DoubleArrowRightIcon from '~icons/radix-icons/double-arrow-right'

import { Button } from '@/components/ui/button'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'

interface DataTablePaginationProps {
    table: Table<Task>
}
defineProps<DataTablePaginationProps>()
</script>

<template>
    <div class="flex flex-row items-center justify-between py-4">
        <div class="flex-1 text-sm text-muted-foreground hidden lg:flex">
            {{ table.getFilteredSelectedRowModel().rows.length }} of
            {{ table.getFilteredRowModel().rows.length }} row(s) selected.
        </div>
        <div class="flex items-center space-x-6 lg:space-x-8">
            <div class="flex items-center space-x-0 lg:space-x-2">
                <p class="text-xs font-medium lg:text-sm">
                    Rows per page
                </p>
                <Select :model-value="`${table.getState().pagination.pageSize}`"
                    @update:model-value="table.setPageSize">
                    <SelectTrigger class="h-8 w-[70px] shadow-none">
                        <SelectValue :placeholder="`${table.getState().pagination.pageSize}`" />
                    </SelectTrigger>
                    <SelectContent side="right">
                        <SelectItem v-for="pageSize in [10, 20, 30, 40, 50]" :key="pageSize" :value="`${pageSize}`">
                            {{ pageSize }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <div class="flex w-[100px] items-center justify-center text-xs font-medium lg:text-sm">
                Page {{ table.getState().pagination.pageIndex + 1 }} of
                {{ table.getPageCount() }}
            </div>
            <div class="flex items-center space-x-0 lg:space-x-2">
                <Button variant="outline" class="hidden w-8 h-8 p-0 shadow-none lg:flex" :disabled="!table.getCanPreviousPage()"
                    @click="table.setPageIndex(0)">
                    <span class="sr-only">Go to first page</span>
                    <!-- <DoubleArrowLeftIcon class="w-4 h-4" /> -->
                    <ChevronDoubleLeftIcon class="w-4 h-4" />
                </Button>
                <Button variant="outline" class="w-8 h-8 p-0 shadow-none" :disabled="!table.getCanPreviousPage()"
                    @click="table.previousPage()">
                    <span class="sr-only">Go to previous page</span>
                    <ChevronLeftIcon class="w-4 h-4" />
                </Button>
                <Button variant="outline" class="w-8 h-8 p-0 shadow-none" :disabled="!table.getCanNextPage()"
                    @click="table.nextPage()">
                    <span class="sr-only">Go to next page</span>
                    <ChevronRightIcon class="w-4 h-4" />
                </Button>
                <Button variant="outline" class="hidden w-8 h-8 p-0 shadow-none lg:flex" :disabled="!table.getCanNextPage()"
                    @click="table.setPageIndex(table.getPageCount() - 1)">
                    <span class="sr-only">Go to last page</span>
                    <ChevronDoubleRightIcon class="w-4 h-4" />
                </Button>
            </div>
        </div>
    </div>
</template>