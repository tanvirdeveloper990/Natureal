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
                    <h1 class="display-4">আমরা Holistica — ডিজাইন করি নিরাপত্তা ও স্কেলেবল সফটওয়্যার</h1>
                    <p class="lead text-muted">Holistica-তে আমরা সারা বিশ্বের ব্যবসার জন্য টেকসই, নিরাপদ ও ব্যবহারবান্ধব
                        প্ল্যাটফর্ম বানাই। আমাদের কাজের কেন্দ্রবিন্দু: বিশ্বাসযোগ্যতা, গতি এবং সুন্দর অভিজ্ঞতা।</p>
                    <div class="d-flex mt-4">
                        <a href="#contact" class="btn btn-primary mr-3">যোগাযোগ করুন</a>
                        <a href="#services" class="btn btn-outline-primary">আমাদের সেবা দেখুন</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-center d-none d-md-block">
                <img src="{{asset('/assets/img/seller-commision.png')}}"
                    alt="office" class="img-fluid rounded">
            </div>
        </div>

        <div class="row text-center mt-5">
            <div class="col-6 col-md-3 mb-3">
                <div class="card-ghost p-3">
                    <div class="stat">120+</div>
                    <div class="text-muted">খুশি ক্লায়েন্ট</div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card-ghost p-3">
                    <div class="stat">8m+</div>
                    <div class="text-muted">মাসিক ট্রানজ্যাকশন</div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card-ghost p-3">
                    <div class="stat">50+</div>
                    <div class="text-muted">দলীয় সদস্য</div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card-ghost p-3">
                    <div class="stat">5yrs</div>
                    <div class="text-muted">অভিজ্ঞতা</div>
                </div>
            </div>
        </div>

    </div>
</section>

<section id="about" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>আমাদের মিশন</h3>
                <p class="text-muted">Holistica-র মিশন — প্রযুক্তিকে মানুষের জন্য সহজ ও নির্ভরযোগ্য করা। আমরা এমন পণ্য
                    তৈরির চেষ্টা করি যা ব্যবহারকারীর বিশ্বাস জিততে পারে এবং ব্যবসার বৃদ্ধি ত্বরান্বিত করে।</p>

                <h5 class="mt-4">মান এবং নীতি</h5>
                <ul class="text-muted">
                    <li>ব্যবহারকারী কেন্দ্রিক ডিজাইন</li>
                    <li>নিরাপত্তা প্রথম</li>
                    <li>স্বচ্ছতা ও দায়বদ্ধতা</li>
                    <li>টিমওয়ার্ক ও নতুনত্বের উৎসাহ</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h3>কীভাবে আমরা কাজ করি</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <h6 class="mb-1">আবিষ্কার & গবেষণা</h6>
                        <p class="text-muted">ব্যবহারকারীর চাহিদা ও বাজার বিশ্লেষণ করে আমরা পরিকল্পনা করি।</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="mb-1">প্রোটোটাইপ & ডিজাইন</h6>
                        <p class="text-muted">দ্রুত প্রোটোটাইপ তৈরি করে ব্যবহারকারীর সঙ্গে টেস্ট করি।</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="mb-1">বিল্ড & স্কেল</h6>
                        <p class="text-muted">মডুলার আর্কিটেকচার ব্যবহার করে দ্রুত উন্নয়ন ও স্কেলিং করি।</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="mb-1">রিলিজ & সাপোর্ট</h6>
                        <p class="text-muted">নিরবচ্ছিন্ন সাপোর্ট ও আপডেট দিয়ে ক্লায়েন্টের সাফল্য নিশ্চিত করি।</p>
                    </div>
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
            <div class="col-md-4 mb-4">
                <div class="card card-ghost p-3 h-100">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=60"
                        class="team-photo mb-3" alt="team1">
                    <h5 class="mb-1">আব্দুল রহমান</h5>
                    <small class="text-muted">CEO & Founder</small>
                    <p class="mt-2 text-muted">প্রডাক্ট স্ট্র্যাটেজি ও ভিশন—দীর্ঘ অভিজ্ঞতা নিয়ে টিমকে নেতৃত্ব দেন।</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">বিস্তারিত</a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-ghost p-3 h-100">
                    <img src="https://images.unsplash.com/photo-1545996124-54a0b7a1d1b0?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=60"
                        class="team-photo mb-3" alt="team2">
                    <h5 class="mb-1">নাবিলা হাসান</h5>
                    <small class="text-muted">Head of Engineering</small>
                    <p class="mt-2 text-muted">স্কেলেবল সিস্টেম ও নিরাপত্তায় বিশেষজ্ঞ।</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">বিস্তারিত</a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-ghost p-3 h-100">
                    <img src="https://images.unsplash.com/photo-1554151228-14d9def656e4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=60"
                        class="team-photo mb-3" alt="team3">
                    <h5 class="mb-1">সুহান মুহম্মদ</h5>
                    <small class="text-muted">Head of Design</small>
                    <p class="mt-2 text-muted">UX/UI ডিজাইন ও ব্র্যান্ডিং নিয়ে কাজ করেন।</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">বিস্তারিত</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="testimonials" class="py-5">
    <div class="container">
        <h4 class="mb-4">ক্লায়েন্টদের কথা</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card p-4 card-ghost">
                    <p class="mb-2">"Holistica-এর টিম আমাদের প্ল্যাটফর্মটিকে দ্রুত ও নির্ভরযোগ্যভাবে স্কেল করেছে —
                        সার্ভিস লেভেল চমৎকার।"</p>
                    <small class="text-muted">— রাহুল, CTO, Finify</small>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card p-4 card-ghost">
                    <p class="mb-2">"ডিজাইন এবং ইউএক্স খুবই মার্জিত — ব্যবহারকারীরা সহজেই কার্য সম্পাদন করতে পারে।"</p>
                    <small class="text-muted">— আনিকা, Product Lead, Shoply</small>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="cta">
                    <h4 class="mb-2">কাজ শুরু করতে চান?</h4>
                    <p class="mb-3">আপনার আইডিয়া বলুন — আমরা কিভাবে এগোতে পারি তা পরিকল্পনা করে দেব।</p>
                    <a href="mailto:hello@Holistica.com" class="btn btn-light">ইমেইল পাঠান</a>
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