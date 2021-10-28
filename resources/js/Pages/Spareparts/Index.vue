<template>
    <Layout>
        <Head title="Sparepart" />
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Sparepart</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sparepart Type</th>
                                        <th>Sparepart Name</th>
                                        <th>Stock</th>
                                        <th>Price Per Item</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="spareparts.length === 0">
                                        <td colspan="5" class="text-center py-4">
                                            No data available in our record !
                                        </td>
                                    </tr>
                                    <tr v-for="sparepart in spareparts" :key="sparepart.id">
                                        <td>{{ sparepart.sparepart_type }}</td>
                                        <td>{{ sparepart.sparepart_name }}</td>
                                        <td>{{ sparepart.sparepart_quantity }}</td>
                                        <td>{{ sparepart.sparepart_price }}</td>
                                        <td class="text-center">
                                            <button type="button" @click.prevent="edit(sparepart)" class="btn btn-outline-primary mr-1">
                                                <span class="icon-sm mdi mdi-pencil"></span>
                                            </button>
                                            <button type="button" @click.prevent="destroy(sparepart.id)" class="btn btn-outline-danger">
                                                <span class="icon-sm mdi mdi-delete"></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="dropdown-divider"></div>
                        </div>
                        <div class="col-md-6 mx-auto">
                            <div class="row mt-4">
                                <button type="button" class="btn btn-lg btn-block btn-outline-primary">
                                    <i class="mdi mdi-cloud-download"></i> 
                                    Export Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ editMode ? 'Edit Sparepart' : 'Add Sparepart' }}</h4>
                        <div class="dropdown-divider my-4"></div>
                        <form autocomplete="off">
                            <div class="form-group mb-4">
                                <label for="sparepart_type">Sparepart Type</label>
                                <select v-model="form.sparepart_type" id="sparepart_type" class="form-control text-white">
                                    <option value="Camera"> Camera </option>
                                    <option value="Phone"> Phone </option>
                                    <option value="Laptop-PC"> Laptop-PC </option>
                                    <option value="Other"> Other </option>
                                </select>
                                <small class="text-danger" v-if="errors.sparepart_type">{{ errors.sparepart_type[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="sparepart_name">Sparepart Name</label>
                                <input type="text" v-model="form.sparepart_name" class="form-control" id="sparepart_name" placeholder="Enter name">
                                <small class="text-danger" v-if="errors.sparepart_name">{{ errors.sparepart_name[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="sparepart_quantity">Stock</label>
                                <input type="number" v-model="form.sparepart_quantity" class="form-control" id="sparepart_quantity" placeholder="Enter stock">
                                <small class="text-danger" v-if="errors.sparepart_quantity">{{ errors.sparepart_quantity[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="sparepart_price">Price Per Item</label>
                                <input type="number" v-model="form.sparepart_price" class="form-control" id="sparepart_price" placeholder="Enter price">
                                <small class="text-danger" v-if="errors.sparepart_price">{{ errors.sparepart_price[0] }}</small>
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
                sparepart_type: null,
                sparepart_name: null,
                sparepart_quantity: null,
                sparepart_price: null,
            },
        }
    },
    setup () {
        function destroy(id) {
            if(confirm('Are you sure you want to delete this sparepart?')) {
                Inertia.delete(`/sparepart/`+ id +`/delete`)
            }
        }
        return {
            destroy
        }
    },
    methods: {
        store(data) {
            Inertia.post('/sparepart', data)
            this.reset()
            this.editMode = false
        },
        edit (data) {
            this.form = Object.assign({}, data)
            this.editMode = true
        },
        update (data) {
            Inertia.put(`/sparepart/`+ data.id, data)
            this.reset()
            this.editMode = false
        },
        reset () {
            this.form = {
                sparepart_type: null,
                sparepart_name: null,
                sparepart_quantity: null,
                sparepart_price: null,
            }
            this.editMode = false
        }
    },
    props: {
        spareparts: Object,
        errors: Object,
    },
};
</script>
