<template>
    <Layout>
        <Head title="Employees" />
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">List Employee</h4>
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
                                    <Link :href="route('employees.edit', {employee: employee.id}, 'edit')" type="button"  class="btn btn-outline-primary mr-1">
                                        <span class="icon-sm mdi mdi-pencil"></span>
                                    </Link>
                                    <button type="button" @click.prevent="destroy(`${employee.id}`)" class="btn btn-outline-danger mr-1">
                                        <span class="icon-sm mdi mdi-delete"></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="dropdown-divider"></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <Link as="button" :href="route('employees.create')" type="button" class="btn btn-lg btn-block btn-outline-success mb-2">
                            Add Employee
                        </Link>
                    </div>
                    <div v-show="employees.data.length > 0" class="col-md-3">
                        <a :href="route('employee.export')" type="button" class="btn btn-lg btn-block btn-outline-primary mb-2">
                            Download Excel
                        </a>
                    </div>
                    <div class="col-md-6 px-4">
                        <div class="row float-right px-2">
                            <pagination class="" :links="employees.links" />
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
import { Inertia } from '@inertiajs/inertia';
import Pagination from "../Shared/Pagination"

export default {
    components: {
        Link,
        Head,
        Layout,
        Pagination,
    },
    props: {
        employees: Object,
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
