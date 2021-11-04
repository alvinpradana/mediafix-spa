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
                            <tr v-for="invoice in invoices.data" :key="invoice.id">
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
                                    <Link :href="`/show-invoice/`+ invoice.id" type="button" class="btn btn-outline-primary showInvoice mr-1">
                                        <span class="icon-sm mdi mdi-eye"></span>
                                    </Link>
                                    <button type="button" class="btn btn-outline-warning">
                                        <span class="icon-sm mdi mdi-printer"></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="dropdown-divider"></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <a href="/invoices-export" type="button" class="btn btn-lg btn-block btn-outline-primary mb-2">
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
    }
};
</script>
