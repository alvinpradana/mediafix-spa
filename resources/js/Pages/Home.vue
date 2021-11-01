<template>
    <Layout>
        <Head title="Homepage" />
        <div class="row">
            <!-- <Invoice /> -->
            <div class="col-sm-4 grid-margin">
                <Link href="/invoices" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <!-- <h5>INVOICES</h5> -->
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <!-- <h2 class="mb-0">{{ invoices.length }}</h2> -->
                                    <h2 class="mb-0">Invoices</h2>
                                    <!-- <p class="text-success ml-2 mb-0 font-weight-medium">Invoices</p> -->
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
            <!-- <Sparepart /> -->
            <div class="col-sm-4 grid-margin">
                <Link href="/cash-out" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <!-- <h5>CASH OUT</h5> -->
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <!-- <h2 class="mb-0">{{ sparepart }}</h2> -->
                                    <h2 class="mb-0">Cash Out</h2>
                                    <!-- <p class="text-danger ml-2 mb-0 font-weight-medium">Stock</p> -->
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
            <!-- <Equipment /> -->
            <div class="col-sm-4 grid-margin">
                <Link href="/equipment" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <!-- <h5>REPORT</h5> -->
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <!-- <h2 class="mb-0">{{ equipment }}</h2> -->
                                    <h2 class="mb-0">Report</h2>
                                    <!-- <p class="text-primary ml-2 mb-0 font-weight-medium">Stock</p> -->
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Manage company report
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
                            <th> Invoice Code </th>
                            <th> Customer Name </th>
                            <th> Order Cost </th>
                            <th class="text-center"> Unit </th>
                            <th class="text-center"> Description </th>
                            <th> Order Status </th>
                            <th class="text-center"> Action </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-if="invoices.length === 0">
                                <td colspan="7" class="text-center pt-4">
                                    No data available in our record !
                                </td>
                            </tr>
                            <tr v-for="invoice in invoices" :key="invoice.id">
                                <td> {{ invoice.invoice_code }} </td>
                                <td> {{ invoice.customer_name }} </td>
                                <td> Rp. {{ invoice.total_payment }} </td>
                                <td>
                                    <ul v-for="unit in invoice.units" :key="unit.id">
                                        <li> {{ unit.unit_type }} {{ unit.unit_name }} </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul v-for="unit in invoice.units" :key="unit.id">
                                        <li> {{ unit.unit_description }} </li>
                                    </ul>    
                                </td> 
                                <td>
                                    <div v-if="invoice.order_status == 'Process'" class="badge badge-outline-warning mr-1">{{ invoice.order_status }}</div>
                                    <div v-else-if="invoice.order_status == 'Fixed'" class="badge badge-outline-success mr-1">{{ invoice.order_status }}</div>
                                    <div v-else class="badge badge-outline-danger mr-1">{{ invoice.order_status }}</div>
                                    <div v-if="invoice.payment_status == 'Paid'" class="badge badge-outline-success">{{ invoice.payment_status }}</div>
                                    <div v-else-if="invoice.payment_status == 'Down Payment'" class="badge badge-outline-primary">{{ invoice.payment_status }}</div>
                                    <div v-else-if="invoice.payment_status == 'Unpaid'" class="badge badge-outline-warning">{{ invoice.payment_status }}</div>
                                    <div v-else class="badge badge-outline-danger">{{ invoice.payment_status }}</div>
                                </td>
                                <td class="text-center">
                                    <Link :href="`/invoice/`+ invoice.id +`/edit`" type="button" class="btn btn-outline-primary">
                                        <span class="icon-sm mdi mdi-eye"></span>
                                    </Link>
                                    <!-- <button type="button" @click.prevent="" class="btn btn-outline-primary">
                                        <span class="icon-sm mdi mdi-printer"></span>
                                    </button> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Layout from "./Shared/Layout";

export default {
    components: {
        Link,
        Head,
        Layout,
    },
    props: {
        invoices: Object,
        sparepart: Object,
        equipment: Object
    },
};
</script>
