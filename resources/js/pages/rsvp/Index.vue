<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'
import type { ColumnDef, ColumnFiltersState, SortingState } from '@tanstack/vue-table'
import {
    FlexRender, getCoreRowModel, useVueTable, getPaginationRowModel,
    getFilteredRowModel, getSortedRowModel,
} from '@tanstack/vue-table'
import type { FilterFn } from '@tanstack/table-core'
import {
    Table, TableBody, TableCell, TableHead, TableHeader, TableRow,
} from '@/components/ui/table'
import moment from 'moment'
import { Input } from '@/components/ui/input'
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import { h, ref } from 'vue'
import { valueUpdater } from '@/components/ui/table/utils'
import ActionDropdownTable from './ActionDropdownTable.vue'
import DataTablePagination from '@/components/DataTablePagination.vue'
import Skeleton from '@/components/ui/skeleton/Skeleton.vue'
import DataTableViewOptions from '@/components/DataTableViewOptions.vue'
import DataTableColumnHeader from '@/components/DataTableColumnHeader.vue'
import { SearchIcon } from 'lucide-vue-next'
import Badge from '@/components/ui/badge/Badge.vue'

const globalFilter = ref('')
const loading = ref(true)
const props = defineProps<{
    data: {
        id: number
        name: string
        no_of_pax: number
        attendence: boolean
        notes: string
        created_at: string
    }[]
    event: {
        id: number,
        event_name: string
        description: string
        event_date: string
    }
}>()

const columns: ColumnDef<typeof props.data[0]>[] = [
    {
        id: 'index',
        header: 'No.',
        cell: ({ row }) => row.index + 1,
        enableGlobalFilter: false,
    },
    {
        accessorKey: 'name',
        header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Guest Name' }),
        enableSorting: true,
    },
    {
        accessorKey: 'no_of_pax',
        header: 'No. of Pax'
    },
    {
        accessorKey: 'attendence',
        header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Attendence' }),
        cell: ({ getValue }) => (getValue() ? 'Yes' : 'No'),
        enableSorting: true,
    },
    {
        accessorKey: 'notes',
        header: 'Notes',
        meta: { class: 'w-[100px]' }
    },
    {
        accessorKey: 'created_at',
        header: 'Created At',
        cell: ({ getValue }) => moment(getValue()).format('MMM DD, yyyy, h:mm a'),
    },
    {
        id: 'actions',
        header: 'Actions',
        enableHiding: false,
        cell: ({ row }) => {
            return h(ActionDropdownTable, {
                id: row.original.id,
                name: row.original.name,
                attendence: row.original.attendence,
                no_of_pax: row.original.no_of_pax,
                notes: row.original.notes,
                created_at: row.original.created_at
            })
        },
    },
]

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])

const fuzzyFilter: FilterFn<any> = (row, columnId, value, addMeta) => {
    return String(row.getValue(columnId) ?? '').toLowerCase().includes(String(value).toLowerCase())
}

const table = useVueTable({
    data: props.data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    onGlobalFilterChange: updaterOrValue => valueUpdater(updaterOrValue, globalFilter),
    state: {
        get sorting() { return sorting.value },
        get columnFilters() { return columnFilters.value },
        get globalFilter() { return globalFilter.value },
    },
    globalFilterFn: fuzzyFilter,
})

setTimeout(() => {
    loading.value = false
}, 1500)
</script>

<template>

    <Head :title="`Guest List - ${event.event_name}`" />
    <AppLayout :breadcrumbs="[
        { title: 'Event List', href: '/events' },
        { title: 'Guest List', href: `/events/${event.id}/rsvps` }
    ]">
        <div class="flex h-full flex-1 flex-col gap-4 p-2 overflow-x-auto md:p-6">
            <div class="flex flex-row items-center justify-between p-2">
                <h1 class="text-2xl font-bold leading-tight tracking-tight">Guest List</h1>
                <Badge>
                    {{ event.event_name }}
                </Badge>
            </div>

            <Card class="md:w-full shadow-xs">
                <CardContent>
                    <div class="flex flex-row items-center justify-between py-4">
                        <div class="relative md:w-1/2 lg:w-full max-w-xs items-center">
                            <Input class="pl-8" placeholder="Search guests..." :model-value="globalFilter"
                                @update:model-value="globalFilter = $event" />
                            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                                <SearchIcon class="size-4 text-muted-foreground" />
                            </span>
                        </div>
                        <DataTableViewOptions :table="table" />
                    </div>
                    <div class="border rounded-md">
                        <Table>
                            <TableHeader>
                                <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                                    <TableHead v-for="header in headerGroup.headers" :key="header.id">
                                        <FlexRender v-if="!header.isPlaceholder"
                                            :render="header.column.columnDef.header" :props="header.getContext()" />
                                    </TableHead>
                                </TableRow>
                            </TableHeader>

                            <TableBody>
                                <!-- Skeleton Loader -->
                                <template v-if="loading">
                                    <TableRow v-for="i in 10" :key="i">
                                        <TableCell v-for="j in columns.length" :key="j" class="h-12">
                                            <Skeleton class="w-full h-4 rounded" />
                                        </TableCell>
                                    </TableRow>
                                </template>

                                <!-- Real Data -->
                                <template v-else-if="table.getRowModel().rows?.length">
                                    <TableRow v-for="row in table.getRowModel().rows" :key="row.id">
                                        <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id"
                                            :class="cell.column.columnDef.meta?.class">
                                            <FlexRender :render="cell.column.columnDef.cell"
                                                :props="cell.getContext()" />
                                        </TableCell>
                                    </TableRow>
                                </template>

                                <!-- Empty State -->
                                <template v-else>
                                    <TableRow>
                                        <TableCell :colspan="columns.length" class="h-24 text-center">
                                            No results.
                                        </TableCell>
                                    </TableRow>
                                </template>
                            </TableBody>
                        </Table>
                    </div>
                    <DataTablePagination :table="table" />
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

<!-- <template>

    <Head :title="`Guest List - ${event.event_name}`" />
    <AppLayout :breadcrumbs="[
        { title: 'Event List', href: '/event' },
        { title: 'Guest List', href: `/events/${event.id}/rsvps` }
    ]">
        <div class="flex h-full flex-1 flex-col gap-4 p-2 overflow-x-auto md:p-6">
            <div class="flex flex-row items-center justify-between p-2">
                <h1 class="text-2xl font-bold leading-tight tracking-tight">GuestList</h1>
                <p class="text-sm text-muted-foreground">{{ event.event_name }}</p>
            </div>
            <Card class="md:w-full shadow-xs">
                <CardContent>
                    <div class="flex items-center justify-end py-4">
                        <Input class="max-w-sm" placeholder="Filter name..."
                            :model-value="table.getColumn('name')?.getFilterValue() as string"
                            @update:model-value=" table.getColumn('name')?.setFilterValue($event)" />
                    </div>
                    <div class="border rounded-md">
                        <Table>
                            <TableHeader>
                                <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                                    <TableHead v-for="header in headerGroup.headers" :key="header.id">
                                        <FlexRender v-if="!header.isPlaceholder"
                                            :render="header.column.columnDef.header" :props="header.getContext()" />
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <template v-if="table.getRowModel().rows?.length">
                                    <TableRow v-for="row in table.getRowModel().rows" :key="row.id">
                                        <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                            <FlexRender :render="cell.column.columnDef.cell"
                                                :props="cell.getContext()" />
                                        </TableCell>
                                    </TableRow>
                                </template>
                                <template v-else>
                                    <TableRow>
                                        <TableCell :colspan="columns.length" class="h-24 text-center">
                                            No results.
                                        </TableCell>
                                    </TableRow>
                                </template>
                            </TableBody>
                        </Table>
                    </div>
                    <div class="flex items-center justify-end space-x-2 py-4">
                        <div class="flex-1 text-sm text-muted-foreground">
                            {{ table.getFilteredSelectedRowModel().rows.length }} of
                            {{ table.getFilteredRowModel().rows.length }} row(s) selected.
                        </div>
                        <div class="space-x-2">
                            <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()"
                                @click="table.previousPage()">
                                Previous
                            </Button>
                            <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()"
                                @click="table.nextPage()">
                                Next
                            </Button>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template> -->