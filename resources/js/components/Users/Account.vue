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
                    <div class="panel-item bordered">
                        <div class="data">
                            <ul>
                                <li>Count of listings occupied: 0</li>
                                <li>Count of listing reviews: 0</li>
                                <li>Last listing occupied on: N/A</li>
                                <li>Last review made on: N/A</li>
                                <li>Times suspended: 0</li>
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
                <div class="panel">
                    <div class="panel-item">
                        <h3>Recent activity</h3>
                        <div class="data">
                            <div class="favourites-grp">
                                <div class="fav listing">
                                    <a href="/admin/manage-listing.html">
                                        <div class="thumb"></div>
                                        <div class="details">
                                            <h3 class="txt-single-line">Listing name</h3>
                                            <div class="location">
                                                <span class="spec">Location,</span>
                                                <span class="spec">Location,</span>
                                                <span class="spec">Location</span>
                                            </div>
                                            <p class="timestamp">Added 5 hours ago</p>
                                            <div class="info-rating-grp">
                                                <p class="rating">Rating: 4.0/5</p>
                                                <div class="stars">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                                </div>
                                <div class="fav unit">
                                    <a href="/admin/manage-listing-unit.html">
                                        <div class="thumb"></div>
                                        <div class="details">
                                            <h3 class="txt-single-line">Unit title</h3>
                                            <div class="specs">
                                                <span class="spec">1 bed,</span>
                                                <span class="spec">2 bath,</span>
                                                <span class="spec">40sq M</span>
                                            </div>
                                            <div class="deposit">
                                                <span class="label">Initial deposit:</span>
                                                <span class="data">not required</span>
                                            </div>
                                            <div class="price">
                                                <span class="label">KES</span>
                                                <span class="data">0.00</span>
                                            </div>
                                            <p class="timestamp">Added 5 hours ago</p>
                                        </div>
                                    </a>
                                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                                </div>
                                <div class="fav listing">
                                    <a href="/admin/manage-listing.html">
                                        <div class="thumb"></div>
                                        <div class="details">
                                            <h3 class="txt-single-line">Listing name</h3>
                                            <div class="location">
                                                <span class="spec">Location,</span>
                                                <span class="spec">Location,</span>
                                                <span class="spec">Location</span>
                                            </div>
                                            <p class="timestamp">Added 5 hours ago</p>
                                            <div class="info-rating-grp">
                                                <p class="rating">Rating: 4.0/5</p>
                                                <div class="stars">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                                </div>
                                <div class="fav topic">
                                    <a href="../view-topic.html">
                                        <h3 class="title-main txt-single-line">Listing a property - Get started</h3>
                                        <p class="text-main txt-six-line">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Non ipsam impedit ut, harum dicta molestiae laudantium et
                                        totam doloribus molestias cum ducimus fuga. Sunt natus, iste consequuntur eaque officiis ad omnis voluptatem quasi,
                                        consequatur repudiandae similique, quis nemo eius. Reiciendis voluptates error numquam ipsam adipisci perferendis libero
                                        aspernatur excepturi eligendi beatae blanditiis asperiores earum, repellendus, sunt voluptatem illo corrupti praesentium
                                        debitis architecto autem unde, eaque enim fugit deleniti. Nobis repellendus aliquid perspiciatis, dolorum facilis earum
                                        asperiores quo rerum, quisquam rem facere quos voluptas consequuntur unde ipsum exercitationem ad! Ab delectus
                                        voluptates fuga amet quia blanditiis numquam. Dolores fugit atque at!</p>
                                    </a>
                                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                                </div>
                                <div class="fav topic">
                                    <a href="../view-topic.html">
                                        <h3 class="title-main txt-single-line">Listing a property - Get started</h3>
                                        <p class="text-main txt-six-line">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Non ipsam impedit ut, harum dicta molestiae laudantium et
                                        totam doloribus molestias cum ducimus fuga. Sunt natus, iste consequuntur eaque officiis ad omnis voluptatem quasi,
                                        consequatur repudiandae similique, quis nemo eius. Reiciendis voluptates error numquam ipsam adipisci perferendis libero
                                        aspernatur excepturi eligendi beatae blanditiis asperiores earum, repellendus, sunt voluptatem illo corrupti praesentium
                                        debitis architecto autem unde, eaque enim fugit deleniti. Nobis repellendus aliquid perspiciatis, dolorum facilis earum
                                        asperiores quo rerum, quisquam rem facere quos voluptas consequuntur unde ipsum exercitationem ad! Ab delectus
                                        voluptates fuga amet quia blanditiis numquam. Dolores fugit atque at!</p>
                                    </a>
                                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-more">
                        <a href="/admin/account-activity-log.html">View more <i class="fas fa-chevron-right"></i></a>
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
import UpdateForm from '../Modals/EditUserAccount.vue'
import UpdateBrand from '../Modals/EditBrand.vue'
import CreateBrand from '../Modals/CreateBrand.vue'
import CardUser from '../Cards/User1.vue';
import CardBrand from '../Cards/Brand1.vue'
import { onMounted, ref } from 'vue';

const user = ref({})

const props = defineProps(['modal'])
const updateFormRef = ref(null);
const updateBrandRef = ref(null);
const createBrandRef = ref(null)

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
})

</script>
<style scoped>
.showcase-overlay .action-buttons i {
    color: #fff;
}
</style>