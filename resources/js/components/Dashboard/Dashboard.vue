<template>
    <div class="container">
        <div class="wraper">
            <h3 class="shadow">Dashboard</h3>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,
        };
    },
};
</script>
<style scoped>
.wraper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 90vh;
}

.wraper h3 {
    background: #007bff;
    padding: 10px 15px;
    color: white;
    font-weight: bold;
    border-radius: 5px;
}
</style>
