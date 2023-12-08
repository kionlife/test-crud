<template>
    <div class="wrap">
        <div class="app-body shadow d-fixed bg-primary">
            <div class="container">
                <div class="menu" v-if="isLoggedIn">
                    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
                        <div class="container-fluid">
                            <a class="navbar-brand text-white" href="#">Site Logo</a>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <router-link
                                            v-if="isLoggedIn"
                                            class="nav-link text-white font-weight-bold"
                                            aria-current="page"
                                            :to="{ name: 'dashboard' }">Home
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link
                                            v-if="isLoggedIn"
                                            class="nav-link text-white font-weight-bold"
                                            :to="{ name: 'employee' }"
                                        >Employee
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="logout-btn">
                            <router-link
                                v-if="!isLoggedIn"
                                class="nav-link text-white font-weight-bold"
                                :to="{ name: 'login' }">Login
                            </router-link>
                            <a v-if="isLoggedIn"
                               class="nav-link text-white font-weight-bold"
                               @click.prevent="handleUserLogout"
                               href="#">Logout</a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: null,
        };
    },
    computed: {
        isLoggedIn() {
            return (this.isLoggedIn = this.$store.state.isLoggedIn);
        },
    },
    methods: {
        userLoggedInCheck() {
            const token = localStorage.getItem("accessToken");
            if (!token) {
                this.$store.commit("setLoggedIn", false);
            } else {
                this.$store.commit("setLoggedIn", true);
            }
        },
        async handleUserLogout() {
            let loader = this.$loading.show({
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
            });

            const token = localStorage.getItem("accessToken");
            await axios.get("/api/v1/logout", {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Authorization: `Bearer ${token}`,
                    },
                }).then((response) => {
                    localStorage.removeItem("accessToken");
                    this.$router.push("/login");
                    this.$store.commit("setLoggedIn", false);
                    loader.hide();
                }).catch((error) => console.log(error.message));
        }
    },
    mounted() {
        this.userLoggedInCheck();
    }
}
</script>

<style scoped>
.app-body {
    width: 100%;
}

.logout-btn {
    float: right !important;
}
</style>
