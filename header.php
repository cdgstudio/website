<!DOCTYPE html>
<head <?= get_language_attributes() ?>>

    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width"/>
    <title><?php wp_title('|', true, 'right') ?><?= get_option('blogname') ?></title>
    <link rel="profile" href="https://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/style.css'; ?>">

    <link rel="profile" href="https://gmpg.org/xfn/11"/>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<style>
    .header-nav {
        display: flex;
        flex-flow: column;
    }

    .header-nav > :first-child {
        flex: 0 0 50%;
    }

    @media (min-width: 768px) {
        .header-nav {
            justify-content: space-between;
            align-items: center;
            flex-flow: row;
        }
    }

</style>

<nav class="container header-nav">
    <div>
        <a href="<?php echo get_home_url() ?>" style="font-size: 2.5rem; color: #fff"><?= get_bloginfo('name') ?></a>
        <p style="margin: 0"><?= get_bloginfo('description') ?></p>
    </div>
    <style>
        #menu_gorne ul {
            padding: 0;
            list-style: none;
            display: flex;
            gap: 2rem;
        }
    </style>
    <?php
    wp_nav_menu(array(
        'theme_location' => 'main-menu',
        'fallback_cb' => '__return_false',
        'container_id' => 'menu_gorne',
        'depth' => 0,
    ));
    ?>
</nav>


<style>
    #jumbo {
        padding-top: 120px;
        padding-bottom: 120px;
        position: relative;
    }

    #jumbo > h1 {
        text-align: center;
    }
</style>

<div id="jumbo" class="container">
    <?php if (is_singular()): ?>
        <h1><?php the_title() ?></h1>
    <?php endif; ?>

    <?php $excerpt = get_the_excerpt() ?>
    <?php if (empty($excerpt) === false && is_single()): ?>
        <p><?php the_excerpt() ?></p>
    <?php endif; ?>


    <?php if (is_category()): ?>
        <h1><?= get_cat_name(get_queried_object_id()) ?></h1>
    <?php endif; ?>
    <?php if (is_category() && category_description()): ?>
        <p><?= category_description() ?></p>
    <?php endif; ?>


    <?php if (is_tag()): ?>
        <h1><?= get_tag(get_queried_object_id())->name ?></h1>
    <?php endif; ?>
    <?php if (is_tag() && tag_description()): ?>
        <p><?= tag_description() ?></p>
    <?php endif; ?>

    <?php if (is_search() || is_home()): ?>
        <?= get_search_form() ?>
    <?php endif; ?>
</div>
