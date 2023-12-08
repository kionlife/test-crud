<template>
    <div class="wrap">
        <Header />
        <router-view />
    </div>
</template>

<script>
import Header from "./Header/Header.vue";

export default {
    name: "App",
    components: {
        Header,
    },
    data() {
        return {};
    },
};
</script>

<style scoped></style>
