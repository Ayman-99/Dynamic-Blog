<?php

class Post {

    private $post;
    private $conn;

    public function __construct($con, $post_id) {
        $this->conn = $con;
        $post_query = mysqli_query($con, "SELECT * FROM posts inner join categories on posts.post_category=categories.category_name where post_id='$post_id'");
        $this->post = mysqli_fetch_array($post_query);
    }

    public function getPostId() {
        return $this->post['post_id'];
    }

    public function getPostAuthor() {
        return $this->post['post_author'];
    }

    public function getPostTitle() {
        return $this->post['post_title'];
    }

    public function getPostContent() {
        return $this->post['post_content'];
    }

    public function getPostDate() {
        return $this->post['post_date'];
    }

    public function getPostViews() {
        return $this->post['post_views'];
    }

    public function increasePostViews() {
        mysqli_query($this->conn, "update posts set post_views = post_views + 1 where post_id='{$this->post['post_id']}'");
    }

    public function getPostImages() {
        return $this->post['post_image'];
    }

    public function getPostTags() {
        $tags = $this->post['post_tags'];
        $user_to_check_array_explode = explode(",", $tags);
        $dummy = "";
        for ($i = 0; $i < count($user_to_check_array_explode); $i++) {
            $dummy .= "<small><a>" . ucwords($user_to_check_array_explode[$i]) . "</a></small>";
        }
        return $dummy;
    }

    public function getRawPostTags() {
        return $this->post['post_tags'];
    }

    public function getPostCategory() {
        return $this->post['post_category'];
    }

    public function getPostCategoryStatus() {
        return $this->post['category_status'];
    }

    public function getPostAddedBy() {
        return $this->post['post_added_by'];
    }
    
    public function getCommentsCount(){
        $result = mysqli_query($this->conn, "select count(comment_id) as count from comments where comment_post={$this->getPostId()}");
        $row = mysqli_fetch_array($result);
        return $row['count'];
    }
   
}
