<template>
  <Layout>
    <Head title="Reports" />
    <H1>Reports</H1>
    <p>Hello , welcome to your first Inertia app!</p>
  </Layout>
</template>

<script>
  import Layout from '../Shared/Layout'
  import { Head } from '@inertiajs/inertia-vue3'

  export default {
    components: {
      Head,
      Layout,
    },
    props: {
      user: Object,
    },
  }
</script>