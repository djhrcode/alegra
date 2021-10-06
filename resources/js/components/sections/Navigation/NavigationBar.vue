<template>
    <nav class="navbar p-1 p-0-touch" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item">
                <img
                    src="@/assets/img/worldwideimages-logo.svg"
                    style="min-height: 30px"
                />
            </a>

            <a
                role="button"
                class="navbar-burger"
                aria-label="menu"
                aria-expanded="false"
                data-target="navbarBasicExample"
            >
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <!-- <a class="navbar-item"> Home </a>

                <a class="navbar-item"> Documentation </a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link"> More </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item"> About </a>
                        <a class="navbar-item"> Jobs </a>
                        <a class="navbar-item"> Contact </a>
                        <hr class="navbar-divider" />
                        <a class="navbar-item"> Report an issue </a>
                    </div>
                </div> -->
            </div>

            <div class="navbar-end">
                <img
                    class="my-auto"
                    src="@/assets/img/powered-by-alegra-logo.svg"
                    style="min-height: 24px; max-height: 24px"
                />
            </div>
        </div>
    </nav>
</template>

<script>
export default {};
</script>

<style scoped lang="scss">
@import "@/styles/main.scss";

$navbar-padding-vertical: 1rem !default;
$navbar-padding-horizontal: 1.5rem !default;

@import "bulma/sass/components/navbar.sass";

.navbar {
    // padding: $navbar-padding-vertical $navbar-padding-horizontal;
}
</style>
