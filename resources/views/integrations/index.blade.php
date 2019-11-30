<html lang="en" class="wf-poppins-n3-active wf-poppins-n4-active wf-roboto-n5-active wf-roboto-n4-active wf-roboto-n6-active wf-roboto-n7-active wf-poppins-n5-active wf-poppins-n7-active wf-roboto-n3-active wf-poppins-n6-active wf-active"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CloudComCRM</title>
    <!-- Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto:300,400,500,600,700" media="all">
    <script>
        WebFont.load({
            google:{ 
                "families": ["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- <link rel="stylesheet" href="https://keenthemes.com/metronic/preview/demo1/custom/apps/user/assets/css/demo1/pages/general/wizard/wizard-4.css"> -->

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed">
    
    <div id="app" class="gq-wrapper">
        <div class="kt-grid kt-grid--ver kt-grid--root">
            <div id="kt_login" class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin">
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url('{{ asset('images/auth-bg.jpg') }}');">
                    <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                        <div class="kt-login__container">
                            <div class="kt-login__logo">
                                <a href="#">
                                    <img src="{{ asset('images/logocrm-white.png') }}" class="img-fluid">
                                </a>
                            </div>
                            <div class="kt-login__signin">
                                <div class="kt-login__head"><h3 class="kt-login__title">Select user to link</h3></div>
                                <form autocomplete="off" class="kt-form">
                                    <input id="provider" type="hidden" name="provider" value="{{ $provider }}">
                                    <input id="data" type="hidden" name="data" value="{{ $data }}">
                                    <div class="input-group">
                                        <select class="form-control kt-selectpicker" name="user" required>
                                            <option value="" selected disabled>Select your account</option>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="kt-login__actions">
                                        <button id="kt_login_signin_submit" type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">
                                            Confirm
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- APP JS -->
    <script src="{{ asset('vendors/general/jquery/dist/jquery.js') }}"></script>
    <script>
        $(function() {
            $('.kt-form').on('submit', function(e) {
                e.preventDefault()

                $('#kt_login_signin_submit')
                    .addClass('kt-spinner kt-spinner--light kt-spinner--right')
                    .attr('disabled', 'disabled')

                const provider = $('#provider').val()
                const url = '/api/auth/oauth/' + provider + '/save'

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize()
                }).done(function(response) {
                    window.close();
                }).fail(function(error) {
                    console.log(error)
                })

                return false
            })
        })
    </script>
</body>
</html>