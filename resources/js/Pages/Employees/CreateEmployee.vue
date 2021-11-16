<template>
    <Layout>
    <Head title="Create Employee" />
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Employee</h4>
                <div class="dropdown-divider my-4"></div>
                <form @submit.prevent="submit" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="employee_name">Name</label>
                                <input v-model="form.employee_name" type="name" id="employee_name" class="form-control" :class="{'is-invalid': errors.employee_name}" placeholder="Enter name">
                                <small class="invalid-feedback" v-if="errors.employee_name">{{ errors.employee_name[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="phone_number">Phone</label>
                                <input v-model="form.phone_number" type="number" id="phone_number" class="form-control" :class="{'is-invalid': errors.phone_number}" placeholder="Enter phone number">
                                <small class="invalid-feedback" v-if="errors.phone_number">{{ errors.phone_number[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="employee_email">Email</label>
                                <input v-model="form.employee_email" type="email" id="employee_email" class="form-control" :class="{'is-invalid': errors.employee_email}" placeholder="Enter email">
                                <small class="invalid-feedback" v-if="errors.employee_email">{{ errors.employee_email[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="employee_division">Division</label>
                                <input v-model="form.employee_division" type="text" id="employee_division" class="form-control" :class="{'is-invalid': errors.employee_division}" placeholder="Enter employee division">
                                <small class="invalid-feedback" v-if="errors.employee_division">{{ errors.employee_division[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="employee_address">Address</label>
                                <textarea v-model="form.employee_address" type="address" id="employee_address" class="form-control" :class="{'is-invalid': errors.employee_address}" placeholder="Enter address" rows="7"></textarea>
                                <small class="invalid-feedback" v-if="errors.employee_address">{{ errors.employee_address[0] }}</small>
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
    </Layout>
</template>

<script>
import Layout from "../Shared/Layout";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    data() {
        const form = reactive({
            user_id: this.user,
            employee_name: null,
            phone_number: null,
            employee_email: null,
            employee_division: null,
            employee_address: null,
        })
        function submit() {
            Inertia.post(route('employees.store'), form)
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
        user: Object,
    },
};
</script>