<template>
    <Layout>
        <Head title="Create Invoice" />
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Create New Invoice</h4>
                <div class="dropdown-divider my-4"></div>
                <form @submit.prevent="submit" autocomplete="off">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label for="invoice_code">Invoice Code</label>
                            <input type="text" v-model="form.invoice_code" id="invoice_code" class="form-control" placeholder="Invoice code">
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="customer_name">Customer Name</label>
                            <input type="name" id="customer_name" v-model="form.customer_name" class="form-control" placeholder="Enter name">
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="customer_phone">Phone Number</label>
                            <input type="text" id="customer_phone" v-model="form.customer_phone" class="form-control" placeholder="Enter phone number">
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="date_in">Date In</label>
                                <input type="text" v-model="form.date_in" id="date_in" class="form-control" placeholder="Enter date in" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                            </div>
                        <div class="form-group col-sm-2">
                            <label for="date_taken">Date Taken</label>
                                <input type="text" v-model="form.date_taken" id="date_taken" class="form-control" placeholder="Enter date taken" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="guarantee">Guarantee</label>
                            <div class="input-group">
                                <input type="text" id="guarantee" v-model="form.guarantee" class="form-control" placeholder="Long warranty">
                                <div class="input-group-append">
                                    <span class="input-group-text">Days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered table-hover mt-2">
                        <tr>
                            <th class="text-center" width="10%">Qty</th>
                            <th width="15%">Unit</th>
                            <th width="15%">Unit Name</th>
                            <th width="20%">Description</th>
                            <th width="15%">Completeness</th>
                            <th width="10%">Cost</th>
                            <th class="text-center" width="15%">Total</th>
                            <th width="2%">Delete</th>
                        </tr>
                        <tr v-for="(unit, index) in form.units" :key="unit.id">
                            <td>
                                <input type="number" v-model="unit.unit_quantity" class="form-control">
                            </td>
                            <td>
                                <select v-model="unit.unit_type" class="text-white form-control">
                                    <option value="Camera">Camera</option>
                                    <option value="Phone">Phone</option>
                                    <option value="Laptop-PC">Laptop-PC</option>
                                    <option value="Other">Other</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" v-model="unit.unit_name" class="form-control">
                            </td>			
                            <td>
                                <input type="text" v-model="unit.unit_description" class="form-control">
                            </td>
                            <td>
                                <input type="text" v-model="unit.unit_completeness" class="form-control">
                            </td>
                            <td>
                                <input type="number" v-model="unit.unit_cost" class="form-control">
                            </td>
                            <td class="text-center text-success">
                                <div><strong>Rp. {{ total_cost[index] }}</strong></div>
                            </td>
                            <td>
                                <button type="button" @click="deleteRow(index)" class="btn btn-social-icon btn-outline-danger">&times;</button>
                            </td>
                        </tr>
                    </table>
                    <div class="col-sm-12 col-md-2 mt-2 p-0">
                        <button type="button" @click="addRow()" class="btn btn-lg btn-block btn-outline-success"> Add Item </button>
                    </div>
                    <div class="row justify-content-between pl-2">
                        <div class="col-md-8">
                            <div class="row mt-4">
                                <div class="col-sm-12 col-md-6 pr-4">
                                    <div class="row">
                                        <p>Order Status :</p>
                                    </div>
                                    <div class="row mb-4">
                                        <select v-model="form.order_status" class="form-control text-white"> Select One
                                            <option value="Process"> Process </option>
                                            <option value="Fixed"> Fixed </option>
                                            <option value="Cancel"> Cancel </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 pr-4">
                                    <div class="row">
                                        <p>Payment Status :</p>
                                    </div>
                                    <div class="row mb-4">
                                        <select v-model="form.payment_status" class="form-control text-white"> Select One
                                            <option value="Paid"> Paid </option>
                                            <option value="Down Payment"> Down Payment </option>
                                            <option value="Unpaid"> Unpaid </option>
                                            <option value="Cancel"> Cancel </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 pr-4">
                                    <div class="form-group row">
                                        <label for="notes" class="col-form-label">Notes :</label>
                                        <textarea class="form-control txt" rows="6" v-model="form.notes" id="notes" placeholder="Notes of invoice order!"></textarea>
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
                                                    <input type="number" v-model="form.discount" class="form-control" placeholder="Discount">
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
                                            <td>Amount Paid</td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input type="number" v-model="form.down_payment" class="form-control" placeholder="Amount Paid / DP">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dependents</td>
                                            <td class="text-danger"><strong>Rp. {{ dependents }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider mt-4"></div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-lg btn-block btn-outline-success mb-2">
                                <i class="mdi mdi-print"></i>
                                Print Invoice
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
            invoice_code: this.invoice_code,
            customer_name: null,
            phone_number: null,
            date_in: null,
            date_taken: null,
            guarantee: null,
            order_status: null,
            payment_status: null,
            subtotal: this.subtotal,
            discount: null,
            total_payment: this.total_payment,
            down_payment: null,
            dependents: this.dependents,
            notes: null,
            units: [{
                invoice_id: null,
                unit_quantity: 1,
                unit_type: null,
                unit_name: null,
                unit_description: null,
                unit_completeness: null,
                unit_cost: null,
                total_cost: this.total_cost,
            }],
        })
        function submit () {
            Inertia.post('/invoices', form)
        }
        return { form, submit }
    },
    props: {
        errors: Object,
        invoice_code: Object,
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