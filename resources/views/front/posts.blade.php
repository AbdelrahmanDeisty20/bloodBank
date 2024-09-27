@extends('front.master')
@section('content')

    <!--articles-->
    <div class="articles">
        <div class="container title">
            <div class="head-text">
                <h2>المقالات</h2>
            </div>
        </div>
        <div class="view">
            <div class="container">
                <div class="row">
                    <!-- Set up your HTML -->
                    <div class="owl-carousel articles-carousel">
                        @foreach ($posts as $post)
                            <div class="card">
                                <div class="photo">
                                    <img src="{{ asset($post->image) }}" class="card-img-top" alt="...">
                                    <a href="{{ route('postst.postMore', $post->id) }}" class="click">المزيد</a>
                                </div>
                                <a href="#" class="favourite {{ $post->is_favourite ? 'second-heart' : 'first-heart' }}" onclick="toggleFavourite(this, event)"
                                    id="{{ $post->id }}" >
                                    <i class="far fa-heart"></i>
                                </a>

                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">
                                        {{ $post->content }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            // $('.search-btn').click(function(event){
            //     event.preventDefault();
            // })

            function toggleFavourite(heart, event) {
                console.log('Toggle favourite called!');
                var post_id = heart.id;
                console.log(post_id);
                $.ajax({
                    url: '{{ url('toggle-favourite') }}',
                    type: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        post_id: post_id
                    },
                    success: function(data) {
                        console.log(data);
                        var currentClass = $(heart).attr('class');
                        if (currentClass.includes('first')) {
                            $(heart).removeClass('first-heart').addClass('second-heart');
                            $(heart).find('i').css('color', 'red'); // add this line
                        } else {
                            $(heart).removeClass('second-heart').addClass('first-heart');
                            $(heart).find('i').css('color', ''); // reset the color
                        }
                    }
                });
                event.preventDefault();
            }
        </script>
    @endpush
@stop
