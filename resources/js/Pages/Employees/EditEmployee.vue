<template>
    <Layout>
    <Head title="Edit Employee" />
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Employee</h4>
                <div class="dropdown-divider my-4"></div>
                <form @submit.prevent="update" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group col mb-4">
                                <label for="employee_name">Name</label>
                                <input v-model="form.employee_name" type="name" class="form-control" :class="{'is-invalid': errors.employee_name}" placeholder="Enter name">
                                <small class="invalid-feedback" v-if="errors.employee_name">{{ errors.employee_name[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="phone_number">Phone</label>
                                <input v-model="form.phone_number" type="text" class="form-control" :class="{'is-invalid': errors.phone_number}" placeholder="Enter phone number">
                                <small class="invalid-feedback" v-if="errors.phone_number">{{ errors.phone_number[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="employee_email">Email</label>
                                <input v-model="form.employee_email" type="email" class="form-control" :class="{'is-invalid': errors.employee_email}" placeholder="Enter email">
                                <small class="invalid-feedback" v-if="errors.employee_email">{{ errors.employee_email[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col mb-4">
                                <label for="employee_division">Division</label>
                                <input v-model="form.employee_division" type="text" class="form-control" :class="{'is-invalid': errors.employee_division}" placeholder="Enter employee division">
                                <small class="invalid-feedback" v-if="errors.employee_division">{{ errors.employee_division[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="employee_address">Address</label>
                                <textarea v-model="form.employee_address" type="address" class="form-control" :class="{'is-invalid': errors.employee_address}" placeholder="Enter address" rows="7"></textarea>
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
    data(props) {
        const form = reactive({
            employee_name: props.employee.employee_name,
            phone_number: props.employee.phone_number,
            employee_email: props.employee.employee_email,
            employee_division: props.employee.employee_division,
            employee_address: props.employee.employee_address,
        })

        function update() {
            Inertia.put(route('employees.update', {employee: props.employee.id}), form)
        }

        return { form, update }
    },

    components: {
        Layout,
        Head,
        Link,
    },

    props: {
        employee: Object,
        errors: Object,
    },
};
</script>