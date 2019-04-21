<section class="topbar">
    <div class="container">
        <div class="row">
            <p><i class="fa fa-phone"></i> 88 01851334234 || Email : <i class="fa fa-envelope"></i>
                info@w3xplorers.com</p>
        </div>
    </div>
</section>
<section class="logo_bar">
    <div class="container">
        <div class="row">
            <!-- logo -->
            <a href="{{ URL :: to('/') }}" class="site-logo"><img src="{{ asset($app_settings->logo) }}" alt=""
                                                                  width="320px"></a>
            <div class="header-info">
                <div class="hf-item">
                    <i class="fa fa-clock-o"></i>
                    <p><span>Working Days:</span>Saturday - Thursday: 08 AM - 4.00 PM</p>
                </div>
                <div class="hf-item">
                    <i class="fa fa-map-marker"></i>
                    <p><span>Location :</span>{{$app_settings->address}}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<nav class="nav-section">
    <div class="container">
        <div class="row">
            <div id='cssmenu'>
                <ul>
                    <li class='active'><a href='{{ URL :: to('/') }}'><span>Home</span></a></li>
                    <li class='has-sub'><a href='#'><span>About</span></a>
                        <ul>
                            <li><a href='{{ URL :: to('/ourHistory') }}'><span>Our History</span></a></li>
                            <li><a href='{{ URL :: to('/chairmanMessage') }}'><span>Chairman Message</span></a></li>
                            <li><a href='{{ URL :: to('/principalMessage') }}'><span>Principal Message</span></a></li>
                            <li><a href='#'><span>Management Committee</span></a></li>
                            <li><a href='#'><span>Mission & Vision</span></a></li>
                            <li><a href="#">Achievements</a></li>
                            <li><a href="#">Publication</a></li>
                        </ul>
                    </li>
                    <li class='has-sub'><a href="#">Academic</a>
                        <ul>
                            <li><a href="{{ URL :: to('/students') }}">Students</a></li>
                            <li><a href="{{ URL :: to('/teachers') }}">Teachers</a></li>
                            <li><a href="{{ URL :: to('/classRoutine') }}">Class Routine</a></li>
                            <li><a href="{{ URL :: to('/classSyllabus') }}">Syllabus</a></li>
                            <li><a href="{{ URL :: to('/academicCalender') }}">Academic Calendar</a></li>
                            <li><a href="{{ URL :: to('/academicEvents') }}">Events Calendar</a></li>
                            <li><a href="{{ URL :: to('/academicNotices') }}"> All Notices</a></li>
                            <li><a href="{{ URL :: to('/academicNews') }}"> All Latest News</a></li>
                            <li><a href="{{ URL :: to('/rulesRegulation') }}">Rules & Regulation</a></li>
                        </ul>
                    </li>

                    <li><a href="#">Result</a></li>
                    <li class='has-sub'><a href="#">Admission</a>
                        <ul>
                            <li><a href="{{ URL :: to('/eligibility') }}">Eligibility</a></li>
                            <li><a href="#">Dress Code</a></li>
                            <li><a href="#">How to apply</a></li>
                            <li><a href="#">Admission Form</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ URL :: to('/downloads') }}">Downloads</a></li>
                    <li><a href="{{ URL :: to('/gallery') }}">Gallery</a></li>
                    <li class='has-sub'><a href="#">Careers</a>
                        <ul>
                            <li><a href="{{ URL :: to('/jobCircular') }}">Job Circular</a></li>
                            <li><a href="{{ URL :: to('/submitResume') }}">Submit Resume</a></li>
                        </ul>
                    </li>
                    <li class='last'><a href='{{ URL :: to('/contact') }}'><span>Contact</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- Header section end -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#cssmenu ul li').each(function () {
            if (window.location.href.indexOf($(this).find('a:first').attr('href')) > -1) {
                $(this).addClass('active').siblings().removeClass('active');
            }
        });
        $('.has-sub ul li').each(function () {
            if (window.location.href.indexOf($(this).find('a:first').attr('href')) > -1) {
                $('#cssmenu ul li').removeClass('active');
                $(this).closest('ul').closest('li').addClass('active');
                $(this).addClass('active').siblings().removeClass('active');
            }
        });
    });
</script>

