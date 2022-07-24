<style>
    @media (max-width: 600px) {
        #site-footer > .container {
            display: flex;
            flex-direction: column;
        }
    }
    #site-footer {
        text-align: center;
        padding: 15px;
        background-color: rgb(47 51 55 / 80%);
        font-size: 0.8rem;
        margin-top: 5rem;
    }

    #site-footer > .container {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
    }
</style>

<footer id="site-footer">
    <div class="container">
        <span>
            <?= __('The site is proudly supported by', 'cg') ?>
            <a href="https://wordpress.org">WordPress</a>
        </span>
        <span>
            <?= __('Theme written from scratch.', 'cg') ?>
            <?= __('Available on', 'cg') ?>
            <a href="https://github.com/angularcodegen/website">GitHub</a>
        </span>
    </div>
</footer>


<?php
wp_footer();

?>

</body>
</html>
