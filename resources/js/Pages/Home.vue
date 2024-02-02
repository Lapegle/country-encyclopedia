<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({ countries: Object })
const search = ref('')

watch(search, async (newSearch, oldSearch) => {
    axios.get('/findCountry', {
        params: {
            search: newSearch
        }
    }).then((response) => {
        console.log(response.data)
    })
})
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-center p-8">
                    <div class="w-full">
                        <InputLabel for="search" value="Search for a country" />
                        <TextInput
                            class="w-full"
                            id="search"
                            name="search"
                            v-model="search"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
