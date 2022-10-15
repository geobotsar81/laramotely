<template>
    <div class="mobileMenu" :class="menuClass">
        <div class="mobileMenu__overlay"></div>

        <div class="mobileMenu__content"></div>
        <ul class="mobileMenu__primary">
            <li><inertia-link @click="closeMobileMenu" :href="route('news.show')">News</inertia-link></li>
            <li><inertia-link @click="closeMobileMenu" :href="route('contact.show')">Contact</inertia-link></li>
            <li><inertia-link @click="closeMobileMenu" :href="route('job.post')">Post a Free Job</inertia-link></li>
        </ul>
    </div>
</template>
<script>
import AppButton from "@/Shared/AppButton";
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppButton,
        InertiaLink,
    },
    data() {
        return {
            menu: this.$page.props.menus.main["items"],
        };
    },
    props: {
        menuClass: String,
    },
    emits: ["closeMobileMenu"],
    methods: {
        closeMobileMenu() {
            this.$emit("closeMobileMenu");
        },
    },
};
</script>
<style lang="scss" scoped>
.mobileMenu {
    position: fixed;
    z-index: $zindexMobileMenu;
    text-align: left;
    padding: 140px 30px;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    opacity: 1;

    .mobileMenu__overlay {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        background-color: $appBlack;
        opacity: 1;
        transform: scaleY(0);
        transform-origin: 0 0;
        transition-delay: 0.4s;
        transition: all 0.6s ease-out;
    }
    .mobileMenu__content {
        transform: scale(1.15) translateY(-30px);
        opacity: 0;
        transition: transform 0.5s $cubic, opacity 0.6s $cubic;
        position: relative;
    }

    :deep(.button) {
        display: inline-block !important;
        padding: 5px;
    }

    ul.mobileMenu__primary {
        margin-bottom: 0px;
        width: 100%;
        padding: 0px;

        li {
            list-style: none;
            display: block;
            padding: 10px 0px;
            transform: scale(1.15) translateY(-30px);
            opacity: 0;
            text-align: center;
            transition: transform 0.5s $cubic, opacity 0.6s $cubic;

            @for $i from 1 through $menuItems {
                &:nth-child(#{$i}) {
                    transition-delay: #{0.06 - ($i * 0.07)}s;
                }
            }

            &:last-child {
                border-bottom: 0px;
            }

            a {
                color: #fff;
                font-size: 24px;
                line-height: 46px;
                font-weight: 400;
                text-decoration: none;
                transition: $appTransition;
                display: block;
                width: 100%;

                &:hover,
                &:focus,
                &.active {
                    color: $appBlack2;
                }
            }

            .dropdown-toggle {
                position: relative;
                &:after {
                    content: "\f078";
                    font-family: "Font Awesome 5 Pro";
                    border: 0px;
                    position: absolute;
                    right: 0px;
                    top: 5px;
                    font-size: 14px;
                }

                &:hover,
                &:focus,
                &.active {
                    color: $appLightBlue;
                }
            }

            .dropdown-toggle[aria-expanded="true"] {
                &:after {
                    content: "\f077";
                }
            }
            .mobileMenu__submenu {
                padding: 0px;
                li {
                    list-style: none;
                    display: block;
                    border-bottom: 0px;
                    padding: 10px 0px;

                    a {
                        font-size: 16px;
                        line-height: 18px;
                    }
                }
            }
        }
    }
}

.mobileMenu.is-active {
    opacity: 1;
    pointer-events: all;
    .mobileMenu__overlay {
        opacity: 1;
        pointer-events: all;
        transform: scaleY(1);
        transition-delay: 1s;
        transition: all 0.6s;
    }
    .mobileMenu__content {
        transform: scale(1) translateY(0px);
        opacity: 1;
        transition-delay: #{0.07}s;
    }
    ul.mobileMenu__primary {
        li {
            transform: scale(1) translateY(0px);
            opacity: 1;
            @for $i from 1 through $menuItems {
                &:nth-child(#{$i}) {
                    transition-delay: #{0.07 * $i + 0.2}s;
                }
            }
        }
    }
}

@media (max-width: 575.98px) {
    .mobileMenu {
        padding: 100px 30px;
    }
}
</style>
