<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Post;
use App\User;
use App\Role;
use App\Country;
use App\Photos;
use App\Video;
use App\Tag;
use App\Address;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/post/{id}/{name}', function($id, $name){
   return ("id: ".$id ." name: " .$name);
});

Route::get('admin/posts/example/', array('as'=>'admin.post', function(){

$url = route('admin.post');

return "this url is " .$url;

}));
// Route::get('/posts/{id}/{name}', 'PostController@show_post');

Route::get('insert', function(){
  DB::insert('insert into posts(title, content) values(?,?)',['Laravel APP', 'the content of laravel mvc']);
});
Route::get('read', function(){
  $result = DB::select('select * from posts');
// foreach ($result as $key) {
//  return $key->content;
// }
return $result;
});

Route::get('update/{title}', function($title){
  $updated=DB::update('update posts set title=? where content=?',[$title, "the content of laravel mvc"]);
  return $updated;
});
Route::get('delete', function(){
  $deleted = DB::delete('delete from posts where id=?',[3]);
  return $deleted;
});

//////////////
//ELOQUENT ORM
//////////////

//retrieve
Route::get('find', function(){
return Post::all()->get();

});
Route::get('findid/{id}', function($id){
  $posts= Post::find($id);
  return $posts;
});
Route::get('findwhere', function(){
  $posts= Post::where('created_at',null)->orderBy('id', 'asc')->get();
  return $posts;
});
Route::get('findorfail/{id}', function($id){
  $posts= Post::findOrFail($id);
  return $posts;
});
// basic insert
Route::get('basicinsert/{title}', function($title){
  $post = new Post;
  $post->title=$title;
  $post->content="Inserted with basic insert of Eloquet";
  $post->save();
});
//basic update
Route::get('basicinsert2/{id}/{title}', function($id,$title){
  $post = Post::find($id);
  $post->title=$title;
  $post->content="Inserted with basic insert of Eloquet";
  $post->save();
});
//create
Route::get('create', function(){
  $post=  Post::create(['user_id'=>'1','title'=>'Post Insert with Eloquent', 'content'=>'Post content and title inserted with Eloquent']);
  return $post;//need to configure Mass Assignment: go to Posts model and see $fillabl.
});
//update
Route::get('updatewitheloquent', function(){
$post=  Post::where('id',1)->update(['title'=>'Updated title with Elo', 'content'=>'Updated content with Eloquent']);
return $post;
});

//delete
Route::get('delete', function(){
   Post::find(4)->delete();
});

Route::get('destroy', function(){
  Post::destroy([2,4]);
});
//soft delete
Route::get('softdelete', function(){
  Post::find(6)->delete();// SoftDeletes model is used in Post model. ()softDeletes is needed in sql table
});
//read soft SoftDeletes
Route::get('readsoftdel', function(){
return  Post::withTrashed()->find(1);
});
Route::get('onlytrashed', function(){
return  Post::onlyTrashed()->find(1);
});
//restoring softDeletes
Route::get('restore', function(){
  Post::onlyTrashed()->restore();
});
//deleting permanently
Route::get('forcedelete', function(){
  Post::onlyTrashed()->find(6)->forceDelete();
});
//////////////
//ELOQUENT One to One relationship
//////////////
Route::get('user/{id}/post', function($id){
  return User::find($id)->post;//look to post function in User model: hasOne()
});

Route::get('postuser/{id}', function($id){
  return Post::find($id)->user; //look to user function in Post mode: belongsTo()
});

//////////////
//ELOQUENT One to Many relationship
//////////////

Route::get('users/{id}/posts', function($id){
  return User::find($id)->posts;//look to post function in User model: hasMany()
});
//////////////
//ELOQUENT Many to Many relationship
//////////////

Route::get('user/{id}/roles', function($id){
  return User::find($id)->roles;//look to User model: belongsToMany(). Created Role model, roles tables, role_user table
});
Route::get('role/{id}/users', function($id){
  return Role::find($id)->users;//look to Role model: belongsToMany(). Created Role model, roles tables, role_user table
});

Route::get('user/{id}/assign_role/{role}', function($id, $role){
$user=  User::find($id);
$getrole=Role::where('name','=',$role)->get();
if(count($getrole)!=0){
  $userrole=  $user->roles()->where('name','=',$role)->get();
  if(count($userrole)!=0){
    return $user->roles;
  }
  $id= $getrole[0]->id;
  $user->roles()->attach($id);//attaching role to user
}else{
  $user->roles()->save(new Role(['name'=>$role]));//adding new role
}

return $user->roles;
});

Route::get('user/{id}/roles/detach/{role}', function($id, $role){
  $user=  User::find($id);
  $getrole=Role::where('name','=',$role)->get();
  if(count($getrole)!=0){
    $userrole=  $user->roles()->where('name','=',$role)->get();
    if(count($userrole)>0){
      $id= $getrole[0]->id;
      $user->roles()->detach($id);//detaching the roles from the user
    }else{
      return "The user does not has this role";
    }
  }else{
    return "No such user role";
  }
  return $user->roles;
});

Route::get('user/{id}/sync/roles', function($id){
  User::find($id)->roles()->sync([1,2]);//syncing roles, deletes all roles of the user, and then adds roles inside the array
  return User::find($id)->roles;
});
//////////////
//ELOQUENT Has Many Through
//////////////

Route::get('country/{id}/post', function($id){
  return Country::find($id)->posts;  //look to Country model: hasManyThrough()
});

//////////////
//ELOQUENT Polymorphism -> One to Many
//////////////
Route::get('user/{id}/insert/photo/{name}', function($id,$name){
  User::find($id)->photos()->create(['path'=>$name.'.jpg']);//insert
  return User::find($id)->photos;
});

Route::get('user/{id}/photos', function($id){
  return User::find($id)->photos;//look to User moder: morphMany(); and Photos model:morphTo imageable()
});
Route::get('postphotos/{id}/photos', function($id){
  return Post::find($id)->photos;
});
Route::get('photos/{id}/type', function($id){
  return Photos::find($id)->imageable;
});
Route::get('photos/delete', function(){
  Photos::where('path', '=', "")->delete();//deleting
  return Photos::all();
});

Route::get('photos/update', function(){
$photo=  Photos::where('path', '=', 'just photo.jpg')->first();
  $photo->path='justphoto.jpg';
  $photo->save();
  return $photo;
});


//////////////
//ELOQUENT Polymorphism -> Many to Many
//////////////
Route::get('create/tags', function(){
  $post=Post::create(['title'=>'PHP', 'content'=>'Laravel, php, javascript attached']);
  $tag=Tag::create(['name'=>'php-attach']);
  $video = Video::create(['name'=>'learn_php_attach.mov']);
  $post->tags()->attach($tag);
  $video->tags()->attach($tag);
  return Tag::where('name','=','php')->first()->pivot;
});

Route::get('posttags/{id}', function($id){
  return Post::find($id)->tags;
});
Route::get('videotags/{id}', function($id){
  return Video::find($id)->tags;
});
Route::get('tags/{id}/posts', function($id){
  $tag = Tag::find($id);
    return Tag::find($id)->posts;
});
Route::get('tags/{id}/videos', function($id){
  $tag = Tag::find($id);
    return Tag::find($id)->videos;
});
//////////////
//ELOQUENT  One to One
//////////////

//insert
Route::get('user/{id}/address/{address}', function($id, $address){
  $newaddress= new Address(['name'=>$address]);
  User::find($id)->address()->save($newaddress);
});

//update
Route::get('user/{id}/update/address/{name}', function($id, $name){
  $address = Address::whereUserId($id)->first();
  $address->name = $name;
  $address->save();
  return User::find($id)->address;
});

//////////////
//CRUD Application
//////////////
Route::resource('/posts', 'PostController');
