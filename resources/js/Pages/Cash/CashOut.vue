<template>
    <Layout>
        <Head title="Cash Out" />
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Cash Out</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="cash_out.length === 0">
                                        <td colspan="7" class="text-center py-4">
                                            No data available in our record !
                                        </td>
                                    </tr>
                                    <tr v-for="cash in cash_out" :key="cash.id">
                                        <td>{{ cash.cash_date }}</td>
                                        <td>{{ cash.cash_description }}</td>
                                        <td>Rp. {{ cash.cash_amount }}</td>
                                        <td class="text-center">
                                            <button type="button" @click.prevent="edit(cash)" class="btn btn-outline-primary mr-1">
                                                <span class="icon-sm mdi mdi-pencil"></span>
                                            </button>
                                            <button type="button" @click.prevent="destroy(cash.id)" class="btn btn-outline-danger">
                                                <span class="icon-sm mdi mdi-delete"></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="dropdown-divider"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12 mt-3">
                                <button type="button" class="btn btn-lg btn-block btn-outline-primary">
                                    Export
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-12 mt-3">
                                <button type="button" class="btn btn-lg btn-block btn-outline-warning">
                                    Import
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Total</h4>
                            <h4 class="card-title">Rp. {{ total_amount }}</h4>
                        </div>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ editMode ? 'Edit Cash' : 'Add Cash' }}</h4>
                        <div class="dropdown-divider my-4"></div>
                        <form autocomplete="off">
                            <div class="form-group mb-4">
                                <label for="cash_description">Description</label>
                                <textarea rows="4" v-model="form.cash_description" class="form-control" id="cash_description" placeholder="Cash description"></textarea>
                                <small class="text-danger" v-if="errors.cash_description">{{ errors.cash_description[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="cash_date">Date</label>
                                <input type="text" v-model="form.cash_date" class="form-control" id="cash_date" placeholder="Cash date" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                <small class="text-danger" v-if="errors.cash_date">{{ errors.cash_date[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="cash_amount">Amount</label>
                                <input type="number" v-model="form.cash_amount" class="form-control" id="cash_amount" placeholder="Cash amount">
                                <small class="text-danger" v-if="errors.cash_amount">{{ errors.cash_amount[0] }}</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="row">
                                <div v-show="!editMode" class="col-md-8 mx-auto mt-2">
                                    <button @click.prevent="store(form)" type="button" class="btn btn-lg btn-block btn-outline-success mx-auto">Save</button>
                                </div>
                                <div v-show="editMode" class="col-md-6 mx-auto mt-2">
                                    <button @click="update(form)" type="button" class="btn btn-lg btn-block btn-outline-success mx-auto">Update</button>
                                </div>
                                <div v-show="editMode" class="col-md-6 mx-auto mt-2">
                                    <button @click.prevent="reset()" type="button" class="btn btn-lg btn-block btn-outline-danger mx-auto">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
    data () {
        return {
            editMode: false,
            form: {
                cash_description: null,
                cash_date: null,
                cash_amount: null,
            },
        }
    },
    setup () {
        function destroy(id) {
            if(confirm('Are you sure you want to delete this cash?')) {
                Inertia.delete(`/cash-out/`+ id +`/delete`)
            }
        }
        return {
            destroy
        }
    },
    methods: {
        store(data) {
            Inertia.post('/cash-out', data, {
                onSuccess: () => this.reset()
            }, {
                onError: () => this.editMode = true
            })
            this.clearErrors()
        },
        edit (data) {
            this.form = Object.assign({}, data)
            this.editMode = true
        },
        update (data) {
            Inertia.put(`/cash-out/`+ data.id, data, {
                onSuccess: () => this.reset()
            }, {
                onError: () => this.editMode = true
            })
            this.clearErrors()
        },
        reset () {
            this.form = {
                cash_description: null,
                cash_date: null,
                cash_amount: null,
            }
            this.editMode = false
        }
    },
    props: {
        cash_out: Object,
        total_amount: Object,
        errors: Object,
    },
};
</script>
