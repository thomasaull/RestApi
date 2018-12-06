<?php namespace ProcessWire;

class Blog { 

  
  public static function getPosts() {
      
    $posts = wire('pages')->get(1)->children;
    
    $response = new \StdClass();
    $response->posts = [];
        
    foreach($posts as $post) {
      array_push($response->posts, [
        "id" => $post->id,
        "title" => $post->title
      ]);
    }

    return $response;
  }

  public static function getPost($data) {
    $data = RestApiHelper::checkAndSanitizeRequiredParameters($data, ['id|int']);
   
    $response = new \StdClass();
    
    $post = wire('pages')->get($data->id);
    
    if(!$post->id) throw new \Exception('Post not found');
    
    $response->id = $post->id;
    foreach($post->template->fields as $field) {
      $response->{$field->name} = $post->{$field->name}; 
    }
      
    return $response;
  
  }

}