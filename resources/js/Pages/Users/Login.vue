<template>
    <Head title="Login" />
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="row w-100 m-0">
                    <!-- <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg"> -->
                    <div class="content-wrapper full-page-wrapper d-flex align-items-center">
                        <div class="col-md-4 mx-auto">
                            <div v-if="$page.props.flash.alert_success" class="mx-auto">
                                <div class="alert alert-success" role="alert">
                                    {{ $page.props.flash.alert_success }}
                                    <button @click="close()" type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body px-4 py-4">
                                    <h3 class="card-title text-left">Login</h3>
                                    <div class="dropdown-divider my-3"></div>
                                    <form @submit.prevent="store" autocomplete="off">
                                        <div class="form-group py-2">
                                            <label>Email *</label>
                                            <input v-model="form.email" type="email" class="form-control" :class="{'is-invalid': errors.email}" placeholder="Enter email">
                                            <small class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</small>
                                        </div>
                                        <div class="form-group py-2">
                                            <label>Password *</label>
                                            <input v-model="form.password" type="password" class="form-control" :class="{'is-invalid': errors.password}" placeholder="Enter password">
                                            <small class="invalid-feedback" v-if="errors.password">{{ errors.password[0] }}</small>
                                        </div>
                                        <div class="dropdown-divider my-3"></div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-block btn-success">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from '@vue/reactivity';
import { Inertia } from '@inertiajs/inertia';

export default {
    data() {
        const form = reactive({
            email: null,
            password: null,
            remember: false,
        })
        function store() {
            Inertia.post(route('login'), form)
        }
        return { form, store }
    },
    components: {
        Head,
        Link,
    },
    props: {
        errors: Object,
    },
    methods: {
        close () {
            this.$page.props.flash.alert_success = false
        }
    }
};
</script>