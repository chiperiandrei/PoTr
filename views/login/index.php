<?php require_once('views/components/meta.php'); ?>

    <link rel="stylesheet" href="/public/css/login.css">
    <link rel="stylesheet" href="/public/css/flags.min.css">

<?php require_once('views/login/components/header.php'); ?>

    <main>
        <div class="container">
            <div class="introduction">
                <h1>The poems of the week</h1>
                <article>
                    <div class="poem-infos">
                        <h1 class="poem-title">
                            <a href="<?php echo $this->poemOne['link']; ?>">
                                <?php echo $this->poemOne['title']; ?>
                            </a>
                        </h1>
                        <h4 class="poem-author">
                            <a href="<?php echo $this->poemOne['author_link']; ?>">
                                <?php echo $this->poemOne['author_name']; ?>
                            </a>
                        </h4>
                    </div>
                    <div class="poem-strophe">
                        <pre><?php echo $this->poemOne['content']; ?></pre>
                        <a href="<?php echo $this->poemOne['link']; ?>" class="poem-read-more">[Read more]</a>
                    </div>
                    <span class="poem-language">
                <img src="public/img/flags/blank.gif"
                     class="flag flag-<?php echo $this->poemOne['language']; ?>"
                     alt="<?php echo $this->poemOne['language']; ?>">
            </span>
                </article>
                <article>
                    <div class="poem-infos">
                        <h1 class="poem-title">
                            <a href="<?php echo $this->poemTwo['link']; ?>">
                                <?php echo $this->poemTwo['title']; ?>
                            </a>
                        </h1>
                        <h4 class="poem-author">
                            <a href="<?php echo $this->poemTwo['author_link']; ?>">
                                <?php echo $this->poemTwo['author_name']; ?>
                            </a>
                        </h4>
                    </div>
                    <div class="poem-strophe">
                        <pre><?php echo $this->poemTwo['content']; ?></pre>
                        <a href="<?php echo $this->poemTwo['link']; ?>" class="poem-read-more">[Read more]</a>
                    </div>
                    <span class="poem-language">
                <img src="public/img/flags/blank.gif"
                     class="flag flag-<?php echo $this->poemTwo['language']; ?>"
                     alt="<?php echo $this->poemTwo['language']; ?>">
            </span>
                </article>
            </div>
            <form action="/login/connect" method="POST">
                <div class="login">
                    <h1>Connect with Us</h1>
                    <div class="login-text">
                        <label for="email">Email:</label>
                        <input type="email" name="email" placeholder="jhon.doe@example.com" required>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="login-text">
                        <label for="password">Password:</label>
                        <input type="password" name="password" placeholder="*******" required>
                        <i class="fas fa-key"></i>
                    </div>
                    <div>
                        <span id="forgot-password-on">Forgot password?</span>
                        <button type="submit" id="login">Login</button>
                    </div>
                    <?php if (Session::exists('error-login')) : ?>
                    <div>
                        <span id="login-error">
                            <?php Session::print('error-login'); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if (Session::exists('error-register')) : ?>
                    <div>
                        <span id="login-error">
                            <?php Session::print('error-register'); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if (Session::exists('password-not-same')) : ?>
                    <div>
                        <span id="login-error">
                            <?php Session::print('password-not-same'); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if (Session::exists('email-is-used')) : ?>
                    <div>
                        <span id="login-error">
                            <?php Session::print('email-is-used'); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if (Session::exists('captcha-wrong')) : ?>
                    <div>
                        <span id="login-error">
                            <?php Session::print('captcha-wrong'); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if (Session::exists('log-register')) : ?>
                    <div>
                        <span id="login-ok">
                            <?php Session::print('log-register'); ?>
                        </span>
                        </div>
                    <?php endif; ?>
                    <?php if (Session::exists('cui')) : ?>
                    <div>
                        <span id="login-ok">
                            We sent an email at <?php Session::print('cui'); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <div>
                        <span id="create-account-on">
                            <i class="fas fa-user-plus"></i>Create account
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </main>

<?php require_once('views/login/components/create-account.php'); ?>
<?php require_once('views/login/components/forgot-password.php'); ?>

    <script src="public/js/login.js" type="text/javascript"></script>

<?php require_once('views/components/footer.php'); ?>