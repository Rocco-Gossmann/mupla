const MyPlayer = (function () {

    let tracks = [];
    let playlist = [];
    let currentTrack = -1;

    const player = document.querySelector("#audioplayer");
    const nowplaying = document.querySelector("#nowplaying");

    function noPlayer() {
        console.warning( "no DOM-Element with ID player was found during page load" );
    }

    if (!player) throw new Error("Could not find '#audioplayer' DOM-Element");

    function playTrack(idx, useShuffle=false) {
        // remove highlight from all track links
        document.querySelectorAll(".track_link").forEach((l) => l.classList.remove("active") );

        // Find Track in current playlist 
        currentTrack = Math.abs(idx % tracks.length);

        let file = playlist[currentTrack]; 

        if(!useShuffle) {
            const trackFile = tracks[currentTrack]['file'];
            file = playlist.filter(e => e['file'] == trackFile)[0]
        }

        const domtrack = document.querySelector(`#track_${file["idx"]}`);
        domtrack.classList.add("active");
        domtrack.scrollIntoView({ behavior: "smooth" });

        if (nowplaying) nowplaying.innerHTML = file["file"];

        player.src = `play.php?track=${encodeURI(file["file"]).replace("&", "%26")}`;
    }

    function toggleShuffle(toggle) {
        if (toggle) {
            playlist = [...tracks]
                .sort(() => (Math.random() - 0.5) * 2)
                .sort(() => (Math.random() - 0.5) * 2)
                .sort(() => (Math.random() - 0.5) * 2); // 3X for good messure
        } else {
            currentTrack = playlist[currentTrack]["idx"];
            playlist.filter((e) => e.idx == currentTrack)[0];
            playlist = [...tracks];
        }
    }
    function playNext() {
        playTrack(currentTrack + 1, true);
    }

    function playPrev() {
        playTrack(currentTrack - 1, true);
    }

    function registerTracks(_tracks) {
        tracks = _tracks;
        playlist = _tracks;
    }

    player.addEventListener("canplay", () => player.play());
    player.addEventListener("ended", playNext);
    navigator.mediaSession.setActionHandler('nexttrack', playNext);
    navigator.mediaSession.setActionHandler('previoustrack', playPrev);

    const successPlayerState = {
        playNext,
        playPrev,
        playTrack,
        registerTracks,
        toggleShuffle,
    };

    const errorPlayerState = {
        playNext: noPlayer,
        playPrev: noPlayer,
        playTrack: noPlayer,
        registerTracks: noPlayer,
        toggleShuffle: noPlayer,
    };

    return player ? successPlayerState : errorPlayerState;
})();
