<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import TextInfoItem from "@/Components/TextInfoItem.vue";
import PillLink from "@/Components/PillLink.vue";

const props = defineProps({country: Object})
</script>

<template>
    <Head :title="country.common_name"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg flex justify-center p-8">
                    <div class="max-w-3xl">
                        <h1 class="font-bold text-4xl text-center">{{ country.common_name }}</h1>
                        <div class="flex flex-col sm:flex-row-reverse justify-between mt-4">
                            <div class="sm:ml-52 flex flex-col justify-center items-center">
                                <img
                                    :alt="'Flag of ' + country.official_name"
                                    :src="country.flag_url"
                                    class="w-48"
                                />
                                <p class="text-sm italic">Flag of {{ country.common_name }}</p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <TextInfoItem :value="country.official_name" description="Official name"/>
                                <TextInfoItem :value="country.country_code.toUpperCase()" description="Country code"/>
                                <TextInfoItem :value="String(country.population)" description="Population"/>
                                <TextInfoItem :value="String(country.area)" description="Area (km²)"/>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h2 class="font-bold mb-2">Neighbouring countries</h2>
                            <div>
                                <PillLink
                                    v-for="neighbour in country.neighbouring_countries"
                                    :link="'/country/' + neighbour.id"
                                    :text="neighbour.common_name"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
