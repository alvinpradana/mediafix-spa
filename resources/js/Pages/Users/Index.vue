<template>
    <Layout>
        <Head title="Users Admin" />
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-md-4">
                <h3>List users</h3>
            </div>
            <div v-if="$page.props.auth.user.is_admin == 1" class="col-md-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <input v-model="search" type="text" class="form-control rounded-lg text-secondary" placeholder="Search"/>
                    </div>
                    <div class="col-md-4">
                        <Link as="button" :href="route('users.create')" type="button" class="btn btn-lg btn-block btn-outline-success">
                            Add User
                        </Link>
                    </div>
                </div>
            </div>
            <div v-else class="col-md-4">
                <input v-model="search" type="text" class="form-control rounded-lg text-secondary" placeholder="Search"/>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Workshop</th>
                                <th>Added at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="users.data.length === 0">
                                <td colspan="7" class="text-center pt-4">
                                    Your keyword doesn't match with our records!
                                </td>
                            </tr>
                            <tr v-for="user in users.data" :key="user.id">
                                <td>{{ user.name }}</td>
                                <td>{{ user.username }}</td>
                                <td><a :href="`https://wa.me/62`+ user.phone + `?text=Halo%20`+ user.name" target="_blank">0{{ user.phone }}</a></td>
                                <td>{{ user.workshop }}</td>
                                <td>{{ moment(user.created_at).format("LL") }} <i class="text-primary text-small">By {{ user.user_added }}</i></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="dropdown-divider"></div>
                </div>
                <div class="row mt-2">
                    <!-- <div v-if="$page.props.auth.user.is_admin == 1" class="col-md-3">
                        <Link as="button" :href="route('users.create')" type="button" class="btn btn-lg btn-block btn-outline-success mb-2">
                            Add User
                        </Link>
                    </div> -->
                    <div class="col-md-9 px-4">
                        <div class="row float-right px-2">
                            <pagination class="" :links="users.links" />
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
import Pagination from "../Shared/Pagination"
import moment from "moment";
import { ref } from '@vue/reactivity';
import { watch } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        Head,
        Link,
        Layout,
        Pagination,
    },
    props: {
        users: Object,
        date: Object,
        filters: Object
    },
    data (props) {
        let search = ref(props.filters.search)

        watch (search, value => {
            Inertia.get('/dashboard/users', { search: value }, {
                preserveState: true,
                replace: true
            })
        })

        return {
            search,
            moment: moment,
        }
    }
};
</script>
