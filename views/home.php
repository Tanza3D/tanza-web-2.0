<?php
\Site\Embed::SetDescription("I’m a designer and developer from the UK, working on projects such as osu!, UNTONE, Osekai, and many more! Learn about me here!");
\Site\Embed::SetTitle("Tanza");


$random_mobile_range = 8;
$random_desktop_range = 9;

$random_mobile = rand(1, $random_mobile_range);
$random_desktop = rand(1, $random_desktop_range);


\Site\Embed::SetBannerImage("/public/img/home/bgs/desktop_" . str_pad($random_desktop, 2, '0', STR_PAD_LEFT) . ".jpg");
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
        <a id="contact-button" class="text-button">Contact</a>
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
        <a class="social-button tooltip cta" style="--colour: #ff66aa" tooltip="Discord" onclick="window.CopyDiscord(event)">
            <i icon="discord"></i>
            <p>tanza3d</p>
        </a>
    </div>
</div>

<form class="contact" id="contact" autocomplete="on">
    <div id="contact-close">
        <i class="iconoir-xmark"></i>
    </div>
    <div class="page-container">
        <div class="texts">
            <h1>Contact</h1>
            <p>Want to talk? Fill out the form and I'll get back to you as soon as possible!</p>
            <p>Alternatively, email me directly at archie@untone.uk or contact me on Discord at Tanza3D!</p>
        </div>
        <div class="inputs">
            <div>
                <div class="input-wrapper">
                    <input autocomplete="name" name="contact_name" id="contact-name" class="input" type="text"
                           placeholder="Name">
                </div>
                <div class="input-wrapper">
                    <input autocomplete="email" name="contact_email" id="contact-email" class="input" type="email"
                           placeholder="Email">
                </div>
            </div>
            <div class="input-wrapper more">
                <textarea id="contact-body" class="input" placeholder="Query"></textarea>
            </div>
            <div>
                <button type="submit" id="contact-send" class="button cta right"><span>Send</span></button>
            </div>
        </div>
    </div>
</form>
