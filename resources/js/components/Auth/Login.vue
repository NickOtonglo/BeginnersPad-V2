<template>
    <section class="section-auth">
        <div class="container">
             <!-- Form -->
            <div class="auth-form">
                <h3 class="section-title">Sign up</h3>
                <form id="form-auth">
                    <div class="form-group">
                        <div class="grp-name">
                            <label for="fname">First name</label>
                            <input type="text" name="fname" id="fname">
                        </div>
                        <div class="grp-name">
                            <label for="lname">Last name</label>
                            <input type="text" name="lname" id="lname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="telephone">Phone number (+254xxxxxxxxx)</label>
                        <input type="text" name="telephone" id="telephone">
                    </div>
                    <div class="form-group">
                        <label for="username">Username (must be unique)</label>
                        <input type="text" name="username" id="username">
                    </div>
                    <div class="form-group">
                        <label for="user_type">Account type</label>
                        <select name="user_type" id="user_type">
                            <option value="" selected>--select account type--</option>
                            <option value="5">Customer</option>
                            <option value="4">Property lister</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="username">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms" >
                            <p class="form-check-label">
                                I agree to the <a href="#">Terms and Conditions of Beginners Pad</a>
                            </p>
                        </div>
                    </div>
                    <input class="btn btn-submit" type="button" value="Sign up">
                </form>
            </div>
        </div>
    </section>
</template>