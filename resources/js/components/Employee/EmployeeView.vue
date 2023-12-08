<template>
    <div class="container">
        <div class="user-details">
            <div class="wraper shadow p-3">
                <h3 class="text-center mb-3">Employee Profile</h3>
                <div class="left-details">
                    <div class="user-items">
                        <div class="title font-weight-bold">Name</div>
                        <div class="">{{ employee.name }}</div>
                    </div>
                    <div class="user-items">
                        <div class="title font-weight-bold">Email</div>
                        <div class="">{{ employee.email }}</div>
                    </div>
                    <div class="user-items">
                        <div class="title font-weight-bold">Phone</div>
                        <div class="">{{ employee.phone }}</div>
                    </div>
                </div>
                <hr />
                <div class="right-details">
                    <div class="user-items">
                        <div class="title font-weight-bold">Address</div>
                        <div class="">{{ employee.address }}</div>
                    </div>
                    <div class="user-items">
                        <div class="title font-weight-bold">Department</div>
                        <div class="">{{ employee.department?.name }}</div>
                    </div>
                    <div class="user-items">
                        <div class="title font-weight-bold">Achievements</div>
                        <div class="" v-for="item in employee.achievement">
                            {{ item?.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EmployeeView",
    data() {
        return {
            employee: {},
            errors: {},
        };
    },
    methods: {
        async getUserDetails() {
            // vue overlay loader
            let loader = this.$loading.show({
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
            });

            const id = this.$route.params.id;
            const token = localStorage.getItem("accessToken");

            const result = await axios.get(`/api/v1/employee/show/${id}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Authorization: `Bearer ${token}`,
                },
            });
            this.employee = result.data.data;
            loader.hide();
        },
    },
    mounted() {
        this.getUserDetails();
    },
};
</script>

<style scoped>
.wraper {
    border-radius: 5px;
    border: 2px solid #ddd9d9;
    width: 50%;
}
.user-details {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5rem;
    height: 90vh;
}

.left-details {
    display: flex;
    gap: 2rem;
    justify-content: space-between;
    align-items: center;
}

.right-details {
    display: flex;
    gap: 2rem;
    justify-content: space-between;
    align-items: center;
}

.wraper h3 {
    background: #007bff;
    padding: 10px 15px;
    color: white;
    font-weight: bold;
    border-radius: 5px;
}
</style>
