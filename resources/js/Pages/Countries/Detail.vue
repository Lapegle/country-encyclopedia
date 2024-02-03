<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import TextInfoItem from "@/Components/TextInfoItem.vue";

defineProps({country: Object})
</script>

<template>
    <Head :title="country.common_name"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg flex justify-center p-8">
                    <div>
                        <h1 class="font-bold text-4xl text-center">{{ country.common_name }}</h1>
                        <div class="flex flex-col sm:flex-row-reverse mt-4">
                            <div class="sm:ml-52 flex justify-center">
                                <img
                                    :alt="'Flag of ' + country.official_name"
                                    :src="country.flag_url"
                                    class="w-48"
                                />
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <TextInfoItem :value="country.official_name" description="Official name"/>
                                <TextInfoItem :value="country.country_code.toUpperCase()" description="Country code"/>
                                <TextInfoItem :value="country.population" description="Population"/>
                                <TextInfoItem :value="country.area" description="Area (km²)"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
