<template>
    <Layout>
    <Head title="Edit Partner" />
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Edit Partner</h4>
            <div class="dropdown-divider my-4"></div>
                <form @submit.prevent="update" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="partner_name">Partner Name</label>
                                <input v-model="form.partner_name" type="name" class="form-control" id="partner_name" :class="{'is-invalid': errors.partner_name}" placeholder="Enter name">
                                <small class="invalid-feedback" v-if="errors.partner_name">{{ errors.partner_name[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="phone_number">Phone</label>
                                <input v-model="form.phone_number" type="text" class="form-control" id="phone_number" :class="{'is-invalid': errors.phone_number}" placeholder="Enter phone number">
                                <small class="invalid-feedback" v-if="errors.phone_number">{{ errors.phone_number[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="partner_email">Partner Email</label>
                                <input v-model="form.partner_email" type="email" class="form-control" id="partner_email" :class="{'is-invalid': errors.partner_email}" placeholder="Enter email">
                                <small class="invalid-feedback" v-if="errors.partner_email">{{ errors.partner_email[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="start_join">Start Date</label>
                                <input v-model="form.start_join" type="date" class="form-control" id="start_join" :class="{'is-invalid': errors.start_join}">
                                <small class="invalid-feedback" v-if="errors.start_join">{{ errors.start_join[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="partner_company">Partner Company</label>
                                <input v-model="form.partner_company" type="text" class="form-control" id="partner_company" :class="{'is-invalid': errors.partner_company}" placeholder="Enter company">
                                <small class="invalid-feedback" v-if="errors.partner_company">{{ errors.partner_company[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="partner_address">Partner Address</label>
                                <input v-model="form.partner_address" type="address" class="form-control" id="partner_address" :class="{'is-invalid': errors.partner_address}" placeholder="Enter address">
                                <small class="invalid-feedback" v-if="errors.partner_address">{{ errors.partner_address[0] }}</small>
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
    </Layout>
</template>

<script>
import Layout from "../Shared/Layout";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    data (props) {
        const form = reactive({
            partner_name: props.partner.partner_name,
            phone_number: props.partner.phone_number,
            partner_email: props.partner.partner_email,
            start_join: props.partner.start_join,
            partner_company: props.partner.partner_company,
            partner_address: props.partner.partner_address,
        })
        function update() {
            Inertia.put(route('partners.update', {partner: props.partner.id}), form)
        }
        return { form, update }
    },
    components: {
        Layout,
        Head,
        Link,
    },
    props: {
        partner: Object,
        errors: Object,
    },
};
</script>