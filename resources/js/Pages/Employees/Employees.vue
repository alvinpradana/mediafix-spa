<template>
    <Head title="Employees" />
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-4">
            <h3>List Employees</h3>
        </div>
        <div class="col-md-4">
            <input v-model="search" type="text" class="form-control rounded-lg text-secondary" placeholder="Search"/>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Division</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="employees.data.length === 0">
                            <td colspan="7" class="text-center py-4">
                                No data available in our record !
                            </td>
                        </tr>
                        <tr v-for="employee in employees.data" :key="employee.id">
                            <td>
                                <i class="icon-sm mdi mdi-account-circle text-success"></i>
                                <span class="pl-2">{{ employee.employee_name }}</span>
                            </td>
                            <td><a :href="`https://wa.me/62`+ employee.phone_number +`?text=Halo%20`+ employee.employee_name" target="_blank">0{{ employee.phone_number }}</a></td>
                            <td>{{ employee.employee_email }}</td>
                            <td>{{ employee.employee_division }}</td>
                            <td>{{ employee.employee_address }}</td>
                            <td>
                                <Link :href="route('employees.edit', {employee: employee.id}, 'edit')" type="button"  class="btn btn-primary mr-1">
                                    <span class="icon-sm mdi mdi-pencil"></span>
                                </Link>
                                <button type="button" @click.prevent="destroy(`${employee.id}`)" class="btn btn-danger mr-1">
                                    <span class="icon-sm mdi mdi-delete"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="dropdown-divider"></div>
            </div>
            <div class="row mt-2">
                <div class="col-md-2">
                    <Link as="button" :href="route('employees.create')" type="button" class="btn btn-lg btn-block btn-success mb-2">
                        Create
                    </Link>
                </div>
                <div v-show="employees.data.length > 0" class="col-md-2">
                    <a :href="route('employee.export')" type="button" class="btn btn-lg btn-block btn-primary mb-2">
                        Download
                    </a>
                </div>
                <div class="col-md-8 px-4">
                    <div class="row float-right px-2">
                        <pagination class="" :links="employees.links" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from "../Shared/Layout";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia';
import Pagination from "../Shared/Pagination"
import { ref } from '@vue/reactivity';
import { watch } from '@vue/runtime-core';
import debounce from "lodash/debounce";

export default {
    layout: Layout,
    
    components: {
        Link,
        Head,
        Pagination,
    },
    props: {
        employees: Object,
        filters: Object
    },
    data (props) {
        let search = ref(props.filters.search)

        watch (search, debounce (function (value) {
            Inertia.get('/employees', { search: value }, {
                preserveState: true,
                replace: true
            })
        }, 300))

        return {
            search
        }
    },
    setup() {
        function destroy(id) {
            if (confirm('Are you sure you want to delete this employee?')) {
                Inertia.delete(route('employees.destroy', {employee: id}))
            }
        }
        return {
            destroy
        }
    }
};
</script>
