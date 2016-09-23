@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <section class="row new-post">

        @include('includes.message-block')

        <div class="col-md-6 col-md-offset-3">
            <header>
                <h3>What do you have to say?</h3>
            </header>
            <form action="{{ route('post.create') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea class="form-control" name="body" id="body" cols="30" rows="10" placeholder="Your Post"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </div>
    </section>
    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What other people say ...</h3></header>
            @foreach($posts as $post)
              <!--using html5 dataset feature to attach the post id-->
                <article class="post" data-postid="{{ $post->id}}">
                    <p>{{ $post->body }}</p>
                    <div class="info">
                         Posted by {{ $post->user->first_name }} on {{ $post->created_at->format('m/d/Y h:i:s a') }}
                    </div>
                    <div class="interaction">
                         <a href="#" class="like">Like</a> |
                         <a href="#" class="like">Dislike</a>
                         @if(Auth::user() == $post->user)
                            |
                            <a href="#" class="edit">Edit</a> |
                            <a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
                         @endif
                    </div>
                </article>
             @endforeach
        </div>

    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Edit Post</h4>
          </div>
          <div class="modal-body">
              <form>
                  <div class="form-group">
                      <textarea class="form-control" name="modal-text" id="modal-text" rows="5"></textarea>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>
       //we'll need these to make the jquery ajax calls
       var token = "{{ Session::token() }}";
       var urlEdit = "{{ route('post.edit') }}";
       var urlLike = "{{ route('post.like') }}"; //one route for like and dislkie
    </script>
@endsection
