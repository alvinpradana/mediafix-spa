<template>
    <Head title="User Profile" />
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Information</h4>
                    <div class="dropdown-divider my-4"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="text-muted">Name</label>
                                <div class="mr-1 mb-1 px-3 py-2 text-secondary border rounded" v-html="user.name"/>
                            </div>
                            <div class="form-group mb-4">
                                <label class="text-muted">Username</label>
                                <div class="mr-1 mb-1 px-3 py-2 text-secondary border rounded" v-html="user.username"/>
                            </div>
                            <div class="form-group mb-4">
                                <label class="text-muted">Phone</label>
                                <div class="mr-1 mb-1 px-3 py-2 text-secondary border rounded" v-html="'0'+ user.phone"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="text-muted">Password</label>
                                <div class="mr-1 mb-1 px-3 py-2 text-secondary border rounded d-flex align-items-center">
                                    <span class="text-muted">*****************</span>
                                    <span @click="editPassword()" type="button" class="mdi mdi-pencil ml-auto"></span>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="text-muted">Email</label>
                                <div class="mr-1 mb-1 px-3 py-2 text-secondary border rounded" v-html="user.email"/>
                            </div>
                            <div class="form-group mb-4">
                                <label class="text-muted">Workshop</label>
                                <div class="mr-1 mb-1 px-3 py-2 text-secondary border rounded" v-html="user.workshop"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="passwordUpdate" class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Password</h4>
                    <div class="dropdown-divider"></div>
                    <form @submit.prevent="update" autocomplete="off">
                        <div class="form-group mt-4">
                            <label for="password">New Password</label>
                            <input v-model="form.password" type="password" id="password" class="form-control" :class="{'is-invalid': errors.password}" placeholder="New Password">
                            <small class="invalid-feedback" v-if="errors.password">{{ errors.password[0] }}</small>
                        </div>  
                        <div class="form-group mt-4">
                            <label for="password_confirmation">Confirm Password</label>
                            <input v-model="form.password_confirmation" type="password" id="password_confirmation" name="password_confirmation" class="form-control" :class="{'is-invalid': errors.password_confirmation}" placeholder="Confirm password">
                            <small class="invalid-feedback" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</small>
                        </div>
                        <div class="dropdown-divider my-4"></div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <button type="submit" class="btn btn-lg btn-block btn-success">Save</button>
                            </div>
                            <div class="col-md-6 mb-2">
                                <button @click.prevent="cancelPassword()" type="button" class="btn btn-lg btn-block btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="!passwordUpdate" class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Profile Image</h4>
                    <div class="dropdown-divider"></div>
                    <div class="bg-gray-dark p-3 rounded mt-3">
                        <div class="row">
                            <div style="width:200px; height:200px" class="border rounded-circle mx-auto d-block mb-2">
                                <img v-if="user.image" :src="showImage() + user.image" alt="Images" class="rounded-circle mx-auto d-block w-100 h-100"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from "../Shared/Layout";
import { Link, Head } from "@inertiajs/inertia-vue3";
import UserImage from './UserImage.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    layout: Layout,
    
    components: {
        Head,
        Link,
        UserImage
    },
    props: {
        user: Object,
        errors: Object
    },
    data () {
        return {
            passwordUpdate: false,
            form: {
                username: this.user.username,
                password: null,
            }
        }
    },
    methods: {
        editPassword () {
            this.passwordUpdate = true
        },
        cancelPassword () {
            this.passwordUpdate = false
        },
        update (){
            Inertia.put(route('password.reset'), this.form, {
                onSuccess: () => this.reset()
            }, {
                onError: () => this.reset()
            })
        },
        reset () {
            this.passwordUpdate = false
            this.form = {
                password: null,
                current_password: null
            }
        },
        showImage () {
            return '/storage/'
        }
    }

};
</script>