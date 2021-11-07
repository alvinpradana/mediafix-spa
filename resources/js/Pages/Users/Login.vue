<template>
    <Head title="Login" />
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="row w-100 m-0">
                    <!-- <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg"> -->
                    <div class="content-wrapper full-page-wrapper d-flex align-items-center">
                        <div class="card col-md-4 mx-auto">
                            <div class="card-body px-4 py-5">
                                <h3 class="card-title text-left mb-3">Login</h3>
                                <form @submit.prevent="store">
                                    <div class="form-group">
                                        <label>Username or email *</label>
                                        <input v-model="form.email" type="text" class="form-control" :class="{'is-invalid': errors.email}" placeholder="Enter email">
                                        <small class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Password *</label>
                                        <input v-model="form.password" type="text" class="form-control" :class="{'is-invalid': errors.password}" placeholder="Enter password">
                                        <small class="invalid-feedback" v-if="errors.password">{{ errors.password[0] }}</small>
                                    </div>
                                    <div class="form-group d-flex align-items-center justify-content-between mt-4">
                                        <div class="form-check">
                                        <label class="form-check-label">
                                            <input v-model="form.remember" type="checkbox" class="form-check-input"> Remember me </label>
                                        </div>
                                        <a href="#" class="text-small text-primary"><u>Forgot password</u></a>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-block btn-outline-success">Login</button>
                                    </div>
                                </form>
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
    }
};
</script>