<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="site-header" id="site-header">
        <div class="container site-header__inner">

            <div class="site-header__logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__logo-link">
                    <img class="site-header__logo-image"
                        src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo-buczek-poleruje.png'); ?>"
                        alt="Buczek Poleruje">
                </a>
            </div>

            <nav class="site-header__nav" aria-label="Główna nawigacja">
                <ul class="nav">
                    <li class="nav__item"><a class="nav__link is-active" href="#top">Start</a></li>
                    <li class="nav__item"><a class="nav__link" href="#realizacje">Efekty</a></li>
                    <li class="nav__item"><a class="nav__link" href="#uslugi">Usługi</a></li>
                    <li class="nav__item"><a class="nav__link" href="#wycena">Wycena</a></li>
                    <li class="nav__item"><a class="nav__link" href="#kontakt">Kontakt</a></li>
                </ul>
            </nav>

            <a href="#kontakt" class="btn btn--primary site-header__cta">
                Napisz
            </a>

            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu"
                aria-label="Otwórz menu">
                <span class="menu-toggle__line"></span>
                <span class="menu-toggle__line"></span>
                <span class="menu-toggle__line"></span>
            </button>

        </div>
    </header>

    <div class="mobile-menu" id="mobile-menu" aria-hidden="true">
        <div class="mobile-menu__overlay"></div>

        <div class="mobile-menu__panel">
            <div class="mobile-menu__top">
                <span class="mobile-menu__brand">Buczek Poleruje</span>

                <button class="mobile-menu__close" type="button" aria-label="Zamknij menu">
                    ✕
                </button>
            </div>

            <nav class="mobile-menu__nav" aria-label="Mobilna nawigacja">
                <ul class="mobile-menu__list">
                    <li><a class="mobile-menu__link" href="#top">Start</a></li>
                    <li><a class="mobile-menu__link" href="#uslugi">Usługi</a></li>
                    <li><a class="mobile-menu__link" href="#realizacje">Efekty</a></li>
                    <li><a class="mobile-menu__link" href="#wycena">Wycena</a></li>
                    <li><a class="mobile-menu__link" href="#kontakt">Kontakt</a></li>
                </ul>
            </nav>

            <div class="mobile-menu__actions">
                <a class="btn btn--primary" href="tel:+48668974402">Zadzwoń</a>
                <a class="btn btn--ghost" href="https://instagram.com/buczek.poleruje" target="_blank"
                    rel="noopener noreferrer">
                    Instagram
                </a>
            </div>
        </div>
    </div>
