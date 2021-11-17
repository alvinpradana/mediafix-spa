<template>
    <Layout>
        <Head title="Homepage" />
        <div class="row">
            <div class="col-sm-4 grid-margin">
                <Link :href="route('invoice.index')" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">Invoices</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Manage invoices order
                                </h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-deskphone text-success ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
            <div class="col-sm-4 grid-margin">
                <Link :href="route('cash.index')" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">Cash Out</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Manage company cash out
                                </h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-arrow-top-right text-danger ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
            <div class="col-sm-4 grid-margin">
                <Link :href="route('users.index')" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">Users</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Manage company users admin
                                </h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-chart-line text-primary ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">History Order</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th> Nomor Nota </th>
                            <th> Nama Customer  </th>
                            <th> Biaya </th>
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
                                    <ul v-for="unit in invoice.units" :key="unit.id">
                                        <li class="text-capitalize"> {{ unit.unit_type }} {{ unit.unit_name }} </li>
                                    </ul>
                                </td>
                                <td>
                                    <div v-if="invoice.order_status == 'Diagnosa'" class="badge badge-pill badge-warning mr-1"><span class="px-1">{{ invoice.order_status }}</span></div>
                                    <div v-else-if="invoice.order_status == 'Process Repair'" class="badge badge-pill badge-warning mr-1"><span class="px-1">{{ invoice.order_status }}</span></div>
                                    <div v-else-if="invoice.order_status == 'Testing Unit'" class="badge badge-pill badge-primary mr-1"><span class="px-1">{{ invoice.order_status }}</span></div>
                                    <div v-else-if="invoice.order_status == 'Selesai'" class="badge badge-pill badge-success mr-1"><span class="px-1">{{ invoice.order_status }}</span></div>
                                    <div v-else class="badge badge-pill badge-danger mr-1"><span class="px-1">{{ invoice.order_status }}</span></div>

                                    <div v-if="invoice.payment_status == 'Lunas'" class="badge badge-pill badge-success"><span class="px-1">{{ invoice.payment_status }}</span></div>
                                    <div v-else-if="invoice.payment_status == 'Uang Muka'" class="badge badge-pill badge-primary"><span class="px-1">{{ invoice.payment_status }}</span></div>
                                    <div v-else-if="invoice.payment_status == 'Belum Bayar'" class="badge badge-pill badge-warning"><span class="px-1">{{ invoice.payment_status }}</span></div>
                                    <div v-else class="badge badge-pill badge-danger"><span class="px-1">{{ invoice.payment_status }}</span></div>
                                </td>
                                <td class="text-center">
                                    <Link :href="route('invoice.show', {invoice: invoice.id})" type="button" class="btn btn-primary mr-1">
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
                <div class="row justify-content-center">
                    <pagination class="mt-3" :links="invoices.links" />
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Layout from "../Shared/Layout";
import Pagination from "../Shared/Pagination"

export default {
    components: {
        Link,
        Head,
        Layout,
        Pagination,
    },
    props: {
        invoices: Object,
        sparepart: Object,
        equipment: Object,
    },
    methods: {
        setTarget (id) {
            window.open(route('invoice.print', {id: id}, "_blank"))
        }
    }
};
</script>
