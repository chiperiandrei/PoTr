<?php require_once('views/components/meta.php'); ?>

<link rel="stylesheet" href="/public/css/main.css">
<link rel="stylesheet" href="/public/css/flags.min.css">

<?php require_once('views/components/header.php'); ?>

<main>
    <div class="container">
        <section class="main-poems">
            <section>
                <?php for($i = 0; $i < $this->count; $i += 2) : ?>
                    <article>
                        <div class="poem">
                            <?php if (Session::exists('user_id')) :
                                if ($this->poems[$i]['favorite'] == true) : ?>
                                    <span class="poem-bookmark"
                                          onclick="setFavorites(this, <?php echo $this->poems[$i]['id']; ?>, 'delete')">
                                    <i class="fas fa-bookmark"></i>
                                </span>
                                <?php else : ?>
                                    <span class="poem-bookmark"
                                          onclick="setFavorites(this, <?php echo $this->poems[$i]['id']; ?>, 'add')">
                                    <i class="far fa-bookmark"></i>
                                </span>
                                <?php endif;
                            endif; ?>
                            <h1 class="poem-title">
                                <a href="<?php echo $this->poems[$i]['link']; ?>">
                                    <?php echo $this->poems[$i]['title']; ?>
                                </a>
                            </h1>
                            <h4 class="poem-author">
                                <a href="<?php echo $this->poems[$i]['author_link']; ?>">
                                    <?php echo $this->poems[$i]['author_name']; ?>
                                </a>
                            </h4>
                        </div>
                        <div class="poem-strophe">
                            <pre><?php echo $this->poems[$i]['content']; ?></pre>
                            <a href="<?php echo $this->poems[$i]['link']; ?>" class="poem-read-more">[Read more]</a>
                        </div>
                        <span class="poem-language">
                            <img src="/public/img/flags/blank.gif"
                                 class="flag flag-<?php echo $this->poems[$i]['language']; ?>"
                                 alt="<?php echo $this->poems[$i]['language']; ?>">
                        </span>
                    </article>
                <?php endfor; ?>
            </section>
            <section>
                <?php for($i = 1; $i < $this->count; $i += 2) : ?>
                    <article>
                        <div class="poem">
                            <?php if (Session::exists('user_id')) :
                                if ($this->poems[$i]['favorite'] == true) : ?>
                                    <span class="poem-bookmark"
                                          onclick="setFavorites(this, <?php echo $this->poems[$i]['id']; ?>, 'delete')">
                                    <i class="fas fa-bookmark"></i>
                                </span>
                                <?php else : ?>
                                    <span class="poem-bookmark"
                                          onclick="setFavorites(this, <?php echo $this->poems[$i]['id']; ?>, 'add')">
                                    <i class="far fa-bookmark"></i>
                                </span>
                                <?php endif;
                            endif; ?>
                            <h1 class="poem-title">
                                <a href="<?php echo $this->poems[$i]['link']; ?>">
                                    <?php echo $this->poems[$i]['title']; ?>
                                </a>
                            </h1>
                            <h4 class="poem-author">
                                <a href="<?php echo $this->poems[$i]['author_link']; ?>">
                                    <?php echo $this->poems[$i]['author_name']; ?>
                                </a>
                            </h4>
                        </div>
                        <div class="poem-strophe">
                            <pre><?php echo $this->poems[$i]['content']; ?></pre>
                            <a href="<?php echo $this->poems[$i]['link']; ?>" class="poem-read-more">[Read more]</a>
                        </div>
                        <span class="poem-language">
                            <img src="/public/img/flags/blank.gif"
                                 class="flag flag-<?php echo $this->poems[$i]['language']; ?>"
                                 alt="<?php echo $this->poems[$i]['language']; ?>">
                        </span>
                    </article>
                <?php endfor; ?>
            </section>

        </section>
    </div>
</main>

<script src="/public/js/main.js" type="text/javascript"></script>

</body>
</html>