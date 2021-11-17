<template>
    <Layout>
        <Head title="Partners" />
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-md-4">
                <h3>List Partners</h3>
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
                                <th>Partners Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Start Date</th>
                                <th>Company</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="partners.data.length === 0">
                                <td colspan="7" class="text-center py-4">
                                    No data available in our record !
                                </td>
                            </tr>
                            <tr v-for="partner in partners.data" :key="partner.id">
                                <td class="align-items-center">
                                    <i class="icon-sm mdi mdi-account-circle text-success"></i>
                                    <span class="pl-2">{{ partner.partner_name }}</span>
                                </td>
                                <td><a :href="`https://wa.me/62`+ partner.phone_number +`?text=Hallo%20`+ partner.partner_name" target="_blank">0{{ partner.phone_number }}</a></td>
                                <td>{{ partner.partner_email }}</td>
                                <td>{{ partner.start_join }}</td>
                                <td>{{ partner.partner_company }}</td>
                                <td>{{ partner.partner_address }}</td>
                                <td>
                                    <Link :href="route('partners.edit', {partner: partner.id})" type="button" class="btn btn-primary mr-1">
                                        <span class="icon-sm mdi mdi-pencil"></span>
                                    </Link>
                                    <button type="button" @click.prevent="destroy(partner.id)" class="btn btn-danger">
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
                        <Link as="button" :href="route('partners.create')" type="button" class="btn btn-lg btn-block btn-success mb-2">
                             Create
                        </Link>
                    </div>
                    <div v-show="partners.data.length > 0" class="col-md-2">
                        <a :href="route('partners.export')" type="button" class="btn btn-lg btn-block btn-primary mb-2">
                             Download
                        </a>
                    </div>
                    <div class="col-md-8 px-4">
                        <div class="row float-right px-2">
                            <pagination class="" :links="partners.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../Shared/Layout";
import { Link, Head } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia';
import Pagination from "../Shared/Pagination"
import { ref } from '@vue/reactivity';
import { watch } from '@vue/runtime-core';

export default {
    components: {
        Link,
        Head,
        Layout,
        Pagination,
    },
    props: {
        partners: Object,
        filters: Object
    },
    data (props) {
        let search = ref(props.filters.search)

        watch (search, value => {
            Inertia.get('/partners', { search: value }, {
                preserveState: true,
                replace: true
            })
        })

        return {
            search
        }
    },
    setup() {
        function destroy(id) {
            if (confirm('Are you sure you want to delete this partner?')) {
                Inertia.delete(route('partners.destroy', {partner: id}))
            }
        }
        return {
            destroy
        }
    }
};
</script>
