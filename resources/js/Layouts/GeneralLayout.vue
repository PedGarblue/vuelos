<template>
    <div 
        class="
            min-h-screen
            min-w-screen
            flex flex-col 
            sm:justify-center
            items-center
            pt-6
            sm:pt-0
            bg-gradient-to-br
            from-blue-900
            to-gray-900
        ">
        <div
            class="
                sm:w-[75vw]
                sm:h-[80vh]
                w-full
                h-full
                px-6 py-4
                bg-white
                dark:bg-gray-800
                shadow-md
                overflow-hidden
                sm:rounded-lg
                "
        >
            <div v-if="$slots.header" class="my-8">
                <slot name="header" />
            </div>
            <slot />
        </div>
    </div>
</template>
