<template>
    <section class="section-help">
        <div class="container">
            <!-- FAQs and Topics -->
            <div class="help-links">
                <div class="help-faqs">
                    <h3 class="section-title">Frequently asked questions</h3>
                    <div class="link-item">
                        <h4>What is Beginners Pad?</h4>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Earum consequatur at iure. Soluta consequatur, earum
                            voluptates debitis neque similique id voluptatibus natus? Eaque tenetur laborum exercitationem, minus libero,
                            repellendus rem tempore explicabo voluptate corrupti totam. Quo id provident ullam dolorem nostrum corporis ipsa
                            eius consequuntur...</p>
                        <a href="#">See more <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="link-item">
                        <h4>How can I find my next house?</h4>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Earum consequatur at iure. Soluta consequatur, earum
                            voluptates debitis neque similique id voluptatibus natus? Eaque tenetur laborum exercitationem, minus libero,
                            repellendus rem tempore explicabo voluptate corrupti totam. Quo id provident ullam dolorem nostrum corporis ipsa
                            eius consequuntur...</p>
                            <a href="#">See more <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="link-item">
                        <h4>How can I list my property?</h4>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Earum consequatur at iure. Soluta consequatur, earum
                            voluptates debitis neque similique id voluptatibus natus? Eaque tenetur laborum exercitationem, minus libero,
                            repellendus rem tempore explicabo voluptate corrupti totam. Quo id provident ullam dolorem nostrum corporis ipsa
                            eius consequuntur...</p>
                            <a href="#">See more <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="section-more">
                        <router-link :to="{ name: 'help.faq' }">View all FAQs <i class="fas fa-chevron-right"></i></router-link>
                    </div>
                </div>
                <div class="help-topics">
                    <h3 class="section-title">Help topics</h3>
                    <div class="link-item">
                        <h4>Listing a property - Get started</h4>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Earum consequatur at iure. Soluta consequatur, earum
                            voluptates debitis neque similique id voluptatibus natus? Eaque tenetur laborum exercitationem, minus libero,
                            repellendus rem tempore explicabo voluptate corrupti totam. Quo id provident ullam dolorem nostrum corporis ipsa
                            eius consequuntur...</p>
                        <a href="#">See more <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="link-item">
                        <h4>Choosing a new house - Get started</h4>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Earum consequatur at iure. Soluta consequatur, earum
                            voluptates debitis neque similique id voluptatibus natus? Eaque tenetur laborum exercitationem, minus libero,
                            repellendus rem tempore explicabo voluptate corrupti totam. Quo id provident ullam dolorem nostrum corporis ipsa
                            eius consequuntur...</p>
                        <a href="#">See more <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="link-item">
                        <h4>Waiting list - Get started</h4>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Earum consequatur at iure. Soluta consequatur, earum
                            voluptates debitis neque similique id voluptatibus natus? Eaque tenetur laborum exercitationem, minus libero,
                            repellendus rem tempore explicabo voluptate corrupti totam. Quo id provident ullam dolorem nostrum corporis ipsa
                            eius consequuntur...</p>
                        <a href="#">See more <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="section-more">
                        <a href="/view-topics.html">View all Help topics <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <div class="help-form">
                <h3 class="section-title">Contact representative</h3>
                <form>
                    <div class="form-group">
                        <label for="email">Email address*</label>
                        <input type="email" name="Email address" id="email">
                    </div>
                    <div class="form-group">
                        <label for="help_category">Help category*</label>
                        <select name="Help category" id="help_category">
                            <option value="" selected>--select category--</option>
                            <option value="billing">Billing</option>
                            <option value="my_account">My account</option>
                            <option value="request_account_closure">Request account closure</option>
                            <option value="unable_to_login">Unable to sign in</option>
                            <option value="account_suspended">Account suspended</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Text (describe problem in detail)*</label>
                        <textarea name="description" id="description" cols="30" rows="10"></textarea>
                    </div>
                    <input class="btn btn-link btn-submit" type="button" value="Submit">
                </form>
                <div class="section-more">
                    <a href="/view-tickets-user.html">Sample tickets as user <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="section-more">
                    <a href="/view-tickets-admin.html">Sample tickets as admin <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup></script>