<template>
    <div class="container">
        <div class="login_form">
            <form class="bg-light" @submit.prevent="handleUserRegistration">
                <h3 class="text-center">User Registration</h3>
                <div class="form-group">
                    <label for="inputEmail">Name</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Name"
                        v-model="login.name"
                    />
                    <div
                        v-if="login.errors.has('name')"
                        v-html="login.errors.get('name')"
                        class="text-danger"
                    />
                </div>
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
                <div class="form-group">
                    <label for="inputPassword">Confirmed Password</label>
                    <input
                        type="password"
                        class="form-control"
                        placeholder="Password"
                        v-model="login.password_confirmation"
                    />
                </div>
                <button type="submit" class="btn btn-primary font-weight-bold">Register</button>
                <router-link
                    :to="{ name: 'login' }"
                    class="btn bg-primary font-weight-bold">Have an account</router-link>
            </form>
        </div>
    </div>
</template>

<script>
import Form from "vform";

export default {
    name: "Register",
    data() {
        return {
            login: new Form({
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            }),
            user: {},
        };
    },
    methods: {
        async handleUserRegistration() {
            let loader = this.$loading.show({
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
            });

            await this.login
                .post("/api/v1/register", {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then((res) => {
                    this.$router.push({ path: "/" });
                    loader.hide();
                    this.$toast.open({
                        message: res.data.message,
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
        getAuthUser() {
            axios.get("/api/v1/authUser").then((res) => {
                this.user = res.data.data;
            });
        },
    },
    mounted() {
        this.getAuthUser();
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
.login_form form a {
    float: right;
    color: white;
}
.login_form h3 {
    background: #007bff;
    padding: 10px 15px;
    color: white;
    font-weight: bold;
    border-radius: 5px;
}
</style>
