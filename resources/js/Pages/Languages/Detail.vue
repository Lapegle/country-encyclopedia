<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

defineProps({language: Object})
</script>

<template>
    <Head :title="language.name"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg flex justify-center p-8">
                    <h1 class="font-bold text-4xl text-center">{{ language.name }}</h1>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
