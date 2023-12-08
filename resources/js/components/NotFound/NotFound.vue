<template>
    <div class="container">
        <div class="notfound-body">
            <h3 class="text-center text-light">Page NotFound</h3>
            <router-link
                to="/dashboard"
                class="text-center bg-primary text-white p-2 w-25">Home</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotFound",
};
</script>

<style scoped>
.notfound-body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 90vh;
    gap: 1rem;
}
.notfound-body h3 {
    color: #9f9f9f !important;
}

.notfound-body a {
    border-radius: 5px;
    font-weight: bold;
}
</style>
