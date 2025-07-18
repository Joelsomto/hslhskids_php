<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once 'include/Session.php';
require_once 'include/Controller.php';
$Controller = new Controller();

?>
<!doctype html>
<html class=no-js lang=zxx>

<head>
    <meta charset=utf-8>
    <meta http-equiv=x-ua-compatible content="ie=edge">
    <title>HSLHS for Kids | Healing Streams Live Healing Services with Pastor Chris </title>
    <meta name=description content="Welcome to the Healing Streams Live Healing Services Platform for Kids.
    HSLHS for Kids is designed to reach every child in the world with God's healing power.
    Healing Streams is the largest platform in the world for the preaching of the Gospel reaching and impacting billions of people globally">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="keywords" content="HSLHS for Kids, healing, kiddies magazine, Healing Streams, Pastor Chris, healing to the nations, HERALD, HTTN magazine, miracles, healing school, largest crusade, soul winning, RevDr. Chris Oyakhilome">
    <meta name=author content="Healing Streams Live Healing Services for Kids">
    <meta name=theme-color content="#ffffff">
    <meta property=og:title content="HSLHS for Kids | Healing Streams Live Healing Services with Pastor Chris">
    <meta property="og:image" content="https://healingstreams.tv/images/favicon.png" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="200" />
    <meta property="og:image:height" content="200" />
    <link rel="shortcut icon" type="image/x-icon" href="https://healingstreams.tv/images/favicon.png">
    <meta property="og:description" content="Welcome to the Healing Streams Live Healing Services Platform for Kids." />
    <link rel=stylesheet href="assets/css/bootstrap.min.css">
    <link rel=stylesheet href="assets/css/animate.css">
    <link rel=stylesheet href="assets/css/custom-animation.css">
    <link rel=stylesheet href="assets/css/slick.css">
    <link rel=stylesheet href="assets/css/nice-select.css">
    <link rel=stylesheet href="assets/css/flaticon_mycollection.css">
    <link rel=stylesheet href="assets/css/swiper-bundle.css">
    <link rel=stylesheet href="assets/css/meanmenu.css">
    <link rel=stylesheet href="assets/css/font-awesome-pro.css">
    <link rel=stylesheet href="assets/css/magnific-popup.css">
    <link rel=stylesheet href="assets/css/spacing.css">
    <link rel=stylesheet href="assets/css/main.css">
    <link rel=stylesheet href="assets/css/livetv.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/magnific-popup.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>
        a {
            text-decoration: none;
        }

        ul.custom-bullets {
            list-style: none;
        }

        ul.custom-bullets li::before {
            content: "•";
            color: #ff9f00;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        .swiper-slide {
            width: 100% !important;
            /* Or any larger fixed value like 800px */
            max-width: 1000px;
            margin: 0 auto;
            /* Center the wider slide */
        }

        .program-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        /* Style both buttons and anchor tags the same way */
        .program-actions button,
        .program-actions a {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #4a90e2;
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            /* Remove underline from links */
        }

        .program-actions button:hover,
        .program-actions a:hover {
            background-color: #3a7bc8;
            transform: translateY(-2px);
            /* Add slight lift effect */
        }

        /* Specific button colors */
        .btn-salvation {
            background-color: #28a745;
        }

        .btn-salvation:hover {
            background-color: #218838;
        }

        .btn-magazine {
            background-color: #17a2b8;
        }

        .btn-magazine:hover {
            background-color: #138496;
        }

        .btn-give {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-give:hover {
            background-color: #e0a800;
        }

        .btn-invite {
            background-color: #6f42c1;
        }

        .btn-invite:hover {
            background-color: #5e34a8;
        }
    </style>
    <style>
        .participation-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.participation-modal .modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
    text-align: center;
}

.participation-modal input {
    width: 100%;
    padding: 8px;
    margin: 10px 0;
    box-sizing: border-box;
}

.participation-modal button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.participation-modal button:hover {
    background-color: #45a049;
}
    </style>
</head>


<body>
    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div>
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="far fa-angle-double-up"></i>
    </button>

    <?php include_once('partials/search_popup.php') ?>

    <?php include_once('partials/offcanvas.php') ?>

    <div class="body-overlay"></div>
    <!-- Page Header Start-->
    <?php include_once('partials/header.php') ?>

    <!-- Page Header Ends  -->
    <main>
        <!-- <div class="it-breadcrumb-area it-breadcrumb-height black-bg p-relative fix">
            <div class="it-breadcrumb-shape-1">
                <img src="assets/img/breadcurmb/shape-1-1-1.png" alt="">
            </div>
            <div class="it-breadcrumb-shape-2">
                <img src="assets/img/breadcurmb/shape-1-2-1.png" alt="">
            </div>
            <div class="it-breadcrumb-shape-3">
                <img src="assets/img/breadcurmb/shape-1-3-1.png" alt="">
            </div>
            <div class="it-breadcrumb-shape-5">
                <img src="assets/img/breadcurmb/shape-1-5-1.png" alt="">
            </div>
            <div class="it-breadcrumb-shape-6">
                <img src="assets/img/breadcurmb/shape-1-6-1.png" alt="">
            </div>
            <div class="it-breadcrumb-shape-7">
                <img src="assets/img/breadcurmb/shape-1-5-1.png" alt="">
            </div>
            <div class="it-breadcrumb-shape-8">
                <img src="assets/img/breadcurmb/shape-1-7-1.png" alt="">
            </div>
            <div class="it-breadcrumb-shape-9">
                <img src="assets/img/breadcurmb/shape-1-8-1.png" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="it-breadcrumb-content z-index text-center">
                            <div class="it-breadcrumb-section-title-box mb-20">
                                <h3 class="it-breadcrumb-title">Live Tv</h3>
                            </div>
                            <div class="it-breadcrumb-list">
                                <span><a href="index-1.html">Home</a></span>
                                <span class="dvdr"><i>//</i></span>
                                <span class="color">Live Tv</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="live-tv-section">
            <div class="container">
                <div class="row gx-5">
                    <!-- Main TV Player Column -->
                    <div class="col-lg-8">
                        <div class="tv-player-container">
                            <div class="tv-header">
                                <div class="channel-info">
                                    <div class="channel-logo">
                                        <img src="https://healingstreams.tv/images/favicon.png" alt="Channel Logo">
                                    </div>
                                    <div class="channel-meta">
                                        <h2 class="channel-name">Kids Live Tv</h2>
                                        <div class="viewer-count">
                                            <i class="fas fa-eye"></i> <span id="viewer-count">1,245</span> watching now
                                        </div>
                                    </div>
                                </div>
                                <div class="tv-controls">
                                    <button class="btn-control fullscreen-btn" title="Fullscreen">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="video-wrapper">
                                <?php
                                // Get link and title from the request
                                $link = $_REQUEST['link'] ?? 'https://pvqybrzodz24-hls-live.5centscdn.com/HSOP/955ad3298db330b5ee880c2c9e6f23a0.sdp/playlist.m3u8';
                                $title = $_REQUEST['title'] ?? 'Healing Streams Live Healing Services';
                                $isHls = (strpos($link, '.m3u8') !== false);
                                ?>
                                <!-- Video Section -->

                                <?php if ($isHls): ?>
                                    <!-- HLS Video -->
                                    <video id="liveTvPlayer" controls autoplay playsinline>
                                        Your browser does not support the video tag.
                                    </video>
                                    <script src="https://cdn.jsdelivr.net/npm/hls.js@1/dist/hls.min.js"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const video = document.getElementById('liveTvPlayer');
                                            if (Hls.isSupported()) {
                                                const hls = new Hls();
                                                hls.loadSource('<?php echo htmlentities($link); ?>');
                                                hls.attachMedia(video);
                                                hls.on(Hls.Events.MANIFEST_PARSED, function() {
                                                    video.play();
                                                });
                                            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                                                video.src = '<?php echo htmlentities($link); ?>';
                                                video.addEventListener('loadedmetadata', function() {
                                                    video.play();
                                                });
                                            }
                                        });
                                    </script>
                                <?php else: ?>
                                    <!-- MP4 Video -->
                                    <video controls class="w-100" src="<?php echo htmlentities($link); ?>"></video>
                                <?php endif; ?>

                                <div class="live-badge">LIVE</div>
                                <div class="kids-corner">
                                    <div class="floating-emoji">🎈</div>
                                    <div class="floating-emoji">🎨</div>
                                    <div class="floating-emoji">🧸</div>
                                </div>
                            </div>

                            <div class="program-info">
                                <div class="current-program">
                                    <h4>Currently Playing</h4>
                                    <h3><?php echo htmlentities($title); ?></h3>
                                    <!-- <p class="program-time">08:00 - 10:00 AM</p> -->
                                    <p class="program-description">Get ready for an amazing live event where you can experience God’s love and healing power like never before!</p>
                                </div>
                                <div class="program-actions">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn-salvation" data-bs-toggle="modal" data-bs-target="#salvationModal">
                                        <i class="fas fa-cross"></i> Receive Salvation
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="salvationModal" tabindex="-1" aria-labelledby="salvationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title" id="salvationModalLabel">A Prayer Of Salvation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="https://healingstreams.tv/images/salvation_pic.jpg" alt="Salvation" class="img-fluid rounded mb-3" />
                                                    <p class="text-start" style="line-height: 1.6;">
                                                        O Lord God, I believe with all my heart in Jesus Christ, Son of the living God.
                                                        I believe He's alive today. I confess with my mouth that Jesus Christ is the Lord of my life from this day.<br><br>
                                                        Through Him and in His Name, I have eternal life, I'm born again.
                                                        Thank You Lord, for saving my soul! I'm now a child of God. Hallelujah!
                                                    </p>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="assets/magazine/Jun2025_HTTN_Magazine_For_Kids_June_2025.pdf" download class="btn-magazine">
                                        <i class="fas fa-download"></i> Download Magazine
                                    </a>
                                    <a href="https://healingstreams.tv/donate.php/?rl=5" class="btn-give" target="_blank" rel="noopener noreferrer">
                                        <i class="fas fa-gift"></i> Give
                                    </a>
                                    <?php
                                    // Get current website URL
                                    $siteUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
                                        . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                    ?>

                                    <!-- Invite Button -->
                                    <button type="button" class="btn-invite" data-bs-toggle="modal" data-bs-target="#inviteModal">
                                        <i class="fas fa-user-plus"></i> Invite Others
                                    </button>

                                    <!-- Invite Modal -->
                                    <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content text-center">
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title w-100" id="inviteModalLabel">Invite Others</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Share this site with others on:</p>
                                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($siteUrl) ?>" target="_blank" class="btn btn-primary">
                                                            <i class="fab fa-facebook-f"></i> Facebook
                                                        </a>
                                                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode($siteUrl) ?>" target="_blank" class="btn btn-info text-white">
                                                            <i class="fab fa-twitter"></i> Twitter
                                                        </a>
                                                        <a href="https://api.whatsapp.com/send?text=<?= urlencode($siteUrl) ?>" target="_blank" class="btn btn-success">
                                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                                        </a>
                                                        <a href="mailto:?subject=Check this out&body=<?= urlencode($siteUrl) ?>" class="btn btn-dark">
                                                            <i class="fas fa-envelope"></i> Email
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Live Comments Column -->
                    <div class="col-lg-4">
                        <div class="live-comments-container">
                            <div class="comments-header">
                                <h3><i class="fas fa-comment-dots"></i> Kids Chat</h3>
                                <div class="comment-count">42</div>
                            </div>

                            <div class="comments-stream">
                                <!-- Sample comments - these would be dynamically loaded in a real app -->
                                <div class="comment new">
                                    <div class="comment-avatar">
                                        <img src="https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Happy" alt="User">
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-meta">
                                            <span class="username">HappyKid</span>
                                            <span class="timestamp">just now</span>
                                        </div>
                                        <p class="comment-text">I love this show! The colors are so pretty! 🌈</p>
                                    </div>
                                </div>

                                <div class="comment">
                                    <div class="comment-avatar">
                                        <img src="https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Jumping" alt="User">
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-meta">
                                            <span class="username">JumpingJill</span>
                                            <span class="timestamp">2 min ago</span>
                                        </div>
                                        <p class="comment-text">My favorite character is the blue one! 💙</p>
                                    </div>
                                </div>

                                <div class="comment">
                                    <div class="comment-avatar">
                                        <img src="https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Sunny" alt="User">
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-meta">
                                            <span class="username">SunnySam</span>
                                            <span class="timestamp">5 min ago</span>
                                        </div>
                                        <p class="comment-text">Can we sing the song again? 🎵</p>
                                    </div>
                                </div>

                                <div class="comment">
                                    <div class="comment-avatar">
                                        <img src="https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Bouncy" alt="User">
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-meta">
                                            <span class="username">BouncyBen</span>
                                            <span class="timestamp">8 min ago</span>
                                        </div>
                                        <p class="comment-text">This is the best morning ever! 😊</p>
                                    </div>
                                </div>
                            </div>

                            <div class="comment-form">
                                <div class="form-avatar">
                                    <img src="https://api.dicebear.com/6.x/bottts-neutral/svg?seed=You" alt="You">
                                </div>
                                <div class="form-input">
                                    <input type="text" placeholder="Say something nice...">
                                    <button class="send-button">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                                <div class="emoji-picker">
                                    <button class="emoji-btn">😊</button>
                                    <button class="emoji-btn">👍</button>
                                    <button class="emoji-btn">❤️</button>
                                    <button class="emoji-btn">🎉</button>
                                    <button class="emoji-btn">🌈</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="it-event-area pt-115 pb-90" id="testimonies">
            <div class=container>
                <div class="row justify-content-center">
                    <div class=col-xl-7>
                        <div class="it-event-title-box text-center mb-50">
                            <span class=it-section-subtitle>Testimonies</span>
                            <h3 class="it-section-title pb-20">Healing Streams Testimonies </h3>
                        </div>
                    </div>
                </div>
                <div class=row>
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-30  wow itfadeUp" data-wow-duration=.9s data-wow-delay=.3s>
                        <div class=it-event-item>
                            <div class="it-event-thumb-box p-relative">
                                <div class=it-event-thumb>
                                    <img src="https://hsch.ceflixcdn.com/eths3/vow_adrew_mar23a.jpg" alt="">
                                </div>

                            </div>
                            <div class=it-event-content>

                                <h4 class="it-event-title pb-25"><a href=>ANAPHYLACTIC REACTION HEALED </a></h4>
                                <a class="it-btn " href="live.php?link=https://hsch.ceflixcdn.com/eths3/vow_adrew_mar23a.mp4&title=Anaphylactic Reaction Healed">
                                    <span>
                                        Play
                                        <svg width=15 height=14 viewBox="0 0 15 14" fill=none
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.6875 7.71875C14.0938 7.34375 14.0938 6.6875 13.6875 6.3125L8.6875 1.3125C8.3125 0.90625 7.65625 0.90625 7.28125 1.3125C6.875 1.6875 6.875 2.34375 7.28125 2.71875L10.5625 6H1C0.4375 6 0 6.46875 0 7C0 7.5625 0.4375 8 1 8H10.5625L7.28125 11.3125C6.875 11.6875 6.875 12.3438 7.28125 12.7188C7.65625 13.125 8.3125 13.125 8.6875 12.7188L13.6875 7.71875Z"
                                                fill=currentcolor />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-30  wow itfadeUp" data-wow-duration=.9s data-wow-delay=.5s>
                        <div class=it-event-item>
                            <div class="it-event-thumb-box p-relative">
                                <div class=it-event-thumb>
                                    <img src="https://hsch.ceflixcdn.com/eths3/vow_febwk2.jpg" alt="">
                                </div>

                            </div>
                            <div class=it-event-content>

                                <h4 class="it-event-title pb-25"><a href=>HEALED OF SEVERE AUTISM </a></h4>
                                <a class="it-btn " href="live.php?link=https://hsch.ceflixcdn.com/vow_febwk2.mp4&title=Healed of Severe Autism">
                                    <span>
                                        Play
                                        <svg width=15 height=14 viewBox="0 0 15 14" fill=none
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.6875 7.71875C14.0938 7.34375 14.0938 6.6875 13.6875 6.3125L8.6875 1.3125C8.3125 0.90625 7.65625 0.90625 7.28125 1.3125C6.875 1.6875 6.875 2.34375 7.28125 2.71875L10.5625 6H1C0.4375 6 0 6.46875 0 7C0 7.5625 0.4375 8 1 8H10.5625L7.28125 11.3125C6.875 11.6875 6.875 12.3438 7.28125 12.7188C7.65625 13.125 8.3125 13.125 8.6875 12.7188L13.6875 7.71875Z"
                                                fill=currentcolor />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-30  wow itfadeUp" data-wow-duration=.9s data-wow-delay=.7s>
                        <div class=it-event-item>
                            <div class="it-event-thumb-box p-relative">
                                <div class=it-event-thumb>
                                    <img src="https://hsch.ceflixcdn.com/eths3/vow_nov_24a.jpg" alt="">
                                </div>

                            </div>
                            <div class=it-event-content>

                                <h4 class="it-event-title pb-25"><a href=>RAISED FROM THE DEAD</a></h4>
                                <a class="it-btn " href="live.php?link=https://hsch.ceflixcdn.com/eths3/vow_nov_24.mp4&title=Raised from the Dead">
                                    <span>
                                        play
                                        <svg width=15 height=14 viewBox="0 0 15 14" fill=none
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.6875 7.71875C14.0938 7.34375 14.0938 6.6875 13.6875 6.3125L8.6875 1.3125C8.3125 0.90625 7.65625 0.90625 7.28125 1.3125C6.875 1.6875 6.875 2.34375 7.28125 2.71875L10.5625 6H1C0.4375 6 0 6.46875 0 7C0 7.5625 0.4375 8 1 8H10.5625L7.28125 11.3125C6.875 11.6875 6.875 12.3438 7.28125 12.7188C7.65625 13.125 8.3125 13.125 8.6875 12.7188L13.6875 7.71875Z"
                                                fill=currentcolor />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            // Initialize the HLS player
            document.addEventListener('DOMContentLoaded', function() {
                const video = document.getElementById('liveTvPlayer');
                const fullscreenBtn = document.querySelector('.fullscreen-btn');

                // Fullscreen functionality
                fullscreenBtn.addEventListener('click', function() {
                    if (video.requestFullscreen) {
                        video.requestFullscreen();
                    } else if (video.webkitRequestFullscreen) {
                        video.webkitRequestFullscreen();
                    } else if (video.msRequestFullscreen) {
                        video.msRequestFullscreen();
                    }
                });

                // HLS player setup
                if (Hls.isSupported()) {
                    const hls = new Hls();
                    hls.loadSource(video.querySelector('source').src);
                    hls.attachMedia(video);
                    hls.on(Hls.Events.MANIFEST_PARSED, function() {
                        video.play();
                    });
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    video.src = video.querySelector('source').src;
                    video.addEventListener('loadedmetadata', function() {
                        video.play();
                    });
                } else {
                    video.play();
                }

                // Simulate live comments (in a real app, this would come from a WebSocket or API)
                setInterval(function() {
                    const comments = [
                        "This is so much fun! 😊",
                        "I love the colors! 🌈",
                        "Can we watch this again?",
                        "The characters are so funny! 😂",
                        "This is my favorite show! ❤️",
                        "I learned something new today! 🎓",
                        "The song is stuck in my head! 🎵",
                        "My little brother loves this too! 👶"
                    ];

                    const emojis = ["😊", "👍", "❤️", "🎉", "🌈", "🐶", "🐱", "🦄", "🌟", "🎈"];
                    const randomEmoji = emojis[Math.floor(Math.random() * emojis.length)];

                    const users = [{
                            name: "HappyKid",
                            avatar: "https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Happy"
                        },
                        {
                            name: "JumpingJill",
                            avatar: "https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Jumping"
                        },
                        {
                            name: "SunnySam",
                            avatar: "https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Sunny"
                        },
                        {
                            name: "BouncyBen",
                            avatar: "https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Bouncy"
                        },
                        {
                            name: "GigglyGrace",
                            avatar: "https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Giggly"
                        },
                        {
                            name: "DancingDan",
                            avatar: "https://api.dicebear.com/6.x/bottts-neutral/svg?seed=Dancing"
                        }
                    ];

                    const randomUser = users[Math.floor(Math.random() * users.length)];
                    const randomComment = comments[Math.floor(Math.random() * comments.length)] + " " + randomEmoji;

                    const commentStream = document.querySelector('.comments-stream');
                    const newComment = document.createElement('div');
                    newComment.className = 'comment new';
                    newComment.innerHTML = `
            <div class="comment-avatar">
                <img src="${randomUser.avatar}" alt="User">
            </div>
            <div class="comment-content">
                <div class="comment-meta">
                    <span class="username">${randomUser.name}</span>
                    <span class="timestamp">just now</span>
                </div>
                <p class="comment-text">${randomComment}</p>
            </div>
        `;

                    commentStream.insertBefore(newComment, commentStream.firstChild);

                    // Update comment count
                    const countElement = document.querySelector('.comment-count');
                    countElement.textContent = parseInt(countElement.textContent) + 1;

                    // Update viewer count randomly
                    const viewerCount = document.getElementById('viewer-count');
                    const currentViewers = parseInt(viewerCount.textContent.replace(/,/g, ''));
                    const change = Math.floor(Math.random() * 10) - 3; // Random change between -3 and +6
                    viewerCount.textContent = (currentViewers + change).toLocaleString();

                    // Auto-scroll if at bottom
                    if (commentStream.scrollTop + commentStream.clientHeight >= commentStream.scrollHeight - 50) {
                        commentStream.scrollTop = commentStream.scrollHeight;
                    }
                }, 4000);

                // Emoji picker functionality
                document.querySelectorAll('.emoji-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const input = document.querySelector('.comment-form input');
                        input.value += this.textContent;
                        input.focus();
                    });
                });
            });
        </script>
        <?php
require_once 'include/Controller.php';
$Controller = new Controller();

// Process form submission if posted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['participant_submit'])) {
    $email = $_POST['email'] ?? null;
    $participantCount = intval($_POST['participant_count'] ?? 1);
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    
    // Check if user exists in registration tables
    $isRegistered = false;
    $userId = null;
    $userType = null;
    
    if ($email) {
        $isRegistered = $Controller->checkExistingUser($email);
        if ($isRegistered) {
            $userId = $Controller->getUserIdByEmail($email);
            $userType = 'email';
        }
    }
    
    // Prepare participation data
    $participationData = [
        'user_id' => $userId,
        'user_type' => $userType,
        'participant_count' => $participantCount,
        'email' => $email,
        'day_number' => 1, // Today is day 1
        'participation_date' => date('Y-m-d'),
        'ip_address' => $ipAddress,
        'is_registered' => $isRegistered ? 1 : 0
    ];
    
    // Check for existing participation today
    if ($userId) {
        $existingParticipation = $Controller->getTodaysParticipation($userId, $userType);
        if ($existingParticipation) {
            // Update existing record
            $Controller->updateParticipation($existingParticipation['id'], $participationData);
        } else {
            // Create new record
            $Controller->participants($participationData);
        }
    } else {
        // Create new record for unregistered user
        $Controller->participants($participationData);
    }
    
    // Set session flag to prevent showing modal again today
    $_SESSION['participated_today'] = true;
}
?>

<!-- Bootstrap Modal HTML -->
<div class="modal fade" id="participantModal" tabindex="-1" aria-labelledby="participantModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="participantModalLabel">Event Participation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="">
        <div class="modal-body">
          <div class="mb-3">
            <label for="participant_count" class="form-label">Number of Participants</label>
            <input type="number" class="form-control" id="participant_count" name="participant_count" min="1" value="1" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="participant_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
// Show modal only if user hasn't participated today
if (empty($_SESSION['participated_today'])): ?>
<script>
  // Show modal on page load
  document.addEventListener('DOMContentLoaded', function() {
    var participantModal = new bootstrap.Modal(document.getElementById('participantModal'));
    participantModal.show();
  });
</script>
<?php endif; ?>


        <!-- Include HLS.js for streaming playback -->
        <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    </main>
    <?php include_once('partials/healingRegistrationModal.php'); ?>

    <!-- footer start-->
    <?php include_once('partials/footer.php') ?>

    <!-- {{-- End Footer --}} -->
    <script src="assets/js/jquery-1.js"></script>
    <script src="assets/js/waypoints-1.js"></script>
    <script src="assets/js/bootstrap.bundle.min-1.js"></script>
    <script src="assets/js/slick.min-1.js"></script>
    <script src="assets/js/magnific-popup-1.js"></script>
    <script src="assets/js/purecounter-1.js"></script>
    <script src="assets/js/wow-1.js"></script>
    <script src="assets/js/nice-select-1.js"></script>
    <script src="assets/js/swiper-bundle-1.js"></script>
    <script src="assets/js/isotope-pkgd-1.js"></script>
    <script src="assets/js/imagesloaded-pkgd-1.js"></script>
    <script src="assets/js/ajax-form-1.js"></script>
    <script src="assets/js/main-1.js"></script>
</body>

</html>