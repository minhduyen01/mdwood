<template>
    <div>
        <SidebarMenu/>
        <div class="layout--main" style="margin-left: 260px;">
            <TheNavbar/>
            <Nuxt />
        </div>
    </div>
</template>
<script>
import TheNavbar from "../components/admin/navbar/TheNavbar"
import SidebarMenu from "../components/admin/sidebar/SidebarMenu"

export default {
    components: {
        TheNavbar,
        SidebarMenu
    },
    middleware: ["admin"]
}
</script>
<style lang="scss">
body{
    background: #f8f8f8;
    -webkit-transition: background-color .3s ease;
    font-family: "Montserrat", Helvetica, Arial, sans-serif;
    font-size: 14px !important;
}
</style>
