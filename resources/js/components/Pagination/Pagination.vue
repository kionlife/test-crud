<template>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item" :class="{ disabled: currentPage <= 1 }">
                <a class="page-link"
                   @click.prevent="changePage(currentPage - 1)"
                   href="#"
                   aria-label="Previous">
                   <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li
                v-for="page in pages"
                :key="page"
                class="page-item"
                :class="{ active: page === currentPage }">
                    <a class="page-link" @click.prevent="changePage(page)" href="#">{{ page }}</a>
            </li>

            <li class="page-item" :class="{ disabled: currentPage >= lastPage }">
                <a class="page-link"
                   @click.prevent="changePage(currentPage + 1)"
                   href="#"
                   aria-label="Next">
                   <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        lastPage: {
            type: Number,
            required: true,
        },
    },
    computed: {
        pages() {
            const from = this.currentPage - 2 > 0 ? this.currentPage - 2 : 1;
            const to = this.currentPage + 2 < this.lastPage ? this.currentPage + 2 : this.lastPage;
            return Array.from({ length: to - from + 1 }, (_, i) => from + i);
        },
    },
    methods: {
        changePage(page) {
            this.$emit("page-changed", page);
        },
    },
};
</script>
