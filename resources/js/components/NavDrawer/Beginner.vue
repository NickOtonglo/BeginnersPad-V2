<template>
    <div class="nav-drawer-category">
        <p>Menu</p>
        <ul>
            <li class="selected"><a href="/beginner/dashboard.html">Dashboard</a></li>
            <li><a href="/beginner/view-listings.html">Listings</a></li>
            <li><a href="/beginner/tour-appointments.html">Tour appointments</a></li>
            <li><a href="/reviews">My reviews</a></li>
            <li><a href="/favourites">Favourites</a></li>
            <!-- <li><router-link :to="{ name: 'favourites.index' }">Favourites</router-link></li> -->
            <li><a href="/beginner/property-history.html">Property history</a></li>
            <li><a href="/beginner/view-tickets.html">My tickets</a></li>
        </ul>
    </div>
    <div class="nav-drawer-category">
        <p>Premium</p>
        <ul>
            <li><a href="/beginner/waiting-list.html">Waiting list <i class="fas fa-star"></i></a></li>
        </ul>
    </div>
</template>