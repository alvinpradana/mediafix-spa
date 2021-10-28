<template>
    <main class="container-scroller">
        <header>
            <Sidebar />
            <Navbar />
        </header>
        <article class="main-panel">
            <div class="content-wrapper">
                <div v-if="$page.props.flash.alert_success" class="alert alert-success">
                    {{ $page.props.flash.alert_success }}
                </div>
                <slot />
            </div>
        </article>
    </main>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Sidebar from "./Sidebar.vue"
import Navbar from "./Navbar.vue"

export default {
    components: {
        Link,
        Sidebar,
        Navbar
    },
};
</script>
