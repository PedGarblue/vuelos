<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    flight: Object,
});
</script>
<template>
    <Link :href="`/flights/${flight.id}/reserve`">
        <div class="flight-card">
            <div class="bg-slate-700 text-white px-4 py-2">
                <h3 class="text-xl font-bold">
                    <span>{{ flight.origin }}</span> to <span>{{ flight.destination }}</span>
                </h3>
            </div>
            <div class="px-4 py-1">
                <p class="text-gray-500 text-sm">Departure: {{ flight.departure }}</p>
                <p class="text-gray-500 text-sm">Arrival: {{ flight.arrival }}</p>
            </div>
            <div class="px-4 py-1 bg-gray-200">
                <div class="flex">
                    <div class="ml-auto">
                        <span class="h-full">Asientos disponibles</span>
                        <span class="ml-1" :class="{
                            
                        }">{{ flight.available_seats }}</span>
                    </div>
                </div>
            </div>
        </div>
    </Link>
</template>

<style scoped>
.flight-card {
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}
.flight-card:hover {
    transform: translateY(-0.25rem);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}
</style>
