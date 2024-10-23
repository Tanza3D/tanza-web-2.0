<?php
\Site\Embed::SetDescription("I’m a designer and developer from the UK, working on projects such as osu!, UNTONE, Osekai, and many more! Learn about me here!");
\Site\Embed::SetTitle("Tanza");
\Site\Embed::SetBannerImage("/public/img/workbanner.png");
?>
<div class="header header-big">
    <div class="header-left">
        <div class="header-left-bg slant">
            <div class="color-bars">
            </div>
            <div class="slant-inner">
                <svg width="124" height="53" viewBox="0 0 124 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0H14.8V15.1429H0V0Z" fill="#FA31D9"/>
                    <path d="M22.2 0H37V53H22.2V0Z" fill="#FA31D9"/>
                    <path d="M88 37.8571H102.4V53H88V37.8571Z" fill="#67ADFF"/>
                    <path d="M88 0L124 34.0714V53L88 18.9286V0Z" fill="#67ADFF"/>
                    <path d="M44 0L70.9971 9.77559e-06L54.5527 15.1428L44 15.1428V0Z" fill="#5A1FFF"/>
                    <path d="M81 37.8572H60.4444L81 18.9286V3.89742e-05L44 34.0714V53H81V37.8572Z" fill="#5A1FFF"/>
                </svg>
                <h1>Hi, I’m <strong><?= Site::$work == true ? "Archie / Tanza" : "Tanza!" ?></strong></h1>
                <p>I’m a designer and developer from the UK, working on projects such as osu!, UNTONE, Osekai, and many
                    more.</p>
                <p>In my spare time, I also work on 3D art and character design, and I dabble a bit in music and
                    electronics.</p>
                <p>On this site, you can find practically everything I’ve worked on over the past few years, I hope you
                    enjoy looking around!</p>
            </div>
        </div>
    </div>
    <div class="header-right">
        <div class="header-image slant">
            <img class="slant-inner"
                 src="<?= Site::$work == true ? "/public/img/workbanner.png" : "https://tanza.me/img/gallery/original/1696531813_output.png" ?>">
        </div>
    </div>
</div>

<style>
    .cube .c1 {
        --bg: url("/img/portfolio/1702683847/medium.png");
    }

    .cube .c2 {
        --bg: url("/img/portfolio/1689974653/medium.png");
    }

    .cube .c3 {
        --bg: url("/img/portfolio/1692901724/medium.png");
    }

    .cube .c4 {
        --bg: url("/img/portfolio/1689973991/medium.png");
    }

    .cube .c5 {
        --bg: url("https://untonemusic.com/img/release/iridescent/cover.jpg");
    }

    .cube .c7 {
        --bg: url("/img/portfolio/1713826098/medium.png");
    }

    .cube .c6 {
        --bg: url("/img/portfolio/1729382724/medium.png");
    }

    .cube .c8 {
        --bg: url("/img/portfolio/1729382704/2.png");
    }
</style>

<style>
    <?php

for($x = 0; $x < 16; $x++) {
    ?>

    .globe .v<?= $x+1 ?> {
        animation-delay: -<?= $x ?>s !important;
        --length: <?= 15 - $x ?>s;
    }

    .globe.big .v<?= $x+1 ?> {
        animation-delay: -<?= $x*5 ?>s !important;
        --length: <?= 50 - $x ?>s;
    }

    <?php
}
 ?>
</style>

<div class="page-container">
    <a class="slant portfolio-button" href="/portfolio">
        <div class="slant-inner">
            <div class="cube-outer">
                <div class="cube-full">
                    <div class="cube">
                        <div class="right c1"></div>
                        <div class="left c2"></div>
                        <div class="front c3"></div>
                        <div class="back c4"></div>
                    </div>
                    <div class="cube secondary">
                        <div class="right c5"></div>
                        <div class="left c6"></div>
                        <div class="front c7"></div>
                        <div class="back c8"></div>
                    </div>


                    <div class="cube backface">
                        <div class="right c1"></div>
                        <div class="left c2"></div>
                        <div class="front c3"></div>
                        <div class="back c4"></div>
                    </div>
                    <div class="cube secondary backface">
                        <div class="right c5"></div>
                        <div class="left c6"></div>
                        <div class="front c7"></div>
                        <div class="back c8"></div>
                    </div>

                    <div class="intercect">
                        <i class="iconoir-design-pencil"></i>
                        <div class="intercect-hover-bg"></div>
                        <div class="sparkles slant-inner">
                            <div class="sparkles-1"></div>
                            <div class="sparkles-2"></div>
                        </div>
                        <div class="slant-inner right-ping">
                            <i class="iconoir-fast-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="padding">
                <div>
                    <h1>Portfolio</h1>
                    <p>View all of my website, logo, cover, and product designs, all in one place</p>
                </div>
            </div>
        </div>
    </a>
    <div class="slant test"></div>
</div>

<div class="page-container two-button">

    <a class="slant" href="/gallery">
        <div class="image">
            <img class="slant-inner" src="https://tanza.me/img/gallery/original/1700516349_pool.png">
        </div>
        <div class="slant-inner">
            <h1>My Art</h1>
        </div>
    </a>

    <a class="slant" href="https://untonemusic.com/profile/tanza">
        <div class="image">
            <img class="slant-inner" src="https://untonemusic.com/img/release/aurora-dunes/cover.jpg">
        </div>
        <div class="slant-inner">
            <h1>My Music</h1>
        </div>
    </a>
</div>

<div class="follow">
    <!--<div class="globe">
        <div class="x1 v1"></div>
        <div class="x1 v2"></div>
        <div class="x1 v3"></div>
        <div class="x1 v4"></div>

        <div class="x2 v1"></div>
        <div class="x2 v2"></div>
        <div class="x2 v3"></div>
        <div class="x2 v4"></div>
    </div>-->

    <div class="globe big">
        <div class="x1 v1"></div>
        <div class="x1 v2"></div>
        <div class="x1 v3"></div>
        <div class="x1 v4"></div>

        <div class="x2 v1"></div>
        <div class="x2 v2"></div>
        <div class="x2 v3"></div>
        <div class="x2 v4"></div>
    </div>

    <div class="globe big bigger">
        <div class="x1 v1"></div>
        <div class="x1 v2"></div>
        <div class="x1 v3"></div>

        <div class="x2 v1"></div>
        <div class="x2 v2"></div>
        <div class="x2 v3"></div>
    </div>
    <div class="inner">
        <h1>Around The Web</h1>
        <div class="button-row socials">
            <?php
            // this isn't too clean but saves alot of time
            function button($icon, $name, $link, $colour = "#F83CF6")
            {
                ?>
                <a class="social-button" href="<?= $link ?>" style="--col: <?= $colour ?>;">
                    <div>
                        <i icon="<?= $icon ?>"></i>
                        <h1><?= $name ?></h1>
                    </div>
                </a>
                <?php
            }

            button("github", "Github", "https://github.com/Tanza3D", "#4479C5");
            button("linkedin", "LinkedIn", "https://www.linkedin.com/in/archie-/", "#1469C7");
            button("bluesky", "Bluesky", "https://bsky.app/profile/tanza.me", "#3A9EFD");
            button("twitch", "Twitch", "https://twitch.tv/tanza3d", "#944DFF");
            button("osu", "osu!", "https://osu.ppy.sh/users/10379965", "#ff66aa");
            button("lastdotfm", "Last.fm", "https://www.last.fm/user/Tanza3D", "#E4222A");
            ?>
            <a class="social-button discord" style="--col: #1D23BE;" onclick="window.CopyDiscord(event)">
                <div class="upper">
                    <i icon="discord"></i>
                    <h1>Discord</h1>
                </div>
                <div class="under">
                    <img src="https://tanza.me/img/gallery/small/1717107846_whatsdoneisdone-tanza.png">
                    <p>tanza3d</p>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="page-container">
    <div class="work-grid">
        <?php
        function project($title, $name, $link, $button, $about)
        {
            ?>
            <div class="slant projectpanel" style="--bg: url('/public/img/home/<?= $title ?>.png')">
                <div class="slant-inner">
                    <div class="logo"><img src="/public/img/home/<?= $title ?>.svg"></div>
                    <div class="bottom slant">
                        <div class="slant-inner">
                            <p><?= $about ?></p>
                        </div>
                        <a class="button cta" href="https://untone.uk">
                            <span class="slant-inner"><?= $button ?></span>
                        </a>

                    </div>
                </div>
            </div>
            <?php
        }

        ?>
        <div>
            <?php
            project("untone", "UNTONE", "https://untone.uk", "Learn More",
                "UNTONE is a group of developers, designers, and musicians creating websites, music,
                                games, and more. I lead the group alongside Guus!");
            ?>
        </div>
        <div class="project-row">
            <?php
            project("osekai", "Osekai", "https://osekai.net", "Visit",
                "Osekai is a website I developed and designed for the the rhythm game osu!, 
                providing users with medal solutions, custom leaderboards, and more!");
            ?>

            <?php
            project("untonemusic", "UNTONE Music", "https://untonemusic.com", "Learn More",
                "UNTONE Music is a popular record label owned by UNTONE, publishing and 
                marketing electronic music from artists all around the world");
            ?>
        </div>
    </div>
</div>
<form class="contact" id="contact" autocomplete="on">
    
    <div class="page-container">
        <div class="texts">
            <h1>Contact</h1>
            <p>Want to talk? Fill out the form and I'll get back to you as soon as possible!</p>
            <p>Alternatively, email me directly at archie@untone.uk or contact me on Discord at Tanza3D!</p>
        </div>
        <div class="inputs">
            <div>
                <div class="input-wrapper">
                    <input autocomplete="name" name="name" id="contact-name" class="input" type="text"
                           placeholder="Name">
                </div>
                <div class="input-wrapper">
                    <input autocomplete="email" name="email" id="contact-email" class="input" type="email"
                           placeholder="Email">
                </div>
            </div>
            <div class="input-wrapper more">
                <textarea id="contact-body" class="input" placeholder="Query"></textarea>
            </div>
            <div>
                <button type="submit" id="contact-send" class="button cta right slant"><span class="slant-inner">Send</span></button>
            </div>
        </div>
    </div>
</form>