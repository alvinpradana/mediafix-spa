<template>
    <Layout>
        <Head title="Create Invoice" />
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Create New Invoice</h4>
                    <h4 class="card-title">{{ invoice_code }}</h4>
                </div>
                <div class="dropdown-divider mb-4"></div>
                <form @submit.prevent="submit" autocomplete="off">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="customer_name">Nama Customer</label>
                            <input type="name" id="customer_name" v-model="form.customer_name" class="form-control" :class="{'is-invalid': errors.customer_name}" placeholder="Enter name">
                            <small class="invalid-feedback" v-if="errors.customer_name">{{ errors.customer_name[0] }}</small>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="customer_phone">Telepon / WA</label>
                            <input type="text" id="customer_phone" v-model="form.customer_phone" class="form-control" :class="{'is-invalid': errors.customer_phone}" placeholder="Enter phone number">
                            <small class="invalid-feedback" v-if="errors.customer_phone">{{ errors.customer_phone[0] }}</small>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="date_in">Tanggal Masuk</label>
                            <input type="text" v-model="form.date_in" id="date_in" class="form-control" :class="{'is-invalid': errors.date_in}" placeholder="Enter date in" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                            <small class="invalid-feedback" v-if="errors.date_in">{{ errors.date_in[0] }}</small>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="date_taken">Pengambilan</label>
                            <input type="text" v-model="form.date_taken" id="date_taken" class="form-control" :class="{'is-invalid': errors.date_taken}" placeholder="Enter date taken" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                            <small class="invalid-feedback" v-if="errors.date_taken">{{ errors.date_taken[0] }}</small>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="guarantee">Garansi</label>
                            <div class="input-group">
                                <input type="number" id="guarantee" v-model="form.guarantee" class="form-control" :class="{'is-invalid': errors.guarantee}" placeholder="Long warranty">
                                <small class="invalid-feedback" v-if="errors.guarantee">{{ errors.guarantee[0] }}</small>
                                <div class="input-group-append">
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered mt-2">
                        <tr class="text-center">
                            <th width="10%">Qty</th>
                            <th width="15%">Unit</th>
                            <th width="15%">Tipe</th>
                            <th width="20%">Keterangan</th>
                            <th width="15%">Kelengkapan</th>
                            <th width="10%">Biaya</th>
                            <th width="15%">Total</th>
                            <th width="2%">Delete</th>
                        </tr>
                        <tr v-for="(unit, index) in form.units" :key="unit.id">
                            <td>
                                <input type="number" v-model="unit.unit_quantity" class="form-control" :class="{'is-invalid': errors.unit_quantity}">
                                <small class="invalid-feedback" v-if="errors['units.'+ index +'.unit_quantity']">
                                    {{ errors['units.'+ index +'.unit_quantity'][0] }}
                                </small>
                            </td>
                            <td>
                                <select v-model="unit.unit_type" class="text-white form-control" :class="{'is-invalid': errors.unit_type}">
                                    <option value="Camera">Camera</option>
                                    <option value="Phone">Phone</option>
                                    <option value="Laptop/PC">Laptop/PC</option>
                                    <option value="Device">Lainnya</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" v-model="unit.unit_name" class="form-control" :class="{'is-invalid': errors.unit_name}">
                                <small class="invalid-feedback" v-if="errors['units.'+ index +'.unit_name']">
                                    {{ errors['units.'+ index +'.unit_name'][0] }}
                                </small>
                            </td>			
                            <td>
                                <input type="text" v-model="unit.unit_description" class="form-control" :class="{'is-invalid': errors.unit_description}">
                                <small class="invalid-feedback" v-if="errors['units.'+ index +'.unit_description']">
                                    {{ errors['units.'+ index +'.unit_description'][0] }}
                                </small>
                            </td>
                            <td>
                                <input type="text" v-model="unit.unit_completeness" class="form-control" :class="{'is-invalid': errors.unit_completeness}">
                                <small class="invalid-feedback" v-if="errors['units.'+ index +'.unit_completeness']">
                                    {{ errors['units.'+ index +'.unit_completeness'][0] }}
                                </small>
                            </td>
                            <td>
                                <input type="number" v-model="unit.unit_cost" class="form-control" :class="{'is-invalid': errors.unit_cost}">
                            </td>
                            <td class="text-center text-success">
                                <div><strong>Rp. {{ total_cost[index] }}</strong></div>
                            </td>
                            <td>
                                <button type="button" @click="deleteRow(index)" class="btn btn-social-icon btn-outline-danger">&times;</button>
                            </td>
                        </tr>
                    </table>
                    <div v-if="$page.props.flash.alert_error" class="alert alert-danger my-2" role="alert">
                        {{ $page.props.flash.alert_error }}
                    </div>
                    <div class="col-sm-12 col-md-2 mt-2 p-0">
                        <button type="button" @click="addRow()" class="btn btn-lg btn-block btn-outline-success"> Add Item </button>
                    </div>
                    <div class="row justify-content-between pl-2">
                        <div class="col-md-8">
                            <div class="row mt-4">
                                <div class="col-sm-12 col-md-6 pr-4">
                                    <div class="row">
                                        <p>Status Order</p>
                                    </div>
                                    <div class="row mb-4">
                                        <select v-model="form.order_status" class="form-control text-white" :class="{'is-invalid': errors.order_status}">
                                            <option value="Proses">Proses</option>
                                            <option value="Selesai">Selesai</option>
                                            <option value="Batal">Batal</option>
                                        </select>
                                        <small class="invalid-feedback" v-if="errors.order_status">{{ errors.order_status[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 pr-4">
                                    <div class="row">
                                        <p>Status Pembayaran</p>
                                    </div>
                                    <div class="row mb-4">
                                        <select v-model="form.payment_status" class="form-control text-white" :class="{'is-invalid': errors.payment_status}">
                                            <option value="Lunas">Lunas</option>
                                            <option value="Uang Muka">Uang Muka</option>
                                            <option value="Belum Bayar">Belum Bayar</option>
                                            <option value="Batal">Batal</option>
                                        </select>
                                        <small class="invalid-feedback" v-if="errors.payment_status">{{ errors.payment_status[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 pr-4">
                                    <div class="form-group row">
                                        <label for="notes" class="col-form-label">Catatan</label>
                                        <textarea class="form-control txt" :class="{'is-invalid': errors.notes}" rows="6" v-model="form.notes" id="notes" placeholder="Catatan nota!"></textarea>
                                        <small class="invalid-feedback" v-if="errors.notes">{{ errors.notes[0] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Subtotal</td>
                                            <td class="text-success"><strong>Rp. {{ subtotal }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Discount</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" v-model="form.discount" class="form-control" :class="{'is-invalid': errors.discount}" placeholder="Discount">
                                                    <small class="invalid-feedback" v-if="errors.discount">{{ errors.discount[0] }}</small>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-success"><strong>Rp. {{ total_payment }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Uang Muka</td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input type="number" v-model="form.down_payment" class="form-control" :class="{'is-invalid': errors.down_payment}" placeholder="Jumlah bayar">
                                                    <small class="invalid-feedback" v-if="errors.down_payment">{{ errors.down_payment[0] }}</small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sisa Bayar</td>
                                            <td class="text-danger"><strong>Rp. {{ dependents }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider mt-4"></div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-lg btn-block btn-outline-success mb-2">
                                <i class="mdi mdi-print"></i>
                                Save Invoice
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-lg btn-block btn-outline-warning mb-2">
                                <i class="mdi mdi-print"></i>
                                Save & Send
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../Shared/Layout";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive } from '@vue/reactivity';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        Head,
        Layout,
    },
    data () {
        const form = reactive({
            user_id: this.user,
            invoice_code: this.invoice_code,
            customer_name: null,
            customer_phone: null,
            date_in: null,
            date_taken: null,
            guarantee: null,
            order_status: null,
            payment_status: null,
            discount: 0,
            down_payment: 0,
            notes: null,
            units: [{
                unit_quantity: 1,
                unit_type: null,
                unit_name: null,
                unit_description: null,
                unit_completeness: null,
                unit_cost: null,
            }],
        })
        function submit () {
            Inertia.post(route('invoice.store'), form)
        }
        return { form, submit }
    },
    props: {
        errors: Object,
        invoice_code: Object,
        user: Object,
        units_empty: Object,
    },
    computed: {
        total_cost () {
            return this.form.units.map((unit) => {
                return Number(unit.unit_quantity * unit.unit_cost)
            })
        },
        subtotal () {
            return this.form.units.reduce((accumulator, unit) => {
                return accumulator + (unit.unit_quantity * unit.unit_cost)
            }, 0)
        },
        discount () {
            return this.subtotal * (this.form.discount / 100)
        },
        total_payment () {
            return this.subtotal - this.discount
        },
        dependents () {
            return this.total_payment - this.form.down_payment
        }
    },
    methods: {
        addRow () {
            this.form.units.push({
                unit_quantity: 1,
                unit_type: null,
                unit_name: null,
                unit_description: null,
                unit_completeness: null,
                unit_cost: null,
                total_cost: null,
            })
        },
        deleteRow (index) {
            this.form.units.splice(index, 1);
        }
    }
};
</script>