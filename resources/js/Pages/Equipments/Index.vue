<template>
    <Head title="Equipment" />
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="row justify-content-between align-items-center mb-4">
                <div class="col-md-4">
                    <h3>List Equipment</h3>
                </div>
                <div class="col-md-4">
                    <input v-model="search" type="text" class="form-control rounded-lg text-secondary" placeholder="Search"/>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
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
                                <tr v-if="equipments.data.length === 0">
                                    <td colspan="5" class="text-center py-4">
                                        No data available in our record !
                                    </td>
                                </tr>
                                <tr v-for="equipment in equipments.data" :key="equipment.id">
                                    <td>{{ equipment.equipment_type }}</td>
                                    <td class="text-capitalize">{{ equipment.equipment_name }}</td>
                                    <td>{{ equipment.equipment_quantity }}</td>
                                    <td>{{ equipment.equipment_condition }}</td>
                                    <td class="text-center">
                                        <button type="button" @click.prevent="edit(equipment)" class="btn btn-primary mr-1">
                                            <span class="icon-sm mdi mdi-pencil"></span>
                                        </button>
                                        <button type="button" @click.prevent="destroy(equipment.id)" class="btn btn-danger">
                                            <span class="icon-sm mdi mdi-delete"></span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="dropdown-divider"></div>
                    </div>
                    <div class="row justify-content-center px-4">
                        <pagination class="mt-3" :links="equipments.links" />
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
                            <a :href="route('equipment.export')" type="button" class="btn btn-lg btn-block btn-primary">
                                Export
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-3">
                            <button @click.prevent="showImportFile()" type="button" class="btn btn-lg btn-block btn-warning">
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
                                    <input type="file" ref="fileUpload" @input="formFile.file = $event.target.files[0]" class="form-control" :class="{'is-invalid': errors.file}">
                                    <small class="invalid-feedback" v-if="errors.file">{{ errors.file[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-lg btn-block btn-success mb-2">Submit</button>
                            </div>
                            <div class="col-md-6">
                                <button @click.prevent="cancelImport()" class="btn btn-lg btn-block btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ editMode ? 'Edit Equipment' : 'Add Equipment' }}</h4>
                    <div class="dropdown-divider my-4"></div>
                    <form autocomplete="off">
                        <div class="form-group mb-4">
                            <label for="equipment_type">Equipment Type</label>
                            <select v-model="form.equipment_type" id="equipment_type" class="form-control text-white" :class="{'is-invalid': errors.equipment_type}">
                                <option value="Office"> Office </option>
                                <option value="Service"> Service </option>
                            </select>
                            <small class="invalid-feedback" v-if="errors.equipment_type">{{ errors.equipment_type[0] }}</small>
                        </div>
                        <div class="form-group mb-4">
                            <label for="equipment_name">Equipment Name</label>
                            <input type="text" v-model="form.equipment_name" class="form-control" id="equipment_name" :class="{'is-invalid': errors.equipment_name}" placeholder="Enter name">
                            <small class="invalid-feedback" v-if="errors.equipment_name">{{ errors.equipment_name[0] }}</small>
                        </div>
                        <div class="form-group mb-4">
                            <label for="equipment_quantity">Stock</label>
                            <input type="number" v-model="form.equipment_quantity" class="form-control" id="equipment_quantity" :class="{'is-invalid': errors.equipment_quantity}" placeholder="Enter stock">
                            <small class="invalid-feedback" v-if="errors.equipment_quantity">{{ errors.equipment_quantity[0] }}</small>
                        </div>
                        <div class="form-group mb-4">
                            <label for="equipment_condition">Condition</label>
                            <textarea rows="4" v-model="form.equipment_condition" class="form-control" id="equipment_condition" :class="{'is-invalid': errors.equipment_condition}" placeholder="Equipment condition"></textarea>
                            <small class="invalid-feedback" v-if="errors.equipment_condition">{{ errors.equipment_condition[0] }}</small>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div v-show="!editMode" class="col-md-8 mx-auto mt-2">
                                <button @click.prevent="store(form)" type="button" class="btn btn-lg btn-block btn-success mx-auto">Save</button>
                            </div>
                            <div v-show="editMode" class="col-md-6 mx-auto mt-2">
                                <button @click="update(form)" type="button" class="btn btn-lg btn-block btn-success mx-auto">Update</button>
                            </div>
                            <div v-show="editMode" class="col-md-6 mx-auto mt-2">
                                <button @click.prevent="reset()" type="button" class="btn btn-lg btn-block btn-danger mx-auto">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from "../Shared/Layout";
import { Link, Head } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia';
import Pagination from "../Shared/Pagination"
import { ref } from '@vue/reactivity';
import { watch } from '@vue/runtime-core';
import debounce from "lodash/debounce";

export default {
    layout: Layout,

    components: {
        Link,
        Head,
        Pagination,
    },
    data (props) {
        let search = ref(props.filters.search)

        watch (search, debounce (function (value) {
            Inertia.get('/equipment', { search: value }, {
                preserveState: true,
                replace: true
            })
        }, 300))

        return {
            search,
            showImport: false,
            editMode: false,
            form: {
                user_id: this.user,
                equipment_type: null,
                equipment_name: null,
                equipment_quantity: null,
                equipment_condition: null,
            },
            formFile: {
                file: null
            }
        }
    },
    setup () {
        function destroy(id) {
            if(confirm('Are you sure you want to delete this equipment?')) {
                Inertia.delete(route('equipment.destroy', {equipment: id}))
            }
        }
        return {
            destroy
        }
    },
    methods: {
        upload () {
            Inertia.post(route('equipment.import'), this.formFile, {
                onSuccess: () => this.reset()
            })
        },
        store(data) {
            Inertia.post(route('equipment.store'), data, {
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
            Inertia.put(route('equipment.update', {equipment: data.id}), data, {
                onSuccess: () => this.reset()
            }, {
                onError: () => this.editMode = true
            })
            this.clearErrors()
        },
        showImportFile () {
            this.showImport = true
        },
        cancelImport () {
            this.showImport = false
            this.$refs.fileUpload.value = null
        },
        reset () {
            this.form = {
                user_id: this.user,
                equipment_type: null,
                equipment_name: null,
                equipment_quantity: null,
                equipment_condition: null,
            }
            this.$refs.fileUpload.value = null
            this.showImport = false
            this.editMode = false
        }
    },
    props: {
        equipments: Object,
        count: Object,
        errors: Object,
        user: Object,
        filters: Object
    }
};
</script>
