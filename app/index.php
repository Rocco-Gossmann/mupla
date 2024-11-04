<?php

$aAlbums = [];
$aTracks = [];

$oIterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(
        "/opt/music/", 
        FilesystemIterator::SKIP_DOTS|
        FilesystemIterator::KEY_AS_PATHNAME|
        FilesystemIterator::CURRENT_AS_FILEINFO
    )
);

foreach($oIterator as $sEntry => $oDir) {
    $aMatch = [];
    if (!preg_match("#/opt/music/(?<file>.*\.mp3)$#i", realpath($sEntry) , $aMatch))
        continue;

    $sAlbum = dirname($aMatch['file']);
    $sFile  = dirname($aMatch['file']);

    $aAlbums[$sAlbum] = $aAlbums[$sAlbum] ?? [];
    $aAlbums[$sAlbum][count($aTracks)] = $aMatch['file'];

    $aTracks[] = ['file' => $aMatch['file'], 'idx' => count($aTracks)];
}

if(empty($aTracks)) die("no music found. Make sure to put some MP3 - Files into /opt/music (aka. ./music folder of the Repo)");

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="./style.css" />

    <script defer type="text/javascript" src="./player.js"></script>

    <script type="text/javascript">
        window.addEventListener("load", () => {
            MyPlayer.registerTracks(
                JSON.parse("<?php echo addslashes(json_encode($aTracks)); ?>")
            );
        });
    </script>
</head>

<body>

    <?php foreach ($aAlbums as $sAlbum => $aAudioList) { ?>
        <article class="album">
            <h4><?php echo htmlspecialchars($sAlbum) ?></h4>
            <ul class="tracklist">
                <?php foreach ($aAudioList as $iIDX => $sAudio) { ?>
                    <li>
                        <a class="track_link" id="track_<?php echo $iIDX; ?>" href="#play_<?php echo $sAudio ?>" onclick="MyPlayer.playTrack('<?php echo $iIDX ?>')"> <?php echo $sAudio ?> </a>
                    </li>
                <?php } ?>
            </ul>
        </article>
    <?php } ?>

    <div class="player">

        <button class="mt-2 mb-2 prevbtn" onclick="MyPlayer.playPrev()">&larr;</button>
        <label class="mt-2 nowrap shuffle">
            <input type="checkbox" onclick="MyPlayer.toggleShuffle(this.checked)" />&nbsp;shuffle
        </label>

        <b class="mt-2 np_label nowrap">now Playling:</b>
        <span class="mt-2 nowplaying" id="nowplaying"></span>
        <button class="mt-2 mb-2 nextbtn" onclick="MyPlayer.playNext()">&rarr;</button>

        <div class="full-width audio">
            <audio controls id="audioplayer" src=""></audio>
        </div>
    </div>

</body>

</html>
