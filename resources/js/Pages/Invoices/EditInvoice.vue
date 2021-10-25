<template>
    <Layout>
        <Head title="Edit Invoice" />
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit this Invoice</h4>
                <div class="dropdown-divider my-4"></div>
                <form @submit.prevent="update" autocomplete="off">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label for="invoice_code">Invoice Code</label>
                            <input type="text" v-model="form.invoice_code" id="invoice_code" class="form-control" placeholder="Invoice code">
                            <small class="text-danger" v-if="errors.invoice_code">{{ errors.invoice_code[0] }}</small>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="customer_name">Customer Name</label>
                            <input type="name" id="customer_name" v-model="form.customer_name" class="form-control" placeholder="Enter name">
                            <small class="text-danger" v-if="errors.customer_name">{{ errors.customer_name[0] }}</small>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="customer_phone">Phone Number</label>
                            <input type="text" id="customer_phone" v-model="form.customer_phone" class="form-control" placeholder="Enter phone number">
                            <small class="text-danger" v-if="errors.customer_phone">{{ errors.customer_phone[0] }}</small>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="date_in">Date In</label>
                            <input type="text" v-model="form.date_in" id="date_in" class="form-control" placeholder="Enter date in" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                            <small class="text-danger" v-if="errors.date_in">{{ errors.date_in[0] }}</small>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="date_taken">Date Taken</label>
                            <input type="text" v-model="form.date_taken" id="date_taken" class="form-control" placeholder="Enter date taken" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                            <small class="text-danger" v-if="errors.date_taken">{{ errors.date_taken[0] }}</small>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="guarantee">Guarantee</label>
                            <div class="input-group">
                                <input type="number" id="guarantee" v-model="form.guarantee" class="form-control" placeholder="Long warranty">
                                <small class="text-danger" v-if="errors.guarantee">{{ errors.guarantee[0] }}</small>
                                <div class="input-group-append">
                                    <span class="input-group-text">Days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered mt-2">
                        <tr class="text-center">
                            <th width="10%">Qty</th>
                            <th width="15%">Unit</th>
                            <th width="15%">Unit Name</th>
                            <th width="20%">Description</th>
                            <th width="15%">Completeness</th>
                            <th width="10%">Cost</th>
                            <th width="15%">Total</th>
                            <th width="2%">Delete</th>
                        </tr>
                        <tr v-for="(unit, index) in form.units" :key="unit.id">
                            <td>
                                <input type="number" v-model="unit.unit_quantity" class="form-control">
                                <small class="text-danger" v-if="errors['units.'+ index +'.unit_quantity']">
                                    {{ errors['units.'+ index +'.unit_quantity'][0] }}
                                </small>
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
                                <small class="text-danger" v-if="errors['units.'+ index +'.unit_name']">
                                    {{ errors['units.'+ index +'.unit_name'][0] }}
                                </small>
                            </td>			
                            <td>
                                <input type="text" v-model="unit.unit_description" class="form-control">
                                <small class="text-danger" v-if="errors['units.'+ index +'.unit_description']">
                                    {{ errors['units.'+ index +'.unit_description'][0] }}
                                </small>
                            </td>
                            <td>
                                <input type="text" v-model="unit.unit_completeness" class="form-control">
                                <small class="text-danger" v-if="errors['units.'+ index +'.unit_completeness']">
                                    {{ errors['units.'+ index +'.unit_completeness'][0] }}
                                </small>
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
                    <!-- <div v-if="errors.units_empty">
                        <p class="alert alert-danger">{{errors.units_empty[0]}}</p>
                        <hr>
                    </div> -->
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
                                        <small class="text-danger" v-if="errors.order_status">{{ errors.order_status[0] }}</small>
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
                                        <small class="text-danger" v-if="errors.payment_status">{{ errors.payment_status[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 pr-4">
                                    <div class="form-group row">
                                        <label for="notes" class="col-form-label">Notes :</label>
                                        <textarea class="form-control txt" rows="6" v-model="form.notes" id="notes" placeholder="Notes of this invoice!"></textarea>
                                        <small class="text-danger" v-if="errors.notes">{{ errors.notes[0] }}</small>
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
                                                    <small class="text-danger" v-if="errors.discount">{{ errors.discount[0] }}</small>
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
                                                    <small class="text-danger" v-if="errors.down_payment">{{ errors.down_payment[0] }}</small>
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
    data (props) {
        const form = reactive({
            invoice_code: props.invoice.invoice_code,
            customer_name: props.invoice.customer_name,
            customer_phone: props.invoice.customer_phone,
            date_in: props.invoice.date_in,
            date_taken: props.invoice.date_taken,
            guarantee: props.invoice.guarantee,
            order_status: props.invoice.order_status,
            payment_status: props.invoice.payment_status,
            discount: props.invoice.discount,
            down_payment: props.invoice.down_payment,
            notes: props.invoice.notes,
            units: [{
                unit_quantity: props.invoice.units.unit_quantity,
                unit_type: props.invoice.units.unit_type,
                unit_name: props.invoice.units.unit_name,
                unit_description: props.invoice.units.unit_description,
                unit_completeness: props.invoice.units.unit_completeness,
                unit_cost: props.invoice.units.unit_cost,
            }],
        })
        function update () {
            Inertia.put(`/invoice/${invoice.id}`, form)
        }
        return { form, update }
    },
    props: {
        invoice: Object,
        errors: Object,
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