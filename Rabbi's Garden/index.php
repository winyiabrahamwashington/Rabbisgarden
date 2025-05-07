<?php
session_start();

// SETTINGS - CHANGE THESE TO YOUR CREDENTIALS
$username = "admin";
$password = "StrongPassword123!"; // Change this to a secure password
$topics_file = "topics_data.json"; // This will store all topics data

// LOGIN HANDLER
if (isset($_POST['login'])) {
    if ($_POST['user'] === $username && $_POST['pass'] === $password) {
        $_SESSION['logged_in'] = true;
    } else {
        $error = "Invalid credentials!";
    }
}

// LOGOUT HANDLER
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// LOAD OR INITIALIZE TOPICS DATA
function loadTopics() {
    global $topics_file;
    if (file_exists($topics_file)) {
        return json_decode(file_get_contents($topics_file), true);
    } else {
        // Default topics data
        $default_topics = [
            [
                'id' => 1,
                'title' => "Prayer Life",
                'description' => "Developing a consistent and powerful prayer life that transforms your relationship with God.",
                'image' => "https://images.unsplash.com/photo-1532102235608-dc8f0e4f0a2e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
                'icon' => "fas fa-pray",
                'content' => "<h4>Developing a Powerful Prayer Life</h4>
                <p>Prayer is the lifeline of every believer. In this teaching, we explore how to develop a consistent and effective prayer life that transforms your relationship with God.</p>
                <p>Key points include:</p>
                <ul>
                    <li>Understanding different types of prayer</li>
                    <li>Creating a prayer routine</li>
                    <li>Overcoming common prayer obstacles</li>
                </ul>"
            ],
            [
                'id' => 2,
                'title' => "Bible Study",
                'description' => "Effective methods for studying God's Word that lead to life transformation.",
                'image' => "https://images.unsplash.com/photo-1452421822248-d4c2b47f0c81?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
                'icon' => "fas fa-bible",
                'content' => "<h4>Effective Bible Study Methods</h4>
                <p>The Bible is God's living Word to us, and studying it should be a dynamic, life-changing experience.</p>
                <p>We'll examine:</p>
                <ul>
                    <li>The inductive Bible study method</li>
                    <li>Understanding cultural context</li>
                    <li>Applying Scripture to modern life</li>
                </ul>"
            ],
            [
                'id' => 3,
                'title' => "Christian Service",
                'description' => "Discovering and using your spiritual gifts to serve in God's kingdom.",
                'image' => "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
                'icon' => "fas fa-hands-helping",
                'content' => "<h4>Serving in God's Kingdom</h4>
                <p>Every believer is called to serve in God's kingdom. This teaching explores how to discover your spiritual gifts.</p>
                <p>Topics covered:</p>
                <ul>
                    <li>Identifying your spiritual gifts</li>
                    <li>Finding your place in the body of Christ</li>
                    <li>Serving with the right motives</li>
                </ul>"
            ],
            [
                'id' => 4,
                'title' => "Family Life",
                'description' => "Building a godly home that reflects Christ's love to the world.",
                'image' => "https://images.unsplash.com/photo-1470509037663-253afd7f0f51?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
                'icon' => "fas fa-home",
                'content' => "<h4>Building a Godly Family</h4>
                <p>In a world with competing values, building a Christian home is both challenging and essential.</p>
                <p>Key areas:</p>
                <ul>
                    <li>Biblical roles in the family</li>
                    <li>Raising children in the faith</li>
                    <li>Creating a godly home environment</li>
                </ul>"
            ],
            [
                'id' => 5,
                'title' => "Relationships",
                'description' => "Biblical principles for godly relationships in all areas of life.",
                'image' => "https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
                'icon' => "fas fa-heart",
                'content' => "<h4>Godly Relationships</h4>
                <p>Healthy relationships are foundational to Christian living. This teaching explores biblical principles.</p>
                <p>Topics include:</p>
                <ul>
                    <li>Biblical friendship</li>
                    <li>Dating and courtship with purity</li>
                    <li>Resolving conflicts biblically</li>
                </ul>"
            ],
            [
                'id' => 6,
                'title' => "Salvation",
                'description' => "Understanding God's gift of salvation and living as a new creation.",
                'image' => "https://images.unsplash.com/photo-1506126613408-eca07ce68773?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
                'icon' => "fas fa-cross",
                'content' => "<h4>The Gift of Salvation</h4>
                <p>Salvation is the foundation of the Christian life. This teaching explains what salvation is.</p>
                <p>Key concepts:</p>
                <ul>
                    <li>Understanding grace</li>
                    <li>The meaning of repentance</li>
                    <li>Living as a new creation</li>
                </ul>"
            ],
            [
                'id' => 7,
                'title' => "Worship",
                'description' => "The heart of true worship and its transformative power in our lives.",
                'image' => "https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
                'icon' => "fas fa-praying-hands",
                'content' => "<h4>The Heart of True Worship</h4>
                <p>Worship is more than music - it's a lifestyle of honoring God in all we do.</p>
                <p>Key aspects:</p>
                <ul>
                    <li>Understanding worship as a lifestyle</li>
                    <li>The biblical model of worship</li>
                    <li>Overcoming distractions in worship</li>
                </ul>"
            ],
            [
                'id' => 8,
                'title' => "Faith",
                'description' => "Growing in faith that moves mountains and pleases God.",
                'image' => "https://images.unsplash.com/photo-1452421822248-d4c2b47f0c81?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
                'icon' => "fas fa-mountain",
                'content' => "<h4>Growing in Faith</h4>
                <p>Faith is the foundation of our walk with God. This teaching explores how to develop faith.</p>
                <p>Key principles:</p>
                <ul>
                    <li>Understanding what faith is</li>
                    <li>How faith grows through testing</li>
                    <li>Overcoming doubt and unbelief</li>
                </ul>"
            ],
            [
                'id' => 9,
                'title' => "Spiritual Growth",
                'description' => "Practical steps to grow spiritually and mature in Christ.",
                'image' => "https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
                'icon' => "fas fa-seedling",
                'content' => "<h4>Path to Spiritual Maturity</h4>
                <p>Spiritual growth is the process of becoming more like Christ.</p>
                <p>Key elements:</p>
                <ul>
                    <li>The stages of spiritual growth</li>
                    <li>Spiritual disciplines that foster growth</li>
                    <li>Measuring spiritual progress</li>
                </ul>"
            ]
        ];
        file_put_contents($topics_file, json_encode($default_topics, JSON_PRETTY_PRINT));
        return $default_topics;
    }
}

// SAVE TOPICS DATA
function saveTopics($topics) {
    global $topics_file;
    file_put_contents($topics_file, json_encode($topics, JSON_PRETTY_PRINT));
}

// HANDLE TOPIC ACTIONS
if (isset($_SESSION['logged_in'])) {
    $topics = loadTopics();
    
    // ADD NEW TOPIC
    if (isset($_POST['add_topic'])) {
        $new_id = !empty($topics) ? max(array_column($topics, 'id')) + 1 : 1;
        $new_topic = [
            'id' => $new_id,
            'title' => $_POST['title'] ?? 'New Topic',
            'description' => $_POST['description'] ?? 'Description here',
            'image' => $_POST['image'] ?? 'https://images.unsplash.com/photo-1452421822248-d4c2b47f0c81?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            'icon' => $_POST['icon'] ?? 'fas fa-cross',
            'content' => $_POST['content'] ?? '<p>Content goes here</p>'
        ];
        $topics[] = $new_topic;
        saveTopics($topics);
        $message = "New topic added successfully!";
        header("Location: ?");
        exit();
    }
    
    // UPDATE TOPIC
    if (isset($_POST['update_topic'])) {
        $id = (int)$_POST['id'];
        foreach ($topics as &$topic) {
            if ($topic['id'] == $id) {
                $topic['title'] = $_POST['title'];
                $topic['description'] = $_POST['description'];
                $topic['image'] = $_POST['image'];
                $topic['icon'] = $_POST['icon'];
                $topic['content'] = $_POST['content'];
                break;
            }
        }
        saveTopics($topics);
        $message = "Topic updated successfully!";
        header("Location: ?");
        exit();
    }
    
    // DELETE TOPIC
    if (isset($_GET['delete_topic'])) {
        $id = (int)$_GET['delete_topic'];
        $topics = array_filter($topics, function($topic) use ($id) {
            return $topic['id'] != $id;
        });
        $topics = array_values($topics); // Reindex array
        saveTopics($topics);
        $message = "Topic deleted successfully!";
        header("Location: ?");
        exit();
    }
    
    // REORDER TOPICS
    if (isset($_POST['reorder_topics'])) {
        $new_order = json_decode($_POST['topic_order'], true);
        $reordered_topics = [];
        foreach ($new_order as $id) {
            foreach ($topics as $topic) {
                if ($topic['id'] == $id) {
                    $reordered_topics[] = $topic;
                    break;
                }
            }
        }
        saveTopics($reordered_topics);
        $message = "Topics reordered successfully!";
        header("Location: ?");
        exit();
    }
}

// Generate HTML for topics display
function generateTopicsHTML($topics) {
    $html = '';
    foreach ($topics as $topic) {
        $html .= <<<HTML
        <!-- Topic {$topic['id']} - {$topic['title']} -->
        <div class="topic-card" onclick="openTopicModal({$topic['id']})">
          <div class="topic-img">
            <img src="{$topic['image']}" alt="{$topic['title']}">
            <div class="topic-icon">
              <i class="{$topic['icon']}"></i>
            </div>
          </div>
          <div class="topic-content">
            <h3>{$topic['title']}</h3>
            <p>{$topic['description']}</p>
            <span class="learn-more">Learn More →</span>
          </div>
        </div>
HTML;
    }
    return $html;
}

// Get current topics HTML
$current_content = isset($_SESSION['logged_in']) ? generateTopicsHTML($topics) : (file_exists($topics_file) ? generateTopicsHTML(loadTopics()) : '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rabbi's Garden - Sermons & Teachings</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Global Styles */
    :root {
      --primary-color: #2d6a4f;
      --secondary-color: #4caf50;
      --accent-color: #ffb703;
      --dark-color: #1b4332;
      --light-color: #f9f9f9;
      --text-color: #333;
      --white: #ffffff;
      --primary-green: #1e8449;
      --dark-green: #145a32;
      --light-green: #58d68d;
      --gold-accent: #f1c40f;
      --pure-white: #ffffff;
      --off-white: #f8f9fa;
      --dark-bg: #1a1a1a;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      color: var(--text-color);
      line-height: 1.6;
      overflow-x: hidden;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: 'Playfair Display', serif;
      color: var(--primary-color);
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      width: 100%;
    }

    .btn {
      display: inline-block;
      background-color: var(--secondary-color);
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 5px;
      font-size: 1em;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: 500;
    }

    .btn:hover {
      background-color: var(--dark-color);
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Navigation */
    nav {
      background-color: var(--pure-white);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .nav-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
    }

    .logo {
      font-family: 'Montserrat', sans-serif;
      font-weight: 900;
      font-size: 1.8rem;
      color: var(--primary-green);
      display: flex;
      align-items: center;
    }

    .logo i {
      margin-right: 10px;
      color: var(--gold-accent);
    }

    .nav-links {
      display: flex;
      list-style: none;
    }

    .nav-links li {
      margin-left: 2rem;
    }

    .nav-links a {
      font-weight: 600;
      transition: color 0.3s;
      position: relative;
      padding: 5px 0;
    }

    .nav-links a.active {
      color: var(--primary-green);
    }

    .nav-links a:hover {
      color: var(--primary-green);
    }

    .nav-links a:after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: var(--primary-green);
      transition: width 0.3s;
    }

    .nav-links a:hover:after,
    .nav-links a.active:after {
      width: 100%;
    }

    /* Hamburger Menu */
    .hamburger {
      display: none;
      cursor: pointer;
      font-size: 1.5rem;
    }

    /* Hero Section */
    .hero {
      height: 60vh;
      min-height: 500px;
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://i.pinimg.com/736x/d9/42/e6/d942e6583e3661c5ea62070ce9300189.jpg') no-repeat center center/cover;
      display: flex;
      align-items: center;
      text-align: center;
      color: var(--white);
      padding-top: 80px;
    }

    .hero-content {
      max-width: 800px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .hero h1 {
      font-size: clamp(2.5rem, 5vw, 4.5rem);
      margin-bottom: 20px;
      color: var(--white);
      text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
    }

    .hero p {
      font-size: clamp(1.1rem, 2vw, 1.5rem);
      margin-bottom: 30px;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
    }

    /* Sections */
    section {
      padding: 80px 0;
    }

    .section-title {
      text-align: center;
      margin-bottom: 60px;
    }

    .section-title h2 {
      font-size: clamp(2rem, 4vw, 3rem);
      margin-bottom: 15px;
      position: relative;
      display: inline-block;
    }

    .section-title h2::after {
      content: '';
      position: absolute;
      width: 80px;
      height: 4px;
      background: var(--accent-color);
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
    }

    .section-title p {
      font-size: clamp(1rem, 1.3vw, 1.3rem);
      color: #666;
      max-width: 700px;
      margin: 0 auto;
    }

    /* Sermons Section */
    .sermons {
      background-color: var(--light-color);
    }

    .sermons-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 30px;
    }

    .sermon-card {
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .sermon-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .sermon-img {
      height: 200px;
      overflow: hidden;
    }

    .sermon-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
    }

    .sermon-card:hover .sermon-img img {
      transform: scale(1.1);
    }

    .sermon-content {
      padding: 25px;
    }

    .sermon-content h3 {
      font-size: 1.5em;
      margin-bottom: 10px;
    }

    .sermon-meta {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      color: #666;
      font-size: 0.9em;
    }

    .sermon-content p {
      margin-bottom: 20px;
      color: #666;
    }

    .watch-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      background-color: var(--primary-color);
      color: white;
      padding: 8px 20px;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s;
    }

    .watch-btn:hover {
      background-color: var(--dark-color);
    }

    /* Scripture Panel */
    .scripture-panel {
      background: linear-gradient(135deg, var(--primary-color), var(--dark-color));
      color: white;
      padding: 60px 0;
      margin: 80px 0;
      text-align: center;
    }

    .scripture-panel .container {
      max-width: 800px;
    }

    .scripture-panel h2 {
      color: white;
      margin-bottom: 30px;
    }

    .scripture-text {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.2rem, 2vw, 1.8rem);
      line-height: 1.8;
      margin-bottom: 30px;
      font-style: italic;
    }

    .scripture-ref {
      font-weight: 600;
      font-size: 1.1em;
    }

    /* YouTube Channel Section */
    .youtube-channel {
      background-color: white;
      padding: 80px 0;
      text-align: center;
    }

    .youtube-channel .btn {
      margin-top: 30px;
    }

    /* Topics Section - Updated */
    .topics {
      background-color: var(--light-color);
    }

    .topics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 30px;
    }

    .topic-card {
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s;
      cursor: pointer;
    }

    .topic-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .topic-img {
      height: 200px;
      overflow: hidden;
      position: relative;
    }

    .topic-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
    }

    .topic-card:hover .topic-img img {
      transform: scale(1.1);
    }

    .topic-icon {
      position: absolute;
      bottom: 20px;
      right: 20px;
      background-color: rgba(255, 255, 255, 0.9);
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8em;
      color: var(--primary-color);
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
      transition: all 0.3s;
    }

    .topic-card:hover .topic-icon {
      background-color: var(--primary-color);
      color: white;
      transform: scale(1.1);
    }

    .topic-content {
      padding: 25px;
    }

    .topic-content h3 {
      font-size: 1.4em;
      margin-bottom: 10px;
      color: var(--primary-color);
    }

    .topic-content p {
      color: #666;
      margin-bottom: 15px;
      font-size: 0.95em;
    }

    .learn-more {
      display: inline-block;
      color: var(--primary-color);
      font-weight: 600;
      font-size: 0.9em;
      transition: color 0.3s;
    }

    .topic-card:hover .learn-more {
      color: var(--dark-color);
    }

    /* Topic Modal */
    .topic-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      z-index: 2000;
      overflow-y: auto;
    }

    .modal-content {
      background-color: white;
      margin: 80px auto;
      max-width: 800px;
      width: 90%;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
      animation: modalFadeIn 0.4s;
    }

    @keyframes modalFadeIn {
      from { opacity: 0; transform: translateY(-50px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
      background-color: var(--primary-color);
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-header h3 {
      color: white;
      margin: 0;
    }

    .close-modal {
      background: none;
      border: none;
      color: white;
      font-size: 1.5em;
      cursor: pointer;
    }

    .modal-body {
      padding: 30px;
    }

    .modal-body img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    /* Footer */
    footer {
      background-color: var(--dark-bg);
      color: white;
      padding: 4rem 0 2rem;
    }

    .footer-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .footer-logo {
      font-family: 'Montserrat', sans-serif;
      font-weight: 900;
      font-size: 1.8rem;
      color: var(--pure-white);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
    }

    .footer-logo i {
      margin-right: 10px;
      color: var(--gold-accent);
    }

    .footer-about p {
      margin-bottom: 1rem;
      color: #aaa;
    }

    .footer-links h3, .footer-social h3 {
      color: var(--pure-white);
      margin-bottom: 1.5rem;
      font-size: 1.2rem;
      position: relative;
      padding-bottom: 10px;
    }

    .footer-links h3:after, .footer-social h3:after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 50px;
      height: 2px;
      background-color: var(--gold-accent);
    }

    .footer-links ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-links li {
      margin-bottom: 0.8rem;
    }

    .footer-links a {
      color: #aaa;
      text-decoration: none;
      transition: color 0.3s;
    }

    .footer-links a:hover {
      color: var(--light-green);
    }

    .social-icons {
      display: flex;
      gap: 1rem;
    }

    .social-icons a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background-color: transparent;
      border-radius: 50%;
      color: var(--light-green);
      border: 2px solid var(--light-green);
      transition: all 0.3s;
    }

    .social-icons a:hover {
      background-color: var(--light-green);
      color: var(--dark-bg);
      transform: translateY(-3px);
    }

    .footer-bottom {
      text-align: center;
      padding-top: 2rem;
      border-top: 1px solid #333;
      color: #777;
      font-size: 0.9rem;
    }

    /* Privacy Policy Modal */
    .privacy-modal {
      display: none;
      position: fixed;
      z-index: 2000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.8);
    }

    .privacy-modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 30px;
      border-radius: 10px;
      width: 80%;
      max-width: 800px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      position: relative;
    }

    .privacy-close {
      color: #aaa;
      position: absolute;
      top: 15px;
      right: 25px;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .privacy-close:hover {
      color: #333;
    }

    /* Admin Panel Styles */
    .admin-panel {
      font-family: 'Poppins', sans-serif;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    
    .admin-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 2px solid var(--primary-color);
    }
    
    .admin-title {
      font-family: 'Playfair Display', serif;
      color: var(--primary-color);
      font-size: 2rem;
    }
    
    .admin-logout {
      background-color: var(--primary-color);
      color: white;
      padding: 8px 20px;
      border-radius: 5px;
      text-decoration: none;
      transition: all 0.3s;
    }
    
    .admin-logout:hover {
      background-color: var(--dark-color);
    }
    
    .admin-message {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 5px;
      color: white;
    }
    
    .admin-message.success {
      background-color: var(--primary-color);
    }
    
    .admin-message.error {
      background-color: #e74c3c;
    }
    
    .admin-sections {
      display: grid;
      grid-template-columns: 300px 1fr;
      gap: 30px;
    }
    
    .admin-sidebar {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      height: fit-content;
    }
    
    .admin-main {
      background: white;
      border-radius: 8px;
      padding: 25px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .sidebar-title {
      font-family: 'Playfair Display', serif;
      color: var(--primary-color);
      margin-bottom: 20px;
      font-size: 1.3rem;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }
    
    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .sidebar-menu li {
      margin-bottom: 10px;
    }
    
    .sidebar-menu a {
      display: block;
      padding: 10px 15px;
      color: #555;
      text-decoration: none;
      border-radius: 5px;
      transition: all 0.3s;
    }
    
    .sidebar-menu a:hover, 
    .sidebar-menu a.active {
      background-color: var(--primary-color);
      color: white;
    }
    
    .sidebar-menu i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }
    
    .section-title {
      font-family: 'Playfair Display', serif;
      color: var(--primary-color);
      margin-bottom: 25px;
      font-size: 1.5rem;
      position: relative;
      padding-bottom: 10px;
    }
    
    .section-title:after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 60px;
      height: 3px;
      background-color: var(--primary-color);
    }
    
    .topics-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .topics-list li {
      background: #f9f9f9;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.3s;
      border-left: 4px solid var(--primary-color);
    }
    
    .topics-list li:hover {
      background: #f1f1f1;
      transform: translateX(5px);
    }
    
    .topic-actions {
      display: flex;
      gap: 10px;
    }
    
    .action-btn {
      padding: 5px 10px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 0.9rem;
    }
    
    .edit-btn {
      background-color: #3498db;
      color: white;
    }
    
    .edit-btn:hover {
      background-color: #2980b9;
    }
    
    .delete-btn {
      background-color: #e74c3c;
      color: white;
    }
    
    .delete-btn:hover {
      background-color: #c0392b;
    }
    
    .add-btn {
      background-color: var(--primary-color);
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-bottom: 20px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    
    .add-btn:hover {
      background-color: var(--dark-color);
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
    }
    
    .form-control {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-family: 'Poppins', sans-serif;
      font-size: 1rem;
    }
    
    .form-control:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
    }
    
    textarea.form-control {
      min-height: 200px;
      resize: vertical;
    }
    
    .editor-toolbar {
      background: #f5f5f5;
      padding: 10px;
      border-radius: 5px 5px 0 0;
      border: 1px solid #ddd;
      border-bottom: none;
    }
    
    .editor-toolbar button {
      background: white;
      border: 1px solid #ddd;
      padding: 5px 10px;
      margin-right: 5px;
      border-radius: 3px;
      cursor: pointer;
    }
    
    .editor-toolbar button:hover {
      background: #eee;
    }
    
    .editor-textarea {
      border-radius: 0 0 5px 5px !important;
    }
    
    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      margin-top: 20px;
    }
    
    .btn {
      padding: 10px 25px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      transition: all 0.3s;
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      color: white;
    }
    
    .btn-primary:hover {
      background-color: var(--dark-color);
    }
    
    .btn-secondary {
      background-color: #95a5a6;
      color: white;
    }
    
    .btn-secondary:hover {
      background-color: #7f8c8d;
    }
    
    .sortable-ghost {
      opacity: 0.5;
      background: #c8ebfb;
    }
    
    .drag-handle {
      cursor: move;
      margin-right: 10px;
      color: #777;
    }
    
    .icon-preview {
      font-size: 1.5rem;
      margin-left: 10px;
      color: var(--primary-color);
    }
    
    /* Login Form Styles */
    .login-container {
      max-width: 500px;
      margin: 50px auto;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      padding: 30px;
    }
    
    .login-title {
      font-family: 'Playfair Display', serif;
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 30px;
      font-size: 1.8rem;
    }
    
    .login-form .form-group {
      margin-bottom: 20px;
    }
    
    .login-form label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
    }
    
    .login-form input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
    }
    
    .login-form button {
      width: 100%;
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .login-form button:hover {
      background-color: var(--dark-color);
    }
    
    /* Mobile Responsive */
    @media screen and (max-width: 992px) {
      .nav-container {
        padding: 1rem;
      }

      .nav-links {
        position: fixed;
        top: 80px;
        left: -100%;
        width: 100%;
        height: calc(100vh - 80px);
        background: var(--pure-white);
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: left 0.3s;
      }

      .nav-links.active {
        left: 0;
      }

      .nav-links li {
        margin: 15px 0;
      }

      .hamburger {
        display: block;
      }

      .hero {
        height: auto;
        padding: 120px 0 80px;
      }

      .sermons-grid,
      .topics-grid {
        grid-template-columns: 1fr;
      }
      
      .admin-sections {
        grid-template-columns: 1fr;
      }
      
      .admin-sidebar {
        margin-bottom: 30px;
      }
    }

    @media screen and (max-width: 576px) {
      .logo {
        font-size: 1.5rem;
      }
      
      .hero h1 {
        font-size: 2.2rem;
      }
      
      .hero p {
        font-size: 1rem;
      }
      
      .footer-container {
        grid-template-columns: 1fr;
        text-align: center;
      }
      
      .social-icons {
        justify-content: center;
      }
      
      .footer-links h3:after, 
      .footer-social h3:after {
        left: 50%;
        transform: translateX(-50%);
      }
      
      .admin-header {
        flex-direction: column;
        gap: 15px;
      }
      
      .topic-actions {
        flex-direction: column;
        gap: 5px;
      }
      
      .action-btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <?php if (!isset($_SESSION['logged_in'])): ?>
    <!-- Login Form -->
    <div class="login-container">
      <h1 class="login-title">Admin Login</h1>
      <?php if (isset($error)): ?>
        <div class="admin-message error"><?= $error ?></div>
      <?php endif; ?>
      <form class="login-form" method="post">
        <div class="form-group">
          <label for="user">Username</label>
          <input type="text" id="user" name="user" required>
        </div>
        <div class="form-group">
          <label for="pass">Password</label>
          <input type="password" id="pass" name="pass" required>
        </div>
        <button type="submit" name="login">Login</button>
      </form>
    </div>
  <?php else: ?>
    <!-- Admin Panel -->
    <div class="admin-panel">
      <div class="admin-header">
        <h1 class="admin-title">Rabbi's Garden Admin Panel</h1>
        <a href="?logout=true" class="admin-logout">Logout</a>
      </div>
      
      <?php if (isset($message)): ?>
        <div class="admin-message success"><?= $message ?></div>
      <?php endif; ?>
      
      <div class="admin-sections">
        <!-- Sidebar Navigation -->
        <div class="admin-sidebar">
          <h3 class="sidebar-title">Admin Menu</h3>
          <ul class="sidebar-menu">
            <li><a href="#" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="#topics"><i class="fas fa-book-open"></i> Manage Topics</a></li>
            <li><a href="#"><i class="fas fa-video"></i> Sermons</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
          </ul>
        </div>
        
        <!-- Main Content Area -->
        <div class="admin-main">
          <?php if (!isset($_GET['edit_topic']) && !isset($_GET['add_topic'])): ?>
            <!-- Topics List -->
            <div id="topics">
              <div class="section-title">
                <h2>Manage Topics</h2>
                <p>Add, edit, or delete topics and arrange their display order.</p>
              </div>
              
              <button class="add-btn" onclick="window.location.href='?add_topic=true'">
                <i class="fas fa-plus"></i> Add New Topic
              </button>
              
              <form id="reorderForm" method="post">
                <input type="hidden" name="reorder_topics" value="1">
                <input type="hidden" name="topic_order" id="topicOrder">
                <ul class="topics-list" id="sortable">
                  <?php foreach ($topics as $topic): ?>
                    <li data-id="<?= $topic['id'] ?>">
                      <div>
                        <i class="fas fa-grip-lines drag-handle"></i>
                        <strong><?= $topic['title'] ?></strong>
                      </div>
                      <div class="topic-actions">
                        <a href="?edit_topic=<?= $topic['id'] ?>" class="action-btn edit-btn">
                          <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="?delete_topic=<?= $topic['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this topic?');">
                          <i class="fas fa-trash"></i> Delete
                        </a>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <button type="submit" class="btn btn-primary" id="saveOrderBtn" style="display: none;">
                  Save New Order
                </button>
              </form>
            </div>
            
            <!-- Preview Section -->
            <div style="margin-top: 50px;">
              <div class="section-title">
                <h2>Topics Preview</h2>
                <p>This is how your topics section will appear on the website.</p>
              </div>
              
              <div style="margin-top: 30px; padding: 20px; background: var(--light-color); border-radius: 8px;">
                <h2 style="text-align: center; font-family: 'Playfair Display', serif; color: var(--primary-color); margin-bottom: 15px; position: relative; display: inline-block; left: 50%; transform: translateX(-50%);">Explore Christian Topics</h2>
                <p style="text-align: center; color: #666; max-width: 700px; margin: 0 auto 30px;">Dive deeper into various aspects of Christian living and biblical teachings.</p>
                
                <div class="topics-grid">
                  <?= $current_content ?>
                </div>
              </div>
            </div>
          <?php elseif (isset($_GET['add_topic'])): ?>
            <!-- Add New Topic Form -->
            <div class="section-title">
              <h2>Add New Topic</h2>
              <p>Fill out the form below to create a new topic.</p>
            </div>
            
            <form method="post">
              <input type="hidden" name="add_topic" value="1">
              
              <div class="form-group">
                <label for="title">Topic Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
              </div>
              
              <div class="form-group">
                <label for="description">Short Description</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
              </div>
              
              <div class="form-group">
                <label for="image">Image URL</label>
                <input type="text" id="image" name="image" class="form-control" required>
                <small>Paste a direct image URL (e.g., from Unsplash)</small>
              </div>
              
              <div class="form-group">
                <label for="icon">Icon Class</label>
                <div style="display: flex; align-items: center;">
                  <input type="text" id="icon" name="icon" class="form-control" value="fas fa-cross" required>
                  <span class="icon-preview"><i class="fas fa-cross"></i></span>
                </div>
                <small>Use Font Awesome icon classes (e.g., fas fa-pray, fas fa-bible)</small>
              </div>
              
              <div class="form-group">
                <label for="content">Detailed Content</label>
                <div class="editor-toolbar">
                  <button type="button" onclick="formatText('bold')"><i class="fas fa-bold"></i></button>
                  <button type="button" onclick="formatText('italic')"><i class="fas fa-italic"></i></button>
                  <button type="button" onclick="formatText('underline')"><i class="fas fa-underline"></i></button>
                  <button type="button" onclick="insertText('<h4>', '</h4>')">H4</button>
                  <button type="button" onclick="insertText('<h5>', '</h5>')">H5</button>
                  <button type="button" onclick="insertText('<ul>\n<li>', '</li>\n</ul>')">List</button>
                  <button type="button" onclick="insertText('<blockquote>', '</blockquote>')">Quote</button>
                </div>
                <textarea id="content" name="content" class="form-control editor-textarea" rows="10" required></textarea>
              </div>
              
              <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='?'">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Topic</button>
              </div>
            </form>
          <?php elseif (isset($_GET['edit_topic'])): ?>
            <!-- Edit Topic Form -->
            <?php 
              $edit_id = (int)$_GET['edit_topic'];
              $edit_topic = null;
              foreach ($topics as $topic) {
                if ($topic['id'] == $edit_id) {
                  $edit_topic = $topic;
                  break;
                }
              }
              
              if ($edit_topic):
            ?>
              <div class="section-title">
                <h2>Edit Topic</h2>
                <p>Make changes to this topic below.</p>
              </div>
              
              <form method="post">
                <input type="hidden" name="update_topic" value="1">
                <input type="hidden" name="id" value="<?= $edit_topic['id'] ?>">
                
                <div class="form-group">
                  <label for="title">Topic Title</label>
                  <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($edit_topic['title']) ?>" required>
                </div>
                
                <div class="form-group">
                  <label for="description">Short Description</label>
                  <textarea id="description" name="description" class="form-control" rows="3" required><?= htmlspecialchars($edit_topic['description']) ?></textarea>
                </div>
                
                <div class="form-group">
                  <label for="image">Image URL</label>
                  <input type="text" id="image" name="image" class="form-control" value="<?= htmlspecialchars($edit_topic['image']) ?>" required>
                  <small>Paste a direct image URL (e.g., from Unsplash)</small>
                </div>
                
                <div class="form-group">
                  <label for="icon">Icon Class</label>
                  <div style="display: flex; align-items: center;">
                    <input type="text" id="icon" name="icon" class="form-control" value="<?= htmlspecialchars($edit_topic['icon']) ?>" required>
                    <span class="icon-preview"><i class="<?= htmlspecialchars($edit_topic['icon']) ?>"></i></span>
                  </div>
                  <small>Use Font Awesome icon classes (e.g., fas fa-pray, fas fa-bible)</small>
                </div>
                
                <div class="form-group">
                  <label for="content">Detailed Content</label>
                  <div class="editor-toolbar">
                    <button type="button" onclick="formatText('bold')"><i class="fas fa-bold"></i></button>
                    <button type="button" onclick="formatText('italic')"><i class="fas fa-italic"></i></button>
                    <button type="button" onclick="formatText('underline')"><i class="fas fa-underline"></i></button>
                    <button type="button" onclick="insertText('<h4>', '</h4>')">H4</button>
                    <button type="button" onclick="insertText('<h5>', '</h5>')">H5</button>
                    <button type="button" onclick="insertText('<ul>\n<li>', '</li>\n</ul>')">List</button>
                    <button type="button" onclick="insertText('<blockquote>', '</blockquote>')">Quote</button>
                  </div>
                  <textarea id="content" name="content" class="form-control editor-textarea" rows="10" required><?= htmlspecialchars($edit_topic['content']) ?></textarea>
                </div>
                
                <div class="form-actions">
                  <button type="button" class="btn btn-secondary" onclick="window.location.href='?'">Cancel</button>
                  <button type="submit" class="btn btn-primary">Update Topic</button>
                </div>
              </form>
            <?php else: ?>
              <div class="admin-message error">Topic not found!</div>
              <a href="?" class="btn btn-primary">Back to Topics</a>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Main Website Content (hidden when admin is logged in) -->
  <?php if (!isset($_SESSION['logged_in'])): ?>
    <!-- Navigation -->
    <nav>
      <div class="nav-container container">
        <a href="index.html" class="logo">
          <i class="fas fa-leaf"></i>Rabbi's Garden
        </a>
        <ul class="nav-links">
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="donations.html">Donations</a></li>
          <li><a href="sermons.html" class="active">Sermons</a></li>
          <li><a href="shop.html">Shop</a></li>
          <li><a href="contacts.html">Contacts</a></li>
        </ul>
        <div class="hamburger">
          <i class="fas fa-bars"></i>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h1>Spiritual Nourishment for Your Soul</h1>
        <p>Discover profound biblical teachings that will transform your walk with God</p>
        <a href="#featured-sermons" class="btn">Watch Sermons</a>
      </div>
    </section>

    <!-- Sermons Section -->
    <section class="sermons" id="featured-sermons">
      <div class="container">
        <div class="section-title">
          <h2>Featured Sermons</h2>
          <p>Explore our collection of inspiring messages that will strengthen your faith and deepen your understanding of God's Word.</p>
        </div>
        
        <div class="sermons-grid">
          <!-- Sermon 1 -->
          <div class="sermon-card">
            <div class="sermon-img">
              <img src="https://images.unsplash.com/photo-1452421822248-d4c2b47f0c81?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Bible Study">
            </div>
            <div class="sermon-content">
              <h3>The Power of Faith</h3>
              <div class="sermon-meta">
                <span><i class="far fa-calendar-alt"></i> June 12, 2023</span>
                <span><i class="fas fa-clock"></i> 45 min</span>
              </div>
              <p>Discover how faith can move mountains and transform your life in ways you never imagined possible.</p>
              <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="watch-btn" target="_blank">
                <i class="fab fa-youtube"></i> Watch Now
              </a>
            </div>
          </div>
          
          <!-- Sermon 2 -->
          <div class="sermon-card">
            <div class="sermon-img">
              <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Prayer Gathering">
            </div>
            <div class="sermon-content">
              <h3>Prayer That Changes Things</h3>
              <div class="sermon-meta">
                <span><i class="far fa-calendar-alt"></i> May 28, 2023</span>
                <span><i class="fas fa-clock"></i> 52 min</span>
              </div>
              <p>Learn the secrets of effective prayer that brings heaven's answers to earth's challenges.</p>
              <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="watch-btn" target="_blank">
                <i class="fab fa-youtube"></i> Watch Now
              </a>
            </div>
          </div>
          
          <!-- Sermon 3 -->
          <div class="sermon-card">
            <div class="sermon-img">
              <img src="https://images.unsplash.com/photo-1532102235608-dc8f0e4f0a2e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Worship Service">
            </div>
            <div class="sermon-content">
              <h3>Living in God's Presence</h3>
              <div class="sermon-meta">
                <span><i class="far fa-calendar-alt"></i> May 15, 2023</span>
                <span><i class="fas fa-clock"></i> 38 min</span>
              </div>
              <p>Experience the joy and peace that comes from dwelling continually in God's presence.</p>
              <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="watch-btn" target="_blank">
                <i class="fab fa-youtube"></i> Watch Now
              </a>
            </div>
          </div>
          
          <!-- Sermon 4 -->
          <div class="sermon-card">
            <div class="sermon-img">
              <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Bible Teaching">
            </div>
            <div class="sermon-content">
              <h3>Overcoming Life's Storms</h3>
              <div class="sermon-meta">
                <span><i class="far fa-calendar-alt"></i> April 30, 2023</span>
                <span><i class="fas fa-clock"></i> 47 min</span>
              </div>
              <p>Biblical principles to help you stand strong when the storms of life come your way.</p>
              <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="watch-btn" target="_blank">
                <i class="fab fa-youtube"></i> Watch Now
              </a>
            </div>
          </div>
          
          <!-- Sermon 5 -->
          <div class="sermon-card">
            <div class="sermon-img">
              <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Church Service">
            </div>
            <div class="sermon-content">
              <h3>The Heart of Worship</h3>
              <div class="sermon-meta">
                <span><i class="far fa-calendar-alt"></i> April 22, 2023</span>
                <span><i class="fas fa-clock"></i> 41 min</span>
              </div>
              <p>Discover what true worship is and how it transforms both the worshipper and the atmosphere.</p>
              <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="watch-btn" target="_blank">
                <i class="fab fa-youtube"></i> Watch Now
              </a>
            </div>
          </div>
          
          <!-- Sermon 6 -->
          <div class="sermon-card">
            <div class="sermon-img">
              <img src="https://images.unsplash.com/photo-1470509037663-253afd7f0f51?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Bible Study Group">
            </div>
            <div class="sermon-content">
              <h3>Walking in Love</h3>
              <div class="sermon-meta">
                <span><i class="far fa-calendar-alt"></i> April 10, 2023</span>
                <span><i class="fas fa-clock"></i> 50 min</span>
              </div>
              <p>Practical teaching on how to walk in God's love toward others in everyday situations.</p>
              <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="watch-btn" target="_blank">
                <i class="fab fa-youtube"></i> Watch Now
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Scripture Panel -->
    <section class="scripture-panel">
      <div class="container">
        <h2>Today's Scripture</h2>
        <div class="scripture-text" id="dailyScripture">
          "Therefore, if anyone is in Christ, the new creation has come: The old has gone, the new is here!"
        </div>
        <div class="scripture-ref" id="scriptureReference">2 Corinthians 5:17 (NIV)</div>
      </div>
    </section>

    <!-- YouTube Channel Section -->
    <section class="youtube-channel">
      <div class="container">
        <div class="section-title">
          <h2>Watch More Teachings</h2>
          <p>Visit our YouTube channel for more inspiring sermons and biblical teachings.</p>
        </div>
        <a href="https://www.youtube.com/channel/YOUR_CHANNEL_ID" class="btn" target="_blank">
          <i class="fab fa-youtube"></i> Visit Our YouTube Channel
        </a>
      </div>
    </section>

    <!-- Topics Section - Updated -->
    <section class="topics">
      <div class="container">
        <div class="section-title">
          <h2>Explore Christian Topics</h2>
          <p>Dive deeper into various aspects of Christian living and biblical teachings.</p>
        </div>
        
        <div class="topics-grid">
          <?= $current_content ?>
        </div>
      </div>
    </section>

    <!-- Topic Modal -->
    <div class="topic-modal" id="topicModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="modalTitle">Topic Title</h3>
          <button class="close-modal" onclick="closeTopicModal()">&times;</button>
        </div>
        <div class="modal-body" id="modalBody">
          <!-- Content will be loaded dynamically -->
        </div>
      </div>
    </div>

    <!-- Footer with Updated Social Links -->
    <footer>
      <div class="container">
        <div class="footer-container">
          <div class="footer-about">
            <div class="footer-logo">
              <i class="fas fa-leaf"></i>Rabbi's Garden
            </div>
            <p>A community-based initiative dedicated to sharing the transformative power of the Bible with the world.</p>
            <p>Join Us in Spreading the Word: Become a Part of Our Bible Community!</p>
          </div>
          
          <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
              <li><a href="index.html">Home</a></li>
              <li><a href="about.html">About Us</a></li>
              <li><a href="donations.html">Donations</a></li>
              <li><a href="sermons.html">Sermons</a></li>
              <li><a href="shop.html">Shop</a></li>
              <li><a href="contacts.html">Contacts</a></li>
            </ul>
          </div>
          
          <div class="footer-social">
            <h3>Connect With Us</h3>
            <div class="social-icons">
              <a href="https://www.instagram.com/yourusername" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
              <a href="https://www.tiktok.com/@yourusername" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
              <a href="https://www.youtube.com/channel/YOUR_CHANNEL_ID" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
              <a href="https://www.facebook.com/yourusername" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            </div>
            <p style="margin-top: 1rem; color: #aaa;">Follow our journey and see the impact of your support.</p>
          </div>
        </div>
        
        <div class="footer-bottom">
          <p>&copy; <span id="current-year"></span> Rabbi's Garden. All rights reserved. | <a href="#" id="privacy-link" style="color: var(--light-green);">Privacy Policy</a></p>
        </div>
      </div>
    </footer>

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" class="privacy-modal">
      <div class="privacy-modal-content">
        <span class="privacy-close">&times;</span>
        <h2>Privacy Policy</h2>
        <p><strong>Last Updated: <span id="policy-date"></span></strong></p>
        
        <h3>1. Information We Collect</h3>
        <p>We may collect personal information such as your name, email address, phone number, and payment details when you make a donation, purchase from our shop, or contact us.</p>
        
        <h3>2. How We Use Your Information</h3>
        <p>We use the information we collect to:</p>
        <ul>
          <li>Process donations and purchases</li>
          <li>Respond to your inquiries</li>
          <li>Send you updates about our ministry (if you opt-in)</li>
          <li>Improve our services</li>
        </ul>
        
        <h3>3. Information Sharing</h3>
        <p>We do not sell or share your personal information with third parties except as necessary to process payments or when required by law.</p>
        
        <h3>4. Data Security</h3>
        <p>We implement appropriate security measures to protect your personal information. However, no internet transmission is 100% secure.</p>
        
        <h3>5. Your Rights</h3>
        <p>You may request access to, correction of, or deletion of your personal information by contacting us.</p>
        
        <h3>6. Changes to This Policy</h3>
        <p>We may update this policy periodically. The updated version will be posted on our website with a new "Last Updated" date.</p>
        
        <h3>7. Contact Us</h3>
        <p>If you have questions about this privacy policy, please contact us through our <a href="contacts.html">Contacts page</a>.</p>
      </div>
    </div>
  <?php endif; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
  <script>
    // Mobile Navigation Toggle
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    if (hamburger && navLinks) {
      hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
      });

      // Close mobile menu when clicking a link
      document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
          navLinks.classList.remove('active');
        });
      });
    }

    // Set current year in footer
    document.getElementById('current-year').textContent = new Date().getFullYear();

    // Scripture rotation
    const scriptures = [
      {
        text: "Trust in the LORD with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.",
        ref: "Proverbs 3:5-6 (NIV)"
      },
      {
        text: "For I know the plans I have for you, declares the LORD, plans to prosper you and not to harm you, plans to give you hope and a future.",
        ref: "Jeremiah 29:11 (NIV)"
      },
      {
        text: "But seek first his kingdom and his righteousness, and all these things will be given to you as well.",
        ref: "Matthew 6:33 (NIV)"
      },
      {
        text: "Therefore, if anyone is in Christ, the new creation has come: The old has gone, the new is here!",
        ref: "2 Corinthians 5:17 (NIV)"
      },
      {
        text: "I can do all this through him who gives me strength.",
        ref: "Philippians 4:13 (NIV)"
      },
      {
        text: "And we know that in all things God works for the good of those who love him, who have been called according to his purpose.",
        ref: "Romans 8:28 (NIV)"
      },
      {
        text: "The LORD is my shepherd, I lack nothing.",
        ref: "Psalm 23:1 (NIV)"
      }
    ];
    
    // Daily Bible Verse (rotates through scriptures array)
    function updateDailyScripture() {
      const today = new Date();
      const dayOfYear = Math.floor((today - new Date(today.getFullYear(), 0, 0)) / (1000 * 60 * 60 * 24));
      const scriptureIndex = dayOfYear % scriptures.length;
      
      document.getElementById('dailyScripture').textContent = `"${scriptures[scriptureIndex].text}"`;
      document.getElementById('scriptureReference').textContent = scriptures[scriptureIndex].ref;
    }
    
    // Initialize daily scripture
    if (document.getElementById('dailyScripture')) {
      updateDailyScripture();
    }
    
    // Topics Data
    const topicsData = <?= json_encode(isset($_SESSION['logged_in']) ? $topics : (file_exists($topics_file) ? loadTopics() : [])) ?>;
    
    // Open topic modal
    function openTopicModal(topicId) {
      const topic = topicsData.find(t => t.id === topicId);
      if (topic) {
        document.getElementById('modalTitle').textContent = topic.title;
        document.getElementById('modalBody').innerHTML = `
          <img src="${topic.image}" alt="${topic.title}">
          ${topic.content}
        `;
        document.getElementById('topicModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
      }
    }

    // Close topic modal
    function closeTopicModal() {
      document.getElementById('topicModal').style.display = 'none';
      document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    if (document.getElementById('topicModal')) {
      document.getElementById('topicModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('topicModal')) {
          closeTopicModal();
        }
      });
    }

    // Set active navigation link
    document.addEventListener('DOMContentLoaded', function() {
      const currentPage = window.location.pathname.split('/').pop() || 'sermons.html';
      const navLinks = document.querySelectorAll('.nav-links a');
      
      if (navLinks.length > 0) {
        navLinks.forEach(link => {
          const linkPage = link.getAttribute('href');
          if (currentPage === linkPage) {
            link.classList.add('active');
          } else {
            link.classList.remove('active');
          }
        });
      }
    });

    // Set privacy policy date
    if (document.getElementById('policy-date')) {
      document.getElementById('policy-date').textContent = new Date().toLocaleDateString('en-US', {
        year: 'numeric', 
        month: 'long', 
        day: 'numeric'
      });
    }

    // Privacy Policy Modal
    const modal = document.getElementById('privacyModal');
    const privacyLink = document.getElementById('privacy-link');
    const closeBtn = document.querySelector('.privacy-close');

    if (modal && privacyLink && closeBtn) {
      privacyLink.addEventListener('click', function(e) {
        e.preventDefault();
        modal.style.display = 'block';
      });

      closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
      });

      window.addEventListener('click', function(e) {
        if (e.target === modal) {
          modal.style.display = 'none';
        }
      });
    }
    
    <?php if (isset($_SESSION['logged_in'])): ?>
      // Initialize sortable list
      if (document.getElementById('sortable')) {
        new Sortable(document.getElementById('sortable'), {
          animation: 150,
          ghostClass: 'sortable-ghost',
          handle: '.drag-handle',
          onEnd: function() {
            const items = document.querySelectorAll('#sortable li');
            const order = Array.from(items).map(item => item.getAttribute('data-id'));
            document.getElementById('topicOrder').value = JSON.stringify(order);
            document.getElementById('saveOrderBtn').style.display = 'inline-block';
          }
        });
      }
      
      // Icon preview update
      if (document.getElementById('icon')) {
        document.getElementById('icon').addEventListener('input', function() {
          const preview = this.nextElementSibling;
          preview.innerHTML = `<i class="${this.value}"></i>`;
        });
      }
      
      // Text editor functions
      function formatText(format) {
        const textarea = document.getElementById('content');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);
        let wrapStart = '', wrapEnd = '';
        
        switch(format) {
          case 'bold': 
            wrapStart = '<strong>'; 
            wrapEnd = '</strong>'; 
            break;
          case 'italic': 
            wrapStart = '<em>'; 
            wrapEnd = '</em>'; 
            break;
          case 'underline': 
            wrapStart = '<u>'; 
            wrapEnd = '</u>'; 
            break;
        }
        
        textarea.value = textarea.value.substring(0, start) + wrapStart + selectedText + wrapEnd + textarea.value.substring(end);
        textarea.focus();
        textarea.selectionStart = start + wrapStart.length;
        textarea.selectionEnd = end + wrapStart.length;
      }
      
      function insertText(prefix, suffix) {
        const textarea = document.getElementById('content');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);
        
        textarea.value = textarea.value.substring(0, start) + prefix + selectedText + suffix + textarea.value.substring(end);
        textarea.focus();
        
        if (selectedText) {
          textarea.selectionStart = start + prefix.length;
          textarea.selectionEnd = end + prefix.length;
        } else {
          textarea.selectionStart = textarea.selectionEnd = start + prefix.length;
        }
      }
    <?php endif; ?>
  </script>
</body>
</html>