<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-home"></i></a></li>
                <li><a href="/admin">Admin</a></li>
                <li class="active">Notifications</li>
            </ol>
        </div>
    </div>

    <?php if ($success) : ?> 
    <div class="alert alert-info fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php foreach ($messages as $message) : ?> 
            <?= $message ?> 
        <?php endforeach ?>
    </div>
    <?php endif ?> 

    <div class="row">
        <div class="col-xs-12">
            <h1>Notifications</h1>
        </div>
    </div>

    <div class="clearfix">&nbsp;</div>

    <form role="form" action="" method="post">
        <input type="hidden" name="filter" value="">
        <input type="hidden" name="delete" value="">

         <div class="row">
            <div class="col-xs-6">
                <div class="btn-group">
                    <a href="/admin/notifications/new" class="btn btn-primary" role="button" title="New"><i class="fa fa-file-o"></i> New</a>
                    <a href="" class="btn btn-danger disabled" role="button" title="Delete" id="btn-delete"><i class="fa fa-trash-o"></i> Delete</a>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="input-group pull-right">
                    <input type="text" class="form-control" name="filter" placeholder="Filter by title or tag">
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="button"><i class="fa fa-search"></i> Search</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>

        <?php if (!$notifications) : ?> 

        <div class="row">
            <div class="col-lg-12">
                <p>No notifications found.</p>
            </div>
        </div>

        <?php else : ?> 

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="notifications" value="1" title="Select/deselect all"></th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Entity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notifications as $notification) : ?> 
                                <?php $notification = $notification->getValues() ?>
                            <tr>
                                <td><input type="checkbox" name="id[]" value="<?= $notification['id'] ?>"></td>
                                <td><a href="/admin/notifications/edit/<?= $notification['id'] ?>" title="Preview"><?= $notification['code'] ?></a></td>
                                <td><?= $notification['title'] ?></td>
                                <td><?= $notification['entity_model_id'] ?></td>
                            </tr>
                            <?php endforeach ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>

    <?php endif ?> 

</div>
