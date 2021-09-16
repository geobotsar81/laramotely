<template>
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            {{ item.title }}
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li v-for="{ submenuItem, index } in item.children" :key="index">
                <inertia-link class="dropdown-item" :href="route('page', submenuItem.url)">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mt-2">
                                <div class="col-12">
                                    {{ submenuItem.title }}
                                </div>
                            </div>
                            <div v-if="submenuItem.subtitle" class="row dropdownSubtitle">
                                <div class="col-12">
                                    {{ submenuItem.subtitle }}
                                </div>
                            </div>
                        </div>
                    </div>
                </inertia-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        item: Object,
    },
    components: {},
};
</script>
<style lang="scss" scoped>
.dropdown-toggle {
    font-size: 16px;
    line-height: 22px;
    color: #ffffff;
    font-weight: 600;
    transition: $appTransition;
    position: relative;
    &:after {
        content: "\f078";
        font-family: "Font Awesome 5 Pro";
        border: 0px;
        position: absolute;
        right: 0px;
        top: 0px;
        font-size: 10px;
    }

    &:hover,
    &:focus,
    &.active {
        color: $appBlue;
    }
}

.dropdown-menu {
    border-radius: 3px;
    box-shadow: 0px 10px 20px 0px rgba(40, 42, 57, 0.35);
    background-color: #ffffff;
    padding: 10px 0px;
    width: 550px;

    .dropdown-item {
        font-size: 16px;
        line-height: 22px;
        font-weight: 600;
        color: $appBlack;
        padding: 10px 25px;
        transition: $appTransition;

        &:hover,
        &:focus {
            background-color: #fff !important;
            color: $appBlue;

            .dropdown__svg {
                background-color: #e5f2fd;

                :deep(path) {
                    fill: $appBlue !important;
                }
            }
        }
    }
}

.dropdown__svg {
    border-radius: 4px;
    background-color: #eef8f1;
    width: 60px;
    height: 60px;
    text-align: center;
    display: inline-block;
    padding-top: 15px;
    margin-right: 10px;
    transition: $appTransition;

    :deep(path) {
        transition: $appTransition;
    }
}

.dropdownSubtitle {
    font-size: 14px;
    font-weight: 400;
    color: $appGrey2;
}

.sticky {
    .dropdown-toggle {
        color: $appBlack !important;
    }
}
</style>
