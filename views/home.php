<?php
\Site\Embed::SetDescription("I’m a designer and developer from the UK, working on projects such as osu!, UNTONE, Osekai, and many more! Learn about me here!");
\Site\Embed::SetTitle("Tanza");
\Site\Embed::SetBannerImage("/public/img/workbanner.png");

$random_mobile_range = 8;
$random_desktop_range = 9;

$random_mobile = rand(1, $random_mobile_range);
$random_desktop = rand(1, $random_desktop_range);
?>
<style>
    .home-area {
        --bg-mobile: url("/public/img/home/bgs/mobile_<?=str_pad($random_mobile, 2, '0', STR_PAD_LEFT)?>.jpg");
        --bg-desktop: url("/public/img/home/bgs/desktop_<?=str_pad($random_desktop, 2, '0', STR_PAD_LEFT)?>.jpg");
    }
</style>

<div class="home-area">
    <div class="topleft">
        <h1>Hi, I'm <strong>Tanza!</strong></h1>

        <p>I’m a designer and developer from the UK, working on projects such as osu!, UNTONE, Osekai, and many
            more.</p>
        <p>In my spare time, I also work on 3D art and character design, and I dabble a bit in music and
            electronics.</p>
        <p>On this site, you can find practically everything I’ve worked on over the past few years, I hope you
            enjoy looking around!</p>

        <div class="links">
            <a href="/about">About / Projects <i class="iconoir-arrow-right"></i></a>
            <a href="/portfolio">Portfolio <i class="iconoir-arrow-right"></i></a>
            <a href="/gallery">Art Gallery <i class="iconoir-arrow-right"></i></a>
        </div>
    </div>
    <div class="bottomleft">
        <a href="/contact" class="text-button">Contact</a>
        <div></div>
        <?php
        // this isn't too clean but saves alot of time
        function button($icon, $name, $link, $colour = "#F83CF6")
        {
            ?>
            <a class="social-button tooltip" href="<?= $link ?>" style="--col: <?= $colour ?>;" tooltip="<?= $name ?>">
                <i icon="<?= $icon ?>"></i>
            </a>
            <?php
        }

        button("bluesky", "Bluesky", "https://bsky.app/profile/tanza.me", "#3A9EFD");
        button("osu", "osu!", "https://osu.ppy.sh/users/10379965", "#ff66aa");
        button("github", "Github", "https://github.com/Tanza3D", "#4479C5");
        button("twitch", "Twitch", "https://twitch.tv/tanza3d", "#944DFF");
        button("linkedin", "LinkedIn", "https://www.linkedin.com/in/archie-/", "#1469C7");
        button("lastdotfm", "Last.fm", "https://www.last.fm/user/Tanza3D", "#E4222A");
        ?>
    </div>
</div>