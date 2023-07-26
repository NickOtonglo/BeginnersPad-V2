<template>
    <ul class="pagination">
        <li>
            <button type="button" @click="onClickFirstPage" :disabled="isInFirstPage">
                First
            </button>
        </li>

        <li>
            <button type="button" @click="onClickPreviousPage" :disabled="isInFirstPage">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
        </li>

        <!-- Visible Buttons Start -->

        <li v-for="page in pages" :key="page.name">
            <button type="button" @click="onClickPage(page.name)"
             :disabled="page.isDisabled"
             :class="{ active: isPageActive(page.name) }">
                {{ page.name }}
            </button>
        </li>

        <!-- Visible Buttons End -->

        <li>
            <button type="button" @click="onClickNextPage" :disabled="isInLastPage">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </li>

        <li>
            <button type="button" @click="onClickLastPage" :disabled="isInLastPage">
                Last
            </button>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'Pagination',
    props: {
        maxVisibleButtons: {
            type: Number,
            required: false,
            default: 3,
        },
        totalPages: {
            type: Number,
            required: true,
        },
        perPage: {
            type: Number,
            required: true,
        },
        currentPage: {
            type: Number,
            required: true,
        },
        // metaLinks: {
        //     type: Array,
        //     required: true,
        // }
    },
    computed: {
        startPage() {
            // when on the first page
            if (this.currentPage === 1) {
                return 1
            }

            // when on the last page
            if (this.currentPage === this.totalPages) {
                const start = this.totalPages - (this.maxVisibleButtons - 1);

                if (start === 0) {
                    return 1;
                } else {
                    return start;
                }
            }

            // when in-between
            return this.currentPage - 1
        },
        pages() {
            const range = []
            for(
                let i = this.startPage;
                i <= Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);
                i++
            ) {
                range.push({
                    name: i,
                    isDisabled: i === this.currentPage
                })
            }

            return range
        },
        isInFirstPage() {
            return this.currentPage === 1
        },
        isInLastPage() {
            return this.currentPage === this.totalPages
        }
    },
    methods: {
        onClickFirstPage() {
            this.$emit('pagechanged', 1)
        },
        onClickPreviousPage() {
            this.$emit('pagechanged', this.currentPage - 1)
        },
        onClickPage(page) {
            this.$emit('pagechanged', page)
        },
        onClickNextPage() {
            this.$emit('pagechanged', this.currentPage + 1)
        },
        onClickLastPage() {
            this.$emit('pagechanged', this.totalPages)
        },
        isPageActive(page) {
            return this.currentPage === page;
        }
    }
}
</script>
