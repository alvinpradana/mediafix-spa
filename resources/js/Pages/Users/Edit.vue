<template>
    <Head title="Edit Profile" />
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit User Profile</h4>
            <div class="dropdown-divider my-4"></div>
            <form @submit.prevent="update" autocomplete="off">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="name">Name</label>
                            <input v-model="form.name" type="name" id="name" class="form-control" :class="{'is-invalid': errors.name}" placeholder="Enter name">
                            <small class="invalid-feedback" v-if="errors.name">{{ errors.name[0] }}</small>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-4">
                                <label for="username">Username</label>
                                <input v-model="form.username" type="text" id="username" class="form-control" :class="{'is-invalid': errors.username}" name="username" placeholder="Enter username">
                                <small class="invalid-feedback" v-if="errors.username">{{ errors.username[0] }}</small>
                            </div>
                            <div class="form-group col-md-6 mb-4">
                                <label for="email">Email</label>
                                <input v-model="form.email" type="email" id="email" class="form-control" :class="{'is-invalid': errors.email}" name="email" placeholder="Confirm Password">
                                <small class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="phone">Phone</label>
                            <input v-model="form.phone" type="number" id="phone" class="form-control" :class="{'is-invalid': errors.phone}" placeholder="Enter phone number">
                            <small class="invalid-feedback" v-if="errors.phone">{{ errors.phone[0] }}</small>
                        </div>
                        <div class="form-group mb-4">
                            <label for="workshop">Workshop</label>
                            <input v-model="form.workshop" type="text" id="workshop" class="form-control" :class="{'is-invalid': errors.workshop}" placeholder="Enter workshop">
                            <small class="invalid-feedback" v-if="errors.workshop">{{ errors.workshop[0] }}</small>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="row mt-4">
                    <div class="col-md-6 mx-auto">
                        <button type="submit" class="btn btn-lg btn-block btn-success mx-auto">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from "../Shared/Layout";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from '@vue/reactivity';
import { Inertia } from '@inertiajs/inertia';

export default {
    layout: Layout,
    
    data(props) {
        const form = reactive({
            name: props.user.name,
            username: props.user.username,
            email: props.user.email,
            phone: props.user.phone,
            workshop: props.user.workshop,
        })
        function update() {
            Inertia.put(route('users.update', {user: props.user.id}), form)
        }
        return { form, update }
    },
    components: {
        Head,
        Link,
    },
    props: {
        errors: Object,
        user: Object
    }
};
</script>