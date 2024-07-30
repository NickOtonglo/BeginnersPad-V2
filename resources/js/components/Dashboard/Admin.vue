<template>
    <div class="dash-grp" id="dashListings">
        <h5 class="grp-label">Listings</h5>
        <div class="items">
            <div class="item card item-primary">
                <p>All</p>
                <h2>{{ data.listings_all }}</h2>
            </div>
            <div class="item card item-warning">
                <p>Unsubmitted</p>
                <h2>{{ data.listings_unsubmitted }}</h2>
            </div>
            <div class="item card item-tertiary">
                <p>Pending</p>
                <h2>{{ data.listings_pending }}</h2>
            </div>
            <div class="item card item-success">
                <p>Published</p>
                <h2>{{ data.listings_published }}</h2>
            </div>
            <div class="item card item-danger">
                <p>Rejected</p>
                <h2>{{ data.listings_rejected }}</h2>
            </div>
            <div class="item card item-danger">
                <p>Suspended</p>
                <h2>{{ data.listings_suspended }}</h2>
            </div>
            <div class="item card item-warning">
                <p>Hidden</p>
                <h2>{{ data.listings_hidden }}</h2>
            </div>
            <div class="item card item-secondary">
                <p>Total average rating</p>
                <h2>{{ data.listings_average_rating }}<i class="fa-solid fa-star"></i></h2>
            </div>
        </div>
        <div class="items">
            <div class="item card item-primary">
                <p>All units</p>
                <h2>{{ data.listings_units_all }}</h2>
            </div>
            <div class="item card item-warning">
                <p>Inactive/hidden units</p>
                <h2>{{ data.listings_units_hidden }}</h2>
            </div>
        </div>
        <div class="charts">
            <div class="chart">
                <canvas id="chartDashBeginnerFavs" width="250" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="dash-grp" id="dashFavourites">
        <h5 class="grp-label">Favourites</h5>
        <div class="items">
            <div class="item card item-secondary">
                <p>Listings</p>
                <h2>{{ data.favourites_properties }}</h2>
            </div>
            <div class="item card item-primary">
                <p>Units</p>
                <h2>{{ data.favourites_units }}</h2>
            </div>
            <div class="item card item-tertiary">
                <p>Articles</p>
                <h2>{{ data.favourites_articles }}</h2>
            </div>
        </div>
        <div class="charts">
            <div class="chart">
                <canvas id="chartDashBeginnerFavs" width="250" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="dash-grp" id="dashReviews">
        <h5 class="grp-label">Reviews</h5>
        <div class="items">
            <div class="item card item-primary">
                <p>Reviews done</p>
                <h2>{{ data.reviews_posted }}</h2>
            </div>
            <div class="item card item-danger">
                <p>Reviews removed</p>
                <h2>{{ data.reviews_removed }}</h2>
            </div>
        </div>
        <div class="items">
            <div class="item card item-danger">
                <p><template v-for="index in 1"><i class="fa-solid fa-star"></i></template> ratings</p>
                <h2>{{ data.reviews_rating_dist_1 }}</h2>
            </div>
            <div class="item card item-primary">
                <p><template v-for="index in 2"><i class="fa-solid fa-star"></i></template> ratings</p>
                <h2>{{ data.reviews_rating_dist_2 }}</h2>
            </div>
            <div class="item card item-warning">
                <p><template v-for="index in 3"><i class="fa-solid fa-star"></i></template> ratings</p>
                <h2>{{ data.reviews_rating_dist_3 }}</h2>
            </div>
            <div class="item card item-tertiary">
                <p><template v-for="index in 4"><i class="fa-solid fa-star"></i></template> ratings</p>
                <h2>{{ data.reviews_rating_dist_4 }}</h2>
            </div>
            <div class="item card item-success">
                <p><template v-for="index in 5"><i class="fa-solid fa-star"></i></template> ratings</p>
                <h2>{{ data.reviews_rating_dist_5 }}</h2>
            </div>
        </div>
        <div class="charts">
            <div class="chart">
                <canvas id="chartDashReviewsBeginner" width="250" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="dash-grp" id="dashUsers">
        <h5 class="grp-label">Users</h5>
        <div class="items">
            <div class="item card item-secondary">
                <p>All</p>
                <h2>{{ data.users_all }}</h2>
            </div>
            <div class="item card item-primary">
                <p>Admins</p>
                <h2>{{ data.users_admins }}</h2>
            </div>
            <div class="item card item-tertiary">
                <p>Listers</p>
                <h2>{{ data.users_listers }}</h2>
            </div>
            <div class="item card item-tertiary">
                <p>Beginners</p>
                <h2>{{ data.users_beginners }}</h2>
            </div>
            <div class="item card item-tertiary">
                <p>Others</p>
                <h2>{{ data.users_others }}</h2>
            </div>
        </div>
        <div class="charts">
            <div class="chart">
                <canvas id="chartDashBeginnerFavs" width="250" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="dash-grp" id="dashTickets">
        <h5 class="grp-label">Tickets</h5>
        <div class="items">
            <div class="item card item-primary">
                <p>Submitted</p>
                <h2>{{ data.tickets_all }}</h2>
            </div>
            <div class="item card item-warning">
                <p>Pending</p>
                <h2>{{ data.tickets_pending }}</h2>
            </div>
            <div class="item card item-success">
                <p>Resolved</p>
                <h2>{{ data.tickets_resolved }}</h2>
            </div>
            <div class="item card item-tertiary">
                <p>Open</p>
                <h2>{{ data.tickets_open }}</h2>
            </div>
            <div class="item card item-danger">
                <p>Closed</p>
                <h2>{{ data.tickets_closed }}</h2>
            </div>
        </div>
        <div class="charts">
            <div class="chart">
                <canvas id="chartDashTicketsBeginner" width="250" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="dash-grp" id="dashZones">
        <h5 class="grp-label">Zones</h5>
        <div class="items">
            <div class="item card item-secondary">
                <p>All</p>
                <h2>{{ data.zones_all }}</h2>
            </div>
            <div class="item card item-tertiary">
                <p>All sub-zones</p>
                <h2>{{ data.zones_sub_all }}</h2>
            </div>
            <div class="item card item-primary">
                <p>Highest listed</p>
                <h4>{{ data.zone_highest_listed }}</h4>
            </div>
            <div class="item card item-tertiary">
                <p>Highest listed sub-zone</p>
                <h4>{{ data.sub_zone_highest_listed }}</h4>
            </div>
            <div class="item card item-primary">
                <p>Highest rated</p>
                <h4 v-if="data.zones_highest_ratings">{{ data.zones_highest_ratings[0] }} ({{ data.zones_highest_ratings[1] }}<i class="fa-solid fa-star"></i>)</h4>
            </div>
            <div class="item card item-success">
                <p>Av. rent in highest rated</p>
                <h4>KES {{ data.zones_highest_ratings_average_rent }}K</h4>
            </div>
            <div class="item card item-primary">
                <p>Av. rent in cheapest zone</p>
                <h4 v-if="data.zones_cheapest_rent">{{ data.zones_cheapest_rent[0] }} (KES {{ data.zones_cheapest_rent[1] }}K)</h4>
            </div>
        </div>
        <div class="charts">
            <div class="chart">
                <canvas id="chartDashTicketsBeginner" width="250" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="dash-grp" id="dashWaitingList">
        <h5 class="grp-label">Waiting list</h5>
        <div class="items">
            <div v-if="data.waiting_list_most_popular_list_1" class="item card item-tertiary">
                <p>Most popular waiting list</p>
                <h4>{{ data.waiting_list_most_popular_list_1 }}</h4>
            </div>
            <div v-if="data.waiting_list_most_popular_list_2" class="item card item-primary">
                <p>2<sup>nd</sup> Most popular waiting list</p>
                <h4>{{ data.waiting_list_most_popular_list_2 }}</h4>
            </div>
            <div v-if="data.waiting_list_most_popular_list_3" class="item card item-secondary">
                <p>3<sup>rd</sup> Most popular waiting list</p>
                <h4>{{ data.waiting_list_most_popular_list_3 }}</h4>
            </div>
            <div class="item card item-primary">
                <p>Active listings on waiting lists</p>
                <h2>{{ data.waiting_list_property_listings_active }}</h2>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    data: Object,
})
</script>