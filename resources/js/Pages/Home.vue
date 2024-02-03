<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const search = ref('')
const searchFocused = ref(false)
const countries = ref([])

watch(search, async (newSearch, oldSearch) => {
    axios.get('/findCountry', {
        params: {
            search: newSearch
        }
    }).then((response) => {
        countries.value = response.data
    })
})
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg flex justify-center p-8">
                    <div class="w-full relative">
                        <InputLabel for="search" value="Search for a country" />
                        <TextInput
                            class="w-full"
                            id="search"
                            name="search"
                            v-model="search"
                            @focus="searchFocused = true"
                            @blur="searchFocused = false"
                        />
                        <div v-if="searchFocused" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg">
                            <ul
                                tabindex="-1"
                                class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5"
                            >
                                <div v-for="country in countries" :key="country.country_code">
                                    <li
                                        class="relative py-2 pl-3 text-gray-900 cursor-pointer hover:bg-indigo-200"
                                    >
                                        <span class="block font-normal truncate">{{ country.common_name }}</span>
                                    </li>
                                </div>

                                <div
                                    v-if="!countries.length && search.length"
                                    class="px-3 py-2 text-gray-900 cursor-default select-none"
                                >
                                    Nothing found, try a again
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
