<template>
    <Layout>
        <Head title="Partners" />
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Company Partners</h4>
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
                            <tr v-if="partners.length === 0">
                                <td colspan="7" class="text-center py-4">
                                    No data available in our record !
                                </td>
                            </tr>
                            <tr v-for="partner in partners" :key="partner.id">
                                <td>
                                    <i class="icon-sm mdi mdi-account-circle text-success"></i>
                                    <span class="pl-2">{{ partner.partner_name }}</span>
                                </td>
                                <td>{{ partner.phone_number }}</td>
                                <td>{{ partner.partner_email }}</td>
                                <td>{{ partner.start_join }}</td>
                                <td>{{ partner.partner_company }}</td>
                                <td>{{ partner.partner_address }}</td>
                                <td>
                                    <Link :href="`/partner/`+ partner.id +`/edit`"  type="button" class="btn btn-outline-primary mr-1">
                                        <span class="icon-sm mdi mdi-pencil"></span>
                                    </Link>
                                    <button type="button" @click.prevent="destroy(partner.id)" class="btn btn-outline-danger mr-1">
                                        <span class="icon-sm mdi mdi-delete"></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="dropdown-divider"></div>
                </div>
                <div class="col-md-6 mx-auto">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <Link as="button" href="/create-partner" type="button" class="btn btn-lg btn-block btn-outline-success mt-2">
                                <i class="mdi mdi-library-plus"></i> Add Partner
                            </Link>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-lg btn-block btn-outline-primary mt-2">
                                <i class="mdi mdi-cloud-download"></i> Export Data
                            </button>
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

export default {
    components: {
        Link,
        Head,
        Layout,
    },
    props: {
        partners: Object,
    },
    setup() {
        function destroy(id) {
            if (confirm('Are you sure you want to delete this partner?')) {
                Inertia.delete(`/partner/${id}/delete`)
            }
        }
        return {
            destroy
        }
    }
};
</script>
