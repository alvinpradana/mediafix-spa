<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <Link :href="route('dashboard')" class="sidebar-brand brand-logo">
                <b class="text-white" style="font-family: Arial, Helvetica, sans-serif">
                    MEDIAFIX
                </b>
            </Link>
            <Link :href="route('dashboard')" class="sidebar-brand brand-logo-mini">
                <b class="text-white" style="font-family: Arial, Helvetica, sans-serif">M</b>
            </Link>
        </div>
        <ul class="nav">
            <li class="nav-item nav-category">
                <span class="nav-link">Navigations</span>
            </li>
            <li class="nav-item menu-items" :class="{ 'active' : $page.url.startsWith('/dashboard') }">
                <Link :href="route('dashboard')" class="nav-link">
                    <span class="menu-icon">
                        <i class="mdi mdi-speedometer"></i>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </Link>
            </li>
            <li class="nav-item menu-items" :class="{ 'active': $page.url.startsWith('/sparepart') }">
                <Link :href="route('sparepart.index')" class="nav-link">
                    <span class="menu-icon">
                        <i class="mdi mdi-monitor-multiple"></i>
                    </span>
                    <span class="menu-title">Sparepart</span>
                </Link>
            </li>
            <li class="nav-item menu-items" :class="{ 'active': $page.url.startsWith('/equipment') }">
                <Link :href="route('equipment.index')" class="nav-link">
                    <span class="menu-icon">
                        <i class="mdi mdi-wallet-travel"></i>
                    </span>
                    <span class="menu-title">Equipment</span>
                </Link>
            </li>
            <li class="nav-item menu-items" :class="{ 'active': $page.url.startsWith('/partners') }">
                <Link :href="route('partners.index')" class="nav-link">
                    <span class="menu-icon">
                        <i class="mdi mdi-account-star"></i>
                    </span>
                    <span class="menu-title">Partners</span>
                </Link>
            </li>
            <li class="nav-item menu-items" :class="{ 'active': $page.url.startsWith('/employees') }">
                <Link :href="route('employees.index')" class="nav-link">
                    <span class="menu-icon">
                        <i class="mdi mdi-worker"></i>
                    </span>
                    <span class="menu-title">Employees</span>
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
