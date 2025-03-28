@extends('layouts.app')

@section('script')
    <script>
        $('#sendComment').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
        })

        // document.querySelector('#sendCommentForm').addEventListener('submit' , function(event) {
        //     event.preventDefault();
        //     let target = event.target;
        
        //     let data = {
        //         commentable_id : target.querySelector('input[name="commentable_id"]').value,
        //         commentable_type: target.querySelector('input[name="commentable_type"]').value,
        //         parent_id: target.querySelector('input[name="parent_id"]').value,
        //         comment: target.querySelector('textarea[name="comment"]').value
        //     }
        
        //     // if(data.comment.length < 2) {
        //     //     console.error('pls enter comment more than 2 char');
        //     //     return;
        //     // }
        
        
        //     $.ajaxSetup({
        //         headers : {
        //             'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
        //             'Content-Type' : 'application/json'
        //         }
        //     })
        
        
        //     $.ajax({
        //         type : 'POST',
        //         url : '/comments',
        //         data : JSON.stringify(data),
        //         success : function(data) {
        //             console.log(data);
        //         }
        //     })
        // })
    </script>
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ $product->title }}
                    </div>

                    <div class="card-body">
                        {{ $product->description }}
                    </div>
                </div>
                @auth
    <form action="{{ route('send.comment') }}" method="post" id="sendCommentForm">
                        @csrf
                        <div class="modal-body">
                                <input type="hidden" name="commentable_id" value="{{ $product->id }}" >
                                <input type="hidden" name="commentable_type" value="{{ get_class($product) }}">
                                <input type="hidden" name="parent_id" value="0">

                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">پیام دیدگاه:</label>
                                    <textarea name="comment" class="form-control" id="message-text"></textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                            <button type="submit" class="btn btn-primary">ارسال نظر</button>
                        </div>
                    </form>
    @endauth
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mt-4">بخش نظرات</h4>
                </div>
                @guest
                    <div class="alert alert-warning">برای ثبت نظر لطفا وارد سایت شوید.</div>
                @endguest

                @foreach($product->comments()->where('approved' , 1)->where('parent_id' , 0)->get() as $comment )
                    <div class="card {{ ! $loop->first ? 'mt-3' : '' }}">
                        <div class="card-header d-flex justify-content-between">
                            <div class="commenter">
                                <span>{{ $comment->user->name }}</span>
                                <span class="text-muted">{{ jdate($comment->created_at)->ago()}}
                                <!-- ->format('%A, %d %B %y') -->
                                 </span>
                            </div>
                            @auth
                                <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="{{ $comment->id }}">پاسخ به نظر</span>
                            @endauth
                        </div>

                        <div class="card-body">
                            {{ $comment->comment }}

                            @foreach($comment->child as $childComment)
                                <div class="card mt-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="commenter">
                                            <span>{{ $childComment->user->name }}</span>
                                            <span class="text-muted">- دو دقیقه قبل</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        {{ $childComment->comment }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
