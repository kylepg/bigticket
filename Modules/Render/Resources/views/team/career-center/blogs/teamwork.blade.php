@extends('render::layouts.sidebar')
@section('content')
<link href="{{ asset('/render-assets/team/career-center/blog.css') }}" rel="stylesheet">
<script src="{{ asset('/render-assets/team/career-center/blog.js') }}"></script>

<style>
    @media (max-width: 600px) {
        .img-wrap {
            width: 100%;
            max-width: 100% !important;
            float: none;
            display: flex;
            justify-content: center;
            flex-direction: column;
            padding: 2em 1em !important;
            align-items: center;
        }

        .img-wrap img {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
        }
    }

    .img-wrap img {
        border-radius: 0.25em;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }
</style>
<div id="blog-wrap">
    <div id="login" style="padding: 1em">
        <div class="inner">
            <div class="max-w-sm relative py-4 px-2">
                @include('render::team.career-center.career-center-logo')
            </div>
            <p style="margin: 0.5em 0em;"><strong>Locked content</strong>. Please <strong><a
                        href="https://am.ticketmaster.com/celtics/CareerCenter#/">register</a></strong>
                for MVP access.</p>
            <p class="mb-4">Already registered? Enter your email address:
            </p>
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
    <div id="content-wrap">
        <h1 style="margin-bottom: 1em">Teamwork</h1>
        <div class="img-wrap" style="float: left; padding-left: 0; padding-right:2em;">
            <img class="xs-full"
                src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/kara-walker.jpg"
                alt="Kara Walker" style="margin: 0em 4em 1em 0em; max-width:350px;">
        </div>
        <h3>Blogger: <span style="color: #212121">Kara Walker – Vice President, Marketing & Content Strategy</span></h3>
        <h3>Celtics Tenure: <span style="color: #212121">14 years</span></h3>
        <p style="font-style: italic;">Kara is entering her 14th season with the Celtics. After graduating from Ithaca
            College in 2007, she started with the Celtics in Ticket Operations. Through that role, she developed a
            strong understanding of our fans and Season Ticket Members and took that knowledge to her role in marketing.
            As the organization has grown and digital content has become an area of increased focus, Kara’s team and
            responsibilities have grown as well. As Vice President of Marketing & Content Strategy, she now oversees
            traditional ticket marketing, social media, email marketing, advertising, branding, fan engagement, game
            operations, live events and content strategy (ideation, production and monetization).</p>
        <p>
            Working for a professional sports team, it’s no surprise that I constantly stress the importance of teamwork
            and collaboration. In order for the team to perform at a high level on the court, every player needs to work
            together, assuming a particular role, putting the goals of the team (winning) ahead of any individual goals
            (stats, awards, etc.). A high level of teamwork has been arguably the most important characteristic of any
            successful Celtics team I’ve seen over the years (and for that matter, successful teams throughout sports).
            We often talk on the front office side about how much we can learn from the basketball side, but the truth
            is many of us have been learning these principles of teamwork for most of our lives.
        </p>
        <p>
            Many of us who work in professional sports were once team sport athletes, and it’s no coincidence. As a
            former
            Division III college soccer player (Go Bombers!), seeing team sports on a resume for a potential job or
            internship candidate immediately suggests to me that someone knows how to work with others to achieve a
            common
            goal. And as a manager, that’s incredibly valuable. Professional sports teams often have front offices that
            are
            much smaller than people assume. We’re global brands operating with staff sizes that are much more
            indicative to
            a small mom-and-pop shop. That means that we need to maximize the impact of every single employee, and that
            there’s no time for egos. We truly need to make sure that our whole is greater than the sum of our parts. To
            put
            it simply, we need to display teamwork in everything we do.</p>
        <p>
            The most valuable thing that my bosses over the years have taught me is that if I do well, I make them look
            good. Now that I run a department, I remind my staff of that constantly. If we produce good content and keep
            fans engaged at a high level, if we sell lots of tickets and ensure the Celtics brand is strong, that looks
            good for every one of us. Strong content leads to engaged fans, which leads to monetization through
            sponsorship of content and sales (tickets, merchandise, etc.), which leads to money that we can put back
            into the team – all coming back to our overarching goal of winning that next Championship. Whether you’re
            the superstar or the sixth man (person) on any given day, your role is just as important and you’re just as
            valuable. It’s a cliché, but it’s absolutely true.
        </p>
        <p>
            If I think back on my favorite projects over the past 13 Seasons, the common thread is teamwork. There is
            nothing so rewarding as coming up with an idea, working tirelessly with dozens of people across several
            departments, and eventually seeing it come to fruition. One such project was a content series we’ve produced
            the past two seasons called Passing the Torch. This started as an idea on how to make our rich history and
            tradition more accessible to a young audience. It took months of planning, coordination not only internally
            but with our broadcast partner NBC Sports Boston, and an entire team comprised of marketing, content
            production, creative, communications, corporate sponsorship, basketball operations and more. The end result
            was a show that I personally had little to do with actually creating, but I was incredibly proud of the team
            effort that made it happen.</p>

        <p>Bill Russell said, “Create unselfishness as the most important team attribute.” I’m not sure I can say it any
            better. As a leader, if you can instill a true sense of team, you’ll have success, and as an employee, if
            you can become a great teammate, you’ll bring immense value. Teamwork and the importance of making your
            teammates better has been a characteristic valued by the Boston Celtics for decades. If we can all recognize
            that we’re working toward the same goal, whether that’s bringing Banner 18 to Boston, creating great
            content, selling out TD Garden or anything in between, we can put the good of the team above all else, and
            inevitably that will result in success for each of us individually.</p>

        </p>
    </div>
</div>
@endsection