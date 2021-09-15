<template>
    <div class="sideMenu" :class="$store.state.menuIsOpen ? '' : 'minimised'">
        <div class="sideMenu__button" @click="toggleMenu"><i class="fas fa-caret-square-left"></i></div>
        <div class="container">
            <div class="row">
                <div class="col-12 sideMenu__logo">
                    <big
                        ><inertia-link :href="route('dashboard')"><app-logo></app-logo></inertia-link
                    ></big>
                    <small>
                        <inertia-link :href="route('dashboard')"><app-logo-small></app-logo-small></inertia-link
                    ></small>
                </div>
            </div>

            <div class="row">
                <div class="col-12 sideMenu__user">
                    <a href="#" class="toggleUser" @click="toggleUserSubmenu">
                        <img v-if="$page.props.user.profile_photo_url" :src="$page.props.user.profile_photo_url" />
                        <span>{{ $page.props.user.name }}</span>
                    </a>
                    <ul class="sideMenu__user__submenu" :class="showUserSubmenu ? 'active' : ''">
                        <li>
                            <inertia-link :href="route('profile.show')"><i class="fal fa-user"></i> <span>Account</span></inertia-link>
                        </li>
                        <li>
                            <a href="#" @click="logout"><i class="far fa-power-off"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12 sideMenu__menu">
                    <ul>
                        <li>
                            <a v-if="$page.props.user.role_id == 1" href="admin" target="_blank"><i class="fal fa-user"></i> <span>Admin Backend</span></a>
                        </li>
                        <li>
                            <a href="#" @click="toggleToolsSubmenu"><i class="fal fa-tools"></i><span>Tools</span></a>

                            <ul class="sub-menu" :class="showToolsSubmenu ? 'active' : ''">
                                <li :class="$store.state.hasRbaTool ? '' : 'inactive'">
                                    <inertia-link :href="route('rba.show')"><i class="fal fa-tachometer-alt"></i> <span>Risk Based Approach</span></inertia-link>
                                </li>
                                <li :class="$store.state.hasAmlTool ? '' : 'inactive'">
                                    <inertia-link :href="route('aml.show')"><i class="fal fa-search"></i> <span>AML Search</span></inertia-link>
                                </li>
                                <li :class="$store.state.hasMrzTool ? '' : 'inactive'">
                                    <inertia-link :href="route('mrz.show')"><i class="fal fa-passport"></i> <span>MRZ Check</span></inertia-link>
                                </li>
                                <li :class="$store.state.hasKycTool ? '' : 'inactive'">
                                    <inertia-link href="#"><i class="fal fa-id-card"></i> <span>ID/Passport Verification</span></inertia-link>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <inertia-link :href="route('contact.show')"><i class="fal fa-headset"></i><span>Get Help</span></inertia-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import AppLogo from "@/Shared/AppLogo";
import AppLogoSmall from "@/Shared/AppLogoSmall";
import common from "@/common-functions.js";

export default {
    components: {
        AppLogo,
        AppLogoSmall,
    },
    data() {
        return {
            showUserSubmenu: false,
            showToolsSubmenu: false,
            amlMenuItems: this.$page.props.menus.amlsuite["items"],
        };
    },
    props: {},
    methods: {
        storageUrl: common.storageUrl,
        logout() {
            this.$inertia.post(route("logout"));
        },
        toggleUserSubmenu() {
            this.showUserSubmenu = !this.showUserSubmenu;
        },
        toggleToolsSubmenu() {
            this.showToolsSubmenu = !this.showToolsSubmenu;
        },
        toggleMenu() {
            this.$store.commit("toggleMenu");
        },
    },
};
</script>
<style lang="scss" scoped>
.sideMenu {
    width: 355px;
    position: fixed;
    left: 0px;
    top: 0px;
    bottom: 0px;
    height: 100%;
    display: inline-block;
    vertical-align: top;
    background-color: #fff;
    transition: $primaryTransition;

    a {
        font-size: 18px;
        font-weight: 600;
        color: $projectGrey1;
        transition: $primaryTransition;

        &:hover,
        &:focus {
            text-decoration: none;
            color: $projectBlue;
        }
    }

    &.minimised {
        width: 90px;

        .sideMenu__logo,
        .toggleUser {
            padding-left: 30px;
            span {
                display: none;
            }
        }

        .sideMenu__menu li a,
        .sideMenu__user__submenu li a {
            padding-left: 35px;
            span {
                display: none;
            }
        }

        .sideMenu__menu .sub-menu a {
            padding-left: 30px;
        }

        .sideMenu__button {
            top: 78px;
            right: 36px;
            transform: rotate(180deg);
        }

        big img {
            display: none;
        }
        small img {
            display: block;
            padding-bottom: 30px;
        }
    }
}
.sideMenu__logo {
    padding: 30px 45px;
    img {
        max-width: 154px;
        height: auto;
    }

    small img {
        display: none;
    }
    border-bottom: solid 1px $projectGrey6;
}
.sideMenu__button {
    position: absolute;
    right: 30px;
    top: 33px;
    color: $projectGrey5;
    font-size: 18px;
    cursor: pointer;
    z-index: $zIndexFloatingButtons;
    transition: $primaryTransition;

    &:hover,
    &:focus {
        color: $projectGrey1;
    }
}
.sideMenu__user {
    padding: 0px;
    .toggleUser {
        padding: 30px 45px;
        border-bottom: solid 1px $projectGrey6;
        display: block;
    }

    img {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        margin-right: 20px;
        border: solid 1px $projectGrey6;
    }
}

.sideMenu__user__submenu {
    color: #fff;
    background-color: $projectDarkGrey1;
    padding: 0px;
    margin: 0px;
    transition: all 0.8s;
    height: 0px;
    overflow-y: hidden;

    &.active {
        height: 150px;
    }

    li {
        list-style: none;

        a {
            color: #fff;
            padding: 20px 45px;
            display: block;
            background-color: $projectDarkGrey1;
            transition: $primaryTransition;

            &:hover,
            &:focus {
                background-color: $projectGrey1;
                color: #fff;
            }
        }
        i {
            padding-right: 20px;
        }
    }
}

.sideMenu__menu {
    padding: 0px;
    ul {
        padding-left: 0px;
        margin: 0px;
        li {
            list-style: none;

            &.current-menu-item {
                a {
                    color: $projectBlue;
                }
            }

            a {
                padding: 30px 45px;
                display: block;
                transition: $primaryTransition;
            }
        }

        .current-menu-ancestor {
            a {
                color: $projectBlue;
            }
            .sub-menu {
                display: block;
            }
        }

        .sub-menu .current-menu-item a {
            background-color: $projectGrey1 !important;
        }

        i {
            font-size: 24px;
            padding-right: 25px;
        }

        .sub-menu {
            height: 0px;
            transition: all 1.2s;
            overflow-y: hidden;

            &.active {
                height: 300px;
            }

            li {
                a {
                    padding: 20px 45px;
                    background-color: $projectDarkGrey1;
                    color: #ffffff;

                    &:hover,
                    &:focus {
                        background-color: $projectGrey1;
                        color: #fff;
                    }
                }
                a[href=""],
                a[href="#"] {
                    pointer-events: none;
                    color: $projectGrey10;
                }

                &.inactive a {
                    pointer-events: none;
                    color: $projectGrey10;
                }
            }
        }
    }
}

@media (max-width: 991.98px) {
    .sideMenu {
        width: 90px;

        .sideMenu__logo,
        .toggleUser {
            padding-left: 30px;
            span {
                display: none;
            }
        }

        .sideMenu__menu li a,
        .sideMenu__user__submenu li a {
            padding-left: 35px !important;
            span {
                display: none;
            }
        }

        .sideMenu__menu .sub-menu a {
            padding-left: 30px !important;
        }

        .sideMenu__button {
            display: none;
        }

        big img {
            display: none;
        }
        small img {
            display: block;
            padding-bottom: 30px;
        }
    }
}

@media (max-width: 575.98px) {
    .sideMenu {
        position: fixed;
        z-index: $zindexHeader;
        height: 90px;
        overflow: hidden;
        box-shadow: $boxShadow;

        &.minimised {
            height: 100vh;

            .sideMenu__button {
                transform: rotate(90deg);
            }
        }
    }
    .sideMenu__logo {
        padding-top: 20px;
    }
    .sideMenu__button {
        display: block !important;
        transform: rotate(-90deg);
        top: 60px;
        right: 36px;
    }
}
</style>
