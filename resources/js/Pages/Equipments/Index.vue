<template>
    <Layout>
        <Head title="Equipment" />
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Equipment</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Equipment Type</th>
                                        <th>Equipment Name</th>
                                        <th>Stock</th>
                                        <th>Condition</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="equipments.length === 0">
                                        <td colspan="5" class="text-center py-4">
                                            No data available in our record !
                                        </td>
                                    </tr>
                                    <tr v-for="equipment in equipments" :key="equipment.id">
                                        <td>{{ equipment.equipment_type }}</td>
                                        <td>{{ equipment.equipment_name }}</td>
                                        <td>{{ equipment.equipment_quantity }}</td>
                                        <td>{{ equipment.equipment_condition }}</td>
                                        <td class="text-center">
                                            <button type="button" @click.prevent="edit(equipment)" class="btn btn-outline-primary mr-1">
                                                <span class="icon-sm mdi mdi-pencil"></span>
                                            </button>
                                            <button type="button" @click.prevent="destroy(equipment.id)" class="btn btn-outline-danger">
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
                            <h4 class="card-title">Stock</h4>
                            <h4 class="card-title">{{ count }} <small class="text-sm text-success">item</small></h4>
                        </div>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ editMode ? 'Edit Equipment' : 'Add Equipment' }}</h4>
                        <div class="dropdown-divider my-4"></div>
                        <form autocomplete="off">
                            <div class="form-group mb-4">
                                <label for="equipment_type">Equipment Type</label>
                                <select v-model="form.equipment_type" id="equipment_type" class="form-control text-white">
                                    <option value="Office"> Office </option>
                                    <option value="Service"> Service </option>
                                </select>
                                <small class="text-danger" v-if="errors.equipment_type">{{ errors.equipment_type[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="equipment_name">Equipment Name</label>
                                <input type="text" v-model="form.equipment_name" class="form-control" id="equipment_name" placeholder="Enter name">
                                <small class="text-danger" v-if="errors.equipment_name">{{ errors.equipment_name[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="equipment_quantity">Stock</label>
                                <input type="number" v-model="form.equipment_quantity" class="form-control" id="equipment_quantity" placeholder="Enter stock">
                                <small class="text-danger" v-if="errors.equipment_quantity">{{ errors.equipment_quantity[0] }}</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="equipment_condition">Condition</label>
                                <textarea rows="4" v-model="form.equipment_condition" class="form-control" id="equipment_condition" placeholder="Equipment condition"></textarea>
                                <small class="text-danger" v-if="errors.equipment_condition">{{ errors.equipment_condition[0] }}</small>
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
                equipment_type: null,
                equipment_name: null,
                equipment_quantity: null,
                equipment_condition: null,
            },
        }
    },
    setup () {
        function destroy(id) {
            if(confirm('Are you sure you want to delete this equipment?')) {
                Inertia.delete(`/equipment/`+ id +`/delete`)
            }
        }
        return {
            destroy
        }
    },
    methods: {
        store(data) {
            Inertia.post('/equipment', data, {
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
            Inertia.put(`/equipment/`+ data.id, data, {
                onSuccess: () => this.reset()
            }, {
                onError: () => this.editMode = true
            })
            this.clearErrors()
        },
        reset () {
            this.form = {
                equipment_type: null,
                equipment_name: null,
                equipment_quantity: null,
                equipment_condition: null,
            }
            this.editMode = false
        }
    },
    props: {
        equipments: Object,
        count: Object,
        errors: Object,
    },
};
</script>
