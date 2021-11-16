<template>
    <Layout>
        <Head title="Invoices" />
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-md-4">
                <h3>Invoice Order</h3>
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
                            <th> Nomor Nota </th>
                            <th> Nama Customer </th>
                            <th> Total Biaya </th>
                            <th class="text-center"> Unit </th>
                            <th> Status Order </th>
                            <th class="text-center"> Action </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-if="invoices.data.length === 0">
                                <td colspan="7" class="text-center pt-4">
                                    No data available in our record !
                                </td>
                            </tr>
                            <tr v-for="invoice in invoices.data" :key="invoice.id">
                                <td>
                                    {{ invoice.invoice_code }}
                                    <span v-show="invoice.mark === 1" class="text-success mdi mdi-checkbox-marked-circle-outline ml-1"></span>
                                </td>
                                <td class="text-capitalize"> {{ invoice.customer_name }} </td>
                                <td> Rp. {{ invoice.total_payment }} </td>
                                <td>
                                    <ul v-for="unit in invoice.units" :key="unit.id" class="my-auto">
                                        <li class="py-1 text-capitalize"> {{ unit.unit_type }} {{ unit.unit_name }} </li>
                                    </ul>
                                </td>
                                <td>
                                    <div v-if="invoice.order_status == 'Diagnosa'" class="badge badge-pill badge-outline-warning mr-1">{{ invoice.order_status }}</div>
                                    <div v-else-if="invoice.order_status == 'Process Repair'" class="badge badge-pill badge-outline-warning mr-1">{{ invoice.order_status }}</div>
                                    <div v-else-if="invoice.order_status == 'Testing Unit'" class="badge badge-pill badge-outline-primary mr-1">{{ invoice.order_status }}</div>
                                    <div v-else-if="invoice.order_status == 'Selesai'" class="badge badge-pill badge-outline-success mr-1">{{ invoice.order_status }}</div>
                                    <div v-else class="badge badge-pill badge-outline-danger mr-1">{{ invoice.order_status }}</div>

                                    <div v-if="invoice.payment_status == 'Lunas'" class="badge badge-pill badge-outline-success">{{ invoice.payment_status }}</div>
                                    <div v-else-if="invoice.payment_status == 'Uang Muka'" class="badge badge-pill badge-outline-primary">{{ invoice.payment_status }}</div>
                                    <div v-else-if="invoice.payment_status == 'Belum Bayar'" class="badge badge-pill badge-outline-warning">{{ invoice.payment_status }}</div>
                                    <div v-else class="badge badge-pill badge-outline-danger">{{ invoice.payment_status }}</div>
                                </td>
                                <td class="text-center">
                                    <Link :href="route('invoice.show', {invoice: invoice.id})" type="button" class="btn btn-primary showInvoice mr-1">
                                        <span class="icon-sm mdi mdi-eye"></span>
                                    </Link>
                                    <Link as="button" type="button" @click="setTarget(invoice.id)" class="btn btn-success">
                                        <span class="icon-sm mdi mdi-printer"></span>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="dropdown-divider"></div>
                </div>
                <div v-show="invoices.data.length > 0" class="row mt-2">
                    <div class="col-md-3">
                        <a :href="route('invoices.export')" type="button" class="btn btn-lg btn-block btn-primary mb-2">
                                Download Excel
                        </a>
                    </div>
                    <div class="col-md-9 px-4">
                        <div class="row float-right">
                            <pagination class="px-2" :links="invoices.links" />
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
import Pagination from "../Shared/Pagination"
import { ref } from '@vue/reactivity';
import { watch } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';

export default {
    data (props) {
        let search = ref(props.filters.search)

        watch (search, value => {
            Inertia.get('/dashboard/invoice', { search: value }, {
                preserveState: true,
                replace: true
            })
        })

        return { search }

    },
    components: {
        Link,
        Head,
        Layout,
        Pagination,
    },
    props: {
        invoices: Object,
        filters: Object
    },
    methods: {
        setTarget (id) {
            window.open(route('invoice.print', {id: id}, "_blank"))
        }
    }
};
</script>
