<template>
    <Layout>
        <Head title="Users Admin" />
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">List Users</h4>
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
                            <tr v-for="user in users.data" :key="user.id">
                                <td>{{ user.name }}</td>
                                <td>{{ user.username }}</td>
                                <td>+62{{ user.phone }}</td>
                                <td>{{ user.workshop }}</td>
                                <td>{{ moment(user.created_at).format("LL") }} <i class="text-primary text-small">By {{ user.user_added }}</i></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="dropdown-divider"></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <Link as="button" :href="route('users.create')" type="button" class="btn btn-lg btn-block btn-outline-success mb-2" data-bs-toggle="modal" data-bs-target="#AddEmployee">
                            Add User
                        </Link>
                    </div>
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

export default {
    components: {
        Head,
        Link,
        Layout,
        Pagination,
    },
    props: {
        users: Object,
        date: Object
    },
    data () {
        return {
            moment: moment
        }
    }
};
</script>
