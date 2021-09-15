<template>
    <div class="modal fade messageModal" :id="modalId" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="acurisModalLabel" v-if="modalTitle">{{ modalTitle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="acurisResults">
                        <div v-if="modalMessage" class="alert alert-danger">{{ modalMessage }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from "bootstrap";
import AppButton from "@/Shared/AppButton";
import common from "@/common-functions.js";

export default {
    mounted() {
        this.modal = new Modal(document.getElementById(this.modalId));
    },
    components: {
        AppButton,
    },
    props: {
        modalId: {
            type: String,
            required: true,
        },
        modalTitle: {
            type: String,
            required: true,
        },
        modalMessage: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            modal: null,
        };
    },
    methods: {
        showModal() {
            this.modal.show();
        },
    },
};
</script>
<style lang="scss" scoped></style>
