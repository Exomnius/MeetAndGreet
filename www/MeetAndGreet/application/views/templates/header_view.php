<!DOCTYPE html>
<!--http://thefinishedbox.com/freebies/scripts/jquery-animated-search/-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Meet and Greet</title>
        {css}
        <link href="{url}" rel="stylesheet" media="screen" />
        {/css}

        <link rel="icon" href="{favicon}" type="image/gif">
        <script src="{js}"></script>
    </head> 
    <body>
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#" id="messages"><img src="/assets/images/messages.png" alt=""></a>
                    <!-- <a class="navbar-brand" href="{main}">Meet And Greet</a> -->
                    <a class="navbar-brand" class="logo" href="/"><img src="/assets/images/logo.png" alt=""></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <!--<li id="members"><a href="{members}">Leden</a></li>-->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="register"><a href="{profile}">{profilet}</a></li>
                        <li id="login"><a href="{login}">{logint}</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        {message_modal}