<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Gym</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="MyGyM - Revolutionize Your Gym Management Experience">
    <meta name="description" content="MyGym - Revolutionize Your Gym Management Experience">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/png" />

    <!-- ===== All CSS files ===== -->
    <link rel="stylesheet" href="assetss/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assetss/css/animate.css" />
    <link rel="stylesheet" href="assetss/css/lineicons.css" />
    <link rel="stylesheet" href="assetss/css/ud-styles.css" />

    <!-- Styles for Toggle Switch -->
    <style>
        /* Change the background color of the Sign In button in the responsive view */
        @media (max-width: 991px) {
            .navbar-nav .nav-item .btn-primary {
                background-color: #007bff;
                /* Blue background color */
                border-radius: 5px;
                width: 100%;
                text-align: center;
                margin-top: 10px;
            }
        }

        a#whatsapp_button span {
            box-shadow: 0 0 10px 0 rgb(0 0 0 / 14%);
            background: #fff;
        }

        a#whatsapp_button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        a#whatsapp_button i {
            box-shadow: 1px 6px 24px 0 rgba(7, 94, 84, 0.24);
            height: 52px;
            width: 54px;
            background: #24d366;
            color: #fff;
            font-size: 32px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        a#whatsapp_button i:hover {
            background: #00ae00;
            transition: 0.2s;
        }

        a#whatsapp_button span {
            display: inline-block;
            color: #000;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 30px;
            margin-left: 10px;
            text-transform: uppercase;
        }

        .pricing-toggle {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .original-price {
            font-size: 0.8em;
            color: #888;
            margin-right: 5px;
        }

        /* Change this to your site's primary color */
        input:checked+.slider {
            background-color: #007bff;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
            color: #fff !important;
            padding: 0.25em 0.4em;
            border-radius: 0.25rem;
        }
    </style>
</head>

<body>
    <!-- ====== Header Start ====== -->
    <header class="ud-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="">
                            <img src="assets/img/logo/full_logo_white.png" alt="Logo" />
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"> </span>
                            <span class="toggler-icon"> </span>
                            <span class="toggler-icon"> </span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul id="nav" class="navbar-nav mx-auto">
                                <li class="nav-item">
                                    <a class="ud-menu-scroll" href="#home">Home</a>
                                </li>

                                <li class="nav-item">
                                    <a class="ud-menu-scroll" href="#about">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="ud-menu-scroll" href="#pricing">Pricing</a>
                                </li>
                                <li class="nav-item">
                                    <a class="ud-menu-scroll" href="#team">Team</a>
                                </li>
                                <li class="nav-item">
                                    <a class="ud-menu-scroll" href="#contact">Contact</a>
                                </li>

                                <!-- Sign In Button as a Nav Item -->
                                <li class="nav-item d-block d-lg-none">
                                    @if (Auth::check())
                                        @php
                                            $dashboardRoute = '';

                                            if (Auth::user()->role == 'gym_admin') {
                                                $dashboardRoute = route('gym_admin.dashboard');
                                            } elseif (Auth::user()->role == 'staff') {
                                                $dashboardRoute = route('staff.dashboard');
                                            } elseif (Auth::user()->role == 'main_admin') {
                                                $dashboardRoute = route('main_admin.dashboard');
                                            }
                                        @endphp
                                        <a class="nav-link btn btn-primary text-white" href="{{ $dashboardRoute }}">
                                            Dashboard
                                        </a>
                                    @else
                                        <a class="nav-link btn btn-primary text-white" href="{{ route('login') }}">
                                            Sign In
                                        </a>
                                    @endif
                                </li>
                            </ul>
                        </div>

                        <div class="navbar-btn d-none d-lg-inline-block">
                            @if (Auth::check())
                                <a class="ud-main-btn ud-white-btn" href="{{ $dashboardRoute }}">Dashboard</a>
                            @else
                                <a class="ud-main-btn ud-white-btn" href="{{ route('login') }}">
                                    Sign In
                                </a>
                            @endif
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ====== Header End ====== -->


    <!-- ====== Hero Start ====== -->
    <section class="ud-hero" id="home">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-hero-content wow fadeInUp" data-wow-delay=".2s">
                        <h1 class="ud-hero-title">
                            Revolutionize Your Gym Management Experience
                        </h1>
                        <p class="ud-hero-desc">
                            Streamline operations, enhance member engagement, and grow your fitness business with MyGym
                            - the ultimate all-in-one gym management solution.
                        </p>
                        <ul class="ud-hero-buttons">
                            <li>
                                {{-- <a href="https://wa.me/212625081156?text=Salut%2C%20" rel="nofollow noopener"
                                    target="_blank" class="ud-main-btn ud-white-btn">
                                    Get Started Now
                                </a> --}}
                                <a href="#pricing"class="ud-main-btn ud-white-btn">
                                    Get Started Now
                                </a>
                            </li>
                            <li>
                                <a href="#contact" rel="nofollow noopener" class="ud-main-btn ud-link-btn">
                                    Get 7 day Trial <i class="lni lni-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    {{-- <div class="ud-hero-brands-wrapper wow fadeInUp" data-wow-delay=".3s">
                        <img src="assetss/images/hero/brand.svg" alt="brand" />
                    </div> --}}
                    <div class="ud-hero-image wow fadeInUp" data-wow-delay=".25s">
                        <img src="assetss/images/hero/app.png" alt="hero-image" />
                        <img src="assetss/images/hero/dotted-shape.svg" alt="shape" class="shape shape-1" />
                        <img src="assetss/images/hero/dotted-shape.svg" alt="shape" class="shape shape-2" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Hero End ====== -->

    <!-- ====== Features Start ====== -->
    <section id="features" class="ud-features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title">
                        <span>Features</span>
                        <h2>Powerful Tools to Elevate Your Gym</h2>
                        <p>
                            We provide a comprehensive suite of features designed to simplify and optimize every aspect
                            of your gym's operations.

                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-sm-4">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".1s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-gift"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">Member Management</h3>
                            <p class="ud-feature-desc">
                                Easily track and manage member details, memberships, and attendance with intuitive tools
                                designed for efficiency.
                            </p>
                            <a href="#">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-4">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".15s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-move"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">Multi-Dashboard System</h3>
                            <p class="ud-feature-desc">
                                Empower your team with dedicated dashboards for Gym Owner, Staff, and Coaches, each
                                tailored to their specific roles.
                            </p>
                            <a href="#">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-4">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".2s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-layout"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">Membership & Payment Management</h3>
                            <p class="ud-feature-desc">
                                Handle memberships, payments, and renewals with ease, ensuring your financials are
                                always in order.
                            </p>
                            <a href="#">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-4">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".25s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-layers"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">Class & Equipment Management</h3>
                            <p class="ud-feature-desc">
                                Schedule classes, manage equipment, and monitor usage to optimize your gym's offerings
                                and maintain top-notch facilities.
                            </p>
                            <a href="#">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-4">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".3s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-stats-up"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">Custom Reporting & Analytics</h3>
                            <p class="ud-feature-desc">
                                Get in-depth insights into your gym's performance with customizable reports that help
                                you make informed decisions.
                            </p>
                            <a href="#">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-4">
                    <div class="ud-single-feature wow fadeInUp" data-wow-delay=".35s">
                        <div class="ud-feature-icon">
                            <i class="lni lni-package"></i>
                        </div>
                        <div class="ud-feature-content">
                            <h3 class="ud-feature-title">Scalable Plans</h3>
                            <p class="ud-feature-desc">
                                Choose from scalable plans that grow with your gym, offering flexibility and support
                                that matches your needs.
                            </p>
                            <a href="#">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <!-- ====== Features End ====== -->

    <!-- ====== About Start ====== -->
    <section id="about" class="ud-about">
        <div class="container">
            <div class="ud-about-wrapper wow fadeInUp" data-wow-delay=".2s">
                <div class="ud-about-content-wrapper">
                    <div class="ud-about-content">
                        <span class="tag">About Us</span>
                        <h2>Empowering Gyms to Achieve More</h2>
                        <p>
                            At MyGym, our mission is to simplify gym management by providing intuitive and effective
                            software solutions. We understand the challenges of running a fitness center and are
                            dedicated to helping you focus on what matters most: delivering exceptional fitness
                            experiences to your members.
                        </p>

                        <p>
                            With years of experience in the fitness and technology industries, our team has crafted a
                            platform that addresses the unique needs of gyms of all sizes. Join us in transforming the
                            way you manage your gym and elevate your business to new heights.
                        </p>
                        <a href="javascript:void(0)" class="ud-main-btn">Learn More About Us</a>
                    </div>
                </div>
                <div class="ud-about-image">
                    <img src="assetss/images/about/about-image.svg" alt="about-image" />
                </div>
            </div>
        </div>
    </section>
    <!-- ====== About End ====== -->

    <!-- ====== Pricing Start ====== -->
    <section id="pricing" class="ud-pricing">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center">
                        <span>Pricing</span>
                        <h2>Our Pricing Plans</h2>
                        <p>
                            Choose the plan that fits your gym’s size and scale with ease.
                        </p>
                    </div>
                    <!-- Toggle Button for Monthly/Yearly Pricing -->
                    <div class="text-center mb-4">
                        <div class="pricing-toggle">
                            <span>Monthly</span>
                            <label class="switch">
                                <input type="checkbox" id="pricingToggle">
                                <span class="slider round"></span>
                            </label>
                            <span>Yearly <span class="badge bg-danger">-20% Off</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-0 align-items-center justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="ud-single-pricing first-item wow fadeInUp" data-wow-delay=".15s">
                        <div class="ud-pricing-header">
                            <h3>Basic Plan</h3>
                            <h4 class="monthly-price">249.99 dh/mo</h4>
                            <h4 class="yearly-price d-none">
                                <del class="original-price">3000 dh/yr</del>
                                <span class="discounted-price">2399.90 dh/yr</span>
                            </h4>
                        </div>
                        <div class="ud-pricing-body">
                            <ul>
                                <li>5 GB Storage</li>
                                <li>2 Users</li>
                                <li>100 Members</li>
                                <li>Support: Email Support</li>
                                <li>Access to Gym Admin Dashboard</li>
                                <li>Access to Staff Dashboard</li>
                            </ul>
                        </div>
                        <div class="ud-pricing-footer">
                            <a href="#contact" class="ud-main-btn ud-border-btn">
                                Purchase Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="ud-single-pricing active wow fadeInUp" data-wow-delay=".1s">
                        <span class="ud-popular-tag">POPULAR</span>
                        <div class="ud-pricing-header">
                            <h3>Standard Plan</h3>
                            <h4 class="monthly-price">399.99 dh/mo</h4>
                            <h4 class="yearly-price d-none">
                                <del class="original-price">4800 dh/yr</del>
                                <span class="discounted-price">3839.90 dh/yr</span>
                            </h4>
                        </div>
                        <div class="ud-pricing-body">
                            <ul>
                                <li>10 GB Storage</li>
                                <li>4 Users</li>
                                <li>150 Members</li>
                                <li>Support: Email & Phone Support</li>
                                <li>Access to Gym Admin Dashboard</li>
                                <li>Access to Staff Dashboard</li>
                            </ul>
                        </div>
                        <div class="ud-pricing-footer">
                            <a href="#contact" class="ud-main-btn ud-white-btn">
                                Purchase Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="ud-single-pricing last-item wow fadeInUp" data-wow-delay=".15s">
                        <div class="ud-pricing-header">
                            <h3>Premium Plan</h4>
                                <h4 class="monthly-price">599.99 dh/mo</h4>
                                <h4 class="yearly-price d-none">
                                    <del class="original-price">7200 dh/yr</del>
                                    <span class="discounted-price">5759.90 dh/yr</span>
                                </h4>
                        </div>
                        <div class="ud-pricing-body">
                            <ul>
                                <li>Unlimited GB Storage</li>
                                <li>Unlimited Users</li>
                                <li>Unlimited Members</li>
                                <li>Support: 24/7 Priority Support</li>
                                <li>Access to Gym Admin, Staff, and Coach Dashboards</li>
                            </ul>
                        </div>
                        <div class="ud-pricing-footer">
                            <a href="#contact" class="ud-main-btn ud-border-btn">
                                Purchase Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ====== Pricing End ====== -->


    <!-- ====== FAQ Start ====== -->
    <section id="faq" class="ud-faq">
        <div class="shape">
            <img src="assetss/images/faq/shape.svg" alt="shape" />
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title text-center mx-auto">
                        <span>Frequently Asked Questions
                        </span>
                        <h2>Any Questions? Answered</h2>
                        <p>
                            There are many variations of passages of Lorem Ipsum available
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="ud-single-faq wow fadeInUp" data-wow-delay=".1s">
                        <div class="accordion">
                            <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne">
                                <span class="icon flex-shrink-0">
                                    <i class="lni lni-chevron-down"></i>
                                </span>
                                <span>What is MyGym?</span>
                            </button>
                            <div id="collapseOne" class="accordion-collapse collapse">
                                <div class="ud-faq-body">
                                    MyGym is a comprehensive gym management software designed to streamline all
                                    aspects of running a fitness center, including member management, scheduling,
                                    payments, and more.


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ud-single-faq wow fadeInUp" data-wow-delay=".15s">
                        <div class="accordion">
                            <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo">
                                <span class="icon flex-shrink-0">
                                    <i class="lni lni-chevron-down"></i>
                                </span>
                                <span>Is there a free trial available?</span>
                            </button>
                            <div id="collapseTwo" class="accordion-collapse collapse">
                                <div class="ud-faq-body">
                                    Yes, we offer a 7-day free trial so you can explore all the features and see how
                                    MyGym can benefit your business.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ud-single-faq wow fadeInUp" data-wow-delay=".2s">
                        <div class="accordion">
                            <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree">
                                <span class="icon flex-shrink-0">
                                    <i class="lni lni-chevron-down"></i>
                                </span>
                                <span>Can I upgrade or downgrade my plan anytime?</span>
                            </button>
                            <div id="collapseThree" class="accordion-collapse collapse">
                                <div class="ud-faq-body">
                                    Absolutely! You can change your subscription plan at any time to suit your gym's
                                    evolving needs.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ud-single-faq wow fadeInUp" data-wow-delay=".1s">
                        <div class="accordion">
                            <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour">
                                <span class="icon flex-shrink-0">
                                    <i class="lni lni-chevron-down"></i>
                                </span>
                                <span>How secure is my data with MyGym?</span>
                            </button>
                            <div id="collapseFour" class="accordion-collapse collapse">
                                <div class="ud-faq-body">
                                    We prioritize data security and employ industry-standard encryption and security
                                    protocols to ensure your information is safe and protected.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ud-single-faq wow fadeInUp" data-wow-delay=".15s">
                        <div class="accordion">
                            <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive">
                                <span class="icon flex-shrink-0">
                                    <i class="lni lni-chevron-down"></i>
                                </span>
                                <span>What kind of customer support do you offer?</span>
                            </button>
                            <div id="collapseFive" class="accordion-collapse collapse">
                                <div class="ud-faq-body">
                                    We provide comprehensive support through email, live chat, and phone, along with
                                    extensive documentation and tutorials to assist you.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ud-single-faq wow fadeInUp" data-wow-delay=".2s">
                        <div class="accordion">
                            <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                data-bs-target="#collapseSix">
                                <span class="icon flex-shrink-0">
                                    <i class="lni lni-chevron-down"></i>
                                </span>
                                <span>Does MyGym support multiple gyms?
                                </span>
                            </button>
                            <div id="collapseSix" class="accordion-collapse collapse">
                                <div class="ud-faq-body">
                                    Yes, MyGym can manage multiple gyms, making it ideal for gym chains and franchises.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== FAQ End ====== -->

    <!-- ====== Testimonials Start ====== -->
    <section id="testimonials" class="ud-testimonials">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center">
                        <span>Testimonials</span>
                        <h2>What Our Clients Say
                        </h2>
                        <p>
                            There are many variations of passages of Lorem Ipsum available
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="ud-single-testimonial wow fadeInUp" data-wow-delay=".1s">
                        <div class="ud-testimonial-ratings">
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                        </div>
                        <div class="ud-testimonial-content">
                            <p>
                                “MyGym has completely transformed how we run our fitness center. Managing memberships
                                and scheduling classes has never been easier. Our staff and members love the
                                convenience!”
                            </p>
                        </div>
                        <div class="ud-testimonial-info">
                            <div class="ud-testimonial-image">
                                <img src="assetss/images/testimonials/author-01.png" alt="author" />
                            </div>
                            <div class="ud-testimonial-meta">
                                <h4>Sarah Johnson</h4>
                                <p>Owner of FitLife Gym</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ud-single-testimonial wow fadeInUp" data-wow-delay=".15s">
                        <div class="ud-testimonial-ratings">
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                        </div>
                        <div class="ud-testimonial-content">
                            <p>
                                “The analytics and reporting features have provided us with valuable insights into our
                                business performance. We've seen significant growth since implementing MyGym.”
                            </p>
                        </div>
                        <div class="ud-testimonial-info">
                            <div class="ud-testimonial-image">
                                <img src="assetss/images/testimonials/author-02.png" alt="author" />
                            </div>
                            <div class="ud-testimonial-meta">
                                <h4>Michael Lee</h4>
                                <p>Manager at ActivePulse Fitness</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ud-single-testimonial wow fadeInUp" data-wow-delay=".2s">
                        <div class="ud-testimonial-ratings">
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                            <i class="lni lni-star-filled"></i>
                        </div>
                        <div class="ud-testimonial-content">
                            <p>
                                “Customer support is top-notch! The MyGym team has been incredibly helpful and
                                responsive to our needs. Highly recommend this software to any gym owner.”
                            </p>
                        </div>
                        <div class="ud-testimonial-info">
                            <div class="ud-testimonial-image">
                                <img src="assetss/images/testimonials/author-03.png" alt="author" />
                            </div>
                            <div class="ud-testimonial-meta">
                                <h4>Emily Davis</h4>
                                <p>Founder of StrengthHub Gym</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Testimonials End ====== -->

    <!-- ====== Team Start ====== -->
    <section id="team" class="ud-team">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center">
                        <span>Our Team</span>
                        <h2>Meet the People Behind MyGym</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="ud-single-team wow fadeInUp" data-wow-delay=".1s">
                        <div class="ud-team-image-wrapper">
                            <div class="ud-team-image">
                                <img src="assetss/images/team/team-01.png" alt="team" />
                            </div>

                            <img src="assetss/images/team/dotted-shape.svg" alt="shape" class="shape shape-1" />
                            <img src="assetss/images/team/shape-2.svg" alt="shape" class="shape shape-2" />
                        </div>
                        <div class="ud-team-info">
                            <h5>Oussama</h5>
                            <h6>Founder & CEO</h6>
                        </div>
                        <ul class="ud-team-socials">
                            <li>
                                <a href="#">
                                    <i class="lni lni-facebook-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="lni lni-twitter-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="ud-single-team wow fadeInUp" data-wow-delay=".15s">
                        <div class="ud-team-image-wrapper">
                            <div class="ud-team-image">
                                <img src="assetss/images/team/team-02.png" alt="team" />
                            </div>

                            <img src="assetss/images/team/dotted-shape.svg" alt="shape" class="shape shape-1" />
                            <img src="assetss/images/team/shape-2.svg" alt="shape" class="shape shape-2" />
                        </div>
                        <div class="ud-team-info">
                            <h5>Mohammed</h5>
                            <h6>Developer</h6>
                        </div>
                        <ul class="ud-team-socials">
                            <li>
                                <a href="#">
                                    <i class="lni lni-facebook-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="lni lni-twitter-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="ud-single-team wow fadeInUp" data-wow-delay=".2s">
                        <div class="ud-team-image-wrapper">
                            <div class="ud-team-image">
                                <img src="assetss/images/team/team-03.png" alt="team" />
                            </div>

                            <img src="assetss/images/team/dotted-shape.svg" alt="shape" class="shape shape-1" />
                            <img src="assetss/images/team/shape-2.svg" alt="shape" class="shape shape-2" />
                        </div>
                        <div class="ud-team-info">
                            <h5>Reda</h5>
                            <h6>Developer</h6>
                        </div>
                        <ul class="ud-team-socials">
                            <li>
                                <a href="#">
                                    <i class="lni lni-facebook-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="lni lni-twitter-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="ud-single-team wow fadeInUp" data-wow-delay=".25s">
                        <div class="ud-team-image-wrapper">
                            <div class="ud-team-image">
                                <img src="assetss/images/team/team-04.png" alt="team" />
                            </div>

                            <img src="assetss/images/team/dotted-shape.svg" alt="shape" class="shape shape-1" />
                            <img src="assetss/images/team/shape-2.svg" alt="shape" class="shape shape-2" />
                        </div>
                        <div class="ud-team-info">
                            <h5>Ayoub</h5>
                            <h6>Developer</h6>
                        </div>
                        <ul class="ud-team-socials">
                            <li>
                                <a href="#">
                                    <i class="lni lni-facebook-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="lni lni-twitter-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Team End ====== -->

    <!-- ====== Contact Start ====== -->
    <section id="contact" class="ud-contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-7">
                    <div class="ud-contact-content-wrapper">
                        <div class="ud-contact-title">
                            <span>CONTACT US</span>
                            <h2>
                                Let's Talk About
                                <br />
                                Your Gym's Success
                            </h2>
                        </div>
                        <div class="ud-contact-info-wrapper">
                            <div class="ud-single-info">
                                <div class="ud-info-icon">
                                    <i class="lni lni-map-marker"></i>
                                </div>
                                <div class="ud-info-meta">
                                    <h5>Our Location</h5>
                                    <p>Casablanca, Morocco</p>
                                </div>
                            </div>
                            <div class="ud-single-info">
                                <div class="ud-info-icon">
                                    <i class="lni lni-envelope"></i>
                                </div>
                                <div class="ud-info-meta">
                                    <h5>Email Us</h5>
                                    <p>support@mygym.ma</p>
                                    <p>contact@mygym.ma</p>
                                </div>
                            </div>
                            <div class="ud-single-info">
                                <div class="ud-info-icon">
                                    <i class="lni lni-phone"></i>
                                </div>
                                <div class="ud-info-meta">
                                    <h5>Phone</h5>
                                    <p>+212 645-736280</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="ud-contact-form-wrapper wow fadeInUp" data-wow-delay=".2s">
                        <h3 class="ud-contact-form-title">Send us a Message</h3>

                        <!-- Success or Error Messages -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Contact Form -->
                        <form class="ud-contact-form" action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="ud-form-group">
                                <label for="fullName">Full Name*</label>
                                <input type="text" name="fullName" placeholder="full name" required />
                            </div>
                            <div class="ud-form-group">
                                <label for="email">Email*</label>
                                <input type="email" name="email" placeholder="example@yourmail.com" required />
                            </div>
                            <div class="ud-form-group">
                                <label for="phone">Phone*</label>
                                <input type="text" name="phone" placeholder="+212 6 1234 5678" required />
                            </div>
                            <div class="ud-form-group">
                                <label for="userMessage">Message*</label>
                                <textarea name="userMessage" rows="1" placeholder="type your message here" required></textarea>
                            </div>
                            <div class="ud-form-group mb-0">
                                <button type="submit" class="ud-main-btn">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== Contact End ====== -->

    <!-- ====== Footer Start ====== -->
    <footer class="ud-footer wow fadeInUp" data-wow-delay=".15s">
        <div class="shape shape-1">
            <img src="assetss/images/footer/shape-1.svg" alt="shape" />
        </div>
        <div class="shape shape-2">
            <img src="assetss/images/footer/shape-2.svg" alt="shape" />
        </div>
        <div class="shape shape-3">
            <img src="assetss/images/footer/shape-3.svg" alt="shape" />
        </div>
        <div class="ud-footer-widgets">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="ud-widget">
                            <a href="index.html" class="ud-footer-logo">
                                <img src="assets/img/logo/full_logo_white.png" alt="logo" />
                            </a>
                            <p class="ud-widget-desc">
                                We create innovative solutions to simplify gym management
                                , achieve greater efficiency and success.


                            </p>
                            <ul class="ud-widget-socials">
                                <li>
                                    <a href="">
                                        <i class="lni lni-facebook-filled"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="lni lni-twitter-filled"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="lni lni-instagram-filled"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="lni lni-linkedin-original"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                        <div class="ud-widget">
                            <h5 class="ud-widget-title">About Us</h5>
                            <ul class="ud-widget-links">
                                <li>
                                    <a href="#home">Home</a>
                                </li>
                                <li>
                                    <a href="#features">Features</a>
                                </li>
                                <li>
                                    <a href="#about">About</a>
                                </li>
                                <li>
                                    <a href="#testimonial">Testimonial</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6">
                        <div class="ud-widget">
                            <h5 class="ud-widget-title">Features</h5>
                            <ul class="ud-widget-links">
                                <li>
                                    <a href="#features">Features</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Privacy policy</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Terms of service</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Refund policy</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6">
                        <div class="ud-widget">
                            <h5 class="ud-widget-title">Our Products</h5>
                            <ul class="ud-widget-links">
                                <li>
                                    <a href="https://mygym.ma/" rel="nofollow noopner" target="_blank">MyGym
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="https://ecommercehtml.com/" rel="nofollow noopner"
                                        target="_blank">Ecommerce HTML</a>
                                </li>
                                <li>
                                    <a href="https://ayroui.com/" rel="nofollow noopner" target="_blank">Ayro UI</a>
                                </li>
                                <li>
                                    <a href="https://graygrids.com/" rel="nofollow noopner" target="_blank">Plain
                                        Admin</a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="col-xl-3 col-lg-6 col-md-8 col-sm-10">
                        <div class="ud-widget">
                            <h5 class="ud-widget-title">Partners</h5>
                            <ul class="ud-widget-brands">
                                <li>
                                    <a href="https://ayroui.com/" rel="nofollow noopner" target="_blank">
                                        <img src="assetss/images/footer/brands/ayroui.svg" alt="ayroui" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://ecommercehtml.com/" rel="nofollow noopner" target="_blank">
                                        <img src="assetss/images/footer/brands/ecommerce-html.svg"
                                            alt="ecommerce-html" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://graygrids.com/" rel="nofollow noopner" target="_blank">
                                        <img src="assetss/images/footer/brands/graygrids.svg" alt="graygrids" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://lineicons.com/" rel="nofollow noopner" target="_blank">
                                        <img src="assetss/images/footer/brands/lineicons.svg" alt="lineicons" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://uideck.com/" rel="nofollow noopner" target="_blank">
                                        <img src="assetss/images/footer/brands/uideck.svg" alt="uideck" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://tailwindtemplates.co/" rel="nofollow noopner" target="_blank">
                                        <img src="assetss/images/footer/brands/tailwindtemplates.svg"
                                            alt="tailwindtemplates" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="ud-footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <ul class="ud-footer-bottom-left">
                            <li>
                                <a href="javascript:void(0)">Privacy policy</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Support policy</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Terms of service</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <p class="ud-footer-bottom-right">
                            @
                            <script>
                                document.write(new Date().getFullYear());
                            </script> - All Rights Reserved by
                            <a href="https://mygym.ma" rel="nofollow">MyGym</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ====== Footer End ====== -->
    
    <!-- ====== Whatsapp Button Start ====== -->
    <a id="whatsapp_button" href="https://wa.me/+212645736280" target="_blank"><i class="lni lni-whatsapp"></i></a>
    <!-- ====== Whatsapp Button End ====== -->

    <!-- ====== Back To Top Start ====== -->
    <a href="javascript:void(0)" class="back-to-top">
        <i class="lni lni-chevron-up"> </i>
    </a>
    <!-- ====== Back To Top End ====== -->

    <!-- ====== All Javascript Files ====== -->
    <script src="assetss/js/bootstrap.bundle.min.js"></script>
    <script src="assetss/js/wow.min.js"></script>
    <script src="assetss/js/main.js"></script>
    <script>
        // ==== for menu scroll
        const pageLink = document.querySelectorAll(".ud-menu-scroll");

        pageLink.forEach((elem) => {
            elem.addEventListener("click", (e) => {
                e.preventDefault();
                document.querySelector(elem.getAttribute("href")).scrollIntoView({
                    behavior: "smooth",
                    offsetTop: 1 - 60,
                });
            });
        });

        // section menu active
        function onScroll(event) {
            const sections = document.querySelectorAll(".ud-menu-scroll");
            const scrollPos =
                window.pageYOffset ||
                document.documentElement.scrollTop ||
                document.body.scrollTop;

            for (let i = 0; i < sections.length; i++) {
                const currLink = sections[i];
                const val = currLink.getAttribute("href");
                const refElement = document.querySelector(val);
                const scrollTopMinus = scrollPos + 73;
                if (
                    refElement.offsetTop <= scrollTopMinus &&
                    refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
                ) {
                    document
                        .querySelector(".ud-menu-scroll")
                        .classList.remove("active");
                    currLink.classList.add("active");
                } else {
                    currLink.classList.remove("active");
                }
            }
        }

        window.document.addEventListener("scroll", onScroll);
    </script>
    <!-- Script for Pricing Toggle -->
    <script>
        document.getElementById('pricingToggle').addEventListener('change', function() {
            const monthlyPrices = document.querySelectorAll('.monthly-price');
            const yearlyPrices = document.querySelectorAll('.yearly-price');
            const isChecked = this.checked;

            monthlyPrices.forEach(price => {
                price.classList.toggle('d-none', isChecked);
            });

            yearlyPrices.forEach(price => {
                price.classList.toggle('d-none', !isChecked);
            });
        });
    </script>
</body>

</html>
