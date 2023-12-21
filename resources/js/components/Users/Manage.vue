<template>
    <!-- Showcase -->
    <section class="showcase-avatar">
        <div class="showcase-overlay warning">
            <div class="container">
                <div class="card-wrapper">
                    <CardUser :user="user" :clickable="false" />
                </div>
            </div>
        </div>
    </section>

    <section class="section-user-profile">
        <div class="container">
            <div class="panel-grp">
                <div class="panel">
                    <div class="panel-item bordered">
                        <div class="data">
                            <ul>
                                <li>Created on: {{ user.created_at }}</li>
                                <li>Times suspended: {{ user.count_suspended }}</li>
                            </ul>
                        </div>
                    </div>
                    <div v-if="user.role == 'Lister'" class="panel-item bordered">
                        <div class="lister-details">
                            <div class="title-grp">
                                <h3>Brand profile</h3>
                                <div class="info-actions">
                                    <i v-if="user.brand" @click="click(updateBrandRef)" class="fas fa-edit"></i>
                                    <i v-if="!user.brand" @click="click(createBrandRef)" class="fas fa-edit"></i>
                                </div>
                            </div>
                            <template v-if="user.brand">
                                <CardBrand :brand="user.brand" :user="user" />
                            </template>
                            <template v-else>
                                <div class="details">
                                    <div class="header">
                                        <div>
                                            <h2 class="name">-brand name-</h2>
                                        </div>
                                        <img src="/images/static/avatar.png" alt="">
                                    </div>
                                    <p class="listings-count">no listings posted</p>
                                    <div class="info-rating-grp">
                                        <p class="rating">Rating: -no rating-</p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container" >
            <form @submit.prevent="updateUserStatus(`/api/users/profile/${user.username}`, user)" ref="formRef" :hidden="true">
                <div class="form-group">
                    <input v-model="user.status" type="text" name="status" :disabled="true">
                </div>
                <button :disabled="true" ref="btnSubmitRef" class="btn-submit" type="submit">
                    <div v-show="isLoading" class="lds-dual-ring"></div>
                    <span v-if="isLoading">Loading...</span>
                    <span v-else>Save</span>
                </button>
            </form>
            <div class="container-btn-dropdown multi">
                <ButtonDropdown 
                    v-if="auth_user.role == 'System Admin' || auth_user.role == 'Super Admin' || auth_user.role == 'Admin'"
                    ref="buttonDropRef" 
                    :actionList="actionList" 
                    @action-selected="actionSelected"/>
            </div>
        </div>
    </section>

    <section id="sectionTable">
        <div class="container">
            <div class="table-grp">
                <h4 class="table-title">User log</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Performed by</th>
                        <th>Comments</th>
                        <th>Time</th>
                    </tr>
                    <template v-for="(item, index) in user.logs">
                        <tr>
                            <td>{{ index+1 }}</td>
                            <td>@{{ item.username }}</td>
                            <template v-if="item.method == 'POST'">
                                <td>account created</td>
                            </template>
                            <template v-else-if="item.method == 'PATCH' && item.username">
                                <td>account updated</td>
                            </template>
                            <template v-else-if="item.method == 'DELETE' || (item.method == 'PATCH' && !item.username)">
                                <td>account deleted</td>
                            </template>
                            <td>@{{ item.action_by }}</td>
                            <td>{{ item.comment }}</td>
                            <td>{{ item.time_ago }}</td>
                        </tr>
                    </template>
                    <template v-if="user.logs && !user.logs.length">
                        <tr style="text-align: center;">-no logs-</tr>
                    </template>
                </table>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import userMaster from '../../composables/users'
import CardUser from '../Cards/User1.vue';
import CardBrand from '../Cards/Brand1.vue'
import ButtonDropdown from '../Misc/ButtonDropdown.vue';
import checkAuth from '../../composables/checkAuth';

const { getUser, user, route, updateUserStatus, isLoading } = userMaster()
const buttonDropRef = ref(null)
const formRef = ref(null)
const btnSubmitRef = ref(null)

const actionList = ref([
    {
        id: 1,
        text: `Suspend`,
    }, 
    {
        id: 2,
        text: `Restore`,
    }, 
    {
        id: 3,
        text: `Delete`,
    },
])

const auth_user = ref({})
const getUserData = () => {
    if (checkAuth().isAuthenticated.value) {
        axios.get('/api/user')
            .then(response => auth_user.value = response.data)
            .catch(error => console.log(error))
    }
}    

function actionSelected(action) {
    if (action == 'Suspend') {
        user.value.status = `Suspend`
        btnSubmitRef.value.disabled = isLoading
        btnSubmitRef.value.click()
    }
    if (action == 'Restore') {
        user.value.status = `Restore`
        btnSubmitRef.value.disabled = isLoading
        btnSubmitRef.value.click()
    }
    if (action == 'Delete') {
        user.value.status = `Delete`
        btnSubmitRef.value.disabled = isLoading
        btnSubmitRef.value.click()
    }
}

onBeforeMount(() => {
    getUser(`/api/users/profile/${route.params.username}`)
    getUserData()
})
</script>

<style scoped>
.table-grp table td {
    overflow: auto;
    text-overflow: unset;
    max-width: unset;
}
</style>