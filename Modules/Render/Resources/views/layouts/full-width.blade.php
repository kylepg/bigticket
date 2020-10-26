<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- FAVICON -->
<link rel="icon" href="../dist/favicon.png">
<!-- JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- BOOTSTRAP CSS -->
<link type="text/css" rel="stylesheet"
    href="https://www.nba.com/celtics/sites/all/themes/etowah_radix/assets/stylesheets/bootstrap.css?pbz7wj"
    media="all" />
<!-- DRUPAL STYLES -->
<link type="text/css" rel="stylesheet"
    href="https://www.nba.com/celtics/sites/all/themes/etowah_radix/assets/stylesheets/screen.css?pbz7wj" media="all" />
<!-- DRUPAL STYLES -->
<link type="text/css" rel="stylesheet"
    href="https://www.nba.com/celtics/sites/celtics/files/css/css_T-TZfTydUwB664EEKJHDcuk7jy4tISCzGTq3m7vhy9Q.css"
    media="all" />
<!-- DRUPAL STYLES -->
<link type="text/css" rel="stylesheet"
    href="https://www.nba.com/celtics/sites/celtics/files/css/css_sP6_eilAByeIvznnqxyAfo81Te1JzfT0YYU8toRUYIo.css"
    media="print" />
<!-- DRUPAL STYLES -->
<link type="text/css" rel="stylesheet"
    href="https://www.nba.com/celtics/sites/all/themes/etowah_radix/assets/stylesheets/screen.css?pbz7wj" media="all" />
<!-- JS SITEWIDE OVERRIDES -->
<script type="text/javascript"
    src="https://www.nba.com/celtics/sites/celtics/files/sitewide_overrides/active/etowah_swo_98743/header_sitewide_overrides.js?pelmf9">
</script>
<!-- CSS SITEWIDE OVERRIDES -->
<link type="text/css" rel="stylesheet"
    href="https://www.nba.com/resources/static/team/v2/celtics/dev/overrides/overrides.css" media="all" />
<!-- BOOTSTRAP 3 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- TYPEKIT FONTS -->
<link rel="stylesheet" href="https://use.typekit.net/gby5gmb.css">
<!-- Project CSS -->
<style>
    .moscone-flipped-content {
        float: left;
    }

    h1 {
        font-size: 2em;
    }

    h2 {
        font-size: 1.5em;
    }

    h4 {
        font-size: 1em;
    }

    h3 {
        font-size: 1.25em;
    }

    h1,
    h2,
    h3,
    h4,
    h5 {
        font-family: "futura-pt", Helvetica, Arial, sans-serif;
        font-weight: bold;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
        color: #008348;
    }

    a {
        color: #008348;
    }

    .global-nav-wrapper,
    #new-navbar {
        position: fixed !important;
        z-index: 100000;
    }

    #main {
        margin-top: 64px !important;
        border: none;
    }
</style>

<body class="html not-front not-logged-in no-sidebars page-node page-node- node-type-page region-content"
    style="width: auto; position: relative; top: auto;">
    <header class="header" role="header">
        <nav class="global-nav-wrapper">
        </nav>
    </header>
    <main id="main" class="main">
        <div id="page" class="page">
            <div class="container"></div>
            <div class="page-header-ad">
                <div class="container"></div>
            </div>
            <div tabindex="0" id="content">
                <div id="page-header"></div>
                <div class="region region-content">
                    <div id="block-system-main" class="block block-system">
                        <div class="content">
                            <div class="panel-flexible panels-flexible-37064 clearfix">
                                <div class="panel-flexible-inside panels-flexible-37064-inside">
                                    <div
                                        class="panels-flexible-region panels-flexible-region-37064-center panels-flexible-region-first panels-flexible-region-last">
                                        <div
                                            class="inside panels-flexible-region-inside panels-flexible-region-37064-center-inside panels-flexible-region-inside-first panels-flexible-region-inside-last">
                                            <div class="panel-pane pane-entity-field pane-node-body">
                                                <div class="pane-content">
                                                    <div
                                                        class="field field-name-body field-type-text-with-summary field-label-hidden">
                                                        @yield('content')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>