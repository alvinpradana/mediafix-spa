<template>
    <Head title="Users Admin" />
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-4">
            <h3>List Users</h3>
        </div>
        <div  class="col-md-4">
            <input v-model="search" type="text" class="form-control rounded-lg text-secondary" placeholder="Search"/>
        </div>
    </div>
    <div v-if="$page.props.flash.alert_error" class="alert alert-danger my-2" role="alert">
        {{ $page.props.flash.alert_error }}
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
                            <th v-if="$page.props.auth.user.is_admin == 1" class="text-center">Action</th>
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
                            <td>{{ moment(user.created_at).format("LL") }}</td>
                            <td v-if="$page.props.auth.user.is_admin === 1" class="text-center">
                                <Link :href="route('user.show', {user: user.username})" as="button" class="btn btn-primary mr-1">
                                    <span class="icon-sm mdi mdi-eye"></span>
                                </Link>
                                <button type="button" @click.prevent="destroy(user.username)" class="btn btn-danger">
                                    <span class="icon-sm mdi mdi-delete"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="dropdown-divider"></div>
            </div>
            <div class="row justify-content-between mt-2" v-if="$page.props.auth.user.is_admin == 1">
                <div class="col-md-2">
                    <Link as="button" :href="route('users.create')" type="button" class="btn btn-lg btn-block btn-success mb-2">
                        Add User
                    </Link>
                </div>
                <div class="col-md-10 px-4">
                    <div class="row float-right px-2">
                        <pagination :links="users.links" />
                    </div>
                </div>
            </div>
            <div v-else class="row justify-content-center px-4">
                <pagination class="mt-3" :links="users.links" />
            </div>
        </div>
    </div>
    
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
    layout: Layout,

    components: {
        Head,
        Link,
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
    },
    setup() {
        function destroy(username) {
            if (confirm('Are you sure you want to delete '+ username + '?')) {
                Inertia.delete(route('user.delete', {user: username}))
            }
        }
        return {
            destroy
        }
    }
};
</script>
