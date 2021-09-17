<template>
    <Head>
        <title>{{ pageTitle() }}</title>
        <meta head-key="description" type="description" :content="pageDescription()" />
        <meta head-key="twitter:title" name="twitter:title" :content="pageTitle()" />
        <meta head-key="twitter:description" name="twitter:description" :content="pageDescription()" />
        <meta head-key="twitter:card" name="twitter:card" content="summary_large_image" />
        <meta head-key="og:url" property="og:url" :content="url" />
        <meta head-key="og:title" property="og:title" :content="pageTitle()" />
        <meta head-key="og:description" property="og:description" :content="pageDescription()" />
        <meta head-key="og:type" property="og:type" content="website" />
        <meta head-key="og:image" property="og:image" :content="this.$page.props.meta.ogImage" />
    </Head>
</template>
<script>
import { Head } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Head,
    },
    props: {
        title: {
            type: String,
            required: false,
        },
        description: {
            type: String,
            required: false,
        },
        url: {
            type: String,
            required: true,
        },
    },
    methods: {
        pageTitle() {
            let title = this.title ? this.title + " - " : "";
            return title + this.$page.props.meta.title;
        },
        pageDescription() {
            let description = this.description ? this.description : this.$page.props.meta.description;
            return description;
        },
    },
};
</script>
