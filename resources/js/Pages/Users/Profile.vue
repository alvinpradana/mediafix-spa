<template>
    <Layout>
    <Head title="User Profile" />
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Profile Information</h4>
                        <div class="dropdown-divider my-4"></div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-4">
                                    <label class="text-muted">Name</label>
                                    <div class="mr-1 mb-1 px-3 py-2 border rounded" v-html="user.name"/>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="text-muted">Username</label>
                                    <div class="mr-1 mb-1 px-3 py-2 border rounded" v-html="user.username"/>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="text-muted">Phone</label>
                                    <div class="mr-1 mb-1 px-3 py-2 border rounded" v-html="user.phone"/>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="text-muted">Email</label>
                                    <div class="mr-1 mb-1 px-3 py-2 border rounded" v-html="user.email"/>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="text-muted">Workshop</label>
                                    <div class="mr-1 mb-1 px-3 py-2 border rounded" v-html="user.workshop"/>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row justify-content-between align-items-center mt-4">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <Link :href="route('users.edit', {user: user.id})" as="button" class="btn btn-lg btn-block btn-outline-primary">Edit</Link>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <button type="submit" class="btn btn-lg btn-block btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <a href="#" type="submit" class="text-primary mx-3"><u>Change Password</u></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">User Activity</h4>
                        <div class="dropdown-divider"></div>
                        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                            <div class="text-md-center text-xl-left">
                                <h6 class="mb-1">Transfer to Paypal</h6>
                                <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
                            </div>
                            <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                                <h6 class="font-weight-bold mb-0">$236</h6>
                            </div>
                        </div>
                        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                            <div class="text-md-center text-xl-left">
                                <h6 class="mb-1">Tranfer to Stripe</h6>
                                <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
                            </div>
                            <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                                <h6 class="font-weight-bold mb-0">$593</h6>
                            </div>
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

export default {
    components: {
        Layout,
        Head,
        Link,
    },
    props: {
        user: Object,
        errors: Object,
    }
};
</script>