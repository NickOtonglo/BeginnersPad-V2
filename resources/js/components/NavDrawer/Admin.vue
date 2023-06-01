<template>
    <div class="nav-drawer closed" id="navDrawer">
        <i id="navDrawerClose" class="fas fa-times fa-2x"></i>
        <div class="nav-drawer-category">
            <ul>
                <li><a href="/help.html"><i class="fas fa-question-circle"></i> Help</a></li>
                <li><a href="#"><i class="fas fa-user-circle"></i> Manage account</a></li>
                <li><a href="/sign-in.html"><i class="fas fa-sign-out-alt"></i> Sign out</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>Menu</p>
            <ul>
                <li><a href="/admin/dashboard.html">Dashboard</a></li>
                <li class="selected"><a href="/admin/bookmarks.html">Bookmarks</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>Listings</p>
            <ul>
                <li><a href="/admin/view-listings.html">View all</a></li>
                <li><a href="/admin/manage-listings.html">Manage</a></li>
                <li><a href="/admin/manage-listings-logs.html">Listing management log</a></li>
                <li><a href="/admin/manage-listings-reviews.html">Manage reviews</a></li>
                <li><a href="/admin/listing-applications.html">Applications</a></li>
                <li><a href="/admin/listing-applications-logs.html">Application management log</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>Users</p>
            <ul>
                <li><a href="/view-users.html">View all</a></li>
                <li><a href="/admin/manage-users.html">Manage</a></li>
                <li><a href="/admin/manage-users-logs.html">Management log</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>Zones</p>
            <ul>
                <li><a href="/admin/manage-zones.html">Manage</a></li>
                <li><a href="/admin/manage-zones-logs.html">Management log</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>Tags & topics</p>
            <ul>
                <li><a href="/view-topics.html">View topics</a></li>
                <li><a href="/admin/manage-topics.html">Manage topics</a></li>
                <li><a href="/admin/manage-topics-logs.html">Topic management log</a></li>
                <li><a href="/admin/manage-tags.html">Manage tags</a></li>
                <li><a href="/admin/manage-tags-logs.html">Tag management log</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>Help & tickets</p>
            <ul>
                <li><a href="/admin/view-tickets.html">View tickets</a></li>
                <li><a href="/admin/manage-tickets-log.html">Ticket management log</a></li>
                <li><a href="/admin/manage-help-categories.html">Manage help categories</a></li>
                <li><a href="/admin/manage-faqs.html">Manage FAQs</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>System</p>
            <ul>
                <li><a href="#">Manage</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">System logs</a></li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import operateNavDrawer from '../../composables/nav-drawer';

onMounted(() => {
    operateNavDrawer()
})

</script>