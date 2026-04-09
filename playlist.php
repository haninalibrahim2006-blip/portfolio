<?php
include("inc/functions.php");
$album = getSingleAlbum();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Benjamin Porobic">
    <title>Playlist</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="topbar">
    <a class="logo" href="index.php">Radio Gaga</a>
    <?php displayNavigation(); ?>
</header>

<main class="page-container">
    <!-- Links: albums -->
    <?php displayAlbums(); ?>

    <!-- Rechts: video en tracks -->
    <div class="tracks-column">
        <h1>Playlist</h1>

        <?php if(!$album) { ?>
            <p>Geen album gevonden.</p>
        <?php } else { ?>

            <h2 class="album-title"><?php echo $album["albumTitle"]; ?></h2>

            <!-- Video -->
            <video id="mainVideo" class="album-video" controls>
                <?php
                // standaard video = eerste track video
                $videoStart = ""; 
                if (count($album["tracks"]) > 0) {
                    $videoStart = str_replace(" ", "%20", $album["tracks"][0]["track_video"]);
                }
                ?>
                <?php if($videoStart != "") { ?>
                    <source src="videos/<?php echo $videoStart; ?>" type="video/mp4">
                <?php } ?>
            </video>

            <?php displayTracksTable($album); ?>

        <?php } ?>
    </div>
</main>

<script>
// video speelt mee en wisselt video
const video = document.getElementById("mainVideo");
const audios = document.querySelectorAll(".track-audio");

audios.forEach(a => {
    a.addEventListener("play", function () {

        // andere audio stoppen
        audios.forEach(other => {
            if(other !== a) {
                other.pause();
                other.currentTime = 0;
            }
        });

        // video bron wisselen
        const newVideo = a.getAttribute("data-video");
        if(newVideo && video) {
            if(!video.src.includes(newVideo)) {
                video.src = newVideo;
                video.load();
            }
            video.play();
        }
    });

    // als audio pauzeert of eindigt - video pauze
    a.addEventListener("pause", function () {
        if(video) video.pause();
    });

    a.addEventListener("ended", function () {
        if(video) video.pause();
    });
});
</script>

</body>
</html>
