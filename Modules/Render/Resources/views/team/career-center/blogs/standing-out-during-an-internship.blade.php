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

    h3 {
        margin-top: 1.75em !important;
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
        <h1 style="margin-bottom: 1em">Standing Out During an Internship</h1>
        <div class="img-wrap" style="float: left; padding-left: 0">
            <img class="xs-full"
                src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/Logan-Dickinson.jpg"
                alt="Logan Dickinson" style="margin: 0em 2em 1em 0em; max-width:350px;">
        </div>
        <h3>Blogger: <span style="color: #212121">Logan Dickinson - Senior Coordinator, Corporate Partnerships
                Activation</span></h3>

        <h3>Celtics Tenure: <span style="color: #212121">3 years</span></h3>


        <p style="font-style: italic;">Logan began her career with the Celtics as a Corporate Partnerships Activation
            Specialist in 2017. Before
            joining the Celtics, she worked for the Kansas City Chiefs, Atlanta Hawks and Washington Nationals. As a
            Senior
            Coordinator, Logan manages the accounts of several corporate partners and oversees the strategy and
            execution of
            all full arena giveaways and promotional products for the organization.</p>

        <p>Your resume stood out, you aced the interview and landed the internship, but now what? Before joining the
            Celtics, I was an intern for three different professional sports teams in three different leagues within one
            year. In addition to teaching me how to be an expert mover, these experiences taught me how to make the most
            of
            each opportunity as well as make a lasting impression!</p>

        <h3>Arrive prepared and continue to prep.</h3>
        <p>It is important to have background on the organization and your department before the first day. Do not be
            afraid to ask your manager if there is any specific information they would like you to review before you
            begin
            the internship. However, remember that the prep does not stop after your first day. Continue to prepare for
            each
            day of your internship. If you are invited to sit in on various meetings, do research on the relevant
            topics.
            Before joining a partner recap meeting, one of my department’s interns did their own research about how that
            partner was activating with other teams and took detailed notes during the meeting. They were able to share
            their findings and suggestions in a follow-up internal meeting and ultimately helped us develop a
            season-long
            social activation.</p>

        <h3>Do not be afraid to ask questions or ask for help.</h3>
        <p>During my first day at the Celtics, my manager sat me down and said “I want you to know that there is no such
            thing as a stupid question. I would rather you ask a question instead of falsely assuming and making a
            mistake.”
            That piece of advice is the first thing I tell any new interns that join my department each semester. Your
            department is there to help you learn. Additionally, do not be afraid to ask for help. Especially on
            gamedays,
            you will most likely be pulled in several different directions. It is impossible to be in two places at once
            –
            believe me, I have tried! Teamwork does make the dream work.</p>

        <h3>Attitude is everything.</h3>
        <p>Come to work every day ready to learn and ready to help. Over the course of your internship, there are going
            to
            be long days and nights between games and events. Interns that maintain a positive attitude and are ready to
            help always stand out to me regardless of their department. People will notice and appreciate your outlook.
        </p>

        <h3>Take initiative.</h3>
        <p>Notice something that could help your department be more efficient? Put together a plan and present it to
            your
            manager. One of my former interns created a plan to reorganize our supply closet to be more efficient for
            gameday packing and storage. The plan entailed a new layout as well as recommendations for storage
            containers.
            My department approved the project, and it did wonders for our group!</p>

        <h3>Take all of your tasks – no matter how small – seriously.</h3>
        <p>The beauty of working in sports is that every day is going to be different, which means your tasks are going
            to
            vary as well. Some days you might be asked to host a CEO of a partner, while other days you might be asked
            to
            mail out hundreds of packages or move boxes. It is important to take each task seriously and execute them to
            the
            best of your ability. Your department will notice if you take work seriously and do your work well. As a
            result,
            the smaller tasks will most likely lead to larger ones.</p>

        <h3>Connect with other employees outside of your internship department.</h3>
        <p>It is important to understand the different departments and roles behind any team. Network and meet with
            department heads and members of other departments to learn about the organization in full. It is a great way
            to
            expand your network, while learning more about the different departments within the organization.</p>

        <h3>Stay in touch after your internship ends.</h3>
        <p>One easy way to stay connected with those you meet during your internship is by adding them on LinkedIn.
            Additionally, I recommend writing a thank you note to those who influenced your experience. Gestures like
            this
            can make a lasting impression on the people around you. It shows you valued your time with them and
            everything
            you learned!</p>
    </div>
</div>
@endsection