<template>
    <div class="container-fluid page-body-wrapper">
        <nav class="navbar p-0 fixed-top d-flex flex-row">
            <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                <button ref="toggledNav" class="navbar-toggler align-self-center collapsed" type="button" data-toggle="minimize" data-target="#navbar-collapse">
                    <span class="mdi mdi-menu"></span>
                </button>
                <ul class="navbar-nav w-100">
                    <li class="nav-item w-100">
                        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                            <input type="text" class="form-control" placeholder="Search"/>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <Link :href="route('invoice.create')" class="nav-link btn btn-success create-new-button" aria-expanded="false" >
                            + Add New Invoice
                        </Link>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                            <div v-if="$page.props.auth.user" class="navbar-profile">
                                <img class="img-xs rounded-circle" :src="'/storage/' + $page.props.auth.user.image" :alt="$page.props.auth.user.name">
                                <p class="mb-0 d-none d-sm-block navbar-profile-name">
                                    {{ $page.props.auth.user.name }}
                                </p>
                                <i class="mdi mdi-menu-down d-none d-sm-block ml-2"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                            <h6 class="p-3 mb-0">Profile</h6>
                            <div class="dropdown-divider"></div>
                            <Link :href="route('user.profile')" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-settings text-success"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject mb-1">
                                        Settings
                                    </p>
                                </div>
                            </Link>
                            <Link :href="route('logout')" as="button" method="delete" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-logout text-danger"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject mb-1">
                                        Log out
                                    </p>
                                </div>
                            </Link>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-format-line-spacing"></span>
                </button>
            </div>
        </nav>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    }
};
</script>