@extends('layouts.app')
@section('title', $data->slug)


@section('css')
<style>
    /* Breadcrumb Section */
    .breadcrumb-section {
        background-color: white;
        padding: 15px 0;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 30px;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: 14px;
    }

    .breadcrumb-item a {
        color: #2d5f4f;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: #16a34a;
    }

    .breadcrumb-item.active {
        color: #6b7280;
    }

    /* Main Blog Section */
    .blog-detail-section {
        padding: 40px 0;
    }

    /* Featured Image */
    .featured-image {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    /* Blog Content Card */
    .blog-content-card {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    /* Blog Title */
    .blog-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        line-height: 1.4;
    }

    /* Meta Info */
    .blog-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #6b7280;
        font-size: 14px;
    }

    .meta-item i {
        color: #2d5f4f;
    }

    /* Blog Content */
    .blog-content {
        color: #374151;
        font-size: 1.05rem;
        line-height: 1.9;
    }

    .blog-content h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-top: 30px;
        margin-bottom: 15px;
    }

    .blog-content p {
        margin-bottom: 20px;
        text-align: justify;
    }

    /* Sidebar Styles */
    .sidebar_new {
        position: sticky;
        top: 20px;
    }

    .sidebar-widget {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .widget-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 3px solid #2d5f4f;
    }

    /* Categories Widget */
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-item {
        padding: 10px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .category-item:last-child {
        border-bottom: none;
    }

    .category-item a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #4b5563;
        text-decoration: none;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .category-item a:hover {
        color: #2d5f4f;
        padding-left: 8px;
    }

    .category-count {
        background-color: #f3f4f6;
        color: #6b7280;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 13px;
    }

    /* Related Products Widget */
    .product-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-thumb {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .product-info h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
        line-height: 1.4;
    }

    .product-info h5 a {
        color: #1f2937;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .product-info h5 a:hover {
        color: #2d5f4f;
    }

    .product-price {
        color: #16a34a;
        font-weight: 700;
        font-size: 14px;
    }

    /* Recent Comments Widget */
    .comment-item {
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .comment-item:last-child {
        border-bottom: none;
    }

    .comment-author {
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .comment-text {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.5;
    }

    .comment-link {
        color: #2d5f4f;
        text-decoration: none;
        font-size: 13px;
        transition: color 0.3s ease;
    }

    .comment-link:hover {
        color: #16a34a;
    }

    /* Tag Cloud Widget */
    .tag-cloud {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .tag-item {
        display: inline-block;
        background-color: #f3f4f6;
        color: #4b5563;
        padding: 8px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .tag-item:hover {
        background-color: #2d5f4f;
        color: white;
        border-color: #2d5f4f;
    }

    /* Social Share & Navigation Section */
    .post-footer-section {
        background: white;
        border-radius: 12px;
        padding: 40px 0px;
        margin-bottom: 30px;
        /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); */
    }

    .social-share-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        font-family: "SolaimanLipi", "Noto Sans Bengali", sans-serif;
    }

    /* Post Navigation */
    .post-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 25px;
        border-top: 2px solid #e5e7eb;
        gap: 20px;
    }

    .nav-post {
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: #4b5563;
        transition: all 0.3s ease;
        max-width: 45%;
    }

    .nav-post:hover {
        color: #2d5f4f;
    }

    .nav-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        color: #9ca3af;
    }

    .nav-title {
        font-size: 0.95rem;
        font-weight: 600;
        line-height: 1.4;
    }

    .nav-post.previous {
        align-items: flex-start;
    }

    .nav-post.next {
        align-items: flex-end;
        text-align: right;
    }

    /* Comment Section */
    .comment-section {
        background: white;
        border-radius: 12px;
        /* padding: 40px; */
        /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); */
        margin-bottom: 30px;
    }

    .comment-count {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 30px;
    }

    /* Existing Comment Item */
    .comment-item-box {
        display: flex;
        gap: 15px;
        padding: 25px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .comment-item-box:last-child {
        border-bottom: none;
    }

    .comment-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .comment-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .comment-avatar i {
        font-size: 24px;
        color: #9ca3af;
    }

    .comment-content {
        flex: 1;
    }

    .comment-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }

    .comment-author-name {
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
    }

    .comment-date {
        font-size: 0.875rem;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .comment-date i {
        font-size: 0.75rem;
    }

    .comment-reply-btn {
        background: none;
        border: none;
        color: #2d5f4f;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: color 0.3s ease;
    }

    .comment-reply-btn:hover {
        color: #16a34a;
    }

    .comment-text {
        color: #4b5563;
        font-size: 0.95rem;
        line-height: 1.7;
        margin: 0;
    }

    /* Leave Comment Form */
    .leave-comment-section {
        margin-top: 40px;
        padding-top: 40px;
        border-top: 2px solid #e5e7eb;
    }

    .leave-comment-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .email-privacy-note {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 25px;
    }

    .comment-form .form-control {
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .comment-form .form-control:focus {
        border-color: #2d5f4f;
        box-shadow: 0 0 0 0.2rem rgba(45, 95, 79, 0.15);
    }

    .comment-form textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .form-check-input:checked {
        background-color: #2d5f4f;
        border-color: #2d5f4f;
    }

    .form-check-input:focus {
        border-color: #2d5f4f;
        box-shadow: 0 0 0 0.2rem rgba(45, 95, 79, 0.15);
    }

    .form-check-label {
        font-size: 0.9rem;
        color: #4b5563;
    }

    .submit-comment-btn {
        background-color: #2d5f4f;
        color: white;
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .submit-comment-btn:hover {
        background-color: #1f4436;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 95, 79, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 767px) {

        .post-footer-section,
        .comment-section {
            padding: 25px 20px;
        }

        .social-share-title,
        .comment-count,
        .leave-comment-title {
            font-size: 1.25rem;
        }

        .post-navigation {
            flex-direction: column;
            gap: 15px;
            align-items: start;
        }

        .nav-post {
            max-width: 100%;
        }

        .nav-post.next {
            align-items: flex-start;
            text-align: left;
        }

        .comment-item-box {
            gap: 12px;
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
        }

        .comment-avatar i {
            font-size: 20px;
        }

        .leave-comment-section {
            padding-top: 30px;
            margin-top: 30px;
        }
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .blog-content-card {
            padding: 30px 20px;
        }

        .blog-title {
            font-size: 1.6rem;
        }

        .sidebar_new {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 767px) {
        .blog-content-card {
            padding: 25px 15px;
        }

        .blog-title {
            font-size: 1.4rem;
        }

        .blog-meta {
            gap: 15px;
        }

        .blog-content {
            font-size: 1rem;
        }

        .sidebar-widget {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb Section -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{$data->title}}
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Blog Detail Section -->
<section class="blog-detail-section">
    <div class="container">
        <div class="row">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <!-- Featured Image -->
                <img
                    src="{{Storage::url($data->image)}}"
                    alt="{{$data->title}}"
                    class="featured-image" />

                <!-- Blog Content Card -->
                <div class="blog-content-card text-left">
                    <!-- Blog Title -->
                    <h1 class="blog-title">
                        {{$data->title}}
                    </h1>

                    <!-- Meta Information -->
                    <div class="blog-meta">
                        <div class="meta-item">
                            <i class="far fa-user"></i>
                            <span>{{$data->auth_title}}</span>
                        </div>
                        <div class="meta-item">
                            <i class="far fa-calendar"></i>
                            <span>{{$data->post_date}}</span>
                        </div>
                    </div>

                    <!-- Blog Content -->
                    <div class="blog-content">
                        {!! $data->description !!}
                    </div>
                   
                   
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar_new">
                    <!-- Categories Widget -->
                    <div class="sidebar-widget text-left">
                        <h3 class="widget-title">Categories</h3>
                        <ul class="category-list">
                            <li class="category-item">
                                <a href="#">
                                    <span>Blogs</span>
                                    <span class="category-count">{{$data->count() }}</span>
                                </a>
                            </li>
                            
                        </ul>
                    </div>

                    <!-- Related Products Widget -->
                    <div class="sidebar-widget text-left">
                        <h3 class="widget-title">Products</h3>
                        @foreach($products as $item)
                        <div class="product-item">
                            <img
                                src="{{Storage::url($item->featured_image_1)}}"
                                alt="{{$item->name}}"
                                class="product-thumb" />
                            <div class="product-info">
                                <h5>
                                    <a href="{{route('product.single',$item->slug)}}">{{$item->name}}</a>
                                </h5>
                                <div class="product-price">{{currency()}}{{$item->sale_price}}</div>
                            </div>
                        </div>
                        @endforeach

                      
                    </div>

                   

                 
                </div>
            </div>
        </div>
    </div>
</section>
@endsection