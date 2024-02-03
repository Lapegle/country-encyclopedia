<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import TextInfoItem from "@/Components/TextInfoItem.vue";
import PillLink from "@/Components/PillLink.vue";
import {StarIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    country: Object,
    rank: Number,
    isFavorite: Boolean
})

const updateFavorites = (adding = true) => {
    const url = adding ? '/countries/add-to-favorites' : '/countries/remove-from-favorites';

    axios.post(url, {
        country_id: props.country.id
    })
        .then(() => {
            router.reload({only: ['isFavorite']})
        })
        .catch((error) => {
            console.error('Error toggling favorite country:', error)
        })
};
</script>

<template>
    <Head :title="country.common_name"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg flex justify-center p-8">
                    <div class="max-w-3xl">
                        <div class="flex items-center justify-center">
                            <h1 class="font-bold text-4xl">{{ country.common_name }}</h1>
                            <StarIcon :class="isFavorite ? 'fill-amber-400' : 'fill-gray-200'"
                                      class="ml-3 w-8" @click="updateFavorites(!isFavorite)"/>
                        </div>

                        <div class="flex flex-col sm:flex-row-reverse justify-between mt-4">
                            <div
                                class="sm:ml-52 bg-gray-200 shadow-xl p-2 rounded flex flex-col justify-center items-center">
                                <img
                                    :alt="'Flag of ' + country.official_name"
                                    :src="country.flag_url"
                                    class="w-48"
                                />
                                <p class="text-sm italic mt-2">Flag of {{ country.common_name }}</p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <TextInfoItem :value="country.official_name" description="Official name"/>
                                <TextInfoItem :value="country.country_code.toUpperCase()" description="Country code"/>
                                <TextInfoItem
                                    :value="`${String(country.population)} (#${rank} in the world)`"
                                    description="Population"
                                />
                                <TextInfoItem :value="String(country.area)" description="Area (km²)"/>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h2 class="font-bold mb-2">Neighbouring countries</h2>
                            <PillLink
                                v-for="neighbour in country.neighbouring_countries"
                                :link="'/countries/' + neighbour.id"
                                :text="neighbour.common_name"
                            />
                        </div>
                        <div class="mt-4">
                            <h2 class="font-bold mb-2">Spoken languages</h2>
                            <PillLink
                                v-for="language in country.country_languages"
                                :link="'/languages/' + language.id"
                                :text="language.name"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
