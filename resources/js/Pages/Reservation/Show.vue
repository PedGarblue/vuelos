<script setup>
import { useForm } from '@inertiajs/vue3';
import GeneralLayout from '../../Layouts/GeneralLayout.vue';
import Datapill from '../../Components/Datapill.vue';

const props = defineProps({
    reservation: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    seats: props.reservation.tickets.length,
});

const deleteform = useForm({});

const deleteReservation = () => {
    if (confirm('¿Estás seguro de eliminar esta reserva?')) {
        deleteform.delete(`/reservations/${reservation.id}`);
    }
};
</script>
<template>
    <GeneralLayout>
        <template #header>
            <h1 class="text-2xl">Ver Reserva de Vuelo</h1>
        </template>
        <div>
            <h2 class="text-xl font-bold">Detalles del Vuelo</h2>
            <div class="flex flex-col w-fit">
                <datapill title="Origen" :value="reservation.flight.origin" />
                <datapill title="Destino" :value="reservation.flight.destination" />
                <datapill title="Salida" :value="reservation.flight.departure" />
                <datapill title="Llegada" :value="reservation.flight.arrival" />
                <datapill title="Asientos Disponibles" :value="reservation.flight.available_seats" />
            </div>
        </div>
        <div>
            <h2 class="text-xl font-bold">Detalles de la Reserva</h2>
            <div class="flex flex-col w-fit">
                <datapill title="Asientos" :value="reservation.tickets.length" />
                <datapill title="Creado" :value="reservation.created_at" />
                <datapill title="Actualizado" :value="reservation.updated_at" />
            </div>
        </div>
        <div>
            <h2 class="text-xl font-bold">Actualizar Reserva</h2>
            <form
                class="flex flex-col w-fit"
                @submit.prevent="form.put(`/reservations/${reservation.id}`)"
            >
                <div>
                    <div class="flex flex-col">
                        <label for="seats">Asientos</label>
                        <input id="seats" type="number" v-model="form.seats" />
                        <div v-if="form.errors.seats">
                            <span class="text-red-500" v-for="error in form.errors.seats" :key="error">
                                {{ error }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="flex flex-col">
                        <button type="submit" class="button">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <form @submit.prevent="deleteform.delete(`/reservations/${reservation.id}`)">
                <button type="submit" class="button" >Eliminar Reserva</button>
            </form>
        </div>
    </GeneralLayout>    
</template>