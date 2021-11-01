<template>
  <Layout>
    <Head title="Administration" />
    <div class="row">
            <div class="col-sm-4 grid-margin">
                <Link href="/invoices" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">Cash In</h2>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">Menu</p>
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Company cash in page
                                </h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-arrow-bottom-left text-success ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
            <div class="col-sm-4 grid-margin">
                <Link href="/sparepart" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">Cash Out</h2>
                                    <p class="text-danger ml-2 mb-0 font-weight-medium">
                                        Menu
                                    </p>
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Company cash out page
                                </h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-arrow-top-right text-danger ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
            <div class="col-sm-4 grid-margin">
                <Link href="/equipment" as="div" class="card" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">Report</h2>
                                    <p class="text-primary ml-2 mb-0 font-weight-medium">
                                        Menu
                                    </p>
                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    Company report page
                                </h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-chart-line text-primary ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </Layout>
</template>

<script>
  import Layout from '../Shared/Layout'
  import { Head, Link } from '@inertiajs/inertia-vue3'

  export default {
    components: {
      Head,
      Link,
      Layout,
    },
    props: {
      user: Object,
    },
  }
</script>