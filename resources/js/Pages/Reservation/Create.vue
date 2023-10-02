<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GeneralLayout from '../../Layouts/GeneralLayout.vue';
import Datapill from '../../Components/Datapill.vue';

const props = defineProps({
    flight: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    flight_id: props.flight.id,
    seats: 0,
});
</script>

<template>
    <GeneralLayout>
        <template #header>
            <h1 class="text-2xl">Crear Reserva de Vuelo</h1>
            <div>
                <Link class="button" href="/flights">Regresar</Link>
            </div>
        </template>
        <div>
            <h2 class="text-xl font-bold">Detalles del Vuelo</h2>
            <div class="flex flex-col w-fit">
                <datapill title="Origen" :value="props.flight.origin" />
                <datapill title="Destino" :value="props.flight.destination" />
                <datapill title="Salida" :value="props.flight.departure" />
                <datapill title="Llegada" :value="props.flight.arrival" />
                <datapill title="Asientos Disponibles" :value="props.flight.available_seats" />
            </div>
        </div>
        <form
            class="flex flex-col w-fit"
            @submit.prevent="form.post(`/reservations`)"
        >
            <div>
                <div class="flex flex-col">
                    <label for="seats">Asientos</label>
                    <input id="seats" type="number" v-model="form.seats" />
                    <!-- input error message -->
                    <div v-if="form.errors.seats">
                        <span class="text-red-500" v-for="error in form.errors.seats" :key="error">
                            {{ error }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex flex-col">
                    <button type="submit" class="button">Crear</button>
                </div>
            </div>
        </form>
    </GeneralLayout>
</template>