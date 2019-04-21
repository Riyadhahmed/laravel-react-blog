<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="{{ URL :: to('/admin/dashboard') }}">
                <i class="fa fa-home"></i> <span>Dashboard</span>
            </a>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-universal-access"></i>
                <span>Access Management </span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ URL :: to('/admin/users') }}">
                        <i class="fa fa-users"></i> <span>Operators</span></a>
                </li>
                <li><a href="{{ URL :: to('/admin/permissions') }}">
                        <i class="fa fa-book"></i> <span>Permissions</span></a>
                </li>
                <li><a href="{{ URL :: to('/admin/roles') }}"><i
                            class="fa fa-bookmark"></i> Roles </a>
                </li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-university"></i>
                <span>Frontend </span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ URL :: to('/admin/news') }}">
                        <i class="fa fa-globe"></i> <span> Notice Board & News</span></a>
                </li>
            </ul>
        </li>
        <li class="treeview">
            <a href="{{ URL :: to('/admin/settings') }}">
                <i class="fa fa-cogs"></i> <span>Settings</span>
            </a>
        </li>
        <li class="treeview">
            <a href="{{ URL :: to('/admin/backups') }}">
                <i class="fa fa-cloud-download"></i> <span>Backup</span>
            </a>
        </li>
    </ul>
</section>

<!-- /.sidebar -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.sidebar ul li').each(function () {
            if (window.location.href.indexOf($(this).find('a:first').attr('href')) > -1) {
                $(this).closest('ul').closest('li').attr('class', 'active');
                $(this).addClass('active').siblings().removeClass('active');
            }
        });
    });
</script>