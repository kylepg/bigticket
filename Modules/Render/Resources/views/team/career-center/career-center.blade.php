@extends('render::layouts.full-width')
@section('content')

<link href="{{ asset('/render-assets/render/tailwind.css') }}" rel="stylesheet">
<link href="{{ asset('/render-assets/team/career-center/career-center.css') }}" rel="stylesheet">
<script src="{{ asset('/render-assets/team/career-center/career-center.js') }}"></script>

<!-- -------------------------- ^^^ PROJECT JS/CSS ^^^ -------------------------- -->
<div id="career-center">
    <section id="login-overlay" class="overlay">
        <div class="shade"></div>
        <div class="login-modal">
            <div class="inner">
                <i class="fas fa-times close-button"></i>
                <div class="max-w-sm relative py-4 px-2">
                    @include('render::team.career-center.career-center-logo')
                </div>
                <p class="mb-4">Please enter your MVP registration email address:</p>
                <input class="form-control" type="email">
                <p class="error-message">This email address has not been registered.</p>
                <p class="valid-message">Please enter a valid email address.</p>
                <div style="display: none" class="success">
                    <div class="lds-spinner">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <button class="submit-button">Submit</button>
            </div>
        </div>
    </section>
    <section id="key-takeaway-overlay" class="overlay">
        <div class="shade"></div>
        <div class="bg-gray-200 p-6 relative max-w-6xl rounded-lg flex flex-col justify-center items-center">
            <i
                class="fas fa-times close-button md:hover:text-gray-600 text-4xl relative self-end pr-2 pb-4 cursor-pointer"></i>
            @foreach($ccc["webinars"] as $webinar)
            <img data-name="{{$webinar["name"]}}" class="w-full rounded-lg hidden"
                src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/key-takeaways_{{$webinar["name"]}}.jpg" />
            @endforeach
            @foreach($ccc["Live Speaker"] as $sp)
            <img data-name="live-speaker-panel_week-{{$sp["week"]}}" class="w-full rounded-lg hidden"
                src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/key-takeaways_live-speaker-panel_week-{{$sp["week"]}}.jpg" />
            @endforeach
            <a download href=""
                class="bg-green-500 mt-4 text-4xl py-4 px-8 font-bold md:hover:bg-green-400 text-uppercase rounded cursor:pointer text-white futura w-auto">
                Download</a>
        </div>
    </section>
    <section id="video-overlay" class="overlay">
        <div class="shade"></div>
        <div class="relative overlay-container pt-0 p-8">
            <div class="bg-gray-200 p-1 w-full relative rounded-lg flex flex-col items-center">
                <p class="title text-green-500 futura text-4xl font-bold">
                </p>
                <i
                    class="fas fa-times close-button md:hover:text-gray-600 text-4xl absolute self-end pr-4 py-4 cursor-pointer"></i>
                <div class="video-wrap">
                    <script class="_nbaVideoPlayerScout" data-team="celtics"
                        data-videoId="/video/teams/celtics/2020/07/10/3318382/1594412017861-Hype-2-3318382"
                        data-width="768" data-height="732" src="https://www.nba.com/scout/team/cvp/videoPlayerScout.js">
                    </script>
                </div>
            </div>
        </div>
    </section>
    <section data-section="header">
        <img class="bg" data-desktop alt="Virtual Jr. Celtics Camps"
            src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/career-center-bg_lg.jpg">
        <img class="bg-blur" data-desktop alt="Virtual Jr. Celtics Camps"
            src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/career-center-bg_lg.jpg">
        <img class="bg" data-mobile alt="Virtual Jr. Celtics Camps"
            src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/career-center-bg_sm.jpg">
        <div class="inner py-8">
            @include('render::team.career-center.career-center-logo')
            <div class="register-wrap only-if-not-logged-in">
                <a class="register-button" href="https://am.ticketmaster.com/celtics/CareerCenter#/">REGISTER</a>
                <p>Already registered as an MVP? <span class="login-button">Log
                        In</span></p>
            </div>
            <p class="registrant-name only-if-logged-in">Welcome <span class="name"></span>! <span
                    class="logout-button ">Log out</span>
            </p>
            <div class="shader"></div>
    </section>
    <section data-section="blurb">
        <div class="inner">
            <div>
                <p>Have you ever wondered how the front office staff at the winningest franchise in the NBA got their
                    foot
                    in the door and advanced their career paths?</p>
                <p>

                    The Celtics Career Center program is a new opportunity to
                    learn first-hand how Celtics staff navigate their careers in the competitive sports industry.
                    Whether
                    you’re a college student, recent grad, or seasoned professional, this eight-week virtual program
                    will
                    give participants unprecedented access to the best in the business in an effort to help advance your
                    career in sports.
                </p>
            </div>
            <div class="img-wrap">
                <img alt="Celtics staff members with Enes Kanter" class="hm"
                    src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/staff-pic_1.jpg" />
            </div>
        </div>
    </section>

    <section data-section="webinars">

        <!-- Webinars -->

        <div class="content-row">
            <div class="inner">
                <h2><i class="fas fa-video"></i>Webinars</h2>
                <div class="carousel" data-carousel="webinars">
                    @foreach($ccc["webinars"] as $webinar)
                    <div class="card carousel-cell p-4 cursor-pointer md:w-5/12 w-10/12"
                        data-name="{{$webinar["name"]}}" data-title="{{$webinar["title"]}}" data-locked="false"
                        data-videoId="{{ $webinar["videoId"] }}">
                        <div class="card-inner w-full h-full rounded bg-gray-200 shadow-md">
                            <div class="img-wrap relative rounded-t overflow-hidden cursor-pointer flex-1">
                                <div class="play-wrap absolute w-full flex justify-center items-center h-full"><i
                                        style="font-size: 3rem" class="absolute fas fa-play z-50 text-white"></i>
                                </div>
                                <div
                                    class="green-shading absolute bg-green-500 w-full h-full opacity-50 z-10 transition-opacity duration-500">
                                </div>
                                <img class="h-full w-full duration-500 leading-10"
                                    src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/webinar_{{$webinar["name"]}}.jpg"
                                    alt="{{$webinar["title"]}} Staff on Webinar" />
                            </div>
                            <div class="card-bottom py-4 px-6 flex-1">
                                <p class="futura font-bold leading-snug text-3xl text-green-500 md:my-2 mb-2">
                                    {{$webinar["title"]}}</p>
                                <ul class="staff-list p-0 list-none text-gray-700 top-0">
                                    @foreach($webinar["guests"] as $guest)
                                    <li class="futura font-normal"><span
                                            class="font-bold text-black pr-3">{{$guest["name"]}}</span>{{$guest["title"]}}
                                    </li>
                                    @endforeach
                                </ul>
                                <div data-image="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/key-takeaways_{{$webinar["name"]}}.jpg"
                                    class="btn-celtics bg-green-500 cursor-pointer rounded shadow text-2xl font-bold text-white futura no-underline text-center py-2 px-4 relative my-4 key-takeaways md:hover:bg-green-400 transition duration-300 text-uppercase"
                                    data-episode="">Key Takeaways</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Employee Spotlight -->

        <div class="content-row">
            <div class="inner">
                <h2><i class="fas fa-user"></i>Employee Spotlight</h2>
                <div class="carousel">
                    @foreach($ccc["bops"] as $bop)
                    <div class="card carousel-cell p-4 cursor-pointer md:w-3/12 w-10/12" data-locked="false">
                        <a style="color: inherit; text-decoration: none;" class="no-underline"
                            href="https://www.nba.com/celtics/team/beyond-the-parquet/{{ $bop["name"]}}">
                            <div class="card-inner w-full h-full rounded bg-gray-200 shadow-md">
                                <div class="img-wrap relative rounded-t overflow-hidden cursor-pointer flex-1">
                                    <div class="green-shading absolute bg-green-500 w-full h-full opacity-50 z-10
                                    transition-opacity duration-500"></div>
                                    <img class="h-full w-full duration-500"
                                        src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/beyond-the-parquet/images/staff-headshot_{{ $bop["name"]}}_700x700.jpg"
                                        alt="" />
                                </div>
                                <div class="py-4 px-6 flex-1">
                                    <p class="futura font-bold text-3xl text-green-500 no-underline leading-10">
                                        {{ $bop["display_name"]}}</p>
                                    <p class="futura no-underline">{{ $bop["title"]}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Weekly Blogs -->

        <div class="content-row">
            <div class="inner">
                <h2><i class="fas fa-comment-edit"></i>Weekly Blog</h2>
                <p class="only-if-not-logged-in pl-4"><span class="font-bold">Locked content.</span>
                    Please <a href="https://am.ticketmaster.com/celtics/CareerCenter#/"
                        class="font-bold text-green-500 cursor-pointer no-underline hover:text-green-400">register</a>
                    for or <span
                        class="login-button font-bold text-green-500 cursor-pointer no-underline hover:text-green-400">log
                        in</span>
                    with an MVP account
                    to access.</p>
                <div class="carousel">
                    @foreach($ccc["blogs"] as $blog)
                    <div class="card carousel-cell p-4 cursor-pointer md:w-4/12 w-10/12" data-locked="true">
                        <a style="color: inherit; text-decoration: none;" class="no-underline"
                            href="https://www.nba.com/celtics/team/career-center/blog/{{ $blog["name"]}}">
                            <div class="card-inner w-full h-full rounded bg-gray-200 shadow-md">
                                <div
                                    class="img-wrap relative rounded-t overflow-hidden cursor-pointer flex-1 flex justify-center items-center">
                                    <i class="fas fa-lock z-50 text-white absolute hidden text-6xl"></i>
                                    <div class="green-shading absolute bg-green-500 w-full h-full opacity-50 z-10
                                    transition-opacity duration-500"></div>
                                    <img class="h-full w-full duration-500"
                                        src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/blog_{{ $blog["name"]}}.jpg"
                                        alt="Photo of {{$blog["author"]}}" />
                                </div>
                                <div class="py-4 px-6 flex-1">
                                    <p class="futura font-bold text-3xl text-green-500 no-underline leading-10 mb-2">
                                        {{$blog["title"]}}</p>
                                    <p class="futura no-underline leading-8"><span
                                            class="font-bold pr-2 ">{{ $blog["author"]}}</span>{{$blog["author_title"]}}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- LIVE SPEAKER PANELS -->

        <div class="content-row">
            <div class="inner">
                <h2><i class="fas fa-keynote"></i>Live Speaker Panels</h2>
                <p class="only-if-not-logged-in pl-4"><span class="font-bold">Locked content.</span>
                    Please <a href="https://am.ticketmaster.com/celtics/CareerCenter#/"
                        class="font-bold text-green-500 cursor-pointer no-underline hover:text-green-400">register</a>
                    for or <span
                        class="login-button font-bold text-green-500 cursor-pointer no-underline hover:text-green-400">log
                        in</span>
                    with an MVP account
                    to access.</p>
                <div class="carousel" data-carousel="live-speaker-panels">
                    @foreach($ccc["Live Speaker"] as $sp)
                    <div class="card carousel-cell p-4 cursor-pointer md:w-5/12 w-10/12" data-locked="true"
                        data-week="{{$sp["week"]}}" data-name="live-speaker-panel_week-1" data-title="{{$sp["title"]}}"
                        data-videoId="{{ $sp["videoId"] }}">
                        @if(!$sp["past"])
                        <a style="color: inherit; text-decoration: none;" class="no-underline"
                            href="{{$sp["past"] ? '' : $sp["registrations"][0]["link"]}}">
                            @endif
                            <p class="futura font-bold leading-snug text-3xl md:my-2 mb-2">
                                Week {{$sp["week"]}} | {{ $sp["displayDate"]}}</p>
                            <div class="card-inner w-full h-full rounded bg-gray-200 shadow-md">
                                <div
                                    class="img-wrap relative rounded-t overflow-hidden cursor-pointer flex-1 flex justify-center items-center">
                                    <div
                                        class="play-wrap absolute w-full flex justify-center items-center h-full {{!$sp["past"] ? 'hidden' : ''}}">
                                        <i style="font-size: 3rem" class="absolute fas fa-play z-50 text-white"></i>
                                    </div>
                                    <i class="fas fa-lock z-50 text-white absolute hidden text-6xl"></i>
                                    <div class="green-shading absolute bg-green-500 w-full h-full opacity-50 z-10
                                    transition-opacity duration-500"></div>
                                    <img class="h-full w-full duration-500"
                                        src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/live-speaker-panel_week-{{ $sp["week"]}}.jpg"
                                        alt="Week {{$sp["week"]}} Panel Photo" />
                                </div>
                                <div class="card-bottom py-4 px-6 flex-1">
                                    <p class="futura font-bold leading-snug text-3xl text-green-500 md:my-2 mb-2">
                                        {{$sp["title"]}}</p>
                                    <ul class="staff-list p-0 list-none text-gray-700 top-0 mb-7">
                                        @foreach($sp["guests"] as $guest)
                                        <li style="line-height: 1.15" class="futura font-normal mb-4"><span
                                                class="font-bold text-black pr-3">{{$guest["name"]}}</span>{{$guest["title"]}}
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div data-image="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/key-takeaways_webinar_week-{{$sp["week"]}}.jpg"
                                        class="{{!$sp["past"] ? 'hidden' : ''}} btn-celtics bg-green-500 cursor-pointer rounded shadow text-2xl font-bold text-white futura no-underline text-center py-2 px-4 relative my-4 key-takeaways md:hover:bg-green-400 transition duration-300 text-uppercase"
                                        data-episode="">Key Takeaways</div>
                                    <a href="{{$sp["registrations"][0]["link"]}}"
                                        class="btn-celtics bg-green-500 cursor-pointer rounded shadow text-2xl font-bold block
                                        text-white futura no-underline text-center py-2 px-4 relative my-4
                                md:hover:bg-green-400 transition duration-300 text-uppercase {{$sp["past"] ? 'hidden' : ''}}" data-episode="">Register</a>
                                </div>
                            </div>
                            @if(!$sp["past"])
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Small Group Q&A Sessions -->

        {{-- <div class="content-row">
            <div class="inner">
                <h2><i class="fas fa-users"></i>Small Group Q&A Sessions</h2>
                <p class="only-if-not-logged-in pl-4"><span class="font-bold">Locked content.</span>
                    Please <a href="https://am.ticketmaster.com/celtics/CareerCenter#/"
                        class="font-bold text-green-500 cursor-pointer no-underline hover:text-green-400">register</a>
                    for or <span
                        class="login-button font-bold text-green-500 cursor-pointer no-underline hover:text-green-400">log
                        in</span>
                    with an MVP account
                    to access.</p>
                <div class="carousel">
                    @foreach($ccc["smallGroupPanels"] as $smGrp)
                    <div class="card carousel-cell p-4 md:w-5/12 w-10/12 {{$smGrp["past"] ? 'pointer-events-none' : ''}}"
        data-locked="true" data-week="{{$smGrp["week"]}}">
        <div class="card-inner w-full h-full rounded bg-gray-200 shadow-md">
            <div
                class="img-wrap relative rounded-t overflow-hidden cursor-pointer flex-1 flex justify-center items-center">
                <i class="fas fa-lock z-50 text-white absolute hidden text-6xl"></i>
                <div class="green-shading absolute bg-green-500 w-full h-full opacity-50 z-10
                                    transition-opacity duration-500"></div>
                <img class="h-full w-full duration-500"
                    src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/small-group-panel_week-{{ $smGrp["week"]}}.jpg?1"
                    alt="Week {{$smGrp["week"]}} Small Group Panel Photo" />
            </div>
            <div class="card-bottom py-4 px-6 flex-1">
                <p class="futura font-bold leading-snug text-3xl text-green-500 md:my-2 mb-2">
                    {{$smGrp["title"]}}</p>
                <p class="futura font-normal leading-snug mb-2">{{$smGrp["description"]}}</p>
                @foreach($smGrp["registration_links"] as $i => $link)
                <div class="flex items-center justify-between flex-wrap">
                    <p class="futura text-2xl uppercase font-semibold pr-2">{{$link["date"]}}</p>
                    <a href="{{$link["link"]}}" class="{{ $smGrp["past"] ? 'hidden' : '' }} btn-celtics bg-green-500 cursor-pointer rounded shadow text-2xl
                                        font-bold block text-white futura no-underline text-center py-2 px-4 relative
                                        my-4 md:w-auto w-full md:hover:bg-green-400 transition duration-300
                                        text-uppercase {{$smGrp["past"] ? 'hidden' : ''}}" data-episode="">Register For
                        Session {{$i + 1}}</a>
                </div>
                @endforeach
            </div>
        </div>
</div>
@endforeach
</div>
</div>
</div> --}}
</section>
<section data-section="stay-connected">
    <div class="inner">
        <h2 class="title"><i class="fas fa-share-alt"></i>Stay Connected</h2>
        <div class="divide"></div>
        <div class="social-wrap">
            <a href="https://twitter.com/celtics"><i class="fab fa-twitter-square"></i></a>
            <a href="https://www.facebook.com/bostonceltics/"><i class="fab fa-facebook-square"></i></a>
            <a href="https://www.instagram.com/celtics/?hl=en"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/company/bostonceltics/"><i class="fab fa-linkedin"></i></a>
            <a href="https://www.snapchat.com/add/celtics"><i class="fab fa-snapchat-square"></i></a>
            <a href="https://www.youtube.com/celticsom"><i class="fab fa-youtube-square"></i></a>
            <a href="https://www.nba.com/celtics/clubgreen/subscribe" class="subscribe"><i
                    class="fas fa-envelope"></i>Subscribe to Club Green
            </a>
        </div>
    </div>
</section>
<section data-section="footer">
    <img src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/staff-pic_2.jpg" />
    <div class="inner">
        <div>
            <p class="questions mb-8"><span>Questions?</span> Contact groupsales@celtics.com</p>
            <p class="legal">Participation is open to residents of (i) MA, (ii) RI, NH, VT, and ME who live within a
                150-mile radius of Boston, MA, or (iii) CT who live within a 75-mile radius of Boston, MA.</p>
            <p class="legal">
                Participation in or completion of CCC does not (a) confer any academic or internship credit, or (b)
                guarantee, imply or warrant in any way any internship or employment opportunity with the Boston
                Celtics
                or their affiliates. The CCC content and materials are intended for informational purposes only, are
                general in nature, and are not intended to, and should not be relied upon, or construed as, career
                or
                job advice regarding any specific situation or factual circumstance. Your participation in CCC does
                not
                entitle you to access or use any other resources of the Boston Celtics or their affiliates.</p>
            <p class="legal">
                Participants will not be considered registered unless all requested info is received prior to
                October
                13th, 2020.</p>
        </div>
    </div>
</section>
</div>
@endsection