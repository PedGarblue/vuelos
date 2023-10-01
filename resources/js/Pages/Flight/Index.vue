<script setup>
import GeneralLayout from '../../Layouts/GeneralLayout.vue';


defineProps({
    flights: Object,
});
</script>
<template>
    <GeneralLayout>
        <template #header>
            <h1 class="text-2xl font-bold">Flights</h1>
        </template>
        <div>
            <div class="flight-list">
                <div v-for="flight in flights" class="flight-card">
                    <div class="bg-slate-700 text-white px-4 py-2">
                        <h3 class="text-xl font-bold">
                            <span>{{ flight.origin }}</span> to <span>{{ flight.destination }}</span>
                        </h3>
                    </div>
                    <p class="text-gray-500 text-sm">Departure: {{ flight.departure }}</p>
                    <p class="text-gray-500 text-sm">Arrival: {{ flight.arrival }}</p>
                </div>
            </div>
        </div>
    </GeneralLayout>
</template>

<style>
.flight-list {
    display: grid;
    grid-template-columns: repeat(3, minmax(18rem, 100%));
    grid-gap: 1rem;
}
.flight-card {
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.1);
    overflow: hidden;
}
</style>