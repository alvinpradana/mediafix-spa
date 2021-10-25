<template>
    <Layout>
        <Head title="Homepage" />
        <div class="row">
            <div class="col-sm-4 grid-margin">
                <Link href="/invoices" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <h5>ORDER</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">32123</h2>
                                    <p class="text-primary ml-2 mb-0 font-weight-medium">Order</p>
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Added 12 unit today
                                </h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-deskphone text-primary ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
            <div class="col-sm-4 grid-margin">
                <Link href="/employees" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <h5>SPAREPART</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">45850</h2>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">
                                        Stock
                                    </p>
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Devices sparepart stock
                                </h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-monitor-multiple text-success ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
            <div class="col-sm-4 grid-margin">
                <Link href="/employees" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <h5>EQUIPMENT</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">2039</h2>
                                    <p class="text-danger ml-2 mb-0 font-weight-medium">
                                        Stock
                                    </p>
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Company equipment stock
                                </h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </Layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Layout from "./Shared/Layout";

export default {
    components: {
        Link,
        Head,
        Layout,
    },
    props: {

    },
};
</script>
