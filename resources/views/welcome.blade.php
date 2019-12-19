<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>XCS-Int</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .version {
                padding-top: 30px;
                font-size: 11px;
                color: #636b6f;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    XCS-INT Framework
                </div>

                <div class="links">
                    By Oliver G.
                </div>

                <br>
                <br>

                <div class="links">
                    Release Monitor
                </div>

                <div class="content">
                    <p>CHAIN OF COMMAND TESTING RELEASE</p>
                    <div class="progress">
                      <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width:13%">13%</div>
                    </div><br>
                </div>

                <div class="content">
                    How many times I have restarted work on the framework from the base: <b>3</b><br>
                    How many times I made something only to realise that a library exists that does the exact same thing: <b>52</b>
                    <br>

                    <div class="version"><b>{{ $constants['global']['application_version'] }}</b></div>
                    <br>

                    <p>ACCOUNTS - Authentication, Account Creation and Handling</p>
                    <div class="progress">
                      <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width:83%">83%</div>
                    </div><br>

                    <p>ACTIVITY - Patrol Logging, Displaying and Validating</p>
                    <div class="progress">
                      <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width:0%">0%</div>
                    </div><br>

                    <p>PROFILES - Personal Profiles, Account Settings and Account Validation</p>
                    <div class="progress">
                      <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width:10%">10%</div>
                    </div><br>

                    <p>DISCIPLINARY ACTIONS - Issuing DA and Displaying DA</p>
                    <div class="progress">
                      <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width:0%">0%</div>
                    </div>

                </div>

            </div>
        </div>
    </body>
</html>
