<template>
    <div class="container">
        <div class="login_form">
            <form class="bg-light shadow" @submit.prevent="handleUserLogin">
                <h3 class="text-center">Login User</h3>
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="inputEmail"
                        placeholder="Email"
                        v-model="login.email"
                    />
                    <div
                        v-if="login.errors.has('email')"
                        v-html="login.errors.get('email')"
                        class="text-danger"
                    />
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        id="inputPassword"
                        placeholder="Password"
                        v-model="login.password"
                    />
                    <div
                        v-if="login.errors.has('password')"
                        v-html="login.errors.get('password')"
                        class="text-danger"
                    />
                </div>
                <button type="submit" class="btn btn-primary font-weight-bold">Login</button>
                <router-link
                    :to="{ name: 'register' }"
                    class="btn bg-primary font-weight-bold">Register an account</router-link>
            </form>
        </div>
    </div>
</template>

<script>
import Form from "vform";
import App from "./../App.vue";

export default {
    name: "Login",
    components: {
        App,
    },
    data() {
        return {
            login: new Form({
                email: "",
                password: "",
            }),
            isLoggedIn: false,
        };
    },
    methods: {
        async handleUserLogin() {
            // vue overlay loader
            let loader = this.$loading.show({
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
            });

            const formData = new FormData();
            formData.append("email", this.login.email);
            formData.append("password", this.login.password);

            const headers = {
                "X-Requested-With": "XMLHttpRequest",
            };

            await this.login
                .post("/api/v1/login", formData, { headers })
                .then((response) => {
                    localStorage.setItem(
                        "accessToken",
                        response.data.accessToken
                    );
                    this.$store.commit("setLoggedIn", true);
                    this.$router.push({ name: "employee" });
                    loader.hide();
                    this.$toast.open({
                        message: response.data.message,
                        type: "success",
                    });
                })
                .catch((error) => {
                    loader.hide();
                    if (error.response.status == 401) {
                        this.$toast.open({
                            message: error.response.data.message,
                            type: "warning",
                        });
                    }
                });
        },
    },
};
</script>

<style scoped>
.login_form {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    margin: 10rem 0rem;
}

.login_form form {
    width: 50%;
    padding: 20px 10px;
    border-radius: 5px;
    border: 2px solid #ddd9d9;
}

.login_form h3 {
    background: #007bff;
    padding: 10px 15px;
    color: white;
    font-weight: bold;
    border-radius: 5px;
}

.login_form form a {
    float: right;
    color: white;
}
</style>
