<?php
// Update the details below with your MySQL details
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'chat';
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} catch (PDOException $exception) {
    // If there is an error with the connection, stop the script and display the error
    exit('Failed to connect to database!');
}
// Below function will convert datetime to time elapsed string
function getCurrentDateTime(){
    date_default_timezone_set("Asia/Calcutta");
    return date("Y-m-d H:i:s");
}
function getDateString($date){
    $dateArray = date_parse_from_format('Y/m/d', $date);
    $monthName = DateTime::createFromFormat('!m', $dateArray['month'])->format('F');
    return $dateArray['day'] . " " . $monthName  . " " . $dateArray['year'];
}

function getDateTimeDifferenceString($datetime){
    $currentDateTime = new DateTime(getCurrentDateTime());
    $passedDateTime = new DateTime($datetime);
    $interval = $currentDateTime->diff($passedDateTime);
    //$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
    $day = $interval->format('%a');
    $hour = $interval->format('%h');
    $min = $interval->format('%i');
    $seconds = $interval->format('%s');

    if($day > 7)
        return getDateString($datetime);
    else if($day >= 1 && $day <= 7 ){
        if($day == 1) return $day . " day ago";
        return $day . " days ago";
    }else if($hour >= 1 && $hour <= 24){
        if($hour == 1) return $hour . " hour ago";
        return $hour . " hours ago";
    }else if($min >= 1 && $min <= 60){
        if($min == 1) return $min . " minute ago";
        return $min . " minutes ago";
    }else if($seconds >= 1 && $seconds <= 60){
        if($seconds == 1) return $seconds . " second ago";
        return $seconds . " seconds ago";
    }
}
// This function will populate the comments and comments replies using a loop
function show_comments($comments, $parent_id = -1) {
    $html = '';
    if ($parent_id != -1) {
        // If the comments are replies sort them by the "submit_date" column
        array_multisort(array_column($comments, 'submit_date'), SORT_ASC, $comments);
    }
    // Iterate the comments using the foreach loop
    foreach ($comments as $comment) {
        if ($comment['parent_id'] == $parent_id) {
            // Add the comment to the $html variable
            $html .= '
            <div class="comment">
            <div style="font-family:Quicksand;border-color:transparent; background-color:rgba(56, 196, 246,0.2);padding-left:1cm;padding-top:10px;padding-bottom:10px;padding-left:1cm;border-radius:1cm;color:rgba(0,0,0,0.6);">    
            <div style="padding-right:1cm;">
                    <div class="name" style="font-size:0.5cm;font-weight:bold;padding-right:0.5cm;color:rgba(0,0,0,0.6);">' .$_GET['uname']. '</div>
                    <span class="date" style="float :right;font-size:0.4cm; color:rgba(0,0,0,0.6);weight:bolder;">' . getDateTimeDifferenceString($comment['submit_date']) . '</span>
                </div>
                <p class="content" style="font-size:0.5cm;padding-right:1cm;padding-left:0cm;word-wrap:break-word; color:">' . nl2br(htmlspecialchars($comment['content'], ENT_QUOTES)) . '</p>
                <a class="reply_comment_btn" href="#" id="reply1" data-comment-id="' . $comment['id'] . '" style="color:white; text-decoration:none; font-size:17px;">Reply</a>&nbsp&nbsp&nbsp<button id="like" onclick="countl('.$comment['id'].');" style="border:none; background-color:transparent; border-radius: 5px; color: white;height:1cm;padding-bottom:0.3cm;"><img src="./images/heart.png" style="height:1cm;width:1cm;"></button><button style="border:transparent;background-color:rgba(255,255,255,0.6); border-radius: 50px;padding-right:10px;padding-left:10px;padding-top:2px;padding-bottom:2px; color:black;">'.$comment['likes'].'</button><br>
                ' . show_write_comment_form($comment['id']) . '
                <div class="replies">
                ' . show_comments($comments, $comment['id']) . '
                </div>
            </div>
                </div>
                </div><br>
            ';
        }
    }
    return $html;
}
// This function is the template for the write comment form
function show_write_comment_form($parent_id = -1) {
    $html = '
    <div class="write_comment" data-comment-id="' . $parent_id . '" style="padding:1cm;">
        <form>
            <input name="parent_id" type="hidden" value="' . $parent_id . '">
            <textarea name="content" placeholder="Write your comment here..." style="padding:0.5cm;border-radius:20px;background-color:rgba(87, 215, 247,0.55);border-color:#1aace188; outline:none;color:white;border-color:white;box-shadow:0 0 10px white;font-size:0.5cm;font-family:Quicksand;"required></textarea>
            <center><button id="reply" type="submit" style="font-family:Quicksand;font-size:0.5m;background-color:rgb(20, 143, 181);font-weight: lighter; padding:12px;border-radius: 20px;width:10%;">Post</button><center>
        </form>
    </div>
    ';
    return $html;
}
// Page ID needs to exist, this is used to determine which comments are for which page
if (isset($_GET['page_id'])) {
    // Check if the submitted form variables exist
    if (isset($_POST['content'])) {
        // POST variables exist, insert a new comment into the MySQL comments table (user submitted form)
        $stmt = $pdo->prepare('INSERT INTO comments (page_id, parent_id, name, content, submit_date) VALUES (?,?,?,?,NOW())');
        $stmt->execute([ $_GET['page_id'], $_POST['parent_id'], $_GET['uname'], $_POST['content'] ]);
        exit('Your comment has been submitted!');
    }
    // Get all comments by the Page ID ordered by the submit date
    $stmt = $pdo->prepare('SELECT * FROM comments WHERE page_id = ? ORDER BY submit_date DESC');
    $stmt->execute([ $_GET['page_id'] ]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Get the total number of comments
    $stmt = $pdo->prepare('SELECT COUNT(*) AS total_comments FROM comments WHERE page_id = ?');
    $stmt->execute([ $_GET['page_id'] ]);
    $comments_info = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    exit('No page ID specified!');
}
?>

<div class="comment_header" style="font-family:Quicksand;height:1.5cm; border-bottom-color: transparent;">
    <span class="total" style="font-size:0.55cm;padding-left:0.5cm;"><?=$comments_info['total_comments']?> Comments</span>
    <a href="#" class="write_comment_btn" data-comment-id="-1" style="font-family:Quicksand;font-size:0.5m;background-color:rgb(20, 143, 181);font-weight: lighter; padding:12px;border-radius: 20px;">Comment</a>
</div>

<?=show_write_comment_form()?>

<?=show_comments($comments)?>
