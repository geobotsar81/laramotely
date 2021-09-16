<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container-fluid"></div>
    </the-main>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import TheHead from "@/Shared/TheHead";
import TheMain from "@/Shared/TheMain";

export default {
    components: {
        AppLayout,
        TheHead,
        TheMain,
    },
    layout: AppLayout,
};
</script>
<style lang="scss" scoped></style>
