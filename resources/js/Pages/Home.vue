<script setup>
import ApplicationLogo from '../Components/ApplicationLogo.vue';
import GeneralLayout from '../Layouts/GeneralLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    flights_url: String,
});
</script>

<template>
    <Head title="Home"/>

    <GeneralLayout>
        <div class="flex h-full w-full">
            <div class="my-auto mx-auto">
                <div class="p-6 text-gray-900 text-3xl">¡Bienvenidos a Vuelos App!</div>
                <div class="flex py-4">
                    <ApplicationLogo class="mx-auto text-[10rem] text-black"/>
                </div>
                <div class="flex flex-col">
                    <Link 
                        :href="flights_url"
                        class="mx-auto"
                    >
                        <button class="button text-xl">
                            Ver vuelos
                        </button>
                    </Link>

                </div>
            </div>
        </div>
    </GeneralLayout>
</template>