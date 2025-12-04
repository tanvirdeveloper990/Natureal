@extends('layouts.app')

@section('title', 'About')
@section('css')
<style>
    .hero {
        padding: 80px 0;
        background: linear-gradient(135deg, rgba(43, 140, 255, 0.10), rgba(43, 140, 255, 0.02));
    }

    .brand-logo {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        background: var(--primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 22px;
    }

    .card-ghost {
        background: rgba(255, 255, 255, 0.9);
        border: 0;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(20, 30, 60, 0.08);
    }

    .stat {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary);
    }

    .timeline {
        position: relative;
        padding-left: 30px
    }

    .timeline:before {
        content: '';
        position: absolute;
        left: 12px;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(#e6f0ff, #ffffff);
        border-radius: 4px
    }

    .timeline-item {
        position: relative;
        margin-bottom: 28px;
        padding-left: 18px
    }

    .timeline-item:before {
        content: '';
        position: absolute;
        left: -6px;
        top: 2px;
        width: 16px;
        height: 16px;
        background: var(--primary);
        border-radius: 50%;
        box-shadow: 0 0 0 6px rgba(43, 140, 255, 0.08)
    }

    .team-photo {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 12px
    }

    .cta {
        background: linear-gradient(90deg, var(--primary), #00c9a7);
        color: white;
        border-radius: 12px;
        padding: 30px
    }

    @media (max-width:767px) {
        .hero {
            padding: 48px 0
        }

        .team-photo {
            height: 180px
        }
    }
</style>
@endsection

@section('content')

<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="card-ghost p-5">
                    <h1 class="display-4">{{ $data->title }}</h1>
                    <p class="lead text-muted">{{ $data->description }}</p>
                    <div class="d-flex mt-4">
                        <a href="{{ $data->contact_button_link }}" class="btn btn-primary mr-3">{{ $data->contact_button_text }}</a>
                        <a href="{{ $data->service_button_link }}" class="btn btn-outline-primary">{{ $data->service_button_text }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-center d-none d-md-block">
                <img src="{{ Storage::url($data->image) }}"
                    alt="office" class="img-fluid rounded">
            </div>
        </div>

        <div class="row text-center mt-5">
            <div class="col-6 col-md-3 mb-3">
                <div class="card-ghost p-3">
                    <div class="stat">{{ $data->client_count }}</div>
                    <div class="text-muted">{{ $data->client_title }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card-ghost p-3">
                    <div class="stat">{{ $data->monthly_transaction_count }}</div>
                    <div class="text-muted">{{ $data->monthly_transaction_title }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card-ghost p-3">
                    <div class="stat">{{ $data->member_count }}</div>
                    <div class="text-muted">{{ $data->member_title }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card-ghost p-3">
                    <div class="stat">{{ $data->experience_count }}</div>
                    <div class="text-muted">{{ $data->experience_title }}</div>
                </div>
            </div>
        </div>

    </div>
</section>

<section id="about" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>{{ $data->mission_title }}</h3>
                <p class="text-muted">{{ $data->mission_description }}</p>

                <h5 class="mt-4">{{ $data->mission_title_2 }}</h5>
                <ul class="text-muted">
                    @if($data->list_1)
                    <li>{{ $data->list_1 }}</li>
                    @endif
                     @if($data->list_2)
                    <li>{{ $data->list_2 }}</li>
                     @endif
                     @if($data->list_3)
                    <li>{{ $data->list_3 }}</li>
                     @endif
                     @if($data->list_4)
                    <li>{{ $data->list_4 }}</li>
                     @endif
                     @if($data->list_5)
                    <li>{{ $data->list_5 }}</li>
                     @endif
                     @if($data->list_6)
                    <li>{{ $data->list_6 }}</li>
                     @endif
                </ul>
            </div>
            <div class="col-md-6">
                <h3>{{ $data->ourwork_title }}</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <h6 class="mb-1">{{ $data->list_1_title }}</h6>
                        <p class="text-muted">{{ $data->list_1_subtitle }}</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="mb-1">{{ $data->list_2_title }}</h6>
                        <p class="text-muted">{{ $data->list_2_subtitle }}</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="mb-1">{{ $data->list_3_title }}</h6>
                        <p class="text-muted">{{ $data->list_3_subtitle }}</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="mb-1">{{ $data->list_4_title }}</h6>
                        <p class="text-muted">{{ $data->list_4_subtitle }}</p>
                    </div>
                    @if($data->list_5_title)
                    <div class="timeline-item">
                        <h6 class="mb-1">{{ $data->list_5_title }}</h6>
                        <p class="text-muted">{{ $data->list_5_subtitle }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section id="team" class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">আমাদের দল</h3>
            <small class="text-muted">বেশি পরিচিতি পেতে বায়োতে ক্লিক করুন</small>
        </div>

        <div class="row">
            @foreach ($teams as $item)
            <div class="col-md-4 mb-4">
                <div class="card card-ghost p-3 h-100">
                    <img src="{{ Storage::url($item->image) }}"
                        class="team-photo mb-3" alt="{{ $item->name }}">
                    <h5 class="mb-1">{{ $item->name }}</h5>
                    <small class="text-muted">{{ $item->designation }}</small>
                    <p class="mt-2 text-muted">{{ $item->short_description }}</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">বিস্তারিত</a>
                </div>
            </div>
            @endforeach

            
        </div>
    </div>
</section>

<section id="testimonials" class="py-5">
    <div class="container">
        <h4 class="mb-4">ক্লায়েন্টদের কথা</h4>
        <div class="row">
            @foreach ($clients as $item)
            <div class="col-md-6 mb-3">
                <div class="card p-4 card-ghost">
                    <p class="mb-2">{{ $item->review_text }}</p>
                    <small class="text-muted">— {{ $item->name }}, {{ $item->designation }}</small>
                </div>
            </div>
             @endforeach
            
        </div>
    </div>
</section>

<section id="contact" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="cta">
                    <h4 class="mb-2">{{ $data->how_to_work_title }}</h4>
                    <p class="mb-3">{{ $data->how_to_work_subtitle }}</p>
                    <a href="mailto:{{ $data->how_to_work_button_link }}" class="btn btn-light">{{ $data->how_to_work_button_text }}</a>
                </div>
            </div>
            <div class="col-md-5 text-center">
                <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                    alt="contact" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>
@endsection