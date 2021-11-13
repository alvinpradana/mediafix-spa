<template>
    <Layout>
        <Head title="Show Invoice" />
        <div class="card">
            <div class="card-body text-secondary">
                <div class="d-flex justify-content-between">
                    <div class="col-sm-6">
                        <div class="row">
                            <h4 class="card-title text-secondary mr-2">Invoice</h4>
                            <small v-show="invoice.mark === 1" class="text-success"><strong>* <u>taken by customer</u></strong></small>
                        </div>
                    </div>
                    <h4>{{ invoice.invoice_code }}</h4>
                </div>
                <div class="dropdown-divider mb-4"></div>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label class="text-muted"><strong>Nama Customer</strong></label>
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                            {{ invoice.customer_name.toUpperCase() }}
                        </div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="text-muted"><strong>Telepon / WA</strong></label>
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                            0{{ invoice.customer_phone }}
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label class="text-muted"><strong>Tanggal Masuk</strong></label>
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                            {{ invoice.date_in }}
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label class="text-muted"><strong>Pengambilan</strong></label>
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                            {{ invoice.date_taken }}
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label class="text-muted"><strong>Garansi</strong></label>
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                            {{ invoice.guarantee }} Hari
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-bordered rounded text-center my-2">
                    <tr class="text-center">
                        <th width="10%">Qty</th>
                        <th width="15%">Unit</th>
                        <th width="15%">Tipe</th>
                        <th width="20%">Keterangan</th>
                        <th width="25%">Kelengkapan</th>
                        <th width="10%">Biaya</th>
                        <th width="20%">Total</th>
                    </tr>
                    <tr v-for="unit in invoice.units" :key="unit.id" class="text-secondary">
                        <td class="text-center">{{ unit.unit_quantity }}</td>
                        <td>{{ unit.unit_type.toUpperCase() }}</td>
                        <td>{{ unit.unit_name.toUpperCase() }}</td>
                        <td>{{ unit.unit_description.toUpperCase() }}</td>
                        <td>{{ unit.unit_completeness.toUpperCase() }}</td>
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
                                <label class="text-muted"><strong>Status Order</strong></label>
                                <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                                    {{ invoice.order_status.toUpperCase() }}
                                </div>
                            </div>
                            <div class="form-group col-md-6 px-1">
                                <label class="text-muted"><strong>Status Pembayaran</strong></label>
                                <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                                    {{ invoice.payment_status.toUpperCase() }}
                                </div>
                            </div>
                            <div class="form-group col-md-12 px-1">
                                <label class="text-muted"><strong>Catatan</strong></label>
                                <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                                    {{ invoice.notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-muted"><strong>Subtotal</strong></label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                                    {{ invoice.subtotal }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-muted"><strong>Discount</strong></label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                                    {{ invoice.discount }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-muted"><strong>Total</strong></label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                                    {{ invoice.total_payment }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-muted"><strong>Uang Muka</strong></label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                                    {{ invoice.down_payment }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-muted"><strong>Sisa Bayar</strong></label>
                            <div class="col-sm-8">
                                <div class="mr-1 mb-1 px-3 py-2 text-sm border rounded">
                                    {{ invoice.dependents }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider mt-3"></div>
                <div class="row justify-content-between mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" @click.prevent="destroy(invoice.id)" class="btn btn-lg btn-block btn-outline-danger mb-2">
                                    Delete
                                </button>
                            </div>
                            <div class="col-md-4">
                                <Link :href="route('invoice.edit', {invoice: invoice.id}, 'edit')" type="button" class="btn btn-lg btn-block btn-outline-primary mb-2">
                                    Edit
                                </Link>
                            </div>
                            <div class="col-md-4">
                                <a :href="linkWhatsapp()" target="_blank" as="button" type="button" class="btn btn-lg btn-block btn-outline-warning mb-2">
                                    <i class="mdi mdi-print"></i>
                                    Send
                                </a>
                            </div>
                        </div>
                    </div>
                    <div v-show="invoice.mark === 0" class="col-md-3">
                        <button type="button" @click.prevent="mark(form)" class="btn btn-lg btn-block btn-outline-success mb-2">
                            Mark as taken
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
        Layout,
        Head,
        Link
    },
    data () {
        return {
            form: {
                mark: 1
            }
        }
    },
    props: {
        invoice: Object,
        link: Object,
        errors: Object,
    },
    setup() {
        function destroy (id) {
            if (confirm('Are you sure you want to delete this invoice?')) {
                Inertia.delete(route('invoice.destroy', {invoice: id}))
            }
        }
        return {
            destroy
        }
    },
    methods: {
        mark (data) {
            if (confirm('Anda yakin unit servis telah diambil?')) {
                Inertia.put(route('invoice.taken', {id: this.invoice.id}), data)
            }
        },
        linkWhatsapp () {
            return 'https://wa.me/' + this.link
        }
    }
};
</script>