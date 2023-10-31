<template>
    <div class="fab-container">
        <button @click="click(refAddUser)" class="fab btn-primary"><i class="fas fa-plus"></i> Add user</button>
    </div>

    <SearchBar 
        @search-initiated="filterUsers" 
        @search-cancelled="filterUsers" />

    <section class="section-users" id="sectionManageUsers">
        <div class="container">
            <div class="top-buttons">
                <div class="btn-grp horizontal">
                    <button 
                        @click="btnSelected='All', getPaginationDataWithRequest(1, 'users', `${request}/`)" 
                        :class="btnSelected == 'All' ? 'selected' : ''">All</button>
                    <button 
                        @click="btnSelected='Beginner', getPaginationDataWithRequest(1, 'users', `${request}/Beginner`)" 
                        :class="btnSelected == 'Beginner' ? 'selected' : ''">Beginners</button>
                    <button 
                        @click="btnSelected='Lister', getPaginationDataWithRequest(1, 'users', `${request}/Lister`)" 
                        :class="btnSelected == 'Lister' ? 'selected' : ''">Listers</button>
                    <button 
                        @click="btnSelected='Admin', getPaginationDataWithRequest(1, 'users', `${request}/Admin`)" 
                        :class="btnSelected == 'Admin' ? 'selected' : ''">Admins/Reps</button>
                    <button 
                        @click="btnSelected='Super Admin', getPaginationDataWithRequest(1, 'users', `${request}/Super Admin`)" 
                        :class="btnSelected == 'Super Admin' ? 'selected' : ''">Super Admins</button>
                    <button 
                        @click="btnSelected='System Admin', getPaginationDataWithRequest(1, 'users', `${request}/System Admin`)" 
                        :class="btnSelected == 'System Admin' ? 'selected' : ''">System Admins</button>
                    <button 
                        @click="btnSelected='Unset', getPaginationDataWithRequest(1, 'users', `${request}/Unset`)" 
                        :class="btnSelected == 'Unset' ? 'selected' : ''">Unset</button>
                </div>
                <div class="btn-grp vertical">
                    <button 
                        @click="btnSelected='All', getPaginationDataWithRequest(1, 'users', `${request}/`)" 
                        :class="btnSelected == 'All' ? 'selected' : ''">All</button>
                    <button 
                        @click="btnSelected='Beginner', getPaginationDataWithRequest(1, 'users', `${request}/Beginner`)" 
                        :class="btnSelected == 'Beginner' ? 'selected' : ''">Beginners</button>
                    <button 
                        @click="btnSelected='Lister', getPaginationDataWithRequest(1, 'users', `${request}/Lister`)" 
                        :class="btnSelected == 'Lister' ? 'selected' : ''">Listers</button>
                    <button 
                        @click="btnSelected='Admin', getPaginationDataWithRequest(1, 'users', `${request}/Admin`)" 
                        :class="btnSelected == 'Admin' ? 'selected' : ''">Admins/Reps</button>
                    <button 
                        @click="btnSelected='Super Admin', getPaginationDataWithRequest(1, 'users', `${request}/Super Admin`)" 
                        :class="btnSelected == 'Super Admin' ? 'selected' : ''">Super Admins</button>
                    <button 
                        @click="btnSelected='System Admin', getPaginationDataWithRequest(1, 'users', `${request}/System Admin`)" 
                        :class="btnSelected == 'System Admin' ? 'selected' : ''">System Admins</button>
                    <button 
                        @click="btnSelected='Unset', getPaginationDataWithRequest(1, 'users', `${request}/Unset`)" 
                        :class="btnSelected == 'Unset' ? 'selected' : ''">Unset</button>
                </div>
            </div>
            <div class="container-btn-dropdown">
                <select v-model="filter_sort" @change="btnSelected='All', getPaginationDataWithRequest(1, 'users', `${request}/`)" class="btn-dropdown">
                    <option value="">Sort by default</option>
                    <option value="DESC">Sort by newest</option>
                    <option value="ASC">Sort by oldest</option>
                </select>
            </div>
            <div id="isLoading">
                <div v-show="isLoading" class="lds-dual-ring"></div>
                <span v-if="isLoading">Loading...</span>
            </div>
            <div class="cards">
                <div v-for="(item, index) in users" class="profile primary">
                    <CardUser :user="item" :clickable="true" />
                </div>
            </div>
            <template v-if="!users.length">
                <p style="text-align: center;">-no users-</p>
            </template>
            <Pagination v-if="usersCount > 50" :totalPages="total_pages"
                :perPage="per_page"
                :currentPage="current_page"
                @pagechanged="onPageChange" />
        </div>
    </section>

    <ModalAddUser ref="refAddUser" />
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import pagination from '../../composables/pagination';
import CardUser from '../Cards/User1.vue';
import SearchBar from '../Search/SearchBar.vue';
import ModalAddUser from '../Modals/AddUser.vue'

const {
    search_global,
    filter_sort,
    total_pages,
    per_page,
    current_page,
    users,
    usersCount,
    onPageChange,
    getPaginationDataWithRequest,
    isLoading,
} = pagination()

const refAddUser = ref(null)
const request = ref(`/api/users`)
const btnSelected = ref('All')

function filterUsers(input) {
    if (!input) {
        search_global.value = ''
        btnSelected.value = 'All'
    } else {
        search_global.value = input
        btnSelected.value = ''
    }
    getPaginationDataWithRequest(current_page.value, 'users', request.value)
}

function click(element) {
    element.openModal();
}

onBeforeMount(() => {
    filterUsers('')
})
</script>