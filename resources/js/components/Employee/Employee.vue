<template>
    <div class="container">
        <div class="employee_table">
            <h3 class="text-center">Employee List</h3>
            <router-link :to="{ name: 'employee-create' }" class="btn btn-sm bg-primary font-weight-bold text-white float-right mb-1 ml-2">Create</router-link>
            <div class="employee-searach float-right">
                <input type="search" placeholder="Search" v-model="search" @keyup="employeeSearch"/>
            </div>
            <table class="table table-striped shadow">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Department</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(employee, index) in employees" :key="employee.id">
                    <th scope="row">{{ calculateSerialNumber(index) }}</th>
                    <td>{{ employee.name }}</td>
                    <td>{{ employee.email }}</td>
                    <td>{{ employee.phone }}</td>
                    <td>{{ employee.address }}</td>
                    <td>
                        {{ employee.department.name ? employee.department.name : "None" }}
                    </td>
                    <td style="width: 12%">
                        <router-link :to="{name: 'employee-view', params: { id: employee.id }}" class="btn btn-sm bg-primary text-white mr-1">
                            <icon icon="eye"/>
                        </router-link>
                        <router-link :to="{name: 'employee-edit', params: { id: employee.id }}" class="btn btn-sm bg-warning text-white mr-1">
                            <icon icon="edit"/>
                        </router-link>
                        <a href="" @click.prevent="removeEmployee(employee.id)" class="btn btn-sm bg-danger text-white">
                            <icon icon="trash"/>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="paginate-area">
                <span class="font-weight-bold text-danger" style="text-align: center">{{ employees.length === 0 ? "Data not found" : "" }}</span>
                <pagination :currentPage="currentPage" :lastPage="lastPage" @page-changed="handlePageChange" />
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import Pagination from "./../Pagination/Pagination.vue";

export default {
    name: "Employee",
    components: {
        Pagination,
    },
    data() {
        return {
            employees: [],
            search: "",
            currentPage: 1,
            lastPage: 0,
            perPage: 0,
        };
    },
    methods: {
        async getAllEmployee() {
            try {
                let loader = this.$loading.show({
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                });

                const token = localStorage.getItem("accessToken");
                const response = await axios.get("/api/v1/employee/list", {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Authorization: `Bearer ${token}`,
                    },
                });

                this.employees = response.data.data.data;
                this.lastPage = response.data.data.last_page;
                this.perPage = response.data.data.per_page;
                loader.hide();
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        removeEmployee(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    let loader = this.$loading.show({
                        container: this.fullPage ? null : this.$refs.formContainer,
                        canCancel: true,
                        onCancel: this.onCancel,
                    });

                    const token = localStorage.getItem("accessToken");
                    axios.get(`/api/v1/employee/delete/${id}`, {
                            headers: {
                                "X-Requested-With": "XMLHttpRequest",
                                Authorization: `Bearer ${token}`,
                            },
                        }).then((response) => {
                            this.employees = response.data.data;
                            this.$toast.open({
                                message: response.data.message,
                                type: "success",
                            });
                            this.getAllEmployee();
                            loader.hide();
                        }).catch((error) => {
                            console.log(error.message);
                        });
                }
            });
        },
        employeeSearch() {
            let loader = this.$loading.show({
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
            });

            const token = localStorage.getItem("accessToken");
            axios.get(`/api/v1/employee/search?search=${this.search}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Authorization: `Bearer ${token}`,
                    },
                }).then((response) => {
                    console.log(response.data.data);
                    this.employees = response.data.data;
                    loader.hide();
                }).catch((error) => console.log(error.message));
        },
        calculateSerialNumber(index) {
            return (this.currentPage - 1) * this.perPage + index + 1;
        },
        async handlePageChange(pageNumber = 1) {
            const token = localStorage.getItem("accessToken");
            const response = await axios.get(
                `/api/v1/employee/list?page=${pageNumber}`,
                {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Authorization: `Bearer ${token}`,
                    },
                }
            );

            this.employees = response.data.data.data;
            this.currentPage = response.data.data.current_page;
        },
    },
    mounted() {
        this.getAllEmployee();
        this.handlePageChange();
    },
};
</script>

<style scoped>
.employee_table {
    margin: 2rem 0rem;
}

.paginate-area {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.employee-searach input {
    border: 2px solid #d7d7d7;
    border-radius: 5px;
    padding: 2px 10px;
    font-weight: 500;
    outline: none;
}

.employee_table h3 {
    background: #007bff;
    padding: 10px 15px;
    color: white;
    font-weight: bold;
    border-radius: 5px;
}
</style>
