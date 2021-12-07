<template>
    <main class="container-scroller">
        <header>
            <Sidebar />
            <Navbar :key="navbarKey" />
        </header>
        <article class="main-panel">
            <div class="content-wrapper">
                    <div v-if="$page.props.flash.alert_success" class="alert alert-success" role="alert">
                        {{ $page.props.flash.alert_success }}
                        <button @click="close()" type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
    methods: {
        close () {
            this.$page.props.flash.alert_success = false
        }
    },
    mounted () {
        this.$forceUpdate ()
    }
}
</script>