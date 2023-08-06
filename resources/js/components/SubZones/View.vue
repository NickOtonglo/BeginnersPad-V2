<template>
    <h3 class="section-title">Sub-zone name</h3>

    <section class="section-zones" id="sectionViewZone">
        <div class="container">
            <div class="panel-grp">
                <div class="panel">
                    <div class="zone-map">
                        <div id="map"></div>
                    </div>
                    <div class="panel-item bordered">
                        <div class="title-grp">
                            <h3>Sub-zone details</h3>
                            <div class="info-actions">
                                <a href="#">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        <div class="data">
                            <ul>
                                <li>Sub-zone name (ID <span>000</span>)</li>
                                <li>County: <span> KE</span></li>
                                <li>County: <span>county name</span></li>
                                <li>Zone: <span>zone name (ID 000)</span></li>
                                <li>Role/nature: <span>role</span></li>
                                <li>Coordinates: <span>0.000, 0.000</span></li>
                                <li>Area radius: <span>0 km</span></li>
                                <li>Timezone: <span>GMT +3</span></li>
                                <li>Added on: <span>01-01-2021 00:00:00</span></li>
                                <li>Listings: <span>0</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="section-more">
                        <a href="/admin/manage-zone.html"><i class="fas fa-chevron-left"></i> View zone</a>
                    </div>
                    <div class="charts">
                        <h3>Relative occupancy chart</h3>
                        <div class="chart" style="height: 300px;width: 250px;">
                            <canvas id="chartDashListingsBeginner" width="250" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div class="listing-units-list">
                        <h3>Listings in this sub-zone</h3>
                        <div class="listing-units-grp" id="sectionZoneListingUnits">
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
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
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
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
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: not rated</p>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
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
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
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
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: not rated</p>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: not rated</p>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
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
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
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
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
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
                            </div>
                        </div>
                        <div class="section-more">
                            <a href="/admin/listing-applications.html">View more <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>