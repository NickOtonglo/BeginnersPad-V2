<template>
    <div v-if="data" class="dash-grp" id="dashListings">
        <h5 class="grp-label">Listings</h5>
        <div class="items">
            <div class="item card item-primary">
                <p>Highest listed zone</p>
                <h4>{{ data.zone_highest_listed }}</h4>
            </div>
            <div class="item card item-tertiary">
                <p>Highest listed sub-zone</p>
                <h4>{{ data.sub_zone_highest_listed }}</h4>
            </div>
            <div class="item card item-primary">
                <p>Highest rated zone</p>
                <h4 v-if="data.zones_highest_ratings">{{ data.zones_highest_ratings[0] }} ({{ data.zones_highest_ratings[1] }}<i class="fa-solid fa-star"></i>)</h4>
            </div>
            <div class="item card item-success">
                <p>Av. rent in highest rated zone</p>
                <h4>KES {{ data.zones_highest_ratings_average_rent }}K</h4>
            </div>
            <div class="item card item-secondary">
                <p>Cheapest zone av. rent</p>
                <h4 v-if="data.zones_cheapest_rent">{{ data.zones_cheapest_rent[0] }} (KES {{ data.zones_cheapest_rent[1] }}K)</h4>
            </div>
        </div>
        <div class="charts">
            <div class="chart">
                <canvas id="chartDashListingsBeginner" width="250" height="300"></canvas>
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
    <div class="dash-grp" id="dashMyListings">
        <h5 class="grp-label">My listings</h5>
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
                <p>Average rating</p>
                <h2>{{ data.listings_average_rating }}</h2>
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
</template>

<script setup>
const props = defineProps({
    data: Object,
})
</script>