<template>
    <Layout>
        <Head title="Sparepart" />
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-5 col-md-9">
                                <h4>List Sparepart</h4>
                            </div>
                            <div class="col-sm-5 col-md-3 text-lg-right">
                                <div class="dropdown mx-auto">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Category </button>
                                    <div class="dropdown-menu">
                                        <div class="col">
                                            <div class="form-check form-check-primary">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" value="Camera">Camera</label>
                                            </div>
                                            <div class="dropdown-divider"></div>
                                            <div class="form-check form-check-primary">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" value="Phone">Phone</label>
                                            </div>
                                            <div class="dropdown-divider"></div>
                                            <div class="form-check form-check-primary">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" value="Laptop-PC">Laptop-PC</label>
                                            </div>
                                            <div class="dropdown-divider"></div>
                                            <div class="form-check form-check-primary">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" value="Other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    <tr v-if="spareparts.data.length === 0">
                                        <td colspan="5" class="text-center py-4">
                                            No data available in our record !
                                        </td>
                                    </tr>
                                    <tr v-for="sparepart in spareparts.data" :key="sparepart.id">
                                        <td>{{ sparepart.sparepart_type }}</td>
                                        <td>{{ sparepart.sparepart_name }}</td>
                                        <td>{{ sparepart.sparepart_quantity }}</td>
                                        <td>Rp. {{ sparepart.sparepart_price }}</td>
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
                        <div class="row justify-content-center px-4">
                            <pagination class="mt-3" :links="spareparts.links" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div v-show="!showImport" class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Stock</h4>
                            <h4 class="card-title">{{ count }} <small class="text-sm text-success">item</small></h4>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mt-3">
                                <a :href="route('sparepart.export')" type="button" class="btn btn-lg btn-block btn-outline-primary">
                                    Export
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-12 mt-3">
                                <button @click.prevent="showImportFile()" type="button" class="btn btn-lg btn-block btn-outline-warning">
                                    Import
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4" v-show="showImport">
                    <div class="card-body">
                        <form @submit.prevent="upload" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="mb-1 px-2 py-2 text-sm border rounded">
                                        <input type="file" @input="formFile.file = $event.target.files[0]">
                                    </div>
                                    <small class="text-danger" v-if="errors.file">{{ errors.file[0] }}</small>
                                </div>
                            </div>
                            <div class="row justify-content-between mt-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-lg btn-block btn-outline-success mb-2">Submit</button>
                                </div>
                                <div class="col-md-6">
                                    <button @click.prevent="cancelImport()" class="btn btn-lg btn-block btn-outline-danger">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
import Pagination from "../Shared/Pagination"

export default {
    components: {
        Link,
        Head,
        Layout,
        Pagination,
    },
    data () {
        return {
            showImport: false,
            editMode: false,
            form: {
                sparepart_type: null,
                sparepart_name: null,
                sparepart_quantity: null,
                sparepart_price: null,
            },
            formFile: {
                file: null
            }
        }
    },
    setup () {
        function destroy(id) {
            if(confirm('Are you sure you want to delete this sparepart?')) {
                Inertia.delete(route('sparepart.destroy', {sparepart: id}))
            }
        }
        return {
            destroy
        }
    },
    methods: {
        upload () {
            Inertia.post(route('sparepart.import'), this.formFile, {
                onSuccess: () => this.reset()
            })
        },
        store(data) {
            Inertia.post(route('sparepart.store'), data, {
                onSuccess: () => this.reset()
            }, {
                onError: () => this.editMode = true
            })
        },
        edit (data) {
            this.form = Object.assign({}, data)
            this.editMode = true
        },
        update (data) {
            Inertia.put(route('sparepart.update', {sparepart: data.id}), data, {
                onSuccess: () => this.reset()
            }, {
                onError: () => this.editMode = true
            })
        },
        showImportFile () {
            this.showImport = true
        },
        cancelImport () {
            this.showImport = false
        },
        reset () {
            this.form = {
                sparepart_type: null,
                sparepart_name: null,
                sparepart_quantity: null,
                sparepart_price: null,
            }
            this.formFile = {
                file: null
            }
            this.showImport = false
            this.editMode = false
        }
    },
    props: {
        spareparts: Object,
        count: Object,
        errors: Object,
    },
};
</script>
