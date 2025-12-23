<script setup lang="ts">
import { Cloud } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
    Empty,
    EmptyContent,
    EmptyDescription,
    EmptyHeader,
    EmptyMedia,
    EmptyTitle,
} from '@/components/ui/empty'
</script>

<template>
    <Empty class="border border-dashed">
        <EmptyHeader>
            <EmptyMedia variant="icon">
                <Cloud />
            </EmptyMedia>
            <EmptyTitle>Wishes Empty</EmptyTitle>
            <EmptyDescription>
                Be the first person to wish!
            </EmptyDescription>
        </EmptyHeader>
        <EmptyContent>
            <Button size="sm">
                <a href="#rsvp-form">
                    Click Here
                </a>
            </Button>
        </EmptyContent>
    </Empty>
</template>
