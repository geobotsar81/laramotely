<template>
    <div>
        <app-preloader v-if="loading"></app-preloader>
        <app-mobile-menu @close-mobile-menu="closeMenu" :menuClass="showMobileMenu ? 'is-active' : ''"></app-mobile-menu>
        <the-header @toggle-mobile-menu="burgerIsClicked" :headerIsActive="showMobileMenu"></the-header>
        <slot />
        <the-footer></the-footer>
    </div>
</template>

<script>
import AppPreloader from "@/Shared/AppPreloader";
import TheHeader from "@/Shared/TheHeader";
import TheFooter from "@/Shared/TheFooter";
import AppMobileMenu from "@/Shared/AppMobileMenu";

export default {
    components: {
        TheHeader,
        TheFooter,
        AppPreloader,
        AppMobileMenu,
    },
    mounted() {
        this.loading = false;
    },
    data() {
        return {
            loading: true,
            showMobileMenu: false,
        };
    },
    methods: {
        burgerIsClicked(menuIsOpen) {
            this.showMobileMenu = menuIsOpen;
        },
        closeMenu() {
            this.showMobileMenu = false;
        },
    },
};
</script>
