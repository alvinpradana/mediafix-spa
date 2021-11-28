<template>
    <Head title="Cash Out" />
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="row justify-content-between align-items-center mb-4">
                <div class="col-md-4">
                    <h3 class="card-title">Cash Out</h3>
                </div>
                <div class="col-md-6">
                    <input v-model="search" type="text" class="form-control rounded-lg text-secondary" placeholder="Search"/>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
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
                                <tr v-if="cash_out.data.length === 0">
                                    <td colspan="7" class="text-center py-4">
                                        No data available in our record !
                                    </td>
                                </tr>
                                <tr v-for="cash in cash_out.data" :key="cash.id">
                                    <td>{{ cash.cash_date }}</td>
                                    <td class="text-capitalize">{{ cash.cash_description }}</td>
                                    <td>Rp. {{ cash.cash_amount }}</td>
                                    <td class="text-center">
                                        <button type="button" @click.prevent="edit(cash)" class="btn btn-primary mr-1">
                                            <span class="icon-sm mdi mdi-pencil"></span>
                                        </button>
                                        <button type="button" @click.prevent="destroy(cash.id)" class="btn btn-danger">
                                            <span class="icon-sm mdi mdi-delete"></span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="dropdown-divider"></div>
                    </div>
                    <div class="row justify-content-center px-4">
                        <pagination class="mt-3" :links="cash_out.links" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div v-show="!showImport" class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Total</h4>
                        <h4 class="card-title">Rp. {{ total_amount }}</h4>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mt-3">
                            <a :href="route('cash.export')" type="button" class="btn btn-lg btn-block btn-primary">
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
                    <h4 class="card-title">{{ editMode ? 'Edit Cash' : 'Add Cash' }}</h4>
                    <div class="dropdown-divider my-4"></div>
                    <form autocomplete="off">
                        <div class="form-group mb-4">
                            <label for="cash_description">Description</label>
                            <textarea rows="4" v-model="form.cash_description" class="form-control" :class="{'is-invalid': errors.cash_description}" id="cash_description" placeholder="Cash description"></textarea>
                            <small class="invalid-feedback" v-if="errors.cash_description">{{ errors.cash_description[0] }}</small>
                        </div>
                        <div class="form-group mb-4">
                            <label for="cash_date">Date</label>
                            <input type="text" v-model="form.cash_date" class="form-control" :class="{'is-invalid': errors.cash_date}" id="cash_date" placeholder="Cash date" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                            <small class="invalid-feedback" v-if="errors.cash_date">{{ errors.cash_date[0] }}</small>
                        </div>
                        <div class="form-group mb-4">
                            <label for="cash_amount">Amount</label>
                            <input type="number" v-model="form.cash_amount" class="form-control" :class="{'is-invalid': errors.cash_amount}" id="cash_amount" placeholder="Cash amount">
                            <small class="invalid-feedback" v-if="errors.cash_amount">{{ errors.cash_amount[0] }}</small>
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

export default {
    layout: Layout,

    components: {
        Link,
        Head,
        Pagination,
    },
    data (props) {
        let search = ref(props.filters.search)

        watch (search, value => {
            Inertia.get('/dashboard/cash', { search: value }, {
                preserveState: true,
                replace: true
            })
        })

        return {
            search,
            showImport: false,
            editMode: false,
            form: {
                user_id: this.user,
                cash_description: null,
                cash_date: null,
                cash_amount: null,
            },
            formFile: {
                file: null
            }
        }
    },
    setup () {
        function destroy(id) {
            if(confirm('Are you sure you want to delete this cash?')) {
                Inertia.delete(route('cash.destroy', {cash: id}))
            }
        }
        return {
            destroy
        }
    },
    methods: {
        upload () {
            Inertia.post(route('cash.import'), this.formFile, {
                onSuccess: () => this.reset()
            })
        },
        store(data) {
            Inertia.post(route('cash.store'), data, {
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
            Inertia.put(route('cash.update', {cash: data.id}), data, {
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
            this.$refs.fileUpload.value = null
        },
        reset () {
            this.form = {
                user_id: this.user,
                cash_description: null,
                cash_date: null,
                cash_amount: null,
            }
            this.formFile = {
                file: null
            }
            this.showImport = false
            this.editMode = false
            this.$refs.fileUpload.value = null
        }
    },
    props: {
        cash_out: Object,
        total_amount: Object,
        errors: Object,
        user: Object,
        filters: Object
    },
};
</script>
