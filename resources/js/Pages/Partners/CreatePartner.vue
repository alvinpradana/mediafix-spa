<template>
    <Layout>
    <Head title="Create Partner" />
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Add New Partner</h4>
            <div class="dropdown-divider my-4"></div>
                <form @submit.prevent="submit" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group col mb-4">
                                <label for="partner_name">Partner Name</label>
                                <input v-model="form.partner_name" type="name" class="form-control" id="partner_name" placeholder="Enter name">
                                <small class="text-danger" v-if="errors.partner_name">{{ errors.partner_name[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="phone_number">Phone</label>
                                <input v-model="form.phone_number" type="text" class="form-control" id="phone_number" placeholder="Enter phone number">
                                <small class="text-danger" v-if="errors.phone_number">{{ errors.phone_number[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="partner_email">Partner Email</label>
                                <input v-model="form.partner_email" type="email" class="form-control" id="partnerEmail" placeholder="Enter email">
                                <small class="text-danger" v-if="errors.partner_email">{{ errors.partner_email[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col mb-4">
                                <label for="start_join">Start Join</label>
                                <input type="text" v-model="form.start_join" id="start_join" class="form-control" placeholder="Enter date join" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                <small class="text-danger" v-if="errors.start_join">{{ errors.start_join[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="partner_company">Partner Company</label>
                                <input v-model="form.partner_company" type="text" class="form-control" id="partner_company" placeholder="Enter company">
                                <small class="text-danger" v-if="errors.partner_company">{{ errors.partner_company[0] }}</small>
                            </div>
                            <div class="form-group col mb-4">
                                <label for="partner_address">Partner Address</label>
                                <input v-model="form.partner_address" type="address" class="form-control" id="partner_address" placeholder="Enter address">
                                <small class="text-danger" v-if="errors.partner_address">{{ errors.partner_address[0] }}</small>
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
            partner_name: null,
            phone_number: null,
            partner_email: null,
            start_join: null,
            partner_company: null,
            partner_address: null,
        })
        function submit() {
            Inertia.post(route('partners.store'), form)
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
    },
};
</script>