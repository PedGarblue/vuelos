<script setup>
import { useForm, Link } from '@inertiajs/vue3';
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

</script>
<template>
    <GeneralLayout>
        <template #header>
            <h1 class="text-2xl mb-4 font-bold">Ver Reserva de Vuelo</h1>
            <div class="flex gap-4">
                <Link href="/flights" class="button button-secondary">Regresar</Link>
                <form @submit.prevent="deleteform.delete(`/reservations/${reservation.id}`)">
                    <button type="submit" class="button button-danger" >Eliminar Reserva</button>
                </form>
            </div>
        </template>
        <div class="flex flex-col lg:flex-row">
            <div class="mx-auto">
                <section>
                    <h2 class="text-xl font-bold">Detalles del Vuelo</h2>
                    <div class="section__body">
                        <datapill title="Origen" :value="reservation.flight.origin" />
                        <datapill title="Destino" :value="reservation.flight.destination" />
                        <datapill title="Salida" :value="reservation.flight.departure" />
                        <datapill title="Llegada" :value="reservation.flight.arrival" />
                        <datapill title="Asientos Disponibles" :value="reservation.flight.available_seats" />
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold">Detalles de la Reserva</h2>
                    <div class="section__body">
                        <datapill title="Asientos" :value="reservation.tickets.length" />
                        <datapill title="Creado" :value="reservation.created_at" />
                        <datapill title="Actualizado" :value="reservation.updated_at" />
                    </div>
                </section>
            </div>
            <div class="mx-auto mt-4 lg:mt-0">
                <section>
                    <h2 class="text-xl font-bold">Actualizar Reserva</h2>
                    <form
                        class="section__body"
                        @submit.prevent="form.put(`/reservations/${reservation.id}`)"
                    >
                        <div>
                            <div class="field">
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
                </section>
            </div>
        </div>
    </GeneralLayout>    
</template>

<style lang="postcss" scoped>
section {
    @apply flex flex-col gap-2 first:mt-0 last:mb-0 my-4;
}
.section__body {
    @apply flex flex-col w-fit gap-2;
}

.field {
    @apply flex flex-col border rounded-xl overflow-hidden;
}

.field label {
    @apply px-2 bg-gray-700 text-white;
}
.field input {
    @apply px-4 rounded-b-xl;
}
</style>