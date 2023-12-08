<template>
    <div class="container">
        <div class="login_form">
            <form class="bg-primary shadow" @submit.prevent="handleEmployeeUpdate">
                <h3 class="text-center">Employee Edit</h3>
                <div class="form-group">
                    <label for="inputEmail">Name</label>
                    <input type="text" class="form-control" placeholder="Name" v-model="employee.name"/>
                </div>
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="inputEmail" placeholder="Email" v-model="employee.email"/>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Phone</label>
                    <input type="text" class="form-control" placeholder="Phone" v-model="employee.phone"/>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Address</label>
                    <input type="text" class="form-control" placeholder="Address" v-model="employee.address"/>
                </div>

                <div class="form-group">
                    <label>Department</label><br />
                    <select class="form-control" v-model="employee.department_id">
                        <option value="" disabled>-Select-</option>
                        <option v-for="department in departments" :key="department.id" :value="department.id">
                            {{ department.name }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Achievement</label><br />
                    <label v-for="achievement in achievements" :for="achievements.id" style="display: block">
                        <input type="checkbox" v-model="employee.achievement_id" :id="achievement.id" :value="achievement.id"/>
                        {{ achievement.name }}
                    </label>
                </div>
                <button type="submit" class="btn btn-primary text-center">
                    Update
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "EmployeeEdit",
    data() {
        return {
            employee: {
                name: "",
                email: "",
                address: "",
                phone: "",
                department_id: "",
                achievement_id: [],
            },
            departments: [],
            achievements: [],
        };
    },
    methods: {
        async handleEmployeeUpdate() {
            let loader = this.$loading.show({
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
            });
            const token = localStorage.getItem("accessToken");

            const formData = new FormData();
            formData.append("name", this.employee.name);
            formData.append("phone", this.employee.phone);
            formData.append("email", this.employee.email);
            formData.append("address", this.employee.address);
            formData.append("department_id", this.employee.department_id);

            this.employee.achievement_id.forEach((id) => {
                formData.append("achievement_id[]", id);
            });

            const headers = {
                "X-Requested-With": "XMLHttpRequest",
                Authorization: `Bearer ${token}`,
            };

            await axios.post(`/api/v1/employee/update/${this.$route.params.id}`, formData, {headers}).then((response) => {
                    this.errors = {};
                    this.$router.push({ name: "employee" });
                    this.$toast.open({
                        message: response.data.message,
                        type: "success",
                    });
                    loader.hide();
                }).catch((error) => {
                    console.log(error);
                });
        },
        async getAllDepartment() {
            let loader = this.$loading.show({
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
            });

            const token = localStorage.getItem("accessToken");

            const result = await axios.get("/api/v1/department/list", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Authorization: `Bearer ${token}`,
                },
            });

            this.departments = result.data.data;
            loader.hide();
        },
        async getAllAchievement() {
            let loader = this.$loading.show({
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
            });

            const token = localStorage.getItem("accessToken");

            const result = await axios.get("/api/v1/achievement/list", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Authorization: `Bearer ${token}`,
                },
            });

            this.achievements = result.data.data;
            loader.hide();
        },
        async getEditUser() {
            const token = localStorage.getItem("accessToken");
            const id = this.$route.params.id;

            const result = await axios.get(`/api/v1/employee/show/${id}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Authorization: `Bearer ${token}`,
                },
            });

            this.employee.name = result.data.data.name;
            this.employee.email = result.data.data.email;
            this.employee.address = result.data.data.address;
            this.employee.phone = result.data.data.phone;
            this.employee.department_id = result.data.data.department_id;

            result.data.data.achievement.forEach((data) => {
                this.employee.achievement_id.push(data.id);
            });
        },
    },
    mounted() {
        this.getAllDepartment();
        this.getAllAchievement();
        this.getEditUser();
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
    margin: 2rem 0rem;
}

.login_form h3 {
    background: #007bff;
    padding: 10px 15px;
    color: white;
    font-weight: bold;
    border-radius: 5px;
}

.login_form form {
    width: 50%;
    padding: 20px 10px;
    border-radius: 5px;
}
.login_form form a {
    float: right;
    color: white;
}
</style>
