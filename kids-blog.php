<?php
require_once __DIR__ . '/include/Session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kids Blog</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .blog-hero { background:#f0f7ff; padding:40px 0; text-align:center; }
        .post-card { background:#fff; border:1px solid #eee; border-radius:8px; padding:16px; margin-bottom:16px; }
        .post-title { font-size:20px; color:#2b6cb0; margin-bottom:8px; }
        .post-meta { color:#666; font-size:12px; margin-bottom:10px; }
    </style>
    <?php include __DIR__ . '/partials/header.php'; ?>
</head>
<body>
<div class="blog-hero">
    <h1>Kids Blog</h1>
    <p>Fun stories, testimonies and activities for kids!</p>
    <a class="it-btn theme-2-bg circle-effect" data-bs-toggle="modal" data-bs-target="#healingRegistrationModal"><span>Join the fun</span></a>
    <div style="margin-top:10px;">
        <a href="assets/magazine/HTTN_Magazine_For_Kids_September_2025_FOR_PRINT.pdf" target="_blank">Download latest Magazine</a>
    </div>
    <script>/* include the modal markup at the end of body on other pages */</script>
</div>

<div class="container my-4">
    <div class="row">
        <div class="col-md-8">
            <?php
            $posts = [
                ['title' => '5 Fun Faith Activities for Kids', 'date' => date('M j, Y'), 'excerpt' => 'Try these activities to build your faith while having fun!'],
                ['title' => 'Testimony: Healing at Home', 'date' => date('M j, Y', strtotime('-3 days')), 'excerpt' => 'Read how Daniel received his healing right at home.'],
                ['title' => 'Memory Verse Challenge', 'date' => date('M j, Y', strtotime('-7 days')), 'excerpt' => 'Join our memory verse challenge and win exciting gifts!'],
            ];
            foreach ($posts as $p): ?>
                <div class="post-card">
                    <div class="post-title"><?php echo htmlspecialchars($p['title']); ?></div>
                    <div class="post-meta">Posted on <?php echo htmlspecialchars($p['date']); ?></div>
                    <div class="post-excerpt"><?php echo htmlspecialchars($p['excerpt']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <div class="post-card">
                <h3>Categories</h3>
                <ul>
                    <li>Activities</li>
                    <li>Testimonies</li>
                    <li>Challenges</li>
                </ul>
            </div>
            <div class="post-card">
                <h3>Subscribe</h3>
                <p>Get updates on new posts and events.</p>
                <a class="it-btn theme-2-bg circle-effect" data-bs-toggle="modal" data-bs-target="#healingRegistrationModal"><span>Register Now</span></a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/healingRegistrationModal.php'; ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
