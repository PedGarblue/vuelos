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
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800">
                    <div>
                        <ApplicationLogo class="h-20"/>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">¡Bienvenidos a Vuelos App!</div>
                    <Link 
                        :href="flights_url"
                    >
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ver vuelos
                        </button>
                    </Link>
                    </div>
                </div>
            </div>
    </GeneralLayout>
</template>