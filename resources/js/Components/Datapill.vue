<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
});
</script>

<template>
    <div class="datafield">
        <span class="datafield__label">{{ title }}</span>
        <span class="datafield__value">{{ value }}</span>
    </div>
</template>

<style lang="postcss" scoped>
.datafield {
    @apply border-2 rounded-lg w-full flex overflow-hidden;
}
.datafield__label {
    @apply px-2 bg-blue-900 text-white;
}
.datafield__value {
    @apply px-2;
}
</style>