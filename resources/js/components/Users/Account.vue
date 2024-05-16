<template>
    <!-- Showcase -->
    <section class="showcase-avatar">
        <div class="showcase-overlay warning">
            <div class="container">
                <div class="card-wrapper">
                    <CardUser :user="user" />
                </div>
                <div class="action-buttons">
                    <i @click="click(updateFormRef)" class="fas fa-edit fa-2x"></i>
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
                                <!-- <li>Account type: {{ user.role }}</li> -->
                                <li>Email address: {{ user.email }}</li>
                                <li>Last logged in on: 01-01-2021 00:00:00</li>
                                <li>Registered on: {{ user.created_at }}</li>
                                <li>Phone number: {{ user.telephone }}</li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="panel-item bordered">
                        <div class="data">
                            <ul>
                                <li>Count of listings occupied: 0</li>
                                <li>Count of listing reviews: 0</li>
                                <li>Last listing occupied on: N/A</li>
                                <li>Last review made on: N/A</li>
                                <li>Times suspended: 0</li>
                            </ul>
                        </div>
                    </div> -->
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
                <div class="panel">
                    <div class="panel-item anchor-no-text-decoration">
                        <h3>Recent activity</h3>
                        <template v-for="(notification, index) in notifications">
                            <template v-if="index <= 7" class="">
                                <router-link
                                    @click="setNotificationToRead(`/api/notifications/key/${notification.id}`), notification.read = 1"
                                    v-if="notification.dest && !isNaN(notification.dest)"
                                    :to="notification.dest_link ? { name: notification.dest, params: { id: notification.dest_link } } : { name: notification.dest }"
                                    class="data-2 link" :class="notification.read == 0 ? 'bold' : ''">
                                    <div class="text">
                                        <h5>{{ notification.time_ago }}</h5>
                                        <h4>{{ notification.title }}</h4>
                                        <p>{{ notification.body }}</p>
                                    </div>
                                </router-link>
                                <router-link
                                    @click="setNotificationToRead(`/api/notifications/key/${notification.id}`), notification.read = 1"
                                    v-if="notification.dest && isNaN(notification.dest)"
                                    :to="notification.dest_link ? { name: notification.dest, params: { slug: notification.dest_link } } : { name: notification.dest }"
                                    class="data-2 link" :class="notification.read == 0 ? 'bold' : ''">
                                    <div class="text">
                                        <h5>{{ notification.time_ago }}</h5>
                                        <h4>{{ notification.title }}</h4>
                                        <p>{{ notification.body }}</p>
                                    </div>
                                </router-link>
                                <div @click="setNotificationToRead(`/api/notifications/key/${notification.id}`), notification.read = 1"
                                    v-else class="data-2 link" :class="notification.read == 0 ? 'bold' : ''">
                                    <div class="text">
                                        <h5>{{ notification.time_ago }}</h5>
                                        <h4>{{ notification.title }}</h4>
                                        <p class="txt-triple-line">{{ notification.body }}</p>
                                    </div>
                                </div>
                            </template>
                        </template>
                        <template v-if="!notifications.length">
                            <p style="text-align: center;">-no new notifications-</p>
                        </template>
                        <!-- <div class="data-2 link">
                            <div class="thumb">
                                <img src="/images/static/avatar.png" alt="">
                            </div>
                            <div class="text">
                                <h4>Title</h4>
                                <p class="txt-triple-line">
                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde repellat laudantium commodi quis asperiores! Hic consequuntur ea reprehenderit earum! Maiores omnis aliquid facere. Excepturi ab cum aliquam amet veritatis blanditiis maxime! Asperiores, suscipit. Laborum in eaque, expedita illo odio nulla, rem fugit error quibusdam ullam libero debitis doloremque magnam? Adipisci, eos ut. Vero, repellendus! Ab magnam eius est tenetur dignissimos ullam totam ex pariatur aliquam porro, officia placeat at, sapiente perspiciatis fugit. Soluta deleniti accusamus quidem. Libero aperiam possimus consequuntur mollitia aliquam aut laboriosam unde eos architecto eius? Voluptas, suscipit hic eveniet id quibusdam ab eum modi consequuntur pariatur dolor iusto deserunt blanditiis asperiores excepturi sapiente quaerat aliquid velit, inventore saepe sit alias enim ea mollitia aspernatur? Voluptate maiores, et itaque aut sunt deserunt exercitationem! Debitis veritatis sint eaque perspiciatis est id. Dolorem delectus illo ipsa officia inventore eaque, placeat, aperiam, ex fugiat consequuntur atque! Cumque error dignissimos inventore ipsum adipisci temporibus quo aut cupiditate sed rem ut doloribus voluptates nihil nesciunt, libero amet accusantium quia sunt eligendi distinctio id. Sed aut suscipit commodi, asperiores rem at laborum voluptatum exercitationem ullam saepe ratione consequuntur impedit. Dolorem unde facere, ipsa fuga corporis fugiat optio. Ullam architecto nemo aut recusandae delectus blanditiis neque corporis eligendi itaque dolorem. Eveniet sequi, corporis molestias autem laboriosam magni sint ut quos magnam quia perferendis labore excepturi recusandae nisi repudiandae harum dicta? Veritatis sapiente error in, odit quis optio quidem saepe voluptatibus officiis odio neque hic ipsam voluptate, mollitia a, deserunt facere sunt aliquam consequuntur dolor illo.
                                </p>
                            </div>
                        </div> -->
                    </div>
                    <div class="section-more">
                        <router-link v-if="notifications.length" :to="{ name: 'user.notifications' }">View more <i
                                class="fas fa-chevron-right"></i></router-link>
                        <router-link v-else :to="{ name: 'user.notifications' }">View all notifications <i
                                class="fas fa-chevron-right"></i></router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <UpdateForm ref="updateFormRef" />
    <UpdateBrand ref="updateBrandRef" />
    <CreateBrand ref="createBrandRef" />
</template>

<script setup>
import { onMounted, ref } from 'vue';
import UpdateForm from '../Modals/EditUserAccount.vue'
import UpdateBrand from '../Modals/EditBrand.vue'
import CreateBrand from '../Modals/CreateBrand.vue'
import CardUser from '../Cards/User1.vue';
import CardBrand from '../Cards/Brand1.vue'
import notificationsMaster from '../../composables/notifications';

const user = ref({})

const props = defineProps(['modal'])
const updateFormRef = ref(null);
const updateBrandRef = ref(null);
const createBrandRef = ref(null)
const {
    notifications,
    getNotifications,
    setNotificationToRead, 
} = notificationsMaster()

function getUserAccount() {
    axios.get('api/user/account')
        .then(response => {
            user.value = response.data

            axios.get('/api/user')
                .then(response => user.value.role = response.data.role)
                .catch(error => console.log(error))
        })
        .catch(error => console.log(error))
}

function click(element) {
    element.openModal();
}

onMounted(() => {
    getUserAccount()
    getNotifications(`/api/notifications/unread`)
})

</script>
<style scoped>
.showcase-overlay .action-buttons i {
    color: #fff;
}
</style>