<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({country: Object})
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg flex justify-center p-8">
                    Detail
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
