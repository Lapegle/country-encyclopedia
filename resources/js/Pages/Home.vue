<script setup>
import {Head, Link} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {ref, watch} from "vue";
import {debounce} from "lodash";
import CountryCard from "@/Components/CountryCard.vue";

defineProps({
    favoriteCountries: Object
})

const search = ref('')
const searchFocused = ref(false)
const countries = ref([])

const onSearchBlur = () => {
    setTimeout(() => {
        searchFocused.value = false;
    }, 250);
}

const getCountries = debounce((search) => {
    axios.get('/countries/find', {
        params: {
            search
        }
    })
        .then((response) => {
            countries.value = response.data;
        })
        .catch((error) => {
            console.error('Error fetching countries:', error);
        });
}, 300);

watch(search, async (newSearch, oldSearch) => {
    if (newSearch.length) {
        getCountries(newSearch)
    } else {
        countries.value = []
    }
})
</script>

<template>
    <Head title="Home"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg flex-col justify-center p-8">
                    <div class="flex flex-col justify-center items-center">
                        <img class="w-32" src="/images/earth.png"/>
                        <h1 class="font-bold text-4xl mt-2">Country Encyclopedia</h1>
                    </div>
                    <div class="w-full relative mt-20">
                        <InputLabel for="search" value="Search for a country"/>
                        <TextInput
                            id="search"
                            v-model="search"
                            class="w-full"
                            name="search"
                            @blur="onSearchBlur"
                            @focus="searchFocused = true"
                        />
                        <div v-if="searchFocused" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg">
                            <ul class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                                <div v-for="country in countries" :key="country.country_code">
                                    <Link :href="'/countries/' + country.id">
                                        <li class="relative py-2 pl-3 text-gray-900 cursor-pointer hover:bg-indigo-200">
                                            <span class="block font-normal truncate">{{ country.common_name }}</span>
                                        </li>
                                    </Link>
                                </div>

                                <div
                                    v-if="!countries.length && search.length"
                                    class="px-3 py-2 text-gray-900 cursor-default select-none"
                                >
                                    Nothing found, try a again
                                </div>
                            </ul>
                        </div>
                        <div class="mt-12">
                            <h2 class="font-bold mb-3">My favorite countries</h2>
                            <CountryCard v-for="country in favoriteCountries" :country="country"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
