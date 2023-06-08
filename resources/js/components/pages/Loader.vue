<template>
    <div class="border border-blue-300  p-4 max-w-sm w-full mx-auto min-h-full" :class="{'hidden' : curr_weather}">
        <div class="animate-pulse flex space-x-4">
            <div class="flex-1 space-y-6 py-1">
            <div class="h-2 bg-slate-200 rounded"></div>
            <div class="space-y-3" v-for="() in 4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                    <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                </div>
                <div class="h-2 bg-slate-200 rounded"></div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                    <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                </div>
                <div class="h-2 bg-slate-200 rounded"></div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['curr_weather'],
    }
</script>