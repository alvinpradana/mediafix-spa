<template>
    <Layout>
    <Head title="Add User" />
        <div v-if="$page.props.auth.user.is_admin == 1" class="card">
            <div class="card-body">
                <h4 class="card-title">Add User Admin</h4>
                <div class="dropdown-divider my-4"></div>
                <form @submit.prevent="submit" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group col mb-4">
                                <label for="name">Name</label>
                                <input v-model="form.name" type="name" id="name" class="form-control" :class="{'is-invalid': errors.name}" placeholder="Enter name">
                                <small class="invalid-feedback" v-if="errors.name">{{ errors.name[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="username">Username</label>
                                <input v-model="form.username" type="text" id="username" class="form-control" :class="{'is-invalid': errors.username}" placeholder="Enter username">
                                <small class="invalid-feedback" v-if="errors.username">{{ errors.username[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="email">Email</label>
                                <input v-model="form.email" type="email" id="email" class="form-control" :class="{'is-invalid': errors.email}" placeholder="Enter user email">
                                <small class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="form-group col-md-6 mb-4">
                                    <label for="password">Password</label>
                                    <input v-model="form.password" type="password" id="password" class="form-control" :class="{'is-invalid': errors.password}" name="password" placeholder="Enter password">
                                    <small class="invalid-feedback" v-if="errors.password">{{ errors.password[0] }}</small>
                                </div>
                                <div class="form-group col-md-6 mb-4">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input v-model="form.password_confirmation" type="password" id="password_confirmation" class="form-control" :class="{'is-invalid': errors.password_confirmation}" name="password_confirmation" placeholder="Confirm Password">
                                    <small class="invalid-feedback" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</small>
                                </div>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="phone">Phone</label>
                                <input v-model="form.phone" type="number" id="phone" class="form-control" :class="{'is-invalid': errors.phone}" placeholder="Enter phone number">
                                <small class="invalid-feedback" v-if="errors.phone">{{ errors.phone[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="workshop">Workshop</label>
                                <input v-model="form.workshop" type="workshop" id="workshop" class="form-control" :class="{'is-invalid': errors.workshop}" placeholder="Enter workshop">
                                <small class="invalid-feedback" v-if="errors.workshop">{{ errors.workshop[0] }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row mt-4">
                        <div class="col-md-6 mx-auto">
                            <button type="submit" class="btn btn-lg btn-block btn-outline-success mx-auto">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div v-else>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card outline-primary my-auto">
                        <div class="card-body text-center">
                            Sorry, You must be log in as Admin.
                        <div class="dropdown-divider px-3 my-3"></div>
                        <Link :href="route('dashboard')" class="text-primary px-2"><u>Go back</u></Link>
                            or
                        <Link :href="route('logout')" method="delete" class="text-primary px-2"><u>Login as admin</u></Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../Shared/Layout";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from '@vue/reactivity';
import { Inertia } from '@inertiajs/inertia';

export default {
    data(props) {
        const form = reactive({
            name: null,
            username: null,
            user_added: props.user,
            email: null,
            password: null,
            phone: null,
            workshop: null,
        })
        function submit() {
            Inertia.post(route('users.store'), form)
        }
        return { form, submit }
    },
    components: {
        Layout,
        Head,
        Link,
    },
    props: {
        errors: Object,
        user: Object
    }
};
</script>