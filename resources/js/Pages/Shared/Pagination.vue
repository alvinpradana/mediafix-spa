<template>
    <div v-if="links.length > 3">
        <div class="row justify-content-center mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="btn btn-outline-primary mr-1 mb-1 px-4 py-3 text-sm border rounded" v-html="link.label" />
                <inertia-link v-else class="btn btn-outline-primary mr-1 mb-1 px-4 py-3 text-sm border rounded" :class="{ 'btn-primary': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>

<script>
import Link from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link
    },
    props: {
        links: Array,
    },
}
</script>
