<div class="cool-header">
    <h1>About Me</h1>
</div>
<div class="page-container top">
    <div class="cool-tanza"></div>
    <div class="texts">

        <h1>Hi! I'm Tanza!</h1>
        <p>I work on various projects throughout the internet, from rhythm games to record labels, and creating websites
            and internal tools for our teams at UNTONE and the likes!</p>
        <p>I've been coding since about 2018, and been a 3d artist since 2019, with my graphic design history going back
            a few years further.</p>

        <p>In 2021, I made my first protogen named Tanza, and later renamed myself to that name as well as joining the
            furry community! I've since created countless protogens and even a few other cool species like lizards and
            such! (if you're interested, check out the artwork gallery!)</p>
    </div>
</div>

<div class="page-container projects">
    <!-- temp layout -->
    <?php
    function ProjectPanel($project)
    {
        $flair = $project['flair'] ?? 'Creator';
        $date = $project['date'] ?? null;
        $key = $project['key'];
        $name = $project['name'];
        $description = $project['description'];
        $link = $project['link'];
        ?>
        <div class="project-panel" style="--background: url('/public/img/about/projects/<?= $key ?>.jpg')">
            <div class="cover">
                <img src="/public/img/about/projects/<?= $key ?>.svg" alt="<?= $name ?>">
            </div>
            <div class="text">
                <small class="flair-<?= strtolower($flair) ?>"><?= $flair ?></small>
                <h1><?= $name ?></h1>
                <p><?= $description ?></p>
            </div>
            <a href="<?= $link ?>">View Project</a>
        </div>
        <?php
    }

    $current_projects = [
        [
            'key' => 'untone',
            'name' => 'UNTONE',
            'description' => "I'm the founder of UNTONE, a small group of developers, designers, and musicians! The company behind UNTONE Music, TONE::FURY, Anthera, and Osekai!",
            'link' => 'https://untone.org',
        ],
        [
            'key' => 'untone-music',
            'name' => 'UNTONE Music',
            'description' => "UNTONE Music is an electronic-facing record label - I'm the lead technical director and designer on the project!",
            'link' => 'https://untonemusic.com',
        ],
        [
            'key' => 'tonefury',
            'name' => 'TONE::FURY',
            'description' => "TONE::FURY is a record label specializing in hardstyle and harderstyle music - I'm the lead technical director and designer on the project!",
            'link' => 'https://untonemusic.com',
        ],
        [
            'key' => 'anthera',
            'name' => 'Anthera',
            'description' => "Anthera is a furry art sharing social platform with modern and unique features, I'm the lead (and only) designer, developer, and director on the project! Everything was done by me.",
            'link' => 'https://anthera.art',
        ],
        [
            'key' => 'osekai',
            'name' => 'Osekai',
            'description' => "Osekai is a website with various osu!-related tools, such as medal solutions, profile statistics, and more - I joined the project in 2020 and have been the lead developer since 2024!",
            'link' => 'https://osekai.net',
        ],
        [
            'key' => 'osu',
            'name' => 'osu!',
            'description' => "I'm one of the many amazing designers on the osu! team, I specialize primarily in news post assets (banners, etc) and medal designs. You can find lots of my osu! work on my portfolio!",
            'link' => 'https://osu.ppy.sh',
            'flair' => 'Contributor',
        ],
        [
            "key" => "solync",
            "name" => "Solync",
            "description" => "Solync is an employee-owned collective, creating innovative technologies - I'm the lead designer on the team and also have been assisting in UX, sysadmin, and development.",
            "link" => "https://solync.org",
            "flair" => "Contributor",
        ],
    ];

    $past_projects = [
        [
            'key' => 'cubey',
            'name' => "Cubey's Adventures",
            'description' => "Cubey / Cubey's Adventures is a 2d platformer game I made back in 2020, we're working on a new version so keep an eye out!",
            'link' => 'https://cubey.cc',
            'date' => '2021',
        ],
        [
            'key' => 'eclipsedteam',
            'name' => 'EclipsedTeam',
            'description' => 'Me and Matteo worked on EclipsedTeam back in 2020, our primary focus was creating intricate skins for osu!, though we also developed osu!trigen at the same time',
            'link' => 'https://sites.google.com/view/eclipsedteam',
            'date' => '2020',
        ],
        [
            'key' => 'trigen',
            'name' => 'osu!trigen',
            'description' => "Small piece of software built using Unity to generate animated triangle backgrounds in the style of osu!'s designs",
            'link' => 'https://github.com/Tanza3D/osu-trigen/tree/main',
            'date' => '2020',
        ],
        [
            'key' => 'reddark',
            'name' => 'RedDark',
            'description' => 'as seen on https://www.pcmag.com/news/quiet-day-on-reddit-major-subreddits-go-dark-to-protest-api-changes',
            'link' => 'https://github.com/Tanza3D/reddark',
            'date' => '2023',
        ],
        [
            'key' => 'timeguessr',
            'name' => 'TIMEGUESSR',
            'description' => 'I designed the homepage, the main map picker area, and most importantly the results screen. For reasons beyond me, I am sadly not credited for any of this on the site.',
            'link' => 'https://timeguessr.com',
            'date' => '2023',
            'flair' => 'Past Contributor',
        ],
    ];
    ?>
    <h1>Current Works</h1>
    <div class="project-grid">
        <?php foreach ($current_projects as $project) {
            ProjectPanel($project);
        } ?>
    </div>
    <h1>Past Works</h1>
    <div class="project-grid">
        <?php foreach ($past_projects as $project) {
            ProjectPanel($project);
        } ?>
    </div>
</div>