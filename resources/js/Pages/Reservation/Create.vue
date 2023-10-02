<script setup>
import { useForm, Link, Head } from '@inertiajs/vue3';
import GeneralLayout from '../../Layouts/GeneralLayout.vue';
import Datapill from '../../Components/Datapill.vue';

const props = defineProps({
    flight: {
        type: Object,
        required: true,
    },
    return_route: {
        type: String,
        required: false,
    },
});

const form = useForm({
    flight_id: props.flight.id,
    seats: 0,
});
</script>

<template>
    <Head title="Vuelos - Crear Reserva" />
    <GeneralLayout>
        <template #header>
            <h1 class="text-2xl font-bold">Crear Reserva de Vuelo</h1>
            <div class="mt-4">
                <Link class="button button-secondary" :href="return_route || '/flights'">Regresar</Link>
            </div>
        </template>
        <div class="flex flex-col">
            <div class="mx-auto">
                <div class="flex flex-col gap-2">
                    <h2 class="text-xl font-bold">Detalles del Vuelo</h2>
                    <div class="flex flex-col w-fit gap-2">
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
                    <div class="py-6">
                        <div class="flex flex-col border rounded-xl overflow-hidden">
                            <label for="seats" class="px-2 bg-gray-700 text-white">¿Cuanto asientos necesita?</label>
                            <input id="seats" type="number" v-model="form.seats" min="1" class="px-4 rounded-b-xl"/>
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
            </div>
        </div>
    </GeneralLayout>
</template>