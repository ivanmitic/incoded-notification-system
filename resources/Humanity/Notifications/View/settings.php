<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-home"></i></a></li>
                <li class="active">Settings</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h1>Settings</h1>
        </div>
    </div>

    <div class="clearfix">&nbsp;</div>

    <form role="form" action="/settings" method="post">
        <div class="row">
            <div class="col-sm-6">
                <fieldset>
                    <legend>Notifications</legend>
                    <p>Choose notifications and ways of how you want to recieve them:</p>

                    <?php foreach ($notifications as $notification_id => $notification) : ?> 
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="notification[<?= $notification_id ?>]" value="<?= $notification_id ?>">
                            <?= $notification['code'] ?>
                        </label>
                    </div>
                    <p>Services:</p>
                    <?php foreach ($notification['services'] as $service_id => $service) : ?> 
                    <label class="checkbox-inline">
                        <input type="checkbox" name="service[<?= $notification_id ?>][<?= $service_id ?>]" value="<?= $service_id ?>">
                        <?= $service ?>
                    </label>
                    <?php endforeach ?> 
                    <?php endforeach ?> 
                    <hr>
                </fieldset>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn btn-default" href="/notifications">Back</a>
            </div>
        </div>
    </form>
</div>
