<script setup>
import { reactive, defineProps } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import FlightCard from '../../Components/FlightCard.vue';
import ReservationCard from '../../Components/ReservationCard.vue';
import GeneralLayout from '../../Layouts/GeneralLayout.vue';

const props = defineProps({
    flights: Object,
    reservations: Object,
    search: Object,
});

const flightSearchForm = useForm({
    origin: props.search.origin || '',
    destination: props.search.destination || '', 
    from: props.search.from || new Date().toISOString().slice(0, 10),
    to: props.search.to || '',
});

const reservationsContainer = reactive({
    show: false,
});

const toggleReservationsContainer = () => {
    reservationsContainer.show = !reservationsContainer.show;
};
console.log(props.flights)
</script>
<template>
    <Head title="Vuelos - Listado" />
    <GeneralLayout>
        <template #header>
            <h1 class="text-2xl font-bold">Vuelos</h1>
        </template>
        <div class="border-2 border-gray-100 rounded-lg overflow-hidden text-white">
            <button @click="toggleReservationsContainer" class="w-full">
                <div class="px-2 bg-slate-700">
                    <h2 class="text-xl">Mis Reservas</h2>
                </div>
            </button>
            <div v-if="reservations.length > 0" class="reservation-list" :class="{
                'hidden': !reservationsContainer.show,
            }">
                <ReservationCard
                    v-for="reservation in reservations"
                    :reservation="reservation"
                    :key="reservation.id"
                    class="w-full"
                />
            </div>
            <div v-else class="text-">
                No tienes reservas aún.
            </div>
        </div>
        <div>
            <div class="py-2">
                <h2 class="text-xl">Listado de Vuelos</h2>
            </div>
            <div class="border rounded-xl p-2">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-2">
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
                    <div>
                        <label for="from">Desde Día</label>
                        <vue-date-picker
                            id="to"
                            v-model="flightSearchForm.from"
                            class="p-1 w-full"
                        />
                    </div>
                    <div>
                        <label for="to">Hasta Día</label>
                        <vue-date-picker
                            id="to"
                            type="date"
                            v-model="flightSearchForm.to"
                            class="p-1 w-full"
                        />
                    </div>
                </div>
                <div >
                    <button class="button" @click="flightSearchForm.get('/flights')">
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
    @apply py-2 grid-cols-1 lg:grid-cols-3;
    display: grid;
    grid-gap: 1rem;
    overflow-y: auto;
}
.flight-list {
    @apply grid-cols-1 lg:grid-cols-3 border-2 rounded-xl mt-4 h-[21rem] xl:h-[25.5rem];
    display: grid;
    grid-gap: 1rem;
    overflow-y: auto;
}
</style>