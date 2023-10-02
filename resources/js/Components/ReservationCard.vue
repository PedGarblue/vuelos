<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    reservation: Object,
});
</script>

<template>
    <Link :href="`/reservations/${reservation.id}`">
        <div class="reservation-card">
            <div class="bg-sky-700 text-white px-4 py-2">
                <h3 class="text-xl font-bold">
                    <span>{{ reservation.flight.origin }}</span> to <span>{{ reservation.flight.destination }}</span>
                </h3>
            </div>
            <div class="px-4 py-1">
                <p class="text-gray-500 text-sm">Departure: {{ reservation.flight.departure }}</p>
                <p class="text-gray-500 text-sm">Arrival: {{ reservation.flight.arrival }}</p>
            </div>
            <div class="px-4 py-1">
                <div class="flex">
                    <div class="ml-auto">
                        <span>Asientos:</span>
                        <span class="ml-1">{{ reservation.tickets.length }}</span>
                    </div>
                </div>
            </div>
        </div>
    </Link>
</template>

<style lang="postcss" scoped>
.reservation-card {
    @apply border-2 border-gray-200;
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}
.reservation-card:hover {
    transform: translateY(-0.25rem);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}
</style>