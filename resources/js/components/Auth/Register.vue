<template>
    <section class="section-auth">
        <div class="container">
             <!-- Form -->
            <div class="auth-form">
                <h3 class="section-title">Sign in</h3>
                <form>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="username">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" >
                            <p class="form-check-label">Remember me</p>
                        </div>
                    </div>
                    <input class="btn-submit" type="button" value="Sign in">
                    <div class="link-forgot-password">
                        <a href="#">Forgot your password?</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>