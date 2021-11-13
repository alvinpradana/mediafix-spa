<template>
    <Layout>
        <Head title="Invoices" />
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Invoice Order</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th> Nomor Nota </th>
                            <th> Nama Customer </th>
                            <th> Total Biaya </th>
                            <th class="text-center"> Unit </th>
                            <th class="text-center"> Keterangan </th>
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
                                <td> {{ invoice.customer_name.toUpperCase() }} </td>
                                <td> Rp. {{ invoice.total_payment }} </td>
                                <td>
                                    <ul v-for="unit in invoice.units" :key="unit.id" class="my-auto">
                                        <li class="py-1"> {{ unit.unit_type.toUpperCase() }} {{ unit.unit_name.toUpperCase() }} </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul v-for="unit in invoice.units" :key="unit.id" class="my-auto">
                                        <li class="py-1"> {{ unit.unit_description.toUpperCase() }} </li>
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
                                    <Link :href="route('invoice.show', {invoice: invoice.id})" type="button" class="btn btn-outline-primary showInvoice mr-1">
                                        <span class="icon-sm mdi mdi-eye"></span>
                                    </Link>
                                    <Link as="button" type="button" @click="setTarget(invoice.id)" class="btn btn-outline-success">
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
                        <a :href="route('invoices.export')" type="button" class="btn btn-lg btn-block btn-outline-primary mb-2">
                             Download Excel
                        </a>
                    </div>
                    <div class="col-md-9 px-4">
                        <div class="row float-right px-2">
                            <pagination class="" :links="invoices.links" />
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

export default {
    components: {
        Link,
        Head,
        Layout,
        Pagination,
    },
    props: {
        invoices: Object
    },
    methods: {
        setTarget (id) {
            window.open(route('invoice.print', {id: id}, "_blank"))
        }
    }
};
</script>
