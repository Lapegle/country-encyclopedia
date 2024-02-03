<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({country: Object})
</script>

<template>
    <Link
        :href="'/countries/' + country.id"
        class="flex w-full px-2 bg-gray-100 hover:bg-gray-200 shadow m-2 py-2 rounded max-h-32 items-center"
    >
        <img
            :alt="'Flag of ' + country.official_name"
            :src="country.flag_url"
            class="w-28"
        />
        <p class="ml-4 font-bold">{{ country.common_name }}</p>
    </Link>
</template>
