<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="centered underlined">Get in touch</h1>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">Have a new source of remote laravel jobs, want to post a new job or any other questions? Send us an email!</div>
            </div>

            <div class="row mt-5">
                <div class="col-12 col-lg-8 offset-lg-2 text-center">
                    <form name="contacForm" @submit.prevent="submitForm">
                        <input type="hidden" name="honeypot" v-model="form.honeypot" />
                        <div v-if="form.errors.honeypot" class="formError">
                            {{ form.errors.honeypot }}
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <input placeholder="Name" name="contactName" type="text" class="form-control" v-model="form.contactName" />
                                <div v-if="form.errors.contactName" class="formError">
                                    {{ form.errors.contactName }}
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <input placeholder="Email" name="contactEmail" type="text" class="form-control" v-model="form.contactEmail" />
                                <div v-if="form.errors.contactEmail" class="formError">
                                    {{ form.errors.contactEmail }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea placeholder="Message" class="form-control" name="contactMessage" v-model="form.contactMessage"></textarea>
                                <div v-if="form.errors.contactMessage" class="formError">
                                    {{ form.errors.contactMessage }}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <app-button type="submit" class="buttonRed" v-if="!form.processing"> SEND </app-button>
                                <img src="img/LoaderIcon.gif" v-if="form.processing" />
                            </div>
                        </div>
                        <div class="row mt-4" v-if="formSuccess">
                            <div class="col-sm-12">
                                <div class="alert alert-success">Your message has been successfully sent!</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </the-main>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import TheHead from "@/Shared/TheHead";
import TheMain from "@/Shared/TheMain";
import AppButton from "@/Shared/AppButton";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    setup() {
        const form = useForm({
            contactName: null,
            contactEmail: null,
            contactMessage: null,
            honeypot: null,
        });

        return { form };
    },
    components: {
        AppLayout,
        TheHead,
        TheMain,
        AppButton,
    },
    layout: AppLayout,
    data() {
        return {
            animate: false,
            storageUrl: this.$page.props.storageUrl + "/",
            formSuccess: false,
        };
    },
    methods: {
        submitForm() {
            this.formSuccess = false;
            this.form.submit("post", "/contact", {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset("contactName");
                    this.form.reset("contactEmail");
                    this.form.reset("contactMessage");
                    this.formSuccess = true;
                },
            });
        },
    },
    props: {
        page: Object,
    },
    computed: {
        metaTitle: function () {
            return this.$page.props.meta.title + " - " + this.page.title;
        },
    },
};
</script>
<style lang="scss" scoped>
.header {
    background-color: $appBlack;
}
.main {
    margin-top: 80px;
    padding: 60px 0px;
    background-color: #ffffff;
    color: $appBlack;
    font-size: 16px;
}

label {
    font-weight: 700;
    color: $appGreyDark;
    padding-bottom: 10px;
}
.form-control {
    border-radius: 0px;
    border: solid 1px #f7f7f7;
    padding: 12px 25px;
    transition: all 0.6s;
    background-color: #f7f7f7;

    &:hover,
    &:focus {
        box-shadow: none;
        outline: none;
        border-color: $appBlue;
    }
}

.alert-success {
    background-color: transparent;
    border: 0px;
}
textarea {
    height: 400px;
    padding-top: 20px !important;
}

.formError {
    font-size: 14px;
    color: $appRed;
    padding-top: 5px;
    text-align: left;
}

.buttonMain {
    padding: 10px 50px;
    background-color: $appBlue;
    color: #ffffff;
    font-size: 14px;
    font-weight: 400;
    border: solid 2px $appBlue;
    outline: none;
    border-radius: 25px;
    display: inline-block;
    transition: all $appTransitionDuration;
    &:hover,
    &:focus {
        background-color: #fff;
        color: $appBlue;
        outline: none;
    }
}
</style>
