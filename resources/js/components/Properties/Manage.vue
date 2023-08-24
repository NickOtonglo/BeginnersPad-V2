<template>
    <section class="section-listing-images">
        <div class="container">
            <div class="title-grp">
                <h3>Images</h3>
                <div class="info-actions">
                    <i id="btnImgFaux" class="fas fa-plus"></i>
                    <form action="">
                        <input class="file-path-wrapper" accept="image/*" name="btn_submit" id="btnImgReal" type="file" style="display: none;"/>
                    </form>
                </div>
            </div>
            <div class="image-grp">
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="title-grp">
                <h3>Thumbnail</h3>
                <div class="info-actions">
                    <i id="btnThumbFaux" class="fas fa-plus"></i>
                    <form action="">
                        <input class="file-path-wrapper" accept="image/*" name="btn_submit" id="btnThumbReal" type="file" style="display: none;"/>
                    </form>
                </div>
            </div>
            <div class="image-grp">
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section class="section-listing-primary">
        <div class="container">
            <h3>Primary information</h3>
            <div class="listing-info-main">
                <div class="info-name">
                    <h1 class="name">Name</h1>
                    <div class="info-actions">
                        <i id="modalTrigger1" class="fas fa-edit"></i>
                    </div>
                </div>
                <p class="location">Location, Location, Location</p>
            </div>
            <div class="listing-info-description">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur, assumenda nobis neque recusandae dicta distinctio
                libero. Culpa nostrum molestiae fugit explicabo nam, hic qui enim aperiam impedit ad, possimus similique ullam
                perspiciatis amet mollitia dolore inventore recusandae accusantium nulla, tempora dolorem deleniti reprehenderit. Natus
                similique, sequi hic quas delectus saepe iste dolores, cupiditate quaerat error ex dolore, et ad quis id facere ipsam ab
                libero voluptatem enim nemo. Dicta, nam?</p>
            </div>
        </div>
    </section>

    <section class="section-listing-secondary">
        <div class="container">        
            <div class="panel-grp">
                <div class="panel">
                    <div class="listing-units-list">
                        <div class="title-grp">
                            <h3>Units available</h3>
                            <div class="info-actions">
                                <!-- <a href="/lister/manage-listing-unit.html">
                                    <i class="fas fa-plus"></i>
                                </a> -->
                                <i id="modalTrigger" class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="listing-units-grp">
                            <div class="card-sm card-unit">
                                <a href="/lister/manage-listing-unit.html">
                                    <div class="details">
                                        <h2>Unit title</h2>
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
                                    <div class="thumb"></div>
                                </a>  
                            </div>
                            
                            <div class="card-sm card-unit">
                                <a href="/lister/manage-listing-unit.html">
                                    <div class="details">
                                        <h2>Unit title</h2>
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
                                    <div class="thumb"></div>
                                </a>  
                            </div>
                            
                            <div class="card-sm card-unit">
                                <a href="/lister/manage-listing-unit.html">
                                    <div class="details">
                                        <h2>Unit title</h2>
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
                                    <div class="thumb"></div>
                                </a>  
                            </div>
                            
                            <div class="card-sm card-unit">
                                <a href="/lister/manage-listing-unit.html">
                                    <div class="details">
                                        <h2>Unit title</h2>
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
                                    <div class="thumb"></div>
                                </a>  
                            </div>
                            
                            <div class="card-sm card-unit">
                                <a href="/lister/manage-unit.html">
                                    <div class="details">
                                        <h2>Unit title</h2>
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
                                    <div class="thumb"></div>
                                </a>  
                            </div>
                        </div>
                    </div>
                    <div class="lister-details">
                        <h3>Lister information</h3>
                        <div class="details">
                            <div class="header">
                                <div>
                                    <h2 class="name">Lister name</h2>
                                    <p class="timestamp">Joined on 01 Jan 2021</p>
                                </div>
                                <img src="/images/logo.png" alt="">
                            </div>
                            <p class="listings-count">6 listings posted</p>
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
                            <div class="section-more">
                                <a href="#">View profile <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div class="listing-features">
                        <div class="title-grp">
                            <h3>Communial features</h3>
                            <div class="info-actions">
                                <i id="modalTrigger2" class="fas fa-edit"></i>
                            </div>
                        </div>
                        <div class="features">
                            <ul>
                                <li>24-hour security</li>
                                <li>CCTV cameras</li>
                                <li>ample parking</li>
                                <li>auxilliary water supply</li>
                                <li>stand-by power generator</li>
                                <li>solar energy</li>
                                <li>house cleaning services</li>
                                <li>laundry services</li>
                            </ul>
                        </div>
                    </div>
                    <div class="listing-map">
                        <h3>Location</h3>
                        <div id="map"></div>
                    </div>
                    <div class="listing-actions">
                        <h3>Actions</h3>
                        <div class="btn-grp vertical">
                            <button>Submit for approval</button>
                            <button>Withdraw submission</button>
                            <button>Hide from public</button>
                            <button>Request removal from system</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal" id="modal">
        <div class="modal-header">
            <h2>Add unit</h2>
            <button id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form id="formCreateUnit">
                    <div class="form-group" id="grpName2">
                        <label for="unitName">Unit name*</label>
                        <input type="text" name="unitName" id="unitName">
                    </div>
                    <input id="btnCreateUnit" class="btn btn-submit" type="button" value="Create" onclick="initUnit();">
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button id="modalFooterClose" class="btn btn-link">Close</button>
        </div>
    </div>

    <div class="modal" id="modal1">
        <div class="modal-header">
            <h2>Edit listing info</h2>
            <button id="modalHeaderClose1" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form id="formUpdateListing">
                    <div class="form-group" id="grpName">
                        <label for="name">Listing name*</label>
                        <input type="text" name="name" id="name">
                    </div>
                    <div class="form-group" id="grpDescription">
                        <label for="description">Description*</label>
                        <textarea name="description" id="description" cols="30" rows="10"></textarea>
                    </div>
                    <input class="btn btn-submit" type="button" value="Update" onclick="initListing();">
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button id="modalFooterClose1" class="btn btn-link">Close</button>
        </div>
    </div>

    <div class="modal" id="modal2">
        <div class="modal-header">
            <h2>Communial features</h2>
            <button id="modalHeaderClose2" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form id="formUpdateListingFeatures">
                    <div class="form-group" id="grpFeatures">
                        <label for="features">Features (seperate each item with a semicolon)</label>
                        <textarea name="features" id="features" cols="30" rows="10"></textarea>
                    </div>
                    <input class="btn btn-submit" type="button" value="Update" onclick="initFeatures();">
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button id="modalFooterClose2" class="btn btn-link">Close</button>
        </div>
    </div>
</template>

<script setup>
import { useRoute } from 'vue-router';

const route = useRoute()

</script>