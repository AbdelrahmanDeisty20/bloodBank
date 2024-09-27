@extends('front.master')
@section('content')
    <!--inside-article-->
    <div class="inside-article">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="#">المقالات</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الوقاية من الأمراض</li>
                    </ol>
                </nav>
            </div>
            <div class="article-image">
                <img src="{{ asset($post->image) }}">
            </div>
            <div class="article-title col-12">
                <div class="h-text col-6">
                    <h4>{{ $post->title }}</h4>
                </div>
                <div class="icon col-6">
                    <a href="#" class="favourite {{ $post->is_favourite ? 'second-heart' : 'first-heart' }}"
                        onclick="toggleFavourite(this, event)" id="{{ $post->id }}">
                        <i class="far fa-heart"></i>
                    </a>
                </div>
            </div>

            <!--text-->
            <div class="text">
                <p>{{ $post->content }}</p>
            </div>

            <!--articles-->
            <div class="articles">
                <div class="title">
                    <div class="head-text">
                        <h2>مقالات ذات صلة</h2>
                    </div>
                </div>
                <div class="view">
                    <div class="row">
                        <!-- Set up your HTML -->

                        <div class="owl-carousel articles-carousel">
                            @foreach ($posts as $po)
                                <div class="card">
                                    <div class="photo">
                                        <img src="{{ asset($po->image) }}" class="card-img-top" alt="...">
                                        <a href="article-details.html" class="click">المزيد</a>
                                    </div>
                                    <a href="#"
                                        class="favourite {{ $post->is_favourite ? 'second-heart' : 'first-heart' }}"
                                        onclick="toggleFavourite(this, event)" id="{{ $post->id }}">
                                        <i class="far fa-heart"></i>
                                    </a>

                                    <div class="card-body">
                                        <h5 class="card-title">{{ $po->title }}</h5>
                                        <p class="card-text">
                                            {{ $po->content }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

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
