<template>
    <app-modal ref="appMessageModal" modalId="appMessageModal" :modalTitle="modalTitle" :modalMessage="modalMessage"></app-modal>
    <the-side-menu></the-side-menu>
    <div class="suiteContainer" :class="$store.state.menuIsOpen ? '' : 'expanded'">
        <slot />
    </div>
</template>

<script>
import TheSideMenu from "@/Shared/TheSideMenu";
import AppModal from "@/Shared/AppModal";

export default {
    created() {
        //Dispatch permissions check after logging in every 3 hours
        //let duration = 15 * 1000;
        let duration = 3 * 60 * 60 * 1000;
        this.$store.dispatch("getPermissionsFromDB", { props: this.$page.props });
        this.checkingPermissions = setInterval(() => {
            this.$store.dispatch("getPermissionsFromSSO", { props: this.$page.props });
        }, duration);

        //Watch for the message modal change in order to display it
        this.$store.watch(
            (state) => {
                return this.$store.state.messageModalMessage; // could also put a Getter here
            },
            (newValue, oldValue) => {
                this.modalTitle = this.$store.state.messageModalTitle;
                this.modalMessage = this.$store.state.messageModalMessage;
                this.$refs.appMessageModal.showModal();
            }
        );
    },
    beforeDestroy() {
        clearInterval(this.checkingPermissions);
    },
    errorCaptured(err, vm, info) {
        //Capture any errors and display them using the message modal
        let payload = { title: this.$page.props.translations.generic.errorMessageTitle, message: err.toString() };
        this.$store.commit("setMessageModal", payload);

        return true;
    },
    data() {
        return {
            checkingPermissions: null,
            modalTitle: "",
            modalMessage: "",
        };
    },

    components: {
        TheSideMenu,
        AppModal,
    },
    methods: {},
};
</script>
