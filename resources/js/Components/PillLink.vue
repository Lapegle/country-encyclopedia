<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    link: String,
    text: String
})
</script>

<template>
    <Link
        :href="link"
    >
        <button class="mr-2 px-4 py-2 border-2 hover:bg-gray-200 text-sm font-medium rounded-full mt-2">
            {{ text }}
        </button>
    </Link>
</template>
