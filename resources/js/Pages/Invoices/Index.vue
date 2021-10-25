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
                            <th> Customer Name </th>
                            <th> Invoice Code </th>
                            <th> Order Cost </th>
                            <th class="text-center"> Unit </th>
                            <th class="text-center"> Description </th>
                            <th> Order Status </th>
                            <th class="text-center"> Action </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="invoice in invoices" :key="invoice.id">
                                <td>
                                    <i class="icon-sm mdi mdi mdi-account-circle text-success"></i>
                                <span class="pl-2"> {{ invoice.customer_name }} </span>
                                </td>
                                <td> {{ invoice.invoice_code }} </td>
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
                                    <Link :href="`/invoice/${invoice.id}/edit`" type="button" class="btn btn-outline-primary showInvoice mr-1">
                                        <span class="icon-sm mdi mdi-eye"></span>
                                    </Link>
                                    <button type="button" @click.prevent="destroy(`${invoice.id}`)" class="btn btn-outline-danger">
                                        <span class="icon-sm mdi mdi-delete"></span>
                                    </button>
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
        invoices: Object
    },
    setup() {
        function destroy (id) {
            if (confirm('Are you sure you want to delete this invoice?')) {
                Inertia.delete(`/invoice/${id}/delete`)
            }
        }
        return {
            destroy
        }
    }
};
</script>
