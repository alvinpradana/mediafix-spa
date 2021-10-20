<template>
    <!-- Sidebar -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <Link class="sidebar-brand brand-logo" href="/">
                <b class="text-white" style="font-family: Arial, Helvetica, sans-serif">
                    MEDIAFIX
                </b>
            </Link>
            <Link class="sidebar-brand brand-logo-mini" href="/">
                <b class="text-white" style="font-family: Arial, Helvetica, sans-serif">M</b>
            </Link>
        </div>
        <ul class="nav">
            <li class="nav-item nav-category">
                <span class="nav-link">Navigations</span>
            </li>
            <li class="nav-item menu-items">
                <Link class="nav-link" href="/">
                    <span class="menu-icon">
                        <i class="mdi mdi-speedometer"></i>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </Link>
            </li>
            <li class="nav-item menu-items">
                <Link class="nav-link" href="/partners">
                    <span class="menu-icon">
                        <i class="mdi mdi-account-star"></i>
                    </span>
                    <span class="menu-title">Partners</span>
                </Link>
            </li>
            <li class="nav-item menu-items">
                <Link class="nav-link" :href="`/employees`">
                    <span class="menu-icon">
                        <i class="mdi mdi-worker"></i>
                    </span>
                    <span class="menu-title">Employees</span>
                </Link>
            </li>
            <li class="nav-item menu-items">
                <Link class="nav-link" href="/reports">
                    <span class="menu-icon">
                        <i class="mdi mdi mdi-file-multiple"></i>
                    </span>
                    <span class="menu-title">Reports</span>
                </Link>
            </li>
        </ul>
    </nav>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },
};
</script>
