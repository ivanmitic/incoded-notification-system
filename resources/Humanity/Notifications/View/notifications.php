<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-home"></i></a></li>
                <li class="active">Notifications</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h1>User Notifications</h1>
        </div>
    </div>

    <?php if (!$notifications) : ?> 

    <div class="row">
        <div class="col-lg-12">
            <p>No notifications so far.</p>
        </div>
    </div>

    <?php else : ?> 

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Content</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notifications as $notification) : ?> 
                            <?php $notification = $notification->getValues() ?>
                        <tr>
                            <td><a href="/admin/notifications/edit/<?= $notification['id'] ?>" title="Read"><?= $notification['body'] ?></a></td>
                            <td><?= $notification['created_at'] ?></td>
                        </tr>
                        <?php endforeach ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php endif ?> 
</div>
