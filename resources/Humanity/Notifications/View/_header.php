<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-ellipsis-v"></i>
            </button>
            <a class="navbar-brand" href="/">Notification System</a>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="nav nav-pills pull-right">
                <li<?php echo $action == 'index' ? ' class="active"' : '' ?>><a href="/" title="Home"><i class="fa fa-home"></i></a></li>
            <?php if ($is_auth) : ?> 
                <li<?php echo $action == 'notifications' ? ' class="active"' : '' ?>><a href="/notifications"><i class="fa fa-bell" title="Notifications"></i></a></li>
            <?php endif ?> 
            <?php if ($user_type == 'admin') : ?> 
                <li<?php echo (strpos($action, 'admin') !== false) ? ' class="active"' : '' ?>><a href="/admin/notifications" title="Admin"><i class="fa fa-cog"></i></a></li>
            <?php endif ?> 
            <?php if ($is_auth) : ?> 
                <li<?php echo $action == 'settings' ? ' class="active"' : '' ?>><a href="/settings"><i class="fa fa-user" title="Settings"></i></a></li>
                <li><a href="/logout" title="Logout"><i class="fa fa-unlock"></i></a></li>
            <?php else : ?> 
                <li<?php echo $action == 'login' ? ' class="active"' : '' ?>><a href="/login" title="Login"><i class="fa fa-lock"></i></a></li>
            <?php endif ?> 
            </ul>
        </div>
    </div>
</nav>
