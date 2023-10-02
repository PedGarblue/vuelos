<script setup>
import { useForm } from '@inertiajs/vue3';
import FlightCard from '../../Components/FlightCard.vue';
import ReservationCard from '../../Components/ReservationCard.vue';
import GeneralLayout from '../../Layouts/GeneralLayout.vue';


defineProps({
    flights: Object,
    reservations: Object,
});

const flightSearchForm = useForm({
    origin: '',
    destination: '',
});
</script>
<template>
    <GeneralLayout>
        <template #header>
            <h1 class="text-2xl font-bold">Vuelos</h1>
        </template>
        <div class="border-2 border-gray-100 rounded-lg px-2 py-2">
            <div class="px-2">
                <h2 class="text-xl">Mis Reservas</h2>
            </div>
            <div v-if="reservations.length > 0" class="reservation-list">
                <ReservationCard
                    v-for="reservation in reservations"
                    :reservation="reservation"
                    :key="reservation.id"
                />
            </div>
            <div v-else>
                No tienes reservas aún.
            </div>
        </div>
        <div>
            <div class="py-2">
                <h2 class="text-xl">Listado de Vuelos</h2>
            </div>
            <div class="border rounded-xl p-2">
                <div class="flex gap-4 mb-2">
                    <div>
                        <label for="origin">Origen</label>
                        <input
                            id="origin"
                            type="text"
                            v-model="flightSearchForm.origin"
                            class="border rounded-lg p-2 w-full"
                        />
                    </div>
                    <div>
                        <label for="destination">Destino</label>
                        <input
                            id="destination"
                            type="text"
                            v-model="flightSearchForm.destination"
                            class="border rounded-lg p-2 w-full"
                        />
                    </div>
                </div>
                <div >
                    <button class="bg-blue-500 text-white rounded-lg p-2" @click="flightSearchForm.get('/flights')">
                        Buscar
                    </button>
                </div>
            </div>
            <div class="flight-list">
                <FlightCard v-for="flight in flights" :flight="flight" :key="flight.id" />
            </div>
        </div>
    </GeneralLayout>
</template>

<style>
.reservation-list {
    @apply py-2;
    display: grid;
    grid-template-columns: repeat(3, minmax(18rem, 100%));
    grid-gap: 1rem;
    overflow-y: auto;
}
.flight-list {
    @apply py-2;
    display: grid;
    grid-template-columns: repeat(3, minmax(18rem, 100%));
    grid-gap: 1rem;
    overflow-y: auto;
}
</style>