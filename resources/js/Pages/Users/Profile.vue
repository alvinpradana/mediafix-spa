<template>
    <Head title="User Profile" />
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Profile Information</h4>
                    <div class="dropdown-divider my-4"></div>
                    <div class="row">
                        <div class="col">
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
                    <div class="dropdown-divider"></div>
                    <div class="row justify-content-between mt-4">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <Link :href="route('users.edit', {user: user.id})" as="button" class="btn btn-lg btn-block btn-primary">Edit</Link>
                                </div>
                                <div v-if="user.is_admin == null" class="col-md-6 mb-2">
                                    <button type="button" @click.prevent="destroy(user.id)" class="btn btn-lg btn-block btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                        <a type="button" @click.prevent="changePassword()" class="text-primary mx-3"><u>Change Password</u></a>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="showPassword" class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Password</h4>
                    <div class="dropdown-divider"></div>
                    <form @submit.prevent="update" autocomplete="off">
                        <div class="form-group mt-4">
                            <label for="current_password">Current Password</label>
                            <input v-model="form.current_password" type="password" id="current_password" class="form-control" :class="{'is-invalid': errors.current_password}" placeholder="Current password">
                            <small class="invalid-feedback" v-if="errors.current_password">{{ errors.current_password[0] }}</small>
                        </div>
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
        <div v-if="!showPassword" class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Your Profile Image</h4>
                    <div class="dropdown-divider"></div>

                    <UserImage v-if="chooseImage" />

                    <div v-if="!chooseImage" class="bg-gray-dark p-3 rounded mt-3">
                        <div class="row">
                            <div style="width:200px; height:200px" class="border rounded-circle mx-auto d-block mb-2">
                                <img v-if="this.user.image" :src="showImage() + user.image" alt="Images" class="rounded-circle mx-auto d-block w-100 h-100"/>
                            </div>
                        </div>
                        <div class="row justify-content-center py-2">
                            <a type="button" @click="edit()" class="text-primary mx-3"><u>Change my photo</u></a>
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
import { Inertia } from '@inertiajs/inertia';
import UserImage from './UserImage.vue';

export default {
    layout: Layout,

    data () {
        return {
            showPassword: false,
            chooseImage: false,
            preview: null,
            form: {
                current_password: null,
                password: null,
            }
        }
    },
    methods: {
        update (){
            Inertia.put(route('password.update'), this.form, {
                onSuccess: () => this.reset()
            }, {
                onError: () => this.reset()
            })
        },
        reset () {
            this.form = {
                current_password: null,
                password: null,
            }
        },
        changePassword () {
            this.showPassword = true
        },
        cancelPassword () {
            this.showPassword = false
        },
        edit () {
            this.chooseImage = true
        },
        showImage () {
            return '/storage/'
        }
    },
    components: {
        Head,
        Link,
        UserImage
    },
    props: {
        user: Object,
        errors: Object,
    },
    setup () {
        function destroy (id) {
            if (confirm('Are you sure you want to delete your account?')) {
                Inertia.delete(route('users.destroy', {user: id}))
            }
        }
        return {
            destroy
        }
    }
};
</script>