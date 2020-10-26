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
        <h1 style="margin-bottom: 1em">7 Strategies to Help You Stand Out From the Crowd</h1>
        <div class="img-wrap" style="float: left; padding-left: 0">
            <img class="xs-full"
                src="https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/Cohen-Dave-2017.jpg"
                alt="Allison Feaster" style="margin: 0em 2em 1em 0em; max-width:350px;">
        </div>
        <h3>Blogger: <span style="color: #212121">David Cohen – Director, Member Experience and Retention</span></h3>
        <h3>Celtics Tenure: <span style="color: #212121">14 years</span></h3>
        <p style="font-style: italic;">David began his career with the Celtics as an Inside Sales Representative
            in 2006. Over the next ten years, he
            advanced within the Sales department and ultimately became one of the top Premium Sales Account Executives
            before
            being promoted to his current role as Director of Member Experience and Retention. As Director, David
            manages a
            team
            of seven people and oversees the strategy and execution of retaining and providing memorable experiences for
            Celtics
            Season Ticket Members.</p>

        <p>For professional sports teams, the difference between winning and losing often comes down to a few inches or
            a
            few
            seconds. The most successful teams are more strategic, pay greater attention to detail in their preparation
            and
            are
            more flawless in their execution. You should apply the same approach as a business professional, whether you
            are
            trying to land your first role in the sports industry or advance your career.</p>

        <p>The business of sports is not only a competitive field to break into, but one that is equally as difficult to
            sustain
            career longevity in. To give you some context, I received between 300-500 resumes within the first week of
            posting
            an open position on Celtics.com. This begs the question – how does one get noticed in a crowd of 500
            applicants?
        </p>

        <p>Over my 14-year career with the Celtics, I have developed seven strategies that will help you stand out from
            the
            pack
            and ultimately give you the best chance in landing the role that’s right for you. These tactics helped me
            break
            into
            the industry, advance my career and have led me to hire some of the best young professionals in our
            organization.
            The purpose of this post is to share these seven strategies with you.</p>

        <p>Before we get started, please know that these are my own philosophies and not all hiring managers may agree
            with
            them. It is also important to remember that nothing I outline below will guarantee you an interview or
            offer.
            However, they are controllable techniques that will increase your odds.</p>

        <p><strong>1. Utilize LinkedIn as a networking and learning tool.</strong> To get the most out of this platform,
            it’s
            not enough to
            build a big network if you aren’t leveraging it. Focus on quality over quantity. You should strive to
            initiate
            relationships, engage in conversations and learn from your network. When connecting with others, include a
            note
            that explains who you are and be very specific about why you want them as part of your network. Most
            professionals in our industry are willing to answer questions or even set up an informational interview to
            pass
            along knowledge and learn more about you. When I’m on the receiving end of such solicitation, I view it as a
            win-win. It gives me an opportunity to build my network, learn best practices and identify prospective
            candidates for positions that may open down the road. </p>

        <p><strong>2. It’s not what you know or who you know…It’s who knows you.</strong> When there is an open position
            on
            my
            team, referrals
            carry more weight than anything. When someone that I trust recommends a candidate, I will always give that
            person an interview. Think about the competitive advantage this would give you against the other 500
            applicants.
            Start building your network today so that when an opportunity arises, someone is willing to recommend you.
        </p>

        <p><strong>3. Your cover letter has a greater impact than your resume.</strong> When I’m screening candidates,
            those
            who
            include an
            engaging cover letter always have an advantage. The cover letter gives you a platform to add character to
            your
            resume, sell yourself through storytelling and ultimately leaves me wanting to learn more about you. Follow
            these guidelines for creating an effective cover letter:</p>
        <ul>
            <li>Keep it short – no more than 3-4 paragraphs, with 2-3 sentences per paragraph. </li>
            <li>Communicate who you are, why you are applying for the position and why you are the best fit.</li>
            <li>Customize the letter and provide specific examples that are applicable to the position. A cookie-cutter
                template that can be reused for other positions is not engaging. </li>
            <li>Personalize the letter with the Hiring Manager’s name. </li>
            <li>Proofread for grammatical errors. </li>
        </ul>

        <p><strong>4. Keep your resume to one page and use bullet points.</strong> Keep it clean, concise and easy to
            scan
            through by using
            bullet points. Summarize your recent and relevant work, experiences and accomplishments on one page. Don’t
            overlook the small details such as making sure fonts, margins and formatting all align. Unless you’re
            applying
            for a creative role, I would advise against attempting to differentiate yourself with the use of colors,
            logos,
            pictures, etc.</p>

        <p><strong>5. Email your cover letter and resume directly to the Hiring Manager.</strong> With a little
            research,
            you
            can identify who
            within the organization you would report to. My advice is to email your cover letter and resume directly to
            this
            person. Keep your message short and friendly. Sure, there is a chance that you come off a little too
            assertive,
            or as someone who perhaps ignored the application instructions. But the reward far outweighs the risk here.
            Think about it – what gives you a better chance at catching the attention of the person who is hiring for
            the
            position: Emailing them your cover letter and resume directly, or submitting those through HR and being
            clumped
            in with the other 500 applicants? Emailing my application documents directly to the Hiring Manager helped me
            land my first job with the Celtics.</p>

        <p><strong>6. Bring a business plan to the interview.</strong> This will differentiate you from the masses. It
            shows
            that you have done
            your research/homework, you are motivated and you have a vision. It also allows you to control the narrative
            of
            the interview to some degree. Even if you are unable to walk through your entire business plan at the
            interview,
            it’s a tangible asset that you will leave behind as a constant reminder of who you are and what you stand
            for.
            Do not skimp on the presentation of this document and bring extra copies.</p>

        <p>Bonus: There are two additional basic concepts to give you a competitive advantage during the interview
            process
            that
            are worth mentioning.</p>
        <ul>
            <li>How you communicate is just as important as what you communicate. I won’t remember the
                specifics of everything
                you said in the interview. However, if you smile, communicate clearly and concisely, express passion,
                display
                positive body language and come across as personable, you will create a connection and I guarantee I
                will
                remember you.</li>

            <li>Dress to impress. This should go without saying, but prior to COVID-19, many candidates that I
                interviewed came
                dressed in business casual, which surprised me. Here is the way I look at it: Will overdressing put you
                at a
                disadvantage against the competition? Of course not. On the flip side, will dressing too casually put
                you at
                a
                disadvantage against the competition? Possibly. Why take this unnecessary risk and give the Hiring
                Manager a
                reason to second guess you? When in doubt, dress in business professional attire. If you’re still
                unsure,
                don’t
                be afraid to ask the Hiring Manager what the appropriate attire is for the interview.</li>
        </ul>
        <p><strong>7. After the interview, respect the decision-making process.</strong> Keep your follow-up efforts to
            a
            “thank you”
            email
            within 24 hours after the interview and a check-in based upon the next steps that were communicated to you.
            Anything more than that is too much and may work against you. Think of an overbearing waiter/waitress or
            salesperson. Instead of portraying these qualities, follow up in a concise manner and then respect the
            process
            that the employer outlined.</p>
    </div>
</div>
@endsection