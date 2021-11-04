<template>
    <Layout>
        <Head title="Show Invoice" />
        <div class="card">
            <div class="card-body text-secondary">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title text-secondary">Invoice</h4>
                    <h4>{{ invoice.invoice_code }}</h4>
                </div>
                <div class="dropdown-divider mb-4"></div>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>Customer Name</label>
                        <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.customer_name" />
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Customer Phone</label>
                        <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.customer_phone" />
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Date In</label>
                        <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.date_in" />
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Date Taken</label>
                        <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.date_taken" />
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Guarantee</label>
                        <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.guarantee" />
                    </div>
                </div>
                <table class="table table-responsive table-bordered rounded text-center my-2">
                    <tr class="text-center">
                        <th width="10%">Qty</th>
                        <th width="15%">Unit</th>
                        <th width="15%">Unit Name</th>
                        <th width="20%">Description</th>
                        <th width="25%">Completeness</th>
                        <th width="10%">Cost</th>
                        <th width="20%">Total</th>
                    </tr>
                    <tr v-for="unit in invoice.units" :key="unit.id" class="text-secondary">
                        <td class="text-center">{{ unit.unit_quantity }}</td>
                        <td>{{ unit.unit_type }}</td>
                        <td>{{ unit.unit_name }}</td>
                        <td>{{ unit.unit_description }}</td>
                        <td>{{ unit.unit_completeness }}</td>
                        <td>Rp. {{ unit.unit_cost }}</td>
                        <td class="text-center">
                            <div>Rp. {{ unit.total_cost }}</div>
                        </td>
                    </tr>
                </table>
                <div class="row justify-content-between pl-2 mt-4">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="form-group col-md-6 px-1">
                                <label>Order Status</label>
                                <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.order_status" />
                            </div>
                            <div class="form-group col-md-6 px-1">
                                <label>Payment Status</label>
                                <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.payment_status" />
                            </div>
                            <div class="form-group col-md-12 px-1">
                                <label>Notes</label>
                                <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded">
                                    {{ invoice.notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Subtotal</label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.subtotal" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Discount</label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.discount" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Total</label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.total_payment" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Down Pay</label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.down_payment" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Dependents</label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-4 py-2 text-sm border rounded" v-html="invoice.dependents" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider mt-3"></div>
                <div class="row mt-3">
                    <div class="col-md-2">
                        <Link :href="`/invoice/`+ invoice.id +`/edit`" type="button" class="btn btn-lg btn-block btn-outline-primary mb-2">
                            Edit
                        </Link>
                    </div>
                    <div class="col-md-2">
                        <button type="button" @click.prevent="destroy(invoice.id)" class="btn btn-lg btn-block btn-outline-danger mb-2">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../Shared/Layout";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        Head,
        Layout,
        Link
    },
    props: {
        invoice: Object,
        errors: Object,
    },
    setup() {
        function destroy (id) {
            if (confirm('Are you sure you want to delete this invoice?')) {
                Inertia.delete(`/invoice/`+ id +`/delete`)
            }
        }
        return {
            destroy
        }
    }
};
</script>